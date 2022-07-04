<?php

require_once "helper.php";

class Connect
{
    private $servername;
    private $username;
    private $password;

    private $dbname;

    public $con;

    function __construct()
    {
        $this->servername = "172.25.0.2";
        $this->username = 'root';
        $this->password = 'root';

        $this->dbname = 'db_crud';

        $this->open_connection();
    }

    private function open_connection()
    {
        $this->con = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($this->con->connect_error) {
            die("Connection Failed" . $this->con->connect_error);
        }
        console_log("Connected Successfully!");
    }

    function fetchData($tblname)
    {
        $data = array();

        $sql = "SELECT id, title, isDone FROM $tblname;";
        $result = $this->con->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $task = array("id" => $row["id"], "title" => $row["title"], "status" => $row["isDone"] ? "Completed" : "Pending");
                array_push($data, $task);
            }
        } else {#
            $task = array("id" => NAN, "title" => "No Task to show", "status" => "None");
            array_push($data, $task);
        }
        return $data;
    }

    function insertData($tblname, $data)
    {
        $sql = "INSERT INTO $tblname (title, isDone) VALUES " . $data;

        if ($this->con->query($sql) === TRUE) {
            console_log("New record created successfully");
        } else {
            console_log("Error: " . $sql . "<br>" . $this->con->error);
        }
    }

    function deleteData($tblname, $id) {
        $sql = "DELETE FROM $tblname WHERE id=$id";

        if ($this->con->query($sql) === TRUE) {
            console_log("Record deleted successfully");
        } else {
            console_log("Error: " . $sql . "<br>" . $this->con->error);
        }
    }

    function deleteEntireData($tblname, $id) {
        $sql = "DELETE FROM $tblname WHERE id>=$id";

        if ($this->con->query($sql) === TRUE) {
            console_log("Record deleted successfully");
            navigate('/');
        } else {
            console_log("Error: " . $sql . "<br>" . $this->con->error);
        }
    }

    function updateData($tblname, $id, $title, $status) {
        $sql = "UPDATE $tblname SET title='$title', isDone=$status WHERE id=$id";

        if ($this->con->query($sql) === TRUE) {
            console_log("Record updated successfully");
        } else {
            console_log("Error: " . $sql . "<br>" . $this->con->error);
        }
    }

    private function close_connection()
    {
        $this->con->close();
    }

    function __destruct()
    {
        $this->close_connection();
    }
}
