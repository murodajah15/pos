<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "../../inc/config.php";
		//proses hapus
		session_start();
		date_default_timezone_set('Asia/Jakarta');
		$de = mysqli_fetch_assoc(mysqli_query($connect,"select * from soh where id='$_GET[id]'"));
		if ($de['terima']=='Y'){
			?>
				<script>
					swal({title: "so sudah diterima, tidak bisa Batal Proses", text: "", icon: 
					"success"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=so';
					   }
					);
				</script>
			<?php
			exit();
		}
		$user = $_SESSION['username'];
		$user_proses = "Batal Proses-".$user."-".date('d-m-Y H:i:s');
		$proses = 'N';

		$tampil = mysqli_query($connect,"select * from soh where id='$_GET[id]'");
		$de = mysqli_fetch_assoc($tampil);
		$noso = $de['noso'];
		$tglso = $de['tglso'];

		if ($de['proses']=='N') {
			$text = "Dokumen ".$noso." Sudah di batal proses !";
			?>
			<script>
				swal({title: "Gagal batal proses data", text: "<?= $text ?>" , icon: 
				"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=so';
				   }
				);
			</script>
			<?php
			$lanjut = 0;
			exit();
		}

		$query = $connect->prepare("update soh set proses=?,user_proses=? where id=?");
		$query->bind_param('ssi',$proses,$user_proses,$_GET['id']);
		if($query->execute() and mysqli_affected_rows($connect)>0){
		//Update prosed detail
		mysqli_query($connect,"update sod set proses='$proses' where noso='$noso'");
		?>
			<script>
				swal({title: "Data berhasil di Batal Proses", text: "", icon: 
				"success"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=so';
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
				"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=so';
				   }
				);
			</script>
			<?php
		}		
	?>
</body>