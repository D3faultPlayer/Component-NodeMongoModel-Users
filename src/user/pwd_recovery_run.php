<?php

    $userModel = new UserMongoModel(NULL, true);

    if ($userModel->IsAuth())
    {
        Header("Location: " . $g_config['user_mongo_model']['after_login_page']);
        exit();
    }

    $user_id = Get("user_id");
    $hash    = Get("hash");

    $user = new UserMongoModel($user_id);
    $correct = $user->IsExists() && UserMongoPwdRecoveryHash($user->email, $user->_pwd_hash) == $hash;
    if (!$correct)
    {
        Header("Location: " . SiteRoot("user/pwd_recovery_fail"));
        exit();
    }

    $errs = array();

    if ($correct)
    {
        if (Post('is_new_pwd'))
        {
            $pwd       = trim(Post("pwd"));
            $pwd_again = trim(Post("pwd_again"));

            if (empty($pwd))
            {
                $errs[] = "Новый пароль";
            }
            else if ($pwd != $pwd_again)
            {
                $errs[] = "Повторите новый пароль";
            }

            if (empty($errs))
            {
                $user->pwd = $pwd;
                $user->Flush();
           
                $user->MakeLogin();
                Header("Location: " . SiteRoot("user/pwd_recovery_done"));
                exit();
            }
        }
    }

    $msg = empty($errs) ? "" : MsgErr(implode("<br>", $errs));
?>