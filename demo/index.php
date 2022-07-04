<?php

    $servername  = "172.25.0.2";
    $dbname      =  "db_crud";
    $username    =  "root";
    $password    =  "root";

    // echo $servername;
    // die;

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(
        PDO::MYSQL_ATTR_LOCAL_INFILE => true,
    ));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $table = "CREATE TABLE IF NOT EXISTS `USERS` (
        `id` int(11) unsigned NOT NULL,
        `created_on` DATE not null,
        `modified_on` DATE not null,
        `source_type` varchar(255) NOT NULL,
        `title` varchar(255) NOT NULL,
        `source` varchar(255) NOT NULL,
        `location` varchar(255) NOT NULL,
        `rank` int(10) NOT NULL,
        PRIMARY KEY  (`id`)
    )";
    $conn->exec($table);
    echo "What functionality do you want to perform?\n\n\n";
    echo "1. Insert Data Into Table.\n";
    echo "2. Update Data Of Table.\n";
    echo "3. Delete Data Of Table.\n";
    echo "4. Bulk Insert Data Into Table/Insert All Data of CSV File.\n";
    echo "5. Bulk Delete Data Of Table/Delete All Data of CSV File.\n";

    $option = rtrim(fgets(STDIN));
    echo $option;
    switch ($option) {
        case 1:
            echo "Insert ID: ";
            $id = rtrim(fgets(STDIN));
            echo "Insert Source Type Of Movie: ";
            $source_type = rtrim(fgets(STDIN));
            echo "Insert Title Of movie: ";
            $title = rtrim(fgets(STDIN));
            echo "Insert Source: ";
            $source = rtrim(fgets(STDIN));
            echo "Insert location of country: ";
            $location = rtrim(fgets(STDIN));
            echo "Insert Rank Of Movie: ";
            $rank = rtrim(fgets(STDIN));
            $query = "INSERT INTO `USERS` (`id`,`created_on`,`modified_on`,`source_type`,`title`,`source`,`location`,`rank`) 
            Values ($id,'2021-09-10','2019-8-19','$source_type','$title','$source','$location',$rank)";
            $conn->exec($query);
            break;
        case 2:
            echo "INPUT DATA TO UPDATE: ";
            echo "Insert ID";
            $id = rtrim(fgets(STDIN));
            echo "Insert Source Type Of Movie";
            $source_type = rtrim(fgets(STDIN));
            echo "Insert Title Of movie";
            $title = rtrim(fgets(STDIN));
            echo "Insert Source";
            $source = rtrim(fgets(STDIN));
            echo "Insert location of country";
            $location = rtrim(fgets(STDIN));
            echo "Insert Rank Of Movie";
            $rank = rtrim(fgets(STDIN));

            $query = "UPDATE USERS Set `id`=$id, `source_type`='$source_type', `title`='$title', `source`='$source', `location`='$location', `rank`=$rank where `id` = $id";
            $conn->exec($query);
            break;
        case 3:
            echo "DELETE DATA FROM TABLE: ";
            echo "Insert ID";
            $id = rtrim(fgets(STDIN));
            $query = "DELETE FROM `USERS` where `id` = $id";
            $conn->exec($query);
            break;
        case 4:
            $query = "LOAD DATA LOCAL INFILE 'data.csv' INTO TABLE USERS
            FIELDS TERMINATED BY ',' 
            ENCLOSED BY '\"' 
            LINES TERMINATED BY '\r\n'
            IGNORE 1 LINES";
            echo $query;
            // die();
            $conn->exec($query);
            break;
        case 5:
            $query = "DELETE FROM `USERS`";
            $conn->exec($query);
    }
?>