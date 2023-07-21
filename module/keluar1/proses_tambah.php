<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		if(!empty($_POST['nokeluar'])){
			//proses simpan
			include "../../inc/config.php";
			include "../../autonumber.php";
			date_default_timezone_set('Asia/Jakarta');
			$nokeluar = autoNumberKB($connect,'id','keluarh'); //strip_tags($_POST['nokeluar']);
			//Cek Double
			$cek = mysqli_num_rows(mysqli_query($connect,"select * from keluarh where nokeluar='$nokeluar'"));
			if ($cek > 0){
				echo "<script>alert('No sudah ada, data tidak bisa disimpan !');history.go(-1) </script>";
				exit();
			}
			$user_input = "Tambah-".$_POST['username']."-".date('d-m-Y H:i:s');
			$tglkeluar = strip_tags($_POST['tglkeluar']);
			$noreferensi = strip_tags($_POST['noreferensi']);
			$tgldokumen = strip_tags($_POST['tgldokumen']);
			$kdjntrans = strip_tags($_POST['kdjntrans']);
			$kdgudang = strip_tags($_POST['kdgudang']);
			$biaya_lain = strip_tags($_POST['biaya_lain']);
			$keterangan = strip_tags($_POST['keterangan']);
			$query = $connect->prepare("INSERT INTO keluarh (nokeluar,tglkeluar,noreferensi,tgldokumen,kdjntrans,
				kdgudang,biaya_lain,keterangan,user) values (?,?,?,?,?,?,?,?,?)");
			$query->bind_param('sssssssss',$nokeluar,$tglkeluar,$noreferensi,$tgldokumen,$kdjntrans,
				$kdgudang,$biaya_lain,$keterangan,$user_input);	
			if($query->execute() and mysqli_affected_rows($connect)>0){
				// echo "<script>alert('Data berhasil disimpan !');
				// window.location.href='../../dashboard.php?m=wo';
				// </script>";							
				$aktif = 'Y';
				$query = $connect->prepare("update saplikasi set nokeluar=? where aktif=?");
				$query->bind_param('is',$sort_num,$aktif);	
				if($query->execute() and mysqli_affected_rows($connect)>0){
				}										
				?>
				<script>
					swal({title: "Data Berhasil disimpan ", text: "", icon: 
					"success"}).then(function(){window.location.href='../../dashboard.php?m=keluar';
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
					"error"}).then(function(){window.location.href='../../dashboard.php?m=keluar';
					   }
					);
				</script>
				<?php
			}		
		}else{
			?>
			<script>
				swal({title: "No. PO masih kosong !", text: "", icon: 
				"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=tbsupplier';
				   }
				);
			</script>
			<?php
		}
	?>
</body>