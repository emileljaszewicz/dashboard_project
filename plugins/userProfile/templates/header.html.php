<!doctype html>
<html>
<head>
    <title><?= $this->getPageTitle(); ?></title>
    <link rel="stylesheet" href="plugins/userProfile/CSS/mainPluginStyles.css?v=<?php echo md5(microtime())?>" >

    <?= $this->printHeaderScripts(); ?>

</head>
<body>
<div class="container pluginAdminContainer">
    <div class="navigationContainer">
        <div  class="link" data-action="index">Dane logowania</div>
    </div>
    <div class="userProfileContainer">
        <div class="user_alert"></div>
        <div class="pageTitle"><?php echo $this->getPageTitle() ?></div>