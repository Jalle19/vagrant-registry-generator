<?php

namespace Jalle19\VagrantRegistryGenerator\Configuration;

use Symfony\Component\Console\Input\InputInterface;

/**
 * Class Parser
 * @package Jalle19\VagrantRegistryGenerator\Configuration
 */
class Parser
{

    /**
     * @param InputInterface $input
     *
     * @return Configuration
     */
    public static function parseConfiguration(InputInterface $input)
    {
        $configuration = new Configuration();
        $outputPath    = $input->getArgument('outputPath');

        $configuration
            ->setRegistryPath($input->getArgument('registryPath'))
            ->setOutputPath($outputPath)
            ->setAwsAccessKey($input->getOption('awsAccessKey'))
            ->setAwsSecretKey($input->getOption('awsSecretKey'))
            ->setAwsRegion($input->getOption('awsRegion'));

        if (Configuration::getFilesystemType($outputPath) === Configuration::FILESYSTEM_TYPE_LOCAL) {
            // Convert to absolute path
            if (substr($outputPath, 0, 1) !== '/') {
                $configuration->setOutputPath(getcwd() . '/' . $outputPath);
            }
        }

        return $configuration;
    }


    /**
     * @param string $path
     *
     * @return array
     */
    public static function parseBucketPrefix($path)
    {
        $url = parse_url($path);

        $bucket = $url['host'];
        $prefix = trim($url['path'], '/');

        return [$bucket, $prefix];
    }

}
