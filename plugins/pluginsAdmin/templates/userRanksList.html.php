<?php foreach ($data['ranksObject'] as $object):?>

<div class="panel panel-default" data-id="<?= $object->getUserRankId() ?>">
    <div class="panel-body">
        <div class="glyphicon glyphicon-user"></div>
        <?= $object->getRankName() ?>
        <div class="rankActions">
            <label></label>
            <span class="buttons">
            <?php if(!($object->getUserRankObject() instanceof \userranks\Administrator)):?>
                <?php if($object->getActive() === '1'):?>
                    <button type="button" class="btn  btn-warning switch">wyłącz</button>
                <?php else:?>
                    <button type="button" class="btn  btn-success switch">włącz</button>
                <?php endif; ?>
            <?php endif; ?>

                    <button type="button" class="btn  btn-info settings">uprawnienia</button>
            </span>
        </div>
    </div>
</div>
<?php endforeach; ?>