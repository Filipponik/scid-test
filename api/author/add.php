<?php
require_once '../../config.php';
function check_data($data) {
  if (!$data['f'] || empty($data['f']))
    return ['message' => 'You didn\'t add "f" to your form'];
  if (!$data['i'] || empty($data['i']))
    return ['message' => 'You didn\'t add "i" to your form'];
  if (mb_strlen($data['f']) < 3)
    return ['message' => '"f" must be more than 3 symbols'];

  return true;
}

$data = json_decode(file_get_contents('php://input'), true);
$result = check_data($data);

if ($result !== true) {
  response($result, 400);
}
else {
  try {
    $author = R::dispense('author');
    $author->f = $data['f'];
    $author->i = $data['i'];
    if (isset($data['o']))
      if ($data['o'] && !empty($data['o']))
        $author->o = $data['o'];
    $id = R::store($author);
    response(['id' => $id], 201);

  } catch (Exception $e) {
    response(['message' => 'Error while adding author to database'], 400);
  }
}