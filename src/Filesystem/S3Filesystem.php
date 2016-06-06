<?php

namespace Jalle19\VagrantRegistryGenerator\Filesystem;

use Aws\S3\S3Client;
use Jalle19\VagrantRegistryGenerator\Configuration\Configuration;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Filesystem as Flysystem;

/**
 * Class S3Filesystem
 * @package Jalle19\VagrantRegistryGenerator\Filesystem
 */
class S3Filesystem extends RemoteFilesystem
{

    /**
     * @var string
     */
    private $bucket;

    /**
     * @var string
     */
    private $prefix;


    /**
     * S3Filesystem constructor.
     *
     * @param Configuration $configuration
     * @param string        $bucket
     * @param string        $prefix
     */
    public function __construct(Configuration $configuration, $bucket, $prefix)
    {
        parent::__construct($configuration);

        $this->bucket = $bucket;
        $this->prefix = $prefix;

        $client = new S3Client([
            'credentials' => [
                'key'    => $configuration->getAwsAccessKey(),
                'secret' => $configuration->getAwsSecretKey(),
            ],
            'region'      => $configuration->getAwsRegion(),
            'version'     => 'latest',
        ]);

        $adapter = new AwsS3Adapter($client, $bucket, $prefix);

        $this->filesystem = new Flysystem($adapter);
    }


    /**
     * @inheritdoc
     */
    public function getUrl($path)
    {
        /* @var AwsS3Adapter $adapter */
        $adapter = $this->filesystem->getAdapter();

        return $adapter->getClient()->getObjectUrl($this->bucket, $this->prefix . '/' . $path);
    }

}
