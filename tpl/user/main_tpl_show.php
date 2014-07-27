
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="panel-group">
                <div class="panel panel-default">
                    <ul class="list-group">
                        <?php foreach($g_config['user_mongo_model']['cabinet_menu'] as $p):?>
                            <?php if (SiteRoot(GetQuery()) == $p['href']):?>
                                <li class="list-group-item">
                                    <a href="<?= $p['href']?>">
                                        <strong><?= $p['title']?></strong>
                                    </a>
                                </li>
                            <?php else:?>
                                <li class="list-group-item">
                                    <a href="<?= $p['href']?>">
                                        <?= $p['title']?>
                                    </a>
                                </li>
                            <?php endif?>
                        <?php endforeach?>
                        <li class="list-group-item">
                            <a href="<?= SiteRoot('user/logout')?>" onclick="return confirm('Вы действительно хотите выйти?')">
                                Выйти
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-8 col-sm-6">
            <?= $content?>
        </div>
    </div>
