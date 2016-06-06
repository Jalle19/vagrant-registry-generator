<?php

namespace Jalle19\VagrantRegistryGenerator\Registry\Manifest;

/**
 * Class Manifest
 * @package Jalle19\VagrantRegistryGenerator\Registry\Manifest
 */
class Manifest
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var Version[]
     */
    private $versions;

    /**
     * @var string
     */
    private $url;


    /**
     * Manifest constructor.
     *
     * @param string    $name
     * @param Version[] $versions
     * @param string    $url
     */
    public function __construct($name, array $versions, $url)
    {
        $this->name     = $name;
        $this->versions = $versions;
        $this->url      = $url;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * @return Version[]
     */
    public function getVersions()
    {
        return $this->versions;
    }


    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
    

    /**
     * @return \DateTime|null
     */
    public function getLastModified()
    {
        /* @var Version $latestVersion */
        $latestVersion = end($this->versions);
        $lastModified  = null;

        foreach ($latestVersion->getProviders() as $provider) {
            if ($provider->hasMetadata() &&
                ($lastModified === null || $provider->getFileMetadata()->getTimestamp() > $lastModified)
            ) {
                $lastModified = $provider->getFileMetadata()->getTimestamp();
            }
        }

        return $lastModified;
    }

}
