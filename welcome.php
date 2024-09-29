<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- font awesome cdn  -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>


<!-- Navigation menu -->
<nav class="navbar navbar-light bg-light">
    <a class="navbar-brand" href="#" style="font-size:36px;">
    <img src="" width="200"  class="d-inline-block align-top" alt="">
    Data Kepegawaian
  </a>

  <form class="form-inline my-2 my-lg-0">
      <img src="asset/PP Pegawai.png" style="width:50px; height: 50px; margin-right:10px" alt="user-avtar">
  <a href="logout.php" class="btn btn-primary"><i class="fa fa-lock-open"></i> Keluar Akun</a>
    </form>
</nav>
    <p>

    <div class="container">
    <a href="" target="_blank"><img class="card-img-top" src="asset/PP Pegawai.png" alt="Card image cap" style="width:400px; height:400px;"></a>
    <div class="page-header">
    <h1>Halo, <b><?php echo htmlspecialchars($_SESSION["nik"]); ?></b>, 
    Nomor Induk Kepegawaian: <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Selamat Datang.</h1>
    </div>
    <hr>
    </div>
        <a href="reset-password.php" class="btn btn-warning">Reset Password Akun</a>
        <a href="index.php" class="btn btn-primary">Kembali Halaman Utama</a>
    </p>
	
	
	
	
	 <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
 
</body>
</html>
