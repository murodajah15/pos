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

		$tampil = mysqli_query($connect,"select * from keluarh where id='$_GET[id]'");
		$de = mysqli_fetch_assoc($tampil);
		$nokeluar = $de['nokeluar'];
		$tglkeluar = $de['tglkeluar']; //'00-00-0000';

		$cek=mysqli_fetch_assoc(mysqli_query($connect,"select * from saplikasi where aktif='Y'"));
		$closing_hpp = $cek['closing_hpp'];
		$bulan = substr($tglkeluar,5,2);
		$tahun = substr($tglkeluar,0,4);
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

		if ($de['proses']=='N') {
			$text = "Dokumen ".$nokeluar." Sudah di batal proses !";
			?>
			<script>
				swal({title: "Gagal batal proses data", text: "<?= $text ?>" , icon: 
				"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=keluar';
				   }
				);
			</script>
			<?php
			$lanjut = 0;
			exit();
		}

		$query = $connect->prepare("update keluarh set proses=?,user_proses=? where id=?");
		$query->bind_param('ssi',$proses,$user_proses,$_GET['id']);
		if($query->execute() and mysqli_affected_rows($connect)>0){
			mysqli_query($connect,"update keluard set proses='$proses',tglkeluar='$tglkeluar' where nokeluar='$nokeluar'");
			$tampil = mysqli_query($connect,"select * from keluard where nokeluar='$nokeluar'");
			while($k=mysqli_fetch_assoc($tampil)){
				$qty = $k['qty'];
				$kdbarang = $k['kdbarang'];
				mysqli_query($connect,"update tbbarang set stock=stock+$qty where kode='$kdbarang'");
				mysqli_query($connect,"update stock_barang set keluar=keluar-$qty,akhir=awal+masuk-keluar,nilai_akhir=akhir*hpp_akhir where kdbarang='$kdbarang' and periode='$periode'");
			}
			?>
			<script>
				swal({title: "Data berhasil di Batal Proses", text: "", icon: 
				"success"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=keluar';
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
				"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=keluar';
				   }
				);
			</script>
			<?php
		}		
	?>
</body>