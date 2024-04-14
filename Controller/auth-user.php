<?php
include_once("../Config/load.php");
include("../Utils/randomalphanumeric.php");
include("../Utils/mailer.php");
include("../Utils/emailtemplate.php");

use Config\Database;
use Model\User;

if (isset($_POST["login"])) {
    if (!isset($_POST["email"]) ||  !isset($_POST["password"])) {
        $_SESSION["message"] = "Input kurang lengkap";
        header("Location:../login.php");
        exit;
    } else {
        $email = $_POST["email"];
        $pass = $_POST["password"];
        if (!User::getByEmail($email)) {
            $_SESSION["message"] = "User tidak ditemukan";
            header("Location:../login.php");
            exit;
        } else {
            $u = User::getByEmail($email);
            //cek password
            if (!password_verify($pass, $u["password"])) {
                $_SESSION["message"] = "Password tidak sesuai";
                header("Location:../login.php");
                exit;
            } else {
                $role = User::getRoleCode($u["email"])["status"];
                if ($role == -1) {
                    //user ini baru saja diregister blm diverif 
                    $_SESSION["message"] = "User ini sudah teregister namun belum verifikasi email";
                    header("Location:../login.php");
                    exit;
                } else if ($role == 1 || $role == 2) {
                    //kalau user 
                    // echo false;
                    header("Location:../landingpage.php");
                    setcookie("user", json_encode($u), time() + 86000, '/');
                    exit;
                } else {
                    //kalau user adalah ADMIN
                    // $_SESSION["message"] = "Berhasil login";
                    //setcookie  
                    header("Location:../Pages/AdminPages/adminPageHome.php");
                    //redirect ganti langsung ke admin page 
                    setcookie("user", json_encode($u), time() + 86000, '/');
                    exit;
                }
            }
        }
    }
}
if (isset($_POST["register"])) {
    if (
        !isset($_POST["name"]) || !isset($_POST["email"]) ||
        !isset($_POST["password"]) || !isset($_POST["conf-password"]) ||
        !isset($_POST["birthday"])
    ) {
        $_SESSION["message"] = "Input kurang lengkap";
        header("Location:../register.php");
    } else {
        $nama = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $conf = $_POST["conf-password"];
        $birthday = $_POST["birthday"];
        //cek user kembar
        $u = User::getByEmail($email);
        if ($u) {
            $role = User::getRoleCode($u["email"])["status"];
            if ($role == -1) {
                $_SESSION["message"] = "Email sudah teregister namun belum melakukan verifikasi";
                header("Location:../register.php");
                exit;
            } else {
                $_SESSION["message"] = "Email sudah teregister";
                header("Location:../register.php");
                exit;
            }
        }
        //cek password=confirm
        if ($conf == $password) {
            $db = Database::instance();
            $code = randomAlphaNumeric(20);
            $usia = $db->query("SELECT TIMESTAMPDIFF(YEAR, :tgl, CURDATE()) AS age", [
                ":tgl" => $birthday
            ])->fetch();
            $age = $usia["age"];
            //cek usia
            if ($age < 17) {
                $_SESSION["message"] = "Usia minimal 17 tahun";
                header("Location:../register.php");
            } else {
                // insert new record on user_validation
                try {
                    $db->query("INSERT INTO user_validation values(:kode,:email,(SELECT DATE_ADD(SYSDATE(), INTERVAL 24 DAY_HOUR)),0)", [
                        ":kode" => $code,
                        ":email" => $email
                    ]);
                } catch (\Exception $th) {
                    error_log($th->getCode() . " - " . $th->getMessage(), 3, __DIR__ . "/../error.log");
                }
                $u = new User($nama, $email, $password, $birthday, -1, "NULL");
                $u->save();

                //send email
                $location = "http://localhost/Proyek_Aplin/CalonSultan/Controller/validate-this.php?code=" . $code;
                // nanti ini diganti ke location server

                $bodymail = getBodyMail($nama, $location);
                $_SESSION["email-check"] = $email;

                //redirect ke user validation front page 
                header("Location:../register-validation.php");
                mailer("calonsultanid2022@gmail.com", $email, "Email Verification Calon Sultan", $bodymail);
            }
        } else {
            $_SESSION["message"] = "Password dan Konfirmasi harus sama";
            header("Location:../register.php");
        }
    }
}
if (isset($_POST["userRole"])) {
    echo json_encode(User::getRoleCode($_POST["email"]));
}
if (isset($_GET["resendEmail"])) {
    //random alphanum
    $_SESSION["message"] = "Resend Email Success";
    $db = Database::instance();
    $email = $_GET["resendEmail"];
    $code = randomAlphaNumeric(20);

    //insert into user validation 

    try {
        $db->query("INSERT INTO user_validation values(:kode,:email,(SELECT DATE_ADD(SYSDATE(), INTERVAL 24 DAY_HOUR)),0)", [
            ":kode" => $code,
            ":email" => $email
        ]);
    } catch (\Exception $th) {
        error_log($th->getCode() . " - " . $th->getMessage(), 3, __DIR__ . "/../error.log");
    }
    //send email 
    $location = "http://localhost/Proyek_Aplin/CalonSultan/Controller/validate-this.php?code=" . $code;
    // nanti ini diganti ke location server

    $bodymail = getBodyMail($email, $location);
    $_SESSION["email-check"] = $email;

    //delete from user validation except last code
    try {
        $db->query("DELETE FROM user_validation WHERE email_user=:email and kode<>:kode", [
            ":kode" => $code,
            ":email" => $email
        ]);
    } catch (\Exception $th) {
        error_log($th->getCode() . " - " . $th->getMessage(), 3, __DIR__ . "/../error.log");
    }

    header("Location:../register-validation.php");

    mailer("calonsultanid2022@gmail.com", $email, "Email Verification Calon Sultan", $bodymail);
}
