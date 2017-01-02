<?php

namespace Jalle19\VagrantRegistryGenerator\Registry;

use Jalle19\VagrantRegistryGenerator\Configuration\Configuration;
use Jalle19\VagrantRegistryGenerator\Filesystem\Filesystem;
use Jalle19\VagrantRegistryGenerator\Registry\Manifest\Manifest;
use League\Plates\Engine as TemplateEngine;
use Psr\Log\LoggerInterface;

/**
 * Class tWriter
 * @package Jalle19\VagrantRegistryGenerator\Registry
 */
class Writer
{

    /**
     * @var TemplateEngine
     */
    private $templates;

    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var Filesystem
     */
    private $filesystem;


    /**
     * AbstractWriter constructor.
     *
     * @param Configuration   $configuration
     * @param LoggerInterface $logger
     * @param Filesystem      $filesystem
     */
    public function __construct(Configuration $configuration, LoggerInterface $logger, Filesystem $filesystem)
    {
        $this->configuration = $configuration;
        $this->logger        = $logger;
        $this->filesystem    = $filesystem;

        $this->templates = new TemplateEngine($this->configuration->getTemplatePath());
    }


    /**
     * @param Registry $registry
     */
    public function write(Registry $registry)
    {
        $manifests     = $registry->getManifests();
        $organizations = $registry->getOrganizations();

        $this->logger->notice('Writing registry containing {manifestCount} manifest(s) from {organizationCount} organization(s)',
            [
                'manifestCount'     => count($manifests),
                'organizationCount' => count($organizations),
            ]);

        $this->writeRegistry($registry);

        foreach ($organizations as $organization) {
            $this->logger->info('Writing organization {organization} to registry', ['organization' => $organization]);
            $this->writeOrganization($organization, $registry->getManifestsByOrganization($organization));
        }

        foreach ($manifests as $manifest) {
            $this->logger->info('Writing manifest {manifest} to registry', ['manifest' => $manifest->getName()]);
            $this->writeManifest($manifest);
        }
    }


    /**
     * @param Registry $registry
     */
    private function writeRegistry(Registry $registry)
    {
        $filesystem = $this->filesystem->getFilesystem();

        $filesystem->put('index.html', $this->templates->render('registry', [
            'manifests'     => $registry->getManifests(),
            'organizations' => $registry->getOrganizations(),
        ]));

        $filesystem->put('styles.css', file_get_contents($this->configuration->getTemplatePath() . '/styles.css'));
    }


    /**
     * @param Manifest $manifest
     */
    private function writeManifest(Manifest $manifest)
    {
        $filesystem = $this->filesystem->getFilesystem();

        $filePath      = 'manifests/' . $manifest->getName();
        $directoryName = dirname($filePath);

        $filesystem->put($directoryName . '/styles.css',
            file_get_contents($this->configuration->getTemplatePath() . '/styles.css'));

        $filesystem->put($filePath . '.html', $this->templates->render('manifest', [
            'manifest' => $manifest,
        ]));
    }


    /**
     * @param string     $organization
     * @param Manifest[] $manifests
     */
    private function writeOrganization($organization, array $manifests)
    {
        $filesystem = $this->filesystem->getFilesystem();

        $filePath      = 'organizations/' . $organization;
        $directoryName = dirname($filePath);

        $filesystem->put($directoryName . '/styles.css',
            file_get_contents($this->configuration->getTemplatePath() . '/styles.css'));

        $filesystem->put($filePath . '.html', $this->templates->render('organization', [
            'organization' => $organization,
            'manifests'    => $manifests,
        ]));
    }

}
