<!doctype html>
<html>
<head>
    <title><?= $this->getPageTitle(); ?></title>
    <link rel="stylesheet" href="plugins/yahooWeather/CSS/mainStyles.css?v=<?php echo md5(microtime())?>" >

    <?= $this->printHeaderScripts(); ?>

</head>
<body>

    <div class="weather-container">
        <div class="container-title-bar">
            <form class="form-inline text-right">
                <div class="form-group">
                    <p class="form-control-static titleContainer"> <?= $this->getPageTitle() ?></p>
                </div>
                <div class="form-group searchContainer" >
                    <input type="text" class="form-control" placeholder="Search for..." style="display: none">
                </div>
                <button class="btn btn-default searchBtn" type="button"><span class="glyphicon glyphicon-search"></span></button>
            </form>

    </div>
