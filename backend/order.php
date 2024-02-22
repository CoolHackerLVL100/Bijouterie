<?php
    require_once 'connection.php';
    require_once 'order_model.php';
    require_once 'request.php';

    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: http://localhost:3000');
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Methods: DELETE, POST, GET, OPTIONS, PATCH, PUT');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    header('Access-Control-Max-Age: 86400');

    final class Order {
        public static function get_order(){
            try {
                Request::response(200, '', OrderModel::get(      
                    $_GET['id'],
                ));           
            } catch (Exception $e) {
                Request::response(500, $e->getMessage());
            } 
        }
        public static function get_orders(){
            try {
                Request::response(200, '', OrderModel::filter(      
                    // $_GET['type'],
                    // $_GET['min_price'],
                    // $_GET['max_price'],
                    // $_GET['gender'],
                    // $_GET['size'],
                    // $_GET['stones'],
                    // $_GET['materials'],
                ));           
            } catch (Exception $e) {
                Request::response(500, $e->getMessage());
            }
        }
        public static function add_product(){

        }
        public static function update_product(){

        }
        public static function delete_product(){
            
        }

        public static function backup_to_json(){
            if (check_token(true)){
                try {
                     
                    Request::response(200, '', OrderModel::toJSON());
                } catch (Exception $e) {
                    Request::response(500, $e->getMessage());
                }                
            } else {
                Request::response(403, 'Отсутствуют права доступа на данный ресурс');
            }  
        }

        public static function restore_from_json(){
            if (check_token(true)){
                try {
                     
                    Request::response(200, '', OrderModel::fromJSON());
                } catch (Exception $e) {
                    Request::response(500, $e->getMessage());
                }                
            } else {
                Request::response(403, 'Отсутствуют права доступа на данный ресурс');
            }  
        }
    }
