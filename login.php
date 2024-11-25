<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/login.css">

    <title>Autentificare</title>
</head>

<body class="main-background">
    <?php

    session_start();

    $_SESSION["user_email"] = "";
    $_SESSION["user_type"] = "";

    date_default_timezone_set('Europe/Bucharest');
    $date = date('Y-m-d');

    $_SESSION["date"] = $date;

    include("connection.php");

    $error = '<label for="promter" class="form-label"></label>';

    if ($_POST) {

        $email = $_POST['email'];
        $password = $_POST['password'];

        $result = $database->query("select * from users where email='$email'");
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $user_type = $user['type'];
            $user_password = $user['password'];
            $user_name = $user['name'];
            $user_email = $user['email'];
            $user_id = $user['id'];

            // TODO: USE PASSWORD_HASH
            if ($password == $user_password) {

                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_email'] = $user_email;
                $_SESSION['user_name'] = $user_name;
                $_SESSION['user_type'] = $user_type;

                switch ($user_type) {
                    case 'a':
                        header('location: admin/index.php');
                        break;
                    case 'p':
                        header('location: patient/index.php');
                        break;
                    case 'd':
                        header('location: doctor/index.php');
                        break;
                }

            } else {
                $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Date incorecte: Email sau parolă invalidă</label>';
            }

        } else {
            $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Nu am găsit niciun cont pentru acest email.</label>';
        }
    }

    ?>

    <center>
        <div class="container">
            <table border="0" style="margin: 0;padding: 0;width: 60%;">
                <tr>
                    <td>
                        <p class="header-text">Bine ai revenit!</p>
                    </td>
                </tr>
                <div class="form-body">
                    <tr>
                        <td>
                            <p class="sub-text">Autentifică-te pentru a continua</p>
                        </td>
                    </tr>
                    <tr>
                        <form action="" method="POST">
                            <td class="label-td">
                                <label for="email" class="form-label">Email: </label>
                            </td>
                    </tr>
                    <tr>
                        <td class="label-td">
                            <input type="email" name="email" class="input-text" placeholder="Adresă de email" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td">
                            <label for="password" class="form-label">Parolă: </label>
                        </td>
                    </tr>

                    <tr>
                        <td class="label-td">
                            <input type="Password" name="password" class="input-text" placeholder="Parolă" required>
                        </td>
                    </tr>

                    <tr>
                        <td><br>
                            <?php echo $error ?>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input type="submit" value="Autentifică-te" class="login-btn btn-primary btn">
                        </td>
                    </tr>
                </div>
                <tr>
                    <td>
                        <br>
                        <label for="" class="sub-text" style="font-weight: 280;">Nu ai un cont&#63; </label>
                        <a href="signup.php" class="hover-link1 non-style-link">Înregistrează-te</a>
                        <br><br><br>
                    </td>
                </tr>

                </form>
            </table>
        </div>
    </center>
</body>

</html>