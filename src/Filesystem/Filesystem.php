<?php

namespace Jalle19\VagrantRegistryGenerator\Filesystem;

use Jalle19\VagrantRegistryGenerator\Configuration\Configuration;

/**
 * Class Filesystem
 * @package Jalle19\VagrantRegistryGenerator\Filesystem
 */
abstract class Filesystem
{

    /**
     * @var \League\Flysystem\Filesystem
     */
    protected $filesystem;

    /**
     * @var Configuration
     */
    protected $configuration;


    /**
     * Filesystem constructor.
     *
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }


    /**
     * @return \League\Flysystem\Filesystem
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }

}
