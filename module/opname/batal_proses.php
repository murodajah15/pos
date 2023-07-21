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

		$tampil = mysqli_query($connect,"select * from opnameh where id='$_GET[id]'");
		$de = mysqli_fetch_assoc($tampil);
		$noopname = $de['noopname'];
		if ($de['proses']=='N') {
			$text = "Dokumen ".$noopname." Sudah di batal proses !";
			?>
			<script>
				swal({title: "Gagal batal proses data", text: "<?= $text ?>" , icon: 
				"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=opname';
				   }
				);
			</script>
			<?php
			$lanjut = 0;
			exit();
		}

		$tampil = mysqli_query($connect,"select * from opnamed");
		while($k=mysqli_fetch_assoc($tampil)){
			$qty = $k['qty'];
			$kdbarang = $k['kdbarang'];
			mysqli_query($connect,"update tbbarang set stock=stock_sblm where kode='$kdbarang'");
		}

		$query = $connect->prepare("update opnameh set proses=?,user_proses=? where id=?");
		$query->bind_param('ssi',$proses,$user_proses,$_GET['id']);
		if($query->execute() and mysqli_affected_rows($connect)>0){
		?>
			<script>
				swal({title: "Data berhasil di Batal Proses", text: "", icon: 
				"success"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=opname';
				   }
				);
			</script>
			<?php
		}else{
			// echo "<script>alert('Gagal hapus data !');
			// window.history.back(); //window.location.href='../../dashboard.php?m=tbbank';
			// </script>";				
			?>
			<script>
				swal({title: "Gagal Batal Proses data", text: "", icon: 
				"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=opname';
				   }
				);
			</script>
			<?php
		}		
	?>
</body>