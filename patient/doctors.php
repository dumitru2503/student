<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">

    <title>Doctors</title>
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

    include("../connection.php");

    date_default_timezone_set('Europe/Bucharest');

    $today = date('Y-m-d');

    $search_term = "";
    if (isset($_GET["search"])) {
        $search_term = $_GET["search"];
    }

    ?>
    <div class="container">
        <?php require_once './includes/menu.php' ?>
        <div class="dash-body">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <tr class="header">
                    <td width="13%">
                        <a href="./"><button class="login-btn btn-primary-soft btn btn-icon-back"
                                style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                                <font class="tn-in-text">Inapoi</font>
                            </button></a>
                    </td>
                    <td>
                        <form action="./schedule.php" method="GET" class="header-search">

                            <input type="search" name="search" class="input-text header-searchbar"
                                placeholder="Cautare serviciu" value="<?php echo $search_term ?>">&nbsp;&nbsp;

                            <input type="Submit" value="Cautare" class="login-btn btn-primary btn"
                                style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                        </form>
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
                    <td colspan="4" style="padding-top:10px;">
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">All
                            Doctors
                    </td>

                </tr>

                <tr>
                    <td colspan="4">
                        <center>
                            <p>
                                TODO: adauga setari
                            </p>
                        </center>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    </div>

</body>

</html>