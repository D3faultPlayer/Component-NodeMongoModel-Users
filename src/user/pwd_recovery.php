<?php

    // ! Зависимый компонент sendmail_tpl
    // + Нужно задать SITE_ROOT полный (впрочем как и для sendmail_tpl)

    $userModel = new UserMongoModel(NULL, true);

    if ($userModel->IsAuth())
    {
        header("Location: " . $g_config['user_mongo_model']['after_login_page']);
        exit();
    }

    $msg = '';
    $success = false;

    if (Post('is_restore'))
    {
        $login   = trim(Post('login'));
        
        $user_id = $userModel->GetUserIdByLogin($login);
        $user = new UserMongoModel($user_id);

        if ($user->IsExists())                                      
        {
            $msg = MsgOk("Проверьте почту, Вы должны были получить письмо. Следуйте инструкциям указанным в письме.");
            $success = true;
            $_POST = array();

            $hash = UserMongoPwdRecoveryHash($user->email, $user->_pwd_hash);
            $link = SiteRoot("user/pwd_recovery_run&user_id={$user->_id}&hash={$hash}");

            if ($link) // Дополнительно проверяем полный у нас URL или относительный (что недопустимо)
            {
                $l = parse_url($link);
                if (empty($l['host']))
                {
                    trigger_error("Invalid restore pwd url '{$link}'! In file core/config/main.php set define('SITE_ROOT', 'http://DOMAIN_NAME/');", E_USER_ERROR);
                }
            }

            $linkStr = "<a target='_blank' href='{$link}'>{$link}</a>";

            $title  = "Восстановление пароля";
            $isSend = SendMailTpl('_email_tpls/default', array
                                                         (
                                                             "title" => $title,
                                                             "text"  => "<p>
                                                                            От вашего имени был сделан запрос на восстановление пароля. 
                                                                            Если вы не желаете восстановить пароль, то просто игнорируйте это письмо.<br />\n<br />\n
                                                                            Для восстановления пароля перейдите по ссылке:
                                                                         </p>\n" . $linkStr,
                                                         ), 
                                                         $user->email, 
                                                         $title
                                  );

        }
        else
        {
            $msg = "Неверный e-mail";
        }
    }
?>