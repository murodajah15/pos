<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "../../inc/config.php";
		if(!empty($_POST['kdbarang'])){
		//proses simpan
			date_default_timezone_set('Asia/Jakarta');
			//Cek Double
			$cek = mysqli_num_rows(mysqli_query($connect,"select * from opnamed where kdbarang='$_POST[kdbarang]' and noopname='$_POST[noopname]' and id<>'$_POST[id]'"));
			if ($cek > 0){
				echo "<script>alert('Kode tersebut sudah digunakan');history.go(-1) </script>";
				exit();
			}
				$user_input = "Update-".$_POST['username']."-".date('d-m-Y H:i:s');
				$noopname = strip_tags($_POST['noopname']);
				$kdbarang = strip_tags($_POST['kdbarang']);
				$nmbarang = strip_tags($_POST['nmbarang']);
				$qty = $_POST['qty'];
				$query = $connect->prepare("update opnamed set kdbarang=?,nmbarang=?,qty=?,user=? where id=?");
				$query->bind_param('ssisi',$kdbarang,$nmbarang,$qty,$user_input,$_POST['id']);
				if($query->execute() and mysqli_affected_rows($connect)>0){
					?>
					<script>
						swal({title: "Data Berhasil disimpan ", text: "", icon: 
						"success"}).then(function(){window.history.go(-2); //then(function(){window.location.href='../../dashboard.php?m=po';
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
						"error"}).then(function(){window.history.go(-2); //then(function(){window.location.href='../../dashboard.php?m=po';
						   }
						);
					</script>
					<?php
				}		

		}else{
			header("location:../../dashboard.php?m=opname");
		}
	?>
</body>
