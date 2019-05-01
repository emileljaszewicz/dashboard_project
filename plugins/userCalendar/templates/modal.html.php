<div id="modal" class="panel event-container" style="width: 400px; height: 300px">
    <div class="panel-heading event-container-label">Wydarzenie na dzień <?= $data['date']?></div>
    <div class="panel-body event-content" >
        <form action="saveEvent">
            <div class="form-group">
                <label for="exampleInputEmail1">Nazwa wydarzenia</label>
                <input type="text" class="form-control modalData" name="eventTitle" value="<?= $data['existedEvent']->getEventName() ?>">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Opis</label>
                <textarea class="form-control modalData" rows="3" name="eventDescription"><?= $data['existedEvent']->getDescription() ?></textarea>
            </div>
            <div class="buttons">
                <button type="submit" class="btn btn-default saveEvent">Zapisz</button>
                <button type="submit" class="btn btn-default closeEvent">Zamknij</button>
                <?php if(!empty($data['existedEvent']->getEventDate())):?>
                    <button type="submit" class="btn btn-default removeEvent">Usuń</button>
                <?php endif;?>
            </div>
        </form>
    </div>
</div>
