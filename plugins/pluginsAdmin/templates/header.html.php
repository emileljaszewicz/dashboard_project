<!doctype html>
<html>
<head>
    <title><?= $this->getPageTitle(); ?></title>
    <link rel="stylesheet" href="plugins/pluginsAdmin/CSS/mainPluginStyles.css?v=<?php echo md5(microtime())?>" >
    <script src="plugins/pluginsAdmin/js/mainScripts.js?v=<?php echo md5(microtime())?>" ></script>
    <?= $this->printHeaderScripts(); ?>
</head>
<body>
<div class="container pluginAdminContainer" style="background: white; min-width:300px; height: 100%; padding:0px;">
<div style="height: 100%;float:left;">
    <div class="adminNavigation" style="background:whitesmoke;">
        <div  class="link" data-action="index">Lista pluginów</div>
    </div>
</div>
<div style="overflow-y:auto; height:100%">
<div style="padding: 30px">
    <div class="pageTitle"><?php echo $this->getPageTitle() ?></div>