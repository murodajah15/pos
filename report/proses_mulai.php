<body>
	<script src="../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "../inc/config.php";
		if(!empty($_POST['nowo'])){
		//proses simpan
			date_default_timezone_set('Asia/Jakarta');
			$tglmulai = strip_tags($_POST['tglmulai']);
			$jammulai = strip_tags($_POST['jammulai']);
			$user_input = "Update-".$_POST['username']."-".date('d-m-Y H:i:s');
			$query = $connect->prepare("update status_wo set tglmulai=?,jammulai=?,user_mulai=? where id=?");
			$query->bind_param('sssi',$tglmulai,$jammulai,$user_input,$_POST['id']);
			//mysqli_query($connect,"update status_wo set user_selesai='$user_input'");
			if($query->execute() and mysqli_affected_rows($connect)>0){
				// echo "<script>alert('Data berhasil disimpan !');
				// window.location.href='../../dashboard.php?m=wo';
				// </script>";													
				?>
				<script>
					swal({title: "Data Berhasil disimpan ", text: "", icon: 
					"success"}).then(function(){window.history.go(-2); //then(function(){window.location.href='../../dashboard.php?m=update_wo';
					   }
					);
				</script>
				<?php
			}else{
				// echo "<script>alert('Gagal simpan data !');
				// window.location.href='../../dashboard.php?m=wo';
				// </script>";							
				?>
				<script>
					swal({title: "Gagal simpan data ", text: "", icon: 
					"error"}).then(function(){window.history.go(-2); //then(function(){window.location.href='../../dashboard.php?m=update_wo';
					   }
					);
				</script>
				<?php
			}		

		}else{
			header("location:../../dashboard.php?m=update_wo");
		}
	?>
</body>
