<?php
    require_once 'database.php';
    require_once 'connection.php';
    require_once 'request.php';

    final class Resource {
        public static function get_image(){
            $segments = explode('/', parse_url($_SERVER['REQUEST_URI'])['path']);
            $image_name = './images/' . $segments[5] . '/' . $segments[6];
            $extension = explode('.', $segments[6])[1];

            header('Content-Type: image/' . $extension);
            header("Content-Length: " . filesize($image_name));

            $file = fopen($image_name, 'rb');
            fpassthru($file);  
        }
        public static function get_font(){
            $segments = explode('/', parse_url($_SERVER['REQUEST_URI'])['path']);
            $font_name = './fonts/' . $segments[5];

            header('Content-Type: font/ttf');
            header("Content-Length: " . filesize($font_name));
            header('Content-Disposition: inline; filename="' . basename($font_name) . '"');

            readfile($font_name); 
        }

        public static function get_gallery(){
            global $user_connect;

            try {
                $result = Database::query($user_connect, 'SELECT * FROM public.gallery');   

                if (!$result)
                    throw new Exception('Ошибка запроса');

                Request::response(200, '', 
                    Database::fetch_all($result)
                );    
            } catch (Exception $e){
                Request::response(500, $e->getMessage());
            }
            
        }
    }

