<?php 

    class Request {
        private static $status = [
            200 => 'Ok',
            201 => 'Created',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            409 => 'Conflict',
            500 => 'Internal Server Error'
        ];
        public static function response($code, $message, $data = NULL){
            http_response_code($code);
            echo json_encode([
                'status' => static::$status[$code],
                'method' => $_SERVER['REQUEST_METHOD'],
                'message' => $message,
                'data' => $data
            ]);
        }
    }

?>