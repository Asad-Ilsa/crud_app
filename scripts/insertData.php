<?php 

require_once "connection.php";
$connect = new Connect();

$data = array();
$i = 0;
$key = "titleInput" . $i;

do {
    array_push($data, $_POST[$key]);
    $i += 1;
    $key = "titleInput" . $i;
} while (array_key_exists($key, $_POST));

$dataStr = "";

foreach ($data as $item) {
    $dataStr .= "('" . $item . "', 0),";
}

$dataStr = rtrim($dataStr, ",");

$connect->insertData("tbl_tasks", "" . $dataStr);
navigate('/');

?>