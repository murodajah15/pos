<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "../../inc/config.php";
		//proses hapus
		session_start();
		date_default_timezone_set('Asia/Jakarta');
		$user = $_SESSION['username'];
		$user_proses = "Batal Proses-".$user."-".date('d-m-Y H:i:s');
		$proses = 'N';
		
		$tampil = mysqli_query($connect,"select * from kasir_keluarh where id='$_GET[id]'");
		$de = mysqli_fetch_assoc($tampil);
		$nokwitansi = $de['nokwitansi'];
		$tglkwitansi = $de['tglkwitansi'];
		if ($de['proses']=='N') {
			$text = "Dokumen ".$nokwitansi." Sudah di batal proses !";
			?>
			<script>
				swal({title: "Gagal batal proses data", text: "<?= $text ?>" , icon: 
				"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=kasir_keluar';
				   }
				);
			</script>
			<?php
			$lanjut = 0;
			exit();
		}		

		$cek=mysqli_fetch_assoc(mysqli_query($connect,"select * from saplikasi where aktif='Y'"));
		$closing_hpp = $cek['closing_hpp'];
		$bulan = substr($tglkwitansi,5,2);
		$tahun = substr($tglkwitansi,0,4);
		$periode = $tahun.$bulan;
		//echo $periode;
		if ($periode<=$closing_hpp) {
			echo 'Closing terakhir : '.$closing_hpp;
			?>
				<script>
					swal({title: "Gagal Proses !", text: "Sudah Closing Data Bulanan !", icon: 
					"success"}).then(function(){window.history.back(); //then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=wo';
					   }
					);
				</script>
			<?php				
			exit();
		}
		
		$query = $connect->prepare("update kasir_keluarh set proses=?,user_proses=? where id=?");
		$query->bind_param('sss',$proses,$user_proses,$_GET['id']);
		if($query->execute() and mysqli_affected_rows($connect)>0){
			//Update prosed detail
			mysqli_query($connect,"update kasir_keluard set proses='$proses' where nokwitansi='$nokwitansi'");
			$tampil = mysqli_query($connect,"select * from kasir_keluarh where id='$_GET[id]'");
			$de = mysqli_fetch_assoc($tampil);
			$nokwitansi = $de['nokwitansi'];
			$tampil = mysqli_query($connect,"select * from kasir_keluard where nokwitansi='$nokwitansi'");
     	while($k=mysqli_fetch_assoc($tampil)){
     		$uang = $k['uang'];
     		$id = $k['id'];
     		$nomohon = $k['nomohon'];
	   		$nodokumen = $k['nodokumen'];

				$data= mysqli_query($connect,"select sum(uang) as bayar from kasir_keluard where nodokumen='$nodokumen' and proses='Y'");
				$de = mysqli_fetch_assoc($data);
				$bayar = $de['bayar'];
				if (!isset($bayar)) {
					$bayar=0;
				}
				if ($kdjlnkeluar='K-JL'){
					mysqli_query($connect,"update jualh set sudahbayar=sudahbayar+'$uang',kurangbayar=kurangbayar-'$uang' where nojual='$nodokumen'");
				}else{
					mysqli_query($connect,"update belih set sudahbayar=sudahbayar+'$uang',kurangbayar=kurangbayar-'$uang' where nobeli='$nodokumen'");
				}
     		$query = mysqli_query($connect,"select uang,kurang,bayar from mohklruangd where nomohon='$nomohon' and nodokumen='$nodokumen'");
     		$de = mysqli_fetch_assoc($query);
     		$bayar = $de['bayar'] - $uang;
     		$kurang = $de['kurang'] + $uang;
				$query = $connect->prepare("update mohklruangd set bayar=?,kurang=? where nomohon=? and nodokumen=?");
				$query->bind_param('ssss',$bayar,$kurang,$nomohon,$nodokumen); 
				if($query->execute() and mysqli_affected_rows($connect)>0){
					$data= mysqli_query($connect,"select sum(bayar) as bayar from mohklruangd where nomohon='$nomohon'");
					$de = mysqli_fetch_assoc($data);
					$bayar = $de['bayar'];
					mysqli_query($connect,"update mohklruangh set bayar='$bayar',kurang=total-$bayar where nomohon='$nomohon'");		
				}
			}
			?>
			<script>
				swal({title: "Data berhasil di Batal Proses", text: "", icon: 
				"success"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=kasir_keluar';
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
				"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=kasir_keluar';
				   }
				);
			</script>
			<?php
		}		
	?>
</body>