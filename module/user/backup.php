<?php
include 'cek_akses.php';
?>

<?php
if ($aksesok == 'Y') {
?>

	<font face="calibri">
		<style>
			h1 {
				text-align: center;
			}

			p.date {
				text-align: right;
			}

			p.main {
				text-align: justify;
			}
		</style>
		</head>

		<body>

			<h1>Backup Database</h1>

			<?php

			$query = mysqli_query($connect, "select * from saplikasi where aktif='Y'");
			$d = mysqli_fetch_assoc($query);
			$path = $d['dirbackup'];
			?>
			<h3>
				<!-- <p align='center'><b>Note :</b> Folder/Directory Backup sementera : <?php echo $path; ?></p> -->
			</h3>
			<br>
			<p align='center'><a target="_blank" class='btn btn-primary' href='module/user/proses_backup.php' onClick="return confirm('Anda yakin akan proses backup database ?')">
					<span class='glyphicon glyphicon-record'></span></button> Proses Backup</a></p><br><br>

		<?php
		// echo "Folder/Directory Backup : " . $path;
	} else {
		echo "<font color='red'>Anda tidak punya hak !</font>";
	} ?>
		<?php
/*<td><a href='tampil_gambar.php?wahyu.jpg' target='blank'>$k[picture]</a></td>
/*<td><img src='.images/promo/".$k['picture']."' width='100' height='100'></td>**/
