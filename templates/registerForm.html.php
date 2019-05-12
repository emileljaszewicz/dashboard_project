<div id="jqueryLoginForm" class="login-panel-styles rounded">
    <?=!empty($otherErrors = $this->getMessages('otherErrors'))? '<div class="alert alert-danger" role="alert">'.$otherErrors.'</div>':''?>
<form action="index.php?task=index&action=registerInit" method="post">
    <div class="form-group <?= !empty($loginError = $this->getMessages('uLoginError'))? 'has-error': ''?>" >
         <label>Login</label>
        <input type="text" name="uLogin" class="form-control"   placeholder="Podaj login">
        <div class="control-label "><?= $loginError;?></div>
    </div>
    <div class="form-group <?= !empty($emailError = $this->getMessages('uEmailError'))? 'has-error': ''?>" >
         <label>Email</label>
        <input type="text" name="uEmail" class="form-control"   placeholder="Podaj email">
        <div class="control-label "><?= $emailError;?></div>
    </div>
    <div class="form-group <?= (!empty($passwordError = $this->getMessages('uPasswordError'))? 'has-error': '')?>">
        <label >Password</label>
        <input type="password" name="uPassword" class="form-control"  placeholder="Podaj hasło">
        <div class="control-label"><?= $passwordError;?></div>
    </div>
    <div class="form-group <?= (!empty($confirmError = $this->getMessages('uConfirmError'))? 'has-error': '')?>">
        <label >Confirm password</label>
        <input type="password" name="uConfirm" class="form-control"  placeholder="Powtórz hasło">
        <div class="control-label"><?= $confirmError;?></div>
    </div>

    <button type="submit" name="submit" class="btn btn-primary btn-sm">Register</button>
</form>
</div>
