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

    if (isset($_SESSION["user_email"]) && $_SESSION["user_email"] != "" && $_SESSION['user_type'] == 'a') {
        $user_id = $_SESSION['user_id'];
        $user_email = $_SESSION["user_email"];
        $user_name = $_SESSION['user_name'];
    } else {
        header("location: ../login.php");
    }

    date_default_timezone_set('Europe/Bucharest');

    $today = date('Y-m-d');

    include("../connection.php");

    $type_doctor = "d";
    $stmt = $database->prepare("SELECT * FROM users WHERE type = ?");
    $stmt->bind_param("s", $type_doctor);
    $stmt->execute();
    $doctors = $stmt->get_result();


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

                        <form action="" method="GET" class="header-search">

                            <input type="search" name="search" class="input-text header-searchbar"
                                placeholder="Search Doctor name or Email" list="doctors">&nbsp;&nbsp;


                            <input type="Submit" value="Search" class="login-btn btn-primary btn"
                                style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">

                        </form>

                    </td>
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Data de azi
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php echo $today ?>
                        </p>
                    </td>
                    <td width="10%">
                        <button class="btn-label"
                            style="display: flex;justify-content: center;align-items: center;"><img
                                src="../img/calendar.svg" width="100%"></button>
                    </td>


                </tr>

                <tr>
                    <td colspan="2" style="padding-top:30px;">
                        <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">
                            Add New Doctor
                        </p>
                    </td>
                    <td colspan="2">
                        <a href="?action=add" class="non-style-link">
                            <button class="login-btn btn-primary btn button-icon"
                                style="display: flex;justify-content: center;align-items: center;margin-left:75px;background-image: url('../img/icons/add.svg');">
                                Add New
                            </button>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:10px;">
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">
                            Medici (<?php echo $doctors->num_rows; ?>)</p>
                    </td>

                </tr>

                <tr>
                    <td colspan="4">
                        <center>
                            <div class="abc scroll">
                                <table width="93%" class="sub-table scrolldown doctors-table" border="0">
                                    <thead>
                                        <tr>
                                            <th class="table-headin">


                                                Nume medic

                                            </th>
                                            <th class="table-headin">
                                                Email
                                            </th>
                                            <th class="table-headin">

                                                Servicii

                                            </th>
                                            <th class="table-headin">

                                                Actiuni

                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php

                                        if ($doctors->num_rows == 0) {
                                            ?>
                                            <tr>
                                                <td colspan="4">
                                                    <br><br><br><br>
                                                    <center>
                                                        <img src="../img/notfound.svg" width="25%">

                                                        <br>
                                                        <p class="heading-main12"
                                                            style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">
                                                            We couldnt find anything related to your keywords !</p>
                                                        <a class="non-style-link" href="doctors.php"><button
                                                                class="login-btn btn-primary-soft btn"
                                                                style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp;
                                                                Show all Doctors &nbsp;</font></button>
                                                        </a>
                                                    </center>
                                                    <br><br><br><br>
                                                </td>
                                            </tr>
                                            <?php

                                        } else {
                                            while ($doctor = $doctors->fetch_assoc()) {

                                                $doctor_id = $doctor["id"];
                                                $doctor_name = $doctor["name"];
                                                $doctor_email = $doctor["email"];

                                                // Using prepared statement with bound parameters
                                                $stmt = $database->prepare("SELECT s.name AS service_name 
                                                                            FROM doctor_services AS ds
                                                                            INNER JOIN services AS s ON ds.service_id = s.id 
                                                                            WHERE doctor_id = ?");
                                                $stmt->bind_param("i", $doctor_id); // Assuming doctor_id is an integer
                                                $stmt->execute();
                                                $services = $stmt->get_result();


                                                ?>

                                                <tr>
                                                    <td> &nbsp;<?php echo substr($doctor_name, 0, 30); ?></td>
                                                    <td><?php echo substr($doctor_email, 0, 20); ?></td>

                                                    <td>
                                                        <?php while ($service = $services->fetch_assoc()) { ?>
                                                            <p><?php echo substr($service["service_name"], 0, 20); ?></p>
                                                        <?php } ?>
                                                    </td>

                                                    <td>
                                                        <div style="display:flex;justify-content: center;">
                                                            <a href="?action=edit&id=<?php echo $doctor_id; ?>&error=0"
                                                                class="non-style-link">
                                                                <button class="btn-primary-soft btn button-icon btn-edit"
                                                                    style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;">
                                                                    <font class="tn-in-text">Edit</font>
                                                                </button>
                                                            </a>
                                                            &nbsp;&nbsp;&nbsp;
                                                            <a href="?action=view&id=<?php echo $doctor_id; ?>"
                                                                class="non-style-link">
                                                                <button class="btn-primary-soft btn button-icon btn-view"
                                                                    style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;">
                                                                    <font class="tn-in-text">View</font>
                                                                </button>
                                                            </a>
                                                            &nbsp;&nbsp;&nbsp;
                                                            <a href="?action=drop&id=<?php echo $doctor_id; ?>&name=<?php echo $doctor_name; ?>"
                                                                class="non-style-link">
                                                                <button class="btn-primary-soft btn button-icon btn-delete"
                                                                    style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;">
                                                                    <font class="tn-in-text">Remove</font>
                                                                </button>
                                                            </a>
                                                        </div>
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
    <?php
    // if ($_GET) {
    
    //     $id = $_GET["id"];
    //     $action = $_GET["action"];
    //     if ($action == 'drop') {
    //         $nameget = $_GET["name"];
    //         echo '
    //         <div id="popup1" class="overlay">
    //                 <div class="popup">
    //                 <center>
    //                     <h2>Are you sure?</h2>
    //                     <a class="close" href="doctors.php">&times;</a>
    //                     <div class="content">
    //                         You want to delete this record<br>(' . substr($nameget, 0, 40) . ').
    
    //                     </div>
    //                     <div style="display: flex;justify-content: center;">
    //                     <a href="delete-doctor.php?id=' . $id . '" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Da&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
    //                     <a href="doctors.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;Nu&nbsp;&nbsp;</font></button></a>
    
    //                     </div>
    //                 </center>
    //         </div>
    //         </div>
    //         ';
    //     } elseif ($action == 'view') {
    //         $sqlmain = "select * from doctor where docid='$id'";
    //         $result = $database->query($sqlmain);
    //         $row = $result->fetch_assoc();
    //         $name = $row["docname"];
    //         $email = $row["docemail"];
    //         $spe = $row["specialties"];
    
    //         $spcil_res = $database->query("select sname from specialties where id='$spe'");
    //         $spcil_array = $spcil_res->fetch_assoc();
    //         $spcil_name = $spcil_array["sname"];
    //         $nic = $row['docnic'];
    //         $tele = $row['doctel'];
    //         echo '
    //         <div id="popup1" class="overlay">
    //                 <div class="popup">
    //                 <center>
    //                     <h2></h2>
    //                     <a class="close" href="doctors.php">&times;</a>
    //                     <div class="content">
    //                         eDoc Web App<br>
    
    //                     </div>
    //                     <div style="display: flex;justify-content: center;">
    //                     <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
    
    //                         <tr>
    //                             <td>
    //                                 <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">View Details.</p><br><br>
    //                             </td>
    //                         </tr>
    
    //                         <tr>
    
    //                             <td class="label-td" colspan="2">
    //                                 <label for="name" class="form-label">Name: </label>
    //                             </td>
    //                         </tr>
    //                         <tr>
    //                             <td class="label-td" colspan="2">
    //                                 ' . $name . '<br><br>
    //                             </td>
    
    //                         </tr>
    //                         <tr>
    //                             <td class="label-td" colspan="2">
    //                                 <label for="Email" class="form-label">Email: </label>
    //                             </td>
    //                         </tr>
    //                         <tr>
    //                             <td class="label-td" colspan="2">
    //                             ' . $email . '<br><br>
    //                             </td>
    //                         </tr>
    //                         <tr>
    //                             <td class="label-td" colspan="2">
    //                                 <label for="nic" class="form-label">NIC: </label>
    //                             </td>
    //                         </tr>
    //                         <tr>
    //                             <td class="label-td" colspan="2">
    //                             ' . $nic . '<br><br>
    //                             </td>
    //                         </tr>
    //                         <tr>
    //                             <td class="label-td" colspan="2">
    //                                 <label for="Tele" class="form-label">Telephone: </label>
    //                             </td>
    //                         </tr>
    //                         <tr>
    //                             <td class="label-td" colspan="2">
    //                             ' . $tele . '<br><br>
    //                             </td>
    //                         </tr>
    //                         <tr>
    //                             <td class="label-td" colspan="2">
    //                                 <label for="spec" class="form-label">Specialties: </label>
    
    //                             </td>
    //                         </tr>
    //                         <tr>
    //                         <td class="label-td" colspan="2">
    //                         ' . $spcil_name . '<br><br>
    //                         </td>
    //                         </tr>
    //                         <tr>
    //                             <td colspan="2">
    //                                 <a href="doctors.php"><input type="button" value="OK" class="login-btn btn-primary-soft btn" ></a>
    

    //                             </td>
    
    //                         </tr>
    

    //                     </table>
    //                     </div>
    //                 </center>
    //                 <br><br>
    //         </div>
    //         </div>
    //         ';
    //     } elseif ($action == 'add') {
    //         $error_1 = $_GET["error"];
    //         $errorlist = array(
    //             '1' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Already have an account for this Email address.</label>',
    //             '2' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Password Conformation Error! Reconform Password</label>',
    //             '3' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;"></label>',
    //             '4' => "",
    //             '0' => '',
    
    //         );
    //         if ($error_1 != '4') {
    //             echo '
    //         <div id="popup1" class="overlay">
    //                 <div class="popup">
    //                 <center>
    
    //                     <a class="close" href="doctors.php">&times;</a> 
    //                     <div style="display: flex;justify-content: center;">
    //                     <div class="abc">
    //                     <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
    //                     <tr>
    //                             <td class="label-td" colspan="2">' .
    //                 $errorlist[$error_1]
    //                 . '</td>
    //                         </tr>
    //                         <tr>
    //                             <td>
    //                                 <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Add New Doctor.</p><br><br>
    //                             </td>
    //                         </tr>
    
    //                         <tr>
    //                             <form action="add-new.php" method="POST" class="add-new-form">
    //                             <td class="label-td" colspan="2">
    //                                 <label for="name" class="form-label">Name: </label>
    //                             </td>
    //                         </tr>
    //                         <tr>
    //                             <td class="label-td" colspan="2">
    //                                 <input type="text" name="name" class="input-text" placeholder="Doctor Name" required><br>
    //                             </td>
    
    //                         </tr>
    //                         <tr>
    //                             <td class="label-td" colspan="2">
    //                                 <label for="Email" class="form-label">Email: </label>
    //                             </td>
    //                         </tr>
    //                         <tr>
    //                             <td class="label-td" colspan="2">
    //                                 <input type="email" name="email" class="input-text" placeholder="Email Address" required><br>
    //                             </td>
    //                         </tr>
    //                         <tr>
    //                             <td class="label-td" colspan="2">
    //                                 <label for="nic" class="form-label">NIC: </label>
    //                             </td>
    //                         </tr>
    //                         <tr>
    //                             <td class="label-td" colspan="2">
    //                                 <input type="text" name="nic" class="input-text" placeholder="NIC Number" required><br>
    //                             </td>
    //                         </tr>
    //                         <tr>
    //                             <td class="label-td" colspan="2">
    //                                 <label for="Tele" class="form-label">Telephone: </label>
    //                             </td>
    //                         </tr>
    //                         <tr>
    //                             <td class="label-td" colspan="2">
    //                                 <input type="tel" name="Tele" class="input-text" placeholder="Telephone Number" required><br>
    //                             </td>
    //                         </tr>
    //                         <tr>
    //                             <td class="label-td" colspan="2">
    //                                 <label for="spec" class="form-label">Choose specialties: </label>
    
    //                             </td>
    //                         </tr>
    //                         <tr>
    //                             <td class="label-td" colspan="2">
    //                                 <select name="spec" id="" class="box" >';
    

    //             $list11 = $database->query("select  * from  specialties order by sname asc;");
    
    //             for ($y = 0; $y < $list11->num_rows; $y++) {
    //                 $row00 = $list11->fetch_assoc();
    //                 $sn = $row00["sname"];
    //                 $id00 = $row00["id"];
    //                 echo "<option value=" . $id00 . ">$sn</option><br/>";
    //             }
    //             ;
    



    //             echo '       </select><br>
    //                             </td>
    //                         </tr>
    //                         <tr>
    //                             <td class="label-td" colspan="2">
    //                                 <label for="password" class="form-label">Password: </label>
    //                             </td>
    //                         </tr>
    //                         <tr>
    //                             <td class="label-td" colspan="2">
    //                                 <input type="password" name="password" class="input-text" placeholder="Defind a Password" required><br>
    //                             </td>
    //                         </tr><tr>
    //                             <td class="label-td" colspan="2">
    //                                 <label for="cpassword" class="form-label">Conform Password: </label>
    //                             </td>
    //                         </tr>
    //                         <tr>
    //                             <td class="label-td" colspan="2">
    //                                 <input type="password" name="cpassword" class="input-text" placeholder="Conform Password" required><br>
    //                             </td>
    //                         </tr>
    

    //                         <tr>
    //                             <td colspan="2">
    //                                 <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    
    //                                 <input type="submit" value="Add" class="login-btn btn-primary btn">
    //                             </td>
    
    //                         </tr>
    
    //                         </form>
    //                         </tr>
    //                     </table>
    //                     </div>
    //                     </div>
    //                 </center>
    //                 <br><br>
    //         </div>
    //         </div>
    //         ';
    
    //         } else {
    //             echo '
    //                 <div id="popup1" class="overlay">
    //                         <div class="popup">
    //                         <center>
    //                         <br><br><br><br>
    //                             <h2>New Record Added Successfully!</h2>
    //                             <a class="close" href="doctors.php">&times;</a>
    //                             <div class="content">
    

    //                             </div>
    //                             <div style="display: flex;justify-content: center;">
    
    //                             <a href="doctors.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
    
    //                             </div>
    //                             <br><br>
    //                         </center>
    //                 </div>
    //                 </div>
    //     ';
    //         }
    //     } elseif ($action == 'edit') {
    //         $sqlmain = "select * from doctor where docid='$id'";
    //         $result = $database->query($sqlmain);
    //         $row = $result->fetch_assoc();
    //         $name = $row["docname"];
    //         $email = $row["docemail"];
    //         $spe = $row["specialties"];
    
    //         $spcil_res = $database->query("select sname from specialties where id='$spe'");
    //         $spcil_array = $spcil_res->fetch_assoc();
    //         $spcil_name = $spcil_array["sname"];
    //         $nic = $row['docnic'];
    //         $tele = $row['doctel'];
    
    //         $error_1 = $_GET["error"];
    //         $errorlist = array(
    //             '1' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Already have an account for this Email address.</label>',
    //             '2' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Password Conformation Error! Reconform Password</label>',
    //             '3' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;"></label>',
    //             '4' => "",
    //             '0' => '',
    
    //         );
    
    //         if ($error_1 != '4') {
    //             echo '
    //                 <div id="popup1" class="overlay">
    //                         <div class="popup">
    //                         <center>
    
    //                             <a class="close" href="doctors.php">&times;</a> 
    //                             <div style="display: flex;justify-content: center;">
    //                             <div class="abc">
    //                             <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
    //                             <tr>
    //                                     <td class="label-td" colspan="2">' .
    //                 $errorlist[$error_1]
    //                 . '</td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td>
    //                                         <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Edit Doctor Details.</p>
    //                                     Doctor ID : ' . $id . ' (Auto Generated)<br><br>
    //                                     </td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td class="label-td" colspan="2">
    //                                         <form action="edit-doc.php" method="POST" class="add-new-form">
    //                                         <label for="Email" class="form-label">Email: </label>
    //                                         <input type="hidden" value="' . $id . '" name="id00">
    //                                         <input type="hidden" name="oldemail" value="' . $email . '" >
    //                                     </td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td class="label-td" colspan="2">
    //                                     <input type="email" name="email" class="input-text" placeholder="Email Address" value="' . $email . '" required><br>
    //                                     </td>
    //                                 </tr>
    //                                 <tr>
    
    //                                     <td class="label-td" colspan="2">
    //                                         <label for="name" class="form-label">Name: </label>
    //                                     </td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td class="label-td" colspan="2">
    //                                         <input type="text" name="name" class="input-text" placeholder="Doctor Name" value="' . $name . '" required><br>
    //                                     </td>
    
    //                                 </tr>
    
    //                                 <tr>
    //                                     <td class="label-td" colspan="2">
    //                                         <label for="nic" class="form-label">NIC: </label>
    //                                     </td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td class="label-td" colspan="2">
    //                                         <input type="text" name="nic" class="input-text" placeholder="NIC Number" value="' . $nic . '" required><br>
    //                                     </td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td class="label-td" colspan="2">
    //                                         <label for="Tele" class="form-label">Telephone: </label>
    //                                     </td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td class="label-td" colspan="2">
    //                                         <input type="tel" name="Tele" class="input-text" placeholder="Telephone Number" value="' . $tele . '" required><br>
    //                                     </td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td class="label-td" colspan="2">
    //                                         <label for="spec" class="form-label">Choose specialties: (Current' . $spcil_name . ')</label>
    
    //                                     </td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td class="label-td" colspan="2">
    //                                         <select name="spec" id="" class="box">';
    

    //             $list11 = $database->query("select  * from  specialties;");
    
    //             for ($y = 0; $y < $list11->num_rows; $y++) {
    //                 $row00 = $list11->fetch_assoc();
    //                 $sn = $row00["sname"];
    //                 $id00 = $row00["id"];
    //                 echo "<option value=" . $id00 . ">$sn</option><br/>";
    //             }
    //             ;
    



    //             echo '       </select><br><br>
    //                                     </td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td class="label-td" colspan="2">
    //                                         <label for="password" class="form-label">Password: </label>
    //                                     </td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td class="label-td" colspan="2">
    //                                         <input type="password" name="password" class="input-text" placeholder="Defind a Password" required><br>
    //                                     </td>
    //                                 </tr><tr>
    //                                     <td class="label-td" colspan="2">
    //                                         <label for="cpassword" class="form-label">Conform Password: </label>
    //                                     </td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td class="label-td" colspan="2">
    //                                         <input type="password" name="cpassword" class="input-text" placeholder="Conform Password" required><br>
    //                                     </td>
    //                                 </tr>
    

    //                                 <tr>
    //                                     <td colspan="2">
    //                                         <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    
    //                                         <input type="submit" value="Save" class="login-btn btn-primary btn">
    //                                     </td>
    
    //                                 </tr>
    
    //                                 </form>
    //                                 </tr>
    //                             </table>
    //                             </div>
    //                             </div>
    //                         </center>
    //                         <br><br>
    //                 </div>
    //                 </div>
    //                 ';
    //         } else {
    //             echo '
    //             <div id="popup1" class="overlay">
    //                     <div class="popup">
    //                     <center>
    //                     <br><br><br><br>
    //                         <h2>Edit Successfully!</h2>
    //                         <a class="close" href="doctors.php">&times;</a>
    //                         <div class="content">
    

    //                         </div>
    //                         <div style="display: flex;justify-content: center;">
    
    //                         <a href="doctors.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
    
    //                         </div>
    //                         <br><br>
    //                     </center>
    //             </div>
    //             </div>
    // ';
    


    //         }
    //         ;
    //     }
    //     ;
    // }
    ;

    ?>
    </div>

</body>

</html>