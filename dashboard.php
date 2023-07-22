<?php
session_start();
include "timeout.php";
cekform();
if ($_SESSION['login'] == 1) {
	if (!cek_login()) {
		$_SESSION['login'] = 0;
	}
}
if ($_SESSION['login'] == 0) {
	header('location:index.php');
}
include("./inc/config.php");
$username = $_SESSION['username'];
?>


<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>POS | Dashboard</title>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	<!--<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>-->
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
	<!-- bootstrap 3.0.2 -->
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<!-- font Awesome -->
	<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<!-- Ionicons -->
	<link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />
	<!-- DATA TABLES -->
	<link href="css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
	<!-- Theme style -->
	<link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
	<!-- alert -->
	<link href="css/sweet-alert.css" rel="stylesheet" type="text/css" />
	<link href="css/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="plugin/datatables/css/jquery.dataTables.css">
	<link rel="stylesheet" href="croppie/croppie.css" />
	<!-- <script src="js/jquery.min.js" type="text/javascript"></script> -->
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
</head>

<body class="skin-black">

	<!-- <input type="radio" name="myRadios" onclick="handleClick(this);" value="1" />
		<input type="radio" name="myRadios" onclick="handleClick(this);" value="2" />
	
		<script>
			var currentValue = 0;
			function handleClick(myRadio) {
				alert('Old value: ' + currentValue);
				alert('New value: ' + myRadio.value);
				currentValue = myRadio.value;
			}
		</script> -->

	<!-- Loading Page -->

	<body onload="myFunction()" style="margin:0;">
		<div id="loader"></div>
		<!--<div style="display:none;" id="myDiv" class="animate-bottom">-->

		<style>
			.footer {
				position: fixed;
				left: 0;
				bottom: 0;
				width: 100%;
				background-color: grey;
				color: white;
				height: 3%;
				text-align: center;
			}
		</style>

		<style>
			/* Center the loader */
			#loader {
				/*				position: absolute;
			left: 53%;
			top: 50%;
			z-index: 1;
			width: 150px;
			height: 150px;
			margin: -75px 0 0 -75px;
			border: 16px solid #f3f3f3;
			border-radius: 50%;
			border-top: 16px solid #3498db;
			width: 120px;
			height: 120px;
			-webkit-animation: spin 2s linear infinite;
			animation: spin 2s linear infinite;*/
				position: absolute;
				left: 48%;
				top: 50%;
				z-index: 1;
				border: 16px solid #f3f3f3;
				border-radius: 50%;
				border-top: 16px solid blue;
				border-right: 16px solid green;
				border-bottom: 16px solid red;
				width: 60px;
				height: 60px;
				-webkit-animation: spin 2s linear infinite;
				animation: spin 2s linear infinite;
			}

			@-webkit-keyframes spin {
				0% {
					-webkit-transform: rotate(0deg);
				}

				100% {
					-webkit-transform: rotate(360deg);
				}
			}

			@keyframes spin {
				0% {
					transform: rotate(0deg);
				}

				100% {
					transform: rotate(360deg);
				}
			}

			/* Add animation to "page content" */
			.animate-bottom {
				position: relative;
				-webkit-animation-name: animatebottom;
				-webkit-animation-duration: 1s;
				animation-name: animatebottom;
				animation-duration: 1s
			}

			@-webkit-keyframes animatebottom {
				from {
					bottom: -100px;
					opacity: 0
				}

				to {
					bottom: 0px;
					opacity: 1
				}
			}

			@keyframes animatebottom {
				from {
					bottom: -100px;
					opacity: 0
				}

				to {
					bottom: 0;
					opacity: 1
				}
			}

			#myDiv {
				display: none;
			}
		</style>

		<!-- header logo: style can be found in header.less -->
		<header class="header">
			<a href="dashboard.php" class="logo">
				<!-- Add the class icon to your logo image or logo icon to add the margining -->
				Point Of Sales <font color='#FFD700'>(POS)</font>
			</a>
			<!-- Header Navbar: style can be found in header.less -->
			<nav class="navbar navbar-static-top" role="navigation">
				<!-- Sidebar toggle button-->
				<a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<div class="navbar-right">
					<ul class="nav navbar-nav">
						<!-- Messages: style can be found in dropdown.less-->
						<li class="dropdown messages-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-envelope-o"></i>
								<span class="label label-success">4</span>
							</a>
							<ul class="dropdown-menu">
								<li class="header">You have 4 messages</li>
								<li>
									<!-- inner menu: contains the actual data -->
									<ul class="menu">
										<li>
											<!-- start message -->
											<a href="#">
												<div class="pull-left">
													<!-- <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"> -->
												</div>
												<h4>
													Support Team
													<small><i class="fa fa-clock-o"></i> 5 mins</small>
												</h4>
												<p>Why not buy a new awesome theme?</p>
											</a>
										</li>
										<li>
											<a href="#">
												<div class="pull-left">
													<!-- <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="User Image"> -->
												</div>
												<h4>
													Admin Design Team
													<small><i class="fa fa-clock-o"></i> 2 hours</small>
												</h4>
												<p>Why not buy a new awesome theme?</p>
											</a>
										</li>
										<li>
											<a href="#">
												<div class="pull-left">
													<!-- <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image"> -->
												</div>
												<h4>
													Developers
													<small><i class="fa fa-clock-o"></i> Today</small>
												</h4>
												<p>Why not buy a new awesome theme?</p>
											</a>
										</li>
										<li>
											<a href="#">
												<div class="pull-left">
													<!-- <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="User Image"> -->
												</div>
												<h4>
													Sales Department
													<small><i class="fa fa-clock-o"></i> Yesterday</small>
												</h4>
												<p>Why not buy a new awesome theme?</p>
											</a>
										</li>
										<li>
											<a href="#">
												<div class="pull-left">
													<!-- <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image"> -->
												</div>
												<h4>
													Reviewers
													<small><i class="fa fa-clock-o"></i> 2 days</small>
												</h4>
												<p>Why not buy a new awesome theme?</p>
											</a>
										</li>
									</ul>
								</li>
								<li class="footer"><a href="#">See All Messages</a></li>
							</ul>
						</li>
						<!-- User Account: style can be found in dropdown.less -->
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<!-- <i class="glyphicon glyphicon-user"></i> -->
								<?php
								$photo = './photo/' . $_SESSION['photo'];
								echo "<img src=$photo class='img-rounded' width='25' height='30' />"; ?>
								<!--<span>User Login : <?php echo $_SESSION['nama']; ?><i class="caret"></i></span>-->
								<span><?php echo $_SESSION['nama']; ?><i class="caret"></i></span>
							</a>
							<!-- Dropdown menu -->
							<ul class="dropdown-menu">
								<li><a href="./dashboard.php?m=updateprofile"><i class="icon-user"></i>Update Profile</a></li>
								<li><a href="./dashboard.php?m=rubahpass"><i class="icon-user"></i>Rubah Password</a></li>
								<li><a href="index.php"><i class="icon-off"></i>Logout</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</header>

		<div class="wrapper row-offcanvas row-offcanvas-left">
			<!-- Left side column. contains the logo and sidebar -->
			<aside class="left-side sidebar-offcanvas">
				<!-- <aside class="left-side sidebar-offcanvas sidebar-collapse collapse-left"> -->
				<!-- sidebar: style can be found in sidebar.less -->
				<section class="sidebar">
					<ul class="sidebar-menu">
						<li class="active">
							<a href="dashboard.php">
								<i class="fa fa-dashboard"></i> <span>Dashboard</span>
							</a>
						</li>
						<?php
						$mainmenu = 1;
						$no = 1;
						$query = "select * from tbmodule order by nurut";
						$data = mysqli_query($connect, $query);
						while ($k = mysqli_fetch_assoc($data)) {
							$cmodule = $k['cmodule'];
							$cmenu = $k['cmenu'];
							if ($_SESSION['level'] == 'ADMINISTRATOR') {
								$recorddtl = 1;
							} else {
								$detail = mysqli_query($connect, "select * from userdtl where username='$username' and cmodule='$cmodule' and pakai='1'");
								$recorddtl = mysqli_num_rows($detail);
							}
							if ($recorddtl > 0) {
								if ($k['cmainmenu'] == 'Y') {
									if ($no == 1) {
										$mainmenu++; ?>
										<?php
										if (isset($_GET['m'])) {
											if (
												$_GET['m'] == 'tbbarang' or $_GET['m'] == 'tbgudang' or $_GET['m'] == 'tbjntrans'
												or $_GET['m'] == 'tbjnbrg' or $_GET['m'] == 'tbsatuan' or $_GET['m'] == 'tbnegara'
												or $_GET['m'] == 'tbmove' or $_GET['m'] == 'tbdiscount' or $_GET['m'] == 'tbcustomer'
												or $_GET['m'] == 'tbsupplier'
												or $_GET['m'] == 'tbmultiprc' or $_GET['m'] == 'tbsales' or $_GET['m'] == 'tbjnkeluar' or $_GET['m'] == 'tbbank'
											) {
												echo '<li class="treeview active">';
											} else {
												echo '<li class="treeview">';
											}
										} else {
											echo '<li class="treeview">';
										} ?>

										<?php
										echo '<a href="#HomeFile" data-toggle="collapse" aria-expanded="false">
											<i class="fa fa-th"></i>
											<i class="fa fa-angle-left pull-right"></i>';
										echo $k['cmodule'];
										echo '</a>
											<ul class="treeview-menu" id="HomeFile">';
									} else {
										$mainmenu++;
										if ($mainmenu > 1 and $mainmenu <= 3) {
											echo "</ul></li>";
											if (isset($_GET['m'])) {
												if ($_GET['m'] == 'so' or $_GET['m'] == 'jual' or $_GET['m'] == 'po' or $_GET['m'] == 'beli' or $_GET['m'] == 'terima' or $_GET['m'] == 'keluar' or $_GET['m'] == 'opname' or $_GET['m'] == 'approv_batas_piutang' or $_GET['m'] == 'kasir_tunai' or $_GET['m'] == 'permohonan_keluar_uang'  or $_GET['m'] == 'kasir_keluar' or $_GET['m'] == 'kasir_tagihan' or $_GET['m'] == 'kasir_kembali') {
													echo '<li class="treeview active">';
												} else {
													echo '<li class="treeview">';
												}
											} else {
												echo '<li class="treeview">';
											} ?>
										<?php
											echo '<a href="#home1" data-toggle="collapse" aria-expanded="false">
												<i class="fa fa-edit"></i>
												<i class="fa fa-angle-left pull-right"></i>';
											echo $k['cmodule'];
											echo '</a>
												<ul ul class="treeview-menu" id="home1"">';
										}
										if ($mainmenu > 3 and $mainmenu <= 5) {
											echo "</ul></li>";
											if (isset($_GET['m'])) {
												if ($_GET['m'] == 'rfaktur' or $_GET['m'] == 'rso' or $_GET['m'] == 'rjual' or $_GET['m'] == 'rpo' or $_GET['m'] == 'rbeli' or $_GET['m'] == 'rterima' or $_GET['m'] == 'rkeluar' or $_GET['m'] == 'rkasir_tunai' or $_GET['m'] == 'rkasir_tagihan' or $_GET['m'] == 'rpermohonan_keluar_uang' or $_GET['m'] == 'rkasir_keluar' or $_GET['m'] == 'rpiutang' or $_GET['m'] == 'rhutang' or $_GET['m'] == 'rfaktur_harian' or $_GET['m'] == 'rstock_opname' or $_GET['m'] == 'rstock') {
													echo '<li class="treeview active">';
												} else {
													echo '<li class="treeview">';
												}
											} else {
												echo '<li class="treeview">';
											} ?>
										<?php
											echo '<a href="#home2" data-toggle="collapse" aria-expanded="false">
												<i class="fa fa-file""></i>
												<i class="fa fa-angle-left pull-right"></i>';
											echo $k['cmodule'];
											echo '</a>
												<ul ul class="treeview-menu" id="home2"">';
										}
										$mainmenu++;
										if ($mainmenu > 6 and $mainmenu <= 8) {
											echo "</ul></li>";
											if (isset($_GET['m'])) {
												if ($_GET['m'] == 'closing_harian' or $_GET['m'] == 'closing_hpp') {
													echo '<li class="treeview active">';
												} else {
													echo '<li class="treeview">';
												}
											} else {
												echo '<li class="treeview">';
											} ?>
						<?php
											echo '<a href="#home3" data-toggle="collapse" aria-expanded="false">
												<i class="fa fa-cog""></i>
												<i class="fa fa-angle-left pull-right"></i>';
											echo $k['cmodule'];
											echo '</a>
												<ul ul class="treeview-menu" id="home3"">';
										}
									}
								} else {
									// if (isset($_GET['module'])) {
									// 	$cmodule = $k['cmodule'];
									// 	$form = $_SESSION['form'];
									// 	if ($_GET['module'] == $k['cmodule'] and ($_GET['m'] == $form)) {
									// 		echo "<li class=active><a href='./dashboard.php?m=$cmenu&module=$cmodule'>&#187; $k[cmodule]</a></li>";
									// 	} else {
									// 		echo "<li><a href='./dashboard.php?m=$cmenu&module=$cmodule'>&#187; $k[cmodule]</a></li>";
									// 	}
									// } else {
									// 	$cmodule = '';
									// 	echo "<li><a href='./dashboard.php?m=$cmenu&module=$cmodule'>&#187; $k[cmodule]</a></li>";
									// }
									$cmodule = $k['cmodule'];
									$form = $_SESSION['form'];
									if (isset($_GET['m'])) {
										if (isset($_GET['module'])) {
											if ($_GET['module'] == $k['cmodule'] and ($_GET['m'] == $form)) {
												echo "<li class=active><a href='./dashboard.php?m=$cmenu&module=$cmodule'>&#187; $k[cmodule]</a></li>";
											} else {
												echo "<li><a href='./dashboard.php?m=$cmenu&module=$cmodule'>&#187; $k[cmodule]</a></li>";
											}
										} else {
											echo "<li><a href='./dashboard.php?m=$cmenu&module=$cmodule'>&#187; $k[cmodule]</a></li>";
										}
									} else {
										echo "<li><a href='./dashboard.php?m=$cmenu&module=$cmodule'>&#187; $k[cmodule]</a></li>";
									}
									//echo "<li><a href='$m[link]'>&#187; $m[nama_modul]</a></li>";
								}
							}
							$no++;
						}
						echo "</ul></li>";

						?> <?php
								if (isset($_GET['m'])) {
									if (
										$_GET['m'] == 'saplikasi' or $_GET['m'] == 'user' or $_GET['m'] == 'rubahpass'
										or $_GET['m'] == 'updateprofile' or $_GET['m'] == 'backup' or $_GET['m'] == 'restore'
										or $_GET['m'] == 'tbmodule' or $_GET['m'] == 'reset'
									) {
										echo '<li class="treeview active">';
									} else {
										echo '<li class="treeview">';
									}
								} else {
									echo '<li class="treeview">';
								} ?>
						<a href="#utility" data-toggle="collapse" aria-expanded="false">
							<i class="fa fa-wrench"></i>
							<i class="fa fa-angle-left pull-right"></i>
							Utility
						</a>
						<ul ul class="treeview-menu" id="utility">
							<li><a href="./dashboard.php?m=saplikasi">&#187; Setup Aplikasi</a></li>
							<li><a href="./dashboard.php?m=tbmodule">&#187; Tabel Module</a></li>
							<li><a href="./dashboard.php?m=user">&#187; Manajemen User</a></li>
							<li><a href="./dashboard.php?m=rubahpass">&#187; Rubah Password</a></li>
							<li><a href="./dashboard.php?m=backup">&#187; Backup Database</a></li>
							<li><a href="./dashboard.php?m=reset">&#187; Reset Database</a></li>
							<li><a href="./dashboard.php?m=hisuser">&#187; History User</a></li>
						</ul>
						</li>
						<li>
							<a href="index.php">
								<i class="glyphicon glyphicon-log-out"></i>
								Logout</a>
						</li>
						<!--<h5 class='text-center'><font color='white'>Versi 1.00</font></h5>-->
						<!--<?php include("statistik_view.php"); ?>-->
						<!--<br>-->
						<!--<h4 class='text-center'><img src='img/logo_honda.png' width='150' height='150'></h4>-->
						<footer style="background: #333; color: #3333; padding: 3px; text-align: center;">
							<!--<hr>-->
							<h5 class='text-center'>
								<font color='bluewhite'>Versi 1.01</font>
							</h5>
							<span style="color: white">Copyright &copy; 2021 - <?= date('Y'); ?><br> Murod (085921282051)<br>All right reserved</span>
							<!--<hr>-->
						</footer>
						<br>
				</section>
				<!-- /.sidebar -->
			</aside>

			<!-- <div class="footer">
			<marquee behavior="alternate" onmouseover="this.stop()" onmouseout="this.start()" scrolldelay="10" style="font-family:calibri;" align="justify"><font color="white"> 
			Honda Autoland Group - E - Human Resources Management System V 1.0.0</font></marquee>
		</div> -->

			<!-- Right side column. Contains the navbar and content of the page -->
			<aside class="right-side">
				<!-- <aside class="right-side strech"> -->
				<!-- Content Header (Page header) -->
				<!--<section class="content-header">
                    <h1>
                        Dashboard
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>-->

				<?php if (empty($_GET['m'])) {
					//$outstanding_wo = mysqli_num_rows(mysqli_query($connect,"select nowo from wo where batal='N' and proses='N' "));
					//$outstanding_or = mysqli_num_rows(mysqli_query($connect,"select nowo from wo where batal='N' and own_risk>bayar"));
					//$outstanding_spk = mysqli_num_rows(mysqli_query($connect,"select noajukan from spkasuransi where nospk=''"));
					$user_login = mysqli_num_rows(mysqli_query($connect, "select id from user where login='Y'"));
				?>
					<!-- Main content -->
					<section class="content">
						<!-- <br><img class="img-rounded" src='shattered_@2X.png' width='1025' height='515' alt='Responsive image'> -->
						<!-- Small boxes (Stat box) -->
						<div class="row">
							<div class="col-lg-3 col-xs-6">
								<!-- small box -->
								<div class="small-box bg-aqua">
									<div class="inner">
										<h3>
											<?php
											$recc = mysqli_num_rows(mysqli_query($connect, "select noso from soh where proses='Y' and terima='N'"));
											echo $recc;
											?>
											<!--<?= $outstanding_wo ?>-->
										</h3>
										<p>
											Outstanding SO
										</p>
									</div>
									<div class="icon">
										<i class="ion ion-bag"></i>
									</div>
									<a href="#" class="small-box-footer">
										More info <i class="fa fa-arrow-circle-right"></i>
									</a>
								</div>
							</div><!-- ./col -->
							<div class="col-lg-3 col-xs-6">
								<!-- small box -->
								<div class="small-box bg-green">
									<div class="inner">
										<h3>
											<?php
											$recc = mysqli_num_rows(mysqli_query($connect, "select nopo from poh where proses='Y' and terima='N'"));
											echo $recc;
											?>
											<!--<?= $outstanding_or ?><sup style="font-size: 20px"></sup>-->
										</h3>
										<p>
											Outstanding PO
										</p>
									</div>
									<div class="icon">
										<i class="ion ion-stats-bars"></i>
									</div>
									<a href="#" class="small-box-footer">
										More info <i class="fa fa-arrow-circle-right"></i>
									</a>
								</div>
							</div><!-- ./col -->
							<div class="col-lg-3 col-xs-6">
								<!-- small box -->
								<div class="small-box bg-yellow">
									<div class="inner">
										<h3>
											<?php
											$recc = mysqli_fetch_assoc(mysqli_query($connect, "select coalesce(sum(kurangbayar),0) as kurangbayar from belih where proses='Y' and kurangbayar>0"));
											echo '<font size=6>' . number_format($recc['kurangbayar'], 0, ",", ".") . '</font>';
											?>
										</h3>
										<p>
											Saldo Hutang
										</p>
									</div>
									<div class="icon">
										<i class="ion-clipboard"></i>
									</div>
									<a href="#" class="small-box-footer">
										More info <i class="fa fa-arrow-circle-right"></i>
									</a>
								</div>
							</div><!-- ./col -->
							<div class="col-lg-3 col-xs-6">
								<!-- small box -->
								<div class="small-box bg-red">
									<div class="inner">
										<h3>
											<?php
											$recc = mysqli_fetch_assoc(mysqli_query($connect, "select coalesce(sum(kurangbayar),0) as kurangbayar from jualh where proses='Y' and kurangbayar>0"));
											echo '<font size=6>' . number_format($recc['kurangbayar'], 0, ",", ".") . '</font>';
											// echo number_format($recc['kurangbayar'], 0, ",", ".");
											?>
										</h3>
										<p>
											Saldo Piutang
										</p>
									</div>
									<div class="icon">
										<i class="ion ion-pie-graph"></i>
									</div>
									<a href="#" class="small-box-footer">
										More info <i class="fa fa-arrow-circle-right"></i>
									</a>
								</div>
							</div><!-- ./col -->
						</div><!-- /.row -->
						<div class="row">
							<div class="col-lg-3 col-xs-6">
								<!-- small box -->
								<div class="small-box bg-blue">
									<div class="inner">
										<h3>
											<?php
											$today = date('Y-m-d');
											$month = date('m');
											$year = date('Y');
											$recc = mysqli_fetch_assoc(mysqli_query($connect, "select coalesce(sum(total),0) as total from jualh where proses='Y' and month(tgljual)='$month' and year(tgljual)='$year'"));
											echo '<font size=6>' . number_format($recc['total'], 0, ",", ".") . '</font>';
											?>
										</h3>
										<p>
											Penjualan bulan ini
										</p>
									</div>
									<div class="icon">
										<i class="ion ion-pie-graph"></i>
									</div>
									<a href="#" class="small-box-footer">
										More info <i class="fa fa-arrow-circle-right"></i>
									</a>
								</div>
							</div><!-- ./col -->
							<div class="col-lg-3 col-xs-6">
								<!-- small box -->
								<div class="small-box bg-blue">
									<div class="inner">
										<h3>
											<?php
											$today = date('Y-m-d');
											$month = date('m');
											$year = date('Y');
											$recc = mysqli_fetch_assoc(mysqli_query($connect, "select coalesce(sum(total),0) as total from belih where proses='Y' and month(tglbeli)='$month' and year(tglbeli)='$year'"));
											echo '<font size=6>' . number_format($recc['total'], 0, ",", ".") . '</font>';
											?>
										</h3>
										<p>
											Pembelian bulan ini
										</p>
									</div>
									<div class="icon">
										<i class="ion ion-pie-graph"></i>
									</div>
									<a href="#" class="small-box-footer">
										More info <i class="fa fa-arrow-circle-right"></i>
									</a>
								</div>
							</div><!-- ./col -->
							<div class="col-lg-3 col-xs-6">
								<!-- small box -->
								<div class="small-box bg-yellow">
									<div class="inner">
										<h3>
											<?php
											$today = date('Y-m-d');
											$month = date('m');
											$year = date('Y');
											$recc = mysqli_fetch_assoc(mysqli_query($connect, "select coalesce(sum(total),0) as total from belih where proses='Y' and year(tglbeli)='$year'"));
											echo '<font size=6>' . number_format($recc['total'], 0, ",", ".") . '</font>';
											?>
										</h3>
										<p>
											Pembelian tahun ini
										</p>
									</div>
									<div class="icon">
										<i class="ion ion-pie-graph"></i>
									</div>
									<a href="#" class="small-box-footer">
										More info <i class="fa fa-arrow-circle-right"></i>
									</a>
								</div>
							</div><!-- ./col -->
							<div class="col-lg-3 col-xs-6">
								<!-- small box -->
								<div class="small-box bg-red">
									<div class="inner">
										<h3>
											<?php
											$today = date('Y-m-d');
											$month = date('m');
											$year = date('Y');
											$recc = mysqli_fetch_assoc(mysqli_query($connect, "select coalesce(sum(total),0) as total from jualh where proses='Y' and year(tgljual)='$year'"));
											echo '<font size=6>' . number_format($recc['total'], 0, ",", ".") . '</font>';
											?>
										</h3>
										<p>
											Penjualan tahun ini

										</p>
									</div>
									<div class="icon">
										<i class="ion ion-pie-graph"></i>
									</div>
									<a href="#" class="small-box-footer">
										More info <i class="fa fa-arrow-circle-right"></i>
									</a>
								</div>
							</div><!-- ./col -->
						</div><!-- ./row -->
					</section><!-- /.content -->

				<?php } else { ?>
					<section class="content-header">
						<?php include("content.php"); ?>
					</section>
				<?php } ?>

				<?php
				if (empty($_GET['m'])) {
					//include("dashboard_wo.php");
				}
				?>

			</aside><!-- /.right-side -->

			<div class="footer">
				<marquee behavior="alternate" onmouseover="this.stop()" onmouseout="this.start()" scrolldelay="10" style="font-family:calibri;" align="justify">
					<font color="white">
						<?php echo $_SESSION['nm_perusahaan'] ?> - Point Of Sales Versi 1.01</font>
				</marquee>
			</div>

		</div><!-- ./wrapper -->


		<!-- Modal -->
		<div class="modal fade" id="modalbatalproses" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel1">Batal Proses</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					</div>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="searchdatamodal_barang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel1">Cari data barang multi price</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<table class="table table-striped table-bordered table-hover" id="table_filter_find_barang">
							<thead>
								<tr>
									<th colspan="3">
										<input type="text" class="form-control" name="search" id="search" onkeyup="cari_data_list_barang(this.value)" autofocus="">
									</th>
								</tr>
							</thead>
							<tbody id="isi_data" class="isi_data">
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="searchdatamodal_tbbarang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel1">Cari data Tabel Barang</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<table class="table table-striped table-bordered table-hover" id="table_filter_find_tbbarang">
							<thead>
								<tr>
									<th colspan="3">
										<input type="text" class="form-control" name="search" id="search" onkeyup="cari_data_list_tbbarang(this.value)" autofocus="">
									</th>

								</tr>
							</thead>
							<tbody id="isi_data" class="isi_data">
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="searchdatamodal_barang_beli" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel1">Cari data Barang B</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<table class="table table-striped table-bordered table-hover" id="table_filter_find_barang_beli">
							<thead>
								<tr>
									<th colspan="3">
										<input type="text" class="form-control" name="search" id="search" onkeyup="cari_data_list_barang_beli(this.value)" autofocus="">
									</th>

								</tr>
							</thead>
							<tbody id="isi_data" class="isi_data">
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="searchdatamodal_opname" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel1">Cari data Stock Opname</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<table class="table table-striped table-bordered table-hover" id="table_filter_find_opname">
							<thead>
								<tr>
									<th colspan="3">
										<input type="text" class="form-control" name="search" id="search" onkeyup="cari_data_opname(this.value)" autofocus="">
									</th>

								</tr>
							</thead>
							<tbody id="isi_data" class="isi_data">
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="searchdatamodal_penjualan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel1">Cari data Penjualan</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<table class="table table-striped table-bordered table-hover" id="table_filter_find_penjualan">
							<thead>
								<tr>
									<th colspan="3">
										<input type="text" class="form-control" name="search" id="search" onkeyup="cari_data_list_penjualan(this.value)" autofocus="">
									</th>

								</tr>
							</thead>
							<tbody id="isi_data" class="isi_data">
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="searchdatamodal_customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
			<!-- <div class="modal-dialog" role="document"> -->
			<div class="modal-dialog modal-lg" style="width:80%">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel1">Cari data Customer</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<table class="table table-striped table-bordered table-hover" id="table_filter_find_customer">
							<thead>
								<tr>
									<th colspan="3">
										<input type="text" class="form-control" name="search" id="search" onkeyup="cari_data_list_customer(this.value)" autofocus="">
									</th>

								</tr>
							</thead>
							<tbody id="isi_data" class="isi_data">
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="searchdatamodal_sales" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel1">Cari data Sales</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<table class="table table-striped table-bordered table-hover" id="table_filter_find_sales">
							<thead>
								<tr>
									<th colspan="3">
										<input type="text" class="form-control" name="search" id="search" onkeyup="cari_data_list_sales(this.value)" autofocus="">
									</th>

								</tr>
							</thead>
							<tbody id="isi_data" class="isi_data">
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="searchdatamodal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel1">Cari data Supplier</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<table class="table table-striped table-bordered table-hover" id="table_filter_find4">
							<thead>
								<tr>
									<th colspan="3">
										<input type="text" class="form-control" name="search" id="search" onkeyup="cari_data_list_find4(this.value)" autofocus="">
									</th>
								</tr>
							</thead>
							<tbody id="isi_data" class="isi_data">
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="searchdatamodal_supplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel1">Cari Data Supplier</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<table class="table table-striped table-bordered table-hover" id="table_filter_find_supplier">
							<thead>
								<tr>
									<th colspan="3">
										<input type="text" class="form-control" name="search" id="search" onkeyup="cari_data_list_supplier(this.value)" autofocus="">
									</th>

								</tr>
							</thead>
							<tbody id="isi_data" class="isi_data">
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="searchdatamodal_po" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel1">Cari data PO1</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<table class="table table-striped table-bordered table-hover" id="table_filter_find_po">
							<thead>
								<tr>
									<th colspan="3">
										<input type="text" class="form-control" name="search" id="search" onkeyup="cari_data_list_po(this.value)" autofocus="">
									</th>

								</tr>
							</thead>
							<tbody id="isi_data" class="isi_data">
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="searchdatamodal_so" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel1">Cari data Sales Order</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<table class="table table-striped table-bordered table-hover" id="table_filter_find_so">
							<thead>
								<tr>
									<th colspan="3">
										<input type="text" class="form-control" name="search" id="search" onkeyup="cari_data_list_so(this.value)" autofocus="">
									</th>

								</tr>
							</thead>
							<tbody id="isi_data" class="isi_data">
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="searchdatamodal_jual" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel1">Cari data Sales Order</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<table class="table table-striped table-bordered table-hover" id="table_filter_find_jual">
							<thead>
								<tr>
									<th colspan="3">
										<input type="text" class="form-control" name="search" id="search" onkeyup="cari_data_list_jual(this.value)" autofocus="">
									</th>

								</tr>
							</thead>
							<tbody id="isi_data" class="isi_data">
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="searchdatamodal_permohonan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel1">Cari data Permohonan</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<table class="table table-striped table-bordered table-hover" id="table_filter_find_permohonan">
							<thead>
								<tr>
									<th colspan="3">
										<input type="text" class="form-control" name="search" id="search" onkeyup="cari_data_list_permohonan(this.value)" autofocus="">
									</th>

								</tr>
							</thead>
							<tbody id="isi_data" class="isi_data">
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="searchdatamodal_bank" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Cari Data Bank</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<table class="table table-striped table-bordered table-hover" id="table_filter_find_bank">
							<thead>
								<tr>
									<th colspan="3">
										<input type="text" class="form-control" name="search" id="search" onkeyup="cari_data_list_bank(this.value)" autofocus="">
									</th>
								</tr>
							</thead>
							<tbody id="isi_data" class="isi_data">
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="searchdatamodal_hutang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Cari Data Hutang</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<table class="table table-striped table-bordered table-hover" id="table_filter_find_hutang">
							<thead>
								<tr>
									<th colspan="3">
										<input type="text" class="form-control" name="search" id="search" onkeyup="cari_data_list_hutang(this.value)" autofocus="">
									</th>
								</tr>
							</thead>
							<tbody id="isi_data" class="isi_data">
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="searchdatamodal_kembali" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Cari Data Penjualan</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<table class="table table-striped table-bordered table-hover" id="table_filter_find_kembali">
							<thead>
								<tr>
									<th colspan="3">
										<input type="text" class="form-control" name="search" id="search" onkeyup="cari_data_list_kembali(this.value)" autofocus="">
									</th>
								</tr>
							</thead>
							<tbody id="isi_data" class="isi_data">
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="searchdatamodal_jnkeluar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Cari Data Jenis Pengeluaran</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<table class="table table-striped table-bordered table-hover" id="table_filter_find_jnkeluar">
							<thead>
								<tr>
									<th colspan="3">
										<input type="text" class="form-control" name="search" id="search" onkeyup="cari_data_list_jnkeluar(this.value)" autofocus="">
									</th>
								</tr>
							</thead>
							<tbody id="isi_data" class="isi_data">
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="searchdatamodal_jnskartu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Cari Data Jenis Kartu</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<table class="table table-striped table-bordered table-hover" id="table_filter_find_jnskartu">
							<thead>
								<tr>
									<th colspan="3">
										<input type="text" class="form-control" name="search" id="search" onkeyup="cari_data_list_jnskartu(this.value)" autofocus="">
									</th>
								</tr>
							</thead>
							<tbody id="isi_data" class="isi_data">
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		<script src="js/sweet-alert.min.js" type="text/javascript"></script>
		<?php
		function cekakses($connect, $user, $module)
		{
			if ($_SESSION['level'] == 'ADMINISTRATOR') {
				$_SESSION['aksespakai'] = 1;
				$_SESSION['aksestambah'] = 1;
				$_SESSION['aksesedit'] = 1;
				$_SESSION['akseshapus'] = 1;
				$_SESSION['aksesproses'] = 1;
				$_SESSION['aksesunproses'] = 1;
				$_SESSION['aksescetak'] = 1;
			} else {
				$sql = mysqli_query($connect, "select * from userdtl where username='$user' and cmodule='$module'");
				$de = mysqli_fetch_assoc($sql);
				$_SESSION['aksespakai'] = $de['pakai'];
				$_SESSION['aksestambah'] = $de['tambah'];
				$_SESSION['aksesedit'] = $de['edit'];
				$_SESSION['akseshapus'] = $de['hapus'];
				$_SESSION['aksesproses'] = $de['proses'];
				$_SESSION['aksesunproses'] = $de['unproses'];
				$_SESSION['aksescetak'] = $de['cetak'];
			}
		}
		?>

		<script>
			// Nampilin list data pilihan ===================
			function cari_data_pegawai() {
				$.ajax({
					method: "POST",
					url: "cari-data-pegawai.php",
					success: function(data) {
						$("#searchdatamodal").modal('show');
						$("#searchdatamodal").find('.isi_data').html(data);
					}
				})
			}

			/// Ini filter di list datanya yaaa ==========
			function cari_data_list(data) {
				// var $rows = $('#isi_data tr');
				// $('#search').keyup(function() {
				// var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

				// $rows.show().filter(function() {
				// var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
				// return !~text.indexOf(val);
				// }).hide();
				// });
				console.log(data);
				$.ajax({
					method: "POST",
					data: {
						isifilter: data
					},
					url: "cari-data-pegawai.php",
					success: function(data) {
						$("#searchdatamodal").modal('show');
						$("#searchdatamodal").find('.isi_data').html(data);
					}
				})

			}

			// Nampilin list data pilihan ===================
			function cari_data_nopolisi() {

				$.ajax({
					method: "POST",
					url: "cari-data-nopolisi.php",
					success: function(data) {
						$("#searchdatamodal1").modal('show');
						$("#searchdatamodal1").find('.isi_data').html(data);
					}
				})

			}

			// Buat dapetin data waktu di klik list data yang dipilih ==========
			function post1() {
				var table = document.getElementById("table_filter_find1");
				var tbody = table.getElementsByTagName("tbody")[0];
				tbody.onclick = function(e) {
					e = e || window.event;
					var data = [];
					var target = e.srcElement || e.target;
					while (target && target.nodeName !== "TR") {
						target = target.parentNode;
					}
					if (target) {
						var cells = target.getElementsByTagName("td");
						for (var i = 0; i < cells.length; i++) {
							data.push('--separator--' + cells[i].innerHTML);
							dt = data.toString();

						}
					}

					dt_split = dt.split(",--separator--");
					$('#nopolisi').val(((dt_split[0]).replace("--separator--", "")).trim());
					$('#norangka').val(((dt_split[1]).replace("--separator--", "")).trim());
					$('#nomesin').val(((dt_split[2]).replace("--separator--", "")).trim());
					$('#tahun').val(((dt_split[3]).replace("--separator--", "")).trim());
				};
			}

			// Nampilin list data pilihan ===================
			function cari_data_spk() {
				$.ajax({
					method: "POST",
					url: "cari-data-spk.php",
					success: function(data) {
						$("#searchdatamodal3").modal('show');
						$("#searchdatamodal3").find('.isi_data').html(data);
					}
				})

			}

			// Buat dapetin data waktu di klik list data yang dipilih ==========
			function post3() {
				var table = document.getElementById("table_filter_find3");
				var tbody = table.getElementsByTagName("tbody")[0];
				tbody.onclick = function(e) {
					e = e || window.event;
					var data = [];
					var target = e.srcElement || e.target;
					while (target && target.nodeName !== "TR") {
						target = target.parentNode;
					}
					if (target) {
						var cells = target.getElementsByTagName("td");
						for (var i = 0; i < cells.length; i++) {
							data.push('--separator--' + cells[i].innerHTML);
							dt = data.toString();

						}
					}

					dt_split = dt.split(",--separator--");
					$('#nospk').val(((dt_split[0]).replace("--separator--", "")).trim());
					$('#tglspk').val(((dt_split[1]).replace("--separator--", "")).trim());
					$('#nopolisi').val(((dt_split[2]).replace("--separator--", "")).trim());
					$('#norangka').val(((dt_split[3]).replace("--separator--", "")).trim());
					$('#nomesin').val(((dt_split[4]).replace("--separator--", "")).trim());
					$('#tahun').val(((dt_split[5]).replace("--separator--", "")).trim());
					$('#kdasuransi').val(((dt_split[6]).replace("--separator--", "")).trim());
					$('#nmasuransi').val(((dt_split[7]).replace("--separator--", "")).trim());
					$('#kdcust').val(((dt_split[8]).replace("--separator--", "")).trim());
					$('#nmcust').val(((dt_split[9]).replace("--separator--", "")).trim());
				};
			}

			// Nampilin list data pilihan ===================
			function cari_data_supplier() {
				$.ajax({
					method: "POST",
					url: "cari-data-supplier.php",
					success: function(data) {
						$("#searchdatamodal_supplier").modal('show');
						$("#searchdatamodal_supplier").find('.isi_data').html(data);
					}
				})

			}
			// Buat dapetin data waktu di klik list data yang dipilih ==========
			function post_supplier() {
				var table = document.getElementById("table_filter_find_supplier");
				var tbody = table.getElementsByTagName("tbody")[0];
				tbody.onclick = function(e) {
					e = e || window.event;
					var data = [];
					var target = e.srcElement || e.target;
					while (target && target.nodeName !== "TR") {
						target = target.parentNode;
					}
					if (target) {
						var cells = target.getElementsByTagName("td");
						for (var i = 0; i < cells.length; i++) {
							data.push('--separator--' + cells[i].innerHTML);
							dt = data.toString();

						}
					}
					dt_split = dt.split(",--separator--");
					$('#kdsupplier').val(((dt_split[0]).replace("--separator--", "")).trim());
					$('#nmsupplier').val(((dt_split[1]).replace("--separator--", "")).trim());
					$('#alamat').val(((dt_split[2]).replace("--separator--", "")).trim());
				};
			}
			/// Ini filter di list datanya yaaa ==========
			function cari_data_list_supplier(data) {
				console.log(data);
				$.ajax({
					method: "POST",
					data: {
						isifilter: data
					},
					url: "cari-data-supplier.php",
					success: function(data) {
						$("#searchdatamodal_supplier").modal('show');
						$("#searchdatamodal_supplier").find('.isi_data').html(data);
					}
				})

			}

			// Nampilin list data pilihan ===================
			function cari_data_po() {
				$.ajax({
					method: "POST",
					url: "cari-data-po.php",
					success: function(data) {
						$("#searchdatamodal_po").modal('show');
						$("#searchdatamodal_po").find('.isi_data').html(data);
					}
				})

			}
			// Buat dapetin data waktu di klik list data yang dipilih ==========
			function post_po() {
				var table = document.getElementById("table_filter_find_po");
				var tbody = table.getElementsByTagName("tbody")[0];
				tbody.onclick = function(e) {
					e = e || window.event;
					var data = [];
					var target = e.srcElement || e.target;
					while (target && target.nodeName !== "TR") {
						target = target.parentNode;
					}
					if (target) {
						var cells = target.getElementsByTagName("td");
						for (var i = 0; i < cells.length; i++) {
							data.push('--separator--' + cells[i].innerHTML);
							dt = data.toString();
						}
					}
					dt_split = dt.split(",--separator--");
					$('#nopo').val(((dt_split[0]).replace("--separator--", "")).trim());
					// $('#kdsupplier').val(((dt_split[2]).replace("--separator--","")).trim());
					// $('#nmsupplier').val(((dt_split[3]).replace("--separator--","")).trim());
					// $('#jenis_order').val(((dt_split[4]).replace("--separator--","")).trim());
					// $('#biaya_lain').val(((dt_split[5]).replace("--separator--","")).trim());
					// $('#ket_biaya_lain').val(((dt_split[6]).replace("--separator--","")).trim());
					// $('#tglkirim').val(((dt_split[7]).replace("--separator--","")).trim());
					// $('#carabayar').val(((dt_split[8]).replace("--separator--","")).trim());
					// $('#tempo').val(((dt_split[9]).replace("--separator--","")).trim());
					// $('#tgl_jt_tempo').val(((dt_split[10]).replace("--separator--","")).trim());
					// $('#subtotal').val(((dt_split[11]).replace("--separator--","")).trim());
					// $('#total_sementara').val(((dt_split[12]).replace("--separator--","")).trim());
					// $('#ppn').val(((dt_split[13]).replace("--separator--","")).trim());
					// $('#materai').val(((dt_split[14]).replace("--separator--","")).trim());
					// $('#total').val(((dt_split[15]).replace("--separator--","")).trim());
				};
			}

			// Nampilin list data pilihan ===================
			function cari_data_list_po(data) {
				console.log(data);
				$.ajax({
					method: "POST",
					data: {
						isifilter: data
					},
					url: "cari-data-po.php",
					success: function(data) {
						$("#searchdatamodal_po").modal('show');
						$("#searchdatamodal_po").find('.isi_data').html(data);
					}
				})
			}

			function cari_data_list_so(data) {
				$.ajax({
					method: "POST",
					data: {
						isifilter: data
					},
					url: "cari-data-so.php",
					success: function(data) {
						$("#searchdatamodal_so").modal('show');
						$("#searchdatamodal_so").find('.isi_data').html(data);
					}
				})
			}

			// Nampilin list data pilihan ===================
			function cari_data_so() {
				$.ajax({
					method: "POST",
					url: "cari-data-so.php",
					success: function(data) {
						$("#searchdatamodal_so").modal('show');
						$("#searchdatamodal_so").find('.isi_data').html(data);
					}
				})

			}
			// Buat dapetin data waktu di klik list data yang dipilih ==========
			function post_so() {
				var table = document.getElementById("table_filter_find_so");
				var tbody = table.getElementsByTagName("tbody")[0];
				tbody.onclick = function(e) {
					e = e || window.event;
					var data = [];
					var target = e.srcElement || e.target;
					while (target && target.nodeName !== "TR") {
						target = target.parentNode;
					}
					if (target) {
						var cells = target.getElementsByTagName("td");
						for (var i = 0; i < cells.length; i++) {
							data.push('--separator--' + cells[i].innerHTML);
							dt = data.toString();
						}
					}
					dt_split = dt.split(",--separator--");
					$('#noso').val(((dt_split[0]).replace("--separator--", "")).trim());
					// $('#kdsupplier').val(((dt_split[2]).replace("--separator--","")).trim());
					// $('#nmsupplier').val(((dt_split[3]).replace("--separator--","")).trim());
					// $('#jenis_order').val(((dt_split[4]).replace("--separator--","")).trim());
					// $('#biaya_lain').val(((dt_split[5]).replace("--separator--","")).trim());
					// $('#ket_biaya_lain').val(((dt_split[6]).replace("--separator--","")).trim());
					// $('#tglkirim').val(((dt_split[7]).replace("--separator--","")).trim());
					// $('#carabayar').val(((dt_split[8]).replace("--separator--","")).trim());
					// $('#tempo').val(((dt_split[9]).replace("--separator--","")).trim());
					// $('#tgl_jt_tempo').val(((dt_split[10]).replace("--separator--","")).trim());
					// $('#subtotal').val(((dt_split[11]).replace("--separator--","")).trim());
					// $('#total_sementara').val(((dt_split[12]).replace("--separator--","")).trim());
					// $('#ppn').val(((dt_split[13]).replace("--separator--","")).trim());
					// $('#materai').val(((dt_split[14]).replace("--separator--","")).trim());
					// $('#total').val(((dt_split[15]).replace("--separator--","")).trim());
				};
			}

			// Nampilin list data pilihan ===================
			function cari_data_jual() {
				$.ajax({
					method: "POST",
					url: "cari-data-jual.php",
					success: function(data) {
						$("#searchdatamodal_jual").modal('show');
						$("#searchdatamodal_jual").find('.isi_data').html(data);
					}
				})

			}
			// Buat dapetin data waktu di klik list data yang dipilih ==========
			function post_jual() {
				var table = document.getElementById("table_filter_find_jual");
				var tbody = table.getElementsByTagName("tbody")[0];
				tbody.onclick = function(e) {
					e = e || window.event;
					var data = [];
					var target = e.srcElement || e.target;
					while (target && target.nodeName !== "TR") {
						target = target.parentNode;
					}
					if (target) {
						var cells = target.getElementsByTagName("td");
						for (var i = 0; i < cells.length; i++) {
							data.push('--separator--' + cells[i].innerHTML);
							dt = data.toString();
						}
					}
					dt_split = dt.split(",--separator--");
					$('#nojual').val(((dt_split[0]).replace("--separator--", "")).trim());
					$('#tgljual').val(((dt_split[1]).replace("--separator--", "")).trim());
				};
			}

			function cari_data_list_jual(data) {
				$.ajax({
					method: "POST",
					data: {
						isifilter: data
					},
					url: "cari-data-jual.php",
					success: function(data) {
						$("#searchdatamodal_jual").modal('show');
						$("#searchdatamodal_jual").find('.isi_data').html(data);
					}
				})
			}

			// Nampilin list data pilihan ===================
			function cari_data_permohonan() {
				$.ajax({
					method: "POST",
					url: "cari-data-permohonan.php",
					success: function(data) {
						$("#searchdatamodal_permohonan").modal('show');
						$("#searchdatamodal_permohonan").find('.isi_data').html(data);
					}
				})

			}

			function cari_data_list_permohonan(data) {
				$.ajax({
					method: "POST",
					data: {
						isifilter: data
					},
					url: "cari-data-permohonan.php",
					success: function(data) {
						$("#searchdatamodal_permohonan").modal('show');
						$("#searchdatamodal_permohonan").find('.isi_data').html(data);
					}
				})
			}
			// Buat dapetin data waktu di klik list data yang dipilih ==========
			function post_permohonan() {
				var table = document.getElementById("table_filter_find_permohonan");
				var tbody = table.getElementsByTagName("tbody")[0];
				tbody.onclick = function(e) {
					e = e || window.event;
					var data = [];
					var target = e.srcElement || e.target;
					while (target && target.nodeName !== "TR") {
						target = target.parentNode;
					}
					if (target) {
						var cells = target.getElementsByTagName("td");
						for (var i = 0; i < cells.length; i++) {
							data.push('--separator--' + cells[i].innerHTML);
							dt = data.toString();
						}
					}
					dt_split = dt.split(",--separator--");
					$('#nomohon').val(((dt_split[0]).replace("--separator--", "")).trim());
					$('#tglmohon').val(((dt_split[2]).replace("--separator--", "")).trim());
					$('#nmjnkeluar').val(((dt_split[3]).replace("--separator--", "")).trim());
					$('#kdjnkeluar').val(((dt_split[4]).replace("--separator--", "")).trim());
				};
			}
			// Nampilin list data pilihan ===================
			function cari_data_wo() {
				$.ajax({
					method: "POST",
					url: "cari-data-wo.php",
					success: function(data) {
						$("#searchdatamodal5").modal('show');
						$("#searchdatamodal5").find('.isi_data').html(data);
					}
				})

			}
			// Buat dapetin data waktu di klik list data yang dipilih ==========
			function post5() {
				var table = document.getElementById("table_filter_find5");
				var tbody = table.getElementsByTagName("tbody")[0];
				tbody.onclick = function(e) {
					e = e || window.event;
					var data = [];
					var target = e.srcElement || e.target;
					while (target && target.nodeName !== "TR") {
						target = target.parentNode;
					}
					if (target) {
						var cells = target.getElementsByTagName("td");
						for (var i = 0; i < cells.length; i++) {
							data.push('--separator--' + cells[i].innerHTML);
							dt = data.toString();

						}
					}
					dt_split = dt.split(",--separator--");
					$('#nowo').val(((dt_split[0]).replace("--separator--", "")).trim());
					$('#nopolisi').val(((dt_split[1]).replace("--separator--", "")).trim());
					$('#norangka').val(((dt_split[2]).replace("--separator--", "")).trim());
					$('#nilai').val(((dt_split[3]).replace("--separator--", "")).trim());
					$('#bayar').val(((dt_split[3]).replace("--separator--", "")).trim());
					$('#uang').val(((dt_split[3]).replace("--separator--", "")).trim());
					$('#nmcust').val(((dt_split[4]).replace("--separator--", "")).trim());
				};
			}

			// Nampilin list data pilihan ===================
			function cari_data_bank() {
				$.ajax({
					method: "POST",
					url: "cari-data-bank.php",
					success: function(data) {
						$("#searchdatamodal_bank").modal('show');
						$("#searchdatamodal_bank").find('.isi_data').html(data);
					}
				})

			}
			// Buat dapetin data waktu di klik list data yang dipilih ==========
			function post_bank() {
				var table = document.getElementById("table_filter_find_bank");
				var tbody = table.getElementsByTagName("tbody")[0];
				tbody.onclick = function(e) {
					e = e || window.event;
					var data = [];
					var target = e.srcElement || e.target;
					while (target && target.nodeName !== "TR") {
						target = target.parentNode;
					}
					if (target) {
						var cells = target.getElementsByTagName("td");
						for (var i = 0; i < cells.length; i++) {
							data.push('--separator--' + cells[i].innerHTML);
							dt = data.toString();

						}
					}
					dt_split = dt.split(",--separator--");
					$('#kdbank').val(((dt_split[0]).replace("--separator--", "")).trim());
					$('#nmbank').val(((dt_split[1]).replace("--separator--", "")).trim());
				};
			}
			/// Ini filter di list datanya yaaa ==========
			function cari_data_list_bank(data) {
				console.log(data);
				$.ajax({
					method: "POST",
					data: {
						isifilter: data
					},
					url: "cari-data-bank.php",
					success: function(data) {
						$("#searchdatamodal_bank").modal('show');
						$("#searchdatamodal_bank").find('.isi_data').html(data);
					}
				})

			}

			// Nampilin list data pilihan ===================
			function cari_data_hutang() {
				$.ajax({
					method: "POST",
					url: "cari-data-hutang.php",
					success: function(data) {
						$("#searchdatamodal_hutang").modal('show');
						$("#searchdatamodal_hutang").find('.isi_data').html(data);
					}
				})

			}
			// Buat dapetin data waktu di klik list data yang dipilih ==========
			function post_hutang() {
				var table = document.getElementById("table_filter_find_hutang");
				var tbody = table.getElementsByTagName("tbody")[0];
				tbody.onclick = function(e) {
					e = e || window.event;
					var data = [];
					var target = e.srcElement || e.target;
					while (target && target.nodeName !== "TR") {
						target = target.parentNode;
					}
					if (target) {
						var cells = target.getElementsByTagName("td");
						for (var i = 0; i < cells.length; i++) {
							data.push('--separator--' + cells[i].innerHTML);
							dt = data.toString();

						}
					}
					dt_split = dt.split(",--separator--");
					$('#nodokumen').val(((dt_split[0]).replace("--separator--", "")).trim());
					$('#tgldokumen').val(((dt_split[1]).replace("--separator--", "")).trim());
					$('#kdsupplier').val(((dt_split[2]).replace("--separator--", "")).trim());
					$('#nmsupplier').val(((dt_split[3]).replace("--separator--", "")).trim());
					$('#total').val(((dt_split[4]).replace("--separator--", "")).trim());
					$('#uang').val(((dt_split[4]).replace("--separator--", "")).trim());
				};
			}
			/// Ini filter di list datanya yaaa ==========
			function cari_data_list_hutang(data) {
				console.log(data);
				$.ajax({
					method: "POST",
					data: {
						isifilter: data
					},
					url: "cari-data-hutang.php",
					success: function(data) {
						$("#searchdatamodal_hutang").modal('show');
						$("#searchdatamodal_hutang").find('.isi_data').html(data);
					}
				})

			}

			// Nampilin list data pilihan ===================
			function cari_data_kembali() {
				$.ajax({
					method: "POST",
					url: "cari-data-kembali.php",
					success: function(data) {
						$("#searchdatamodal_kembali").modal('show');
						$("#searchdatamodal_kembali").find('.isi_data').html(data);
					}
				})

			}
			// Buat dapetin data waktu di klik list data yang dipilih ==========
			function post_kembali() {
				var table = document.getElementById("table_filter_find_kembali");
				var tbody = table.getElementsByTagName("tbody")[0];
				tbody.onclick = function(e) {
					e = e || window.event;
					var data = [];
					var target = e.srcElement || e.target;
					while (target && target.nodeName !== "TR") {
						target = target.parentNode;
					}
					if (target) {
						var cells = target.getElementsByTagName("td");
						for (var i = 0; i < cells.length; i++) {
							data.push('--separator--' + cells[i].innerHTML);
							dt = data.toString();

						}
					}
					dt_split = dt.split(",--separator--");
					$('#nodokumen').val(((dt_split[0]).replace("--separator--", "")).trim());
					$('#tgldokumen').val(((dt_split[1]).replace("--separator--", "")).trim());
					$('#kdsupplier').val(((dt_split[2]).replace("--separator--", "")).trim());
					$('#nmsupplier').val(((dt_split[3]).replace("--separator--", "")).trim());
					$('#total').val(((dt_split[4]).replace("--separator--", "")).trim());
					$('#uang').val(((dt_split[4]).replace("--separator--", "")).trim());
				};
			}
			/// Ini filter di list datanya yaaa ==========
			function cari_data_list_kembali(data) {
				console.log(data);
				$.ajax({
					method: "POST",
					data: {
						isifilter: data
					},
					url: "cari-data-kembali.php",
					success: function(data) {
						$("#searchdatamodal_kembali").modal('show');
						$("#searchdatamodal_kembali").find('.isi_data').html(data);
					}
				})

			}

			// Nampilin list data pilihan ===================
			function cari_data_jnkeluar() {
				$.ajax({
					method: "POST",
					url: "cari-data-jnkeluar.php",
					success: function(data) {
						$("#searchdatamodal_jnkeluar").modal('show');
						$("#searchdatamodal_jnkeluar").find('.isi_data').html(data);
					}
				})

			}
			// Buat dapetin data waktu di klik list data yang dipilih ==========
			function post_jnkeluar() {
				var table = document.getElementById("table_filter_find_jnkeluar");
				var tbody = table.getElementsByTagName("tbody")[0];
				tbody.onclick = function(e) {
					e = e || window.event;
					var data = [];
					var target = e.srcElement || e.target;
					while (target && target.nodeName !== "TR") {
						target = target.parentNode;
					}
					if (target) {
						var cells = target.getElementsByTagName("td");
						for (var i = 0; i < cells.length; i++) {
							data.push('--separator--' + cells[i].innerHTML);
							dt = data.toString();

						}
					}
					dt_split = dt.split(",--separator--");
					$('#kdjnkeluar').val(((dt_split[0]).replace("--separator--", "")).trim());
					$('#nmjnkeluar').val(((dt_split[1]).replace("--separator--", "")).trim());
				};
			}
			/// Ini filter di list datanya yaaa ==========
			function cari_data_list_jnkeluar(data) {
				console.log(data);
				$.ajax({
					method: "POST",
					data: {
						isifilter: data
					},
					url: "cari-data-jnkeluar.php",
					success: function(data) {
						$("#searchdatamodal_jnkeluar").modal('show');
						$("#searchdatamodal_jnkeluar").find('.isi_data').html(data);
					}
				})

			}

			// Nampilin list data pilihan ===================
			function cari_data_jnskartu() {
				$.ajax({
					method: "POST",
					url: "cari-data-jnskartu.php",
					success: function(data) {
						$("#searchdatamodal_jnskartu").modal('show');
						$("#searchdatamodal_jnskartu").find('.isi_data').html(data);
					}
				})

			}
			// Buat dapetin data waktu di klik list data yang dipilih ==========
			function post_jnskartu() {
				var table = document.getElementById("table_filter_find_jnskartu");
				var tbody = table.getElementsByTagName("tbody")[0];
				tbody.onclick = function(e) {
					e = e || window.event;
					var data = [];
					var target = e.srcElement || e.target;
					while (target && target.nodeName !== "TR") {
						target = target.parentNode;
					}
					if (target) {
						var cells = target.getElementsByTagName("td");
						for (var i = 0; i < cells.length; i++) {
							data.push('--separator--' + cells[i].innerHTML);
							dt = data.toString();
						}
					}
					dt_split = dt.split(",--separator--");
					$('#kdjnskartu').val(((dt_split[0]).replace("--separator--", "")).trim());
					$('#nmjnskartu').val(((dt_split[1]).replace("--separator--", "")).trim());
				};
			}
			/// Ini filter di list datanya yaaa ==========
			function cari_data_list_jnskartu(data) {
				console.log(data);
				$.ajax({
					method: "POST",
					data: {
						isifilter: data
					},
					url: "cari-data-jnskartu.php",
					success: function(data) {
						$("#searchdatamodal_jnskartu").modal('show');
						$("#searchdatamodal_jnskartu").find('.isi_data').html(data);
					}
				})
			}

			// Nampilin list data pilihan ===================
			function cari_data_barang() {
				$.ajax({
					method: "POST",
					url: "cari-data-barang.php",
					success: function(data) {
						$("#searchdatamodal_barang").modal('show');
						$("#searchdatamodal_barang").find('.isi_data').html(data);
					}
				})

			}
			// Buat dapetin data waktu di klik list data yang dipilih ==========
			function post_barang() {
				var table = document.getElementById("table_filter_find_barang");
				var tbody = table.getElementsByTagName("tbody")[0];
				tbody.onclick = function(e) {
					e = e || window.event;
					var data = [];
					var target = e.srcElement || e.target;
					while (target && target.nodeName !== "TR") {
						target = target.parentNode;
					}
					if (target) {
						var cells = target.getElementsByTagName("td");
						for (var i = 0; i < cells.length; i++) {
							data.push('--separator--' + cells[i].innerHTML);
							dt = data.toString();

						}
					}
					dt_split = dt.split(",--separator--");
					$('#kdbarang').val(((dt_split[0]).replace("--separator--", "")).trim());
					$('#nmbarang').val(((dt_split[1]).replace("--separator--", "")).trim());
					$('#harga').val(((dt_split[2]).replace("--separator--", "")).trim());
					$('#kdsatuan').val(((dt_split[3]).replace("--separator--", "")).trim());
					$('#lokasi').val(((dt_split[4]).replace("--separator--", "")).trim());
					$('#kdbarang').focus();
				};
			}
			/// Ini filter di list datanya yaaa ==========
			function cari_data_list_tbbarang(data) {
				console.log(data);
				$.ajax({
					method: "POST",
					data: {
						isifilter: data
					},
					url: "cari-data-barang.php",
					success: function(data) {
						$("#searchdatamodal_barang").modal('show');
						$("#searchdatamodal_barang").find('.isi_data').html(data);
					}
				})

			}

			// Nampilin list data pilihan ===================
			function cari_data_tbbarang() {
				$.ajax({
					method: "POST",
					url: "cari-data-tbbarang.php",
					success: function(data) {
						$("#searchdatamodal_tbbarang").modal('show');
						$("#searchdatamodal_tbbarang").find('.isi_data').html(data);
					}
				})

			}

			// Buat dapetin data waktu di klik list data yang dipilih ==========
			function post_tbbarang() {
				var table = document.getElementById("table_filter_find_tbbarang");
				var tbody = table.getElementsByTagName("tbody")[0];
				tbody.onclick = function(e) {
					e = e || window.event;
					var data = [];
					var target = e.srcElement || e.target;
					while (target && target.nodeName !== "TR") {
						target = target.parentNode;
					}
					if (target) {
						var cells = target.getElementsByTagName("td");
						for (var i = 0; i < cells.length; i++) {
							data.push('--separator--' + cells[i].innerHTML);
							dt = data.toString();

						}
					}
					dt_split = dt.split(",--separator--");
					$('#kdbarang').val(((dt_split[0]).replace("--separator--", "")).trim());
					$('#nmbarang').val(((dt_split[1]).replace("--separator--", "")).trim());
					$('#harga').val(((dt_split[2]).replace("--separator--", "")).trim());
					$('#kdsatuan').val(((dt_split[3]).replace("--separator--", "")).trim());
					$('#lokasi').val(((dt_split[4]).replace("--separator--", "")).trim());
					$('#kdbarang').focus();
				};
			}
			/// Ini filter di list datanya yaaa ==========
			function cari_data_list_tbbarang(data) {
				console.log(data);
				$.ajax({
					method: "POST",
					data: {
						isifilter: data
					},
					url: "cari-data-tbbarang.php",
					success: function(data) {
						$("#searchdatamodal_tbbarang").modal('show');
						$("#searchdatamodal_tbbarang").find('.isi_data').html(data);
					}
				})

			}
			// Nampilin list data pilihan ===================
			function cari_data_barang_beli() {
				$.ajax({
					method: "POST",
					url: "cari-data-barang-beli.php",
					success: function(data) {
						$("#searchdatamodal_barang_beli").modal('show');
						$("#searchdatamodal_barang_beli").find('.isi_data').html(data);
					}
				})

			}
			// Buat dapetin data waktu di klik list data yang dipilih ==========
			function post_barang_beli() {
				var table = document.getElementById("table_filter_find_barang_beli");
				var tbody = table.getElementsByTagName("tbody")[0];
				tbody.onclick = function(e) {
					e = e || window.event;
					var data = [];
					var target = e.srcElement || e.target;
					while (target && target.nodeName !== "TR") {
						target = target.parentNode;
					}
					if (target) {
						var cells = target.getElementsByTagName("td");
						for (var i = 0; i < cells.length; i++) {
							data.push('--separator--' + cells[i].innerHTML);
							dt = data.toString();

						}
					}
					dt_split = dt.split(",--separator--");
					$('#kdbarang').val(((dt_split[0]).replace("--separator--", "")).trim());
					$('#nmbarang').val(((dt_split[1]).replace("--separator--", "")).trim());
					$('#harga').val(((dt_split[2]).replace("--separator--", "")).trim());
					$('#kdsatuan').val(((dt_split[3]).replace("--separator--", "")).trim());
					$('#lokasi').val(((dt_split[4]).replace("--separator--", "")).trim());
				};
			}
			// Buat dapetin data waktu di klik list data yang dipilih ==========
			// Nampilin list data pilihan ===================
			function cari_data_opname() {
				$.ajax({
					method: "POST",
					url: "cari-data-opname.php",
					success: function(data) {
						$("#searchdatamodal_opname").modal('show');
						$("#searchdatamodal_opname").find('.isi_data').html(data);
					}
				})

			}

			function post_opname() {
				var table = document.getElementById("table_filter_find_opname");
				var tbody = table.getElementsByTagName("tbody")[0];
				tbody.onclick = function(e) {
					e = e || window.event;
					var data = [];
					var target = e.srcElement || e.target;
					while (target && target.nodeName !== "TR") {
						target = target.parentNode;
					}
					if (target) {
						var cells = target.getElementsByTagName("td");
						for (var i = 0; i < cells.length; i++) {
							data.push('--separator--' + cells[i].innerHTML);
							dt = data.toString();

						}
					}
					dt_split = dt.split(",--separator--");
					$('#noopname').val(((dt_split[0]).replace("--separator--", "")).trim());
					$('#tglopname').val(((dt_split[1]).replace("--separator--", "")).trim());
				};
			}
			/// Ini filter di list datanya yaaa ==========

			function cari_data_list_barang(data) {
				console.log(data);
				$.ajax({
					method: "POST",
					data: {
						isifilter: data
					},
					url: "cari-data-barang.php",
					success: function(data) {
						$("#searchdatamodal_barang").modal('show');
						$("#searchdatamodal_barang").find('.isi_data').html(data);
					}
				})
			}

			function cari_data_list_barang_beli(data) {
				console.log(data);
				$.ajax({
					method: "POST",
					data: {
						isifilter: data
					},
					url: "cari-data-barang-beli.php",
					success: function(data) {
						$("#searchdatamodal_barang_beli").modal('show');
						$("#searchdatamodal_barang_beli").find('.isi_data').html(data);
					}
				})
			}

			// Nampilin list data pilihan ===================
			function cari_data_customer() {
				$.ajax({
					method: "POST",
					url: "cari-data-customer.php",
					success: function(data) {
						$("#searchdatamodal_customer").modal('show');
						$("#searchdatamodal_customer").find('.isi_data').html(data);
					}
				})

			}
			// Buat dapetin data waktu di klik list data yang dipilih ==========
			function post_customer() {
				var table = document.getElementById("table_filter_find_customer");
				var tbody = table.getElementsByTagName("tbody")[0];
				tbody.onclick = function(e) {
					e = e || window.event;
					var data = [];
					var target = e.srcElement || e.target;
					while (target && target.nodeName !== "TR") {
						target = target.parentNode;
					}
					if (target) {
						var cells = target.getElementsByTagName("td");
						for (var i = 0; i < cells.length; i++) {
							data.push('--separator--' + cells[i].innerHTML);
							dt = data.toString();

						}
					}
					dt_split = dt.split(",--separator--");
					$('#kdcustomer').val(((dt_split[0]).replace("--separator--", "")).trim());
					$('#nmcustomer').val(((dt_split[1]).replace("--separator--", "")).trim());
					//$('#alamat').val(((dt_split[2]).replace("--separator--","")).trim());
				};
			}
			/// Ini filter di list datanya yaaa ==========
			function cari_data_list_customer(data) {
				console.log(data);
				$.ajax({
					method: "POST",
					data: {
						isifilter: data
					},
					url: "cari-data-customer.php",
					success: function(data) {
						$("#searchdatamodal_customer").modal('show');
						$("#searchdatamodal_customer").find('.isi_data').html(data);
					}
				})

			}


			// Nampilin list data pilihan ===================
			function cari_data_sales() {
				$.ajax({
					method: "POST",
					url: "cari-data-sales.php",
					success: function(data) {
						$("#searchdatamodal_sales").modal('show');
						$("#searchdatamodal_sales").find('.isi_data').html(data);
					}
				})

			}
			// Buat dapetin data waktu di klik list data yang dipilih ==========
			function post_sales() {
				var table = document.getElementById("table_filter_find_sales");
				var tbody = table.getElementsByTagName("tbody")[0];
				tbody.onclick = function(e) {
					e = e || window.event;
					var data = [];
					var target = e.srcElement || e.target;
					while (target && target.nodeName !== "TR") {
						target = target.parentNode;
					}
					if (target) {
						var cells = target.getElementsByTagName("td");
						for (var i = 0; i < cells.length; i++) {
							data.push('--separator--' + cells[i].innerHTML);
							dt = data.toString();

						}
					}
					dt_split = dt.split(",--separator--");
					$('#kdsales').val(((dt_split[0]).replace("--separator--", "")).trim());
					$('#nmsales').val(((dt_split[1]).replace("--separator--", "")).trim());
					//$('#alamat').val(((dt_split[2]).replace("--separator--","")).trim());
				};
			}
			/// Ini filter di list datanya yaaa ==========
			function cari_data_list_sales(data) {
				console.log(data);
				$.ajax({
					method: "POST",
					data: {
						isifilter: data
					},
					url: "cari-data-sales.php",
					success: function(data) {
						$("#searchdatamodal_sales").modal('show');
						$("#searchdatamodal_sales").find('.isi_data').html(data);
					}
				})

			}

			// Nampilin list data pilihan ===================
			function cari_data_penjualan() {
				$.ajax({
					method: "POST",
					url: "cari-data-penjualan.php",
					success: function(data) {
						$("#searchdatamodal_penjualan").modal('show');
						$("#searchdatamodal_penjualan").find('.isi_data').html(data);
					}
				})

			}
			// Buat dapetin data waktu di klik list data yang dipilih ==========
			function post_penjualan() {
				var table = document.getElementById("table_filter_find_penjualan");
				var tbody = table.getElementsByTagName("tbody")[0];
				tbody.onclick = function(e) {
					e = e || window.event;
					var data = [];
					var target = e.srcElement || e.target;
					while (target && target.nodeName !== "TR") {
						target = target.parentNode;
					}
					if (target) {
						var cells = target.getElementsByTagName("td");
						for (var i = 0; i < cells.length; i++) {
							data.push('--separator--' + cells[i].innerHTML);
							dt = data.toString();

						}
					}
					dt_split = dt.split(",--separator--");
					$('#nojual').val(((dt_split[0]).replace("--separator--", "")).trim());
					$('#tgljual').val(((dt_split[1]).replace("--separator--", "")).trim());
					$('#nmcustomer').val(((dt_split[2]).replace("--separator--", "")).trim());
					$('#total').val(((dt_split[3]).replace("--separator--", "")).trim());
					$('#piutang').val(((dt_split[4]).replace("--separator--", "")).trim());
					$('#kdcustomer').val(((dt_split[5]).replace("--separator--", "")).trim());
					$('#bayar').val(((dt_split[4]).replace("--separator--", "")).trim());
					$('#uang').val(((dt_split[4]).replace("--separator--", "")).trim());

					//$('#alamat').val(((dt_split[2]).replace("--separator--","")).trim());
				};
			}
			/// Ini filter di list datanya yaaa ==========
			function cari_data_list_penjualan(data) {
				console.log(data);
				$.ajax({
					method: "POST",
					data: {
						isifilter: data
					},
					url: "cari-data-penjualan.php",
					success: function(data) {
						$("#searchdatamodal_penjualan").modal('show');
						$("#searchdatamodal_penjualan").find('.isi_data').html(data);
					}
				})

			}

			// Nampilin list data pilihan ===================
			function cari_data_order_part() {
				$.ajax({
					method: "POST",
					url: "cari-data-order-part.php",
					success: function(data) {
						$("#searchdatamodal_order_part").modal('show');
						$("#searchdatamodal_order_part").find('.isi_data').html(data);
					}
				})

			}
			// Buat dapetin data waktu di klik list data yang dipilih ==========
			function post_order_part() {
				var table = document.getElementById("table_filter_find_order_part");
				var tbody = table.getElementsByTagName("tbody")[0];
				tbody.onclick = function(e) {
					e = e || window.event;
					var data = [];
					var target = e.srcElement || e.target;
					while (target && target.nodeName !== "TR") {
						target = target.parentNode;
					}
					if (target) {
						var cells = target.getElementsByTagName("td");
						for (var i = 0; i < cells.length; i++) {
							data.push('--separator--' + cells[i].innerHTML);
							dt = data.toString();

						}
					}
					dt_split = dt.split(",--separator--");
					$('#noorder').val(((dt_split[0]).replace("--separator--", "")).trim());
				};
			}

			/// Ini filter di list datanya yaaa ==========
			function cari_data_list1(data) {
				// var $rows = $('#isi_data tr');
				// $('#search').keyup(function() {
				// var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

				// $rows.show().filter(function() {
				// var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
				// return !~text.indexOf(val);
				// }).hide();
				// });
				console.log(data);
				$.ajax({
					method: "POST",
					data: {
						isifilter: data
					},
					url: "cari-data-nopolisi.php",
					success: function(data) {
						$("#searchdatamodal1").modal('show');
						$("#searchdatamodal1").find('.isi_data').html(data);
					}
				})

			}
		</script>

		<!--<script src="https://code.jquery.com/jquery-3.4.0.slim.min.js"
			integrity="sha256-ZaXnYkHGqIhqTbJ6MB4l9Frs/r7U4jlx7ir8PJYBqbI="
			crossorigin="anonymous"
		</script>-->


		<!--<script src="https://code.jquery.com/jquery-3.3.1.min.js"
			integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
			crossorigin="anonymous">
		</script>-->

		<script>
			function alert_ok() {
				swal("Good job!", "You clicked the button!", "success")
			};

			// $(document).ready(function () {
			//  $('#sidebarCollapse').on('click', function () {
			// 	 $('#sidebar').toggleClass('active');
			//  });
			// });
		</script>

		<!-- jQuery 2.0.2 -->
		<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>-->
		<script src="js/jquery.min.js" type="text/javascript"></script>
		<!-- Bootstrap -->
		<script src="js/bootstrap.min.js" type="text/javascript"></script>
		<!-- DATA TABES SCRIPT -->
		<!-- <script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script> -->
		<!-- <script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script> -->
		<script type="text/javascript" src="plugin/datatables/js/jquery.dataTables.js"></script>
		<!-- fullCalendar -->
		<script src="js/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
		<!-- AdminLTE App -->
		<script src="js/AdminLTE/app.js" type="text/javascript"></script>
		<!-- <script src="js/my.js" type="text/javascript"></script> -->

		<!-- page script -->
		<script type="text/javascript">
			$(function() {
				$("#example1").dataTable();
				$('#example2').dataTable({
					"bPaginate": true,
					"bLengthChange": false,
					"bFilter": false,
					"bSort": true,
					"bInfo": true,
					"bAutoWidth": false
				});
			});
		</script>

		<script>
			$('#checkall_barang').on('ifChanged', function(event) {
				if (this.checked) // if changed state is "CHECKED"
				{
					// alert(this.checked);
					$(document.getElementsByName('kdbarang')).show();
					$(document.getElementsByName('nmbarang')).show();
					$(document.getElementsByName('src')).show();
				} else {
					$(document.getElementsByName('kdbarang')).hide();
					$(document.getElementsByName('nmbarang')).hide();
					$(document.getElementsByName('src')).hide();
				}
			});
			$('#checkall_periode').on('ifChanged', function(event) {
				if (this.checked) // if changed state is "CHECKED"
				{
					// alert(this.checked);
					$(document.getElementsByName('tanggal1')).hide();
					$(document.getElementsByName('tanggal2')).hide();
				} else {
					$(document.getElementsByName('tanggal1')).show();
					$(document.getElementsByName('tanggal2')).show();
				}
			});
			$('#checkall_customer').on('ifChanged', function(event) {
				if (this.checked) // if changed state is "CHECKED"
				{
					// alert(this.checked);
					$(document.getElementsByName('kdcustomer')).hide();
					$(document.getElementsByName('nmcustomer')).hide();
					$(document.getElementsByName('btn_customer')).hide();
				} else {
					$(document.getElementsByName('kdcustomer')).show();
					$(document.getElementsByName('nmcustomer')).show();
					$(document.getElementsByName('btn_customer')).show();
				}
			});
			$('#checkall_sales').on('ifChanged', function(event) {
				if (this.checked) // if changed state is "CHECKED"
				{
					// alert(this.checked);
					$(document.getElementsByName('kdsales')).hide();
					$(document.getElementsByName('nmsales')).hide();
					$(document.getElementsByName('btn_sales')).hide();
				} else {
					$(document.getElementsByName('kdsales')).show();
					$(document.getElementsByName('nmsales')).show();
					$(document.getElementsByName('btn_sales')).show();
				}
			});
			$('#checkall_resetfile').on('ifChanged', function(event) {
				if (this.checked) // if changed state is "CHECKED"
				{
					//alert(this.checked);
					$(document.getElementsByName('tbbarang_r')).iCheck('check');
					$(document.getElementsByName('tbgudang_r')).iCheck('check');
					$(document.getElementsByName('tbjntrans_r')).iCheck('check');
					$(document.getElementsByName('tbjnbrg_r')).iCheck('check');
					$(document.getElementsByName('tbsatuan_r')).iCheck('check');
					$(document.getElementsByName('tbnegara_r')).iCheck('check');
					$(document.getElementsByName('tbmove_r')).iCheck('check');
					$(document.getElementsByName('tbdiscount_r')).iCheck('check');
					$(document.getElementsByName('tbcustomer_r')).iCheck('check');
					$(document.getElementsByName('tbsupplier_r')).iCheck('check');
					$(document.getElementsByName('tbmultiprc_r')).iCheck('check');
					$(document.getElementsByName('tbsales_r')).iCheck('check');
					$(document.getElementsByName('tbbank_r')).iCheck('check');
					$(document.getElementsByName('tbjnkeluar_r')).iCheck('check');
				} else {
					$(document.getElementsByName('tbbarang_r')).iCheck('uncheck');
					$(document.getElementsByName('tbgudang_r')).iCheck('uncheck');
					$(document.getElementsByName('tbjntrans_r')).iCheck('uncheck');
					$(document.getElementsByName('tbjnbrg_r')).iCheck('uncheck');
					$(document.getElementsByName('tbsatuan_r')).iCheck('uncheck');
					$(document.getElementsByName('tbnegara_r')).iCheck('uncheck');
					$(document.getElementsByName('tbmove_r')).iCheck('uncheck');
					$(document.getElementsByName('tbdiscount_r')).iCheck('uncheck');
					$(document.getElementsByName('tbcustomer_r')).iCheck('uncheck');
					$(document.getElementsByName('tbsupplier_r')).iCheck('uncheck');
					$(document.getElementsByName('tbmultiprc_r')).iCheck('uncheck');
					$(document.getElementsByName('tbsales_r')).iCheck('uncheck');
					$(document.getElementsByName('tbbank_r')).iCheck('uncheck');
					$(document.getElementsByName('tbjnkeluar_r')).iCheck('uncheck');
				}
			});
			$('#checkall_resettransaksi').on('ifChanged', function(event) {
				if (this.checked) // if changed state is "CHECKED"
				{
					//alert(this.checked);
					$(document.getElementsByName('so')).iCheck('check');
					$(document.getElementsByName('jual')).iCheck('check');
					$(document.getElementsByName('po')).iCheck('check');
					$(document.getElementsByName('beli')).iCheck('check');
					$(document.getElementsByName('terima')).iCheck('check');
					$(document.getElementsByName('keluar')).iCheck('check');
					$(document.getElementsByName('opname')).iCheck('check');
					$(document.getElementsByName('approv')).iCheck('check');
					$(document.getElementsByName('kasir_tunai')).iCheck('check');
					$(document.getElementsByName('kasir_tagihan')).iCheck('check');
					$(document.getElementsByName('moh_keluar')).iCheck('check');
					$(document.getElementsByName('keluar_uang')).iCheck('check');
				} else {
					$(document.getElementsByName('so')).iCheck('uncheck');
					$(document.getElementsByName('jual')).iCheck('uncheck');
					$(document.getElementsByName('po')).iCheck('uncheck');
					$(document.getElementsByName('beli')).iCheck('uncheck');
					$(document.getElementsByName('terima')).iCheck('uncheck');
					$(document.getElementsByName('keluar')).iCheck('uncheck');
					$(document.getElementsByName('opname')).iCheck('uncheck');
					$(document.getElementsByName('approv')).iCheck('uncheck');
					$(document.getElementsByName('kasir_tunai')).iCheck('uncheck');
					$(document.getElementsByName('kasir_tagihan')).iCheck('uncheck');
					$(document.getElementsByName('moh_keluar')).iCheck('uncheck');
					$(document.getElementsByName('keluar_uang')).iCheck('uncheck');
				}
			});

			$('#checkall_pakai').on('ifChanged', function(event) {
				if (this.checked) // if changed state is "CHECKED"
				{
					//alert(this.checked);
					$checkbox = 50;
					for (jumlah = 1; jumlah <= $checkbox; jumlah++) {
						$checkboxpakai = 'checkboxpakai' + jumlah;
						checkboxes = document.getElementsByName($checkboxpakai);
						//for(var i=0, n=checkboxes.length;i<n;i++) { checkboxes[i].checked = pilih.checked; } 
						//console.log(jumlah);
						$(checkboxes).iCheck('check');
					}
				} else {
					//alert(this.checked);
					$checkbox = 50;
					for (jumlah = 1; jumlah <= $checkbox; jumlah++) {
						$checkboxpakai = 'checkboxpakai' + jumlah;
						checkboxes = document.getElementsByName($checkboxpakai);
						//for(var i=0, n=checkboxes.length;i<n;i++) { checkboxes[i].checked = pilih.checked; } 
						//console.log(jumlah);
						$(checkboxes).iCheck('uncheck');
					}
				}
			});

			$('#checkall_tambah').on('ifChanged', function(event) {
				if (this.checked) // if changed state is "CHECKED"
				{
					//alert(this.checked);
					$checkbox = 50;
					for (jumlah = 1; jumlah <= $checkbox; jumlah++) {
						$checkboxtambah = 'checkboxtambah' + jumlah;
						checkboxes = document.getElementsByName($checkboxtambah);
						//for(var i=0, n=checkboxes.length;i<n;i++) { checkboxes[i].checked = pilih.checked; } 
						//console.log(jumlah);
						$(checkboxes).iCheck('check');
					}
				} else {
					//alert(this.checked);
					$checkbox = 50;
					for (jumlah = 1; jumlah <= $checkbox; jumlah++) {
						$checkboxtambah = 'checkboxtambah' + jumlah;
						checkboxes = document.getElementsByName($checkboxtambah);
						//for(var i=0, n=checkboxes.length;i<n;i++) { checkboxes[i].checked = pilih.checked; } 
						//console.log(jumlah);
						$(checkboxes).iCheck('uncheck');
					}
				}
			});

			$('#checkall_edit').on('ifChanged', function(event) {
				if (this.checked) // if changed state is "CHECKED"
				{
					//alert(this.checked);
					$checkbox = 50;
					for (jumlah = 1; jumlah <= $checkbox; jumlah++) {
						$checkboxedit = 'checkboxedit' + jumlah;
						checkboxes = document.getElementsByName($checkboxedit);
						//for(var i=0, n=checkboxes.length;i<n;i++) { checkboxes[i].checked = pilih.checked; } 
						//console.log(jumlah);
						$(checkboxes).iCheck('check');
					}
				} else {
					//alert(this.checked);
					$checkbox = 50;
					for (jumlah = 1; jumlah <= $checkbox; jumlah++) {
						$checkboxedit = 'checkboxedit' + jumlah;
						checkboxes = document.getElementsByName($checkboxedit);
						//for(var i=0, n=checkboxes.length;i<n;i++) { checkboxes[i].checked = pilih.checked; } 
						//console.log(jumlah);
						$(checkboxes).iCheck('uncheck');
					}
				}
			});

			$('#checkall_hapus').on('ifChanged', function(event) {
				if (this.checked) // if changed state is "CHECKED"
				{
					//alert(this.checked);
					$checkbox = 50;
					for (jumlah = 1; jumlah <= $checkbox; jumlah++) {
						$checkboxhapus = 'checkboxhapus' + jumlah;
						checkboxes = document.getElementsByName($checkboxhapus);
						//for(var i=0, n=checkboxes.length;i<n;i++) { checkboxes[i].checked = pilih.checked; } 
						//console.log(jumlah);
						$(checkboxes).iCheck('check');
					}
				} else {
					//alert(this.checked);
					$checkbox = 50;
					for (jumlah = 1; jumlah <= $checkbox; jumlah++) {
						$checkboxhapus = 'checkboxhapus' + jumlah;
						checkboxes = document.getElementsByName($checkboxhapus);
						//for(var i=0, n=checkboxes.length;i<n;i++) { checkboxes[i].checked = pilih.checked; } 
						//console.log(jumlah);
						$(checkboxes).iCheck('uncheck');
					}
				}
			});

			$('#checkall_proses').on('ifChanged', function(event) {
				if (this.checked) // if changed state is "CHECKED"
				{
					//alert(this.checked);
					$checkbox = 50;
					for (jumlah = 1; jumlah <= $checkbox; jumlah++) {
						$checkboxproses = 'checkboxproses' + jumlah;
						checkboxes = document.getElementsByName($checkboxproses);
						//for(var i=0, n=checkboxes.length;i<n;i++) { checkboxes[i].checked = pilih.checked; } 
						//console.log(jumlah);
						$(checkboxes).iCheck('check');
					}
				} else {
					//alert(this.checked);
					$checkbox = 50;
					for (jumlah = 1; jumlah <= $checkbox; jumlah++) {
						$checkboxproses = 'checkboxproses' + jumlah;
						checkboxes = document.getElementsByName($checkboxproses);
						//for(var i=0, n=checkboxes.length;i<n;i++) { checkboxes[i].checked = pilih.checked; } 
						//console.log(jumlah);
						$(checkboxes).iCheck('uncheck');
					}
				}
			});

			$('#checkall_unproses').on('ifChanged', function(event) {
				if (this.checked) // if changed state is "CHECKED"
				{
					//alert(this.checked);
					$checkbox = 50;
					for (jumlah = 1; jumlah <= $checkbox; jumlah++) {
						$checkboxunproses = 'checkboxunproses' + jumlah;
						checkboxes = document.getElementsByName($checkboxunproses);
						//for(var i=0, n=checkboxes.length;i<n;i++) { checkboxes[i].checked = pilih.checked; } 
						//console.log(jumlah);
						$(checkboxes).iCheck('check');
					}
				} else {
					//alert(this.checked);
					$checkbox = 50;
					for (jumlah = 1; jumlah <= $checkbox; jumlah++) {
						$checkboxunproses = 'checkboxunproses' + jumlah;
						checkboxes = document.getElementsByName($checkboxunproses);
						//for(var i=0, n=checkboxes.length;i<n;i++) { checkboxes[i].checked = pilih.checked; } 
						//console.log(jumlah);
						$(checkboxes).iCheck('uncheck');
					}
				}
			});

			$('#checkall_cetak').on('ifChanged', function(event) {
				if (this.checked) // if changed state is "CHECKED"
				{
					//alert(this.checked);
					$checkbox = 50;
					for (jumlah = 1; jumlah <= $checkbox; jumlah++) {
						$checkboxcetak = 'checkboxcetak' + jumlah;
						checkboxes = document.getElementsByName($checkboxcetak);
						//for(var i=0, n=checkboxes.length;i<n;i++) { checkboxes[i].checked = pilih.checked; } 
						//console.log(jumlah);
						$(checkboxes).iCheck('check');
					}
				} else {
					//alert(this.checked);
					$checkbox = 50;
					for (jumlah = 1; jumlah <= $checkbox; jumlah++) {
						$checkboxcetak = 'checkboxcetak' + jumlah;
						checkboxes = document.getElementsByName($checkboxcetak);
						//for(var i=0, n=checkboxes.length;i<n;i++) { checkboxes[i].checked = pilih.checked; } 
						//console.log(jumlah);
						$(checkboxes).iCheck('uncheck');
					}
				}
			});

			function searchTable() {
				var input;
				var saring;
				var status;
				var tbody;
				var tr;
				var td;
				var i;
				var j;
				input = document.getElementById("kata");
				saring = input.value.toUpperCase();
				tbody = document.getElementsByTagName("tbody")[0];;
				tr = tbody.getElementsByTagName("tr");
				for (i = 0; i < tr.length; i++) {
					td = tr[i].getElementsByTagName("td");
					for (j = 0; j < td.length; j++) {
						if (td[j].innerHTML.toUpperCase().indexOf(saring) > -1) {
							status = true;
						}
					}
					if (status) {
						tr[i].style.display = "";
						status = false;
					} else {
						tr[i].style.display = "none";
					}
				}
			}
		</script>

		<script>
			$(document).ready(function() {
				$('#kdmerek').change(function() {
					var id_merek = $('#kdmerek').val();
					if (id_merek != '') {
						//alert(id_model);
						$.ajax({
							type: 'post',
							url: 'get_model.php',
							data: {
								id: id_merek
							},
							cache: false,
							success: function(returndata) {
								$('#kdmodel').html(returndata);
							}
						});
					}
				})
			})
			$(document).ready(function() {
				$('#kdmodel').change(function() {
					var id_model = $('#kdmodel').val();
					if (id_model != '') {
						//alert(id_model);
						$.ajax({
							type: 'post',
							url: 'get_type.php',
							data: {
								id: id_model
							},
							cache: false,
							success: function(returndata) {
								$('#kdtype').html(returndata);
							}
						});
					}
				})
			})
			$(document).ready(function() {
				$('#kdmerek_e').change(function() {
					var id_merek = $('#kdmerek_e').val();
					if (id_merek != '') {
						//alert(id_model);
						$.ajax({
							type: 'post',
							url: 'get_model.php',
							data: {
								id: id_merek
							},
							cache: false,
							success: function(returndata) {
								$('#kdmodel_e').html(returndata);
							}
						});
					}
				})
			})
			$(document).ready(function() {
				$('#kdmodel_e').change(function() {
					var id_model = $('#kdmodel_e').val();
					if (id_model != '') {
						//alert(id_model);
						$.ajax({
							type: 'post',
							url: 'get_type.php',
							data: {
								id: id_model
							},
							cache: false,
							success: function(returndata) {
								$('#kdtype_e').html(returndata);
							}
						});
					}
				})
			})

			// Nampilin list data pilihan ===================
			function cari_data_satuan() {
				$.ajax({
					method: "POST",
					url: "cari-data-satuan.php",
					success: function(data) {
						$("#searchdatamodal").modal('show');
						$("#searchdatamodal").find('.isi_data').html(data);
					}
				})

			}
			// Buat dapetin data waktu di klik list data yang dipilih ==========
			function post_data_satuan() {
				var table = document.getElementById("table_filter_find");
				var tbody = table.getElementsByTagName("tbody")[0];
				tbody.onclick = function(e) {
					e = e || window.event;
					var data = [];
					var target = e.srcElement || e.target;
					while (target && target.nodeName !== "TR") {
						target = target.parentNode;
					}
					if (target) {
						var cells = target.getElementsByTagName("td");
						for (var i = 0; i < cells.length; i++) {
							data.push('--separator--' + cells[i].innerHTML);
							dt = data.toString();

						}
					}
					dt_split = dt.split(",--separator--");
					$('#kdsatuan').val(((dt_split[0]).replace("--separator--", "")).trim());
					$('#nmsatuan').val(((dt_split[1]).replace("--separator--", "")).trim());
				};
			}
		</script>

		<script language='javascript'>
			function validAngka(a) {
				if (!/^[0-9.]+$/.test(a.value)) {
					a.value = a.value.substring(0, a.value.length - 1000);
				}
			}

			function validAngka_no_titik(a) {
				if (!/^[0-9]+$/.test(a.value)) {
					a.value = a.value.substring(0, a.value.length - 1000);
				}
			}
		</script>

		<script>
			// Loading Page
			var myVar;

			function myFunction() {
				myVar = setTimeout(showPage, 500);
			}

			function showPage() {
				document.getElementById("loader").style.display = "none";
				// document.getElementById("myDiv").style.display = "block";
			}
		</script>

		<script type="text/javascript">
			//https://jagowebdev.com/format-rupiah-dengan-javascript/
			/* Tanpa Rupiah */
			// var gaji1 = document.getElementById('gaji1');
			// gaji1.addEventListener('keyup', function(e) {
			// 	gaji1.value = formatRupiah(this.value)});
			// var gaji2 = document.getElementById('gaji2');
			// gaji2.addEventListener('keyup', function(e)	{
			// 	gaji2.value = formatRupiah(this.value)});	

			/* Dengan Rupiah */
			// var gaji1 = document.getElementById('gaji1');
			// gaji1.addEventListener('keyup', function(e)
			// {
			// 	gaji1.value = formatRupiah(this.value, 'Rp. ');
			// });

			/* Fungsi */
			function formatRupiah(angka, prefix) {
				var number_string = angka.replace(/[^,\d]/g, '').toString(),
					split = number_string.split(','),
					sisa = split[0].length % 3,
					rupiah = split[0].substr(0, sisa),
					ribuan = split[0].substr(sisa).match(/\d{3}/gi);
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
				return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
			}
		</script>

		<script type="text/javascript">
			$(document).ready(function() {
				var table = $('#tbcustomer').DataTable({
					"processing": true,
					"serverSide": true,
					"ajax": "datatbcustomer.php",
					"columnDefs": [{
						"targets": -1,
						"data": null,
						//"defaultContent": "<button class='btn btn-success btn-xs tblEdit'>Edit / Delete</button>"
						//defaultContent: '<div class="btn-group"> <button type="button" class="btn btn-info btn-xs dt-view" style="margin-right:10px;"><span class="glyphicon glyphicon-eye-open glyphicon-info-sign" aria-hidden="true"></span></button><button type="button" class="btn btn-primary btn-xs tblEdit" style="margin-right:10px;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button><button type="button" class="btn btn-danger btn-xs dt-delete" style="margin-right:10px;"><span class="glyphicon glyphicon-remove glyphicon-trash" aria-hidden="true"></span><button type="button" class="btn btn-info btn-xs tblDidik" style="margin-right:10px;">R.Didik</span></button><button type="button" class="btn btn-success btn-xs tblKerja"  style="margin-right:10px;">R.Kerja</span></button></button><button type="button" class="btn btn-danger btn-xs tblSanksi">R.Sanksi</span></button></div>'
						defaultContent: '<div class="btn-group"><button type="button" class="btn btn-info btn-xs dt-view" style="margin-right:10px;"><span class="glyphicon glyphicon-eye-open glyphicon-info-sign" aria-hidden="true"></span></button><button type="button" class="btn btn-primary btn-xs tblEdit" style="margin-right:10px;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button><button type="button" class="btn btn-danger btn-xs dt-delete" style="margin-right:10px;"><span class="glyphicon glyphicon-remove glyphicon-trash" aria-hidden="true"></span></button></div>'
					}]
				});
				$('#tbcustomer tbody').on('click', '.dt-view', function() {
					var data = table.row($(this).parents('tr')).data();
					window.location.href = "?m=tbcustomer&tipe=edit&id=" + data[4];
					// var data = table.row( $(this).parents('tr') ).data();
					// //window.location.href = "?m=tbeselon&tipe=detail&id="+ data[2];
					// var id = data[4];

					// $('#modaldetail').modal('show');
					// //$('#modaldetail').find('.modal-body').html(id);
					// $.ajax({
					// 	//url: './module/ter_kementan/lihat_detail.php',
					// 	url: './module/tbcustomer/lihat_detail.php',
					// 	type: 'post',
					// 	data: {id:id},
					// 	success: function(response){
					// 		console.log(data);
					// 		$('#modaldetail').find('.modal-body').html(response);
					// 	}
					// });
				});
				$('#tbcustomer tbody').on('click', '.tblEdit', function() {
					var data = table.row($(this).parents('tr')).data();
					window.location.href = "?m=tbcustomer&tipe=edit&id=" + data[4];
				});

				$('#tbcustomer tbody').on('click', '.dt-delete', function() {
					//var data = table.row( $(this).parents('tr') ).data();
					//var id = $(this).attr("id");
					var data = table.row($(this).parents('tr')).data();
					var id = data[4];
					swal({
							title: "Yakin akan dihapus ?",
							text: "Once deleted, you will not be able to recover this data!",
							icon: "warning",
							buttons: true,
							dangerMode: true,
						})
						.then((willDelete) => {
							if (willDelete) {
								//alert($kode);
								$href = "module/tbcustomer/proses_hapus.php?id=";
								window.location.href = $href + id;
								// swal("Poof! Your imaginary file has been deleted!", {
								//   icon: "success",
								// });
							} else {
								//swal("Batal Hapus!");
							}
						});

					// if(confirm("Yakin akan dihapus ?"))
					// {
					// 	$.ajax({
					// 			url: './module/tbcustomer/proses_hapus.php',
					// 			methode:"GET",
					// 			data:{id:id},
					// 			success:function(data){
					// 				alert(data);
					// 				//console.log(data);
					// 				//$('#alertmessage').html('<div class="alert alert-success">'+data+'</div>');
					// 				$('#tbcustomer').DataTable().destroy();
					// 				window.location.href='./dashboard.php?m=tbcustomer';
					// 			}
					// 	});
					// }else{
					// 	return false;
					// }
				});
			});

			$(document).ready(function() {
				var table = $('#tbmultiprice').DataTable({
					"processing": true,
					"serverSide": true,
					"ajax": "datatbmultiprice.php",
					"columnDefs": [{
						"targets": -1,
						"data": null,
						//"defaultContent": "<button class='btn btn-success btn-xs tblEdit'>Edit / Delete</button>"
						//defaultContent: '<div class="btn-group"> <button type="button" class="btn btn-info btn-xs dt-view" style="margin-right:10px;"><span class="glyphicon glyphicon-eye-open glyphicon-info-sign" aria-hidden="true"></span></button><button type="button" class="btn btn-primary btn-xs tblEdit" style="margin-right:10px;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button><button type="button" class="btn btn-danger btn-xs dt-delete" style="margin-right:10px;"><span class="glyphicon glyphicon-remove glyphicon-trash" aria-hidden="true"></span><button type="button" class="btn btn-info btn-xs tblDidik" style="margin-right:10px;">R.Didik</span></button><button type="button" class="btn btn-success btn-xs tblKerja"  style="margin-right:10px;">R.Kerja</span></button></button><button type="button" class="btn btn-danger btn-xs tblSanksi">R.Sanksi</span></button></div>'
						defaultContent: '<div class="btn-group"><button type="button" class="btn btn-info btn-xs dt-view" style="margin-right:10px;"><span class="glyphicon glyphicon-eye-open glyphicon-info-sign" aria-hidden="true"></span></button><button type="button" class="btn btn-primary btn-xs tblEdit" style="margin-right:10px;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></div>'
					}]
				});
				$('#tbmultiprice tbody').on('click', '.dt-view', function() {
					var data = table.row($(this).parents('tr')).data();
					window.location.href = "?m=tbmultiprc&tipe=detail&id=" + data[4];

				});
				$('#tbmultiprice tbody').on('click', '.tblEdit', function() {
					var data = table.row($(this).parents('tr')).data();
					window.location.href = "?m=tbmultiprc&tipe=detail_data&kdcustomer=" + data[0];
				});
			});

			$(document).ready(function() {
				var table = $('#tbbarang').DataTable({
					"processing": true,
					"serverSide": true,
					"ajax": "datatbbarang.php",
					"columnDefs": [{
						"targets": -1,
						"data": null,
						//"defaultContent": "<button class='btn btn-success btn-xs tblEdit'>Edit / Delete</button>"
						//defaultContent: '<div class="btn-group"> <button type="button" class="btn btn-info btn-xs dt-view" style="margin-right:10px;"><span class="glyphicon glyphicon-eye-open glyphicon-info-sign" aria-hidden="true"></span></button><button type="button" class="btn btn-primary btn-xs tblEdit" style="margin-right:10px;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button><button type="button" class="btn btn-danger btn-xs dt-delete" style="margin-right:10px;"><span class="glyphicon glyphicon-remove glyphicon-trash" aria-hidden="true"></span><button type="button" class="btn btn-info btn-xs tblDidik" style="margin-right:10px;">R.Didik</span></button><button type="button" class="btn btn-success btn-xs tblKerja"  style="margin-right:10px;">R.Kerja</span></button></button><button type="button" class="btn btn-danger btn-xs tblSanksi">R.Sanksi</span></button></div>'
						defaultContent: '<div class="btn-group"><button type="button" class="btn btn-info btn-xs dt-view" style="margin-right:10px;"><span class="glyphicon glyphicon-eye-open glyphicon-info-sign" aria-hidden="true"></span></button><button type="button" class="btn btn-primary btn-xs tblEdit" style="margin-right:10px;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button><button type="button" class="btn btn-danger btn-xs dt-delete" style="margin-right:10px;"><span class="glyphicon glyphicon-remove glyphicon-trash" aria-hidden="true"></span></button></div>'
					}]
				});
				$('#tbbarang tbody').on('click', '.dt-view', function() {
					var data = table.row($(this).parents('tr')).data();
					//window.location.href = "?m=tbeselon&tipe=detail&id="+ data[2];
					var id = data[5];

					$('#modaldetail').modal('show');
					//$('#modaldetail').find('.modal-body').html(id);
					$.ajax({
						//url: './module/ter_kementan/lihat_detail.php',
						url: 'lihat_detail_tbbarang.php',
						type: 'post',
						data: {
							kode: id
						},
						success: function(response) {
							console.log(data);
							$('#modaldetail').find('.modal-body').html(response);
						}
					});
				});
				$('#tbbarang tbody').on('click', '.tblEdit', function() {
					var data = table.row($(this).parents('tr')).data();
					window.location.href = "?m=tbbarang&tipe=edit&id=" + data[5];
				});

				$('#tbbarang tbody').on('click', '.dt-delete', function() {
					//var data = table.row( $(this).parents('tr') ).data();
					//var id = $(this).attr("id");
					var data = table.row($(this).parents('tr')).data();
					var id = data[5];
					swal({
							title: "Yakin akan dihapus ?",
							text: "Once deleted, you will not be able to recover this data!",
							icon: "warning",
							buttons: true,
							dangerMode: true,
						})
						.then((willDelete) => {
							if (willDelete) {
								//alert($kode);
								$href = "module/tbbarang/proses_hapus.php?id=";
								window.location.href = $href + id;
								// swal("Poof! Your imaginary file has been deleted!", {
								//   icon: "success",
								// });
							} else {
								//swal("Batal Hapus!");
							}
						});
				});
			});

			$(document).ready(function() {
				var table = $('#tbbank').DataTable({
					"processing": true,
					"serverSide": true,
					"ajax": "datatbbank.php",
					"columnDefs": [{
						"targets": -1,
						"data": null,
						// "defaultContent": "<button class='btn btn-success btn-xs tblEdit'>Edit / Delete</button>"
						//defaultContent: '<div class="btn-group"> <button type="button" class="btn btn-info btn-xs dt-view" style="margin-right:10px;"><span class="glyphicon glyphicon-eye-open glyphicon-info-sign" aria-hidden="true"></span></button><button type="button" class="btn btn-primary btn-xs tblEdit" style="margin-right:10px;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button><button type="button" class="btn btn-danger btn-xs dt-delete" style="margin-right:10px;"><span class="glyphicon glyphicon-remove glyphicon-trash" aria-hidden="true"></span><button type="button" class="btn btn-info btn-xs tblDidik" style="margin-right:10px;">R.Didik</span></button><button type="button" class="btn btn-success btn-xs tblKerja"  style="margin-right:10px;">R.Kerja</span></button></button><button type="button" class="btn btn-danger btn-xs tblSanksi">R.Sanksi</span></button></div>'
						defaultContent: '<div class="btn-group"><button type="button" class="btn btn-info btn-xs dt-view" style="margin-right:10px;"><span class="glyphicon glyphicon-eye-open glyphicon-info-sign" aria-hidden="true"></span></button><button type="button" class="btn btn-primary btn-xs tblEdit" style="margin-right:10px;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button><button type="button" class="btn btn-danger btn-xs dt-delete" style="margin-right:10px;"><span class="glyphicon glyphicon-remove glyphicon-trash" aria-hidden="true"></span></button></div>'
					}]
				});
				$('#tbbank tbody').on('click', '.dt-view', function() {
					var data = table.row($(this).parents('tr')).data();
					//window.location.href = "?m=tbeselon&tipe=detail&id="+ data[2];
					var id = data[3];

					$('#modaldetail').modal('show');
					//$('#modaldetail').find('.modal-body').html(id);
					$.ajax({
						//url: './module/ter_kementan/lihat_detail.php',
						url: 'lihat_detail_tbbank.php',
						type: 'post',
						data: {
							kode: id
						},
						success: function(response) {
							console.log(data);
							$('#modaldetail').find('.modal-body').html(response);
						}
					});
				});
				$('#tbbank tbody').on('click', '.tblEdit', function() {
					var data = table.row($(this).parents('tr')).data();
					window.location.href = "?m=tbbank&tipe=edit&id=" + data[3];
				});

				$('#tbbank tbody').on('click', '.dt-delete', function() {
					//var data = table.row( $(this).parents('tr') ).data();
					//var id = $(this).attr("id");
					var data = table.row($(this).parents('tr')).data();
					var id = data[3];
					swal({
							title: "Yakin akan dihapus ?",
							text: "Once deleted, you will not be able to recover this data!",
							icon: "warning",
							buttons: true,
							dangerMode: true,
						})
						.then((willDelete) => {
							if (willDelete) {
								//alert($kode);
								$href = "module/tbbank/proses_hapus.php?id=";
								window.location.href = $href + id;
								// swal("Poof! Your imaginary file has been deleted!", {
								//   icon: "success",
								// });
							} else {
								//swal("Batal Hapus!");
							}
						});
				});
			});
		</script>

		<script>
			function previewImg() {
				const sampul = document.querySelector('#sampul');
				const sampulLabel = document.querySelector('.custom-file-label');
				const imgPreview = document.querySelector('.img-preview');
				sampulLabel.textContent = sampul.files[0].name;
				const fileSampul = new FileReader();
				fileSampul.readAsDataURL(sampul.files[0]);
				fileSampul.onload = function(e) {
					imgPreview.src = e.target.result;
				}
			}
		</script>

		<!-- <script>
			$(document).ready(function() {
				$('#table_filter_find_barang').DataTable({
					// destroy: true,
					"aLengthMenu": [
						[5, 50, 100, -1],
						[5, 50, 100, "All"]
					],
					"iDisplayLength": 5
				})
			})
		</script> -->

		<!-- Modal -->
		<div class="modal fade" id="modaldetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
			<!-- <div class="modal-dialog" role="document"> -->
			<div class="modal-dialog modal-lg" style="width:80%">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel1">Detail Data Tabel</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="row">
						<div class="modal-body">
						</div>
					</div>
					<div class="modal-footer">
						<!-- <div class="col-md-12"> -->
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						<!-- </div> -->
					</div>
				</div>
			</div>
		</div>

	</body>

</html>