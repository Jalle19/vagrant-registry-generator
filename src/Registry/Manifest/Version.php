<?php

namespace Jalle19\VagrantRegistryGenerator\Registry\Manifest;

/**
 * Class Version
 * @package Jalle19\VagrantRegistryGenerator\Registry\Manifest
 */
class Version
{

    /**
     * @var string
     */
    private $version;

    /**
     * @var Provider[]
     */
    private $providers;


    /**
     * Version constructor.
     *
     * @param string     $version
     * @param Provider[] $providers
     */
    public function __construct($version, array $providers)
    {
        $this->version   = $version;
        $this->providers = $providers;
    }


    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }


    /**
     * @return Provider[]
     */
    public function getProviders()
    {
        return $this->providers;
    }
    
}
