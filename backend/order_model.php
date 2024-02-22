<?php
    require_once 'abstract_model.php';
    require_once 'connection.php';
    require_once 'database.php';

    final class OrderModel extends AbstractModel {
        public static function get($id){
            global $user_connect;

            $result = static::select('public.order', $user_connect, [
                'public.product.id', 
                'DATE_TRUNC(\'month\', \'date\') AS production_to_month',
                'COUNT(id) AS count'
                
            ], [
                'public.product.id = ' . $id
            ], NULL, 'public.product.id');

            if (!$result)
                throw new Exception('Ошибка запроса');

            return Database::fetch_all($result);
        }
        public static function filter(){
            global $admin_connect;

            $result = static::select('public.order', $admin_connect, [
                
                'DATE_TRUNC(\'month\', date) AS month',
                'COUNT(id) AS count'
            ], NULL, NULL, 'DATE_TRUNC(\'month\', date)', NULL, 'month');

            if (!$result)
                throw new Exception('Ошибка запроса');

            return Database::fetch_all($result);
        }

        public static function toJSON(){
            global $admin_connect; 

            $result = static::select('public.order', $admin_connect, [
                'id', 
                'user_id', 
                'date', 
                'product_id', 
                'amount', 
            ]);

            if (!$result)
                throw new Exception('Ошибка запроса');

            return Database::fetch_all($result);
        }

        public static function fromJSON(){
            global $admin_connect;

            $data = json_decode(file_get_contents($_FILES['order']['tmp_name']));

            $query = 'INSERT INTO public.order (user_id, date, product_id, amount) VALUES ';

            foreach ($data as $record){
                $query .= '(' . $record->user_id . ', \'' . $record->date . '\', ' . $record->product_id . ', ' . '\'' . $record->amount . '\'),';
            }

            $query = substr($query, 0, -1);

            $result = Database::query($admin_connect, $query);
               
            if (!$result)
                throw new Exception('Ошибка запроса');

            return Database::fetch_all($result);
        }
    }
