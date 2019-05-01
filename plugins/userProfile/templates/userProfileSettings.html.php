<div class="panel panel-default">
    <div class="panel-heading profileLabel bold">Podstawowe</div>
    <div class="panel-body">
        <div class="positionContainer">
            <div class="profileLabel">Login</div>
            <div class="posEdition">
                <a href="#" id="login" class="toSave" data-type="text" data-placement="top"><?= $data['user']->getLogin()?></a>
            </div>
        </div>
        <div class="positionContainer">
            <div class="profileLabel">Imię</div>
            <div class="posEdition">
                <a href="#" id="uName" class="toSave" data-type="text" data-placement="top"><?= $data['user']->getUserName()?></a>
            </div>
        </div>
        <div class="positionContainer">
            <div class="profileLabel">Ranga</div>
            <div class="posEdition">
                <?= $data['user']->getUserRankId()->getRankName()?>
            </div>
        </div>
        <div class="positionContainer">
            <div class="profileLabel">Data rejestracji</div>
            <div class="posEdition">
                <?= $data['user']->getRegistrationDate()?>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading profileLabel bold">Dodatkowe</div>
    <div class="panel-body">
        <div class="positionContainer">
            <div class="profileLabel">Email</div>
            <div class="posEdition">
                <a href="#" id="uEmail" class="toSave" data-type="text" data-placement="top"><?= $data['user']->getEmail()?></a>
            </div>
        </div>
        <div class="positionContainer">
            <div class="profileLabel">Zmiana hasła</div>
            <div class="posEdition">
                <a href="#" id="password" data-type="passwords" data-placement="top">zmień hasło</a>
            </div>
        </div>
</div>

<?php
