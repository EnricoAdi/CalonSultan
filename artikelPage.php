<?php
include_once("Config/load.php");
use Model\User;
use Config\Database;
use Model\Artikel;

if (isset($_SESSION["message"])) {
    echo "<script>alert('$_SESSION[message]');</script>";
    unset($_SESSION["message"]);
}

if (isset($_COOKIE['user'])) {
    # code...
    $usr = json_decode($_COOKIE["user"],true);
    $u = User::getByEmail($usr["email"]);
}else{
    $_SESSION['message'] = 'user harus login';
    header('Location: index.php');
}

if (isset($_POST['seeArtikel'])) {
    $artikel = Artikel::getById($_POST['seeArtikel']);
    $_SESSION['seeArtikel'] = $artikel;
    header('location: seeArtikel.php');
}

//Pagination
$db = Database::instance();
$jumlahDataPerHalaman = 5;
$jumlahData = count($db->query("SELECT * FROM artikel")->fetchAll());
if (isset($_GET['search'])) {
    $key = $_GET['value'];
    if ($key != "") {
        # code...
        $jumlahData = count($db->query("SELECT * FROM artikel WHERE judul LIKE '%$key%' ")->fetchAll());
    }
}
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET['halaman'])) ? $_GET['halaman'] : 1;
$awalData = ( $jumlahDataPerHalaman * $halamanAktif ) - $jumlahDataPerHalaman;
$artikels = $db->query("SELECT * FROM artikel LIMIT $awalData, $jumlahDataPerHalaman")->fetchAll();
//Untuk dapatkan Data
if (isset($_GET['search'])) {
    $key = $_GET['value'];
    if ($key != "") {
        # code...
        $artikels = $db->query("SELECT * FROM artikel WHERE judul LIKE '%$key%' LIMIT $awalData, $jumlahDataPerHalaman")->fetchAll();
    }
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
.rowArtikel {
    border-radius: 20px;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    background-color: white;
    margin-top: 2%;
    padding: 2%;
    position: relative;
}
#formRow {
    display: inline-block;
}
a {
    text-decoration: none;
    color: black;
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
            <a href="landingpage.php"><button class="btn btn-dark">Back</button></a>
        </div>
    </nav>   
    <br>
    <div class="container">
        <div class="row">
            <h1>Cari Artikel Favoritmu !</h1>
            <form class="d-flex" method="GET">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="value">
                <button class="btn btn-success" name="search">Search</button>
            </form>
            <br>
        </div>
        <br>
        <div class="row">
            <?php
            if (isset($_GET['search']) && $key != "") {
                ?>
                <p>Showing Result of : <b><?= $key ?></b></p>
                <?php
            }
            foreach ($artikels as $key => $value) : ?>
            <a href="seeArtikel.php?idArtikel=<?= $value['id'] ?>">
                <div class="rowArtikel">
                    <h5> <?= $value['judul'] ?></h5>
                    <p>Created At : <?= $value['tanggal_rilis'] ?></p>
                </div>
            </a>
            <?php endforeach ?>
        </div>
        <br>
        <div class="row">
            <div class="col-4"></div>
            <div class="col-4">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php
                        //Navigasi
                        $ctr = 1;
                        for ($i = 0; $i < $jumlahHalaman; $i++) : ?> 
                            <?php if( $i+1 == $halamanAktif) : ?>
                                <li class="page-item active"><a href="?halaman=<?= $ctr ?>" class="page-link"><?= $ctr ?></a></li>
                            <?php else : ?>
                                <li class="page-item"><a href="?halaman=<?= $ctr ?>" class="page-link"><?= $ctr ?></a></li>
                            <?php endif; ?>
                        <?php $ctr++; endfor; ?>
                    </ul>
                </nav>
            </div>
            <div class="col-4"></div>
        </div>
    </div> 
</body>
</html>