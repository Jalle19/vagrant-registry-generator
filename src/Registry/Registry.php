<?php

namespace Jalle19\VagrantRegistryGenerator\Registry;

use Jalle19\VagrantRegistryGenerator\Registry\Manifest\Manifest;

/**
 * Class Registry
 * @package Jalle19\VagrantRegistryGenerator\Registry
 */
class Registry
{

    /**
     * @var Manifest[]
     */
    private $manifests;


    /**
     * Registry constructor.
     *
     * @param Manifest[] $manifests
     */
    public function __construct(array $manifests)
    {
        $this->manifests = $manifests;
    }


    /**
     * @return Manifest[]
     */
    public function getManifests()
    {
        return $this->manifests;
    }


    /**
     * @return array
     */
    public function getOrganizations()
    {
        $organizations = [];

        foreach ($this->manifests as $manifest) {
            list($organization,) = explode('/', $manifest->getName());

            if (!in_array($organization, $organizations)) {
                $organizations[] = $organization;
            }
        }

        return $organizations;
    }

}
