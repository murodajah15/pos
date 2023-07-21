<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "../../inc/config.php";
		if(!empty($_POST['nomohon'])){
		//proses simpan
			date_default_timezone_set('Asia/Jakarta');
			//Cek Double
			$cek = mysqli_num_rows(mysqli_query($connect,"select * from mohklruangh where nomohon='$_POST[nomohon]' and id<>'$_POST[id]'"));
			if ($cek > 0){
				echo "<script>alert('Kode tersebut sudah digunakan');history.go(-1) </script>";
				exit();
			}
				// $user = "Update-".$_POST['username']."-".date('d-m-Y H:i:s');
				// mysqli_query($connect,"update wo set kode='$_POST[kode]',nama='$_POST[nama]',aktif='$_POST[aktif]',user='$user' where id='$_POST[id]'");
				// header("location:../../dashboard.php?m=wo");
				$user_input = "Update-".$_POST['username']."-".date('d-m-Y H:i:s');
				$nomohon = strip_tags($_POST['nomohon']);
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
				$nsubtotal=hit_total($connect,$nomohon);
				$keterangan = strip_tags($_POST['keterangan']);
				$total = $nsubtotal + $materai;
				$query = $connect->prepare("update mohklruangh set nomohon=?,tglmohon=?,kdjnkeluar=?,nmjnkeluar=?,carabayar=?,kdbank=?,nmbank=?,kdjnskartu=?,nmjnskartu=?,norek=?,nocekgiro=?,tgljttempocekgiro=?,materai=?,total=?,keterangan=?,user=? where id=?");
				$query->bind_param('ssssssssssssiissi',$nomohon,$tglmohon,$kdjnkeluar,$nmjnkeluar,$carabayar,$kdbank,$nmbank,$kdjnskartu,$nmjnskartu,$norek,$nocekgiro,$tgljttempocekgiro,$materai,$total,$keterangan,$user_input,$_POST['id']);				
				if($query->execute() and mysqli_affected_rows($connect)>0){
					// echo "<script>alert('Data berhasil disimpan !');
					// window.location.href='../../dashboard.php?m=wo';
					// </script>";													
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
			header("location:../../dashboard.php?m=po");
		}
	?>

	<?php
	//pembuatan fungsi
	function hit_total($connect,$nomohon)
	{
		global $nsubtotal;
		include "../../inc/config.php";
		$tampil = mysqli_query($connect,"select sum(uang) as nsubtotal from mohklruangd where nomohon='$nomohon'");
		$de = mysqli_fetch_assoc($tampil);
		$nsubtotal = $de['nsubtotal'];
		//$nppn = $nsubtotal * ($ppn/100);
		//$ntotal = $nsubtotal - $nppn;
		return $nsubtotal;
	}
	?>

</body>

