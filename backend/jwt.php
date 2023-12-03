<?php

function check_token($admin_required = false) {
    $headers = apache_request_headers();

    // error_log(implode(', ', array_keys($headers)));
    // error_log(implode(', ', $headers));
    // echo('COOKIE: '.implode(', ', $_COOKIE));
    // echo('Header: '.$headers['Authorization']);

    if(isset($headers['Authorization']) && isset($_COOKIE['jwt'])){
        error_log($headers['Authorization']);

        

        $is_admin = decode_token($headers['Authorization'])['payload']->is_admin;

        if ($is_admin){ //admin can do everything
            return true;
        }

        if ($headers['Authorization'] == $_COOKIE['jwt']){ //if user not admin - check token
            if ($admin_required){ 
                return false; //user not admin on this line
            }    
            return true;  //user not admin and permissions not required
        }     
    } else {
        return false;
    }
}
function create_token($user_info, $expiration){
    $secret_key = 'aff3135dfbc236bd36a52804c7b25a2d18be935bf076b4031649aa55c4123a3f';
    $header = encode_token(json_encode([
        'typ' => 'JWT', 
        'alg' => 'HS256'
    ]));
    $payload = encode_token(json_encode([
        'id' => $user_info['id'], 
        'is_admin' => $user_info['is_admin'] == 't' ? true : false,
        'expire' => time() + $expiration
    ]));
    $signature = encode_token(hash_hmac('sha256', $header . '.' . $payload, $secret_key, true));

    return $header.'.'.$payload.'.'.$signature;
}
function encode_token($data) {
    return str_replace(['+', '/', '='], ['', '', ''], base64_encode($data));
}
function decode_token($token){
    $blocks = explode('.', $token);
    return [
        'header' => json_decode(base64_decode($blocks[0])),
        'payload' => json_decode(base64_decode($blocks[1])),
        'signature' => $blocks[2]
    ];
}