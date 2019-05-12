<!doctype html>
<html>
<head>
    <title><?= $this->getPageTitle(); ?></title>
    <link rel="stylesheet" href="plugins/userCalendar/CSS/mainPluginStyles.css?v=<?php echo md5(microtime())?>" >
    <link rel="stylesheet" href="plugins/userCalendar/CSS/calendar.css?v=<?php echo md5(microtime())?>" >

    <?= $this->printHeaderScripts(); ?>

</head>
<body>

    <div class="calendarContainer">
    <div class="container-title-bar"><?= $this->getPageTitle() ?></div>
