<?php
include_once("Config/load.php");
use Model\Kelas;
use Model\User;
use Config\Database;

if (isset($_COOKIE['user'])) {
    # code...
    $usr = json_decode($_COOKIE["user"],true);
    $u = User::getByEmail($usr["email"]);
}else{
    header('Location: ../../index.php');
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
    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
</style>
<body>
    <nav class="navbar navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="landingpage.php">
            <img src="Images/logo.png" alt="" width="40" height="34" class="d-inline-block align-text-top">
            Calon Sultan
            </a>
            <span class="text-white">Rajin Belajar Pangkal Pintar !</span>
            <a href="kelasPage.php"><button class="btn btn-dark">Back</button></a>
        </div>
    </nav>   
    <br>
    <div class="container">
        <div class="row">
            <h1>Semua Kelas <?= $u['nama'] ?> !</h1>
            <form class="d-flex" method="GET">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="value">
                <button class="btn btn-outline-success" name="search">Search</button>
            </form>
        </div>
        <br>
        <div class="row">
            <?php
            foreach ($kelas as $key => $value) {
                # code...
                $uEmail = $u['email'];
                $idKelasRow = $value['id'];
                $checkTerdaftar = count($db->query("SELECT * FROM registrasi_kelas WHERE email_user = '$uEmail' AND id_kelas = $idKelasRow")->fetchAll());

                $status = "";
                $text = "Join";
                if ($checkTerdaftar > 0) {
                    $status = "disabled";
                    $text = "Joined";
                }
                ?>
                <div class="rowArtikel">
                    <h5> <?= $value['nama'] ?></h5>
                    <p>Created At : <?= $value['tanggal_pelaksanaan'] ?></p>
                    <div style="right: 2%; top: 40%; position:absolute">
                        <button class="klikinfo btn btn-primary" name="seeArtikel" value="<?= $value['id'] ?>" data-bs-toggle="modal" data-bs-target="#exampleModal"
                        nama="<?= $value['nama'] ?>"
                        tanggal="<?= $value['tanggal_pelaksanaan'] ?>"
                        pembicara="<?= $value['pembicara'] ?>">Info</button>
                        <form method="POST" id="formRow">
                            <button class="btn btn-success" name="joinKelas" value="<?= $value['id'] ?>" <?= $status ?>><?= $text ?></button>
                        </form>
                        <!-- <button class="klikdel btn btn-danger" value="<?= $value['id'] ?>" judul="<?= $value['nama'] ?>" data-bs-toggle="modal" data-bs-target="#exampleModal">Delete</button> -->
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
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