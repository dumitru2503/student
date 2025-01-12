<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">

    <title>Panou de control</title>
    <style>
        .dashbord-tables {
            animation: transitionIn-Y-over 0.5s;
        }

        .filter-container {
            animation: transitionIn-Y-bottom 0.5s;
        }

        .sub-table,
        .anime {
            animation: transitionIn-Y-bottom 0.5s;
        }
    </style>
</head>

<body>
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

    ?>
    <div class="container">
        <?php require_once './includes/menu.php' ?>
        <div class="dash-body" style="margin-top: 15px">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;">

                <tr>

                    <td colspan="1" class="nav-bar">
                        <p style="font-size: 23px;padding-left:12px;font-weight: 600;margin-left:20px;">Acasă</p>

                    </td>
                    <td width="25%">

                    </td>
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Data de azi
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php
                            date_default_timezone_set('Europe/Bucharest');

                            $today = date('Y-m-d');
                            echo $today;

                            ?>
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
                            <table class="filter-container doctor-header patient-header"
                                style="border: none;width:95%; background-color: #b9c9e6;" border="0">
                                <tr>
                                    <td>
                                        <h3>Bine ai venit!</h3>
                                        <h1><?php echo $user_name ?>.</h1>
                                        <p>Nu știi ce să alegi dintre medici? Nicio problemă, accesează secțiunea
                                            <a href="doctors.php" class="non-style-link"><b>"Toți medicii"</b></a> sau
                                            <a href="schedule.php" class="non-style-link"><b>"Sesiuni"</b> </a><br>
                                            Urmărește istoricul programărilor trecute și viitoare.<br>De asemenea, află
                                            timpul estimat
                                            de sosire al medicului tău sau al consultantului medical.<br><br>
                                        </p>

                                        <h3>Programează un medic aici</h3>
                                        <form action="schedule.php" method="post" style="display: flex">

                                            <input type="search" name="search" class="input-text "
                                                placeholder="Caută medic și vom găsi sesiuni disponibile" list="doctors"
                                                style="width:45%;">&nbsp;&nbsp;

                                            <?php
                                            echo '<datalist id="doctors">';
                                            $list11 = $database->query("select name, email from users where type = 'd'");

                                            for ($y = 0; $y < $list11->num_rows; $y++) {
                                                $row00 = $list11->fetch_assoc();
                                                $d = $row00["name"];

                                                echo "<option value='$d'><br/>";

                                            }
                                            ;

                                            echo ' </datalist>';
                                            ?>


                                            <input type="Submit" value="Căutare" class="login-btn btn-primary btn"
                                                style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">

                                            <br>
                                            <br>

                                    </td>
                                </tr>
                            </table>
                        </center>

                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p style="font-size: 20px;font-weight:600;padding-left: 40px;" class="anime">Programari
                        </p>
                        <center>
                            <div class="abc scroll" style="height: 250px;padding: 0;margin: 0;">
                                <table width="95%" class="sub-table scrolldown" border="0">
                                    <thead>

                                        <tr>
                                            <th class="table-headin">


                                                Serviciu

                                            </th>

                                            <th class="table-headin">
                                                Doctor
                                            </th>
                                            <th class="table-headin">

                                                Data si ora

                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $nextweek = date("Y-m-d", strtotime("+1 week"));
                                        $sqlmain = "SELECT users.name AS doctor_name, services.name AS service_name, appointment.date, appointment.time
                                                    FROM appointment
                                                    INNER JOIN services ON appointment.service_id = services.id
                                                    INNER JOIN users ON appointment.doctor_id = users.id
                                                    WHERE appointment.patient_id = ?";
                                        $result = $database->prepare($sqlmain);
                                        $result->bind_param("s", $user_id);
                                        $result->execute();
                                        $result = $result->get_result();

                                        if ($result->num_rows == 0) {
                                            echo '<tr>
                                                    <td colspan="4">
                                                    <br><br><br><br>
                                                    <center>
                                                    <img src="../img/notfound.svg" width="25%">
                                                    
                                                    <br>
                                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">Nothing to show here!</p>
                                                    <a class="non-style-link" href="schedule.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Channel a Doctor &nbsp;</font></button>
                                                    </a>
                                                    </center>
                                                    <br><br><br><br>
                                                    </td>
                                                    </tr>';

                                        } else {
                                            for ($x = 0; $x < $result->num_rows; $x++) {
                                                $row = $result->fetch_assoc();
                                                $service_name = $row["service_name"];
                                                $doctor_name = $row["doctor_name"];
                                                $appointment_date = $row["date"];
                                                $appointment_time = $row["time"];

                                                echo '<tr>
                                                        <td style="padding:20px;"> &nbsp;' .
                                                    substr($service_name, 0, 30)
                                                    . '</td>
                                                        <td>
                                                        ' . substr($doctor_name, 0, 20) . '
                                                        </td>
                                                        <td style="text-align:center;">
                                                            ' . substr($appointment_date, 0, 10) . ' ' . substr($appointment_time, 0, 5) . '
                                                        </td>

                
                                                       
                                                    </tr>';

                                            }
                                        }

                                        ?>

                                    </tbody>

                                </table>
                            </div>
                        </center>







                    </td>
                </tr>
            </table>
        </div>
    </div>


</body>

</html>