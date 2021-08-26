<?php
require_once '../../config.php';
function check_data($data) {
  if (!isset($data['id']) || !isset($data['id']) || !is_numeric($data['id']))
    return ['message' => 'Incorrect ID'];

  return true;
}

$data = json_decode(file_get_contents('php://input'), true);
$result = check_data($data);  
if ($result !== true) {
  response($result, 400);
}
else {
  try {
    $delete = R::load('magazine', $data['id']);
    $res = R::trash($delete);
    if ($res) {
      response(['message' => 'Success']);
    }
    else {
      response(['message' => 'Error while deleting magazine from database'], 400);
    }
  } catch (Exception $e) {
    response(['message' => 'Error while deleting magazine from database'], 400);
  }
}