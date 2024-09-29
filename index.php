<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
// database connection
include('config.php');

$added = false;


//Add  new student code 

if(isset($_POST['submit'])){
	$u_card = $_POST['card_no'];
	$u_f_name = $_POST['user_first_name'];
	$u_l_name = $_POST['user_last_name'];
	$u_father = $_POST['user_father'];
	$u_aadhar = $_POST['user_aadhar'];
	$u_birthday = $_POST['user_dob'];
	$u_gender = $_POST['user_gender'];
	$u_email = $_POST['user_email'];
	$u_phone = $_POST['user_phone'];
	$u_state = $_POST['state'];
	$u_dist = $_POST['dist'];
	$u_village = $_POST['village'];
	$u_police = $_POST['police_station'];
	$u_pincode = $_POST['pincode'];
	$u_mother = $_POST['user_mother'];
	$u_family = $_POST['family'];
	$u_staff_id = $_POST['staff_id'];
	


	//image upload

	$msg = "";
	$image = $_FILES['image']['name'];
	$target = "upload_images/".basename($image);

	if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
  		$msg = "Image uploaded successfully";
  	}else{
  		$msg = "Failed to upload image";
  	}

  	$insert_data = "INSERT INTO student_data(u_card, u_f_name, u_l_name, u_father, u_aadhar, u_birthday, u_gender, u_email, u_phone, u_state, u_dist, u_village, u_police, u_pincode, u_mother, u_family, staff_id,image,uploaded) VALUES ('$u_card','$u_f_name','$u_l_name','$u_father','$u_aadhar','$u_birthday','$u_gender','$u_email','$u_phone','$u_state','$u_dist','$u_village','$u_police','$u_pincode','$u_mother','$u_family','$u_staff_id','$image',NOW())";
  	$run_data = mysqli_query($con,$insert_data);

  	if($run_data){
		  $added = true;
  	}else{
  		echo "Data not insert";
  	}

}

?>







<!DOCTYPE html>
<html>
<head>
	<title>Student Crud </title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

	<div class="container">
<a href="https://lexacademy.in" target="_blank"><img src="https://www.dbl.id/uploads/school/13717/95-SMAN_2_MALANG.png" alt="" width="100x" ></a><br><hr>

<!-- adding alert notification  -->
<?php
	if($added){
		echo "
			<div class='btn-success' style='padding: 15px; text-align:center;'>
				Data Siswa Berhasil Ditambahkan.
			</div><br>
		";
	}

?>





	<a href="logout.php" class="btn btn-success"><i class="fa fa-lock"></i> Logout</a>
	<button class="btn btn-success" type="button" data-toggle="modal" data-target="#myModal">
  <i class="fa fa-plus"></i> Tambah Data Siswa Baru
  </button>
  <a href="welcome.php" class="btn btn-success pull-right"><i class=> </i>Akun Anda</a>
  <hr>
		<table class="table table-bordered table-striped table-hover" id="myTable">
		<thead>
			<tr>
			   <th class="text-center" scope="col">No.</th>
				<th class="text-center" scope="col">Nama</th>
				<th class="text-center" scope="col">Nomor Induk Siswa Nasional</th>
				<th class="text-center" scope="col">No. HP</th>
				<th class="text-center" scope="col">NIK Yang Mengisi</th>
				<th class="text-center" scope="col">Lihat</th>
				<th class="text-center" scope="col">Edit</th>
				<th class="text-center" scope="col">Hapus</th>
			</tr>
		</thead>
			<?php

        	$get_data = "SELECT * FROM student_data order by 1 desc";
        	$run_data = mysqli_query($con,$get_data);
			$i = 0;
        	while($row = mysqli_fetch_array($run_data))
        	{
				$sl = ++$i;
				$id = $row['id'];
				$u_card = $row['u_card'];
				$u_f_name = $row['u_f_name'];
				$u_l_name = $row['u_l_name'];
				$u_phone = $row['u_phone'];
				$u_family = $row['u_family'];
				$u_staff_id = $row['staff_id'];

        		$image = $row['image'];

        		echo "

				<tr>
				<td class='text-center'>$sl</td>
				<td class='text-left'>$u_f_name   $u_l_name</td>
				<td class='text-left'>$u_card</td>
				<td class='text-left'>$u_phone</td>
				<td class='text-center'>$u_staff_id</td>
			
				<td class='text-center'>
					<span>
					<a href='#' class='btn btn-success mr-3 profile' data-toggle='modal' data-target='#view$id' title='Prfile'><i class='fa fa-address-card-o' aria-hidden='true'></i></a>
					</span>
					
				</td>
				<td class='text-center'>
					<span>
					<a href='#' class='btn btn-warning mr-3 edituser' data-toggle='modal' data-target='#edit$id' title='Edit'><i class='fa fa-pencil-square-o fa-lg'></i></a>

					     
					    
					</span>
					
				</td>
				<td class='text-center'>
					<span>
					
						<a href='#' class='btn btn-danger deleteuser' title='Delete'>
						     <i class='fa fa-trash-o fa-lg' data-toggle='modal' data-target='#$id' style='' aria-hidden='true'></i>
						</a>
					</span>
					
				</td>
			</tr>


        		";
        	}

        	?>

			
			
		</table>
		<form method="post" action="export.php">
     <input type="submit" name="export" class="btn btn-success" value="Export Data" />
    </form>
	</div>


	<!---Add in modal---->

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
		<center>
  <img src="https://www.dbl.id/uploads/school/13717/95-SMAN_2_MALANG.png" width="300px" height="300px" alt="Logo">
</center>
    
      </div>
      <div class="modal-body">
        <form method="POST" enctype="multipart/form-data">
			
			<!-- This is test for New Card Activate Form  -->
			<!-- This is Address with email id  -->
<div class="form-row">
<div class="form-group col-md-6">
<label for="inputEmail4">NISN</label>
<input type="text" class="form-control" name="card_no" placeholder="Masukkan 10 Digit NISN" minlength="10" maxlength="10" required>
</div>
<div class="form-group col-md-6">
<label for="inputPassword4">Nomor HP.</label>
<input type="phone" class="form-control" name="user_phone" placeholder="Masukkan 12 Digit Nomor HP" minlength="10" maxlength="12" required>
</div>
</div>


<div class="form-row">
<div class="form-group col-md-6">
<label for="firstname">Nama Pertama</label>
<input type="text" class="form-control" name="user_first_name" placeholder="Masukkan Nama Awal">
</div>
<div class="form-group col-md-6">
<label for="lastname">Nama Akhir</label>
<input type="text" class="form-control" name="user_last_name" placeholder="Masukkan Nama Akhir">
</div>
</div>


<div class="form-row">
<div class="form-group col-md-6">
<label for="fathername">Nama Ayah</label>
<input type="text" class="form-control" name="user_father" placeholder="Masukkan Nama">
</div>
<div class="form-group col-md-6">
<label for="mothername">Nama Ibu</label>
<input type="text" class="form-control" name="user_mother" placeholder="Masukkan Nama">
</div>
</div>


<div class="form-row" style="color: skyblue;">
<div class="form-group col-md-6">
<label for="email">Email</label>
<input type="email" class="form-control" name="user_email" placeholder="Masukkan alamat email">
</div>
<div class="form-group col-md-6">
<label for="aadharno">Nomor Induk KTP Ibu</label>
<input type="text" class="form-control" name="user_aadhar" maxlength="16" placeholder="Masukkan 16 Digit NIK">
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6">
<label for="inputState">Jenis Kelamin</label>
<select id="inputState" name="user_gender" class="form-control">
  <option selected>Pilih...</option>
  <option>Laki-Laki</option>
  <option>Perempuan</option>
</select>
</div>
<div class="form-group col-md-6">
<label for="inputPassword4">Tanggal Lahir</label>
<input type="date" class="form-control" name="user_dob" placeholder="Tanggal Lahir">
</div>
</div>


<div class="form-group">
<label for="family">Anggota Keluarga</label>
    <textarea class="form-control" name="family" rows="3"></textarea>
</div>



<div class="form-group">
<label for="inputAddress">Alamat</label>
<input type="text" class="form-control" name="village" placeholder="Masukkan No. Rumah, Rt dan Rw, atau Nama Jalan">
</div>
<div class="form-group">
<label for="inputAddress2">Polsek</label>
<input type="text" class="form-control" name="police_station" placeholder="Masukkan Nama Polsek terdekat">
</div>
<div class="form-row">
<div class="form-group col-md-6">
    <label for="inputCity">Kecamatan</label>
    <select class="form-control" name="dist">
        <option selected disabled>Pilih Kecamatan...</option>
        <option value="Kedungkandang">Kedungkandang</option>
        <option value="Sukun">Sukun</option>
        <option value="Klojen">Klojen</option>
    </select>
</div>
<div class="form-group col-md-4">
    <label for="inputState">Desa/Kelurahan</label>
    <select name="state" class="form-control">
        <option selected>Pilih...</option>
        <option value="Buring">Buring</option>
        <option value="Madyopuro">Madyopuro</option>
        <option value="Sawojajar">Sawojajar</option>
        <option value="Lesanpuro">Lesanpuro</option>
        <option value="Kedungkandang">Kedungkandang</option>
        <option value="Mergosono">Mergosono</option>
        <option value="Arjowinangun">Arjowinangun</option>
        <option value="Cemorokandang">Cemorokandang</option>
        <option value="Wonokoyo">Wonokoyo</option>
        <option value="Tlogowaru">Tlogowaru</option>
        <option value="Bumiayu">Bumiayu</option>
        <option value='Bandulan'>Bandulan</option>
        <option value='Bandungrejosari'>Bandungrejosari</option>
        <option value='Bakalan Krajan'>Bakalan Krajan</option>
        <option value='Ciptomulyo'>Ciptomulyo</option>
        <option value='Gadang'>Gadang</option>
        <option value='Karang Besuki'>Karang Besuki</option>
        <option value='Kebonsari'>Kebonsari</option>
        <option value='Kotalama'>Kotalama</option>
        <option value='Mulyorejo'>Mulyorejo</option>
        <option value='Pisang Candi'>Pisang Candi</option>
        <option value='Sukun'>Sukun</option>
        <option value='Tanjungrejo'>Tanjungrejo</option>
        <option value='Kasin'>Kasin</option>
        <option value='Bareng'>Bareng</option>
        <option value='Gading Kasri'>Gading Kasri</option>
        <option value='Kiduldalem'>Kiduldalem</option>
        <option value='Kauman'>Kauman</option>
        <option value='Sukoharjo'>Sukoharjo</option>
        <option value='Oro-Oro Dowo'>Oro-Oro Dowo</option>
        <option value='Samaan'>Samaan</option>
        <option value='Penanggungan'>Penanggungan</option>
        <option value='Rampal Celaket'>Rampal Celaket</option>
        <option value='Kesatrian'>Kesatrian</option>
    </select>
</div>
<div class="form-group col-md-2">
<label for="inputZip">Kode Pos</label>
<input type="text" class="form-control" name="pincode">
</div>
</div>


<div class="form-group">
<label for="inputAddress">ID Kepegawaian yang mengaktifkan kartu ini.</label>
<input type="text" class="form-control" name="staff_id" maxlength="16" placeholder="Masukkan ID Kepegawaian Max 16 digit">
</div>
			

        	<div class="form-group">
        		<label>Image</label>
        		<input type="file" name="image" class="form-control" >
        	</div>

        	
        	 <input type="submit" name="submit" class="btn btn-info btn-large" value="Submit">
        	
        	
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<!------DELETE modal---->




<!-- Modal -->
<?php

$get_data = "SELECT * FROM student_data";
$run_data = mysqli_query($con,$get_data);

while($row = mysqli_fetch_array($run_data))
{
	$id = $row['id'];
	echo "

<div id='$id' class='modal fade' role='dialog'>
  <div class='modal-dialog'>

    <!-- Modal content-->
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal'>&times;</button>
        <h4 class='modal-title text-center'>Are you want to sure??</h4>
      </div>
      <div class='modal-body'>
        <a href='delete.php?id=$id' class='btn btn-danger' style='margin-left:250px'>Delete</a>
      </div>
      
    </div>

  </div>
</div>


	";
	
}


?>


<!-- View modal  -->
<?php 

// <!-- profile modal start -->
$get_data = "SELECT * FROM student_data";
$run_data = mysqli_query($con,$get_data);

while($row = mysqli_fetch_array($run_data))
{
	$id = $row['id'];
	$card = $row['u_card'];
	$name = $row['u_f_name'];
	$name2 = $row['u_l_name'];
	$father = $row['u_father'];
	$mother = $row['u_mother'];
	$gender = $row['u_gender'];
	$email = $row['u_email'];
	$aadhar = $row['u_aadhar'];
	$Bday = $row['u_birthday'];
	$family = $row['u_family'];
	$phone = $row['u_phone'];
	$address = $row['u_state'];
	$village = $row['u_village'];
	$police = $row['u_police'];
	$dist = $row['u_dist'];
	$pincode = $row['u_pincode'];
	$state = $row['u_state'];
	$time = $row['uploaded'];
	
	$image = $row['image'];
	echo "

		<div class='modal fade' id='view$id' tabindex='-1' role='dialog' aria-labelledby='userViewModalLabel' aria-hidden='true'>
		<div class='modal-dialog'>
			<div class='modal-content'>
			<div class='modal-header'>
				<h5 class='modal-title' id='exampleModalLabel'>Profile <i class='fa fa-user-circle-o' aria-hidden='true'></i></h5>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>&times;</span>
				</button>
			</div>
			<div class='modal-body'>
			<div class='container' id='profile'> 
				<div class='row'>
					<div class='col-sm-4 col-md-2'>
						<img src='upload_images/$image' alt='' style='width: 150px; height: 150px;' ><br>
		
						<i class='fa fa-id-card' aria-hidden='true'></i> $card<br>
						<i class='fa fa-phone' aria-hidden='true'></i> $phone  <br>
						Tanggal Upload : $time
					</div>
					<div class='col-sm-3 col-md-6'>
						<h3 class='text-primary'>$name $name2</h3>
						<p class='text-secondary'>
						<strong>Ayah :</strong> $father <br>
						<strong>Ibu :</strong>$mother <br>
						<strong>NIK Ibu :</strong> $aadhar <br>
						<i class='fa fa-venus-mars' aria-hidden='true'></i> $gender
						<br />
						<i class='fa fa-envelope-o' aria-hidden='true'></i> $email
						<br />
						<div class='card' style='width: 18rem;'>
						<i class='fa fa-users' aria-hidden='true'></i> Anggota Keluarga :
								<div class='card-body'>
								<p> $family </p>
								</div>
						</div>
						
						<i class='fa fa-home' aria-hidden='true'> Address : </i> $village, $dist, <br> $state - $pincode, $police
						<br />
						</p>
						<!-- Split button -->
					</div>
				</div>

			</div>   
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
			</div>
			</form>
			</div>
		</div>
		</div> 


    ";
}


// <!-- profile modal end -->


?>





<!----edit Data--->

<?php

$get_data = "SELECT * FROM student_data";
$run_data = mysqli_query($con, $get_data);

while ($row = mysqli_fetch_array($run_data)) {
    $id = $row['id'];
    $card = $row['u_card'];
    $name = $row['u_f_name'];
    $name2 = $row['u_l_name'];
    $father = $row['u_father'];
    $mother = $row['u_mother'];
    $gender = $row['u_gender'];
    $email = $row['u_email'];
    $aadhar = $row['u_aadhar'];
    $Bday = $row['u_birthday'];
    $family = $row['u_family'];
    $phone = $row['u_phone'];
    $address = $row['u_state'];
    $village = $row['u_village'];
    $police = $row['u_police'];
    $dist = $row['u_dist'];
    $pincode = $row['u_pincode'];
    $state = $row['u_state'];
    $staffCard = $row['staff_id'];
    $time = $row['uploaded'];
    $image = $row['image'];

    echo "
<div id='edit$id' class='modal fade' role='dialog'>
  <div class='modal-dialog'>

    <!-- Modal content-->
    <div class='modal-content'>
      <div class='modal-header'>
             <button type='button' class='close' data-dismiss='modal'>&times;</button>
             <h4 class='modal-title text-center'>Edit Data Siswa</h4> 
      </div>

      <div class='modal-body'>
        <form action='edit.php?id=$id' method='post' enctype='multipart/form-data'>

        <div class='form-row'>
            <div class='form-group col-md-6'>
                <label for='inputEmail4'>NISN</label>
                <input type='text' class='form-control' name='card_no' placeholder='Masukkan 10 Digit NISN' minlength='10' maxlength='10' value='$card' required>
            </div>
            <div class='form-group col-md-6'>
                <label for='inputPassword4'>Nomor HP.</label>
                <input type='phone' class='form-control' name='user_phone' placeholder='Masukkan 12 Digit Nomor HP' minlength='10' maxlength='12' value='$phone' required>
            </div>
        </div>
        
        <div class='form-row'>
            <div class='form-group col-md-6'>
                <label for='firstname'>Nama Pertama</label>
                <input type='text' class='form-control' name='user_first_name' placeholder='Masukkan Nama Awal' value='$name'>
            </div>
            <div class='form-group col-md-6'>
                <label for='lastname'>Nama Akhir</label>
                <input type='text' class='form-control' name='user_last_name' placeholder='Masukkan Nama Akhir' value='$name2'>
            </div>
        </div>
        
        <div class='form-row'>
            <div class='form-group col-md-6'>
                <label for='fathername'>Nama Ayah</label>
                <input type='text' class='form-control' name='user_father' placeholder='Masukkan Nama' value='$father'>
            </div>
            <div class='form-group col-md-6'>
                <label for='mothername'>Nama Ibu</label>
                <input type='text' class='form-control' name='user_mother' placeholder='Masukkan Nama' value='$mother'>
            </div>
        </div>
        
        <div class='form-row'>
            <div class='form-group col-md-6'>
                <label for='email'>Email</label>
                <input type='email' class='form-control' name='user_email' placeholder='Masukkan alamat email' value='$email'>
            </div>
            <div class='form-group col-md-6'>
                <label for='aadharno'>Nomor Induk KTP Ibu</label>
                <input type='text' class='form-control' name='user_aadhar' maxlength='16' placeholder='Masukkan 16 Digit NIK' value='$aadhar'>
            </div>
        </div>

        <div class='form-row'>
            <div class='form-group col-md-6'>
                <label for='inputState'>Jenis Kelamin</label>
                <select id='inputState' name='user_gender' class='form-control'>
                    <option selected>$gender</option>
                    <option>Laki-Laki</option>
                    <option>Perempuan</option>
                </select>
            </div>
            <div class='form-group col-md-6'>
                <label for='inputPassword4'>Tanggal Lahir</label>
                <input type='date' class='form-control' name='user_dob' placeholder='Tanggal Lahir' value='$Bday'>
            </div>
        </div>
        
        <div class='form-group'>
            <label for='family'>Anggota Keluarga</label>
            <textarea class='form-control' name='family' rows='3'>$family</textarea>
        </div>
        
        <div class='form-group'>
            <label for='inputAddress'>Alamat</label>
            <input type='text' class='form-control' name='village' placeholder='Masukkan No. Rumah, Rt dan Rw, atau Nama Jalan' value='$village'>
        </div>
        <div class='form-group'>
            <label for='inputAddress2'>Polsek</label>
            <input type='text' class='form-control' name='police_station' placeholder='Masukkan Nama Polsek terdekat' value='$police'>
        </div>
        
        <div class='form-row'>
            <div class='form-group col-md-6'>
                <label for='inputCity'>Kecamatan</label>
                <select class='form-control' name='dist'>
                    <option selected>$dist</option>
                    <option value='Kedungkandang'>Kedungkandang</option>
                    <option value='Sukun'>Sukun</option>
                    <option value='Klojen'>Klojen</option>
                </select>
            </div>
            <div class='form-group col-md-4'>
                <label for='inputState'>Desa/Kelurahan</label>
                <select name='state' class='form-control'>
                    <option>$state</option>
                    <option value='Buring'>Buring</option>
                    <option value='Madyopuro'>Madyopuro</option>
                    <option value='Sawojajar'>Sawojajar</option>
                    <option value='Lesanpuro'>Lesanpuro</option>
                    <option value='Kedungkandang'>Kedungkandang</option>
                    <option value='Mergosono'>Mergosono</option>
                    <option value='Arjowinangun'>Arjowinangun</option>
                    <option value='Cemorokandang'>Cemorokandang</option>
                    <option value='Wonokoyo'>Wonokoyo</option>
                    <option value='Tlogowaru'>Tlogowaru</option>
                    <option value='Bumiayu'>Bumiayu</option>
                    <option value='Bandulan'>Bandulan</option>
                    <option value='Bandungrejosari'>Bandungrejosari</option>
                    <option value='Bakalan Krajan'>Bakalan Krajan</option>
                    <option value='Ciptomulyo'>Ciptomulyo</option>
                    <option value='Gadang'>Gadang</option>
                    <option value='Karang Besuki'>Karang Besuki</option>
                    <option value='Kebonsari'>Kebonsari</option>
                    <option value='Kotalama'>Kotalama</option>
                    <option value='Mulyorejo'>Mulyorejo</option>
                    <option value='Pisang Candi'>Pisang Candi</option>
                    <option value='Sukun'>Sukun</option>
                    <option value='Tanjungrejo'>Tanjungrejo</option>
                    <option value='Kasin'>Kasin</option>
                    <option value='Bareng'>Bareng</option>
                    <option value='Gading Kasri'>Gading Kasri</option>
                    <option value='Kiduldalem'>Kiduldalem</option>
                    <option value='Kauman'>Kauman</option>
                    <option value='Sukoharjo'>Sukoharjo</option>
                    <option value='Oro-Oro Dowo'>Oro-Oro Dowo</option>
                    <option value='Samaan'>Samaan</option>
                    <option value='Penanggungan'>Penanggungan</option>
                    <option value='Rampal Celaket'>Rampal Celaket</option>
                    <option value='Kesatrian'>Kesatrian</option>
                </select>
            </div>
        </div>

        <div class='form-group col-md-2'>
		<label for='inputZip'>Kode Pos</label>
		<input type='text' class='form-control' name='pincode' value='$pincode'>
		</div>

        <div class='form-group'>
            <label for='inputAddress'>ID Kepegawaian yang mengaktifkan kartu ini.</label>
            <input type='text' class='form-control' name='staff_id' maxlength='16' placeholder='Masukkan Max 16-digit ID Kepegawaian' value='$staffCard'>
        </div>

        <div class='form-group'>
            <label>Gambar</label>
            <input type='file' name='image' class='form-control'>
            <img src='upload_images/$image' style='width:50px; height:50px'>
        </div>

        <div class='modal-footer'>
            <input type='submit' name='submit' class='btn btn-info btn-large' value='Kirim'>
            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Tutup</button>
        </div>

        </form>
      </div>

    </div>

  </div>
</div>
";
}
?>

<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();

    });
  </script>

</body>
</html>
