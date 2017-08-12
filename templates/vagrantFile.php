<?php

/* @var string $boxName */
/* @var string $manifestUrl */

?>
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

    config.vm.box = "<?php echo $boxName; ?>"
    config.vm.box_url = "<a href="<?php echo $manifestUrl; ?>"><?php echo $manifestUrl; ?></a>"

end
