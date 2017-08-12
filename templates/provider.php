<?php

use Jalle19\VagrantRegistryGenerator\Registry\Manifest\Provider;

/* @var Provider $provider */
/* @var string $boxName */
/* @var string $manifestUrl */

?>
<div class="provider">
    <?php

    if ($provider->hasMetadata()) {
        $metadata = $provider->getFileMetadata();

        ?>
        <div class="fileMetadata">
            <span class="fileName"><?php echo $metadata->getFileName(); ?></span>
            <span class="fileSize"><?php echo (int)($metadata->getSize() / 1024 / 1024); ?> MiB</span>
            <span class="lastModified"><?php echo $metadata->getTimestamp()->format('c'); ?></span>
        </div>
        <?php
    }

    ?>
    <pre class="vagrantFile">
<?php echo trim($this->fetch('vagrantFile', [
    'boxName'     => $boxName,
    'manifestUrl' => $manifestUrl,
])); ?>
    </pre>
</div>
