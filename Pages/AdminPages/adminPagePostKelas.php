<?php
include_once("../../Config/load.php");
use Model\Kelas;
use Model\User;
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

if (isset($_POST['inputKelas'])) {
  $namaKelas = $_POST['namaKelas'];
  $namaPembicara = $_POST['namaPembicara'];
  $tanggal = $_POST['tanggal'];
  $tipe = $_POST['tipe'];
  $lokasi = $_POST['lokasi'];
  $kapasitas = $_POST['jumKelas'];
  $deskripsi = $_POST['deskripsi'];

  $valid = true;
  if ($tipe == 0) {
    echo '<script>alert("pilih tipe kelas!")</script>';
    $valid = false;
  }
  if ($kapasitas == 0) {
    echo '<script>alert("kapasitas kelas tidak boleh 0")</script>';
    $valid = false;
  }

  if ($valid) {
    #save
    echo '<script>alert("Berhasil tambah kelas")</script>';
    $kelas = new Kelas($namaKelas, $namaPembicara, $tanggal, $tipe, $lokasi, $kapasitas, $deskripsi);
    $kelas->add();
    $_SESSION["message"] = "Berhasil Post Kelas";
    header('location: adminPagePostKelas.php');
  }
}

if (isset($_POST['delete'])) {
  Kelas::deleteById($_POST['delete']);
}
if (isset($_POST['clear'])) {

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link href="admin.css" rel="stylesheet">
  <title>Admin Page</title>
</head>
<style>
a {
  text-decoration: none;
}  
</style>
<body>
<!-- Header  -->
<nav class="p-3 bg-dark text-white">
  <div class="container-fluid">
    <a href="adminPageMasterKelas.php"><span class="text-white">Back to Master Kelas</span></a>
  </div>
</nav>
<!-- End of Header -->

<!-- Content -->
<div class="content">
    <!-- Tambah Kelas -->
    <div class="container">
      <h1>Post Kelas</h1>
        <form method="POST">
        <div class="input-group mb-3">
          <span class="input-group-text" id="addon-wrapping">Nama Kelas</span>
          <input type="text" class="form-control" placeholder="Nama Pembicara" aria-label="Username" name="namaKelas" required>
        </div>
        <div class="row">
          <div class="col">
            <div class="input-group mb-3">
              <span class="input-group-text" id="addon-wrapping">Nama Pembicara</span>
              <input type="text" class="form-control" placeholder="Nama Pembicara" aria-label="Username" name="namaPembicara" required>
            </div>
          </div>
          <div class="col">
            <div class="input-group mb-3">
              <span class="input-group-text">Tanggal Pelaksanaan</span>
              <input type="date" class="form-control" placeholder="Server" aria-label="Server" name="tanggal" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="input-group mb-3">
              <span class="input-group-text" id="addon-wrapping">Tipe Kelas</span>
              <select class="form-select" aria-label="Default select example" name="tipe" required>
                <option value="0" selected disabled hidden>Pilih Tipe Kelas !</option>
                <option value="1">Online</option>
                <option value="2">Offline</option>
              </select>
            </div>
          </div>
          <div class="col">
            <div class="input-group mb-3">
              <span class="input-group-text">Lokasi Pelaksanaan Kelas</span>
              <input type="text" class="form-control" placeholder="Lokasi Kelas" aria-label="Server" name="lokasi" required>
            </div>
          </div>
        </div>
        <div>
          <span id="kapasitasKelas">Kapasitas Kelas :</span>
          <input type="number" name="jumKelas" id="inpjumlah" onchange="jumlahChange(this)">
          <input type="range" class="form-range" min="0" max="1000" step="1" id="rangeKelas" onchange="rangeChange(this)" name="kapasitas" value="0" required>
          </div>
          <div class="input-group">
            <span class="input-group-text">Deskripsi Kelas</span>
            <textarea class="form-control" aria-label="With textarea"  name="deskripsi" required style="height: 300px;"></textarea>
          </div>
          <br>
          <button class="btn btn-primary" name="inputKelas">Submit !</button>
          <button class="btn btn-warning" name="clear" data-bs-toggle="modal" data-bs-target="#exampleModal">Clear !</button>
        </form>
      </div>
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
        <button class="btn btn-danger" data-dismiss="modal" name="clear" id="confirmDelete">Confirm Clear !</button>
      </form>
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
    </div>
</div>
<!-- End Of Modal -->
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script>
  //let capacityText = document.getElementById('kapasitasKelas');
  let inpJumlah = document.getElementById('inpjumlah');
  let rangeJumlah = document.getElementById('rangeKelas');
  
  function rangeChange(e){
    //capacityText.innerHTML = e.value;
    inpJumlah.value = e.value;
  }

  function jumlahChange(e){
    let val = e.value;
    if (val > 1000) {
      alert('jumlah maks 1000');
      e.value = 0;
      rangeJumlah.value = 0;
    }else{
      rangeJumlah.value = e.value;
    }
  }
</script>
</html>