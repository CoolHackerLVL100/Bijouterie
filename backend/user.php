<?php
    require_once 'connection.php';
    require_once 'user_model.php';

    header('Content-Type: application/json; charset=utf-8');

    check_token();
    function not_found_response(){
        http_response_code(404);
        echo json_encode([
            'status' => 'Not Found'
        ]);
    }

    function not_authorized_response(){
        http_response_code(403);
        echo json_encode([
            'status' => 'Forbidden'
        ]);
    }

    function get_handler(){
        $uri = parse_url($_SERVER['REQUEST_URI']);
        $segments = explode('/', $uri['path']);

        if (isset($segments[5]) && is_numeric($segments[5])) {    
            if (check_token()){
                try {
                    http_response_code(200);
                    echo json_encode([
                        'status' => 'Ok',
                        'method' => 'GET',
                        'data' => UserModel::get(      
                            $_GET['id'],
                        )  
                    ]);            
                } catch (Exception $e) {
                    http_response_code(500);  
                    echo json_encode([
                        'status' => 'Internal Server Error',
                        'method' => 'GET',
                        'message' => $e->getMessage()
                    ]);
                }
            } else {
                not_authorized_response();
            }
        } else {
            if (check_token(true)){
                try {
                    http_response_code(200);
                    echo json_encode([
                        'status' => 'Ok',
                        'method' => 'GET',
                        'data' => UserModel::filter(      
                            $_GET['min_registration_date'],
                            $_GET['max_registration_date'],
                            $_GET['min_personal_stock'],
                            $_GET['max_personal_stock'],
                            $_GET['firstname'],
                            $_GET['lastname'],
                            $_GET['emailname'],
                            $_GET['gender']
                        )  
                    ]);            
                } catch (Exception $e) {
                    http_response_code(500);  
                    echo json_encode([
                        'status' => 'Internal Server Error',
                        'method' => 'GET',
                        'message' => $e->getMessage()
                    ]);
                }                
            } else {
                not_authorized_response();
            }
        }            
    }

    function post_handler(){
        $uri = parse_url($_SERVER['REQUEST_URI']);
        $segments = explode('/', $uri['path']);

        if (isset($segments[5]) && $segments[5] == 'auth') {
            try {
                http_response_code(200);
                echo json_encode([
                    'status' => 'Ok',
                    'method' => 'POST',
                    'data' => UserModel::auth(      
                        $_POST['login'],
                        $_POST['password']
                    )  
                ]);            
            } catch (Exception $e) {
                switch ($e->getCode()) {
                    case 401:
                        http_response_code(401);  
                        echo json_encode([
                            'status' => 'Unauthorized',
                            'method' => 'POST',
                            'message' => $e->getMessage()
                        ]);
                        break;
                    case 500:
                        http_response_code(500);  
                        echo json_encode([
                            'status' => 'Internal Server Error',
                            'method' => 'POST',
                            'message' => $e->getMessage()
                        ]);
                        break;
                }
            } 
        } elseif (isset($segments[5]) && $segments[5] == 'reg') {
            try {
                if (!isset($_POST['email']) || !isset($_POST['login']) || !isset($_POST['password']) || !isset($_POST['password_confirm']))
                    throw new Exception('Отсутствуют данные', 400);
                if ($_POST['password'] != $_POST['password_confirm'])
                    throw new Exception('Пароли не совпадают', 400);
                http_response_code(201);
                echo json_encode([
                    'status' => 'Created',
                    'method' => 'POST',
                    'data' => UserModel::register(      
                        $_POST['email'],
                        $_POST['login'],
                        $_POST['password']
                    )  
                ]);            
            } catch (Exception $e) {
                switch ($e->getCode()) {
                    case 400:
                        http_response_code(400);  
                        echo json_encode([
                            'status' => 'Bad Request',
                            'method' => 'POST',
                            'message' => $e->getMessage()
                        ]);
                        break;
                    case 409:
                        http_response_code(409);  
                        echo json_encode([
                            'status' => 'Conflict',
                            'method' => 'POST',
                            'message' => $e->getMessage()
                        ]);
                        break;
                    case 500:
                        http_response_code(500);  
                        echo json_encode([
                            'status' => 'Internal Server Error',
                            'method' => 'POST',
                            'message' => $e->getMessage()
                        ]);
                        break;
                }
            } 
        }
    }

    function put_handler(){
        http_response_code(200);
        echo json_encode([
            'status' => 'Ok',
            'method' => 'PUT'
        ]);        
    }

    function delete_handler(){
        http_response_code(200);
        echo json_encode([
            'status' => 'Ok',
            'method' => 'DELETE'
        ]);
    }

    switch ($_SERVER['REQUEST_METHOD']){ //checking of method
        case 'GET':
            get_handler();
            break;
        case 'POST':
            post_handler();
            break;
        case 'PUT':
            put_handler();  
            break;
        case 'DELETE':
            delete_handler();   
            break;
        default:
            not_found_response();
            
    }
?>