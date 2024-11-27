<?php

session_start();

if (isset($_SESSION["user_email"]) && $_SESSION["user_email"] != "" && $_SESSION['user_type'] == 'p') {
    $user_id = $_SESSION['user_id'];
    $user_email = $_SESSION["user_email"];
    $user_name = $_SESSION['user_name'];
} else {
    header("location: ../login.php");
}

include("../connection.php");

if (isset($_GET["id"])) {

    $id = $_GET["id"];
    $sqlmain = "DELETE FROM appointment WHERE id = ?";
    $stmt = $database->prepare($sqlmain);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("location: appointment.php");
}


?>