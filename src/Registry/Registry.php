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
     * @param string $organization the name of the organization
     *
     * @return Manifest[]
     */
    public function getManifestsByOrganization($organization)
    {
        return array_filter($this->manifests, function(Manifest $manifest) use ($organization) {
            return $manifest->getOrganization() === $organization;
        });
    }


    /**
     * @return array
     */
    public function getOrganizations()
    {
        $organizations = [];

        foreach ($this->manifests as $manifest) {
            $organization = $manifest->getOrganization();

            if (!in_array($organization, $organizations)) {
                $organizations[] = $organization;
            }
        }

        return $organizations;
    }


    /**
     * @return array
     */
    public function getOrganizationStatistics()
    {
        $statistics = [];

        foreach ($this->getOrganizations() as $organization) {
            $statistics[$organization] = count($this->getManifestsByOrganization($organization));
        }

        return $statistics;
    }

}
