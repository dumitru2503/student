<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">

    <title>Sessions</title>
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

    //learn from w3schools.com
    
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

    date_default_timezone_set('Europe/Bucharest');

    $today = date('Y-m-d');


    ?>
    <div class="container">
        <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:20px">
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title"><?php echo substr($user_name, 0, 13) ?></p>
                                    <p class="profile-subtitle"><?php echo substr($user_email, 0, 22) ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="../logout.php"><input type="button" value="Deconectare"
                                            class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-home menu-active menu-icon-home-active">
                        <a href="index.php" class="non-style-link-menu non-style-link-menu-active">
                            <div>
                                <p class="menu-text">Acasă</p>
                            </div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor">
                        <a href="doctors.php" class="non-style-link-menu">
                            <div>
                                <p class="menu-text">Toți medicii</p>
                            </div>
                        </a>
                    </td>
                </tr>

                <tr class="menu-row">
                    <td class="menu-btn menu-icon-session">
                        <a href="schedule.php" class="non-style-link-menu">
                            <div>
                                <p class="menu-text">Servicii</p>
                            </div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu">
                            <div>
                                <p class="menu-text">Programările mele</p>
                            </div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-settings">
                        <a href="settings.php" class="non-style-link-menu">
                            <div>
                                <p class="menu-text">Setări</p>
                            </div>
                        </a>
                    </td>
                </tr>

            </table>
        </div>

        <div class="dash-body">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <tr>
                    <td width="13%">
                        <a href="schedule.php"><button class="login-btn btn-primary-soft btn btn-icon-back"
                                style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                                <font class="tn-in-text">Back</font>
                            </button></a>
                    </td>
                    <td>
                        <form action="" method="post" class="header-search">

                            <input type="search" name="search" class="input-text header-searchbar"
                                placeholder="Search Doctor name or Email or Date (YYYY-MM-DD)"
                                list="doctors">&nbsp;&nbsp;

                            <?php
                            echo '<datalist id="services">';
                            $list12 = $database->query("SELECT * FROM services GROUP BY name;");


                            for ($y = 0; $y < $list12->num_rows; $y++) {
                                $row00 = $list12->fetch_assoc();
                                $d = $row00["name"];

                                echo "<option value='$d'><br/>";
                            }
                            ;

                            echo ' </datalist>';
                            ?>


                            <input type="Submit" value="Search" class="login-btn btn-primary btn"
                                style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                        </form>
                    </td>
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Today's Date
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php


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
                    <td colspan="4" style="padding-top:10px;width: 100%;">
                        <!-- <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49);font-weight:400;">Scheduled Sessions / Booking / <b>Review Booking</b></p> -->

                    </td>

                </tr>



                <tr>
                    <td colspan="4">
                        <center>
                            <div class="abc scroll">
                                <table width="100%" class="sub-table scrolldown" border="0"
                                    style="padding: 50px;border:none">

                                    <tbody>

                                        <?php

                                        if (($_GET)) {


                                            if (isset($_GET["id"])) {


                                                $id = $_GET["id"];

                                                $sqlmain = "SELECT s.id AS service_id, s.name AS service_name, u.name AS doctor_name, u.email AS doctor_email
                                                FROM doctor_services AS ds
                                                INNER JOIN services AS s ON ds.service_id = s.id
                                                INNER JOIN users AS u ON ds.doctor_id = u.id
                                                WHERE s.id = ?";

                                                $stmt = $database->prepare($sqlmain);
                                                $stmt->bind_param("i", $id);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                //echo $sqlmain;
                                                $row = $result->fetch_assoc();

                                                $service_id = $row["service_id"];
                                                $service_name = $row["service_name"];
                                                $doctor_name = $row["doctor_name"];
                                                $doctor_email = $row["doctor_email"];


                                                ?>
                                                <tr>
                                                    <td>
                                                        <div class="dashboard-items search-items">

                                                            <div style="width:100%">
                                                                Serviciu:
                                                                <div class="h1-search" style="font-size:25px;">
                                                                    <?php echo $service_name; ?>
                                                                </div><br>

                                                                <div class="h3-search" style="font-size:18px;">

                                                                </div>


                                                                <form action="booking-complete.php" method="post">
                                                                    <input type="hidden" name="scheduleid"
                                                                        value="<?php echo $service_id; ?>">

                                                                    <label for="doctor">Doctor:</label>
                                                                    <select class="input-text filter-container-items"
                                                                        style="margin: 0;width: 95%;" name="time" id="time">
                                                                        <option value="09:00">Doc1</option>
                                                                        <option value="10:00">Doc2</option>
                                                                        <option value="11:00">Doc3</option>
                                                                    </select>
                                                                    <br>

                                                                    <label for="date">Data:</label>
                                                                    <input type="date" name="sheduledate" id="date" 
                                                                        value=<?php echo '"' . $today . '"' ?>
                                                                        min=<?php echo '"' . $today . '"' ?>
                                                                        class="input-text filter-container-items"
                                                                        style="margin: 0;width: 95%;">
                                                                    <br>

                                                                    <label for="time">Ora:</label>
                                                                    <select class="input-text filter-container-items"
                                                                        style="margin: 0;width: 95%;" name="time" id="time">
                                                                        <option value="09:00">09:00</option>
                                                                        <option value="10:00" disabled>10:00</option>
                                                                        <option value="11:00">11:00</option>
                                                                    </select>
                                                                </form>
                                                                <br>

                                                                <div class="h3-search" style="font-size:18px;">
                                                                    Pret : <b>2500 Lei</b>

                                                                </div>
                                                                <br>

                                                            </div>

                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type="Submit" class="login-btn btn-primary btn btn-book"
                                                            style="margin-left:10px;padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;width:95%;text-align: center;"
                                                            value="Programeaza" name="booknow"></button>
                                                    </td>
                                                </tr>
                                                <?php
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



    </div>

</body>

</html>