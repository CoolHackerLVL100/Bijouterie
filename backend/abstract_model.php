<?php
    require_once 'database.php';
    require_once 'connection.php';
    class AbstractModel {
        protected static $table_name = NULL;
        protected static function select($connection, $fields, $conditions = NULL, $joins = NULL, $group_by = NULL, $having = NULL, $order_by = NULL){
            $query = 'SELECT ';

            if ($fields == '*'){
                $query .= '*';
            } else {
                $query .= implode(', ', $fields); //joins array 'fields' with separator ','
            }
            
            $query .= ' FROM ' . static::$table_name;

            if($joins){ //[table, join_type, left_argument, right_argument]
                foreach ($joins as $join){
                    $query .= ' ' . $join[1] . ' JOIN ' . $join[0] . ' ON ' . $join[2] . '=' . $join[3];
                }
            }

            if ($conditions){
                $conditions = array_filter($conditions);

                if (sizeof($conditions) > 0) {
                    $query .= ' WHERE ' . implode(' AND ', $conditions); //joins array 'conditions' with separator 'AND'    
                }      
            }

            if ($group_by){
                $query .= ' GROUP BY ' . $group_by;
            }

            if($having){
                $having = array_filter($having);

                if (sizeof($having) > 0){
                    $query .= ' HAVING ' . implode(' AND ', $having);
                }   
            }

            if ($order_by){
                $query .= ' ORDER BY ' . $order_by;
            }

            //file_put_contents('./log_'.date("j.n.Y").'.log', $query, FILE_APPEND);

            return Database::query($connection, $query);          
        }
        protected static function insert($connection, $fields, $values){ //inserts one value with all arguments of table (id skipped)
            $query = 'INSERT INTO ' . static::$table_name . ' (';

            $query .= implode(', ', $fields) . ') VALUES (';
            
            $query .= implode(', ', $values) . ')';
                    
            return Database::query($connection, $query);
        }
        protected static function update($connection, $values, $conditions=NULL){
            $query = 'UPDATE ' . static::$table_name . ' SET ';

            foreach ($values as $key => $value){
                $query .= $key . '=\'' . $value . '\', ';
            }

            $query = rtrim($query, ', ');

            if ($conditions){
                $query .= ' WHERE ';          
                
                $query .= implode($conditions, ' AND '); 
            }

            return Database::query($connection, $query);
        }
        protected static function delete($connection, $conditions=NULL){
            $query = 'DELETE FROM ' . static::$table_name;

            if ($conditions){
                $query .= ' WHERE ';          
                
                $query .= implode($conditions, ' AND '); 
            }

            return Database::query($connection, $query);     
        }
    }
?>