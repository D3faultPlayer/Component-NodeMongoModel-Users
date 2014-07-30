<?php

    $userModel = new UserMongoModel();
    $user      = $userModel->GetCurUser();

    if (!$user->IsExists())
    {
        Header("Location: " . SiteRoot("404"));
        exit(0);
    }

    $msg = "";
    if (Post('is_save'))
    {
        $pwd      = trim(Post('pwd'));
        $name     = trim(Post('name'));
        $sex      = intval(Post('sex'));
        $birthday = Post('birthday');

        $errs = array();

        if (empty($name))
        {
            $errs[] = "Некорректное или пустое имя";
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
            if (!empty($pwd))
            {
                $user->pwd = $pwd;
            }
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
                $msg = MsgOK("Данные успешно сохранены");
                if (!empty($pwd))
                {
                    $user->MakeLogin();
                }
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
