<?php

require_once "../scripts/connection.php";
$connect = new Connect();

$data = array();

if (isset($_POST["Import"])) {

    $filename = $_FILES["fileInput"]["tmp_name"];
    if ($_FILES["fileInput"]["size"] > 0) {
        $file = fopen($filename, "r");
        $data = fgetcsv($file);
        fclose($file);

        $dataStr = "";

        foreach ($data as $item) {
            $dataStr .= "('" . $item . "', 0),";
        }

        $dataStr = rtrim($dataStr, ",");

        $connect->insertData("tbl_tasks", "" . $dataStr);
        navigate('/');
    } else {
        echo "File is empty";
    }
}


?>