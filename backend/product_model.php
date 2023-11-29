<?php
    require_once 'abstract_model.php';
    require_once 'connection.php';

    final class ProductModel extends AbstractModel {
        protected static $table_name = 'public.product';
        public static function get($id){
            global $user_connect;

            $result = static::select($user_connect, [
                'public.product.id', 
                'type', 
                'public.product.name', 
                'manufacturer', 
                'price', 
                'photo', 
                'gender', 
                'size', 
                'ARRAY(SELECT DISTINCT unnest(ARRAY_AGG(public.material.name))) AS materials',
                'ARRAY(SELECT DISTINCT unnest(ARRAY_AGG(public.stone.name))) AS stones'
            ], [
                'public.product.id = ' . $id
            ], [
                ['public.product_material', 'LEFT', 'public.product.id', 'public.product_material.product_id'],
                ['public.material', 'LEFT', 'material_id', 'public.material.id'],
                ['public.product_stone', 'LEFT', 'public.product.id', 'public.product_stone.product_id'],
                ['public.stone', 'LEFT', 'stone_id', 'public.stone.id']
            ], 'public.product.id');

            if (!$result)
                throw new Exception('Ошибка запроса');

            return Database::fetch_all($result);
        }
        public static function filter($type, $min_price, $max_price, $gender, $size, $stones, $materials){
            global $user_connect;

            //if (sizeof($stones) == 1 && $stones[0] == '')
                // $stones = [
                //     'Фианит', 'Ювелирное стекло', 'Эмаль', 'Кварц', 'Янтарь', 'Султанит', 'Перламутр', 'Гематит', 'Жемчуг', 'Агат', 'Шпинель', 'Халцедон', 'Корунд', 'Опал', 'Кристалл', 'Авантюрин'
                // ];
            //if (sizeof($materials) == 1 && $materials[0] == '')
                // $materials = [
                //     'Золото', 'Серебро', 'Медсплав', 'Керамика', 'Нержавеющая сталь', 'Родирование', 'Бижутерный сплав'
                // ];

            $result = static::select($user_connect, [
                'public.product.id', 
                'type', 
                'public.product.name', 
                'manufacturer', 
                'price', 
                'photo', 
                'gender', 
                'size', 
                'ARRAY(SELECT DISTINCT unnest(ARRAY_AGG(public.material.name))) AS materials',
                'ARRAY(SELECT DISTINCT unnest(ARRAY_AGG(public.stone.name))) AS stones'
            ], [
                $type != '' ? 'type = \'' . $type . '\'' : NULL,
                'price::numeric::float BETWEEN ' . $min_price . ' AND ' . $max_price,
                'gender = \'' . $gender . '\'',
                $size != '' ? 'ARRAY[size]::numeric[] && ARRAY[' . $size . ']' : NULL
            ], [
                ['public.product_material', 'LEFT', 'public.product.id', 'public.product_material.product_id'],
                ['public.material', 'LEFT', 'material_id', 'public.material.id'],
                ['public.product_stone', 'LEFT', 'public.product.id', 'public.product_stone.product_id'],
                ['public.stone', 'LEFT', 'stone_id', 'public.stone.id']
            ], 'public.product.id', [
                (sizeof($stones) != 1 || $stones[0] != '') ? 'ARRAY[\'' . implode('\', \'', $stones) . '\']::character varying[] && (ARRAY_AGG(public.stone.name))' : NULL,
                (sizeof($materials) != 1 || $materials[0] != '') ? 'ARRAY[\'' . implode('\', \'', $materials) . '\']::character varying[] && (ARRAY_AGG(public.material.name))' : NULL
            ]);

            if (!$result)
                throw new Exception('Ошибка запроса');

            return Database::fetch_all($result);
        }
    }
?>