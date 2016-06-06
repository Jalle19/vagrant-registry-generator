<?php

/* @var string $boxName */
/* @var string $provider */
/* @var string $manifestUrl */

?>
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

    config.vm.box = "<?php echo $boxName; ?>"
    config.vm.box_url = "<?php echo $manifestUrl; ?>"

end
