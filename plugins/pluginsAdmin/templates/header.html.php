<!doctype html>
<html>
<head>
    <title><?= $this->getPageTitle(); ?></title>
    <link rel="stylesheet" href="plugins/pluginsAdmin/CSS/mainPluginStyles.css?v=<?php echo md5(microtime())?>" >
    <script src="plugins/pluginsAdmin/js/mainScripts.js?v=<?php echo md5(microtime())?>" ></script>
    <?= $this->printHeaderScripts(); ?>
</head>
<body>
<div class="container pluginAdminContainer">
<div class="navigationContainer">
    <div  class="link" data-action="index">Lista pluginów</div>
    <div  class="link" data-action="userRanks">Rangi użytkowników</div>
</div>
<div class="content-container">
    <div class="pageTitle"><?php echo $this->getPageTitle() ?></div>