<?php

namespace Jalle19\VagrantRegistryGenerator\Configuration;

use Jalle19\VagrantRegistryGenerator\Exception\MissingCredentialsException;
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
     * @throws MissingCredentialsException
     *
     * @return Configuration
     */
    public static function parseConfiguration(InputInterface $input)
    {
        $configuration = new Configuration();

        $configuration
            ->setRegistryPath($input->getArgument('registryPath'))
            ->setOutputPath(self::parseOutputPath($input))
            ->setAwsAccessKey(self::parseAwsAccessKey($input))
            ->setAwsSecretKey(self::parseAwsSecretKey($input))
            ->setAwsRegion($input->getOption('awsRegion'));

        if (!$configuration->hasCredentials()) {
            throw new MissingCredentialsException('No AWS credentials configured, see --help for how to configure them');
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


    /**
     * @param InputInterface $input
     *
     * @return string|null
     */
    private static function parseAwsAccessKey(InputInterface $input)
    {
        $awsAccessKey = $input->getOption('awsAccessKey');

        if (empty($awsAccessKey)) {
            $awsAccessKey = getenv('AWS_ACCESS_KEY_ID');
        }

        return $awsAccessKey;
    }


    /**
     * @param InputInterface $input
     *
     * @return string|null
     */
    private static function parseAwsSecretKey(InputInterface $input)
    {
        $awsSecretKey = $input->getOption('awsSecretKey');

        if (empty($awsSecretKey)) {
            $awsSecretKey = getenv('AWS_SECRET_ACCESS_KEY');
        }

        return $awsSecretKey;
    }

}
