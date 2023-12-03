<?php
    require_once 'connection.php';
    require_once 'user_model.php';
    require_once 'request.php';

    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: http://localhost:3000');
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Methods: DELETE, POST, GET, OPTIONS, PATCH, PUT');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    header('Access-Control-Max-Age: 86400');

    final class User {
        public static function get_user(){
            if (check_token()){
                try {
                    Request::response(200, '', UserModel::get(      
                        $_GET['id'],
                    ));
                } catch (Exception $e) {
                    Request::response(500, $e->getMessage());
                }
            } else {
                Request::response(401, 'Отсутствуют права доступа на данный ресурс');
            }
        }
        public static function get_users(){
            if (check_token(true)){
                try {
                    Request::response(200, '', UserModel::filter(      
                        $_GET['min_registration_date'],
                        $_GET['max_registration_date'],
                        $_GET['min_personal_stock'],
                        $_GET['max_personal_stock'],
                        $_GET['firstname'],
                        $_GET['lastname'],
                        $_GET['emailname'],
                        $_GET['gender']
                    ));          
                } catch (Exception $e) {
                    Request::response(500, $e->getMessage());
                }                
            } else {
                Request::response(401, 'Отсутствуют права доступа на данный ресурс');
            }
        }
        public static function get_cart(){
            if (check_token()){
                try {
                    Request::response(200, '', UserModel::get_cart(      
                        $_GET['id'],
                    ));          
                } catch (Exception $e) {
                    Request::response(500, $e->getMessage());
                }                
            } else {
                Request::response(401, 'Отсутствуют права доступа на данный ресурс');
            }            
        }
        public static function add_to_cart(){
            if (check_token()){
                try {
                    Request::response(201, '', UserModel::add_to_cart(      
                        $_GET['user_id'],
                        $_GET['product_id']
                    ));          
                } catch (Exception $e) {
                    Request::response(500, $e->getMessage());
                }                
            } else {
                Request::response(401, 'Отсутствуют права доступа на данный ресурс');
            }      
        }
        public static function remove_from_cart(){
            if (check_token()){
                try {
                    Request::response(200, '', UserModel::remove_from_cart(      
                        $_GET['user_id'],
                        $_GET['product_id']
                    ));          
                } catch (Exception $e) {
                    Request::response(500, $e->getMessage());
                }                
            } else {
                Request::response(401, 'Отсутствуют права доступа на данный ресурс');
            }            
        }
        public static function auth_user(){
            try {
                Request::response(200, '', UserModel::auth(      
                    $_POST['login'],
                    $_POST['password']
                ));          
            } catch (Exception $e) {
                Request::response($e->getCode(), $e->getMessage());
            } 
        }
        public static function reg_user(){
            try {
                Request::response(201, '', UserModel::register(      
                    $_POST['email'],
                    $_POST['login'],
                    $_POST['password']
                ));           
            } catch (Exception $e) {
                Request::response($e->getCode(), $e->getMessage());
            } 
        }
        public static function edit_user(){
            if (check_token()){    
                $_PATCH = json_decode(file_get_contents('php://input'), true);

                echo file_get_contents('php://input');
                try {
                    Request::response(200, '', UserModel::edit(
                        $_GET['id'],
                        $_PATCH['firstname'],
                        $_PATCH['lastname'],
                        $_PATCH['gender'],
                        $_PATCH['email']
                    ));
                } catch (Exception $e) {
                    Request::response(500, $e->getMessage());
                }
            } else {
                Request::response(401, 'Отсутствуют права доступа на данный ресурс');
            }
        }
        public static function remove_user(){
            if (check_token(true)){
                try {
                    Request::response(200, '', UserModel::remove(      
                        $_GET['user_id']
                    ));          
                } catch (Exception $e) {
                    Request::response(500, $e->getMessage());
                }                
            } else {
                Request::response(403, 'Отсутствуют права доступа на данный ресурс');
            }  
        }
        private static function validate(){
            if (!isset($_POST['email']) || !isset($_POST['login']) || !isset($_POST['password']) || !isset($_POST['password_confirm'])) //validation
                throw new Exception('Отсутствуют данные', 400);

            if ($_POST['email'] == '' || $_POST['login'] == '' || $_POST['password'] == '' || $_POST['password_confirm'] == '') //validation
                throw new Exception('Отсутствуют данные', 400);

            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
                throw new Exception('Некорректный Email', 400);

            if (!preg_match('/^([a-zA-Z\-_0-9.])+$/', $_POST['login']))
                throw new Exception('Логин содержит недопустимые символы', 400);

            if (strlen($_POST['login']) < 3 || strlen($_POST['login']) > 20)
                throw new Exception('Длина логина должна составлять от 3 до 20 символов', 400);

            if (!preg_match('/^([a-zA-Z\-_0-9.])+$/', $_POST['password']))
                throw new Exception('Пароль содержит недопустимые символы', 400);

            if (strlen($_POST['password']) < 8 || strlen($_POST['password']) > 30)
                throw new Exception('Длина пароля должна составлять от 8 до 30 символов', 400);

            if ($_POST['password'] != $_POST['password_confirm'])
                throw new Exception('Пароли не совпадают', 400);
        }
    }