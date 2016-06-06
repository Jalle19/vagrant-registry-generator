<?php

namespace Jalle19\VagrantRegistryGenerator\Filesystem;

use Jalle19\VagrantRegistryGenerator\Configuration\Configuration;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem as Flysystem;

/**
 * Class LocalFilesystem
 * @package Jalle19\VagrantRegistryGenerator\Filesystem
 */
class LocalFilesystem extends Filesystem
{

    /**
     * @inheritdoc
     */
    public function __construct(Configuration $configuration)
    {
        parent::__construct($configuration);

        $this->filesystem = new Flysystem(new Local($this->configuration->getOutputPath()));
    }

}
