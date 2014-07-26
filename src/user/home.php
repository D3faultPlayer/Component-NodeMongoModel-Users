<?php

    $userModel  = new UserMongoModel();

    if (!$userModel->IsAuth())
    {
        header("Location: " . $g_config['user_mongo_model']['after_logout_page']);
        exit(0);
    }
?>