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

        $configuration
            ->setRegistryPath($input->getArgument('registryPath'))
            ->setOutputPath(self::parseOutputPath($input))
            ->setTemplatePath(__DIR__ . '/../../templates')
            ->setAwsRegion($input->getOption('awsRegion'));

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
        $prefix = '';

        // Prefix is optional
        if (isset($url['path'])) {
            $prefix = trim($url['path'], '/');
        }

        return [$bucket, $prefix];
    }


    /**
     * Parses the output path argument, ensuring that local paths are absolute
     *
     * @param InputInterface $input
     *
     * @return string
     */
    private static function parseOutputPath(InputInterface $input)
    {
        $outputPath = $input->getArgument('outputPath');

        if (Configuration::getFilesystemType($outputPath) === Configuration::FILESYSTEM_TYPE_LOCAL &&
            substr($outputPath, 0, 1) !== '/'
        ) {
            $outputPath = getcwd() . '/' . $outputPath;
        }

        return $outputPath;
    }

}
