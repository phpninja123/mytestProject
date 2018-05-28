<?php
require_once "API.php";
$tpbObj = new \TPB\API();

$keyword = $_GET['term'];
$callback = $_GET['callback'];
$page = 1;

$searchResults = $tpbObj->autocompleteValues($keyword, $page);
// echo json_encode($searchResults); die();
echo $callback.'('.json_encode($searchResults).')'; die();
?>