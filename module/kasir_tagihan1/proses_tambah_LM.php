<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		if(!empty($_POST['nokwitansi'])){
			//proses simpan
			include "../../inc/config.php";
			include "../../autonumber.php";
			date_default_timezone_set('Asia/Jakarta');
			$nokwitansi = autoNumberKWT($connect,'id','kasir_tagihan'); //strip_tags($_POST['nokwitansi']);
			//Cek Double
			$cek = mysqli_num_rows(mysqli_query($connect,"select * from kasir_tagihan where nokwitansi='$nokwitansi'"));
			if ($cek > 0){
				echo "<script>alert('No sudah ada, data tidak bisa disimpan !');history.go(-1) </script>";
				exit();
			}
			$user_input = "Tambah-".$_POST['username']."-".date('d-m-Y H:i:s');
			$tglkwitansi = strip_tags($_POST['tglkwitansi']);
			$jnskwitansi = strip_tags($_POST['jnskwitansi']);
			$nojual = strip_tags($_POST['nojual']);
			$kdcustomer = strip_tags($_POST['kdcustomer']);
			$nmcustomer = strip_tags($_POST['nmcustomer']);
			$piutang = $_POST['piutang'];
			$bayar = $_POST['bayar'];
			$uang = $_POST['uang'];
			$kembali = $_POST['kembali'];
			$carabayar = strip_tags($_POST['carabayar']);
			$kdbank = strip_tags($_POST['kdbank']);
			$nmbank = strip_tags($_POST['nmbank']);
			$kdjnskartu = strip_tags($_POST['kdjnskartu']);
			$nmjnskartu = strip_tags($_POST['nmjnskartu']);
			$norek = strip_tags($_POST['norek']);
			$nocekgiro = strip_tags($_POST['nocekgiro']);
			$tglterimacekgiro = strip_tags($_POST['tglterimacekgiro']);
			$tgljttempocekgiro = strip_tags($_POST['tgljttempocekgiro']);
			$keterangan = strip_tags($_POST['keterangan']);
			$username = $_POST['username'];

			if ($bayar > $piutang) {
				echo "<script>alert('Nilai bayar tidak boleh melebihi nilai piutang !, data tidak bisa disimpan !');history.go(-1) </script>";
				exit();
			}
			
			$query = $connect->prepare("INSERT INTO kasir_tagihan (nokwitansi,tglkwitansi,jnskwitansi,nojual,kdcustomer,piutang,bayar,uang,kembali,carabayar,kdbank,nmbank,kdjnskartu,nmjnskartu,norek,nocekgiro,tglterimacekgiro,tgljttempocekgiro,keterangan,user,nmcustomer,user_input) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
			 $query->bind_param('sssssiiiisssssssssssss',$nokwitansi,$tglkwitansi,$jnskwitansi,$nojual,$kdcustomer,$piutang,$bayar,$uang,$kembali,$carabayar,$kdbank,$nmbank,$kdjnskartu,$nmjnskartu,$norek,$nocekgiro,$tglterimacekgiro,$tgljttempocekgiro,$keterangan,$user_input,$nmcustomer,$username);	
			// $query = $connect->prepare("INSERT INTO kasir_tagihan (nokwitansi,tglkwitansi,jnskwitansi,nojual,kdcustomer,piutang) values (?,?,?,?,?,?)");
			// $query->bind_param('sssssi',$nokwitansi,$tglkwitansi,$jnskwitansi,$nojual,$kdcustomer,$piutang);
			if($query->execute() and mysqli_affected_rows($connect)>0){
				// echo "<script>alert('Data berhasil disimpan !');
				// window.location.href='../../dashboard.php?m=wo';
				// </script>";							
				$aktif = 'Y';
				$query = $connect->prepare("update saplikasi set nokwtagihan=? where aktif=?");
				$query->bind_param('is',$sort_num,$aktif);	
				if($query->execute() and mysqli_affected_rows($connect)>0){
				}										
				?>
				<script>
					swal({title: "Data Berhasil disimpan ", text: "", icon: 
					"success"}).then(function(){window.location.href='../../dashboard.php?m=kasir_tagihan';
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
					"error"}).then(function(){window.location.href='../../dashboard.php?m=kasir_tagihan';
					   }
					);
				</script>
				<?php
			}		
		}else{
			header("location:../../dashboard.php?m=kasir_tagihan");
		}
	?>
</body>