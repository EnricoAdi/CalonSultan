<?php
include_once("Config/load.php");
include_once("Config/cdn.php");

if (isset($_SESSION["message"])) {
    echo "<script>alert('$_SESSION[message]');</script>";
    unset($_SESSION["message"]);
}
$email = "";
if (isset($_SESSION["email-check"])) {
    $email = $_SESSION["email-check"];
    $href = "Controller/auth-user.php?resendEmail=" . $email;
    unset($_SESSION["email-check"]);
} else {
    //redirect
    header("Location:landingpage.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Validation</title>
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
        <div class="block p-6 rounded-lg shadow-lg bg-whiteColor max-w-md mt-48 w-96">
            <div class="text-lg font-bold text-center mb-6">New User Validation </div>
            <form action='' method="post">
                <div class="w-full flex justify-center">
                    Silahkan cek email yang sudah dikirimkan ke <?= $email; ?>
                </div> <br />

                <div class="w-full flex justify-center">
                    <a href="login.php" class="">Kembali ke halaman Login </a>
                </div>
                <div class="w-full flex justify-center">
                    <a href=<?= $href; ?> class=""> Tidak Menerima Email? Kirim Ulang </a>
                </div>

            </form>
        </div>

    </div>

</body>


</html>