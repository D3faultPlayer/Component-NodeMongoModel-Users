
    <?php IncludeCom('dev/bootstrap3')?>


    <h1>Восстановление пароля</h1>
    <p>Вы находитесь на странице восстановления пароля.</p>
    <?= $msg?>

    <form action="<?= GetCurUrl()?>" method="post" role="form">
        <input type="hidden" name="is_restore" value="1">
        <div class="form-group">
            <label for="i-login">Введите Ваш E-mail</label>
            <input type="text" class="form-control  input-sm" id="i-login" name="login" value="<?= Post("login")?>">
        </div>
        <button type="submit" class="btn btn-lg btn-primary">
            <i class="fa fa-unlock"></i>
            Восстановить
        </button>
    </form>
