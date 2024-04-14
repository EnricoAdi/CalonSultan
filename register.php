<?php
include_once("Config/load.php");
include_once("Config/cdn.php");
if (isset($_SESSION["message"])) {
    echo "<script>alert('$_SESSION[message]');</script>";
    unset($_SESSION["message"]);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page CalonSultan</title>
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
        <div class="block p-6 rounded-lg shadow-lg bg-darkColor max-w-md mt-48">
            <div class="text-lg font-bold text-center mb-6 text-whiteColor">Register New Account</div>
            <form action='Controller/auth-user.php' method="post">
                <div class="">
                    <div class="form-group mb-6 w-full">
                        <span class="ml-1 text-whiteColor"> Name </span> <br />
                        <input type="text" class="form-control block  w-full  px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding  border border-solid border-gray-300  rounded transition  ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" name="name" placeholder="Nama">

                    </div>
                </div>

                <div class="form-group mb-6">
                    <span class="ml-1 text-whiteColor"> Email </span> <br />
                    <input type="email" class="form-control block  w-full  px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding  border border-solid border-gray-300  rounded transition  ease-in-out m-0
            focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="Alamat Email" name="email">
                </div>

                <div class="grid grid-cols-2 gap-4">

                    <div class="form-group mb-6">
                        <span class="ml-1 text-whiteColor"> Password </span> <br />
                        <input type="password" class="form-control block  w-full  px-3  py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out  m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" name="password" placeholder="Password">
                    </div>
                    <div class="form-group mb-6">
                        <span class="ml-1 text-whiteColor"> Confirmation Password </span> <br />
                        <input type="password" class="form-control block  w-full  px-3  py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out  m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" name="conf-password" placeholder="Confirmation">
                    </div>
                </div>

                <div class="form-group mb-6">
                    <span class="ml-1 text-whiteColor"> Birthday </span> <br />
                    <input type="date" class="form-control block  w-full  px-3  py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out  m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" name="birthday">
                </div>


                <button type="submit" class="w-full px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight  uppercase  rounded   shadow-md  hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out" name="register">Sign up</button>
                <br>
                <br>
                <div class="w-full flex justify-center">
                    <a href="login.php" class="text-whiteColor">Sudah punya akun? <span class="text-sky-400">Login Sekarang!</span> </a>

                </div>
                <div class="w-full flex justify-center">
                    <a href="landingpage.php" class="text-whiteColor">Back To Main Page </a>
                </div>
            </form>
        </div>

    </div>

</body>

</html>