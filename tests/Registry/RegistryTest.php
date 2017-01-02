<?php

namespace Jalle19\VagrantRegistryGenerator\Test\Registry;

use Jalle19\VagrantRegistryGenerator\Registry\Manifest\Manifest;
use Jalle19\VagrantRegistryGenerator\Registry\Registry;

/**
 * Class RegistryTest
 * @package Jalle19\VagrantRegistryGenerator\Test\Registry
 */
class RegistryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @param array $manifestNames
     * @param array $organizations
     *
     * @dataProvider manifestsByOrganizationProvider
     */
    public function testGetManifestsByOrganization(array $manifestNames, array $organizations)
    {
        // Create the manifests
        $manifests = [];

        foreach ($manifestNames as $manifestName) {
            $manifests[] = new Manifest($manifestName, [], 'http://example.com');
        }

        $registry = new Registry($manifests);

        foreach ($organizations as $organization => $manifestCount) {
            $filteredManifests = $registry->getManifestsByOrganization($organization);
            $this->assertCount($manifestCount, $filteredManifests);

            foreach ($filteredManifests as $filteredManifest) {
                $this->assertEquals($organization, $filteredManifest->getOrganization());
            }
        }
    }


    /**
     * @param array $manifestNames
     * @param array $organizations
     *
     * @dataProvider manifestsByOrganizationProvider
     */
    public function testGetOrganizationStatistics(array $manifestNames, array $organizations)
    {
        // Create the manifests
        $manifests = [];

        foreach ($manifestNames as $manifestName) {
            $manifests[] = new Manifest($manifestName, [], 'http://example.com');
        }

        $registry = new Registry($manifests);

        $this->assertEquals($organizations, $registry->getOrganizationStatistics());
    }


    /**
     * @return array
     */
    public function manifestsByOrganizationProvider()
    {
        return [
            [
                ['organization/box1', 'organization/box2', 'other-organization/box1'],
                ['organization' => 2, 'other-organization' => 1],
            ],
        ];
    }

}
