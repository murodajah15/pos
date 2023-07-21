<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "../../inc/config.php";
		if(!empty($_POST['noapprov'])){
			//proses simpan
			date_default_timezone_set('Asia/Jakarta');
			//Cek Double
			$query = $connect->prepare("select * from tbcustomer where kode=? and id<>?");
			$query->bind_param('si',$_POST['kode'],$_POST['id']);
			$result = $query->execute();
			$query->store_result();
			if ($query->num_rows >= "1") {
				// echo "<script>alert('Kode tersebut sudah digunakan');
				// 	window.location.href='../../dashboard.php?m=tbcustomer';
				// 	</script>";							
				?>
				<script>
					swal({title: "Gagal simpan data", text: "Kode tersebut sudah digunakan", icon: 
					"error"}).then(function(){window.location.href='../../dashboard.php?m=tbcustomer';
					   }
					);
				</script>
				<?php
				exit();
			}
			$user_input = "Update-".$_POST['username']."-".date('d-m-Y H:i:s');
			$noapprov = strip_tags($_POST['noapprov']);
			$tglapprov = strip_tags($_POST['tglapprov']);
			$nojual = strip_tags($_POST['nojual']);
			$tgljual = strip_tags($_POST['tgljual']);
			$nmcustomer = strip_tags($_POST['nmcustomer']);
			$total = strip_tags($_POST['total']);
			$keterangan = strip_tags($_POST['keterangan']);

			$query = $connect->prepare("update approv_batas_piutang set noapprov=?,tglapprov=?,nojual=?,tgljual=?,nmcustomer=?,total=?,keterangan=?,user=? where id=?");
			$query->bind_param('sssssissi',$noapprov,$tglapprov,$nojual,$tgljual,$nmcustomer,$total,$keterangan,$user_input,$_POST['id']);

			if($query->execute() and mysqli_affected_rows($connect)>0) {
				// echo "<script>alert('Data berhasil disimpan !');
				// window.location.href='../../dashboard.php?m=tbcustomer';
				// </script>";										
				?>
				<script>
					swal({title: "Data Berhasil disimpan ", text: "", icon: 
					"success"}).then(function(){window.history.go(-2); //window.location.href='../../dashboard.php?m=tbcustomer';
					   }
					);
				</script>
				<?php
			}else{
				// echo "<script>alert('Gagal simpan data !');
				// window.location.href='../../dashboard.php?m=tbcustomer';
				// </script>";							
				?>
				<script>
					swal({title: "Gagal simpan data ", text: "", icon: 
					"error"}).then(function(){window.history.go(-2); //window.location.href='../../dashboard.php?m=tbcustomer';
					   }
					);
				</script>
				<?php
			}			
		}else{
			header("location:../../dashboard.php?m=approv_batas_piutang");
		}
	?>
</body>