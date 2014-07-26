
    <?php IncludeCom('dev/bootstrap3')?>


    <h1>Ошибка восстановления пароля</h1>
    <p>Некорректные данные. Невозможно восстановить пароль. Попробуйте ещё раз позднее, либо обратитесь к администрору ресурса.</p>

    <a href="<?= SiteRoot("user/pwd_recovery")?>" class="btn btn-lg btn-danger">
        Попробовать еще раз
    </a>
    <a href="<?= SiteRoot()?>" class="btn btn-lg btn-primary">
        На главную
    </a>
