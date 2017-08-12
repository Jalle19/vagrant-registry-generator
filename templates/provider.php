<?php

use Jalle19\VagrantRegistryGenerator\Registry\Manifest\Provider;

/* @var Provider $provider */

$metadata = $provider->getFileMetadata();

?>
<tr>
    <td><?php echo $metadata->getFileName(); ?></td>
    <td><?php echo (int)($metadata->getSize() / 1024 / 1024); ?> MiB</td>
    <td><?php echo $metadata->getTimestamp()->format('c'); ?></td>
</tr>
<?php
