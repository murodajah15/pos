<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "../../inc/config.php";
		//proses hapus
		session_start();
		date_default_timezone_set('Asia/Jakarta');
		$user = $_SESSION['username'];
		$user_proses = "Batal Proses-".$user."-".date('d-m-Y H:i:s');
		$tglselesai = date('');
		$proses = 'N';

		$tampil = mysqli_query($connect,"select * from belih where id='$_GET[id]'");
		$de = mysqli_fetch_assoc($tampil);
		$nobeli = $de['nobeli'];
		$tglbeli = $de['tglbeli']; //'00-00-0000';
		$sudahbayar = $de['sudahbayar'];
		$prosesb = $de['proses'];

		$de=mysqli_fetch_assoc(mysqli_query($connect,"select * from saplikasi where aktif='Y'"));
		$closing_hpp = $de['closing_hpp'];
		$bulan = substr($tglbeli,5,2);
		$tahun = substr($tglbeli,0,4);
		$periode = $tahun.$bulan;
		//echo $periode;
		if ($periode<=$closing_hpp) {
			echo 'Closing terakhir : '.$closing_hpp;
			?>
				<script>
					swal({title: "Gagal Batal Proses !", text: "Sudah Closing Data Bulanan !", icon: 
					"success"}).then(function(){window.history.back(); //then(function(){window.location.href='../../dashboard.php?m=wo';
					   }
					);
				</script>
			<?php				
			exit();
		}

		if ($prosesb=='N' or $sudahbayar>0) {
			$text = "Dokumen ".$nobeli." Sudah di batal proses, atau sudah ada pembayaran !";
			?>
			<script>
				swal({title: "Gagal batal proses data", text: "<?= $text ?>" , icon: 
				"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=beli';
				   }
				);
			</script>
			<?php
			$lanjut = 0;
			exit();
		}

		$kurangbayar =0;
		$query = $connect->prepare("update belih set proses=?,user_proses=?,kurangbayar=? where id=?");
		$query->bind_param('ssss',$proses,$user_proses,$kurangbayar,$_GET['id']);
		if($query->execute() and mysqli_affected_rows($connect)>0){
			//Update prosed detail
			mysqli_query($connect,"update belid set proses='$proses',tglbeli='$tglbeli' where nobeli='$nobeli'");
			$tampil = mysqli_query($connect,"select * from belih where id='$_GET[id]'");
			$de = mysqli_fetch_assoc($tampil);
			$nobeli = $de['nobeli'];
			$tampil = mysqli_query($connect,"select * from belid where nobeli='$nobeli'");
     	while($k=mysqli_fetch_assoc($tampil)){
     		$qty = $k['qty'];
     		$id = $k['id'];
     		$kdbarang = $k['kdbarang'];
     		$nopo = $k['nopo'];
     		$query = mysqli_query($connect,"select qty,terima from pod where nopo='$nopo' and kdbarang='$kdbarang'");
     		$de = mysqli_fetch_assoc($query);
     		$qtypesan = $de['qty'];
     		$qtysdhterima = $de['terima'];
     		$terima = $qtysdhterima - $qty;
     		$kurang = $qtypesan -  $terima;
				$query = $connect->prepare("update pod set terima=?,kurang=? where nopo=? and kdbarang=?");
				$query->bind_param('ssss',$terima,$kurang,$nopo,$kdbarang); 
				if($query->execute() and mysqli_affected_rows($connect)>0){
					$query = $connect->prepare("update poh set terima=? where nopo=?");
					$query->bind_param('ss',$proses,$nopo);
					if($query->execute() and mysqli_affected_rows($connect)>0){}
				}
				mysqli_query($connect,"update tbbarang set stock=stock-$qty where kode='$kdbarang'");
				//HPP-----------
				$data = mysqli_fetch_assoc(mysqli_query($connect,"select hpp_lama,hpp,stock,harga_beli,harga_beli_lama from tbbarang where kode='$kdbarang'"));
				$hpp_lama = $data['hpp_lama'];
				$harga_beli_lama = $data['harga_beli_lama'];
				if ($harga_beli_lama=0) {
						$harga_beli_lama = $data['harga_beli'];
				}
				if ($data['stock']>0) {
					$harga_beli_lama = $data['harga_beli'];
				}else{
					$harga_beli_lama = $data['harga_beli'];
				}
				//echo $data['stock'].'   '.$hpp_lama;
				mysqli_query($connect,"update tbbarang set hpp_lama='$hpp_lama',harga_beli_lama='$harga_beli_lama',hpp='$hpp_lama',harga_beli='$harga_beli_lama' where kode='$kdbarang'");
				//--------------
				mysqli_query($connect,"update stock_barang set masuk=masuk-$qty,hpp_akhir=$hpp_lama,akhir=awal+masuk-keluar,nilai_akhir=akhir*$hpp_lama where kdbarang='$kdbarang' and periode='$periode'");
			}
			?>
			<script>
				swal({title: "Data berhasil di Batal Proses", text: "", icon: 
				"success"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=beli';
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
				swal({title: "Gagal Batal Proses data", text: "", icon: 
				"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=beli';
				   }
				);
			</script>
			<?php
		}		
	?>
</body>