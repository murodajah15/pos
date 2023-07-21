<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		if(!empty($_POST['nokwitansi'])){
			//proses simpan
			include "../../inc/config.php";
			include "../../autonumber.php";
			date_default_timezone_set('Asia/Jakarta');
			$nokwitansi = autoNumberKK($connect,'id','kasir_keluarh'); //strip_tags($_POST['nokwitansi']);
			//Cek Double
			$cek = mysqli_num_rows(mysqli_query($connect,"select * from kasir_keluarh where nokwitansi='$nokwitansi'"));
			if ($cek > 0){
				echo "<script>alert('No sudah ada, data tidak bisa disimpan !');history.go(-1) </script>";
				exit();
			}
			$user_input = "Tambah-".$_POST['username']."-".date('d-m-Y H:i:s');
			$tglkwitansi = strip_tags($_POST['tglkwitansi']);
			$kdjnkeluar = strip_tags($_POST['kdjnkeluar']);
			$nmjnkeluar = strip_tags($_POST['nmjnkeluar']);
			$carabayar = strip_tags($_POST['carabayar']);
			$subtotal = strip_tags($_POST['subtotal']);
			$materai = strip_tags($_POST['materai']);
			$total = strip_tags($_POST['total']);
			$keterangan = strip_tags($_POST['keterangan']);
			$username = $_POST['username'];
			$carabayar = strip_tags($_POST['carabayar']);
			$kdbank = strip_tags($_POST['kdbank']);
			$nmbank = strip_tags($_POST['nmbank']);
			$kdjnskartu = strip_tags($_POST['kdjnskartu']);
			$nmjnskartu = strip_tags($_POST['nmjnskartu']);
			$norek = strip_tags($_POST['norek']);
			$nocekgiro = strip_tags($_POST['nocekgiro']);
			$tgljttempocekgiro = strip_tags($_POST['tgljttempocekgiro']);

			$query = $connect->prepare("INSERT INTO kasir_keluarh (nokwitansi,tglkwitansi,kdjnkeluar,nmjnkeluar,carabayar,kdbank,nmbank,kdjnskartu,nmjnskartu,norek,nocekgiro,tgljttempocekgiro,subtotal,materai,total,user_input,user) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
			 $query->bind_param('sssssssssssssssss',$nokwitansi,$tglkwitansi,$kdjnkeluar,$nmjnkeluar,$carabayar,$kdbank,$nmbank,$kdjnskartu,$nmjnskartu,$norek,$nocekgiro,$tgljttempocekgiro,$subtotal,$materai,$total,$username,$user_input);	
			if($query->execute() and mysqli_affected_rows($connect)>0){
				// echo "<script>alert('Data berhasil disimpan !');
				// window.location.href='../../dashboard.php?m=wo';
				// </script>";							
				$aktif = 'Y';
				$query = $connect->prepare("update saplikasi set nokwkeluar=? where aktif=?");
				$query->bind_param('is',$sort_num,$aktif);	
				if($query->execute() and mysqli_affected_rows($connect)>0){
				}										
				?>
				<script>
					swal({title: "Data Berhasil disimpan ", text: "", icon: 
					"success"}).then(function(){window.location.href='../../dashboard.php?m=kasir_keluar';
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
					"error"}).then(function(){window.location.href='../../dashboard.php?m=kasir_keluar';
					   }
					);
				</script>
				<?php
			}		
		}else{
			?>
			<script>
				swal({title: "No. Kwitansi masih kosong !", text: "", icon: 
				"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=tbsupplier';
				   }
				);
			</script>
			<?php
		}
	?>
</body>