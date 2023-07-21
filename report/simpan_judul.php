<body>
	<?php
		echo $_GET['id'].'  '.$_GET['username'];
	?>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		if(!empty($_POST['namalap'])){
			//proses simpan
			include "../../inc/config.php";
			date_default_timezone_set('Asia/Jakarta');
			//Cek Double
			$user_input = "Update-".$_POST['username']."-".date('d-m-Y H:i:s');
			$judul1 = strip_tags($_POST['judul1']);
			$judul2 = strip_tags($_POST['judul2']);
			$judul3 = strip_tags($_POST['judul3']);

			$cek = mysqli_num_rows(mysqli_query($connect,"select * from judullap where namalap ='$_POST[namalap]'"));
			if ($cek > 0){
				$query = $connect->prepare("update judullap set namalap=?,judul1=?,judul2=?,judul3=?,user=?");
				$query->bind_param('sssss',$namalap,$judul1,$judul2,$judul3,$user);
			}else{
				$query = $connect->prepare("insert into judullap (namalap,judul1,judul2,judul3,user) value (?,?,?,?,?)");
				$query->bind_param('sssss',$namalap,$judul1,$judul2,$judul3,$user);					
			}
			if($query->execute() and mysqli_affected_rows($connect)>0){
				?>
				<script>
					swal({title: "Data Berhasil disimpan ", text: "", icon: 
					"success"}).then(function(){window.history.back();
					);
				</script>
				<?php
			}else{
				?>
				<script>
					swal({title: "Gagal simpan data ", text: "", icon: 
					"error"}).then(function(){window.history.back();
					   }
					);
				</script>
				<?php
			}		
		}else{
			?>
			<script>
				swal({title: "Gagal simpan data ", text: "", icon: 
				"error"}).then(function(){window.history.back();
				   }
				);
			</script>
			<?php
		}
	?>
</body>