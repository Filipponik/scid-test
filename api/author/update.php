<?php
require_once '../../config.php';
function check_data($data) {
  if (!isset($data['id']) || !isset($data['id']) || !is_numeric($data['id']))
    return ['message' => 'Incorrect ID'];
  if (isset($data['f'])) {
    if (!$data['f'] || empty($data['f'])) 
      return ['message' => 'Incorrect "f"'];
    if (mb_strlen($data['f']) < 3)
      return ['message' => '"f" must be more than 3 symbols'];
  }

  if (isset($data['i']))
    if (!$data['i'] || empty($data['i']))
      return ['message' => 'Incorrect "i"'];
      
  if (isset($data['o']))
    if (!$data['o'] || empty($data['o']))
      return ['message' => 'Incorrect "o"'];

  return true;
}

$data = json_decode(file_get_contents('php://input'), true);
response($data);
$result = check_data($data);

if ($result !== true) {
  response($result, 400);
}
else {
  try {
    $author = R::load('author', $data['id']);
    if (isset($data['f']))
      $author->f = $data['f'];

    if (isset($data['i']))
      $author->i = $data['i'];

    if (isset($data['o']))
      $author->o = $data['o'];
      
    $id = R::store($author);
    response(['id' => $id]);
  } catch (Exception $e) {
    response(['message' => 'Error while updating author in database'], 400);
  }
}