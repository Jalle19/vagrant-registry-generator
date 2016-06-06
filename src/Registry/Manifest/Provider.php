<?php

namespace Jalle19\VagrantRegistryGenerator\Registry\Manifest;

/**
 * Class Provider
 * @package Jalle19\VagrantRegistryGenerator\Registry\Manifest
 */
class Provider
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $checksumType;

    /**
     * @var string
     */
    private $checksum;

    /**
     * @var FileMetadata
     */
    private $fileMetadata;


    /**
     * Provider constructor.
     *
     * @param string $name
     * @param string $url
     * @param string $checksumType
     * @param string $checksum
     */
    public function __construct($name, $url, $checksumType, $checksum)
    {
        $this->name         = $name;
        $this->url          = $url;
        $this->checksumType = $checksumType;
        $this->checksum     = $checksum;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }


    /**
     * @return string
     */
    public function getChecksumType()
    {
        return $this->checksumType;
    }


    /**
     * @return string
     */
    public function getChecksum()
    {
        return $this->checksum;
    }


    /**
     * @return bool
     */
    public function hasMetadata()
    {
        return $this->fileMetadata !== null;
    }


    /**
     * @return FileMetadata
     */
    public function getFileMetadata()
    {
        return $this->fileMetadata;
    }


    /**
     * @param FileMetadata $fileMetadata
     *
     * @return Provider
     */
    public function setFileMetadata($fileMetadata)
    {
        $this->fileMetadata = $fileMetadata;

        return $this;
    }

}
