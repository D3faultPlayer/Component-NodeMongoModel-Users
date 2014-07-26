<?php

    function UserMongoPwdRecoveryHash($login, $pwd_hash)
    {
        global $g_config;
        return md5($login . "@@@" . $pwd_hash . $g_config['user_mongo_model']['pwd_recovery_salt']);
    }
?>