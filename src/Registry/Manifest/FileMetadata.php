<?php

namespace Jalle19\VagrantRegistryGenerator\Registry\Manifest;

/**
 * Class FileMetadata
 * @package Jalle19\VagrantRegistryGenerator\Registry\Manifest
 */
class FileMetadata
{

    /**
     * @var string
     */
    private $fileName;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var int
     */
    private $size;


    /**
     * FileMetadata constructor.
     *
     * @param string    $fileName
     * @param \DateTime $timestamp
     * @param int       $size
     */
    public function __construct($fileName, \DateTime $timestamp, $size)
    {
        $this->fileName  = $fileName;
        $this->timestamp = $timestamp;
        $this->size      = $size;
    }


    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }


    /**
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }


    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }
    
}
