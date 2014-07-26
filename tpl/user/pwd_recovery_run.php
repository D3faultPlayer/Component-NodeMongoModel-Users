
    <?php IncludeCom('dev/bootstrap3')?>


    <h1>Восстановления пароля</h1>
    <p>Пожалуйста, дважды введите новый пароль.</p>
    <?= $msg?>
    
    <form action="<?= GetCurUrl()?>#content" method="post">
        <input type="hidden" name="is_new_pwd" value="1">
        <div class="form-group">
            <label for="i-pwd">Новый пароль</label>
            <input type="password" class="form-control input-sm" id="i-pwd" name="pwd" value="">
        </div>
        <div class="form-group">
            <label for="i-pwd2">Повторите новый пароль</label>
            <input type="password" class="form-control input-sm" id="i-pwd2" name="pwd_again" value="" autocomplete="off">
        </div>
        <button type="submit" class="btn btn-lg btn-primary">
            Установить новый пароль
        </button> 
    </form>
