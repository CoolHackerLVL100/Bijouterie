<?php
    require_once 'user.php';
    require_once 'product.php';
    require_once 'resource.php';

    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, OPTIONS, DELETE');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    final class Router {
        private static $get_routes = [
            '/^\/Bijouterie\/backend\/api\/user\/$/' => ['User', 'get_users'], //get all users that satisfied conditions
            '/^\/Bijouterie\/backend\/api\/user\/([0-9]+)\/$/' => ['User', 'get_user'], //get some user 
            '/^\/Bijouterie\/backend\/api\/user\/([0-9]+)\/cart\/$/' => ['User', 'get_cart'], //get cart of user 
            '/^\/Bijouterie\/backend\/api\/product\/$/' => ['Product', 'get_products'], //get all products that satisfied conditions
            '/^\/Bijouterie\/backend\/api\/product\/([0-9]+)\/$/' => ['Product', 'get_product'], //get some product 
            '/^\/Bijouterie\/backend\/api\/order\/$/' => ['Order', 'get_orders'], //get all orders that satisfied conditions
            '/^\/Bijouterie\/backend\/api\/order\/([0-9]+)\/$/' => ['Order', 'get_order'], //get some order
            '/^\/Bijouterie\/backend\/api\/review\/$/' => ['Review', 'get_reviews'], //get all reviews that satisfied conditions
            '/^\/Bijouterie\/backend\/api\/review\/([0-9]+)\/$/' => ['Review', 'get_review'], //get some review 
            '/^\/Bijouterie\/backend\/api\/image\/([a-z]+)\/([a-zA-Z0-9_\-]+)\.([a-z]{2,5})$/' => ['Resource', 'get_image'], //get some image 
            '/^\/Bijouterie\/backend\/api\/font\/([a-zA-Z0-9_\-]+)\.([a-z]{2,5})$/' => ['Resource', 'get_font'], //get some font 
        ];
        private static $post_routes = [
            '/^\/Bijouterie\/backend\/api\/user\/auth\/$/' => ['User', 'auth_user'], //authorization of user
            '/^\/Bijouterie\/backend\/api\/user\/reg\/$/' => ['User', 'reg_user'], //registration of user 
        ];
        private static $put_routes = [
            '/^\/Bijouterie\/backend\/api\/user\/([0-9]+)\/cart\/([0-9]+)\/$/' => ['User', 'add_to_cart'],
        ];
        private static $patch_routes = [
            '/^\/Bijouterie\/backend\/api\/user\/([0-9]+)\/$/' => ['User', 'edit_user'],
        ];
        private static $delete_routes = [
            '/^\/Bijouterie\/backend\/api\/user\/([0-9]+)\/$/' => ['User', 'remove'],
            '/^\/Bijouterie\/backend\/api\/user\/([0-9]+)\/cart\/([0-9]+)\/$/' => ['User', 'remove_from_cart'], //remove item from cart of user
        ];
        public static function go($route){
            $routes = [];
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    $routes = static::$get_routes;
                    break;
                case 'POST':
                    $routes = static::$post_routes;
                    break;
                case 'PUT':
                    $routes = static::$put_routes;
                    break;
                case 'PATCH':
                    $routes = static::$patch_routes;
                    break;
                case 'DELETE':
                    $routes = static::$delete_routes;
                    break;
                case 'OPTIONS':
                    echo 'OK';
                    Request::response(200, '');
                    return;
                default:
                    Request::response(404, 'Ресурс не найден');
                
            }
            foreach ($routes as $key => $value) {
                if(preg_match($key, $route)){
                    call_user_func($value);
                    exit();
                }
            }
            Request::response(404, 'Ресурс не найден');
        }
    }