<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "../../inc/config.php";
		//proses hapus
		session_start();
		date_default_timezone_set('Asia/Jakarta');
		$jamkeluar = date("Y-m-d H:i:s");
		$user = $_SESSION['username'];
		$user_proses = "Proses-".$user."-".date('d-m-Y H:i:s');
		$tglselesai = date('Y-m-d H:i:s');
		$proses = 'Y';

		$tampil = mysqli_query($connect,"select * from keluarh where id='$_GET[id]'");
		$de = mysqli_fetch_assoc($tampil);
		$nokeluar = $de['nokeluar'];
		$tglkeluar = $de['tglkeluar'];

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
					swal({title: "Gagal Proses !", text: "Sudah Closing Data Bulanan !", icon: 
					"success"}).then(function(){window.history.back(); //then(function(){window.location.href='../../dashboard.php?m=wo';
					   }
					);
				</script>
			<?php				
			exit();
		}

		if ($de['proses']=='Y' or $de['total']==0) {
			$text = "Dokumen ".$nokeluar." Sudah di proses / total masih 0 (nol)!";
			?>
			<script>
				swal({title: "Gagal proses data", text: "<?= $text ?>" , icon: 
				"error"}).then(function(){window.location.href='../../dashboard.php?m=keluar';
				   }
				);
			</script>
			<?php
			$lanjut = 0;
			exit();
		}
		$rec = mysqli_num_rows(mysqli_query($connect,"select * from keluard where nokeluar='$nokeluar'"));
		if ($rec==0) {
			echo "<script>alert('Tidak ada detail barang, tidak bisa proses !');history.go(-1) </script>";
			exit();			
		}		
		$nsubtotal=hit_total($connect,$nokeluar);
		$ntotal = $nsubtotal + $de['biaya_lain'];
		$query = $connect->prepare("update keluarh set proses=?,subtotal=?,total=?,user_proses=? where id=?");
		$query->bind_param('siisi',$proses,$nsubtotal,$ntotal,$user_proses,$_GET['id']);
		if($query->execute() and mysqli_affected_rows($connect)>0){
			mysqli_query($connect,"update keluard set proses='$proses',tglkeluar='$tglkeluar',jamkeluar='$jamkeluar' where nokeluar='$nokeluar'");
			$tampil = mysqli_query($connect,"select * from keluard where nokeluar='$nokeluar'");
			while($k=mysqli_fetch_assoc($tampil)){
				$qty = $k['qty'];
				$kdbarang = $k['kdbarang'];
				mysqli_query($connect,"update tbbarang set stock=stock-$qty where kode='$kdbarang'");
				$dtbarang = mysqli_query($connect,"select hpp from tbbarang where kode='$kdbarang'");
				$de = mysqli_fetch_assoc($dtbarang);
				$hpp = $de['hpp'];
				mysqli_query($connect,"update keluard set hpp='$hpp' where nokeluar='$nokeluar' and kdbarang='$kdbarang'");
				//Update ke stock_barang
				$cek = mysqli_query($connect,"select kdbarang,periode from stock_barang where periode='$periode' and kdbarang='$kdbarang'");
				$ketemu = mysqli_num_rows($cek);
				if ($ketemu==0){
					//cek saldo sebelumnya 
					$cariperiodesblm = $periode-1;
					$cek = mysqli_query($connect,"select kdbarang,periode,akhir,hpp_akhir from stock_barang where periode='$cariperiodesblm' and kdbarang='$kdbarang'");
					$ketemu = mysqli_fetch_assoc($cek);
					$akhir = $ketemu['akhir'];
					$hpp_akhir = $ketemu['hpp_akhir'];
					$nilai_awal = $akhir * $hpp_akhir;
					mysqli_query($connect,"insert into stock_barang (periode,kdbarang,awal,hpp_awal,hpp_akhir,nilai_awal) values ('$periode','$kdbarang','$akhir','$hpp_akhir','$hpp_akhir','$nilai_awal')");
				}
				mysqli_query($connect,"update stock_barang set keluar=keluar+$qty,akhir=awal+masuk-keluar,nilai_akhir=akhir*hpp_akhir where kdbarang='$kdbarang' and periode='$periode'");
				//
			}
			?>
			<script>
				swal({title: "Data berhasil diproses", text: "", icon: 
				"success"}).then(function(){window.location.href='../../dashboard.php?m=keluar';
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
				swal({title: "Gagal proses data", text: "", icon: 
				"error"}).then(function(){window.location.href='../../dashboard.php?m=keluar';
				   }
				);
			</script>
			<?php
		}		
	?>

	<script>
	<?php
	//pembuatan fungsi
	function hit_total($connect,$nokeluar)
	{
		global $nsubtotal;
		include "../../inc/config.php";
		$tampil = mysqli_query($connect,"select sum(subtotal) as nsubtotal from keluard where nokeluar='$nokeluar'");
		$de = mysqli_fetch_assoc($tampil);
		$nsubtotal = $de['nsubtotal'];
		//$nppn = $nsubtotal * ($ppn/100);
		//$ntotal = $nsubtotal - $nppn;
		return $nsubtotal;
	}
	?>
	</script>	
</body>