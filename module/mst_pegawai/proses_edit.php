<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "../../inc/config.php";
		if(!empty($_POST['nip'])){
			//proses simpan
			date_default_timezone_set('Asia/Jakarta');
			//Cek Double
			$cek = mysqli_num_rows(mysqli_query($connect,"select * from mst_pegawai where (nip='$_POST[nip]' and id<>'$_POST[id]') or (norek='$_POST[norek]' and id<>'$_POST[id]')"));
			if ($cek > 0){
				/*echo "<script>alert('NIP dan Nomor rekening tersebut sudah digunakan');history.go(-1) </script>";**/
				?>
				<script>
					swal({title: "Gagal simpan data!", text: "NIP dan Nomor rekening tersebut sudah digunakan", icon: 
					"error"}).then(function(){window.history.go(-1);
					   }
					);
				</script>
				<?php
				exit();
			}
			$user = "Update-".$_POST['username']."-".date('d-m-Y H:i:s');
			// if ($_POST['kdgrade']=="") {
				// $nmgrade = "";
			// }else{
				// $nmgrade = $_POST['nmgrade'];
			// }
			if ($_POST['golongan']=="") {
				$pangkat = "";
			}else{
				$pangkat = $_POST['pangkat'];
			}			
			if ($_POST['norek']=="") {
				$kdbank = "";
				$bank = "";
				$nama 	= "";
			}else{
				$sql=mysqli_query($connect,"select * from mst_rekening where norek='$_POST[norek]'");
				$de=mysqli_fetch_assoc($sql);		
				$kdbank = $de['kdbank'];
				$bank = $de['bank'];
				$nama = $de['nama'];
			}
			if ($_POST['kelas_jabatan']=="") {
				$tukin = 0;
			}else{
				$sql=mysqli_query($connect,"select * from tbkelas_jabatan where kelas='$_POST[kelas_jabatan]'");
				$de=mysqli_fetch_assoc($sql);
				$tukin = $de['tukin'];
			}
			if ($_POST['kdeselon']=="") {
				$nmeselon = "";
			}else{
				$sql = mysqli_query($connect,"select * from tbeselon where kode='$_POST[kdeselon]'");
				$cek=mysqli_fetch_assoc($sql);
				$nmeselon = $cek['nama'];
			}
			if ($_POST['kdsatker']=="") {
				$nmsatker = "";
			}else{
				$cek = mysqli_fetch_assoc(mysqli_query($connect,"select * from tbsatker where kode='$_POST[kdsatker]'"));
				$nmsatker = $cek['nama'];
			}

			/* Input Rekening ke Master Rekening **/
			$cek = mysqli_num_rows(mysqli_query($connect,"select * from mst_rekening where norek='$_POST[norek]'"));
			if ($cek > 0){
				/*Gak usah update deh
				mysqli_query($connect,"update mst_rekening set norek='$_POST[norek],nama='$_POST[nama]',kdbank='$_POST[kdbank'],
				bank='$_POST[bank]' where norek='$_POST[norek]");**/
			}else{
				mysqli_query($connect,"insert into mst_rekening (norek,nama,kdbank,bank,aktif,user,user_input) values 
				('$_POST[norek]','$_POST[nama]','$_POST[kdbank]','$_POST[bank]','Y','$user','$_POST[kdese_kdsat]')");
			}
			/*---------**/
			/*Masukan nilai prosentase pajak**/
			$kdgol=explode('/',$_POST['golongan'],2);
			//echo $kdgol[0];
			if ($kdgol[0]=='IV') {
				$pr_pot_pajak = 15;
			}elseif ($kdgol[0]=='III') { 
				$pr_pot_pajak = 5;
			}else{
				$pr_pot_pajak = 0;
			}
			/*---------**/
			
			// mysqli_query($connect,"update mst_pegawai set nip='$_POST[nip]',npwp='$_POST[npwp]',
			// status='$_POST[status]',nama_alias='$_POST[nama_alias]',golongan='$_POST[golongan]',
			// pangkat='$pangkat',jabatan='$_POST[jabatan]',norek='$_POST[norek]',nama='$nama',kdbank='$kdbank',bank='$bank',
			// aktif='$_POST[aktif]',user='$user',kelas_jabatan='$_POST[kelas_jabatan]',tukin='$tukin',kdeselon='$_POST[kdeselon]',nmeselon='$nmeselon',
			// kdsatker='$_POST[kdsatker]',nmsatker='$nmsatker',user_input='$_POST[kdese_kdsat]',pr_pot_pajak='$pr_pot_pajak' where id='$_POST[id]'");
			// header("location:../../dashboard.php?m=mst_pegawai");

			$user_input = "Tambah-".$_POST['username']."-".date('d-m-Y H:i:s');
			$nip = strip_tags($_POST['nip']);
			$nama_alias = strip_tags($_POST['nama_alias']);
			$npwp = strip_tags($_POST['npwp']);
			$status = strip_tags($_POST['status']);
			$golongan = strip_tags($_POST['golongan']);
			$pangkat = strip_tags($_POST['pangkat']);
			$jabatan = strip_tags($_POST['jabatan']);
			$norek = strip_tags($_POST['norek']);
			$nama = strip_tags($_POST['nama']);
			$kdbank = strip_tags($_POST['kdbank']);
			$bank = strip_tags($_POST['bank']);
			$aktif = strip_tags($_POST['aktif']);
			$user = strip_tags($user);
			$kelas_jabatan = strip_tags($_POST['kelas_jabatan']);
			$kdeselon = strip_tags($_POST['kdeselon']);
			$nmeselon = strip_tags($nmeselon);
			$kdsatker = strip_tags($_POST['kdsatker']);
			$nmsatker = strip_tags($nmsatker);
			$user_input = strip_tags($_POST['kdese_kdsat']);

			$query = $connect->prepare("update mst_pegawai set nip=?,npwp=?,status=?,nama_alias=?,golongan=?,pangkat=?,jabatan=?,norek=?,nama=?,kdbank=?,bank=?,aktif=?,user=?,kelas_jabatan=?,tukin=?,kdeselon=?,nmeselon=?,kdsatker=?,nmsatker=?,user_input=?,pr_pot_pajak=? where id=?");
			$query->bind_param('ssssssssssssssisssssii',$nip,$npwp,$status,$nama_alias,$golongan,$pangkat,$jabatan,$norek,$nama,$kdbank,$bank,$aktif,$user,$kelas_jabatan,$tukin,$kdeselon,$nmeselon,$kdsatker,$nmsatker,$user_input,$pr_pot_pajak,$_POST['id']);
			if($query->execute() and mysqli_affected_rows($connect)>0) {
				// echo "<script>alert('Data berhasil disimpan !');
				// window.location.href='../../dashboard.php?m=mst_pegawai';
				// </script>";							
				?>
				<script>
					swal({title: "Data Berhasil disimpan ", text: "", icon: 
					"success"}).then(function(){window.history.go(-2); //window.location.href='../../dashboard.php?m=mst_pegawai';
					   }
					);
				</script>
				<?php
			}else{
				// echo "<script>alert('Gagal simpan data !');
				// window.location.href='../../dashboard.php?m=mst_pegawai';
				// </script>";							
				?>
				<script>
					swal({title: "Gagal simpan data ", text: "", icon: 
					"error"}).then(function(){window.history.go(-2); //window.location.href='../../dashboard.php?m=mst_pegawai';
					   }
					);
				</script>
				<?php
			}				
		}else{
			header("location:../../dashboard.php?m=mst_pegawai");
		}
	?>
</body>
