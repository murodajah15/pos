<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		if(!empty($_POST['noapprov'])){
			/*proses simpan**/
			include "../../inc/config.php";
			include "../../autonumber.php";
			date_default_timezone_set('Asia/Jakarta');
			$noapprov = autoNumberAP($connect,'id','approv_batas_piutang'); //strip_tags($_POST['noapprov']);
			$query = $connect->prepare("select * from approv_batas_piutang where noapprov=?");
			$query->bind_param('s',$noapprov);
			$result = $query->execute();
			$query->store_result();
			if ($query->num_rows >= "1") {
				// echo "<script>alert('noapprov tersebut sudah digunakan');
				// 	window.location.href='../../dashboard.php?m=approv_batas_piutang';
				// 	</script>";							
				?>
				<script>
					swal({title: "Gagal simpan data !", text: "No. Approv tersebut sudah digunakan", icon: 
					"error"}).then(function(){window.history.go(-1);} //{window.location.href='../../dashboard.php?m=approv_batas_piutang';
					   //}
					);
				</script>
				<?php
				exit();
			}
			$user_input = "Tambah-".$_POST['username']."-".date('d-m-Y H:i:s');
			$tglapprov = strip_tags($_POST['tglapprov']);
			$nojual = strip_tags($_POST['nojual']);
			$tgljual = strip_tags($_POST['tgljual']);
			$nmcustomer = strip_tags($_POST['nmcustomer']);
			$total = strip_tags($_POST['total']);
			$keterangan = strip_tags($_POST['keterangan']);

			$query = $connect->prepare("INSERT INTO approv_batas_piutang (noapprov,tglapprov,nojual,tgljual,nmcustomer,total,keterangan,user) values (?,?,?,?,?,?,?,?)");
			$query->bind_param('sssssiss',$noapprov,$tglapprov,$nojual,$tgljual,$nmcustomer,$total,$keterangan,$user_input);
			if($query->execute() and mysqli_affected_rows($connect)>0){
				// echo "<script>alert('Data berhasil disimpan !');
				// window.location.href='../../dashboard.php?m=approv_batas_piutang';
				// </script>";							
				$aktif = 'Y';
				$query = $connect->prepare("update saplikasi set noapprov=? where aktif=?");
				$query->bind_param('is',$sort_num,$aktif);	
				if($query->execute() and mysqli_affected_rows($connect)>0){
				}										
				?>
				<script>
					swal({title: "Data Berhasil disimpan ", text: "", icon: 
					"success"}).then(function(){window.location.href='../../dashboard.php?m=approv_batas_piutang';
					   }
					);
				</script>
				<?php
			}else{
				// echo "<script>alert('Gagal simpan data !');
				// window.location.href='../../dashboard.php?m=approv_batas_piutang';
				// </script>";							
				?>
				<script>
					swal({title: "Gagal simpan data !", text: "", icon: 
					"error"}).then(function(){window.location.href='../../dashboard.php?m=approv_batas_piutang';
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