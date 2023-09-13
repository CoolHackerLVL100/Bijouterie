<?php
    require_once "database.php";
    require_once "admin_connect.php";

    class AbstractModel {
        protected $table_name = NULL;
        protected $id = NULL;
        
        public function select($connection, $conditions = NULL, $group_by = NULL, $order_by = NULL){
            $query = 'SELECT * FROM '.$this->$table_name;

            if ($conditions){
                $query .= ' WHERE ';          
                
                $query .= implode($conditions, ' AND '); //joins array 'conditions' with separator 'AND'
            }

            if ($group_by){
                $query .= ' GROUP BY '.$group_by;
            }

            if ($order_by){
                $query .= ' ORDER BY '.$order_by;
            }

            return Database::query($connection, $query);          
        }

        public function insert($connection, $values){ //inserts one value with all arguments of table (id skipped)
            $query = 'INSERT INTO '.$this->$table_name.' VALUES (DEFAULT, \'';
            
            $query .= implode($values, '\', \'');

            $query .= '\')';
                    
            return Database::query($query);
        }

        public function update($connection, $values, $conditions=NULL){
            $query = 'UPDATE '.$this->$table_name.' SET ';

            foreach ($values as $key => $value){
                $query .= $key.'=\''.$value.'\', ';
            }

            $query = rtrim($query, ', ');

            if ($conditions){
                $query .= ' WHERE ';          
                
                $query .= implode($conditions, ' AND '); 
            }

            return Database::query($connection, $query);
        }

        public function delete($connection, $conditions=NULL){
            $query = 'DELETE FROM '.$this->$table_name;

            if ($conditions){
                $query .= ' WHERE ';          
                
                $query .= implode($conditions, ' AND '); 
            }

            return Database::query($connection, $query);     
        }
    }
?>