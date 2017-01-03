<?php

use Jalle19\VagrantRegistryGenerator\Registry\Manifest\Manifest;

/* @var Manifest[] $manifests */
/* @var array $organizationStatistics */

$this->layout('layout', ['title' => 'Vagrant Registry'])

?>
<p>
    This registry contains a total of <?php echo count($manifests); ?> manifest(s)
    from <?php echo count($organizationStatistics); ?> organization(s)
</p>
<?php

$this->insert('manifests', [
    'manifests' => $manifests,
    'baseUrl' => '',
]);

?>
<h2>Organizations</h2>

<ul>
    <?php

    foreach ($organizationStatistics as $organization => $manifestCount) {
        ?>
        <li>
            <a href="organizations/<?=$this->e($organization)?>.html"><?=$this->e($organization)?></a>
            (<?=$manifestCount?> manifest(s))
        </li>
        <?php
    }

    ?>
</ul>
