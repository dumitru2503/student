<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">

    <title>Patients</title>
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

    include("../connection.php");

    $filter_default = "name_asc";
    $filter = isset($_GET['filter']) ? $_GET['filter'] : $filter_default;

    $sql = "SELECT u.id AS pid, u.name AS pname, u.email AS pemail, u.phone AS pphone
    FROM appointment AS a 
    INNER JOIN users AS u ON a.patient_id = u.id 
    WHERE a.doctor_id = ? 
    GROUP BY a.patient_id 
    ORDER BY u.name";

    if ($filter == "name_asc") {
        $sql .= " ASC";
    } else if ($filter == "name_desc") {
        $sql .= " DESC";
    }

    $stmt = $database->prepare($sql);
    $stmt->bind_param("s", $user_id);

    $stmt->execute();
    $patients = $stmt->get_result();


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

                        <form action="" method="post" class="header-search">

                            <input type="search" name="search12" class="input-text header-searchbar"
                                placeholder="Search Patient name or Email" list="patient">&nbsp;&nbsp;

                            <input type="Submit" value="Căutare" name="search" class="login-btn btn-primary btn"
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
                    <td colspan="4" style="padding-top:10px;">
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">
                            <?php echo "Pacienti (" . $patients->num_rows . ")"; ?>
                        </p>
                    </td>

                </tr>
                <tr>
                    <td colspan="4" style="padding-top:0px;width: 100%;">
                        <center>
                            <table class="filter-container" border="0">

                                <form action="./patient.php" method="GET">

                                    <td style="text-align: right;">
                                        Ordoneaza:&nbsp;
                                    </td>
                                    <td width="30%">
                                        <select name="filter" id="filter" class="box filter-container-items"
                                            style="width:90% ;height: 37px;margin: 0;">
                                            <!-- <option disabled selected hidden></option> -->
                                            <option value="name_asc" <?php echo $filter == "name_asc" ? "selected" : "" ?>>
                                                A-Z
                                            </option>
                                            <option value="name_desc" <?php echo $filter == "name_desc" ? "selected" : "" ?>>
                                                Z-A
                                            </option>
                                        </select>
                                    </td>
                                    <td width="12%">
                                        <input type="submit" value=" Filtrare"
                                            class=" btn-primary-soft btn button-icon btn-filter"
                                            style="padding: 15px; margin :0;width:100%">
                                </form>
                    </td>

                </tr>
            </table>

            </center>
            </td>

            </tr>

            <tr>
                <td colspan="4">
                    <center>
                        <div class="abc scroll">
                            <table width="93%" class="sub-table scrolldown" style="border-spacing:0;">
                                <thead>
                                    <tr>
                                        <th class="table-headin">
                                            Name
                                        </th>
                                        <th class="table-headin">
                                            Telephone
                                        </th>
                                        <th class="table-headin">
                                            Email
                                        </th>
                                        <th class="table-headin">
                                            Date of Birth
                                        </th>
                                        <th class="table-headin">
                                            Events
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    for ($x = 0; $x < $patients->num_rows; $x++) {
                                        $row = $patients->fetch_assoc();
                                        $id = $row["pid"];
                                        $name = $row["pname"];
                                        $email = $row["pemail"];
                                        $dob = "2000-01-01";
                                        $phone = $row["pphone"];

                                        ?>
                                        <tr>
                                            <td style="font-weight:600;text-align:center;">
                                                &nbsp;<?php echo substr($name, 0, 25); ?></td>
                                            <td style="text-align:center;"><?php echo substr($phone, 0, 25); ?>
                                            </td>
                                            <td style="text-align:center;"><?php echo $email; ?></td>
                                            <td style="text-align:center;"><?php echo $dob; ?></td>
                                            <td style="text-align:center;">
                                                <div style="display:flex;justify-content: center;">
                                                    <a href="?action=view&id=<?php echo $id; ?>" class="non-style-link">
                                                        <button class="btn-primary-soft btn button-icon btn-view"
                                                            style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;">
                                                            <font class="tn-in-text">Detalii</font>
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



            </table>
        </div>
    </div>
    <?php
    if ($_GET) {

        $id = $_GET["id"];
        $action = $_GET["action"];
        $sqlmain = "select * from patient where pid='$id'";
        $result = $database->query($sqlmain);
        $row = $result->fetch_assoc();
        $name = $row["pname"];
        $email = $row["pemail"];
        $nic = $row["pnic"];
        $dob = $row["pdob"];
        $tele = $row["ptel"];
        $address = $row["paddress"];
        echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <a class="close" href="patient.php">&times;</a>
                        <div class="content">

                        </div>
                        <div style="display: flex;justify-content: center;">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        
                            <tr>
                                <td>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">View Details.</p><br><br>
                                </td>
                            </tr>
                            <tr>
                                
                                <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">Patient ID: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    P-' . $id . '<br><br>
                                </td>
                                
                            </tr>
                            
                            <tr>
                                
                                <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">Name: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    ' . $name . '<br><br>
                                </td>
                                
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Email" class="form-label">Email: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                ' . $email . '<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="nic" class="form-label">NIC: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                ' . $nic . '<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Tele" class="form-label">Telephone: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                ' . $tele . '<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="spec" class="form-label">Address: </label>
                                    
                                </td>
                            </tr>
                            <tr>
                            <td class="label-td" colspan="2">
                            ' . $address . '<br><br>
                            </td>
                            </tr>
                            <tr>
                                
                                <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">Date of Birth: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    ' . $dob . '<br><br>
                                </td>
                                
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="patient.php"><input type="button" value="OK" class="login-btn btn-primary-soft btn" ></a>
                                
                                    
                                </td>
                
                            </tr>
                           

                        </table>
                        </div>
                    </center>
                    <br><br>
            </div>
            </div>
            ';

    }
    ;

    ?>
    </div>

</body>

</html>