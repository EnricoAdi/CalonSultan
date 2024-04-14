<?php
include_once("../Config/load.php");

use Config\Database;
use Model\User;

if (isset($_GET["code"])) {
    //kurang pengecekan .

    $db = Database::instance();
    //get from user_validation email
    $email1 = $db->query("SELECT email_user as emailz FROM USER_VALIDATION where kode='" . $_GET["code"] . "'")->fetch();
    $email = $email1["emailz"];

    if ($email1 == false) {
        //nanti diganti auto loged in -> di cek dulu apa user e ws validate/not, kalo blm brti ada org ngasal
        if (isset($_COOKIE["user"])) {
            // do smthin here yg ngebedain user udh login sama blm
            header("Location:../landingpage.php");
            exit;
        }
        // else {
        //     header("Location:../landingpage.php");
        //     exit;
        // }
    } else {
        // delete from user_validation
        $db->query("DELETE FROM USER_VALIDATION WHERE kode=:kode", [
            ":kode" => $_GET["code"]
        ]);

        //get user info
        $u = User::getByEmail($email);
        //validate this user (update)
        $fetchdata = $db->query("SELECT tanggal_lahir FROM USERS where email='" .  $email . "'")->fetch();

        $u_update = new User($u["nama"], $email, $u["password"], $fetchdata["tanggal_lahir"], 1, "NULL");
        $u_update->save();
        $ux = User::getByEmail($email);
        //setcookie -> ini buat nyimpan data user yg log in -> auto log in kalo dia hbs verify
        setcookie("user", json_encode($ux), time() + 86000, '/');
    }
} else {
    header("Location:../landingpage.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Validation</title>
    <link rel="icon" href="../Images/logo.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    <style>
        .gradient {
            background: linear-gradient(90deg, #487f63 0%, #f0b86c 100%);
        }
    </style>
</head>

<body class="gradient">
    <div class="w-full flex justify-center">
        <div class="absolute mt-8">
            <img src="../Images/logo.png" class="border-2 w-24 rounded-full">
            <span class="text-based font-bold text-white">Calon Sultan</span>
        </div>
        <div class="block p-6 rounded-lg shadow-lg bg-white max-w-md mt-48 w-96">
            <div class="text-lg font-bold text-center mb-6">User Validation Succeed </div>
            <form action='' method="post">
                <div class="w-full flex justify-center">
                    User berhasil di verifikasi
                </div> <br />

                <div class="w-full flex justify-center">
                    <a href="../landingpage.php" class="">Masuk Sekarang </a>
                </div>

            </form>
        </div>

    </div>

</body>


</html>