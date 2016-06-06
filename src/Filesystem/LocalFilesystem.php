<?php

namespace Jalle19\VagrantRegistryGenerator\Filesystem;

use Jalle19\VagrantRegistryGenerator\Configuration\Configuration;
use League\Flysystem\Adapter\Local;

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

        $this->filesystem = new \League\Flysystem\Filesystem(new Local($this->configuration->getOutputPath()));
    }

}
