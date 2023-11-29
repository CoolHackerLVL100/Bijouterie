<?php
    require_once 'abstract_model.php';
    require_once 'jwt.php';

    final class UserModel extends AbstractModel {
        protected static $table_name = 'public.user';
        public static function get($id){
            global $user_connect; 

            $result = static::select($user_connect, [
                'id', 
                'is_admin', 
                'registration_date', 
                'personal_stock', 
                'firstname', 
                'lastname', 
                'email', 
                'gender', 
                'avatar'
            ], [
                'id = ' . $id
            ]);

            if (!$result)
                throw new Exception('Ошибка запроса');

            return Database::fetch_all($result);
        }
        public static function filter($min_registration_date, $max_registration_date, $min_personal_stock, $max_personal_stock, $firstname, $lastname, $email, $gender){
            global $user_connect; 
            
            if ($min_registration_date == '')
                $min_registration_date = '\'2020-01-01\'';

            if ($max_registration_date == '')
                $max_registration_date = 'CURRENT_DATE';

            if ($min_personal_stock == '')
                $min_personal_stock = '0';

            if ($max_personal_stock == '')
                $max_personal_stock = '1';

            $result = static::select($user_connect, [
                'id', 
                'is_admin', 
                'registration_date', 
                'personal_stock', 
                'firstname', 
                'lastname', 
                'email', 
                'gender', 
                'avatar'
            ], [
                'registration_date BETWEEN ' . $min_registration_date . ' AND ' . $max_registration_date,
                'personal_stock BETWEEN ' . $min_personal_stock . ' AND ' . $max_personal_stock,
                $firstname != '' ? 'firstname = \'' . $firstname . '\'' : NULL,
                $lastname != '' ? 'lastname = \'' . $lastname . '\'' : NULL,
                $email != '' ? 'email = \'' . $email . '\'' : NULL,
                $gender != '' ? 'gender = \'' . $gender . '\'' : NULL
            ]);

            if (!$result)
                throw new Exception('Ошибка запроса');

            return Database::fetch_all($result);
        }
        public static function auth($login, $password){
            global $user_connect;

            $result = static::select($user_connect, [
                'id', 
                'is_admin',
            ], [
                'login = \'' . $login . '\'',
                'password = md5(\'' . $password . '\')'
            ]);

            if (!$result)
                throw new Exception('Ошибка запроса', 500);

            $result = Database::fetch_all($result);

            if (!sizeof($result)) //login and password not matched
                throw new Exception('Неверные данные для входа', 401);

            $expiration = 86400; //token lives 24h
            $token = create_token($result[0], $expiration); //jwt token creation
            setcookie('jwt', $token, time() + $expiration, '/');

            return [
                'id' => $result[0]['id'],
                'token' => $token
            ];
        }
        public static function register($email, $login, $password){
            global $user_connect;

            $check = static::select($user_connect, [
                'id'
            ], [
                'login = \'' . $login . '\' OR email = \'' . $email . '\''
            ]);

            if (!$check)
                throw new Exception('Ошибка запроса', 500);

            $check = Database::fetch_all($check);

            if (sizeof($check)) //login and password not matched
                throw new Exception('Пользователь с данным логином или электронной почтой уже существует', 409);

            $result = static::insert($user_connect, [
                'is_admin',
                'login',
                'password',
                'registration_date',
                'personal_stock',
                'firstname',
                'lastname',
                'email',
                'gender',
                'avatar'
            ], [
                'false',
                '\'' . $login . '\'',
                'md5(\'' . $password . '\')',
                'CURRENT_DATE',
                '0',
                'NULL',
                'NULL',
                '\'' . $email . '\'',
                '\'u\'',
                'NULL'
            ]);

            if (!$result)
                throw new Exception('Ошибка запроса', 500);

            return true;
        }
    }
?>