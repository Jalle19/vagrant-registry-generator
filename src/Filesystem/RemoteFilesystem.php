<?php

namespace Jalle19\VagrantRegistryGenerator\Filesystem;

/**
 * Class RemoteFilesystem
 * @package Jalle19\VagrantRegistryGenerator\Filesystem
 */
abstract class RemoteFilesystem extends Filesystem
{

    /**
     * @param string $path
     *
     * @return string
     */
    abstract public function getUrl($path);

}
