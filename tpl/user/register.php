
    <h1>Регистрация</h1>
    <div class="row">
        <div class="col-xs-12">
            <?= $msg?>
        </div>
    </div>
    <form action="<?= GetCurUrl()?>" method="post" role="form" enctype="multipart/form-data">
        <input type="hidden" name="is_reg" value="1">

        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="i-photo">Фотография</label>
                    <?php if (Post('photo')):?>
                        <div class="clearfix"></div>
                        <img src="<?= NodeImgUrl(Post('photo'), $aw, $ah, "fitout")?>" class="img-thumbnail" style="width: 100%; max-width: <?= $aw?>px; margin-bottom: 10px;">
                        <input class="form-control" type="hidden" name="photo" value="<?= Post('photo')?>">
                    <?php else:?>
                        <img src="/i/image/dev/get_img_fail.png" style="width: 100%; max-width: 256px; margin-bottom: 10px;" class="thumbnail">
                    <?php endif?>
                    <input type="file" name="photo_file" id="i-photo">
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label for="i-login">E-mail</label>
                    <input type="text" class="form-control input-sm" id="i-login" name="email" value="<?= Post('email')?>">
                </div>
                <div class="form-group">
                    <label for="i-pwd">Пароль</label>
                    <input type="password" class="form-control input-sm" id="i-pwd" name="pwd"  value="" autocomplete="off">
                </div>

                <div class="form-group">
                    <label for="i-name">Имя</label>
                    <input type="text" class="form-control input-sm" id="i-name" name="name" value="<?= Post('name')?>">
                </div>
               
                <div class="form-group">
                    <label for="i-sex">Пол</label>
                    <select class="form-control input-sm" id="i-sex" name="sex">
                        <?php foreach($userModel->GetEnums('sex') as $k => $v):?>
                            <option value="<?= $k?>" <?= Post('sex') == $k ? "selected" : ""?>><?= $v?></option>
                        <?php endforeach?>
                    </select>
                </div>
               
                <div class="form-group">
                    <label for="i-birthday">Дата рождения</label>
                    <input type="date" class="form-control input-sm" id="i-birthday" name="birthday" value="<?= Post('birthday')?>">
                </div>
            </div>
            <div class="col-sm-5">
                <div class="form-group">
                    <label for="i-about">О себе</label>
                    <textarea class="form-control input-sm" id="i-about" rows="16" name="about"><?= Post('about')?></textarea>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-lg btn-primary">
            <i class="fa fa-user"></i>
            &nbsp;
            Зарегистрироваться
        </button>
    </form>
