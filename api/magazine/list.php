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

$magazines = R::getAll('SELECT * FROM `magazine` LIMIT ?, ?', [$offset, $perPage]);

foreach ($magazines as $key => $magazine) {
  $authors = R::getAll('SELECT author.id, author.f, author.i, author.o FROM `magazineauthors`
                        JOIN author ON author.id=magazineauthors.author_id
                        WHERE magazine_id=?', [$magazine['id']]);
  $magazines[$key]['authors'] = $authors;
}

response($magazines);