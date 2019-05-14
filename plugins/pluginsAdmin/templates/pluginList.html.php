
    <?php foreach($data['stats'] as $pluginStatus => $statusPluginData): ?>
    <?php foreach($statusPluginData as $pluginDetails): ?>

            <?php
        $ob = unserialize($pluginDetails);

       $pluginsAnaliser = new \plugins\pluginsAdmin\Classes\PluginsAnaliser(unserialize($pluginDetails));
       $panel = $pluginsAnaliser->getPluginDetails();

            ?>
        <?php if($panel instanceof \plugins\Plugin):?>
        <div class="pluginContainer" data-id="<?php echo $pluginsAnaliser->getPluginId()?>">
            <div class="plugin-cont-header">
                <div class="plugin-name">
                    <div class="label">Nazwa:</div>
                    <div class="description"><?php echo $panel->getPluginName() ?></div>
                </div>
            </div>
            <div class="plugin-cont-body">
                <div class="details">
                    <div class="label">Katalog: </div>
                    <div class="description directory"><?php echo $panel->pluginPath() ?></div>
                </div>
                <div class="details">
                    <div class="label">Autor:</div>
                    <div class="description"><?php echo $panel->pluginInfo()["Author"] ?></div>
                </div>
                <div class="details">
                    <div class="label">Opis:</div>
                    <div class="description"><?php echo $panel->pluginInfo()["Description"] ?></div>
                </div>
                <div class="details">
                    <div class="label">Status:</div>
                    <div class="description"><?php echo $pluginsAnaliser->getPluginStatus() ?></div>
                </div>
            </div>
            <div class="plugin-cont-actions">
                <div class="actions">
                    <div class="label">Akcje:</div>
                    <?php if($pluginsAnaliser->getPanelEntity()->getActive() === 1):?>
                    <div class="description">
                        <button data-action="disable" type="button" class="btn btn-danger">Wyłącz</button>
                        <button data-action="unInstall" type="button" class="btn btn-primary">Odinstaluj</button>
                    </div>
                    <?php elseif ($pluginsAnaliser->getPanelEntity()->getActive() === 2):?>
                    <div class="description"><button data-action="enable" type="button" class="btn btn-warning">Włącz</button></div>
                    <?php else :?>
                        <div class="description"><button data-action="install" type="button" class="btn btn-success">Zainstaluj</button></div>
                    <?php endif;?>
                </div>
            </div>
        </div>
        <?php endif;?>
            <?php if($panel instanceof \Entities\Panels):?>
                <div class="pluginContainer" data-id="<?php echo $panel->getPanelId()?>">
                    <div class="plugin-cont-header">
                        <div class="plugin-name"><b>Nazwa klasy pluginu:</b> <?php echo $panel->getPluginClassName() ?></div>
                    </div>
                    <div class="plugin-cont-body">
                        <div class="details">
                            <div class="label">Status:</div>
                            <div class="description"><?php echo $pluginsAnaliser->getPluginStatus() ?></div>
                        </div>
                    </div>
                    <div class="plugin-cont-actions">
                        <div class="actions">
                            <div class="label">Akcje:</div>
                                <div class="description">
                                    <button data-action="unInstall" type="button" class="btn btn-primary">Usuń z bazy danych</button>
                                </div>

                        </div>
                    </div>
                </div>
            <?php endif;?>
    <?php endforeach;?>

    <?php endforeach;?>

<!--<div class="page" data-page-id="2">2</div><div class="page" data-page-id="3">3</div>-->
