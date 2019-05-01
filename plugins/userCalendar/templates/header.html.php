<!doctype html>
<html>
<head>
    <title><?= $this->getPageTitle(); ?></title>
    <link rel="stylesheet" href="plugins/userCalendar/CSS/mainPluginStyles.css?v=<?php echo md5(microtime())?>" >
    <link rel="stylesheet" href="plugins/userCalendar/CSS/calendar.css?v=<?php echo md5(microtime())?>" >

    <?= $this->printHeaderScripts(); ?>

</head>
<body>
<div class="container" style="background: whitesmoke; min-width:300px; width: 100%;height: 100%; padding:0px;">
    <div class="callendarContainer">
    <div class="container-title-bar"><?= $this->getPageTitle() ?></div>
