<?php
require_once '../../config.php';
function check_data($data) {
  if (!isset($data['id']) || !isset($data['id']) || !is_numeric($data['id']))
    return ['message' => 'Incorrect ID'];

  if (isset($data['name']))
    if (!$data['name'] || empty($data['name']))
      return ['message' => 'You didn\'t add "name" to your form'];
  
  if (isset($data['picture_url']))
    if (!$data['picture_url'] || empty($data['picture_url']))
      return ['message' => 'You didn\'t add "pictureUrl" to your form'];
  
  if (isset($data['date']))
    if (!$data['date'] || empty($data['date']))
      return ['message' => 'You didn\'t add "date" to your form'];

  if (isset($data['authors']))
    if (!$data['authors'] || empty($data['authors']))
      return ['message' => 'You didn\'t add "authors" to your form'];
  
  return true;
}

$data = json_decode(file_get_contents('php://input'), true);
$result = check_data($data);

if ($result !== true) {
  response($result, 400);
}
else {
  foreach ($data['authors'] as $id) {
    $author = R::getRow('SELECT id FROM `author` WHERE id=? LIMIT 1', [$id]);
    if (!$author) {
      return response(['message' => 'Cannot find all authors'], 400);
      die();
    }
  }
  try {
    $magazine = R::load('magazine', $data['id']);
    if (isset($data['name']))
      $magazine->name = $data['name'];

    if (isset($data['picture_url']))
      $magazine->picture_url = $data['picture_url'];
    
    if (isset($data['description']))
      $magazine->description = $data['description'];
      
    if (isset($data['date']))
      $magazine->date = $data['date'];
    $id = R::store($magazine);

    $current_authors = R::getAll('SELECT id, author_id from magazineauthors WHERE magazine_id=?', [$data['id']]);

    if (isset($data['authors'])) {
      foreach ($current_authors as $value) {
        $delete = R::load('magazineauthors', $value['id']);
        $res = R::trash($delete);
      }
      foreach ($data['authors'] as $value) {
        $magazine_authors = R::dispense('magazineauthors');
        $magazine_authors->magazine_id = $id;
        $magazine_authors->author_id = $id_author;
        R::store($magazine_authors);
      }
    }

    response(['id' => $id], 200);

  } catch (Exception $e) {
    var_dump($e);
    die();
    return response(['message' => 'Error while adding magazine to database'], 400);
  }
}