<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login POS System</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!--<link rel="stylesheet" href="assets/css/bootstrap-theme.min.css">-->
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

	<script language="javascript">
		function validasi(isi) {
			if (isi.username.value == "") {
				alert("Username tidak boleh dikosongkan!!");
				isi.username.focus();
				return (false);
			}
			if (isi.password.value == "") {
				alert("Password tidak boleh dikosongkan!!");
				isi.password.focus();
				return (false);
			}
			return (true);
		}
	</script>
</head>

<div class="loginbox">
	<div class="login_msg">
		<?php
		include("./inc/config.php");
		session_start();
		include "timeout.php";
		date_default_timezone_set('Asia/Jakarta');
		$error = "";
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			// username dan password didapat dari form
			$myusername = mysqli_real_escape_string($connect, $_POST['username']);
			$mypassword = md5(mysqli_real_escape_string($connect, $_POST['password']));
			$sql = "SELECT * FROM user WHERE username = '$myusername' and password = '$mypassword'";
			$result = mysqli_query($connect, $sql);
			$row = mysqli_fetch_assoc($result);
			$count = mysqli_num_rows($result);

			// Jika hasil sesuai $myusername dan $mypassword, table row harus 1	
			if ($count > 0) {
				if ($row['aktif'] == 'N') {
					echo "<script>alert('User tidak aktif')</script>";
					echo "<script type='text/javascript'>  window.location='index.php'; </script>";
				}
				$_SESSION['login_user'] = $myusername;
				$_SESSION['login'] = 1;
				$_SESSION['username'] = $row['username'];
				$_SESSION['nama'] = $row['nama_lengkap'];
				$_SESSION['level'] = $row['level'];
				$_SESSION['timeout'] = time();
				$_SESSION['photo'] = $row['photo'];
				timer();
				$_SESSION['jmlperhalaman'] = 5;
				$sql = "SELECT * FROM saplikasi WHERE aktif='Y'";
				$result = mysqli_query($connect, $sql);
				$row = mysqli_fetch_assoc($result);
				$_SESSION['kd_perusahaan'] = $row['kd_perusahaan'];
				$_SESSION['nm_perusahaan'] = $row['nm_perusahaan'];
				$_SESSION['alamat_perusahaan'] = $row['alamat'];
				$_SESSION['telp_perusahaan'] = $row['telp'];
				$_SESSION['nm_sistem'] = $row['nm_sistem'];
				$_SESSION['direktur'] = $row['direktur'];
				$_SESSION['finance_mgr'] = $row['finance_mgr'];
				$_SESSION['logo'] = $row['logo'];
				$_SESSION['kunci_harga_jual'] = $row['kunci_harga_jual'];
				$_SESSION['norek1'] = $row['norek1'];
				$_SESSION['norek2'] = $row['norek2'];
				$_SESSION['kunci_stock'] = $row['kunci_stock'];

				$time = time();
				$datetime = date('Y-m-d H:i:s');
				$sql = "update user set login='Y',login_time='$time',last_login='$datetime' where username='$myusername'";
				$result = mysqli_query($connect, $sql);
				//include("statistik_index.php");
				//header("location: dashboard.php");
				echo "<script type='text/javascript'>  window.location='dashboard.php'; </script>";
			} else {
				/*$error = "Your Login Name or Password is invalid";
				echo $error;**/
				echo '<div class="login-container">';
				echo '<br>';
				echo '<p style="text-align:center"><font face="calibri" color="red">Your Login Name or Password is invalid</font></p>';
				echo '</div>';
			}
		}
		?>
	</div>
</div>

<body>

	<body>

		<body onload="document.login.username.focus()" style="background-image: url(shattered_@2X.png);">
			<!-- <body onload="document.login.username.focus()" style="background-color:grey;"> -->
			<div class="container">
				<p><br /><br></p>
				<p><br /></p>
				<div class="row">
					<div class="col-md-4"></div>
					<div class="col-md-4">
						<div class="panel panel-default" style="background-color:white;">
							<div class="panel-body" style='color: black'>
								<h5 class='text-center'><img src='img/logo.png' width='110' height='100' style='margin:-50px 0px' class='img-circle'></h5>
								</br></br>
								<h4 style="text-align: center; margin:0px 0px">Login To POS</h4>
								<h1></h1>
								<!--<div class="page-header">
					<h2 style="text-align: center;">Login to TuKin System</h2>
				</div>-->
								<form role="form" name="login" method="POST" onsubmit="return validasi(this)" autocomplete="off">
									<!--action="cek_login.php"-->
									<!-- <div class="form-group">
						<label for="exampleInputEmail1"><font color="black"><b>Username</b></font></label>
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
							<input type="text" name="username" class="form-control" placeholder="Username">
						</div>                                
					</div> -->
									<?php
									$fusername = "";
									$fpassword = "";
									// $string = exec('getmac');
									// $mac = substr($string, 0, 17);
									// $sql = "SELECT * FROM user WHERE mac='$mac' order by last_login desc limit 1";
									// $result = mysqli_query($connect, $sql);
									// $row = mysqli_fetch_assoc($result);
									// $fusername = $row['username'];
									// $fpassword = $row['password'];
									// $fpassword = md5(mysqli_real_escape_string($connect, $fpassword));
									// echo $fpassword . '<br>' . 'aa' . $fusername;
									?>
									<div class="form-group">
										<label for="exampleInputEmail1">
											<font color="black"><b>Username</b></font>
										</label>
										<div class="input-group">
											<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
											<?php
											if ($fusername <> "") {
											?>
												<input type='text' class='form-control' name='username' size='10' autofocus='autofocus' autocomplete="off" placeholder="Username" required>
											<?php
											} else {
											?>
												<input type='text' class='form-control' name='username' size='10' autofocus='autofocus' autocomplete="off" placeholder="Username" required>
											<?php
											}
											?>
										</div>
									</div>

									<div class="form-group">
										<label for="exampleInputPassword1">
											<font color="black"><b>Password</b></font>
										</label>
										<div class="input-group">
											<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
											<input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
										</div>
									</div>
									<!-- <input type='checkbox' name='simpanpassword' id="simpanpassword"> -->
									<input type='hidden' name='simpanpassword' id="simpanpassword">
									<!-- <font size='2'>Simpan Username</font> -->
									<h3></h3>
									<!--<hr/>
							<!--<button type="button" class="btn btn-success"><span class="glyphicon glyphicon-arrow-left"></span> Back</button> -->
									<button type="submit" class="btn btn-primary" name="submit"><span class="glyphicon glyphicon-ok"></span> Login</button>
									<p><br /></p>
									<!-- <a href="reset_password.php" target="_blank">Reset Password</a> -->
									<a href="reset_password.php">Reset Password</a>
								</form>
								<h5 class='text-right'><img src='img/login1.jpg' width='60' height='60' style='margin:-70px 0px' class='img-curve'></h5>
							</div>
						</div>
					</div>
				</div>
			</div>
		</body>

</html>