<?php
    require_once 'connection.php';
    require_once 'product_model.php';
    require_once 'request.php';

    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: http://localhost:3000');

    final class Product {
        public static function get_product(){
            try {
                Request::response(200, '', ProductModel::get(      
                    $_GET['id'],
                ));           
            } catch (Exception $e) {
                Request::response(500, $e->getMessage());
            } 
        }
        public static function get_products(){
            try {
                Request::response(200, '', ProductModel::filter(      
                    $_GET['type'],
                    $_GET['min_price'],
                    $_GET['max_price'],
                    $_GET['gender'],
                    $_GET['size'],
                    $_GET['stones'],
                    $_GET['materials'],
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
                     
                    Request::response(200, '', ProductModel::toJSON());
                } catch (Exception $e) {
                    Request::response(500, $e->getMessage());
                }                
            } else {
                Request::response(403, 'Отсутствуют права доступа на данный ресурс');
            }  
        }
    }
