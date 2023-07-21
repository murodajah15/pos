<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		if(!empty($_POST['nomohon'])){
			//proses simpan
			include "../../inc/config.php";
			include "../../autonumber.php";
			date_default_timezone_set('Asia/Jakarta');
			$nomohon = autoNumberPK($connect,'id','mohklruangh'); //strip_tags($_POST['nomohon']);
			//Cek Double
			$cek = mysqli_num_rows(mysqli_query($connect,"select * from mohklruangh where nomohon='$nomohon'"));
			if ($cek > 0){
				echo "<script>alert('No sudah ada, data tidak bisa disimpan !');history.go(-1) </script>";
				exit();
			}
			$user_input = "Tambah-".$_POST['username']."-".date('d-m-Y H:i:s');
			$tglmohon = strip_tags($_POST['tglmohon']);
			$kdjnkeluar = strip_tags($_POST['kdjnkeluar']);
			$nmjnkeluar = strip_tags($_POST['nmjnkeluar']);
			$carabayar = strip_tags($_POST['carabayar']);
			$kdbank = strip_tags($_POST['kdbank']);
			$nmbank = strip_tags($_POST['nmbank']);
			$kdjnskartu = strip_tags($_POST['kdjnskartu']);
			$nmjnskartu = strip_tags($_POST['nmjnskartu']);
			$norek = strip_tags($_POST['norek']);
			$nocekgiro = strip_tags($_POST['nocekgiro']);
			$tgljttempocekgiro = strip_tags($_POST['tgljttempocekgiro']);
			$materai = strip_tags($_POST['materai']);
			$total = strip_tags($_POST['total']);
			$keterangan = strip_tags($_POST['keterangan']);
			$query = $connect->prepare("INSERT INTO mohklruangh (nomohon,tglmohon,kdjnkeluar,nmjnkeluar,carabayar,kdbank,nmbank,kdjnskartu,nmjnskartu,norek,nocekgiro,tgljttempocekgiro,materai,total,keterangan,user) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
			 $query->bind_param('ssssssssssssiiss',$nomohon,$tglmohon,$kdjnkeluar,$nmjnkeluar,$carabayar,$kdbank,$nmbank,$kdjnskartu,$nmjnskartu,$norek,$nocekgiro,$tgljttempocekgiro,$materai,$total,$keterangan,$user_input);	
			if($query->execute() and mysqli_affected_rows($connect)>0){
				// echo "<script>alert('Data berhasil disimpan !');
				// window.location.href='../../dashboard.php?m=wo';
				// </script>";							
				$aktif = 'Y';
				$query = $connect->prepare("update saplikasi set nomohon=? where aktif=?");
				$query->bind_param('is',$sort_num,$aktif);	
				if($query->execute() and mysqli_affected_rows($connect)>0){
				}										
				?>
				<script>
					swal({title: "Data Berhasil disimpan ", text: "", icon: 
					"success"}).then(function(){window.location.href='../../dashboard.php?m=permohonan_keluar_uang';
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
					"error"}).then(function(){window.location.href='../../dashboard.php?m=permohonan_keluar_uang';
					   }
					);
				</script>
				<?php
			}		
		}else{
			?>
			<script>
				swal({title: "No. Permohonan masih kosong !", text: "", icon: 
				"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=tbsupplier';
				   }
				);
			</script>
			<?php
		}
	 	function autoNumber($connect,$id, $table){
			//$query = 'SELECT MAX(RIGHT('.$id.', 4)) as max_id FROM '.$table.' ORDER BY '.$id;
			mysqli_query($connect,'alter table mohklruangh AUTO_INCREMENT=0');
			$query = 'select id as max_id from '.$table.' order by id desc';
			$result = mysqli_query($connect,$query);
			$data = mysqli_fetch_array($result);
			$id_max = $data['max_id'];
			$sort_num = $id_max ;//(int) substr($id_max, 1, 4);
			$sort_num++;
			date_default_timezone_set("Asia/Jakarta");  
	    $tgl = date('m-d-Y');
			$year = date('Y');
			$month = date('M');
			$nmonth = date('m');
			$new_code = 'PK'.$year.$nmonth.sprintf("%05s", $sort_num);
			return $new_code;
		}
	?>
</body>