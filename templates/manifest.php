<?php

use Jalle19\VagrantRegistryGenerator\Registry\Manifest\Manifest;

/* @var Manifest $manifest */
$name = $manifest->getName();
$this->layout('layout', ['title' => $name . ' - Vagrant Registry']);

?>
<h2><?=$this->e($name);?></h2>
<?php

foreach (array_reverse($manifest->getVersions()) as $version) {
    $this->insert('version', [
        'boxName'     => $manifest->getName(),
        'version'     => $version,
        'manifestUrl' => $manifest->getUrl(),
    ]);
}
