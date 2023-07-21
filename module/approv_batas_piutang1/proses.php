<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "../../inc/config.php";
		//proses hapus
		session_start();
		date_default_timezone_set('Asia/Jakarta');

		$user = $_SESSION['username'];
		$user_proses = "Proses-".$user."-".date('d-m-Y H:i:s');
		$tglselesai = date('Y-m-d H:i:s');
		$proses = 'Y';
		$query = $connect->prepare("update approv_batas_piutang set proses=?,user_proses=? where id=?");
		$query->bind_param('ssi',$proses,$user_proses,$_GET['id']);
		if($query->execute() and mysqli_affected_rows($connect)>0){
			?>
			<script>
				swal({title: "Data berhasil diproses", text: "", icon: 
				"success"}).then(function(){window.location.href='../../dashboard.php?m=approv_batas_piutang';
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
				swal({title: "Gagal proses data", text: "", icon: 
				"error"}).then(function(){window.location.href='../../dashboard.php?m=approv_batas_piutang';
				   }
				);
			</script>
			<?php
		}		
	?>
</body>