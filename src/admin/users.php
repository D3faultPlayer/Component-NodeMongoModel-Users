<?php

    IncludeCom("admin/node_model/list", array
                                        (
                                            "table"  => array("photo", "email", "name"),
                                            "class"  => "UserMongoModel",
                                        ));
?>