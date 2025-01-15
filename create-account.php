<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/signup.css">

    <title>Crează un cont</title>
    <style>
        .container {
            animation: transitionIn-X 0.5s;
        }
    </style>
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


    if ($_POST) {

        $fname = $_SESSION['personal']['fname'];
        $lname = $_SESSION['personal']['lname'];
        $name = $fname . " " . $lname;
        $address = $_SESSION['personal']['address'];
        $dob = $_SESSION['personal']['dob'];

        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        $type = 'p';

        if ($password == $cpassword) {
            $sqlmain = "select * from users where email=?;";
            $stmt = $database->prepare($sqlmain);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Există deja un cont asociat cu această adresă de email.</label>';
            } else {
                $stmt = $database->prepare("insert into users(email,name,password,phone,type) values(?, ?, ?, ?, ?);");
                $stmt->bind_param("sssss", $email, $name, $password, $phone, $type);
                $stmt->execute();

                $result = $database->prepare("SELECT * FROM users WHERE email = ?");
                $result->bind_param("s", $email);
                $result->execute();
                $result = $result->get_result();

                if ($result->num_rows == 1) {
                    $user = $result->fetch_assoc();
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION["user_email"] = $user['email'];
                    $_SESSION["user_type"] = $user['type'];
                    $_SESSION["user_name"] = $user['name'];

                    header('Location: patient/index.php');
                }

                $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;"></label>';
            }

        } else {
            $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Eroare la confirmarea parolei! Te rog reconfirmă parola.</label>';
        }




    } else {
        $error = '<label for="promter" class="form-label"></label>';
    }

    ?>


    <center>
        <div class="container">
            <table border="0" style="width: 69%;">
                <tr>
                    <td colspan="2">
                        <p class="header-text">Creare cont nou</p>
                        <p class="sub-text">Adaugă detaliile tale personale pentru a continua</p>
                    </td>
                </tr>
                <tr>
                    <form action="" method="POST">
                        <td class="label-td" colspan="2">
                            <label for="email" class="form-label">Email: </label>
                        </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="email" name="email" class="input-text" placeholder="Adresă Email" required>
                    </td>

                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="phone" class="form-label">Număr de telefon: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="phone" name="phone" class="input-text" placeholder="ex: 0712345678"
                            pattern="[0]{1}[0-9]{9}">
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="password" class="form-label">Creează o parolă nouă: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="password" name="password" class="input-text" placeholder="Parolă nouă" required>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="cpassword" class="form-label">Confirmă parola: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="password" name="cpassword" class="input-text" placeholder="Confirmă parola"
                            required>
                    </td>
                </tr>

                <tr>

                    <td colspan="2">
                        <?php echo $error ?>

                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="reset" value="Resetează" class="login-btn btn-primary-soft btn">
                    </td>
                    <td>
                        <input type="submit" value="Înregistrează-te" class="login-btn btn-primary btn">
                    </td>

                </tr>
                <tr>
                    <td colspan="2">
                        <br>
                        <label for="" class="sub-text" style="font-weight: 280;">Ai deja un cont&#63; </label>
                        <a href="login.php" class="hover-link1 non-style-link">Autentifică-te</a>
                        <br><br><br>
                    </td>
                </tr>

                </form>
                </tr>
            </table>

        </div>
    </center>
</body>

</html>