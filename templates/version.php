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
