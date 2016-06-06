<?php

namespace Jalle19\VagrantRegistryGenerator\Registry;

use Jalle19\VagrantRegistryGenerator\Configuration\Configuration;
use Jalle19\VagrantRegistryGenerator\Exception\InvalidConfigurationException;
use Jalle19\VagrantRegistryGenerator\Exception\RegistryReadFailedException;
use Jalle19\VagrantRegistryGenerator\Filesystem\Filesystem;
use Jalle19\VagrantRegistryGenerator\Filesystem\RemoteFilesystem;
use Jalle19\VagrantRegistryGenerator\Registry\Manifest\FileMetadata;
use Jalle19\VagrantRegistryGenerator\Registry\Manifest\Manifest;
use Jalle19\VagrantRegistryGenerator\Registry\Manifest\Parser as ManifestParser;
use Jalle19\VagrantRegistryGenerator\Registry\Manifest\Version;
use Psr\Log\LoggerInterface;

/**
 * Class Reader
 * @package Jalle19\VagrantRegistryGenerator\Registry
 */
class Reader
{

    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var RemoteFilesystem
     */
    private $filesystem;


    /**
     * Reader constructor.
     *
     * @param Configuration   $configuration
     * @param LoggerInterface $logger
     * @param Filesystem      $filesystem
     *
     * @throws InvalidConfigurationException
     */
    public function __construct(Configuration $configuration, LoggerInterface $logger, Filesystem $filesystem)
    {
        // The reader can only work with remote filesystems
        if (!($filesystem instanceof RemoteFilesystem)) {
            throw new InvalidConfigurationException('The registry reader can only operate on remote filesystems');
        }

        $this->configuration = $configuration;
        $this->logger        = $logger;
        $this->filesystem    = $filesystem;
    }


    /**
     * @return Registry
     *
     * @throws RegistryReadFailedException
     */
    public function readRegistry()
    {
        $this->logger->notice('Fetching manifest files');
        $manifests = $this->parseManifests();

        $this->logger->notice('Attempting to fetch additional file metadata for each box');

        foreach ($manifests as $manifest) {
            foreach ($manifest->getVersions() as $version) {
                foreach ($version->getProviders() as $provider) {
                    $fileMetadata = $this->parseProviderFileMetadata($manifest, $version);

                    if ($fileMetadata !== null) {
                        $provider->setFileMetadata($fileMetadata);
                    }
                }
            }
        }

        return new Registry($manifests);
    }


    /**
     * @return Manifest[]
     * @throws RegistryReadFailedException
     */
    private function parseManifests()
    {
        $filesystem    = $this->filesystem->getFilesystem();
        $manifests     = [];
        $organizations = $filesystem->listContents('json');

        foreach ($organizations as $organization) {
            $manifestFiles = $filesystem->listContents($organization['path']);

            if (count($manifestFiles) === 1) {
                $manifestFile = $manifestFiles[0];
                $manifestJson = $filesystem->read($manifestFile['path']);
                $manifestUrl  = $this->filesystem->getUrl($manifestFile['path']);

                if ($manifestJson === false) {
                    throw new RegistryReadFailedException('Failed to read manifest file "' . $manifestFile['path'] . '"');
                }

                $this->logger->info('Parsing manifest file at {path}', ['path' => $manifestFile['path']]);
                $manifests[] = ManifestParser::parseManifest($manifestJson, $manifestUrl);
            }
        }

        return $manifests;
    }


    /**
     * @param Manifest $manifest
     * @param Version  $version
     *
     * @return FileMetadata|null
     * @throws RegistryReadFailedException
     */
    private function parseProviderFileMetadata(Manifest $manifest, Version $version)
    {
        $filesystem = $this->filesystem->getFilesystem();

        // Get the contents of the corresponding box directory
        $boxContents = $filesystem->listContents('boxes/' . $manifest->getName() . '/' . $version->getVersion());

        if (count($boxContents) === 1) {
            $boxFile   = $boxContents[0];
            $timestamp = \DateTime::createFromFormat('U', $boxFile['timestamp']);
            $this->logger->info('Fetching metadata for box at {path}', ['path' => $boxFile['path']]);

            if ($timestamp === false) {
                throw new RegistryReadFailedException('Failed to parse timestamp for box file "' . $boxFile['path'] . '"');
            }

            return new FileMetadata($boxFile['basename'], $timestamp, $boxFile['size']);
        }

        return null;
    }

}
