<?php

use Jalle19\VagrantRegistryGenerator\Registry\Manifest\Manifest;

/* @var Manifest $manifest */
$name         = $manifest->getName();
$organization = $manifest->getOrganization();
$versions     = $manifest->getVersions();

$this->layout('layout', ['title' => $name . ' - ' . $organization . ' - Vagrant Registry']);

?>
    <h2><?=$this->e($name);?></h2>

    <p>
        This manifest contains <?php echo count($versions); ?> version(s)
    </p>
<?php

foreach (array_reverse($versions) as $version) {
    $this->insert('version', [
        'boxName'           => $manifest->getName(),
        'version'           => $version,
        'vagrantFilePrefix' => $manifest->getBoxName(),
        'manifestUrl'       => $manifest->getUrl(),
    ]);
}
