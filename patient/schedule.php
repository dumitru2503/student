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
        <?php

        $sqlpt1 = "";
        $insertkey = "";
        $q = '';
        $searchtype = "All";

        if ($_POST) {
            //print_r($_POST);
        
            if (!empty($_POST["search"])) {
                /*TODO: make and understand */
                $keyword = $_POST["search"];
                $sqlmain = "select * from schedule inner join doctor on schedule.docid=doctor.docid where schedule.scheduledate>='$today' and (doctor.docname='$keyword' or doctor.docname like '$keyword%' or doctor.docname like '%$keyword' or doctor.docname like '%$keyword%' or schedule.title='$keyword' or schedule.title like '$keyword%' or schedule.title like '%$keyword' or schedule.title like '%$keyword%' or schedule.scheduledate like '$keyword%' or schedule.scheduledate like '%$keyword' or schedule.scheduledate like '%$keyword%' or schedule.scheduledate='$keyword' )  order by schedule.scheduledate asc";
                //echo $sqlmain;
                $insertkey = $keyword;
                $searchtype = "Search Result : ";
                $q = '"';
            }

        }
        ?>

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
                                placeholder="Search Doctor name or Email or Date (YYYY-MM-DD)" list="doctors"
                                value="<?php echo $insertkey ?>">&nbsp;&nbsp;

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
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">
                            Servicii
                        </p>
                        <p class="heading-main12" style="margin-left: 45px;font-size:22px;color:rgb(49, 49, 49)">
                            <?php echo $q . $insertkey . $q; ?>
                        </p>
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

                                        $sqlmain = "SELECT * FROM services";
                                        $result = $database->query($sqlmain);


                                        if ($result->num_rows == 0) {
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
                                            //echo $result->num_rows;
                                            for ($x = 0; $x < ($result->num_rows); $x++) {
                                                echo "<tr>";
                                                for ($q = 0; $q < 3; $q++) {
                                                    $row = $result->fetch_assoc();
                                                    if (!isset($row)) {
                                                        break;
                                                    }
                                                    ;
                                                    $service_id = $row["id"];
                                                    $service_name = $row["name"];

                                                    if ($service_id == "") {
                                                        break;
                                                    }

                                                    echo '
                                        <td style="width: 25%;">
                                                <div  class="dashboard-items search-items"  >
                                                
                                                    <div style="width:100%">
                                                            <a href="booking.php?id=' . $service_id . '" >
                                                                <div class="service-container">
                                                                    <img src="../img/service2.png">
                                                                    <br>
                                                                    <div class="h3-search">
                                                                        ' . substr($service_name, 0, 21) . '
                                                                    </div>
                                                                </div>
                                                            </a>
                                                    </div>
                                                            
                                                </div>
                                            </td>';

                                                }
                                                echo "</tr>";

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