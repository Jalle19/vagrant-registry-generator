<?php

use Jalle19\VagrantRegistryGenerator\Registry\Manifest\Manifest;

/* @var string $organization */
/* @var Manifest[] $manifests */
$this->layout('layout', ['title' => $organization . ' - Vagrant Registry']);

?>
    <h2><?=$this->e($organization);?></h2>

    <p>
        This organization has <?php echo count($manifests); ?> manifest(s)
    </p>
<?php

$this->insert('manifests', [
    'manifests' => $manifests,
    'baseUrl'   => '../',
]);
