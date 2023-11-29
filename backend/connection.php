<?php
    require_once 'database.php';

    global $user_connect; 
    $user_connect = Database::connect('localhost', '5432', 'db_bijouterie', 'User', 'user'); //connection for user-provided operations

    global $admin_connect; 
    $admin_connect = Database::connect('localhost', '5432', 'db_bijouterie', 'Admin', 'admin'); //connection for admin-provided operations
?>