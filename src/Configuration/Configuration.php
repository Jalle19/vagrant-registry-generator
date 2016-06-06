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
    private $awsAccessKey;

    /**
     * @var string
     */
    private $awsSecretKey;

    /**
     * @var string
     */
    private $awsRegion;

    /**
     * @var string
     */
    private $s3Bucket;

    /**
     * @var string
     */
    private $s3Prefix;


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
    public function getAwsAccessKey()
    {
        return $this->awsAccessKey;
    }


    /**
     * @param string $awsAccessKey
     *
     * @return Configuration
     */
    public function setAwsAccessKey($awsAccessKey)
    {
        $this->awsAccessKey = $awsAccessKey;

        return $this;
    }


    /**
     * @return string
     */
    public function getAwsSecretKey()
    {
        return $this->awsSecretKey;
    }


    /**
     * @param string $awsSecretKey
     *
     * @return Configuration
     */
    public function setAwsSecretKey($awsSecretKey)
    {
        $this->awsSecretKey = $awsSecretKey;

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
     * @return string
     */
    public function getS3Bucket()
    {
        return $this->s3Bucket;
    }


    /**
     * @param string $s3Bucket
     *
     * @return Configuration
     */
    public function setS3Bucket($s3Bucket)
    {
        $this->s3Bucket = $s3Bucket;

        return $this;
    }


    /**
     * @return string
     */
    public function getS3Prefix()
    {
        return $this->s3Prefix;
    }


    /**
     * @param string $s3Prefix
     *
     * @return Configuration
     */
    public function setS3Prefix($s3Prefix)
    {
        $this->s3Prefix = $s3Prefix;

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
        } else {
            return self::FILESYSTEM_TYPE_LOCAL;
        }
    }

}
