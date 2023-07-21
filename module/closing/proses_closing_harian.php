<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
   	<?php
			include "../../inc/config.php";
			$aktif = 'Y';
			//$tgl_closing = $_GET['id'];
			$username = $_GET['username'];
			//echo $username;
			$tgl_closing = date('y-m-d');
			$tgl_berikutnya = $_GET['id'];
			$tgl_berikutnya = date("Y-m-d", strtotime($tgl_berikutnya));
			$qry = mysqli_query($connect,"select * from saplikasi where aktif='Y'");
			$data = mysqli_fetch_assoc($qry);
			$periodeclose = $data['closing_hpp'];
			$periodedata = date("Y", strtotime($tgl_berikutnya)).date("m", strtotime($tgl_berikutnya));
			echo $periodeclose;
			if ($periodedata<$periodeclose){
				?>
				<script>
					swal({title: "Bulan dan tahun tanggal berikutnya tidak boleh lebih kecil terakhir closing Bulanan ", text: "", icon: 
					"error"}).then(function(){window.location.href='../../dashboard.php?m=closing_harian';
					   }
					);
				</script>
				<?php
				exit;
			}
			$query = $connect->prepare("update saplikasi set tgl_closing=?,tgl_berikutnya=?,user_closing=? where aktif=?");
			$query->bind_param('ssss',$tgl_closing,$tgl_berikutnya,$username,$aktif);				
			if($query->execute()){ //and mysqli_affected_rows($connect)>0
				// echo "<script>alert('Data berhasil disimpan !');
				// window.location.href='../../dashboard.php?m=wo';
				// </script>";
				if ($_GET['resetnomor']=='on') {
					$bulan = substr('0'.$_GET['bulan'],-2);
					$tahun = $_GET['tahun'];
					mysqli_query($connect,"update saplikasi set bulan='$bulan',tahun='$tahun',noso='0',nojual='0',nopo='0',nobeli='0',nokeluar='0',noterima='0',noopname='0',noapprov='0',nokwtunai='0',nokwtagihan='0',nomohon='0',nokwkeluar='0' where aktif='Y'" );
				}
				?>
				<script>
					swal({title: "Closing Harian Berhasil1 ", text: "", icon: 
					"success"}).then(function(){window.location.href='../../dashboard.php?m=closing_harian';
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
					swal({title: "Closing harian Gagal ", text: "", icon: 
					"error"}).then(function(){window.location.href='../../dashboard.php?m=closing_harian';
					   }
					);
				</script>
				<?php
			}		
	?>
</body>
