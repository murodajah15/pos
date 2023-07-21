<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "../../inc/config.php";
		//proses hapus
		session_start();
		date_default_timezone_set('Asia/Jakarta');
		$user = $_SESSION['username'];
		$user_proses = "Batal Proses-".$user."-".date('d-m-Y H:i:s');
		$tglselesai = date('');
		$proses = 'N';

		$tampil = mysqli_query($connect,"select * from mohklruangh where id='$_GET[id]'");
		$de = mysqli_fetch_assoc($tampil);
		$nomohon = $de['nomohon'];
		$bayar = $de['bayar'];
		if ($de['proses']=='N' or $bayar>0) {
			$text = "Dokumen ".$nomohon." Sudah di batal proses atau sudah ada pengeluaran uang !";
			?>
			<script>
				swal({title: "Gagal batal proses data", text: "<?= $text ?>" , icon: 
				"error"}).then(function(){window.location.href='../../dashboard.php?m=permohonan_keluar_uang';
				   }
				);
			</script>
			<?php
			$lanjut = 0;
			exit();
		}

		$query = $connect->prepare("update mohklruangh set proses=?,kurang=?,user_proses=? where id=?");
		$query->bind_param('sssi',$proses,$bayar,$user_proses,$_GET['id']);
		if($query->execute() and mysqli_affected_rows($connect)>0){
		?>
			<script>
				swal({title: "Data berhasil di Batal Proses", text: "", icon: 
				"success"}).then(function(){window.location.href='../../dashboard.php?m=permohonan_keluar_uang';
				   }
				);
			</script>
			<?php
		}else{
			// echo "<script>alert('Gagal hapus data !');
			// window.location.href='../../dashboard.php?m=tbbank';
			// </script>";				
			?>
			<script>
				swal({title: "Gagal Batal Proses data", text: "", icon: 
				"error"}).then(function(){window.location.href='../../dashboard.php?m=permohonan_keluar_uang';
				   }
				);
			</script>
			<?php
		}		
	?>
</body>