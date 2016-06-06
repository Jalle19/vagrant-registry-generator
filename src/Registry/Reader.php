<?php

namespace Jalle19\VagrantRegistryGenerator\Registry;

use Jalle19\VagrantRegistryGenerator\Configuration\Configuration;
use Jalle19\VagrantRegistryGenerator\Exception\InvalidConfigurationException;
use Jalle19\VagrantRegistryGenerator\Filesystem\Filesystem;
use Jalle19\VagrantRegistryGenerator\Filesystem\RemoteFilesystem;
use Jalle19\VagrantRegistryGenerator\Registry\Manifest\FileMetadata;
use Jalle19\VagrantRegistryGenerator\Registry\Manifest\Parser as ManifestParser;

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
     * @var Filesystem
     */
    private $filesystem;


    /**
     * Reader constructor.
     *
     * @param Configuration $configuration
     * @param Filesystem    $filesystem
     */
    public function __construct(Configuration $configuration, Filesystem $filesystem)
    {
        // The reader can only work with remote filesystems
        if (!($filesystem instanceof RemoteFilesystem)) {
            throw new InvalidConfigurationException('The registry reader can only operate on remote filesystems');
        }

        $this->configuration = $configuration;
        $this->filesystem    = $filesystem;
    }


    /**
     *
     */
    public function readRegistry()
    {
        $filesystem = $this->filesystem->getFilesystem();

        // Find all manifest files
        $manifests     = [];
        $organizations = $filesystem->listContents('json');

        foreach ($organizations as $organization) {
            $manifestFiles = $filesystem->listContents($organization['path']);

            if (count($manifestFiles) === 1) {
                $manifestFile = $manifestFiles[0];
                $manifestJson = $filesystem->read($manifestFile['path']);
                $manifestUrl  = $this->filesystem->getUrl($manifestFile['path']);

                $manifests[] = ManifestParser::parseManifest($manifestJson, $manifestUrl);
            }
        }

        $registry = new Registry($manifests);

        // Read additional information about the box
        foreach ($registry->getManifests() as $manifest) {
            foreach ($manifest->getVersions() as $version) {
                foreach ($version->getProviders() as $provider) {
                    // Get the contents of the corresponding box directory
                    $boxContents = $filesystem->listContents('boxes/' . $manifest->getName() . '/' . $version->getVersion());

                    if (count($boxContents) === 1) {
                        $boxFile = $boxContents[0];

                        $provider->setFileMetadata(new FileMetadata(
                            $boxFile['basename'],
                            \DateTime::createFromFormat('U', $boxFile['timestamp']),
                            $boxFile['size']));
                    }
                }
            }
        }

        return $registry;
    }

}
