<?php

/** @var array $organizationStatistics */

?>
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
