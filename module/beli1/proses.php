<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "../../inc/config.php";
		//proses hapus
		session_start();
		date_default_timezone_set('Asia/Jakarta');
		$jambeli = date("Y-m-d H:i:s");
		$user = $_SESSION['username'];
		$user_proses = "Proses-".$user."-".date('d-m-Y H:i:s');
		$tglselesai = date('Y-m-d H:i:s');
		$proses = 'Y';

		$tampil = mysqli_query($connect,"select * from belih where id='$_GET[id]'");
		$de = mysqli_fetch_assoc($tampil);
		$nobeli = $de['nobeli'];
		$tglbeli = $de['tglbeli'];
		$total = $de['total'];
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
					swal({title: "Gagal Proses !", text: "Sudah Closing Data Bulanan !", icon: 
					"success"}).then(function(){window.history.back(); //then(function(){window.location.href='../../dashboard.php?m=wo';
					   }
					);
				</script>
			<?php				
			exit();
		}

		if ($prosesb=='Y' or $total==0) {
			$text = "Dokumen ".$nobeli." Sudah di proses / total masih 0 (nol)!";
			?>
			<script>
				swal({title: "Gagal proses data", text: "<?= $text ?>" , icon: 
				"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=beli';
				   }
				);
			</script>
			<?php
			$lanjut = 0;
			exit();
		}
		$rec = mysqli_num_rows(mysqli_query($connect,"select * from belid where nobeli='$nobeli'"));
		if ($rec==0) {
			echo "<script>alert('Tidak ada detail barang, tidak bisa proses !');history.go(-1) </script>";
			exit();			
		}				
		//cek qty penerimaan ke po
		$tampil = mysqli_query($connect,"select * from belid where nobeli='$nobeli'");
    	while($k=mysqli_fetch_assoc($tampil)){			
			$qty = $k['qty'];
			$id = $k['id'];
			$kdbarang = $k['kdbarang'];
			$nopo = $k['nopo'];
			if ($nopo<>""){
				$query = mysqli_query($connect,"select * from pod where nopo='$nopo' and kdbarang='$kdbarang'");
				$k=mysqli_fetch_assoc($query);
				if ($k['kurang']<$qty) {
					$text = "Barang ".$kdbarang." QTY penerimaan melebihi QTY Order !";
					?>
					<script>
						swal({title: "Gagal proses data", text: "<?= $text ?>" , icon: 
						"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=beli';
						}
						);
					</script>
					<?php
					$lanjut = 0;
					exit();
				}
			}
    	}

		$query = $connect->prepare("update belih set proses=?,user_proses=?,kurangbayar=? where id=?");
		$query->bind_param('ssii',$proses,$user_proses,$total,$_GET['id']);
		if($query->execute() and mysqli_affected_rows($connect)>0){
			//Update prosed detail
			mysqli_query($connect,"update belid set proses='$proses',tglbeli='$tglbeli',jambeli='$jambeli' where nobeli='$nobeli'");
			$tampil = mysqli_query($connect,"select * from belid where nobeli='$nobeli'");
     		while($k=mysqli_fetch_assoc($tampil)){
				$qty = $k['qty'];
				$id = $k['id'];
				$kdbarang = $k['kdbarang'];
				$nopo = $k['nopo'];
				$harga = $k['harga'];
				//echo $qty;
				$data = mysqli_query($connect,"select qty,terima from pod where nopo='$nopo' and kdbarang='$kdbarang'");
				$de = mysqli_fetch_assoc($data);
				$qtypesan = $de['qty'];
				$qtysdhterima = $de['terima'];
				$terima = $qtysdhterima + $qty;
				$kurang = $qtypesan -  $terima;
				$query = $connect->prepare("update pod set terima=?,kurang=? where nopo=? and kdbarang=?");
				$query->bind_param('ssss',$terima,$kurang,$nopo,$kdbarang); 
				if($query->execute() and mysqli_affected_rows($connect)>0){
					$cek = mysqli_query($connect,"select sum(kurang) as kurang from pod where nopo='$nopo'");	
					$de = mysqli_fetch_assoc($cek);
					if ($de['kurang']==0){
						$query = $connect->prepare("update poh set terima=? where nopo=?");
						$query->bind_param('ss',$proses,$nopo);
						if($query->execute() and mysqli_affected_rows($connect)>0){}
					}
				}
				//HPP-----------
				$data = mysqli_fetch_assoc(mysqli_query($connect,"select hpp_lama,hpp,stock,harga_beli,harga_beli_lama from tbbarang where kode='$kdbarang'"));
				$hpptbbarang = $data['hpp'];
				if ($hpptbbarang<0){
					$hpptbbarang=0;
				}
				$stocktbbarang = $data['stock'];
				if ($stocktbbarang<0){
					$stocktbbarang=0;
				}

				$jumstock = $stocktbbarang+$qty;
				$harga_beli_lama  = $data['harga_beli_lama'];
				if ($harga_beli_lama=0) {
					$harga_beli_lama = $harga;
				}else{
					$harga_beli_lama = $data['harga_beli'];
				}
				$harga = ($hpptbbarang*$stocktbbarang) + ($harga*$qty); 
				$hpp = $harga / ($jumstock);
				//echo $harga.'  '.$jumstock.'  '.$hpp.'<br>';
				//echo $hpptbbarang.'aaaa'.$hpp.'aaaaa'.$kdbarang;
				//(((invent.nhpp * invent.nqtystock) + (cinbelid.nhrgbeli * cinbelid.nqty))/(invent.nqtystock + cinbelid.nqty))
				if ($stocktbbarang>0) {
					//ECHO $stocktbbarang;
					mysqli_query($connect,"update tbbarang set hpp_lama='$hpptbbarang',harga_beli_lama='$harga_beli_lama',hpp='$hpp',harga_beli='$harga' where kode='$kdbarang'");
				}else{
					mysqli_query($connect,"update tbbarang set hpp_lama='0',hpp='$hpp',harga_beli='$harga' where kode='$kdbarang'");
				}
				mysqli_query($connect,"update belid set hpp='$hpp' where nobeli='$nobeli' and kdbarang='$kdbarang'");
				//--------------
				mysqli_query($connect,"update tbbarang set stock=stock+$qty where kode='$kdbarang'");
				//-- Update Stock_barang
				$cek = mysqli_query($connect,"select kdbarang,periode from stock_barang where periode='$periode' and kdbarang='$kdbarang'");
				$ketemu = mysqli_num_rows($cek);
				if ($ketemu==0){
					//cek saldo sebelumnya 
					$cariperiodesblm = $periode-1;
					$cek = mysqli_query($connect,"select kdbarang,periode,akhir,hpp_akhir from stock_barang where periode='$cariperiodesblm' and kdbarang='$kdbarang'");
					$ketemu = mysqli_fetch_assoc($cek);
					$akhir = $ketemu['akhir'];
					$hpp_akhir = $hpp;
					$nilai_awal = $akhir * $hpp_akhir;
					mysqli_query($connect,"insert into stock_barang (periode,kdbarang,awal,hpp_awal,hpp_akhir,nilai_awal) values ('$periode','$kdbarang','$akhir','$hpp_akhir','$hpp_akhir','$nilai_awal')");
				}
				//update ke stock_barang
				mysqli_query($connect,"update stock_barang set masuk=masuk+$qty,hpp_akhir=$hpp,akhir=awal+masuk-keluar,nilai_akhir=akhir*hpp_akhir where kdbarang='$kdbarang' and periode='$periode'");
			}
			?>
			<script>
				swal({title: "Data berhasil diproses", text: "", icon: 
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
				swal({title: "Gagal proses data", text: "", icon: 
				"error"}).then(function()window.history.back(); //window.location.href='../../dashboard.php?m=beli';
				   }
				);
			</script>
			<?php
		}		
	?>
</body>