<?php
function response($arr, $code=200) {
  http_response_code($code);
  echo json_encode($arr, JSON_UNESCAPED_SLASHES);
}

require 'rb.php';

$db_host = 'localhost';
$db_name = 'scid_test';
$db_conn_string = 'mysql:host='.$db_host.';dbname='.$db_name;
$db_user = 'root';
$db_pass = '';

R::setup($db_conn_string, $db_user, $db_pass);
R::freeze(true);

if (!R::testConnection()) {
	exit('Нет подключения к базе данных');
}
 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");