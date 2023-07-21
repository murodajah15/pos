<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		if(!empty($_POST['nobeli'])){
			//proses simpan
			include "../../inc/config.php";
			include "../../autonumber.php";
			date_default_timezone_set('Asia/Jakarta');
			$nobeli = autoNumberBE($connect,'id','belih'); //strip_tags($_POST['nobeli']);
			//Cek Double
			$cek = mysqli_num_rows(mysqli_query($connect,"select * from belih where nobeli='$nobeli'"));
			if ($cek > 0){
				echo "<script>alert('No sudah ada, data tidak bisa disimpan !');history.go(-1) </script>";
				exit();
			}
			$user_input = "Tambah-".$_POST['username']."-".date('d-m-Y H:i:s');
			$tglbeli = strip_tags($_POST['tglbeli']);
			$noinvoice = strip_tags($_POST['noinvoice']);
			$tglinvoice = strip_tags($_POST['tglinvoice']);
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
			$query = $connect->prepare("INSERT INTO belih (noinvoice,tglinvoice,nobeli,tglbeli,kdsupplier,nmsupplier,jenis_order,tglkirim,biaya_lain,ket_biaya_lain,carabayar,ppn,materai,keterangan,tempo,tgl_jt_tempo,user) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
			 $query->bind_param('sssssssssssssssss',$noinvoice,$tglinvoice,$nobeli,$tglbeli,$kdsupplier,$nmsupplier,$jenis_order,$tglkirim,$biaya_lain,$ket_biaya_lain,$carabayar,$ppn,$materai,$keterangan,$tempo,$tgl_jt_tempo,$user_input);	
			if($query->execute() and mysqli_affected_rows($connect)>0){
				// echo "<script>alert('Data berhasil disimpan !');
				// window.location.href='../../dashboard.php?m=wo';
				// </script>";			
				$aktif = 'Y';
				$query = $connect->prepare("update saplikasi set nobeli=? where aktif=?");
				$query->bind_param('is',$sort_num,$aktif);	
				if($query->execute() and mysqli_affected_rows($connect)>0){
				}										
				?>
				<script>
					swal({title: "Data Berhasil disimpan ", text: "", icon: 
					"success"}).then(function(){window.location.href='../../dashboard.php?m=beli';
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
					"error"}).then(function(){window.location.href='../../dashboard.php?m=beli';
					   }
					);
				</script>
				<?php
			}		
		}else{
			?>
			<script>
				swal({title: "No. Pembelian masih kosong !", text: "", icon: 
				"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=tbsupplier';
				   }
				);
			</script>
			<?php
		}
	  function autoNumber($connect,$id, $table){
	 		$tampil = mysqli_query($connect,"select * from saplikasi where aktif='Y'");
	 		$k=mysqli_fetch_assoc($tampil);
	 		$bulan = $k['bulan'];
	 		if ($bulan<10){
	 			$bulan='0'.$k['bulan'];
	 		}
	 		$tahun = $k['tahun'];
	 		$sort_num = $k['nobeli'];
			//$query = 'SELECT MAX(RIGHT('.$id.', 4)) as max_id FROM '.$table.' ORDER BY '.$id;
			// date_default_timezone_set("Asia/Jakarta");  
	  	// $tgl = date('m-d-Y');
			// $year = date('Y');
			// $month = date('M');
			// $nmonth = date('m');
			// $yearmonth= $year.$nmonth;
			// mysqli_query($connect,'alter table '.$table.' AUTO_INCREMENT=0');
			// $query = 'select id as max_id from '.$table.' order by id desc';
			// $result = mysqli_query($connect,$query);
			// $data = mysqli_fetch_array($result);
			// $id_max = $data['max_id'];
			// $sort_num = $id_max ;//(int) substr($id_max, 1, 4);
			// $sort_num++;
			// $new_code = 'RS/'.$year.'/'.$nmonth.'/'.sprintf("%05s", $sort_num);
	 		$sort_num++;
			$new_code = 'BE/'.$tahun.'/'.$bulan.'/'.sprintf("%05s", $sort_num);
			return $new_code;
		}
	?>
</body>