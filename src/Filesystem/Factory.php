<?php

namespace Jalle19\VagrantRegistryGenerator\Filesystem;

use Jalle19\VagrantRegistryGenerator\Configuration\Configuration;
use Jalle19\VagrantRegistryGenerator\Configuration\Parser as ConfigurationParser;
use Jalle19\VagrantRegistryGenerator\Exception\InvalidConfigurationException;

/**
 * Class Factory
 * @package Jalle19\VagrantRegistryGenerator\Filesystem
 */
class Factory
{

    /**
     * @param string        $path
     * @param Configuration $configuration
     *
     * @return Filesystem
     * @throws InvalidConfigurationException
     */
    public static function makeFilesystem($path, Configuration $configuration)
    {
        switch (Configuration::getFilesystemType($path)) {
            case Configuration::FILESYSTEM_TYPE_S3:
                list($bucket, $prefix) = ConfigurationParser::parseBucketPrefix($path);

                return new S3Filesystem($configuration, $bucket, $prefix);
            case Configuration::FILESYSTEM_TYPE_LOCAL:
                return new LocalFilesystem($configuration);
            default:
                throw new InvalidConfigurationException('Invalid filesystem path specified, no matching reader could be created');
        }
    }

}
