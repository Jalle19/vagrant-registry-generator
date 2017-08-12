<?php

use Jalle19\VagrantRegistryGenerator\Registry\Manifest\Version;

/* @var Version $version */
/* @var string $boxName */
/* @var string $manifestUrl */

?>
<div class="version">
    <a href="#<?php echo $version->getVersion(); ?>" name="<?php echo $version->getVersion(); ?>">
        <h2 class="header"><?php echo $version->getVersion(); ?></h2>
    </a>
    <table>
        <tr>
            <th>Filename:</th>
            <th>Size:</th>
            <th>Last modified:</th>
        </tr>
        <?php

        foreach ($version->getProviders() as $provider) {
            // Skip providers without metadata
            if (!$provider->hasMetadata()) {
                continue;
            }
            
            $this->insert('provider', [
                'provider' => $provider,
            ]);
        }

        ?>
    </table>
    <pre class="vagrantFile"><?php echo trim($this->fetch('vagrantFile', [
            'boxName'     => $boxName,
            'manifestUrl' => $manifestUrl,
        ])); ?></pre>
</div>
