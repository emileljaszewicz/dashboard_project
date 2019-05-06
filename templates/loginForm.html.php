<div id="jqueryLoginForm" class="login-panel-styles rounded">
    <?php
    $otherErrors = $this->getMessages('otherErrors');
    $successMessages = $this->getMessages('successMessages');
    ?>

    <?=(!empty($otherErrors) || !empty($successMessages))? '<div class="alert '.(!empty($successMessages)? 'alert-success':'alert-danger').'" role="alert">'.$otherErrors.$successMessages.'</div>':''?>
<form action="index.php?task=index&action=userInit" method="post">
    <div class="form-group <?= !empty($loginError = $this->getMessages('uLoginError'))? 'has-error': ''?>" >
         <label>Login</label>
        <input type="text" name="uLogin" class="form-control"   placeholder="Podaj login">
        <div class="control-label "><?= $loginError;?></div>
    </div>
    <div class="form-group <?= (!empty($passwordError = $this->getMessages('uPasswordError'))? 'has-error': '')?>">
        <label >Password</label>
        <input type="password" name="uPassword" class="form-control"  placeholder="Podaj hasło">
        <div class="control-label"><?= $passwordError;?></div>
    </div>
    <div class="form-group">
        <div class="form-check-inline">
            <a href="index.php?task=index&action=register">Zarejestruj się</a>
        </div>
    </div>
    <button type="submit" name="submit" class="btn btn-primary btn-sm">Submit</button>
</form>
</div>
