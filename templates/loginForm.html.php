<div id="jqueryLoginForm" class="login-panel-styles rounded">
    <?=$this->getErrors('mysqlErrors')? '<div class="alert alert-danger" role="alert">...</div>':''?>
<form action="index.php?task=index&action=userInit" method="post">
    <div class="form-group <?= !empty($loginError = $this->getErrors('loginError'))? 'has-error': ''?>" >
         <label>Login</label>
        <input type="text" name="uLogin" class="form-control"   placeholder="Podaj login">
        <div class="control-label "><?= $loginError;?></div>
    </div>
    <div class="form-group <?= (!empty($passwordError = $this->getErrors('passwordError'))? 'has-error': '')?>">
        <label >Password</label>
        <input type="password" name="uPassword" class="form-control"  placeholder="Podaj hasło">
        <div class="control-label"><?= $passwordError;?></div>
    </div>
    <div class="form-group">
        <div class="form-check-inline">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Zapamiętaj mnie</label>
        </div>
        <div class="form-check-inline">
            <a href="#">Zarejestruj się</a>
        </div>
    </div>
    <button type="submit" name="submit" class="btn btn-primary btn-sm">Submit</button>
</form>
</div>
