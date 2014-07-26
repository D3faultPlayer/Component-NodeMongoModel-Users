                        
    <?php IncludeCom('dev/bootstrap3')?>


    <h1>Авторизация на сайте</h1>
    <p>
        Для регистрации вам нужно лишь стать участником поездки или предложить свою поездку.
    </p>
    <div class="row">
        <div class="col-xs-6">
            <?= $msg?>
            <form action="<?= GetCurUrl()?>" method="post" role="form">
                <input type="hidden" name="is_login" value="1">
                <div class="form-group">
                    <label for="i-login">E-mail</label>
                    <input type="text" class="form-control input-sm" id="i-login" name="login" value="<?= Post('login')?>" autocomplete="on">
                </div>
                <div class="form-group">
                    <label for="i-pwd">Пароль</label>
                    <input type="password" class="form-control input-sm" id="i-pwd" name="pwd" value="<?= Post('pwd')?>" autocomplete="on">
                </div>
                <button type="submit" class="btn btn-lg btn-primary">
                    <i class="fa fa-user"></i>
                    Войти
                </button>
                <a href="<?= SiteRoot("user/pwd_recovery")?>" class="btn btn-lg btn-default">
                    <i class="fa fa-unlock"></i>
                    Забыли пароль?
                </a>
                <a href="<?= SiteRoot("user/register")?>" class="btn btn-lg btn-default">
                    <i class="fa fa-book"></i>
                    Регистрация
                </a>
            </form>
        </div>
    </div>