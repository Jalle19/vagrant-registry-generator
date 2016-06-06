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
     * @var string
     */
    private $templatePath;

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

        // The path is relative to the generated PHAR file
        $this->templatePath = './templates';
        $this->templates    = new TemplateEngine($this->templatePath);
    }


    /**
     * @param Registry $registry
     */
    public function write(Registry $registry)
    {
        $manifests = $registry->getManifests();

        $this->logger->notice('Writing registry containing {count} manifests', ['count' => count($manifests)]);
        $this->writeIndex($manifests);

        foreach ($manifests as $manifest) {
            $this->logger->info('Writing manifest {manifest} to registry', ['manifest' => $manifest->getName()]);
            $this->writeManifest($manifest);
        }
    }


    /**
     * @param array $manifests
     */
    private function writeIndex(array $manifests)
    {
        $filesystem = $this->filesystem->getFilesystem();

        $filesystem->put('index.html', $this->templates->render('registry', [
            'manifests' => $manifests,
        ]));

        $filesystem->put('styles.css', file_get_contents($this->templatePath . '/styles.css'));
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
            file_get_contents($this->templatePath . '/styles.css'));

        $filesystem->put($filePath . '.html', $this->templates->render('manifest', [
            'manifest' => $manifest,
        ]));
    }

}
