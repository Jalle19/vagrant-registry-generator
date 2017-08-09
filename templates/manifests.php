<?php

use Jalle19\VagrantRegistryGenerator\Registry\Manifest\Manifest;

/* @var Manifest[] $manifests */
/* @var string $baseUrl */

?>
<h2>Manifests</h2>

<table>
  <tr>
    <th>Name:</th>
    <th>Last modified:</th>
  </tr>

    <?php

    foreach ($manifests as $manifest) {
        $name = $manifest->getName();

        ?>
        <tr>
          <td>
            <a href="<?=$baseUrl?>manifests/<?=$this->e($name)?>.html"><?=$this->e($name)?></a>
          </td>
          <td>
            <?php

            $lastModified = $manifest->getLastModified();

            if ($lastModified !== null) {
                echo $lastModified->format('c');
            } else {
                echo 'not available';
            }

            ?>
          </td>
        </tr>
        <?php
    }

    ?>
</table>
