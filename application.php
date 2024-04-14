<?php
    use Model\User;
    include_once("Config/load.php");
    include_once("Config/cdn.php");
    // include_once("Config/cdn.php");

    if(!isset($_COOKIE["user"])){
        header("Location:index.php");
        exit;
    }

    $usr = json_decode($_COOKIE["user"],true);
    $u = User::getByEmail($usr["email"]);
    $u_subscriber = User::getRoleCode($u["email"])["status"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" href="Images/logo.png" type="image/x-icon">
</head>
<link rel="stylesheet" href="CSS/style-app.css">
<body>
    <div class="flex">
        <span hidden id="emailUser"><?= $usr["email"] ?></span>
        <?php require("Component/Sidebar/sidebar.php"); ?>
        <div class="p-5" style="width:100%; height:100vh">
            <?php 
                require("Pages/Application/dashboard.php");
                require("Pages/Application/keuangan.php");
                require("Pages/Application/laporan.php");
                require("Pages/Application/history.php");
            ?>
        </div>
    </div>
</body>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js" ></script>
<script src="Scripts/Application/appScript.js"></script>
<script src="Scripts/Application/dashboardScript.js"></script>
<script src="Scripts/Application/keuanganScript.js"></script>
<script src="Scripts/Application/pageChange.js"></script>
</html>