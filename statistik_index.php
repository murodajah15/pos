<?php
	include "./inc/config.php";
	$browser = $_SERVER['HTTP_USER_AGENT'];
	$os = $_SERVER['HTTP_USER_AGENT'];
	$ip      = $_SERVER['REMOTE_ADDR']; // Mendapatkan IP komputer user
	/*$ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);**/
	$tanggal = date("Ymd");
	$waktu = time();
	$bln=date("m");
	$tgl=date("d");
	$blan=date("Y-m");
	$thn=date("Y");
	$tglk=$tgl-1;

	// Check bila sebelumnya data pengunjung sudah terrekam
	if (!isset($_COOKIE['VISITOR'])) {
 
		// Masa akan direkam kembali
		// Tujuan untuk menghindari merekam pengunjung yang sama dihari yang sama.
		// Cookie akan disimpan selama 24 jam
		$duration = time()+60*60*24;
	 
		// simpan kedalam cookie browser
		setcookie('VISITOR',$browser,$duration);
	 
		// SQL Command atau perintah SQL INSERT
		/*mysqli_query($connect,"INSERT INTO statistik (ip, browser,os,tanggal,hist,online) VALUES ('$ip','$browser','$os','$tanggal','1','$waktu')");
	 
		// variabel { $db } adalah perwakilan dari koneksi database lihat config.php
		/*$query = $db->query($sql);**/

		// Mencek berdasarkan IPnya, apakah user sudah pernah mengakses hari ini
		$s = mysqli_query($connect,"SELECT * FROM statistik WHERE ip='$ip' AND tanggal='$tanggal'");
		// Kalau belum ada, simpan data user tersebut ke database
		if(mysqli_num_rows($s) == 0){
			mysqli_query($connect,"INSERT INTO statistik(ip, browser, os, tanggal, hits, online) VALUES('$ip','$browser','$os','$tanggal','1','$waktu')");
		}
		// Jika sudah ada, update
		else{
			mysqli_query($connect,"UPDATE statistik SET hits=hits+1,online='$waktu',os='$os',browser='$browser' WHERE ip='$ip' AND tanggal='$tanggal'");
		}
	}else{
		$s = mysqli_query($connect,"SELECT * FROM statistik WHERE ip='$ip' AND tanggal='$tanggal'");
		// Kalau belum ada, simpan data user tersebut ke database
		if(mysqli_num_rows($s) == 0){
    		mysqli_query($connect,"INSERT INTO statistik(ip, browser, os, tanggal, hits, online) VALUES('$ip','$browser','$os','$tanggal','1','$waktu')");
		}else{
			mysqli_query($connect,"UPDATE statistik SET hits=hits+1,online='$waktu',os='$os',browser='$browser' WHERE ip='$ip' AND tanggal='$tanggal'");
		}
	}
	//mysqli_query($connect,"UPDATE statistik SET hits=hits+1,online='$waktu',os='$os',browser='$browser' WHERE ip='$ip' AND tanggal='$tanggal'");
?> 
