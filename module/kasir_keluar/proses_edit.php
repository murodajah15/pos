<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "../../inc/config.php";
		if(!empty($_POST['nokwitansi'])){
		//proses simpan
			date_default_timezone_set('Asia/Jakarta');
			//Cek Double
			$cek = mysqli_num_rows(mysqli_query($connect,"select * from kasir_keluarh where nokwitansi='$_POST[nokwitansi]' and id<>'$_POST[id]'"));
			if ($cek > 0){
				echo "<script>alert('Kode tersebut sudah digunakan');history.go(-1) </script>";
				exit();
			}
			$user_input = "Update-".$_POST['username']."-".date('d-m-Y H:i:s');
			$nokwitansi = strip_tags($_POST['nokwitansi']);
			$tglkwitansi = strip_tags($_POST['tglkwitansi']);
			$kdjnkeluar = strip_tags($_POST['kdjnkeluar']);
			$nmjnkeluar = strip_tags($_POST['nmjnkeluar']);	
			$carabayar = strip_tags($_POST['carabayar']);	
			$subtotal = strip_tags($_POST['subtotal']);
			$materai = strip_tags($_POST['materai']);
			$total = strip_tags($_POST['total']);
			$keterangan = strip_tags($_POST['keterangan']);		
			$nsubtotal=hit_total($connect,$nokwitansi);
			$ntotal = $nsubtotal + $materai;
			$username = $_POST['username'];
			$carabayar = strip_tags($_POST['carabayar']);
			$kdbank = strip_tags($_POST['kdbank']);
			$nmbank = strip_tags($_POST['nmbank']);
			$kdjnskartu = strip_tags($_POST['kdjnskartu']);
			$nmjnskartu = strip_tags($_POST['nmjnskartu']);
			$norek = strip_tags($_POST['norek']);
			$nocekgiro = strip_tags($_POST['nocekgiro']);
			$tgljttempocekgiro = strip_tags($_POST['tgljttempocekgiro']);

			$query = $connect->prepare("update kasir_keluarh set nokwitansi=?,tglkwitansi=?,kdjnkeluar=?,nmjnkeluar=?,carabayar=?,kdbank=?,nmbank=?,kdjnskartu=?,nmjnskartu=?,norek=?,nocekgiro=?,tgljttempocekgiro=?,subtotal=?,materai=?,total=?,user=?,user_input=? where id=?");
			$query->bind_param('ssssssssssssssssss',$nokwitansi,$tglkwitansi,$kdjnkeluar,$nmjnkeluar,$carabayar,$kdbank,$nmbank,$kdjnskartu,$nmjnskartu,$norek,$nocekgiro,$tgljttempocekgiro,$subtotal,$materai,$ntotal,$user_input,$username,$_POST['id']);				
			if($query->execute() and mysqli_affected_rows($connect)>0){
				// echo "<script>alert('Data berhasil disimpan !');
				// window.location.href='../../dashboard.php?m=wo';
				// </script>";													
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
			header("location:../../dashboard.php?m=kasir_keluar");
		}
	?>

	<?php
	//pembuatan fungsi
	function hit_total($connect,$nokwitansi)
	{
		global $nsubtotal;
		include "../../inc/config.php";
		$tampil = mysqli_query($connect,"select sum(uang) as nsubtotal from kasir_keluard where nokwitansi='$nokwitansi'");
		$de = mysqli_fetch_assoc($tampil);
		$nsubtotal = $de['nsubtotal'];
		//$nppn = $nsubtotal * ($ppn/100);
		//$ntotal = $nsubtotal - $nppn;
		return $nsubtotal;
	}
	?>

</body>

