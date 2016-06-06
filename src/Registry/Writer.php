<?php

namespace Jalle19\VagrantRegistryGenerator\Registry;

use Jalle19\VagrantRegistryGenerator\Configuration\Configuration;
use Jalle19\VagrantRegistryGenerator\Filesystem\Filesystem;
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
        $filesystem = $this->filesystem->getFilesystem();
        $manifests  = $registry->getManifests();

        $this->logger->notice('Writing registry containing {count} manifests', ['count' => count($manifests)]);

        $filesystem->put('index.html', $this->templates->render('registry', [
            'manifests' => $manifests,
        ]));

        $filesystem->put('styles.css', file_get_contents($this->templatePath . '/styles.css'));

        foreach ($manifests as $manifest) {
            $filePath      = 'manifests/' . $manifest->getName();
            $directoryName = dirname($filePath);

            $this->logger->info('Writing manifest {manifest} to registry', ['manifest' => $manifest->getName()]);

            $filesystem->put($directoryName . '/styles.css',
                file_get_contents($this->templatePath . '/styles.css'));

            $filesystem->put($filePath . '.html', $this->templates->render('manifest', [
                'manifest' => $manifest,
            ]));
        }
    }

}
