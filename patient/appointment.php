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

    if (isset($_SESSION["user_email"]) && $_SESSION["user_email"] != "" && $_SESSION['user_type'] == 'p') {
        $user_id = $_SESSION['user_id'];
        $user_email = $_SESSION["user_email"];
        $user_name = $_SESSION['user_name'];
    } else {
        header("location: ../login.php");
    }

    date_default_timezone_set('Europe/Bucharest');
    $today = date('Y-m-d');
    $filter_date = isset($_GET['filter_date']) ? $_GET['filter_date'] : "";

    //import database
    include("../connection.php");

    $sqlmain = "SELECT appointment.id AS appointment_id, users.name AS doctor_name, services.name AS service_name, appointment.date, appointment.time
                FROM appointment
                INNER JOIN services ON appointment.service_id = services.id
                INNER JOIN users ON appointment.doctor_id = users.id
                WHERE appointment.patient_id = ?";

    if ($filter_date) {
        $sqlmain .= " AND appointment.date = ?";
        $result = $database->prepare($sqlmain);
        $result->bind_param("ss", $user_id, $filter_date);
    } else {
        $sqlmain .= " ORDER BY appointment.date DESC";
        $result = $database->prepare($sqlmain);
        $result->bind_param("s", $user_id);
    }

    $result->execute();
    $result = $result->get_result();


    ?>
    <div class="container">
        <?php require_once './includes/menu.php' ?>
        <div class="dash-body">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <tr>
                    <td width="13%">
                        <a href="./"><button class="login-btn btn-primary-soft btn btn-icon-back"
                                style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                                <font class="tn-in-text">Înapoi</font>
                            </button></a>
                    </td>
                    <td>
                        <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Istoricul programărilor</p>

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

                <!-- <tr>
                    <td colspan="4" >
                        <div style="display: flex;margin-top: 40px;">
                        <div class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49);margin-top: 5px;">Schedule a Session</div>
                        <a href="?action=add-session&id=none&error=0" class="non-style-link"><button  class="login-btn btn-primary btn button-icon"  style="margin-left:25px;background-image: url('../img/icons/add.svg');">Add a Session</font></button>
                        </a>
                        </div>
                    </td>
                </tr> -->
                <tr>
                    <td colspan="4" style="padding-top:10px;width: 100%;">

                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">
                            Programări
                            (<?php echo $result->num_rows; ?>)</p>
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

                </tr>



                <tr>
                    <td colspan="4">
                        <center>
                            <div class="abc scroll">
                                <table width="93%" class="sub-table scrolldown" border="0" style="border:none">

                                    <tbody>

                                        <?php




                                        if ($result->num_rows == 0) {
                                            echo '<tr>
                                    <td colspan="7">
                                    <br><br><br><br>
                                    <center>
                                    <img src="../img/notfound.svg" width="25%">
                                    
                                    <br>
                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We  couldnt find anything related to your keywords !</p>
                                    <a class="non-style-link" href="appointment.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Appointments &nbsp;</font></button>
                                    </a>
                                    </center>
                                    <br><br><br><br>
                                    </td>
                                    </tr>';

                                        } else {

                                            for ($x = 0; $x < ($result->num_rows); $x++) {
                                                echo "<tr>";
                                                for ($q = 0; $q < 3; $q++) {
                                                    $row = $result->fetch_assoc();
                                                    if (!isset($row)) {
                                                        break;
                                                    }
                                                    ;
                                                    $appointment_id = $row["appointment_id"];
                                                    $service_name = $row["service_name"];
                                                    $doctor_name = $row["doctor_name"];
                                                    $appointment_date = $row["date"];
                                                    $appointment_time = $row["time"];

                                                    if ($appointment_id == "") {
                                                        break;
                                                    }

                                                    echo '
                                            <td style="width: 25%;">
                                                    <div  class="dashboard-items search-items"  >
                                                    
                                                        <div style="width:100%;">
                                                        <div class="h3-search">
                                                                    Data Programării: ' . substr($appointment_date, 0, 30) . '<br>
                                                                    Codul: OC-000-' . $appointment_id . '
                                                                </div>
                                                                <div class="h1-search">
                                                                    ' . substr($service_name, 0, 21) . '<br>
                                                                </div>
                                                                <div class="h3-search">
                                                                    ' . substr($doctor_name, 0, 30) . '
                                                                </div>
                                                                
                                                                
                                                                <div class="h4-search">
                                                                    Ora: <b>' . substr($appointment_time, 0, 5) . '</b> (1h)
                                                                </div>
                                                                <br>
                                                                <a href="?action=drop&id=' . $appointment_id . '&service=' . $service_name . '&doctor=' . $doctor_name . '" >
                                                                    <button  class="login-btn btn-primary-soft btn "  style="padding-top:11px;padding-bottom:11px;width:100%">
                                                                        <font class="tn-in-text">Anulare Programare</font>
                                                                    </button>
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
    <?php

    if ($_GET) {
        $action = $_GET["action"];
        if ($action == 'booking-added') {
            ?>
                            <div id="popup1" class="overlay">
                                <div class="popup">
                                    <center>
                                        <br><br>
                                        <h2>Programarea dvs. a fost realizată cu succes!</h2>
                                        <a class="close" href="appointment.php">&times;</a>
                                        <div style="display: flex;justify-content: center;">

                                            <a href="appointment.php" class="non-style-link"><button class="btn-primary btn"
                                                    style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;">
                                                    <font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font>
                                                </button></a>
                                            <br><br><br><br>
                                        </div>
                                    </center>
                                </div>
                            </div>
                            <?php
        } elseif ($action == 'drop') {
            $appointment_id = $_GET["id"];
            $service_name = $_GET["service"];
            $doctor_name = $_GET["doctor"];

            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <h2>Doriti sa anulati programarea?</h2>
                        <a class="close" href="appointment.php">&times;</a>
                        <div class="content">
                            Denumire serviciu: &nbsp;<b>' . substr($service_name, 0, 40) . '</b><br><br>
                            Nume medic: &nbsp;<b>' . substr($doctor_name, 0, 40) . '</b><br><br>
                        </div>                       
                        <div style="display: flex;justify-content: center;">
                        <a href="delete-appointment.php?id=' . $appointment_id . '" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Da&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                        <a href="appointment.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;Nu&nbsp;&nbsp;</font></button></a>
                        </div>
                    </center>
            </div>
            </div>
            ';
        }
        // elseif ($action == 'view') {
        //     $sqlmain = "select * from doctor where docid=?";
        //     $stmt = $database->prepare($sqlmain);
        //     $stmt->bind_param("i", $id);
        //     $stmt->execute();
        //     $result = $stmt->get_result();
        //     $row = $result->fetch_assoc();
        //     $name = $row["docname"];
        //     $email = $row["docemail"];
        //     $spe = $row["specialties"];
    
        //     $sqlmain = "select sname from specialties where id=?";
        //     $stmt = $database->prepare($sqlmain);
        //     $stmt->bind_param("s", $spe);
        //     $stmt->execute();
        //     $spcil_res = $stmt->get_result();
        //     $spcil_array = $spcil_res->fetch_assoc();
        //     $spcil_name = $spcil_array["sname"];
        //     $nic = $row['docnic'];
        //     $tele = $row['doctel'];
        //     echo '
        //     <div id="popup1" class="overlay">
        //             <div class="popup">
        //             <center>
        //                 <h2></h2>
        //                 <a class="close" href="doctors.php">&times;</a>
        //                 <div class="content">
        //                     eDoc Web App<br>
    
        //                 </div>
        //                 <div style="display: flex;justify-content: center;">
        //                 <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
    
        //                     <tr>
        //                         <td>
        //                             <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">View Details.</p><br><br>
        //                         </td>
        //                     </tr>
    
        //                     <tr>
    
        //                         <td class="label-td" colspan="2">
        //                             <label for="name" class="form-label">Name: </label>
        //                         </td>
        //                     </tr>
        //                     <tr>
        //                         <td class="label-td" colspan="2">
        //                             ' . $name . '<br><br>
        //                         </td>
    
        //                     </tr>
        //                     <tr>
        //                         <td class="label-td" colspan="2">
        //                             <label for="Email" class="form-label">Email: </label>
        //                         </td>
        //                     </tr>
        //                     <tr>
        //                         <td class="label-td" colspan="2">
        //                         ' . $email . '<br><br>
        //                         </td>
        //                     </tr>
        //                     <tr>
        //                         <td class="label-td" colspan="2">
        //                             <label for="nic" class="form-label">NIC: </label>
        //                         </td>
        //                     </tr>
        //                     <tr>
        //                         <td class="label-td" colspan="2">
        //                         ' . $nic . '<br><br>
        //                         </td>
        //                     </tr>
        //                     <tr>
        //                         <td class="label-td" colspan="2">
        //                             <label for="Tele" class="form-label">Număr de telefon: </label>
        //                         </td>
        //                     </tr>
        //                     <tr>
        //                         <td class="label-td" colspan="2">
        //                         ' . $tele . '<br><br>
        //                         </td>
        //                     </tr>
        //                     <tr>
        //                         <td class="label-td" colspan="2">
        //                             <label for="spec" class="form-label">Specialties: </label>
    
        //                         </td>
        //                     </tr>
        //                     <tr>
        //                     <td class="label-td" colspan="2">
        //                     ' . $spcil_name . '<br><br>
        //                     </td>
        //                     </tr>
        //                     <tr>
        //                         <td colspan="2">
        //                             <a href="doctors.php"><input type="button" value="OK" class="login-btn btn-primary-soft btn" ></a>
    

        //                         </td>
    
        //                     </tr>
    

        //                 </table>
        //                 </div>
        //             </center>
        //             <br><br>
        //     </div>
        //     </div>
        //     ';
        // }
    }

    ?>
    </div>

</body>

</html>