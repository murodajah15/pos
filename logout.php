<?php
	session_start();
	include("./inc/config.php");
	include "timeout.php";
	if (isset($_SESSION['username'])){
		$username = $_SESSION['username'];
		mysqli_query($connect,"update user set login='N' where username='$username'");
	}
	
	echo '<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />';
	if (!isset($_SESSION['expired'])) {
		echo "<html><head><link href='css/bootstrap.min.css' rel='stylesheet'></head><body>
			<meta charset='utf-8'>
			<meta http-equiv='X-UA-Compatibl'e content='IE=edge'>
			<meta name='viewport' content='width=device-width, initial-scale=1'>
			<body style='background-image: url(shattered_@2X.png);'>
			<div class='container'>
				<center><h1>Session Expired</h1><b>
				<!--<a href='index.php'><h3><font color='red'>Login Ulang</font></h3></a>-->
				<a class='btn btn-primary' href='index.php' role='button'>Login Ulang</a>
				<hr>
			</div>";
	}else{
		if ($_SESSION['expired']=='TRUE') {
			echo "<html><head><link href='css/bootstrap.min.css' rel='stylesheet'></head><body>
			<meta charset='utf-8'>
			<meta http-equiv='X-UA-Compatibl'e content='IE=edge'>
			<meta name='viewport' content='width=device-width, initial-scale=1'>
			<body style='background-image: url(shattered_@2X.png);'>
			<div class='container'>
				<center><h1>Session Expired</h1><b>
				<!--<a href='index.php'><h3><font color='red'>Login Ulang</font></h3></a>-->
				<a class='btn btn-primary' href='index.php' role='button'>Login Ulang</a>
				<hr>
			</div>";
			// <center><b>Session Expired !<b>
			// <br/>
			// <a href='index.php'><h3><font color='red'>Login Ulang</font></h3></a>
			// </body></html>";
		}else{
			echo "<html><head><link href='css/bootstrap.min.css' rel='stylesheet'></head><body>
			<meta charset='utf-8'>
			<meta http-equiv='X-UA-Compatibl'e content='IE=edge'>
			<meta name='viewport' content='width=device-width, initial-scale=1'>
			<body style='background-image: url(shattered_@2X.png);'>
			<div class='container'>
				<center><h2>Anda telah sukses keluar sistem <b>[LOGOUT]</h2><b>
				<!--<a href='index.php'><h3><font color='red'>Login Ulang</font></h3></a>-->
				<a class='btn btn-primary' href='index.php' role='button'>Login Ulang</a>
				<hr>
			</div>";
			//<center>Anda telah sukses keluar sistem <b>[LOGOUT]<b>
			//<br/>
			// <a href='index.php'><h3><font color='red'>Login Ulang</font></h3></a>
			// </body></html>";
		}
	}
  session_unset();
  session_destroy();	
?>