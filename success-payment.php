<?php
include_once("Config/load.php");
include_once("Config/cdn.php");

use Model\User;
use Config\Database;

if (isset($_SESSION["message"])) {
    echo "<script>alert('$_SESSION[message]');</script>";
    unset($_SESSION["message"]);
}
$namasub = "";
if (isset($_GET["code"])) {
    if ($_GET["code"] == "scs") {
        if (!isset($_SESSION["namasub"])) {
            $_SESSION["message"] = "Invalid";
        } else {
            $namasub = $_SESSION["namasub"];
            unset($_SESSION["namasub"]);
        }
    } else {
        $db = Database::instance();
        //get from user_validation email
        //cek ada code itu atau ndak
        $email1 = $db->query("SELECT email_user as email FROM USER_VALIDATION where kode='" . $_GET["code"] . "' and tipe=2")->fetch();

        if ($email1 == false) {
            $_SESSION["message"] = "Error subscription code not found";
            header("Location:landingpage.php");
            exit;
        }
        // else {
        //     $email = $email1["email"];
        //     $_SESSION["code"] = $_GET["code"];
        //     $_SESSION["email-check"] = $email;
        // }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successfully</title>
    <link rel="icon" href="Images/logo.png" type="image/x-icon">
    <style>
        .gradient {
            background: linear-gradient(90deg, #487f63 0%, #f0b86c 100%);
        }
    </style>
</head>

<body class="gradient">

    <div class="w-full flex justify-center">
        <div class="block p-6 rounded-lg shadow-lg bg-darkColor max-w-md mt-48 w-96">
            <div class="text-lg font-bold text-center mb-6 text-whiteColor">Payment Success!</div>
            <div class="form-group mb-6">
                <span class="ml-1 text-whiteColor"> Pembelian <?= $namasub; ?> anda berhasil! </span> <br />
            </div>


            <a href="landingpage.php"><button class="w-full px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight  uppercase  rounded 
            shadow-md  hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg 
            focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 
            ease-in-out">Kembali ke main page!</button></a>


        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script type="text/javascript">
        //     $.ajax({
        //         type: "POST",
        //         url: "../Controller/auth-payment.php",
        //         data: {
        //             payment: document.getElementById("nameSub").value,
        //             price: document.getElementById("priceSub").value,
        //             email: document.getElementById("emailUser").value
        //         }
        //     }).done(data)({
        //         alert(data);
        //     });   
    </script>
</body>

</html>