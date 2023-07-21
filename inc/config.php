<?php
// $server = "localhost";
// $username = "reabasti_reabasti_pos";
// $password   = "@reabasti_pos";
// $database = "reabasti_pos";

$server = "localhost";
$username = "root";
$password   = "";
$database = "pos";

//$username = "host94_murod";
//$password = "fLCI6sc8S?Vm"; //SF5ArhvQ3wLK7m5D
//$database = "host94_autoland";


// Koneksi dan memilih database di server
/*mysql_connect($server,$username,$password) or die("Koneksi gagal");
mysql_select_db($database) or die("Database tidak bisa dibuka");**/

// melakukan koneksi ke database
$connect = new mysqli($server, $username, $password, $database);

// cek koneksi yang kita lakukan berhasil atau tidak
if ($connect->connect_error) {
   // jika terjadi error, matikan proses dengan die() atau exit();
   die('Maaf koneksi gagal: ' . $connect->connect_error);
}
