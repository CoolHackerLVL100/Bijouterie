<?php
    require_once 'database.php';
    require_once 'connection.php';
    class AbstractModel {
        protected static function select($table_name, $connection, $fields, $conditions = NULL, $joins = NULL, $group_by = NULL, $having = NULL, $order_by = NULL, $limit = NULL, $offset = NULL) {
            $query = 'SELECT ';

            if ($fields == '*'){
                $query .= '*';
            } else {
                $query .= implode(', ', $fields); //joins array 'fields' with separator ','
            }
            
            $query .= ' FROM ' . $table_name;

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

            if ($limit){
                $query .= ' LIMIT ' . $limit;
            }

            if ($offset){
                $query .= ' OFFSET ' . $offset;
            }

            //file_put_contents('./log_'.date("j.n.Y").'.log', $query . "\n", FILE_APPEND);

            return Database::query($connection, $query);          
        }
        protected static function insert($table_name, $connection, $fields, $values){ //inserts one value with all arguments of table (id skipped)
            $query = 'INSERT INTO ' . $table_name . ' (';

            $query .= implode(', ', $fields) . ') VALUES (';
            
            $query .= implode(', ', $values) . ')';
                    
            return Database::query($connection, $query);
        }
        protected static function update($table_name, $connection, $values, $conditions=NULL){
            $query = 'UPDATE ' . $table_name . ' SET ';

            foreach ($values as $key => $value){
                $query .= $key . '=\'' . $value . '\', ';
            }

            $query = rtrim($query, ', ');

            if ($conditions){
                $query .= ' WHERE ';          
                
                $query .= implode(' AND ', $conditions); 
            }

            return Database::query($connection, $query);
        }
        protected static function delete($table_name, $connection, $conditions=NULL){
            $query = 'DELETE FROM ' . $table_name;

            if ($conditions){
                $query .= ' WHERE ';          
                
                $query .= implode(' AND ', $conditions); 
            }

            return Database::query($connection, $query);     
        }
    }
?>