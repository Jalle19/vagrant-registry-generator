<?php

namespace Jalle19\VagrantRegistryGenerator\Registry\Manifest;

/**
 * Class Parser
 * @package Jalle19\VagrantRegistryGenerator\Registry\Manifest
 */
class Parser
{

    /**
     * @param string $manifestJson
     *
     * @return Manifest
     */
    public static function parseManifest($manifestJson, $manifestUrl)
    {
        $manifest = json_decode($manifestJson);
        $versions = [];

        foreach ($manifest->versions as $version) {
            $providers = [];

            foreach ($version->providers as $provider) {
                $providers[] = new Provider($provider->name, $provider->url, $provider->checksum_type,
                    $provider->checksum);
            }

            $versions[] = new Version($version->version, $providers);
        }

        return new Manifest($manifest->name, $versions, $manifestUrl);
    }

}
