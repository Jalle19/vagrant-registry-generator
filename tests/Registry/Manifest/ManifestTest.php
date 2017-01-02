<?php

namespace Jalle19\VagrantRegistryGenerator\Test\Registry\Manifest;

use Jalle19\VagrantRegistryGenerator\Registry\Manifest\Manifest;

/**
 * Class ManifestTest
 * @package Jalle19\VagrantRegistryGenerator\Test\Registry\Manifest
 */
class ManifestTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @param $manifestName
     * @param $expectedOrganization
     *
     * @dataProvider organizationProvider
     */
    public function testGetOrganization($manifestName, $expectedOrganization)
    {
        $manifest = new Manifest($manifestName, [], 'http://example.com');

        $this->assertEquals($expectedOrganization, $manifest->getOrganization());
    }


    /**
     * @return array
     */
    public function organizationProvider()
    {
        return [
            ['organization/box', 'organization'],
            ['box', 'box'],
        ];
    }

}
