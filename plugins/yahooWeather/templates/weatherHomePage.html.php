<?php
/** @var \plugins\yahooWeather\classes\JsonParser $jsonParser */
$jsonParser = $data['JsonParser'];
$pluginPath = $data['pluginPath'];

?>
<div class="row" style="margin-top:20px; <?= (strlen($jsonParser->city->value()) === 0 ? 'display:none;' : '')?>">
    <div class="col-lg-8">
        <div class="media">
            <div class="media-left media-middle">
                <a href="#">
<!--                    <img class="media-object" src="plugins/yahooWeather/templates/images/sunny.png" width="100">-->
                    <img class="media-object" src="<?= $jsonParser->condition->get('condition')::getWeatherIcon()?>" width="50">
                </a>
            </div>
            <div class="media-left text-center">
                <h2 class="text-center"><?=  $jsonParser->condition::get('condition')::getTemperature()?> °C</h2>
                <h4 class="text-center"><?= $jsonParser->condition::get('condition')::getLabel()?></h4>

            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <table class="table table-bordered darker-color">
            <tr>
                <td>Wind</td>
                <td><?= "{$jsonParser->wind->get('wind')::getWindSpeed()} km/h, {$jsonParser->wind->get('wind')::getWindDirection()}" ?></td>
            </tr>
            <tr>
                <td>Cloudiness</td>
                <td><?= $jsonParser->condition->get('condition')::getLabel()?></td>
            </tr>
            <tr>
                <td>Pressure</td>
                <td><?= $jsonParser->pressure->value()?> hpa</td>
            </tr>
            <tr>
                <td>Humidity</td>
                <td><?= $jsonParser->humidity->value()?> %</td>
            </tr>
            <tr>
                <td>Sunrise</td>
                <td><?= $jsonParser->sunrise->value()?></td>
            </tr>
            <tr>
                <td>Sunset</td>
                <td><?= $jsonParser->sunset->value()?></td>
            </tr>
            <tr>
                <td>Temperature</td>
                <td><?= $jsonParser->condition->get('condition')::getTemperature()?> °C</td>
            </tr>
        </table>
    </div>
</div>
