<?php

    $userModel = new UserMongoModel();

    // Если человек уже залогинен, то редиректим его с этой страницы
    if ($userModel->IsAuth())
    {
        header("Location: " . $g_config['user_mongo_model']['after_login_page']);
        exit();
    }

    $msg = '';
    if (Post('is_login'))
    {
        $login = trim(Post('login'));
        $pwd   = trim(Post('pwd'));
        $errs  = array();

        if (empty($login))
        {
            $errs[] = "Пустой логин";
        }
        if (empty($pwd))
        {
            $errs[] = "Пустой пароль";
        }

        if (count($errs))
        {
            $msg = MsgErr(implode('<br>', $errs));
        }
        else
        {
            $user_id = $userModel->GetUserIdByLogin($login);
            $user = new UserMongoModel($user_id);

            if ($user->IsExists() && $user->_pwd_hash == $userModel->MakeHash($pwd))
            {
                $user->MakeLogin();
                $redirectUrl = empty($redirectUrl) ? Get("redirect_url", NULL, M_HTML_FILTER_OFF | M_XSS_FILTER_OFF) : $redirectUrl;
                $redirectUrl = empty($redirectUrl) ? $g_config['user_mongo_model']['after_login_page'] : $redirectUrl;
                header("Location: " . $redirectUrl);
                exit();
            }
            else
            {
                $msg = MsgErr("Некорректный логин или пароль");
            }
        }
    }
?>