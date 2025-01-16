<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">

    <title>Dashboard</title>
    <style>
        .dashbord-tables,
        .doctor-heade {
            animation: transitionIn-Y-over 0.5s;
        }

        .filter-container {
            animation: transitionIn-Y-bottom 0.5s;
        }

        .sub-table,
        #anim {
            animation: transitionIn-Y-bottom 0.5s;
        }

        .doctor-heade {
            animation: transitionIn-Y-over 0.5s;
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

    include("../connection.php");

    $stmt1 = $database->prepare("SELECT * FROM appointment WHERE doctor_id = ? AND date = ?");
    $stmt1->bind_param("ss", $user_id, $today);
    $stmt1->execute();
    $today_appointments = $stmt1->get_result();
    $today_appointments_count = $today_appointments->num_rows;

    $stmt2 = $database->prepare("SELECT s.name AS service_name, u.name AS patient_name, a.date AS date, a.time AS time
                              FROM appointment AS a
                              INNER JOIN services AS s ON a.service_id = s.id
                              INNER JOIN users AS u ON a.patient_id = u.id
                              WHERE a.doctor_id = ? LIMIT 5;");
    $stmt2->bind_param("s", $user_id);
    $stmt2->execute();
    $appointments = $stmt2->get_result();
    $appointments_count = $appointments->num_rows;


    ?>
    <div class="container">
        <?php require_once './includes/menu.php' ?>
        <div class="dash-body" style="margin-top: 15px">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;">

                <tr>

                    <td colspan="1" class="nav-bar">
                        <p
                            style="font-size: 23px;color:#ffffff;border-radius: 10px; padding: 10px 30px; font-weight: 600; margin-left: 20px; border: 1px solid; background-color: #2d3663;">
                            Profil</p>

                    </td>
                    <td width="25%">

                    </td>
                    <td width="15% ">
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
                    <td colspan="4">

                        <center>
                            <table class="filter-container doctor-header" style="border: none;margin-top:30px;width:95%"
                                border="0">
                                <tr>
                                    <td style="background-color: #b9c9e6; padding-left: 30px; border-radius: 10px">
                                        <h3>Bine ați venit!</h3>
                                        <h1><?php echo $user_name ?>.</h1>
                                        <p>Suntem încântați să vă vedem din nou pe platformă.
                                            Vă dorim o zi productivă și plină de realizări!<br>
                                        </p>
                                        <a href="appointment.php" class="non-style-link"><button class="btn-primary btn"
                                                style="width:30%;border-radius: 5px">Vezi programările</button></a>
                                        <br>
                                        <br>
                                    </td>
                                </tr>
                            </table>
                        </center>

                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <table border="0" width="100%"">
                            <tr>
                                <td width=" 50%">
                            <center>
                                <table class="filter-container" style="border: none;" border="0">
                                    <tr>
                                        <td colspan="4">
                                            <p style="font-size: 20px;font-weight:600;padding-left: 12px;">Status</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 25%;">
                                            <div class="dashboard-items"
                                                style="padding:20px;margin:auto;width:95%;display: flex">
                                                <div>
                                                    <div class="h1-dashboard">
                                                        <?php echo $appointments->num_rows ?>
                                                    </div><br>
                                                    <div class="h3-dashboard">
                                                        Programări &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    </div>
                                                </div>
                                                <!-- <div class="btn-icon-back dashboard-icons"
                                                    style="background-image: url('../img/icons/doctors-hover.svg');">
                                                </div> -->
                                            </div>
                                        </td>
                                        <td style="width: 25%;">
                                            <div class="dashboard-items"
                                                style="padding:20px;margin:auto;width:95%;display: flex;">
                                                <div>
                                                    <div class="h1-dashboard">
                                                        <?php echo $today_appointments->num_rows ?>
                                                    </div><br>
                                                    <div class="h3-dashboard">
                                                        Programări astăzi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    </div>
                                                </div>
                                                <!-- <div class="btn-icon-back dashboard-icons"
                                                    style="background-image: url('../img/icons/patients-hover.svg');">
                                                </div> -->
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- <tr>
                                        <td style="width: 25%;">
                                            <div class="dashboard-items"
                                                style="padding:20px;margin:auto;width:95%;display: flex; ">
                                                <div>
                                                    <div class="h1-dashboard">
                                                        <?php echo $appointmentrow->num_rows ?>
                                                    </div><br>
                                                    <div class="h3-dashboard">
                                                        NewBooking &nbsp;&nbsp;&nbsp;&nbsp;
                                                    </div>
                                                </div>
                                                <div class="btn-icon-back dashboard-icons"
                                                    style="margin-left: 0px;background-image: url('../img/icons/book-hover.svg');">
                                                </div>
                                            </div>

                                        </td>

                                        <td style="width: 25%;">
                                            <div class="dashboard-items"
                                                style="padding:20px;margin:auto;width:95%;display: flex;padding-top:21px;padding-bottom:21px;">
                                                <div>
                                                    <div class="h1-dashboard">
                                                        <?php echo $schedulerow->num_rows ?>
                                                    </div><br>
                                                    <div class="h3-dashboard" style="font-size: 15px">
                                                        Today Sessions
                                                    </div>
                                                </div>
                                                <div class="btn-icon-back dashboard-icons"
                                                    style="background-image: url('../img/icons/session-iceblue.svg');">
                                                </div>
                                            </div>
                                        </td>

                                    </tr> -->
                                </table>
                            </center>
                    </td>
                    <td>



                        <!-- <p id="anim" style="font-size: 20px;font-weight:600;padding-left: 40px;">Programări viitoare</p>
                        <center>
                            <div class="abc scroll" style="height: 250px;padding: 0;margin: 0;">
                                <table width="85%" class="sub-table scrolldown" border="0">
                                    <thead>
                                        <tr>
                                            <th class="table-headin">
                                                Serviciu
                                            </th>
                                            <th class="table-headin">
                                                Nume pacient
                                            </th>
                                            <th class="table-headin">
                                                Data
                                            </th>
                                            <th class="table-headin">
                                                Ora
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php

                                        if ($appointments->num_rows == 0) {
                                            echo '<tr>
                                                    <td colspan="4">
                                                    <br><br><br><br>
                                                    <center>
                                                    <img src="../img/notfound.svg" width="25%">
                                                    
                                                    <br>
                                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We  couldnt find anything related to your keywords !</p>
                                                    <a class="non-style-link" href="schedule.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Sessions &nbsp;</font></button>
                                                    </a>
                                                    </center>
                                                    <br><br><br><br>
                                                    </td>
                                                    </tr>';

                                        } else {
                                            for ($x = 0; $x < $appointments->num_rows; $x++) {
                                                $row = $appointments->fetch_assoc();

                                                $service_name = $row["service_name"];
                                                $patient_name = $row["patient_name"];
                                                $time = $row["time"];
                                                $date = $row["date"];
                                                echo '<tr>
                                                        <td style="padding:20px;text-align:center;">' .
                                                    substr($service_name, 0, 30) .
                                                    '</td>
                                                        <td style="padding:20px;text-align:center;">' .
                                                    substr($patient_name, 0, 30) .
                                                    '</td>
                                                        <td style="padding:20px;font-size:13px;">' .
                                                    substr($date, 0, 10) .
                                                    '</td>
                                                        <td style="text-align:center;font-size:13px;">' .
                                                    substr($time, 0, 5) .
                                                    '</td>
                                                    </tr>';
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </center> -->
                    </td>
                </tr>
            </table>
            </td>
            <tr>
                </table>
        </div>
    </div>


</body>

</html>