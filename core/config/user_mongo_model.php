<?php

    GetQuery(); // Чтобы фунция SiteRoot корректно заработала нужно проинициализировать LANG в функции GetQuery
    $g_config['user_mongo_model'] = array();

    // Соль для хеша пароля
    $g_config['user_mongo_model']['salt'] = "3gjklhadfqehwe4mn34534567"; //!!! Обязательно нужно заменить

    // Если allowed_pages и disallowed_pages оба array(), то все страницы можно просматривать всем юзерам. 
    // Если заданы allowed_pages, то для незарегестрированных юзеров разрешены только они
    // Если заданы disallowed_pages, то незарегестрированным юзерам можно смотреть все страницы, кроме указанных в disallowed_pages
    $g_config['user_mongo_model']['allowed_pages']    = array();
    
    // Страница, куда попадет пользователь, после успешного входа в систему
    $g_config['user_mongo_model']['after_login_page']  = SiteRoot('user/home');
    // Страница, куда попадет пользователь, после выхода из системы
    $g_config['user_mongo_model']['after_logout_page'] = SiteRoot('user/login');
    // Для восстановления пароля
    $g_config['user_mongo_model']['pwd_recovery_salt'] = "13gjklhadfqehfa3sfasdfwemn34534567"; //!!! Обязательно нужно заменить

    // Меню кабинета
    $g_config['user_mongo_model']['cabinet_menu'] = array();
    $g_config['user_mongo_model']['cabinet_menu'][] = array
    (
        "title" => "Профиль",
        "href"  => SiteRoot("user/profile"),
    );
    $g_config['user_mongo_model']['cabinet_menu'][] = array
    (
        "title" => "Редактировать",
        "href"  => SiteRoot("user/edit"),
    );
    // Главный шаблон кабинета
    $g_config['user_mongo_model']['main_tpl'] = 'user/main_tpl_show';
    // Страницы, которые нужно показавать в главном шаблоне кабинета
    $g_config['user_mongo_model']['main_tpl_pages'] = array();
    $g_config['user_mongo_model']['main_tpl_pages'][] = "user/home";
    $g_config['user_mongo_model']['main_tpl_pages'][] = "user/profile";
    $g_config['user_mongo_model']['main_tpl_pages'][] = "user/edit";

    // Редактирование пользователей в админке
    require_once BASEPATH . 'core/config/admin_menu.php';
    $g_config['admin_menu'][]   = array
                        (
                            'link'  => SiteRoot('admin/users'),
                            'name'  => 'Пользователи',
                            'label' => 'Пользователи сайта',
                            'css'   => '',
                            'list'  => array()
                        );
?>