<?php

/** @var array $organizationStatistics */

?>
<table>
    <tr>
      <th>Name:</th>
      <th>Manifests:</th>
    </tr>
    <?php

    foreach ($organizationStatistics as $organization => $manifestCount) {
        ?>
        <tr>
          <td>
            <a href="organizations/<?=$this->e($organization)?>.html"><?=$this->e($organization)?></a>
          </td>
          <td>
              <?=$manifestCount?>
          </td>
        </tr>
        <?php
    }

    ?>
</table>
