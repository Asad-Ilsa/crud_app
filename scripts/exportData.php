<?php

require_once("helper.php");

if (isset($_POST["Export"])) {
    require_once "../scripts/connection.php";
    $connect = new Connect();
    
    $data = $connect->fetchData("tbl_tasks");

    if ($data[0]['status'] == 'None') {
        navigate('/');
    }

    $dataStr = "";

    $file = fopen("../output/export.csv", 'w');

    if ($file === false) {
        die('Error opening the file ' . $filename);
    }

    foreach ($data as $task) {
        $dataStr .= $task['title'] . ",";
    }
    $dataStr = rtrim($dataStr, ",");
    fwrite($file, $dataStr);
    fclose($file);
    navigate('/');
}


?>