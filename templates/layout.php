<?php

/* @var string $title */

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=$this->e($title)?></title>
    <link rel="stylesheet" href="styles.css" type="text/css">
</head>
<body>
<div class="header">
    <h1>Vagrant Registry</h1>
</div>
<div class="content">
    <?=$this->section('content')?>
</div>
<div class="footer">
    Generated with <a
        href="https://github.com/Jalle19/vagrant-registry-generator">Jalle19/vagrant-registry-generator</a>
</div>
</body>
</html>
