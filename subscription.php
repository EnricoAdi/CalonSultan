<?php
include_once("Config/load.php");
include_once("Config/cdn.php");

use Config\Database;
use Model\User;

if (isset($_SESSION["message"])) {
    echo "<script>alert('$_SESSION[message]');</script>";
    unset($_SESSION["message"]);
}

//cek apa ada user yg login
$btnLogIn_disable = "";
$openApp_disable = "hidden";
$user = "";
$msgSubscribeAdd = "";
$keteranganDetail = "";
$email = "";
$namaUser = "";
if (isset($_COOKIE["user"])) {
    // var_dump($_COOKIE["user"]);
    $btnLogIn_disable = "hidden";
    $openApp_disable = "";
    $user = json_decode($_COOKIE["user"], true);

    $role = User::getRoleCode($user["email"])["status"];
    $email = $user["email"];
    $nama = $user["nama"];
    $db = Database::instance();
    if ($role == 2) {
        $keteranganDetail = "(Extends)";
        $sisaWaktu = ($db->query("SELECT datediff(exp_sub,sysdate()) as sisahari FROM  users  WHERE email='$email'")->fetch())["sisahari"];
        $msgSubscribeAdd = "Anda masih memiliki akses premium hingga <b>$sisaWaktu hari lagi!</b>";
        // echo $msgSubscribeAdd;
    }

    // $date1 = $db->query("SELECT DATE_ADD(SYSDATE(),INTERVAL 10 month) as tgl")->fetch();
    // var_dump($date1);
} else {
    //redirect ke landing page
    header("Location:landingpage.php");
    exit;
}
$namasub = "";
$lamasub = 0;
$hargasub = 0;
if (isset($_GET["sub"])) {
    $sub = $_GET["sub"];
    if ($sub == "1msae4e") {
        //1 bulan
        $namasub = "Subscription 1 Bulan";
        $lamasub = 1;
        $hargasub = 120000;
    } else if ($sub == "1ywa4ev") {
        //1 tahun
        $namasub = "Subscription 1 Tahun";
        $lamasub = 12;
        $hargasub = 1200000;
    } else if ($sub == "6msks4e") {
        //6 bulan
        $namasub = "Subscription 6 Bulan";
        $lamasub = 6;
        $hargasub = 660000;
    } else {
        //redirect back karena code error
        $_SESSION["message"] = "Invalid Subscription Code";
        header("Location:landingpage.php");
    }
} else {
    header("Location:landingpage.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Calon Sultan</title>
    <meta name="description" content="Simple landind page" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <!--Replace with your tailwind.css once created-->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet" />
    <link rel="icon" href="Images/logo.png" type="image/x-icon">
    <!-- Define your gradient here - use online tools to find a gradient matching your branding-->
    <style>
        .gradient {
            background: linear-gradient(90deg, #487f63 0%, #f0b86c 100%);
        }
    </style>
</head>

<body class="leading-normal tracking-normal text-white gradient" style="font-family: 'Source Sans Pro', sans-serif">
    <!--Nav-->
    <nav id="header" class="fixed w-full z-30 top-0 text-white">
        <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 py-2">
            <div class="pl-4 flex items-center">
                <a class="toggleColour text-white no-underline hover:no-underline font-bold text-2xl lg:text-4xl" href="#">
                    <!--Icon from: http://www.potlabicons.com/ -->
                    <img class="h-16 fill-current inline z-50" src="Images/logo.png" alt="" />
                    CalonSultan
                </a>
            </div>
            <div class="block lg:hidden pr-4">
                <button id="nav-toggle" class="flex items-center p-1 text-pink-800 hover:text-gray-900 focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                    <svg class="fill-current h-6 w-6" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <title>Menu</title>
                        <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
                    </svg>
                </button>
            </div>
            <div class="w-full flex-grow lg:flex lg:items-center lg:w-auto hidden mt-2 lg:mt-0 bg-white lg:bg-transparent text-black p-4 lg:p-0 z-20" id="nav-content">
                <ul class="list-reset lg:flex justify-end flex-1 items-center">
                    <!-- <li class="mr-3">
                        <a class="inline-block py-2 px-4 text-black font-bold no-underline" href="#contact-us">Contact Us</a>
                    </li> -->
                    <!-- <li class="mr-3">
                        <a class="inline-block text-black no-underline hover:text-gray-800 hover:text-underline py-2 px-4" href="#">link</a>
                    </li> -->
                    <!-- <li class="mr-3">
                        <a class="inline-block text-black no-underline hover:text-gray-800 hover:text-underline py-2 px-4" href="#article-redirect">Blog</a>
                    </li> -->
                    <li class="mr-3 bg-red-100 rounded-md hover:bg-green-100" <?= $openApp_disable ?>>
                        <a class="inline-block text-black no-underline hover:text-gray-800 hover:text-underline py-2 px-4" href="application.php">Open App</a>
                    </li>
                    <li class="mr-3" <?= $openApp_disable ?>>
                        <a class="inline-block text-black no-underline hover:text-gray-800 hover:text-underline py-2 px-4" href="controller/logout.php">Logout</a>
                    </li>
                </ul>
                <!-- <button id="navAction" class="mx-auto lg:mx-0 hover:underline bg-white text-gray-800 font-bold rounded-full mt-4 lg:mt-0 py-4 px-8 shadow opacity-75 focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out" <?= $btnLogIn_disable ?>>
                    <a href="login.php">Login</a>
                </button> -->
            </div>
        </div>
        <hr class="border-b border-gray-100 opacity-25 my-0 py-0" />
    </nav>

    <div class="w-full flex justify-center">
        <div class="block p-6 rounded-lg shadow-lg bg-darkColor max-w-md mt-48 w-96">
            <div class="text-lg font-bold text-center mb-6 text-whiteColor">Subscription Detail Payment <?= $keteranganDetail ?></div>
            <form action='Utils/checkout.php' method="post">
                <div class="form-group mb-6">
                    <span class="text-yellowColor text-center"><?= $msgSubscribeAdd ?> </span> <br />
                    <br />
                    <span class="ml-1 text-whiteColor">Subscription Name : <?= $namasub ?> </span> <br />
                    <!-- <span class="ml-1 text-whiteColor">Subscription Period : <?= $lamasub ?> </span> <br /> -->
                    <span class="ml-1 text-whiteColor">Subscription Price : <?= "Rp" . number_format($hargasub) ?> </span> <br />
                </div>
                <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                <label class="form-check-label" for="exampleCheck1"> Saya setuju untuk mengotorisasi transaksi pembelian subscription Calon Sultan</label>
                <input type="hidden" name="priceSub" value='<?= $hargasub; ?>'>
                <input type="hidden" name="nameSub" value='<?= $namasub ?>'>
                <input type="hidden" name="durationSub" value='<?= $lamasub ?>'>
                <input type="hidden" name="emailSub" value='<?= $email ?>'>
                <input type="hidden" name="fnSub" value='<?= $namaUser ?>'>
                <button type="submit" class="w-full px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight  uppercase  rounded   shadow-md  hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out mt-10" name="subscribe">Subscribe</button>

                <div class="w-full flex justify-center mt-10">
                    <a href="landingpage.php" class="text-whiteColor">Back To Main Page </a>
                </div>
            </form>
        </div>
    </div>
    <!-- jQuery if you need it
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  -->
    <script>
        var scrollpos = window.scrollY;
        var header = document.getElementById("header");
        var navcontent = document.getElementById("nav-content");
        var navaction = document.getElementById("navAction");
        var brandname = document.getElementById("brandname");
        var toToggle = document.querySelectorAll(".toggleColour");

        document.addEventListener("scroll", function() {
            /*Apply classes for slide in bar*/
            scrollpos = window.scrollY;

            if (scrollpos > 10) {
                header.classList.add("bg-whiteColor");
                navaction.classList.remove("bg-white");
                navaction.classList.add("gradient");
                navaction.classList.remove("text-gray-800");
                navaction.classList.add("text-white");
                //Use to switch toggleColour colours
                for (var i = 0; i < toToggle.length; i++) {
                    toToggle[i].classList.add("text-gray-800");
                    toToggle[i].classList.remove("text-white");
                }
                header.classList.add("shadow");
                navcontent.classList.remove("bg-gray-100");
                navcontent.classList.add("bg-white");
            } else {
                header.classList.remove("bg-whiteColor");
                navaction.classList.remove("gradient");
                navaction.classList.add("bg-white");
                navaction.classList.remove("text-white");
                navaction.classList.add("text-gray-800");
                //Use to switch toggleColour colours
                for (var i = 0; i < toToggle.length; i++) {
                    toToggle[i].classList.add("text-white");
                    toToggle[i].classList.remove("text-gray-800");
                }

                header.classList.remove("shadow");
                navcontent.classList.remove("bg-white");
                navcontent.classList.add("bg-gray-100");
            }
        });
    </script>
    <script>
        /*Toggle dropdown list*/
        /*https://gist.github.com/slavapas/593e8e50cf4cc16ac972afcbad4f70c8*/

        var navMenuDiv = document.getElementById("nav-content");
        var navMenu = document.getElementById("nav-toggle");

        document.onclick = check;

        function check(e) {
            var target = (e && e.target) || (event && event.srcElement);

            //Nav Menu
            if (!checkParent(target, navMenuDiv)) {
                // click NOT on the menu
                if (checkParent(target, navMenu)) {
                    // click on the link
                    if (navMenuDiv.classList.contains("hidden")) {
                        navMenuDiv.classList.remove("hidden");
                    } else {
                        navMenuDiv.classList.add("hidden");
                    }
                } else {
                    // click both outside link and outside menu, hide menu
                    navMenuDiv.classList.add("hidden");
                }
            }
        }

        function checkParent(t, elm) {
            while (t.parentNode) {
                if (t == elm) {
                    return true;
                }
                t = t.parentNode;
            }
            return false;
        }
    </script>
</body>

</html>