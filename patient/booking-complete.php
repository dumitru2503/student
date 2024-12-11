<?php

session_start();

if (isset($_SESSION["user_email"]) && $_SESSION["user_email"] != "" && $_SESSION['user_type'] == 'p') {
    $user_id = $_SESSION['user_id'];
    $user_email = $_SESSION["user_email"];
    $user_name = $_SESSION['user_name'];
} else {
    header("location: ../login.php");
}


//import database
include("../connection.php");

if ($_POST) {
    if (isset($_POST["booknow"])) {

        echo "<pre>";
        print_r($user_id);
        echo "<br>";
        print_r($_POST);
        echo "</pre>";

        $service_id = $_POST["service_id"];
        $doctor_id = $_POST["doctor_id"];
        $date = $_POST["date"];
        $time = $_POST["time"];

        $sql = "INSERT INTO appointment(patient_id, doctor_id, service_id, date, time)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $database->prepare($sql);
        $stmt->bind_param("sssss", $user_id, $doctor_id, $service_id, $date, $time);
        $stmt->execute();
        header("location: appointment.php?action=booking-added");
    }
}
?>