<?php
//CRON JOB -> dijalankan setiap 1 hari (once a day)
include_once("Config/load.php");
include_once("Config/cdn.php");
include("Utils/mailer.php");
include("Utils/emailtemplate.php");

use Config\Database;

$db = Database::instance();
//

//delete user verification sesuai date expired
try {
    $user_val_delete = $db->query("DELETE FROM user_validation where waktu_exp < sysdate()", []);
    //cek subscribed user expiration date
    $listmail = $db->query("SELECT nama, email from users where exp_sub < sysdate() and status=2 ", [])->fetchAll();
    //mail 
    foreach ($listmail as $key => $value) {
        $nama = $value["nama"];
        $email = $value["email"];
        // $location = "http://localhost/Proyek_Aplin/CalonSultan/landingpage.php";
        $location = "http://localhost/Proyek_Aplin/CalonSultan/landingpage.php";
        $bodymail = getBodyMailNotifySubscriptionEnd($nama, $location);
        // echo $bodymail;
        mailer("calonsultanid2022@gmail.com", $email, "End Subscription Notification", $bodymail);
    }
    $sub_update = $db->query("UPDATE users set status=1 where exp_sub < sysdate() and status=2 ", []);
} catch (\Exception $th) {
    error_log($th->getCode() . " - " . $th->getMessage(), 3, __DIR__ . "/error.log");
}
