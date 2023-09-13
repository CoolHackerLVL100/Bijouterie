<?php
    require_once "abstract_model.php";

    final class ProductModel extends AbstractModel {
        private $table_name = 'Product';        
        private $name = NULL;
        private $type = NULL;
        private $manufacturer = NULL;
        private $count = NULL;
        private $price = NULL;
        private $photo = NULL;
        private $gender = NULL;
        private $weight = NULL;

        public __construct(){

        }
    }
?>