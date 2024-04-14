<?php
include_once("Config/load.php");
include_once("Config/cdn.php");
include("Utils/randomalphanumeric.php");
include("Utils/mailer.php");
include("Utils/emailtemplate.php");

use Model\User;
use Config\Database;

if (isset($_SESSION["message"])) {
    echo "<script>alert('$_SESSION[message]');</script>";
    unset($_SESSION["message"]);
}
if (isset($_COOKIE["user"])) {
    $user = json_decode($_COOKIE["user"], true);
    $_SESSION["email-check"] = $user["email"];
    header("Location:change-password.php");
    exit;
}
$sended = false;
if (isset($_POST["send-auth"])) {
    $email = "";
    if (isset($_POST["email"])) {
        $email = $_POST["email"];
    }
    if ($email == "") {
        echo "<script>alert('Email harus diisi!');</script>";
    } else {
        //cek email ini ada di db atau ga  
        $u = User::getByEmail($email);
        if ($u == false) {
            echo "<script>alert('Email ini tidak terdaftar di sistem kami');</script>";
        } else {
            $sended = true;
            //cek user ini lagi proses verify atau nda
            $role = User::getRoleCode($email)["status"];
            if ($role == -1) {
                echo "<script>alert('User dengan email ini sedang dalam tahap proses verifikasi');</script>";
            } else {
                //insert new record on user validation a

                $db = Database::instance();
                $code = randomAlphaNumeric(20);
                $db->query("INSERT INTO user_validation values(:kode,:email,(SELECT DATE_ADD(SYSDATE(), INTERVAL 24 DAY_HOUR)),1)", [
                    ":kode" => $code,
                    ":email" => $email
                ]);
                //send email from phpmailer   
                $location = "http://localhost/Proyek_Aplin/CalonSultan/change-password.php?code=" . $code;
                // $location = __DIR__ . "/change-password.php?code=" . $code;

                // nanti ini diganti ke location server

                $bodymail = getBodyMailForgotPassword($location);
                $_SESSION["email-check"] = $email;

                //redirect ke user validation front page  
                mailer("calonsultanid2022@gmail.com", $email, "Forgot Password Calon Sultan", $bodymail);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <link rel="icon" href="Images/logo.png" type="image/x-icon">
    <style>
        .gradient {
            background: linear-gradient(90deg, #487f63 0%, #f0b86c 100%);
        }
    </style>
</head>

<body class="gradient">
    <div class="w-full flex justify-center">
        <div class="absolute mt-8">
            <img src="Images/logo.png" class="border-2 w-24 rounded-full">
            <span class="text-based font-bold text-white">Calon Sultan</span>
        </div>
        <div class="block p-6 rounded-lg shadow-lg bg-darkColor max-w-md mt-48 w-96">
            <div class="text-lg font-bold text-center mb-6  text-whiteColor">Forgot Password? </div>
            <form action='' method="post">
                <?php if ($sended == false) : ?>
                    <div class="form-group mb-6">
                        <span class="ml-1 text-whiteColor"> Email Anda</span> <br />
                        <input type="email" class="form-control block  w-full  px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding  border border-solid border-gray-300  rounded transition  ease-in-out m-0
            focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="Alamat Email" name="email">
                    </div>
                    <button type="submit" class="w-full px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight  uppercase  rounded   shadow-md  hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out" name="send-auth">
                        Send Email Authentication
                    </button>
                <?php endif; ?>
                <?php if ($sended) : ?>

                    <div class="w-full flex justify-center  text-whiteColor">
                        Email Sudah Dikirimkan
                    </div>

                <?php endif; ?>
                <br><br>
                <div class="w-full flex justify-center">
                    <a href="login.php" class=" text-whiteColor">Kembali ke halaman Login </a>
                </div>
            </form>
        </div>

    </div>

</body>

</html>