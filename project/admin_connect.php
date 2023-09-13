<?php
    require_once "database.php";

    class Admin {
        $connection = NULL;

        public function __construct() {
            $this->$connection = Database::connect("localhost", "5432", "db_bijouterie", "admin", "admin");    
        }
        
    }

?>