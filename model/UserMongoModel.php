<?php

    define("SEX_NONE",   1);
    define("SEX_MALE",   2);
    define("SEX_FEMALE", 3);

    class UserMongoModel extends NodeMongoModel
    {
        const REMEMBER_PERIOD = 604800; // Время хранения авторизации (в секундах)

        public function __construct($id = NULL, $onlyShow = false, $lang = LANG)
        {
            parent::__construct("users", $id, $onlyShow, $lang); // Базовый констуктор всегда вызываем самым первым

            // Авторизация возможно либо через почту либо телефон
            $this->NInit('email', NT_CONST, 'Почта');
            //$this->NInit('phone', NT_CONST, 'Телефон');

            $this->NVirtInit('pwd', NT_CONST, "Пароль");

            $this->NInit('name',  NT_CONST, 'Имя');
            $this->NInit('photo', NT_IMG,   'Фото');

            $this->NInit('_pwd_hash', NT_CONST, 'Хэш пароля');

            $this->NInit('sex', NT_ENUM, 'Пол');
            $this->NInitEnum('sex', SEX_NONE,   'Не указан');
            $this->NInitEnum('sex', SEX_MALE,   'Мужской');
            $this->NInitEnum('sex', SEX_FEMALE, 'Женский');

            $this->NInit('birthday',    NT_DATE, 'Дата рождения');
            $this->NInit('about',       NT_TEXT, 'О себе');

            $this->NInit('_added',      NT_UDATE, 'Добавлен');
            $this->NInit('_modified',   NT_UDATE, 'Изменен');

            $this->NInit('_last_login', NT_UDATE, 'Последняя авторизация');

            $this->NSetClassTitle('Пользователи'); // Не обязательно, но пригодится для админки
        }

        protected function NGetVirt($name, $index)
        {
            if ($name == "birthyear")
            {
                if ($this->birthday == "")
                {
                    return false;
                }
                else
                {
                    list($y, $m, $d) = sscanf($this->birthday, "%d-%d-%d");
                    return $y;
                }
            }
            if ($name == "visible_name")
            {
                return $this->name == "" ? $this->email : $this->name;
            }
            if ($name == "pwd")
            {
                return "";
            }
            return parent::NGetVirt($name, $index);
        }

        protected function NSetVirt($name, $index, $value)
        {
            if ($name == "pwd")
            {
                if (!empty($value))
                {
                    $this->_pwd_hash = $this->MakeHash($value);
                }
                return true;
            }
            if ($name == "visible_name")
            {
                trigger_error("You can't set login directly!", E_USER_ERROR);
            }
            return parent::NSetVirt($name, $index, $value);
        }
        
        public function NOnFirstSave()
        {
            $this->_added = time();
        }

        public function NOnSave()
        {
            $this->_modified = time();
        }

        public function MakeHash($pwd)
        {
            global $g_config;
            return md5($pwd . $g_config['user_mongo_model']['salt']);
        }

        public function GetUserIdByLogin($login)
        {
            if (empty($login)) return false;

            $total = 0;
            $list = $this->Find($total, array('email' => $login));
            return empty($list) ? false : $list[0];
        }

        // Получить user_id текущего залогиненного пользователя если возможно, в случаи неудачи вернёт false
        public function GetCurUserId()
        {
            global $g_config;

            $email    = isset($_COOKIE['auto_auth_login'])    ? $_COOKIE['auto_auth_login']    : '';
            $pwd_hash = isset($_COOKIE['auto_auth_pwd_hash']) ? $_COOKIE['auto_auth_pwd_hash'] : '';
            $ret      = false;
            $uid      = $this->GetUserIdByLogin($email);
            if ($uid)
            {
                $u   = new self($uid, true);
                $ret = $u->email == $email && $u->_pwd_hash == $pwd_hash ? $uid : false;
            }
            return $ret;
        }

        public function GetCurUser()
        {
            return new self($this->GetCurUserId());
        }

        // Проверка занятости логина
        public function IsLoginBusy($login)
        {
            return $this->GetUserIdByLogin($login) !== false;
        }

        // Авторизован ли текущей юзер
        public function IsAuth()
        {
            return $this->GetCurUserId() ? true : false;
        }

        // Авторизует пользователя, что бы при будущих обращениях он проходил как авторизованный при успехе вернёт true и запомнит что авторизован, иначе false
        public function MakeLogin()
        {
            if (!$this->IsExists())
            {
                trigger_error("User is not exists!", E_USER_ERROR);
            }
            $this->_last_login = time();
            $this->Flush();
            setcookie('auto_auth_login',    $this->email,     time() + self::REMEMBER_PERIOD, '/', DOMAIN_COOKIE);
            setcookie('auto_auth_pwd_hash', $this->_pwd_hash, time() + self::REMEMBER_PERIOD, '/', DOMAIN_COOKIE);
            $_COOKIE['auto_auth_login']    = $this->email;
            $_COOKIE['auto_auth_pwd_hash'] = $this->_pwd_hash;
        }

        public function MakeLogout()
        {
            setcookie('auto_auth_login',    '', -1, '/', DOMAIN_COOKIE);
            setcookie('auto_auth_pwd_hash', '', -1, '/', DOMAIN_COOKIE);
        }
    };
?>