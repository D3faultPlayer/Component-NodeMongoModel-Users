
    <h1><?= $user->name?></h1>
    <div class="row">
        <div class="col-sm-4">
            <p>
                <img src="<?= NodeImgUrl($user->photo, $aw, $ah, "fitout")?>" class="img-thumbnail" style="width: 100%; max-width: <?= $aw?>px;">
            </p>
            <p>
                <strong>Зарегистрирован</strong>
                <br>
                <?= date("d.m.Y", $user->_added)?>
            </p>
        </div>
        <div class="col-sm-8">
            <?php if ($userModel->GetCurUserId() == $user->_id):?>
                <p>
                    <strong>E-mail</strong>
                    <br>
                    <?= $user->email?>
                </p>
            <?php endif?>
            <?php if ($user->birthday != ""):?>
                <p>
                    <strong>Возраст</strong>
                    <br>
                    <?= abs(date("Y") - $user->birthyear)?> лет
                </p>
            <?php endif?>

            <?php if ($user->sex == SEX_MALE || $user->sex == SEX_FEMALE):?>
                <p>
                    <strong>Возраст</strong>
                    <br>
                    <?= $user->Render("sex")?>
                </p>
            <?php endif?>

            <?php if ($user->about != ""):?>
                <p>
                    <strong>Обо мне</strong>
                    <br>
                    <?= nl2br($user->about)?>
                </p>
            <?php endif?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <pagebuttons>
                <?php if ($userModel->GetCurUserId() == $user->_id):?>
                    <a class="btn btn-lg btn-primary" href="<?= SiteRoot("user/edit")?>"><i class="fa fa-edit"></i> Редактировать</a>
                <?php endif?>
                <a class="btn btn-lg btn-default" href="javascript: history.go(-1)"><i class="fa fa-ban"></i> Назад</a>
            </pagebuttons>
        </div>
    </div>
