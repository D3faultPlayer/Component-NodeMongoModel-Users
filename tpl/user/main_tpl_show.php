
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="panel-group">
                <div class="panel panel-default">
                    <?php foreach($g_config['user_mongo_model']['cabinet_menu'] as $p):?>
                        <div class="panel-heading">
                            <strong class="panel-title">
                                <?php if (SiteRoot(GetQuery()) == $p['href']):?>
                                    <a href="<?= $p['href']?>">
                                        <strong><?= $p['title']?></strong>
                                    </a>
                                <?php else:?>
                                    <a href="<?= $p['href']?>">
                                        <?= $p['title']?>
                                    </a>
                                <?php endif?>
                            </strong>
                        </div>
                    <?php endforeach?>
                    <div class="panel-heading">
                        <strong class="panel-title">
                            <a href="<?= SiteRoot('user/logout')?>" onclick="return confirm('Вы действительно хотите выйти?')">
                                Выйти
                            </a>
                        </strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-8 col-sm-6">
            <?= $content?>
        </div>
    </div>
