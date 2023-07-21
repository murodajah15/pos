<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "../../inc/config.php";
		if(!empty($_POST['nokwitansi'])){
		//proses simpan
			date_default_timezone_set('Asia/Jakarta');
			//Cek Double
			$cek = mysqli_num_rows(mysqli_query($connect,"select * from kasir_tagihan where nokwitansi='$_POST[nokwitansi]' and id<>'$_POST[id]'"));
			if ($cek > 0){
				echo "<script>alert('Kode tersebut sudah digunakan');history.go(-1) </script>";
				exit();
			}
				// $user = "Update-".$_POST['username']."-".date('d-m-Y H:i:s');
				// mysqli_query($connect,"update wo set kode='$_POST[kode]',nama='$_POST[nama]',aktif='$_POST[aktif]',user='$user' where id='$_POST[id]'");
				// header("location:../../dashboard.php?m=wo");
				$user_input = "Tambah-".$_POST['username']."-".date('d-m-Y H:i:s');
				$nokwitansi = strip_tags($_POST['nokwitansi']);
				$tglkwitansi = strip_tags($_POST['tglkwitansi']);
				$jnskwitansi = strip_tags($_POST['jnskwitansi']);
				// $nojual = strip_tags($_POST['nojual']);
				// $kdcustomer = strip_tags($_POST['kdcustomer']);
				$nmcustomer = strip_tags($_POST['nmcustomer']);
				// $materai = $_POST['materai'];
				// $subtotal = $_POST['subtotal'];
				// $total = $_POST['total'];
				// $carabayar = strip_tags($_POST['carabayar']);
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
				
				// $query = $connect->prepare("update kasir_tagihan set nokwitansi=?,tglkwitansi=?,jnskwitansi=?,nojual=?,kdcustomer=?,materai=?,subtotal=?,total=?,carabayar=?,kdbank=?,nmbank=?,kdjnskartu=?,nmjnskartu=?,norek=?,nocekgiro=?,tglterimacekgiro=?,tgljttempocekgiro=?,keterangan=?,user=?,nmcustomer=?,user_input=? where id=?");
				// $query->bind_param('sssssssssssssssssssssi',$nokwitansi,$tglkwitansi,$jnskwitansi,$nojual,$kdcustomer,$materai,$subtotal,$total,$carabayar,$kdbank,$nmbank,$kdjnskartu,$nmjnskartu,$norek,$nocekgiro,$tglterimacekgiro,$tgljttempocekgiro,$keterangan,$user_input,$nmcustomer,$username,$_POST['id']);

				$query = $connect->prepare("update kasir_tagihan set nokwitansi=?,tglkwitansi=?,jnskwitansi=?,carabayar=?,kdbank=?,nmbank=?,kdjnskartu=?,nmjnskartu=?,norek=?,nocekgiro=?,tglterimacekgiro=?,tgljttempocekgiro=?,keterangan=?,user=?,nmcustomer=?,user_input=? where id=?");
				$query->bind_param('sssssssssssssssss',$nokwitansi,$tglkwitansi,$jnskwitansi,$carabayar,$kdbank,$nmbank,$kdjnskartu,$nmjnskartu,$norek,$nocekgiro,$tglterimacekgiro,$tgljttempocekgiro,$keterangan,$user_input,$nmcustomer,$username,$_POST['id']);
				if($query->execute() and mysqli_affected_rows($connect)>0){
					// echo "<script>alert('Data berhasil disimpan !');
					// window.location.href='../../dashboard.php?m=wo';
					// </script>";													
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

