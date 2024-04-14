<?php
include_once("../Config/load.php");
include("../Utils/randomalphanumeric.php");

// ini page ajax untuk return data payment transaction atau insert validate payment

use Config\Database;
use Model\User;

function insertTransaction($price, $email, $length, $status, $n)
{
    try {
        $db = Database::instance();
        $s = $db->query("INSERT INTO transaksi(tanggal,total,email_user, status) values(sysdate(),$price,'$email',$status)", []);
        $role = User::getRoleCode($email)["status"];
        if ($s) {
            if ($role == 1) {
                //kalau user baru beli subs
                $datex = $db->query("SELECT DATE_ADD(SYSDATE(),INTERVAL $length month) as tgl")->fetch();
                $date1 = $datex["tgl"];
                $s2 = $db->query("UPDATE users set status=2, exp_sub = '$date1' where email='$email'", []);
                // return "UPDATE users set status=2, exp_sub = '$date1' where email='$email'";
            } else {
                //perpanjang subscription 
                $datex = $db->query("SELECT DATE_ADD(exp_sub,INTERVAL $length month) as tgl from users  where email='$email'")->fetch();
                $date1 = $datex["tgl"];
                $s2 = $db->query("UPDATE users set status=2, exp_sub = '$date1' where email='$email'", []);
                // return $date1;
            }
            if ($s2) {
                //delete from user validation
                $_SESSION["namasub"] = $n;
                return "Transaksi Subscription Berhasil";
            } else {
                return "Fail to update data";
            }
        } else {
            return "Transaction failed";
        }
    } catch (\Exception $th) {
        error_log($th->getCode() . " - " . $th->getMessage(), 3, __DIR__ . "/../error.log");
        return "Transaction failed";
    }
}

if (isset($_POST["payment"])) {
    $price = $_POST["price"];
    $email = $_POST["email"];
    $length = 0;
    $status = $_POST["status"];
    if ($_POST["payment"] == "Subscription 1 Bulan") {
        $length = 1;
    } else if ($_POST["payment"] == "Subscription 6 Bulan") {
        $length = 6;
    } else if ($_POST["payment"] == "Subscription 1 Tahun") {
        $length = 12;
    }
    $success = insertTransaction($price, $email, $length, $status, $_POST["payment"]);
    echo $success;
} else if (isset($_POST["paymentvalidation"])) {
    $_SESSION["namasub"] = $_POST["paymentvalidation"];
    //jangan lupa di unset

    //insert to user validation
    $db = Database::instance();
    $code = randomAlphaNumeric(20);
} else {
    header("Location:../subscription.php");
}
