<?php
/*session_start();**/
function timer()
{
	$time = 900; /*900=15 menit**/
	$_SESSION['timeout'] = time() + $time;
	$_SESSION['expired'] = '';
}
function cek_login()
{
	$timeout = $_SESSION['timeout'];
	if (time() < $timeout) {
		timer();
		$_SESSION['expired'] = '';
		return true;
	} else {
		unset($_SESSION['timeout']);
		$_SESSION['expired'] = 'TRUE';
		return false;
	}
}
function cekform()
{
	if (isset($_GET['m'])) {
		$_SESSION['form'] = $_GET['m'];
	} else {
		$_SESSION['form'] = '';
	}
}
include("online.php");
