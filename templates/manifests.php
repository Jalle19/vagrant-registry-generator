<?php

use Jalle19\VagrantRegistryGenerator\Registry\Manifest\Manifest;

/* @var Manifest[] $manifests */
/* @var string $baseUrl */

?>
<h2>Manifests</h2>

<ul>
    <?php

    foreach ($manifests as $manifest) {
        $name = $manifest->getName();

        ?>
        <li>
            <a href="<?=$baseUrl?>manifests/<?=$this->e($name)?>.html"><?=$this->e($name)?></a>

            <span class="lastModified">
                (last modified:
                <?php

                $lastModified = $manifest->getLastModified();

                if ($lastModified !== null) {
                    echo $lastModified->format('c');
                } else {
                    echo 'not available';
                }

                ?>)
            </span>
        </li>
        <?php
    }

    ?>
</ul>
