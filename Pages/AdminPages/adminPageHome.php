<?php
include_once("../../Config/load.php");
use Model\User;
use Model\Artikel;
use Model\Kelas;
if (isset($_SESSION["message"])) {
    echo "<script>alert('$_SESSION[message]');</script>";
    unset($_SESSION["message"]);
}

if (isset($_COOKIE['user'])) {
  # code...
  $usr = json_decode($_COOKIE["user"],true);
  $u = User::getByEmail($usr["email"]);
  if ($u['status'] != 0) {
    # code...
    header('Location: ../../index.php');
    $_SESSION['message'] = 'non admin dilarang ke page Admin ya..';
  }
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
  <!-- CDN BOOTSTRAP 5.1.3 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <!-- CSS -->
  <link href="admin.css" rel="stylesheet">
  <title>Admin Page</title>
</head>
<body>
  <!-- Header  -->
  <header class="p-3 bg-dark text-white">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="#" class="nav-link px-2 text-secondary">Home</a></li>
          <li><a href="adminPageMasterArtikel.php" class="nav-link px-2 text-white">Master Artikel</a></li>
          <li><a href="adminPageMasterKelas.php" class="nav-link px-2 text-white">Master Kelas</a></li>
          <!-- <li><a href="adminPagePostKelas.php" class="nav-link px-2 text-white">Post Kelas Baru</a></li>
          <li><a href="adminPagePostArtikel.php" class="nav-link px-2 text-white">Post Artikel Baru</a></li> -->
        </ul>
        <div class="dropdown text-end">
          <button type="button" href="#" class="btn btn-warning" data-bs-toggle="dropdown" aria-expanded="false"
          id="btnUser"><?= $u['nama'] ?></button>
          <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="../../forgot-password.php">Change Password</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="../../Controller/logout.php">Sign out</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>
  <!-- End of Header -->

  <!-- Content -->
  <div class="container py-4">
    <div class="p-3 mb-4 bg-light rounded-3">
      <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Hello, <?= $u['nama'] ?>!</h1>
        <p class="col-md-8 fs-4">Ini adalah halaman utama para admin Calon Sultan. Disini kamu mendapatkan akses khusus untuk melihat,
          menambahkan, dan mengubah semua kelas dan artikel yang ada di aplikasi Calon Sultan. <b>Salam Sultan !</b></p>
        <!-- <button class="btn btn-primary btn-lg" type="button">Example button</button> -->
      </div>
    </div>

    <div class="row align-items-md-stretch">
      <div class="col-md-6">
        <div class="h-100 p-5 text-white bg-dark rounded-3">
          <h2>Master Artikel</h2>
          <p>bla bla bla mari melihat artikel bersamaku ;D</p>
          <a href="adminPageMasterArtikel.php"><button class="btn btn-outline-light" type="button">To Master Artikel</button></a>
        </div>
      </div>
      <div class="col-md-6">
        <div class="h-100 p-5 bg-light border rounded-3">
          <h2>Master Kelas</h2>
          <p>bla bla bla mari melihat kelas untuk belajar bersamaku</p>
          <a href="adminPageMasterKelas.php"><button class="btn btn-outline-secondary" type="button">To Master Kelas</button></a>
        </div>
      </div>
    </div>
  </div>
  <!-- End of Content -->
</body>
</html>