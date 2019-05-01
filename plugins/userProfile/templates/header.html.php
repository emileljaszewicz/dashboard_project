<!doctype html>
<html>
<head>
    <title><?= $this->getPageTitle(); ?></title>
    <link rel="stylesheet" href="plugins/userProfile/CSS/mainPluginStyles.css?v=<?php echo md5(microtime())?>" >

    <?= $this->printHeaderScripts(); ?>

</head>
<body>
<div class="container userProfileContainer" style="background: white; min-width:300px; height: 100%; padding:0px;">
<div style="height: 100%;float:left;">
    <div class="adminNavigation" style="background:whitesmoke;">
        <div  class="link" data-action="index">Logowanie</div>
    </div>
</div>
<div style="overflow-y:auto; height:100%; position:relative;">
    <div class="alert-danger panel-alert" style=" cursor:pointer;top: 20px;"></div>
<div style="padding: 30px;">
    <div class="pageTitle"><?php echo $this->getPageTitle() ?></div>