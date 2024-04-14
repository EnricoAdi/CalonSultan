<?php
include_once("Config/load.php");
include_once("Config/cdn.php");


use Model\User;
use Config\Database;

if (isset($_SESSION["message"])) {
    echo "<script>alert('$_SESSION[message]');</script>";
    unset($_SESSION["message"]);
}
if (isset($_GET["code"])) {

    $db = Database::instance();
    //get from user_validation email
    //cek ada code itu atau ndak
    $email1 = $db->query("SELECT email_user as email FROM USER_VALIDATION where kode='" . $_GET["code"] . "' and tipe=1")->fetch();

    if ($email1 == false) {
        header("Location:landingpage.php");
        exit;
    } else {
        $email = $email1["email"];
        $_SESSION["code"] = $_GET["code"];
        $_SESSION["email-check"] = $email;
    }
}
//cek kalau user yg login mau change password 
if (isset($_COOKIE["user"])) {
    if (isset($_POST["changepass"])) {
        if (isset($_POST["password"]) && isset($_POST["conf-password"])) {
            $db = Database::instance();
            $pass = $_POST["password"];
            $conf = $_POST["conf-password"];
            if ($pass == "" || $conf == "") {
                echo "<script>alert('Password dan konfirmasi harus diisi :)');</script>";
            } else {
                if ($pass != $conf) {
                    echo "<script>alert('Password dan konfirmasi harus sama');</script>";
                } else {
                    if (strlen($pass) < 8) {
                        echo "<script>alert('Password baru harus mempunyai minimal 8 karakter');</script>";
                    } else {
                        // benar semua 
                        //update password

                        $u = User::getByEmail($_SESSION["email-check"]);

                        $fetchdata = $db->query("SELECT tanggal_lahir, exp_sub FROM USERS where email='" .  $_SESSION["email-check"] . "'")->fetch();

                        $role = User::getRoleCode($_SESSION["email-check"])["status"];
                        $u_update = new User($u["nama"], $u["email"], password_hash($pass, PASSWORD_DEFAULT), $fetchdata["tanggal_lahir"], $role, $fetchdata["exp_sub"]);

                        $u_update->save();
                        $ux = User::getByEmail($_SESSION["email-check"]);
                        //unset session 
                        unset($_SESSION["email-check"]);
                        $_SESSION["message"] = "Berhasil Mengganti password!";
                        //setcookie user

                        //auto login
                        header("Location:Pages/AdminPages/adminPageHome.php");

                        setcookie("user", json_encode($ux), time() + 86000, '/');
                    }
                }
            }
        } else {
            echo "<script>alert('Password dan konfirmasi harus diisi :)');</script>";
        }
    }
} else {
    if (isset($_POST["changepass"])) {
        if (!isset($_SESSION["code"])) {
            header("Location:login.php");
            exit;
        } else {
            $code = $_SESSION["code"];
            if (isset($_POST["password"]) && isset($_POST["conf-password"])) {
                $pass = $_POST["password"];
                $conf = $_POST["conf-password"];
                if ($pass == "" || $conf == "") {
                    echo "<script>alert('Password dan konfirmasi harus diisi :)');</script>";
                } else {
                    if ($pass != $conf) {
                        echo "<script>alert('Password dan konfirmasi harus sama');</script>";
                    } else {
                        if (strlen($pass) < 8) {
                            echo "<script>alert('Password baru harus mempunyai minimal 8 karakter');</script>";
                        } else {
                            // benar semua
                            //delete from user validation
                            $db->query("DELETE FROM USER_VALIDATION WHERE kode=:kode", [
                                ":kode" => $code
                            ]);
                            //update password

                            $u = User::getByEmail($_SESSION["email-check"]);

                            $fetchdata = $db->query("SELECT tanggal_lahir, exp_sub FROM USERS where email='" .  $_SESSION["email-check"] . "'")->fetch();

                            $role = User::getRoleCode($_SESSION["email-check"])["status"];
                            $u_update = new User($u["nama"], $u["email"], password_hash($pass, PASSWORD_DEFAULT), $fetchdata["tanggal_lahir"], $role, $fetchdata["exp_sub"]);

                            $u_update->save();
                            $ux = User::getByEmail($_SESSION["email-check"]);
                            //unset session 
                            unset($_SESSION["email-check"]);
                            unset($_SESSION["code"]);
                            // echo "<script>alert('Berhasil Mengganti password!');</script>";
                            $_SESSION["message"] = "Berhasil Mengganti password!";
                            //setcookie user

                            //auto login
                            header("Location:landingpage.php");
                            // $ulogin = {}
                            setcookie("user", json_encode($ux), time() + 86000, '/');
                        }
                    }
                }
            } else {
                echo "<script>alert('Password dan konfirmasi harus diisi :)');</script>";
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
    <title>Change Password</title>
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
                <div class="form-group mb-6">
                    <span class="ml-1 text-whiteColor"> Password baru anda</span> <br />
                    <input type="password" class="form-control block  w-full  px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding  border border-solid border-gray-300  rounded transition  ease-in-out m-0
            focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="Password" name="password">
                    <span class="ml-1 text-whiteColor">Konfirmasi Password baru anda</span> <br />
                    <input type="password" class="form-control block  w-full  px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding  border border-solid border-gray-300  rounded transition  ease-in-out m-0
            focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="Confirm Password" name="conf-password">

                </div>
                <button type="submit" class="w-full px-6 py-2.5 bg-yellow-600 text-white font-medium text-xs leading-tight  uppercase  rounded   shadow-md  hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out" name="changepass">
                    Change Password
                </button>
                <br><br>
                <div class="w-full flex justify-center">
                    <a href="login.php" class=" text-whiteColor">Kembali ke halaman Login </a>
                </div>
            </form>
        </div>

    </div>

</body>

</html>