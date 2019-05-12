<div id="modal" class="panel rank-privileges-container" style="min-width: 200px; height: 300px">
    <div class="panel-heading rank-privileges-label">Lista uprawnień</div>
    <div class="panel-body privileges-content">
        <?php foreach ($data['panels'] as $panelObject):?>

            <div class="checkbox">
                <label>
                    <input type="checkbox"
                   <?php if(in_array($panelObject->getPanelId(), $data['rankPanels'])):?>
                   checked="checked"
                   <?php endif;?>
                     value="<?php echo $panelObject->getPanelId() ?>">
                    <?= $panelObject->getPluginClassName()?>
                </label>
            </div>
        <?php endforeach;?>
    </div>
    <div class="buttons" >
        <button type="button" class="btn  btn-success save">zapisz</button>
        <button type="button" class="btn  btn-info modal-close">zamknij</button>
    </div>
</div>
