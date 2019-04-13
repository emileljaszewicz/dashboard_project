<div id="jqueryLoginForm" class="login-panel-styles rounded">
<form action="index.php?task=index&action=userInit" method="post">
    <div class="form-group">
        <label>Login</label>
        <input type="text" name="uLogin" class="form-control"   placeholder="Podaj login">
    </div>
    <div class="form-group">
        <label >Password</label>
        <input type="password" name="uPassword" class="form-control"  placeholder="Podaj hasło">
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
