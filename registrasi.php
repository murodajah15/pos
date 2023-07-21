<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Registrasi User</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/bootstrap-theme.min.css">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	
	<script language="javascript">
		function validasi(isi) {
			if(isi.username.value == "")
			{
				alert("Username tidak boleh dikosongkan!!");
				isi.username.focus();
				return(false);
			}
			if(isi.password.value == "") {
				alert("Password tidak boleh dikosongkan!!");
				isi.password.focus();
				return(false);
			}
			echo isi.password.value;
			if(isi.password.value <> isi.konfirmasipassword.value) {
				alert("Password & Konfirmasi Password harus sama!");
				isi.password.focus();
				return(false);
			}
			return(true);
		}
	</script>
</head>

<div class="loginbox">
    <div class="login_msg">
    <?php
       include("./inc/config.php");
       session_start();
	   include "timeout.php";
       $error = "";   
       if($_SERVER["REQUEST_METHOD"] == "POST") {

			 echo "<script type='text/javascript'>  window.location='proses_tambah_registrasi.php'; </script>";
       }
    ?>

<body>
  
	<!--<body onload="document.login.username.focus()" style="background-image: url(shattered_@2X.png);">-->
	<body onload="document.login.username.focus()" style="background-color:grey;">
    <div class="container">
    	<p><br/></p>
		<p><br/></p>
  		<div class="row">
  			<div class="col-md-4"></div>
      			<div class="col-md-4">
      				<div class="panel panel-default">
      					<div class="panel-body">
							<h4 style="text-align: center;">Registrasi Awal User</h4>
							<h1></h1>
							<!--<div class="page-header">
								<h2 style="text-align: center;">Login to TuKin System</h2>
							</div>-->
							<?php
						        $sql = "SELECT * FROM user WHERE id>0 and level='ADMINISTRATOR'";
						        $result = mysqli_query($connect,$sql);
						        $count = mysqli_num_rows($result);
						        if ($count=0) {
						        	?>
						        	<h4 style="text-align: center;">User Administrator sudah terdaftar</h4>
						        	<?php
						        	exit();
						        }

							?>
							<form role="form" name="login" method="POST" action="proses_tambah_registrasi.php"> <!--action="cek_login.php"-->
  							<div class="form-group">
								<label for="username"><font color="black"><b>Username</b></font></label>
								<div class="input-group">
									<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
									<input type="text" name="username" class="form-control" id="username" placeholder="Username" autocomplete="off" required>
		            	        </div>                                
  							</div>
  							<div class="form-group">
								<label for="Password"><font color="black"><b>Password</b></font></label>
								<div class="input-group">
									<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
									<input type="password" name="password" class="form-control" id="password" placeholder="Password" autocomplete="off" required>
							    </div>
  							</div>
  							<div class="form-group">
								<label for="konfirmasipassword"><font color="black"><b>Konfirmasi Password</b></font></label>
								<div class="input-group">
									<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
									<input type="password" name="konfirmasipassword" class="form-control" id="konfirmasipassword" placeholder="Konfirmasi Password" autocomplete="off" required>
							    </div>
  							</div>
							<h3></h3>
  							<!--<hr/>
  							<!--<button type="button" class="btn btn-success"><span class="glyphicon glyphicon-arrow-left"></span> Back</button> -->
  							<button type="submit" class="btn btn-primary" name="submit"><span class="glyphicon glyphicon-ok"></span> Simpan</button>
  							<p><br/></p>
						</form>
    				</div>
  			    </div>
         </div>
	</div>
	 
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!--<script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.mask.min.js"></script>-->
	<!-- Include jquery.js and jquery.mask.js -->
	<!--</script>-->
	
</body>
</html>
