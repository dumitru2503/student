<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">

    <title>Appointments</title>
    <style>
        .popup {
            animation: transitionIn-Y-bottom 0.5s;
        }

        .sub-table {
            animation: transitionIn-Y-bottom 0.5s;
        }
    </style>
</head>

<body>
    <?php

    session_start();

    if (isset($_SESSION["user_email"]) && $_SESSION["user_email"] != "" && $_SESSION['user_type'] == 'd') {
        $user_id = $_SESSION['user_id'];
        $user_email = $_SESSION["user_email"];
        $user_name = $_SESSION['user_name'];
    } else {
        header("location: ../login.php");
    }

    date_default_timezone_set('Europe/Bucharest');

    $today = date('Y-m-d');
    $time_now = date("H:i:s");
    $filter_date = isset($_GET['filter_date']) ? $_GET['filter_date'] : "";

    include("../connection.php");

    $sql1 = "SELECT a.id AS appointment_id, s.name AS service_name, u.name AS patient_name, a.date AS date, a.time AS time
         FROM appointment AS a
         INNER JOIN services AS s ON a.service_id = s.id
         INNER JOIN users AS u ON a.patient_id = u.id
         WHERE a.doctor_id = ? AND ((a.date = ? AND a.time > ?) OR (a.date > ?))";

    if ($filter_date) {
        $sql1 .= " AND a.date = ?";
        $stmt1 = $database->prepare($sql1);
        $stmt1->bind_param("sssss", $user_id, $today, $time_now, $today, $filter_date);
    } else {
        $stmt1 = $database->prepare($sql1);
        $stmt1->bind_param("ssss", $user_id, $today, $time_now, $today);
    }

    $stmt1->execute();
    $future_appointments = $stmt1->get_result();

    $sql2 = "SELECT a.id AS appointment_id, s.name AS service_name, u.name AS patient_name, a.date AS date, a.time AS time
         FROM appointment AS a
         INNER JOIN services AS s ON a.service_id = s.id
         INNER JOIN users AS u ON a.patient_id = u.id
         WHERE a.doctor_id = ? AND ((a.date = ? AND a.time <= ?) OR (a.date < ?))";

    if ($filter_date) {
        $sql2 .= " AND a.date = ?";
        $stmt2 = $database->prepare($sql2);
        $stmt2->bind_param("sssss", $user_id, $today, $time_now, $today, $filter_date);
    } else {
        $stmt2 = $database->prepare($sql2);
        $stmt2->bind_param("ssss", $user_id, $today, $time_now, $today);
    }

    $stmt2->execute();
    $past_appointments = $stmt2->get_result();

    ?>
    <div class="container">
        <?php require_once './includes/menu.php' ?>

        <div class="dash-body">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <tr>
                    <td width="13%">
                        <a href="./"><button class="login-btn btn-primary-soft btn btn-icon-back"
                                style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                                <font class="tn-in-text">Inapoi</font>
                            </button></a>
                    </td>
                    <td>
                        <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Appointment Manager</p>

                    </td>
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Data de azi
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php echo $today; ?>
                        </p>
                    </td>
                    <td width="10%">
                        <button class="btn-label"
                            style="display: flex;justify-content: center;align-items: center;"><img
                                src="../img/calendar.svg" width="100%"></button>
                    </td>


                </tr>

                <tr>
                    <td colspan="4" style="padding-top:0px;width: 100%;">
                        <center>
                            <table class="filter-container" border="0">
                                <tr>
                                    <form action="./appointment.php" method="GET">
                                        <td width="10%">

                                        </td>
                                        <td width="5%" style="text-align: center;">
                                            Date:
                                        </td>
                                        <td width="30%">

                                            <input type="date" name="filter_date" id="date" <?php echo "value='$filter_date'"; ?>
                                                class="input-text filter-container-items" style="margin: 0;width: 95%;">

                                        </td>

                                        <td width="12%">
                                            <input type="submit" value="Filtrare"
                                                class=" btn-primary-soft btn button-icon btn-filter"
                                                style="padding: 15px; margin :0;width:100%">
                                        </td>
                                    </form>

                                </tr>
                            </table>

                        </center>
                    </td>


                    <?php if ($future_appointments->num_rows > 0) { ?>
                            </tr>
                            <tr>
                                <td colspan="4" style="padding-top:10px;width: 100%;">

                                    <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">
                                        Viitoare (<?php echo $future_appointments->num_rows; ?>)</p>
                                </td>

                            </tr>
                            <tr>
                                <td colspan="4">
                                    <center>
                                        <div class="abc scroll">
                                            <table width="93%" class="sub-table scrolldown" border="0">
                                                <thead>
                                                    <tr>
                                                        <th class="table-headin">
                                                            Nume pacient
                                                        </th>
                                                        <th class="table-headin">


                                                            Serviciu

                                                        </th>

                                                        <th class="table-headin">

                                                            Date

                                                        </th>

                                                        <th class="table-headin">

                                                            Ora

                                                        </th>

                                                        <th class="table-headin">

                                                            Actiuni

                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    for ($x = 0; $x < $future_appointments->num_rows; $x++) {
                                                        $row = $future_appointments->fetch_assoc();

                                                        $appointment_id = $row["appointment_id"];
                                                        $patient_name = $row["patient_name"];
                                                        $service_name = $row["service_name"];
                                                        $time = $row["time"];
                                                        $date = $row["date"];

                                                        ?>
                                                                <tr>
                                                                    <td style="font-weight:600;text-align:center;">
                                                                        &nbsp;<?php echo substr($patient_name, 0, 25); ?></td>
                                                                    <td style="text-align:center;"><?php echo substr($service_name, 0, 25); ?>
                                                                    </td>
                                                                    <td style="text-align:center;"><?php echo $date; ?></td>
                                                                    <td style="text-align:center;"><?php echo $time; ?></td>
                                                                    <td style="text-align:center;">
                                                                        <div style="display:flex;justify-content: center;">
                                                                            <a href="?action=drop&id=<?php echo $appointment_id; ?>&patient=<?php echo $patient_name; ?>&service=<?php echo $service_name; ?>&date=<?php echo $date; ?>&time=<?php echo $time; ?>"
                                                                                class="non-style-link">
                                                                                <button class="btn-primary-soft btn button-icon btn-delete"
                                                                                    style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;">
                                                                                    <font class="tn-in-text">Cancel</font>
                                                                                </button>
                                                                            </a>
                                                                            &nbsp;&nbsp;&nbsp;
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </center>
                                </td>
                            </tr>
                <?php } ?>

                <?php if ($past_appointments->num_rows > 0) { ?>
                            <tr>
                                <td colspan="4" style="padding-top:10px;width: 100%;">

                                    <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">
                                        In trecut (<?php echo $past_appointments->num_rows; ?>)</p>
                                </td>

                            </tr>
                            <tr>
                                <td colspan="4">
                                    <center>
                                        <div class="abc scroll">
                                            <table width="93%" class="sub-table scrolldown" border="0">
                                                <thead>
                                                    <tr>
                                                        <th class="table-headin">
                                                            Nume pacient
                                                        </th>
                                                        <th class="table-headin">

                                                            Serviciu

                                                        </th>

                                                        <th class="table-headin">

                                                            Date

                                                        </th>

                                                        <th class="table-headin">

                                                            Ora

                                                        </th>

                                                        <th class="table-headin">

                                                            Actiuni

                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    for ($x = 0; $x < $past_appointments->num_rows; $x++) {
                                                        $row = $past_appointments->fetch_assoc();

                                                        $appointment_id = $row["appointment_id"];
                                                        $patient_name = $row["patient_name"];
                                                        $service_name = $row["service_name"];
                                                        $time = $row["time"];
                                                        $date = $row["date"];

                                                        ?>

                                                                <tr>
                                                                    <td style="font-weight:600;text-align:center;">
                                                                        &nbsp;<?php echo substr($patient_name, 0, 25); ?></td>
                                                                    <td style="text-align:center;"><?php echo substr($service_name, 0, 25); ?>
                                                                    </td>
                                                                    <td style="text-align:center;"><?php echo $date; ?></td>
                                                                    <td style="text-align:center;"><?php echo $time; ?></td>
                                                                    <td style="text-align:center;">
                                                                        <div style="display:flex;justify-content: center;">
                                                                            <a href="?action=drop&id=<?php echo $appointment_id; ?>&patient=<?php echo $patient_name; ?>&service=<?php echo $service_name; ?>&date=<?php echo $date; ?>&time=<?php echo $time; ?>"
                                                                                class="non-style-link">
                                                                                <button class="btn-primary-soft btn button-icon btn-delete"
                                                                                    style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;">
                                                                                    <font class="tn-in-text">Cancel</font>
                                                                                </button>
                                                                            </a>
                                                                            &nbsp;&nbsp;&nbsp;
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </center>
                                </td>
                            </tr>
                <?php } ?>

                <?php if ($future_appointments->num_rows == 0 && $past_appointments->num_rows == 0) { ?>
                            <tr>
                                <td colspan="7">
                                    <br><br><br><br>
                                    <center>
                                        <img src="../img/notfound.svg" width="25%">

                                        <br>
                                        <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">Nu
                                            am gasit nici o programare</p>
                                    </center>
                                    <br><br><br><br>
                                </td>
                            </tr>
                <?php } ?>
            </table>
        </div>
    </div>
    <?php

    if (isset($_GET["id"]) && isset($_GET["action"])) {
        $id = $_GET["id"];
        $action = $_GET["action"];

        if ($action == 'drop') {
            $patient = $_GET["patient"];
            $service = $_GET["service"];
            $date = $_GET["date"];
            $time = $_GET["time"];
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <h2>Are you sure?</h2>
                        <a class="close" href="appointment.php">&times;</a>
                        <div class="content">
                            You want to delete this record<br><br>
                            Nume pacient: <b>' . substr($patient, 0, 40) . '</b><br>
                            Serviciu: <b>' . substr($service, 0, 40) . '</b><br>
                            Data: <b>' . substr($date, 0, 40) . '</b><br>
                            Ora: <b>' . substr($time, 0, 40) . '</b><br>
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                        <a href="delete-appointment.php?id=' . $id . '" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Da&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                        <a href="appointment.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;Nu&nbsp;&nbsp;</font></button></a>

                        </div>
                    </center>
            </div>
            </div>
            ';
        }
    }

    ?>
    </div>

</body>

</html>