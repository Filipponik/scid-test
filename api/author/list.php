<?php
require_once '../../config.php';

$data = json_decode(file_get_contents('php://input'), true);

$page = 1;
$perPage = 10;

if (isset($data['page']))
  if ($data['page'] && !empty($data['page']) && is_numeric($data['page']))
    $page = (int)$data['page'];

if (isset($data['perPage']))
  if ($data['perPage'] && !empty($data['perPage']) && is_numeric($data['perPage']))
    $perPage = (int)$data['perPage'];

$offset = $perPage * ($page - 1);
$authors = R::getAll('SELECT * FROM `author` LIMIT ?, ?', [$offset, $perPage]);

response($authors);