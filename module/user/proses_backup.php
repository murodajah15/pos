<?php
include "../../inc/config.php";
date_default_timezone_set('Asia/Jakarta');
/*Backup Database**/
/*$backup_folder = "D:/";
	exec("d:/xampp/mysql/bin/mysqldump -h $server -u $username -p$password $database  > $backup_folder/my-sql-backup.sql", $results, $result_value);
	if ($result_value == 0){
		echo "Backup MySql berhasil dibuat";
	} else {
		echo "Gagal membackup MySql";
	}**/

/*Backup pertabel**/
/*$table_name = "mst_rekening";
	$backup_file  = "d:/temp/mst_rekening.sql";
	$sql = "SELECT * INTO OUTFILE '$backup_file' FROM $table_name";
	 
	$backup = mysqli_query($connect,$sql);
	if(! $backup )
	{
	  die('Gagal Backup: ' . mysqli_error($connect));
	}
	echo "Backup Berhasil\n";**/
/*echo "<script>alert('Restore data berhasil !');history.go(-3) </script>";**/

/*$backup_file  = "d:/temp/tunjangan.sql";
	$backup_file = $database . date("Y-m-d-H-i-s") . '.gz';
	$command = "d:\xampp\mysql\bin\mysqldump -h $server -u $username -p $password "."tunjangan | gzip > $backup_file";
	$backup=system($command);
	if(! $backup )
	{
	  die('Gagal Backup: ' . mysqli_error($connect));
	}
	echo "<script>alert('Backup data berhasil !');history.go(-3) </script>";**/
include "../../inc/config.php";
$query = mysqli_query($connect, "select * from saplikasi where aktif='Y'");
$d = mysqli_fetch_assoc($query);
$path = $d['dirbackup'];
if ($path <> "") {
	if (is_dir($path)) {
	} else {
		// To create the nested structure, the $recursive parameter 
		// to mkdir() must be specified.
		if (!mkdir($path, 0777, true)) {
			die('Failed to create folders...');
			echo "<script>alert('Direktori '.$path.' tidak ditemukan !');history.go(-1) </script>";
			exit();
		}
	}
}

/* backup the db OR just a table */
//echo $database;
backup_tables($server, $username, $password, $database);
$today = date('d-m-Y H-i-s');

function backup_tables($host, $user, $pass, $name, $tables = '*')
{
	$return = '';
	include "../../inc/config.php";
	$query = mysqli_query($connect, "select * from saplikasi where aktif='Y'");
	$d = mysqli_fetch_assoc($query);
	$path = $d['dirbackup'];
	$path = "";
	if ($path <> "") {
		if (file_exists($path)) {
			// echo "The directory backup " . $path . '<br>';
		} else {
			mkdir($path, 0755);
			echo "<script>alert('Direktori '.$path.' tidak ditemukan !');history.go(-1) </script>";
			echo "<p align='center'>The directory $path was successfully created.</p>";
		}
	}

	mysqli_select_db($connect, $name);

	//get all of the tables
	if ($tables == '*') {
		$tables = array();
		$result = mysqli_query($connect, 'SHOW TABLES');
		while ($row = mysqli_fetch_row($result)) {
			$tables[] = $row[0];
		}
	} else {
		$tables = is_array($tables) ? $tables : explode(',', $tables);
	}

	//cycle through
	foreach ($tables as $table) {
		$result = mysqli_query($connect, 'SELECT * FROM ' . $table);
		$num_fields = mysqli_num_fields($result);
		$return .= 'DROP TABLE ' . $table . ';';
		$row2 = mysqli_fetch_row(mysqli_query($connect, 'SHOW CREATE TABLE ' . $table));
		$return .= "\n\n" . $row2[1] . ";\n\n";

		for ($i = 0; $i < $num_fields; $i++) {
			while ($row = mysqli_fetch_row($result)) {
				$return .= 'INSERT INTO ' . $table . ' VALUES(';
				for ($j = 0; $j < $num_fields; $j++) {
					$row[$j] = addslashes($row[$j]);
					$row[$j] = preg_replace("/\n/i", "\\n", $row[$j]);
					if (isset($row[$j])) {
						$return .= '"' . $row[$j] . '"';
					} else {
						$return .= '""';
					}
					if ($j < ($num_fields - 1)) {
						$return .= ',';
					}
				}
				$return .= ");\n";
			}
		}
		$return .= "\n\n\n";
	}

	//save file
	/*$handle = fopen('d:\temp\db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql','w+');**/
	$today = date('d-m-Y H-i-s');
	$handle = fopen($path . $database . '-' . $today . '.sql', 'w+');
	fwrite($handle, $return);
	fclose($handle);
	$file = $path . $database . '-' . $today . '.sql';
?>
	<!-- <p align="center">Data berhasil di backup <?php echo $path . $database . '-' . $today . '.sql' ?></p>
	<p align="center" style="color: blue"><a style="cursor:pointer" onclick="location.href='download_backup.php?nama_file=<?php echo $file ?>'" title="Download">Download</a></p> -->

	<script>
		alert('Data berhasil di Backup');
		// alert('Data berhasil di Backup ' + $path.$database + '-' + $today + ".sql");
		//history.go(-1)
	</script>

	<?php
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename=' . basename($file));
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: private');
	header('Pragma: private');
	header('Content-Length: ' . filesize($file));
	ob_clean();
	flush();
	readfile($file);
	unlink($file);
	exit;
	?>


<?php
}
?>