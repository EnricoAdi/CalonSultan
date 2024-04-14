<?php
include_once("Config/load.php");

use Model\Artikel;
use Model\User;

$backLink = "artikelPage.php";
if (isset($_COOKIE['user'])) {
    # code...
    $usr = json_decode($_COOKIE["user"],true);
    $u = User::getByEmail($usr["email"]);

    if ($u['status'] == 0) {
        $backLink = "Pages/AdminPages/adminPageMasterArtikel.php";
    }
}else{
    $_SESSION['message'] = 'silahkan login dulu';
    header('location:index.php');
}

if (isset($_GET['idArtikel'])) {
    # code...
    $obj = Artikel::getById($_GET['idArtikel']);
}else{
    $_SESSION['message'] = 'silahkan pilih artikel dulu';
    header('location:artikelPage.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<style>
body{
    background-color: #fbfbf8;
}
.container{
    background-color: #d7d7b8;
    height: 100%;
}
</style>
<body>
    <nav class="navbar navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="landingpage.php">
            <img src="Images/logo.png" alt="" width="40" height="34" class="d-inline-block align-text-top">
            Calon Sultan
            </a>
            <span class="text-white">Banyak Baca Banyak Tahu !</span>
            <a href="<?= $backLink ?>"><button class="btn btn-dark">Back</button></a>
        </div>
    </nav>

    <div class="container">
        <br>
        <h1 style="text-align: center;"><?= $obj['judul'] ?></h1>
        <hr >
        <?php echo $obj['isi'] ?>
    </div>
    
</body>
</html>