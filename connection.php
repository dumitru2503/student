<?php

$database = new mysqli("localhost", "root", "", "student");
if ($database->connect_error) {
    die("Connection failed:  " . $database->connect_error);
}

?>