<?php
    require_once 'connection.php';
    require_once 'product_model.php';

    $uri = parse_url($_SERVER['REQUEST_URI']);
    $segments = explode('/', $uri['path']);
    $font_name = './fonts/' . $segments[5];

    header('Content-Type: font/ttf');
    header("Content-Length: " . filesize($font_name));
    header('Content-Disposition: inline; filename="' . basename($font_name) . '"');
    header('Access-Control-Allow-Origin: http://localhost:3000');

    readfile($font_name);  
?>