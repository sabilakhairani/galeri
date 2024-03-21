<?php
session_start();
$userid = $_SESSION['userid'];
include'../config/koneksi.php';
if ($_SESSION['status'] != 'login') {
  echo "<script>
  alert('Anda belum login!');
  location.href='../index.php';
  </script>";
}

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Website Galeri Foto </title>
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
  <link rel="stylesheet" type="text/css" href="../config/bg.css">
</head>
<body class="bg-warning-subtle">
  <nav class="navbar navbar-expand-lg navbar-warning bg-info-subtle">
    <div class="container">
      <a class="navbar-brand" href="index.php"> Website Galeri Foto </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse mt-2" id="navbarNavAltMarkup">
        <div class="navbar-nav me-auto">
          <a href="home.php" class="nav-link"> Home </a>
          <a href="album.php" class="nav-link"> Album </a> 
          <a href="foto.php" class="nav-link"> Foto </a>    
        </div>
        
        <a href="../config/aksi_logout.php" class="btn btn-outline-danger m-1"> Keluar </a>
      </div>
    </div>
  </nav>

  <div class="container mt-3">
    Album :
  <?php
  $album = mysqli_query($koneksi, "SELECT * FROM album WHERE userid='$userid'");
  while($row = mysqli_fetch_array($album)) { ?>
  <a href ="home.php?albumid=<?php echo $row['albumid'] ?>" class ="btn btn-outline-dark"> 
  <?php echo $row['namaalbum'] ?></a>
    
  <?php } ?>
  
  <div class="row">
      <?php 
    if (isset($_GET['albumid'])) {
    $albumid  = $_GET['albumid'];

    $query = mysqli_query($koneksi, "SELECT * FROM foto WHERE userid='$userid' AND albumid='$albumid'");
    while($data = mysqli_fetch_array($query)) { ?>
      
        <div class="col-md-2">
          <a type="button" data-bs-toggle="modal" data-bs-target="#komentar<?php echo $data['fotoid']?>">
            <div class="card">
              <img style ="height: 15rem;" src="../assets/img/<?php echo $data['lokasifile'] ?>" class="card-img-top" title="<?php echo $data['judulfoto'] ?>">
              <div class="card-footer text-center">
        <?php
        $fotoid = $data['fotoid'];
        $ceksuka = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid' AND userid='$userid'");
        $cekbatalsuka = mysqli_query($koneksi, "SELECT * FROM dislike WHERE fotoid='$fotoid' AND userid='$userid'");
        if (mysqli_num_rows($ceksuka) == 1) { ?>
    
        <?php } else { ?>
        
        <?php }
        $like = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid'");

        ?>
        <?php
        if (mysqli_num_rows($cekbatalsuka) == 1) { ?>
        
        <?php } else { ?>
        
        <?php }
        $dislike = mysqli_query($koneksi, "SELECT * FROM dislike WHERE fotoid='$fotoid'");
        ?>
                <?php
                $jmlkomen = mysqli_query($koneksi, "SELECT * FROM komentarfoto WHERE fotoid='$fotoid'");
                ?>
              </div>
            </div>
          </a>

          <div class="modal fade" id="komentar<?php echo $data['fotoid'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
              <div class="modal-content">
                <div class="modal-body">
                 <div class="row">
                  <div class="col-md-5">
                    <img src="../assets/img/<?php echo $data['lokasifile'] ?>" class="card-img-top" title="<?php echo $data['judulfoto'] ?>">
                  </div>
                  <div class="col-md-4"></div> 
                  <div class="m-2">
                    <div class="overflow-auto">
                      <div class="sticky-top">
                        <strong><?php echo $data['judulfoto'] ?></strong><br>
                        <span class="badge bg-secondary"><?php echo $data['tanggalunggah'] ?></span>
                      </div>
                      <hr>
                      <p align="left">
                        <?php echo $data['deskripsifoto'] ?>
                      </p>
                      <hr>
                      <?php
                      $fotoid = $data['fotoid'];
                      $komentar = mysqli_query($koneksi,"SELECT * FROM komentarfoto INNER JOIN user ON komentarfoto.userid=user.userid WHERE komentarfoto.fotoid='$fotoid'");
                      while($row = mysqli_fetch_array($komentar)){
                      ?>
                    <?php } ?>
                    <hr>
                    <div class="sticky-bottom">
                         </div>
                 </div>
               </div>

             </div>
           </div>
         </div>
       </div>
     </div>

   </div>
    <?php } } ?>
</div>
</div>

<footer class="d-flex justify-content-center border-top mt-3 bg-info-subtle fixed-bottom">
  <p>&copy; UKK RPL 2024 | Sabila Khairani Nasution</p>
</footer>

<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
</body>
</html>