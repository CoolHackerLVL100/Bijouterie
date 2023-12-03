<?php
    require_once 'abstract_model.php';
    require_once 'jwt.php';

    final class UserModel extends AbstractModel {
        public static function get($id){
            global $user_connect; 

            $result = static::select('public.user', $user_connect, [
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

            return Database::fetch_all($result)[0];
        }
        public static function filter($min_registration_date, $max_registration_date, $min_personal_stock, $max_personal_stock, $firstname, $lastname, $email, $gender){
            global $admin_connect; 
            
            if ($min_registration_date == '')
                $min_registration_date = '\'2020-01-01\'';

            if ($max_registration_date == '')
                $max_registration_date = 'CURRENT_DATE';

            if ($min_personal_stock == '')
                $min_personal_stock = '0';

            if ($max_personal_stock == '')
                $max_personal_stock = '1';

            $result = static::select('public.user', $admin_connect, [
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
        public static function get_cart($id){
            global $user_connect; 

            $result = static::select('public.user', $user_connect, [
                'public.product.id', 
                'public.product.name', 
                'price', 
                'photo', 
            ], [
                'user_id = ' . $id
            ], [
                ['public.cart', 'INNER', 'public.user.id', 'public.cart.user_id'],
                ['public.product', 'INNER', 'public.product.id', 'public.cart.product_id']
            ]);

            if (!$result)
                throw new Exception('Ошибка запроса');

            return Database::fetch_all($result);          
        } 
        public static function add_to_cart($user_id, $product_id){
            global $user_connect; 

            $result = static::insert('public.cart', $user_connect, [
                'user_id', 
                'product_id'
            ], [
                $user_id,
                $product_id
            ]);

            if (!$result)
                throw new Exception('Ошибка запроса');

            return Database::fetch_all($result);
        }
        public static function remove_from_cart($user_id, $product_id){
            global $user_connect; 

            $result = static::delete('public.cart', $user_connect, [
                'user_id = ' . $user_id,
                'product_id = ' . $product_id
            ]);

            if (!$result)
                throw new Exception('Ошибка запроса');

            return Database::fetch_all($result);
        }
        public static function remove($user_id, $product_id){
            global $admin_connect; 

            $result = static::delete('public.user', $admin_connect, [
                'id = ' . $user_id
            ]);

            if (!$result)
                throw new Exception('Ошибка запроса');

            return Database::fetch_all($result);
        }
        public static function auth($login, $password){
            global $user_connect;

            $result = static::select('public.user', $user_connect, [
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
            setcookie('id', $result[0]['id'], time() + $expiration, '/');

            return [
                'id' => $result[0]['id'],
                'token' => $token
            ];
        }
        public static function register($email, $login, $password){
            global $user_connect;

            $check = static::select('public.user', $user_connect, [
                'id'
            ], [
                'login = \'' . $login . '\' OR email = \'' . $email . '\''
            ]);

            if (!$check)
                throw new Exception('Ошибка запроса', 500);

            $check = Database::fetch_all($check);

            if (sizeof($check)) //login and password not matched
                throw new Exception('Пользователь с данным логином или электронной почтой уже существует', 409);

            $result = static::insert('public.user', $user_connect, [
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