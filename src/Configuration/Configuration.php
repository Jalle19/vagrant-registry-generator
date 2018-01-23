<?php

namespace Jalle19\VagrantRegistryGenerator\Configuration;

/**
 * Class Configuration
 * @package Jalle19\VagrantRegistryGenerator\Configuration
 */
class Configuration
{

    const FILESYSTEM_TYPE_S3    = 's3';
    const FILESYSTEM_TYPE_LOCAL = 'local';

    /**
     * @var string
     */
    private $registryPath;

    /**
     * @var string
     */
    private $outputPath;

    /**
     * @var string
     */
    private $templatePath;

    /**
     * @var string
     */
    private $awsRegion;


    /**
     * @return string
     */
    public function getRegistryPath()
    {
        return $this->registryPath;
    }


    /**
     * @param string $registryPath
     *
     * @return Configuration
     */
    public function setRegistryPath($registryPath)
    {
        $this->registryPath = $registryPath;

        return $this;
    }


    /**
     * @return string
     */
    public function getOutputPath()
    {
        return $this->outputPath;
    }


    /**
     * @param string $outputPath
     *
     * @return Configuration
     */
    public function setOutputPath($outputPath)
    {
        $this->outputPath = $outputPath;

        return $this;
    }


    /**
     * @return string
     */
    public function getTemplatePath()
    {
        return $this->templatePath;
    }


    /**
     * @param string $templatePath
     *
     * @return Configuration
     */
    public function setTemplatePath($templatePath)
    {
        $this->templatePath = $templatePath;

        return $this;
    }


    /**
     * @return string
     */
    public function getAwsRegion()
    {
        return $this->awsRegion;
    }


    /**
     * @param string $awsRegion
     *
     * @return Configuration
     */
    public function setAwsRegion($awsRegion)
    {
        $this->awsRegion = $awsRegion;

        return $this;
    }


    /**
     * @param string $path
     *
     * @return string
     */
    public static function getFilesystemType($path)
    {
        if (substr($path, 0, strlen('s3://')) === 's3://') {
            return self::FILESYSTEM_TYPE_S3;
        }

        return self::FILESYSTEM_TYPE_LOCAL;
    }

}
