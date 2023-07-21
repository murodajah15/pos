<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		if(!empty($_POST['nopo'])){
			//proses simpan
			include "../../inc/config.php";
			include "../../autonumber.php";
			date_default_timezone_set('Asia/Jakarta');
			$nopo = autoNumberPO($connect,'id','poh'); //strip_tags($_POST['nopo']);
			//Cek Double
			$cek = mysqli_num_rows(mysqli_query($connect,"select * from poh where nopo='$nopo'"));
			if ($cek > 0){
				echo "<script>alert('No sudah ada, data tidak bisa disimpan !');history.go(-1) </script>";
				exit();
			}
			$user_input = "Tambah-".$_POST['username']."-".date('d-m-Y H:i:s');
			$tglpo = strip_tags($_POST['tglpo']);
			$noreferensi = strip_tags($_POST['noreferensi']);
			$kdsupplier = strip_tags($_POST['kdsupplier']);
			$nmsupplier = strip_tags($_POST['nmsupplier']);
			$jenis_order = strip_tags($_POST['jenis_order']);
			$tglkirim = strip_tags($_POST['tglkirim']);
			$biaya_lain = strip_tags($_POST['biaya_lain']);
			$ket_biaya_lain = strip_tags($_POST['ket_biaya_lain']);
			$carabayar = strip_tags($_POST['carabayar']);
			$tempo = strip_tags($_POST['tempo']);
			$tgl_jt_tempo = strip_tags($_POST['tgl_jt_tempo']);
			$ppn = strip_tags($_POST['ppn']);
			$materai = strip_tags($_POST['materai']);
			$keterangan = strip_tags($_POST['keterangan']);
			$query = $connect->prepare("INSERT INTO poh (nopo,tglpo,noreferensi,kdsupplier,nmsupplier,jenis_order,tglkirim,biaya_lain,ket_biaya_lain,carabayar,ppn,materai,keterangan,tempo,tgl_jt_tempo,user) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
			 $query->bind_param('ssssssssssssssss',$nopo,$tglpo,$noreferensi,$kdsupplier,$nmsupplier,$jenis_order,$tglkirim,$biaya_lain,$ket_biaya_lain,$carabayar,$ppn,$materai,$keterangan,$tempo,$tgl_jt_tempo,$user_input);	
			if($query->execute() and mysqli_affected_rows($connect)>0){
				// echo "<script>alert('Data berhasil disimpan !');
				// window.location.href='../../dashboard.php?m=wo';
				// </script>";							
				$aktif = 'Y';
				$query = $connect->prepare("update saplikasi set nopo=? where aktif=?");
				$query->bind_param('is',$sort_num,$aktif);	
				if($query->execute() and mysqli_affected_rows($connect)>0){
				}										
				?>
				<script>
					swal({title: "Data Berhasil disimpan ", text: "", icon: 
					"success"}).then(function(){window.location.href='../../dashboard.php?m=po';
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
					"error"}).then(function(){window.location.href='../../dashboard.php?m=po';
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