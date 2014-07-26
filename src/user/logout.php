<?php

    $user = new UserMongoModel(NULL, true);
    $user->MakeLogout();

    header("Location: " . $g_config['user_mongo_model']['after_logout_page']);
    exit();
?>