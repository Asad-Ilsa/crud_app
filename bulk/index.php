<?php

require_once "../scripts/connection.php";
$connect = new Connect();

$data = array();

$file = fopen("contacts.csv","r");
$data = fgetcsv($file);
fclose($file);

$dataStr = "";

foreach ($data as $item) {
    $dataStr .= "('" . $item . "', 0),";
}

$dataStr = rtrim($dataStr, ",");

$connect->insertData("tbl_tasks", "" . $dataStr);
navigate('/');

?>