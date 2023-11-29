<?php
    require_once 'connection.php';
    require_once 'product_model.php';

    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: http://localhost:3000');

    function not_found_response(){
        http_response_code(404);
        echo json_encode([
            'status' => 'Not Found'
        ]);
    }

    function get_handler(){
        $uri = parse_url($_SERVER['REQUEST_URI']);
        $segments = explode('/', $uri['path']);

        if (isset($segments[5]) && is_numeric($segments[5])) {
            try {
                http_response_code(200);
                echo json_encode([
                    'status' => 'Ok',
                    'method' => 'GET',
                    'data' => ProductModel::get(      
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
            try {
                http_response_code(200);
                echo json_encode([
                    'status' => 'Ok',
                    'method' => 'GET',
                    'data' => ProductModel::filter(      
                        $_GET['type'],
                        $_GET['min_price'],
                        $_GET['max_price'],
                        $_GET['gender'],
                        $_GET['size'],
                        $_GET['stones'],
                        $_GET['materials'],
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
        }
    }

    function post_handler(){
        http_response_code(200);
        echo json_encode([
            'status' => 'Ok',
            'method' => 'POST'
        ]);
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