<?php
    
    ob_start();
        IncludeCom($g_config['user_mongo_model']['main_tpl'], array('content' => $content));
    $content = ob_get_clean();
    
    ob_start();
        IncludeCom($g_config['mainTplBasic'], array('content' => $content));
    $content = ob_get_clean();
    
    echo $content;
?>