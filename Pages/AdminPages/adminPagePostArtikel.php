<?php
include_once("../../Config/load.php");
if (isset($_SESSION["message"])) {
  echo "<script>alert('$_SESSION[message]');</script>";
  unset($_SESSION["message"]);
}

use Config\Database;
use Model\Artikel;
use Model\User;

$db = Database::instance();
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

if (isset($_POST['submitArtikel'])) {
  $judul = $_POST['judul'];
  $isi = $_POST['editor'];
  $date = date('Y-m-d');
  // insert artikel baru
  $stmt = $db->query("INSERT INTO artikel (judul, tanggal_rilis, isi) VALUES(:judul, :tanggal, :isi)", [
    'judul' => $judul,
    'tanggal' => $date,
    'isi' => $isi
  ]);
  $_SESSION["message"] = "Berhasil Post Artikel";
  header('location: adminPagePostArtikel.php');
}

if (isset($_POST['deleteArtikel'])) {
  $id = $_POST['deleteArtikel'];
  $stmt = $pdo->query("DELETE FROM artikel WHERE id = $id");
  $stmt->execute();
  unset($_SESSION['idEditArtikel']);
}

if (isset($_POST['editArtikel'])) {
  $id = $_POST['editArtikel'];
  $stmt = $pdo->query("SELECT * FROM artikel WHERE id = $id");
  $stmt->execute();
  $artikels = $stmt->fetch();
  $_SESSION['idEditArtikel'] = $artikels;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.ckeditor.com/4.18.0/full/ckeditor.js"></script>
    <title>Admin Page</title>
</head>
<style>
.rowArtikel {
  border-radius: 20px;
  box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
  background-color: white;
  margin: 2%;
  padding: 2%;
  position: relative;
}
.content {
  padding: 2%;
}
body {
  background: linear-gradient(90deg, #487f63 0%, #f0b86c 100%);
}
a {
  text-decoration: none;
}
</style>
<body>
<!-- Header  -->
<nav class="p-3 bg-dark text-white">
  <div class="container-fluid">
    <a href="adminPageMasterArtikel.php"><span class="text-white">Back to Master Artikel</span></a>
  </div>
</nav>
<!-- End of Header -->

<!-- Content -->
<div class="content">
  <h1>Post Artikel Baru</h1>
  <form method="POST">
    <div class="input-group flex-nowrap">
      <span class="input-group-text" id="addon-wrapping">Judul Artikel : </span>
      <input type="text" class="form-control" placeholder="Judul Artikel" aria-label="Username" aria-describedby="addon-wrapping" name="judul">
    </div>
    <br>
    <textarea name="editor"></textarea>
    <br>
    <button class="btn btn-primary" name="submitArtikel">Submit !</button>
    <button type="button" class="btn btn-warning" name="clear" data-bs-toggle="modal" data-bs-target="#exampleModal">Clear</button>
  </form>
</div>
<!-- End of Content -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Clear</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
    Yakin ingin Clear tanpa Save ?
    </div>
    <div class="modal-footer">
      <form method="POST">
          <button class="btn btn-danger" data-dismiss="modal" name="deleteKelas" id="confirmDelete">Confirm Clear !</button>
      </form>
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
    </div>
</div>
<!-- End Of Modal -->
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script>
  CKEDITOR.replace('editor', {
    
  });
</script>
</html>