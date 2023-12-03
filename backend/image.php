<?php
    require_once 'connection.php';
    require_once 'product_model.php';

    header('Access-Control-Allow-Origin: http://localhost:3000');
    
    $uri = parse_url($_SERVER['REQUEST_URI']);
    $segments = explode('/', $uri['path']);
    $image_name = './images/' . $segments[5] . '/' . $segments[6];

    $extension = explode('.', $segments[6])[1];

    header('Content-Type: image/' . $extension);
    header("Content-Length: " . filesize($image_name));
    header('Access-Control-Allow-Origin: http://localhost:3000');

    $file = fopen($image_name, 'rb');
    fpassthru($file);  
?>