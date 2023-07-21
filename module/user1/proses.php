<?php
// membaca file koneksi.php
include "../../inc/config.php";

// membaca tabel-tabel yang dipilih dari form
$tabel = $_POST['tabel'];

// proses untuk menggabung nama-nama tabel yang dipilih
// sehingga menjadi sebuah string berbentuk 'tabel1 tabel2 tabel3 ...'

$listTabel = "";
foreach($tabel as $namatabel)
{
  $listTabel .= $namatabel." ";
}

// membentuk string command menjalankan mysqldump
// diasumsikan file mysqldump terletak di dalam folder C:\AppServ\MySQL\bin

$command = "D:\mysqldump -u ".$username."-p ".$password." ".$database." ".$listTabel." > ".$database.".sql";
echo $command;
// perintah untuk menjalankan perintah mysqldump dalam shell melalui PHP
exec($command);

// bagian perintah untuk proses download file hasil backup.

header("Content-Disposition: attachment; filename=".$database.".sql");
header("Content-type: application/download");
/*$fp  = fopen($database.".sql", 'r');
$content = fread($fp, filesize($database.".sql"));
fclose($fp);

echo $content;**/

exit;
?>