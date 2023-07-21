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

		$tampil = mysqli_query($connect,"select * from kasir_keluarh where id='$_GET[id]'");
		$de = mysqli_fetch_assoc($tampil);
		$nokwitansi = $de['nokwitansi'];
		$tglkwitansi = $de['tglkwitansi'];
		$kdjnkeluar = $de['kdjnkeluar'];
		if ($de['proses']=='Y' or $de['total']==0) {
			$text = "Dokumen ".$nokwitansi." Sudah di proses atau total masih 0 (nol) !";
			?>
			<script>
				swal({title: "Gagal proses data", text: "<?= $text ?>" , icon: 
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
					"success"}).then(function(){window.history.back(); //then(function(){window.location.href='../../dashboard.php?m=wo';
					   }
					);
				</script>
			<?php				
			exit();
		}		
		
		//cek qty penerimaan ke po
		$tampil = mysqli_query($connect,"select * from kasir_keluard where nokwitansi='$nokwitansi'");
    while($k=mysqli_fetch_assoc($tampil)){			
    	$uang = $k['uang'];
   		$id = $k['id'];
   		$nodokumen = $k['nodokumen'];
   		$nomohon = $k['nomohon'];
			$query = mysqli_query($connect,"select * from mohklruangd where nomohon='$nomohon' and nodokumen='$nodokumen'");
			$de=mysqli_fetch_assoc($query);
			if (!empty($de['nodokumen'])) {
				//echo $de['nodokumen'].'  '.$de['kurang'].'  '.$uang;
				if ($de['kurang']<$uang) {
					$text = "Nilai ".$nodokumen.", melebihi jumlah yang dikeluarkan !";
					?>
					<script>
						swal({title: "Gagal proses data", text: "<?= $text ?>" , icon: 
						"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=kasir_keluar';
						   }
						);
					</script>
					<?php
					$lanjut = 0;
					exit();
				}
			}
    }

  	$query = $connect->prepare("update kasir_keluarh set proses=?,user_proses=? where id=?");
		$query->bind_param('ssi',$proses,$user_proses,$_GET['id']);
		if($query->execute() and mysqli_affected_rows($connect)>0){
			//Update prosed detail
			mysqli_query($connect,"update kasir_keluard set proses='$proses' where nokwitansi='$nokwitansi'");
			$tampil = mysqli_query($connect,"select * from kasir_keluard where nokwitansi='$nokwitansi'");
			$sudahbayar = 0;
     	$kurangbayar = 0;
     	while($k=mysqli_fetch_assoc($tampil)){
     		$uang = $k['uang'];
     		$id = $k['id'];
     		$nodokumen = $k['nodokumen'];
     		$nomohon = $k['nomohon'];
     		//echo $qty;
     		$data = mysqli_query($connect,"select uang,bayar,kurang from mohklruangd where nomohon='$nomohon' and nodokumen='$nodokumen'");
     		$de = mysqli_fetch_assoc($data);
     		$bayar = $de['bayar'];
     		$sudahbayar = $bayar + $uang;
     		$kurangbayar = $de['kurang'] - $uang;
				$query = $connect->prepare("update mohklruangd set bayar=?,kurang=? where nomohon=? and nodokumen=?");
				$query->bind_param('ssss',$sudahbayar,$kurangbayar,$nomohon,$nodokumen); 
				if($query->execute() and mysqli_affected_rows($connect)>0){
					$data= mysqli_query($connect,"select sum(bayar) as bayar from mohklruangd where nomohon='$nomohon'");
					$de = mysqli_fetch_assoc($data);
					$bayar = $de['bayar'];
					mysqli_query($connect,"update mohklruangh set bayar='$bayar',kurang=total-$bayar where nomohon='$nomohon'");
					$data= mysqli_query($connect,"select sum(uang) as bayar from kasir_keluard where nodokumen='$nodokumen' and proses='Y'");
					$de = mysqli_fetch_assoc($data);
					$bayar = $de['bayar'];
					if ($kdjlnkeluar='K-JL'){
						mysqli_query($connect,"update jualh set sudahbayar=sudahbayar-'$uang',kurangbayar=kurangbayar+'$uang' where nojual='$nodokumen'");
					}else{
						mysqli_query($connect,"update belih set sudahbayar=sudahbayar-'$uang',kurangbayar=kurangbayar-'$uang' where nobeli='$nodokumen'");
					}
					// $query = $connect->prepare("update mohklruangh set bayar=?,kurang=? where nomohon=?");
					// $query->bind_param('iis',$sudahbayar,$kurangbayar,$nomohon,$nodokumen); 
					// if($query->execute() and mysqli_affected_rows($connect)>0){
					// }
				}
			}
			?>
			<script>
				swal({title: "Data berhasil diproses", text: "", icon: 
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
				swal({title: "Gagal proses data", text: "", icon: 
				"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=kasir_keluar';
				   }
				);
			</script>
			<?php
		}		
	?>
</body>