<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">

    <title>Orar</title>
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

    include("../connection.php");

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
                        <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Orar</p>

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
                    <td colspan="4" style="padding-top:10px;width: 100%;">

                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">
                            <!-- Orar -->
                        </p>
                    </td>

                </tr>

                <tr>
                </tr>
            </table>

            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr class="bg-light-gray">
                            <th class="text-uppercase">Ora</th>
                            <th class="text-uppercase">Luni</th>
                            <th class="text-uppercase">Marți</th>
                            <th class="text-uppercase">Miercuri</th>
                            <th class="text-uppercase">Joi</th>
                            <th class="text-uppercase">Vineri</th>
                            <th class="text-uppercase">Sâmbătă</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="align-middle">09:00</td>
                            <td>
                                <span
                                    class="bg-purple padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">Implant
                                    dentar</span>
                                <div class="margin-10px-top font-size14">09:00-10:00</div>
                                <div class="font-size13 text-light-gray">Ana Vasile</div>
                            </td>
                            <td>
                                <span
                                    class="bg-sky padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">Coroane
                                    și punți</span>
                                <div class="margin-10px-top font-size14">09:00-10:00</div>
                                <div class="font-size13 text-light-gray">George Dumitru</div>
                            </td>
                            <td>
                                <span
                                    class="bg-purple padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">Implant
                                    dentar</span>
                                <div class="margin-10px-top font-size14">09:00-10:00</div>
                                <div class="font-size13 text-light-gray">Elena Radu</div>
                            </td>
                            <td>
                                <span
                                    class="bg-purple padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">Implant
                                    dentar</span>
                                <div class="margin-10px-top font-size14">09:00-10:00</div>
                                <div class="font-size13 text-light-gray">Mihai Enache</div>
                            </td>
                            <td>
                                <span
                                    class="bg-sky padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">Coroane
                                    și punți</span>
                                <div class="margin-10px-top font-size14">09:00-10:00</div>
                                <div class="font-size13 text-light-gray">Laura Costache</div>
                            </td>
                            <td class="bg-light-gray"></td>
                        </tr>
                        <tr>
                            <td class="align-middle">10:00</td>
                            <td>
                                <span
                                    class="bg-sky padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">Coroane
                                    și punți</span>
                                <div class="margin-10px-top font-size14">10:00-11:00</div>
                                <div class="font-size13 text-light-gray">Elena Radu</div>
                            </td>
                            <td class="bg-light-gray"></td>
                            <td>
                                <span
                                    class="bg-purple padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">Implant
                                    dentar</span>
                                <div class="margin-10px-top font-size14">10:00-11:00</div>
                                <div class="font-size13 text-light-gray">Mihai Enache</div>
                            </td>
                            <td>
                                <span
                                    class="bg-sky padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">Coroane
                                    și punți</span>
                                <div class="margin-10px-top font-size14">10:00-11:00</div>
                                <div class="font-size13 text-light-gray">Laura Costache</div>
                            </td>
                            <td>
                                <span
                                    class="bg-purple padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">Implant
                                    dentar</span>
                                <div class="margin-10px-top font-size14">10:00-11:00</div>
                                <div class="font-size13 text-light-gray">Ana Vasile</div>
                            </td>
                            <td class="bg-light-gray"></td>
                        </tr>
                        <tr>
                            <td class="align-middle">11:00</td>
                            <td>
                                <span
                                    class="bg-lightred padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">Pauză</span>
                                <div class="margin-10px-top font-size14">11:00-12:00</div>
                            </td>
                            <td>
                                <span
                                    class="bg-lightred padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">Pauză</span>
                                <div class="margin-10px-top font-size14">11:00-12:00</div>
                            </td>
                            <td>
                                <span
                                    class="bg-lightred padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">Pauză</span>
                                <div class="margin-10px-top font-size14">11:00-12:00</div>
                            </td>
                            <td>
                                <span
                                    class="bg-lightred padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">Pauză</span>
                                <div class="margin-10px-top font-size14">11:00-12:00</div>
                            </td>
                            <td>
                                <span
                                    class="bg-lightred padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">Pauză</span>
                                <div class="margin-10px-top font-size14">11:00-12:00</div>
                            </td>
                            <td>
                                <span
                                    class="bg-lightred padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">Pauză</span>
                                <div class="margin-10px-top font-size14">11:00-12:00</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle">12:00</td>
                            <td>
                                <span
                                    class="bg-purple padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">Implant
                                    dentar</span>
                                <div class="margin-10px-top font-size14">12:00-13:00</div>
                                <div class="font-size13 text-light-gray">George Dumitru</div>
                            </td>
                            <td class="bg-light-gray"></td>
                            <td>
                                <span
                                    class="bg-sky padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">Coroane
                                    și punți</span>
                                <div class="margin-10px-top font-size14">12:00-13:00</div>
                                <div class="font-size13 text-light-gray">Laura Costache</div>
                            </td>
                            <td>
                                <span
                                    class="bg-purple padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">Implant
                                    dentar</span>
                                <div class="margin-10px-top font-size14">12:00-13:00</div>
                                <div class="font-size13 text-light-gray">Elena Radu</div>
                            </td>
                            <td class="bg-light-gray"></td>
                            <td>
                                <span
                                    class="bg-sky padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">Coroane
                                    și punți</span>
                                <div class="margin-10px-top font-size14">12:00-13:00</div>
                                <div class="font-size13 text-light-gray">Mihai Enache</div>
                            </td>
                        </tr>
                        <!-- Poți extinde tabelul cu același model până la ora 16:00 -->
                    </tbody>
                </table>
            </div>


        </div>
    </div>
    <?php

    if ($_GET) {
        $id = $_GET["id"];
        $action = $_GET["action"];
    }

    ?>
    </div>

</body>

</html>