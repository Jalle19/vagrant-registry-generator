<?php

use Jalle19\VagrantRegistryGenerator\Registry\Manifest\Manifest;

/* @var Manifest[] $manifests */
/* @var array $organizations */

$this->layout('layout', ['title' => 'Vagrant Registry']);

?>
<p>
    This registry contains a total of <?php echo count($manifests); ?> manifest(s) from <?php echo count($organizations); ?> organization(s)
</p>

<h2>Manifests</h2>

<ul>
    <?php

    foreach ($manifests as $manifest) {
        $name = $manifest->getName();

        ?>
        <li class="manifest">
            <a href="manifests/<?=$this->e($name)?>.html"><?=$this->e($name)?></a>

            <p class="lastModified">
                Last modified:
                <?php

                $lastModified = $manifest->getLastModified();

                if ($lastModified !== null) {
                    echo $lastModified->format('c');
                } else {
                    echo 'not available';
                }

                ?>
            </p>
        </li>
        <?php
    }

    ?>
</ul>
