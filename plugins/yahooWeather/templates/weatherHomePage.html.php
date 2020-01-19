<?php
/** @var \plugins\yahooWeather\classes\JsonParser $jsonParser */
$jsonParser = $data['JsonParser'];
$pluginPath = $data['pluginPath'];
$dailyForecast = $jsonParser->forecasts->getNextDayForecasts();


?>
<div class="row" style="margin-top:20px; <?= (strlen($jsonParser->city->value()) === 0 ? 'display:none;' : '')?>">
    <div class="col-lg-8">
        <div class="media">
            <div class="media-left media-middle">
                <div style="background: url(<?= $jsonParser->condition->get('condition')::getWeatherIcon()?>); width: 180px; height:180px;"></div>
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
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading darker-color">Weather for days <?= $dailyForecast->getFirst()->get('date')->value()?> - <?= $dailyForecast->getLast()->get('date')->value()?></div>
            <div class="panel-body">
                <div class="owl-carousel weather-theme owl-loaded">
                    <div class="owl-stage-outer">
                        <div class="owl-stage">
                            <?php foreach ($dailyForecast->getCollection() as $jsonParserForecast):?>
                                <div class="owl-item">
                                    <div class="col-md-12 owl-date">
                                        <?= $jsonParserForecast->get('date')->value()?>
                                    </div>
                                    <div class="col-md-6 scrollable">
                                        <div style="width: 130px">
                                            <img src="<?= $jsonParserForecast->get('code')->value()?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div><?= $jsonParserForecast->get('high')->value()?> °C</div>
                                        <div><?= $jsonParserForecast->get('text')->value()?></div>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <nav aria-label="Page navigation">
            <ul class="pagination owl-nav">
                <li>
                    <a href="#" aria-label="Previous" class="owl-prev">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li>
                    <a href="#" aria-label="Next" class="owl-next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
