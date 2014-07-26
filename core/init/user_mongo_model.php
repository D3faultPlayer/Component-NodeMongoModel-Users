<?php

    // Подменяем главный шаблон для кабинета
    if (in_array(GetQuery(), $g_config['user_mongo_model']['main_tpl_pages']))
    {
        $g_config['mainTplBasic'] = $g_config['mainTpl'];
        $g_config['mainTpl'] = "user/main_tpl";
    }
?>