<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		if(!empty($_POST['nip'])){
			//proses simpan
			include "../../inc/config.php";
			date_default_timezone_set('Asia/Jakarta');
			/*Cek Double**/
			$cek = mysqli_num_rows(mysqli_query($connect,"select * from mst_pegawai where nip='$_POST[nip]' or norek='$_POST[norek]'"));
			if ($cek > 0){
				/*echo "<script>alert('Pegawai/Norek sudah ada, data tidak bisa disimpan !');history.go(-1) </script>";**/
				?>
				<script>
					swal({title: "Gagal simpan data", text: "Pegawai/Norek sudah ada", icon: 
					"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=mst_pegawai';
					   }
					);
				</script>
				<?php
				exit();
			}
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
			// if ($_POST['kelas_jabatan']=="") {
				// $tukin = 0;
			// }else{
				// $sql=mysqli_query($connect,"select * from tbkelas_jabatan where kelas='$_POST[kelas_jabatan]'");
				// $de=mysqli_fetch_assoc($sql);
				// $tukin = $de[tukin];
			// }
				$kdbank = "";
				$bank = "";
				$nama 	= "";			
			if ($_POST['norek']=="") {
				$kdbank = "";
				$bank = "";
				$nama 	= "";
			}else{
				$kdbank = $_POST['kdbank'];
				$bank = $_POST['bank'];
				$nama = $_POST['nama'];
			}
			if ($_POST['kdeselon']=="") {
				$nmeselon = "";
			}else{
				$cek = mysqli_fetch_assoc(mysqli_query($connect,"select * from tbeselon where kode='$_POST[kdeselon]'"));
				$nmeselon = $cek['nama'];
			}
			if ($_POST['kdsatker']=="") {
				$nmsatker = "";
			}else{
				$cek = mysqli_fetch_assoc(mysqli_query($connect,"select * from tbsatker where kode='$_POST[kdsatker]'"));
				$nmsatker = $cek['nama'];
			}
			if ($_POST['kelas_jabatan']=="") {
				$kelas_jabatan = '';
				$a = '0';
				$tukin = (int)$a;
			}else{
				$array_kelas_jabatan = explode("|",$_POST['kelas_jabatan']);
				$kelas_jabatan = $array_kelas_jabatan[0];
				$tukin = $array_kelas_jabatan[1];
			}

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
			$user = "Tambah-".$_POST['username']."-".date('d-m-Y H:i:s');

			// $cek = mysqli_num_rows(mysqli_query($connect,"select * from mst_rekening where norek='$_POST[norek]'"));
			// if ($cek > 0){
			// 	/*.Gak usah update deh
			// 	mysqli_query($connect,"update mst_rekening set norek='$_POST[norek],nama='$_POST[nama]',kdbank='$_POST[kdbank'],
			// 	bank='$_POST[bank]' where norek='$_POST[norek]");**/
			// }else{
				// mysqli_query($connect,"insert into mst_rekening (norek,nama,kdbank,bank,aktif,user,user_input) values 
				// ('$_POST[norek]','$_POST[nama]','$_POST[kdbank]','$bank','Y','$user','$_POST[kdese_kdsat]')");
			// }
			// $sql = "insert into mst_pegawai (nip,nama_alias,npwp,status,golongan,pangkat,jabatan,
			// norek,nama,kdbank,bank,aktif,user,kelas_jabatan,tukin,kdeselon,nmeselon,kdsatker,nmsatker,user_input,pr_pot_pajak) values 
			// ('$_POST[nip]','$_POST[nama_alias]','$_POST[npwp]','$_POST[status]',
			// '$_POST[golongan]','$pangkat','$_POST[jabatan]','$_POST[norek]','$nama',
			// '$kdbank','$bank','$_POST[aktif]','$user','$kelas_jabatan','$tukin','$_POST[kdeselon]',
			// '$nmeselon','$_POST[kdsatker]','$nmsatker','$_POST[kdese_kdsat]','$pr_pot_pajak')";
			// $query = mysqli_query($connect,$sql);
			// if($query){
			// 	header("location:../../dashboard.php?m=mst_pegawai");
			// }else{
			// 	// /*echo "<script>alert('Gagal Simpan Data !');history.go(-1);</script>";**/
			// }
			/* Insert Rekening Otomatis **/
			$cek = $connect->prepare("select * from mst_rekening where norek=?");
			$cek->bind_param('s',$_POST['norek']);
			$result = $cek->execute();
			$cek->store_result();
			if ($cek->num_rows <= "0") {
				$query = $connect->prepare("INSERT INTO mst_rekening (norek,nama,kdbank,bank,aktif,user,user_input) values (?,?,?,?,?,?,?)");
				$query->bind_param('sssssss',$_POST['norek'],$_POST['nama'],$_POST['kdbank'],$bank,'Y',$user,$_POST['kdese_kdsat']);
				if($query->execute() and mysqli_affected_rows($connect)>0){

				}else{
					echo "<script>alert('Gagal update rekening!')</alert>";
				}
			}

			$query = $connect->prepare("select * from mst_pegawai where nip=?");
			$query->bind_param('s',$_POST['nip']);
			$result = $query->execute();
			$query->store_result();
			if ($query->num_rows >= "1") {
				?>
				<script>
					swal({title: "Gagal simpan data", text: "NIP tersebut sudah digunakan", icon: 
					"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=mst_pegawai';
					   }
					);
				</script>
				<?php
				exit();
			}
		
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

			$query = $connect->prepare("INSERT INTO mst_pegawai (nip,nama_alias,npwp,status,golongan,pangkat,jabatan,
			norek,nama,kdbank,bank,aktif,user,kelas_jabatan,tukin,kdeselon,nmeselon,kdsatker,nmsatker,user_input,pr_pot_pajak) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
			$query->bind_param('ssssssssssssssissssss',$nip,$nama_alias,$npwp,$status,$golongan,$pangkat,$jabatan,$norek,$nama,$kdbank,$bank,$aktif,$user,$kelas_jabatan,$tukin,$kdeselon,$nmeselon,$kdsatker,$nmsatker,$user_input,$pr_pot_pajak);
			if($query->execute() and mysqli_affected_rows($connect)>0){
				// echo "<script>alert('Data berhasil disimpan !');
				// window.location.href='../../dashboard.php?m=mst_pegawai';
				// </script>";							
				?>
				<script>
					swal({title: "Data Berhasil disimpan ", text: "", icon: 
					"success"}).then(function(){window.location.href='../../dashboard.php?m=mst_pegawai';
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
					"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=mst_pegawai';
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