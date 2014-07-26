<?php

    $userModel  = new UserMongoModel();

    $user = new UserMongoModel();
    if (Get("id") != "")
    {
        $user = new UserMongoModel(Get("id"), true);
    }
    else if ($userModel->IsAuth())
    {
        $user = $userModel->GetCurUser();
    }

    if (!$user->IsExists())
    {
        header("Location: " . $g_config['user_mongo_model']['after_logout_page']);
        exit(0);
    }

    // Ширина и высота аватара
    $aw = 256;
    $ah = 256;
?>