<?php
    class Database {
        public static function connect($host, $port, $db_name, $login, $password){
            return pg_connect('host='.$host.' port='.$port.' dbname='.$db_name.' user='.$login.' password='.$password);
        }        
        public static function query($connection, $query){
            return pg_query($connection, $query);
        }
        // public static function select($connection, $table_name, $conditions){
        //     return pg_select($connection, $table_name, $conditions);
        // }
        // public static function insert($connection, $table_name, $values){
        //     return pg_insert($connection, $table_name, $values);
        // }
        // public static function update($connection, $table_name, $values, $conditions){
        //     return pg_update($connection, $table_name, $values, $conditions);
        // }
        // public static function delete($connection, $table_name, $conditions){
        //     return pg_delete($connection, $table_name, $conditions);
        // }
        public static function fetch_all($result){
            return pg_fetch_all($result);
        }
        public static function get_last_error(){
            return pg_last_error();
        }
        public static function close($connection){
            return pg_close($connection);
        }
    }


?>