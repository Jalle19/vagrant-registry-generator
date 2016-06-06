<?php

namespace Jalle19\VagrantRegistryGenerator\Registry;

use Jalle19\VagrantRegistryGenerator\Configuration\Configuration;
use Jalle19\VagrantRegistryGenerator\Filesystem\Filesystem;
use League\Plates\Engine as TemplateEngine;

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
     * @var Filesystem
     */
    private $filesystem;


    /**
     * AbstractWriter constructor.
     *
     * @param Configuration $configuration
     * @param Filesystem    $filesystem
     */
    public function __construct(Configuration $configuration, Filesystem $filesystem)
    {
        $this->configuration = $configuration;
        $this->filesystem    = $filesystem;

        $this->templatePath = realpath(__DIR__ . '/../../templates');
        $this->templates    = new TemplateEngine($this->templatePath);
    }


    /**
     * @param Registry $registry
     */
    public function write(Registry $registry)
    {
        $filesystem = $this->filesystem->getFilesystem();
        $manifests  = $registry->getManifests();

        $filesystem->put('index.html', $this->templates->render('registry', [
            'manifests' => $manifests,
        ]));

        $filesystem->put('styles.css', file_get_contents($this->templatePath . '/styles.css'));

        foreach ($manifests as $manifest) {
            $filePath      = 'manifests/' . $manifest->getName();
            $directoryName = dirname($filePath);

            $filesystem->put($directoryName . '/styles.css',
                file_get_contents($this->templatePath . '/styles.css'));

            $filesystem->put($filePath . '.html', $this->templates->render('manifest', [
                'manifest' => $manifest,
            ]));
        }
    }

}
