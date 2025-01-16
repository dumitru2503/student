<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">

    <title>Medici</title>
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
                    <td colspan="4" style="padding-top:10px;width: 100%;">
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">
                            Medici
                        </p>
                        <p class="heading-main12" style="margin-left: 45px;font-size:22px;color:rgb(49, 49, 49)">
                            <?php echo strlen($search_term) != 0 ? "'$search_term'" : ""; ?>
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

                                        $type_doctor = "d";
                                        $stmt = $database->prepare("SELECT * FROM users WHERE name LIKE ? and type = ?");
                                        $search_pattern = "%" . $search_term . "%";
                                        $stmt->bind_param("ss", $search_pattern, $type_doctor);
                                        $stmt->execute();
                                        $result = $stmt->get_result();



                                        if ($result->num_rows == 0) {
                                            ?>
                                            <tr>
                                                <td colspan="4">
                                                    <br><br><br><br>
                                                    <center>
                                                        <img src="../img/notfound.svg" width="25%">

                                                        <br>
                                                        <p class="heading-main12"
                                                            style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">
                                                            Nu am putut gasi nimic !</p>
                                                    </center>
                                                    <br><br><br><br>
                                                </td>
                                            </tr>

                                            <?php

                                        } else {

                                            for ($x = 0; $x < ($result->num_rows); $x++) { ?>
                                                <tr>

                                                <?php
                                                for ($q = 0; $q < 3; $q++) {
                                                    $row = $result->fetch_assoc();
                                                    if (!isset($row)) {
                                                        break;
                                                    }
                                                    ;
                                                    $doctor_id = $row["id"];
                                                    $doctor_name = $row["name"];
                                                    // $service_image = $row["image"];

                                                    if ($doctor_id == "") {
                                                        break;
                                                    }


                                                    $stmt = $database->prepare("SELECT s.name AS service_name 
                                                                            FROM doctor_services AS ds
                                                                            INNER JOIN services AS s ON ds.service_id = s.id 
                                                                            WHERE doctor_id = ?");

                                                    $stmt->bind_param("i", $doctor_id); // Assuming doctor_id is an integer
                                                    $stmt->execute();
                                                    $services = $stmt->get_result();

                                                    ?>
                                                    <td style="width: 25%;">
                                                        <div class="dashboard-items search-items">
                                                            <div style="width:100%">
                                                                <a href="#?id=<?php echo $doctor_id; ?>">
                                                                    <div class="service-container">
                                                                        <img
                                                                            src="../img/doctor.png">
                                                                        <br>
                                                                        <div class="h3-search">
                                                                            <?php echo substr($doctor_name, 0, 21); ?>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    

                    
                                                <?php } ?>
                                                </tr>
                                            <?php } ?>
                                        <?php } ?>
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