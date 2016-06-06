<?php

use Jalle19\VagrantRegistryGenerator\Registry\Manifest\Version;

/* @var Version $version */
/* @var string $boxName */
/* @var string $manifestUrl */

?>
<div class="version">
    <h2><?php echo $version->getVersion(); ?></h2>
    <?php

    foreach ($version->getProviders() as $provider) {
        $this->insert('provider', [
            'boxName'     => $boxName,
            'provider'    => $provider,
            'manifestUrl' => $manifestUrl,
        ]);
    }

    ?>
</div>
