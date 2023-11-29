<?php
    require_once 'router.php';

    header('Access-Control-Allow-Origin: http://localhost:3000');

    Router::go(parse_url($_SERVER['REQUEST_URI'])['path']);

