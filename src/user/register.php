<?php

    $userModel = new UserMongoModel();

    if ($userModel->IsAuth())
    {
        Header("Location: " . $g_config['user_mongo_model']['after_login_page']);
        exit();
    }

    $msg = "";
    if (Post('is_reg'))
    {
        $email    = trim(Post('email'));
        $pwd      = trim(Post('pwd'));
        $name     = trim(Post('name'));
        $sex      = intval(Post('sex'));
        $birthday = Post('birthday');

        $errs = array();

        if (empty($email))
        {
            $errs[] = "Некорректный или пустой E-mail";
        }
        else if ($userModel->GetUserIdByLogin($email))
        {
            $errs[] = "E-mail уже занят";
        }

        if (empty($pwd))
        {
            $errs[] = "Вы не ввели пароль";
        }

        if (empty($name))
        {
            $errs[] = "Вы не ввели имя";
        }
        $enums = $userModel->GetEnums('sex');
        if (!isset($enums[$sex]))
        {
            $errs[] = "Некорректный пол";
        }
        if (!empty($birthday))
        {
            list($y, $m, $d) = sscanf($birthday, "%d-%d-%d");
            if ($y >= date("Y"))
            {
                $errs[] = "Некорректный год рождения";
            }
        }
        $uploader = new Uploader();
        if ($uploader->HasUpload("photo_file"))
        {
            $isUpload = $uploader->Upload(
                             "photo_file",
                             array
                             (
                                 'upload_path'  => BASEPATH . $g_config['node_model']['upl_file_path'],
                                 'encrypt_name' => true
                             )
                        );
            if ($isUpload)
            {
                $inf = $uploader->GetInf();
                $_POST["photo"] = $inf['file_name'];
            }
            else
            {
                $emsg = implode(", ", $uploader->error_msg);
                $errs[] = "Не удалось загрузить фотографию: " . $emsg;
            }
        }
        if (empty($errs))
        {
            $user = new UserMongoModel();
            $user->email    = $email;
            $user->pwd      = $pwd;
            $user->name     = $name;
            $user->sex      = $sex;
            $user->birthday = $birthday;

            $user->about   = trim(Post("about"));

            if (Post("photo_remove") == "on")
            {
                $user->photo = NULL;
                unset($_POST["photo"]);
                unset($_POST["photo_remove"]);
            }
            else
            {
                $user->photo = Post("photo");
            }

            $uid = $user->Flush();
            if ($uid)
            {
                //$msg = MsgOK("Данные успешно сохранены");
                $user->MakeLogin();
                Header("Location: " . SiteRoot("user/register_done"));
                exit();
            }
            else
            {
                $msg = MsgErr("Неизвестная ошибка. Обратитесь к администратору");
            }
        }
        else
        {
            $msg = MsgErr(implode('<br>', $errs));
        }
    }

    // Ширина и высота аватара
    $aw = 256;
    $ah = 256;
?>
