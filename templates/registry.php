<?php

use Jalle19\VagrantRegistryGenerator\Registry\Manifest\Manifest;

/* @var Manifest[] $manifests */
/* @var array $organizations */

$this->layout('layout', ['title' => 'Vagrant Registry']);

?>
<p>
    This registry contains a total of <?php echo count($manifests); ?> manifest(s)
    from <?php echo count($organizations); ?> organization(s)
</p>
<?php

$this->insert('manifests', [
    'manifests' => $manifests,
]);

?>
<h2>Organizations</h2>

<ul>
    <?php

    foreach ($organizations as $organization) {
        ?>
        <li>
            <a href="organizations/<?=$this->e($organization)?>.html"><?=$this->e($organization)?></a>
        </li>
        <?php
    }

    ?>
</ul>
