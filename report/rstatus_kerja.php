<?php
	$user = $_SESSION['username'];
    if(isset($_GET['tipe'])){
        if($_GET['tipe']=='export'){
			cekakses($connect,$user,'Laporan Status Kerjak');
			$lakses = $_SESSION['aksescetak'];
			if ($lakses == 1) {?>
				<font face='calibri'>
                <h3>Export Data Status Kerja</h3>
                <form method='post' enctype='multipart/form-data' action='report/proses_export_status_kerja.php'>
				<input type='hidden' name='username' value='<?= $user ?>'>
				Type : <select name=typefile class='form-control' required>
													<option value='Excel'> Excel</option>
													<option value='CSV'> CSV</option>
													<option value='PDF'> PDF</option>
												</select><br>
				<label>&nbsp;</label>
							<button type='submit' class='btn btn-primary' name='upload' value='export'>Export</button>
							<input button type='Button' class='btn btn-danger' value='Selesai' onClick='history.back()'/>
                </form></font>
                <?php
			}else{
				echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
			}
		}
	}

	if(isset($_GET['tipe'])){
        if($_GET['tipe']=='mulai'){
			cekakses($connect,$user,'Laporan Status Kerja');
			$lakses = $_SESSION['aksespakai'];
			if ($lakses == 1) {	
				date_default_timezone_set("Asia/Jakarta");  
				$tgl = date('Y-m-d');
				$query = $connect->prepare("select * from status_wo where id=?");
				$query->bind_param('i',$_GET['id']);
				$result = $query->execute();
				$query->store_result();
				$query->execute();
				$result = $query->get_result();
				$de = $result->fetch_assoc();
				$nowo = htmlspecialchars($de['nowo']);
				$kdmekanik = htmlspecialchars($de['kdmekanik']);
				$mekanik = $kdmekanik.'|'.htmlspecialchars($de['nmmekanik']);
				$kdstatus = htmlspecialchars($de['kdstatus']);
				$status = $kdstatus.'|'.htmlspecialchars($de['nmstatus']);
				if (strip_tags($de['tglmulai'])=='0000-00-00') {
					//$tglmulai = date("m-d-Y", strtotime($de['tglmulai']));
					$tglmulai = date('Y-m-d');
					$jammulai = date("H:i");
				}else{
					$tglmulai = strip_tags($de['tglmulai']);
					$jammulai = $de['jammulai'];
				}
				if ($de['tglselesai']=='0000-00-00') {
					$tglselesai = $de['tglselesai'];
				}else{
					$tglselesai = date("m-d-Y", strtotime($de['tglselesai']));
				}
				$jamselesai = $de['jamselesai'];
				$keterangan = htmlspecialchars($de['keterangan']);
				$tgmulai = $tglmulai.' '.$jammulai;
				$tgselesai = $tglselesai.' '.$jamselesai;
				?>
				<font face='calibri'>
				<div class='panel panel-default'>
                <div class='panel-heading'>
				<h4>Update Mulai Status Kerja</h4></div>
                <div class='panel-body'>
					<form method='post' enctype='multipart/form-data' action='report/proses_mulai.php'>
						<input type='hidden' name='username' value="<?= $user ?>">
						<input type='hidden' name='id' value="<?= $de['id'] ?>"/>
						<table style=font-size:13px; class='table table-striped table table-bordered'>
							<tr><td>No. WO</td> <td>  <input type='text' class='form-control' name='nowo' value="<?= $nowo ?>" readonly></td></tr>
							<tr><td>Mekanik </td> <td>  <input type='text' class='form-control' name='kdmekanik' value="<?= $mekanik ?>" readonly></td></tr>
							<tr><td>Status Kerja </td> <td>  <input type='text' class='form-control' name='kdmekanik' value="<?= $status ?>" readonly></td></tr>
						<tr><td>Tgl. Mulai (M/D/Y)</td><td><input type='date' class='form-control' id='tglmulai' name='tglmulai' value="<?php echo $tglmulai ?>" size='50' autocomplete='off' required></td></tr>
						<tr><td>Jam Mulai</td><td><input type="time" class='form-control' id='jammulai' name='jammulai' value='<?= $jammulai ?>' style='text-transform:uppercase' ></td></tr>
						</table>
						<label>&nbsp;</label>
						<button type='submit' class='btn btn-primary'>Simpan</button>
						<input button type='Button' class='btn btn-danger' value='Batal' onClick='history.back()'/>
				</div></div></form></font>
			<?php }else{
				echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
			}
		}
	}

	if(isset($_GET['tipe'])){
        if($_GET['tipe']=='selesai'){
			cekakses($connect,$user,'Laporan Status Kerja');
			$lakses = $_SESSION['aksespakai'];
			if ($lakses == 1) {	
				date_default_timezone_set("Asia/Jakarta");  
				$tgl = date('Y-m-d');
				$query = $connect->prepare("select * from status_wo where id=?");
				$query->bind_param('i',$_GET['id']);
				$result = $query->execute();
				$query->store_result();
				$query->execute();
				$result = $query->get_result();
				$de = $result->fetch_assoc();
				$nowo = htmlspecialchars($de['nowo']);
				$kdmekanik = htmlspecialchars($de['kdmekanik']);
				$mekanik = $kdmekanik.'|'.htmlspecialchars($de['nmmekanik']);
				$kdstatus = htmlspecialchars($de['kdstatus']);
				$status = $kdstatus.'|'.htmlspecialchars($de['nmstatus']);
				if (strip_tags($de['tglmulai'])=='0000-00-00') {
					//$tglmulai = date("m-d-Y", strtotime($de['tglmulai']));
					$tglmulai = date('Y-m-d');
					$jammulai = date("H:i");
				}else{
					$tglmulai = strip_tags($de['tglmulai']);
					$jammulai = $de['jammulai'];
				}
				if (strip_tags($de['tglselesai'])=='0000-00-00') {
					$tglselesai = $de['tglselesai'];
					$jamselesai = date("H:i");
				}else{
					$tglselesai = date("m-d-Y", strtotime($de['tglselesai']));
					$jamselesai = $de['jamselesai'];
				}
				$keterangan = htmlspecialchars($de['keterangan']);
				$tgmulai = $tglmulai.' '.$jammulai;
				$tgselesai = $tglselesai.' '.$jamselesai;
				?>
				<font face='calibri'>
				<div class='panel panel-default'>
                <div class='panel-heading'>
				<h4>Update Selesai Status Kerja</h4></div>
                <div class='panel-body'>
					<form method='post' enctype='multipart/form-data' action='report/proses_selesai.php'>
						<input type='hidden' name='username' value="<?= $user ?>">
						<input type='hidden' name='id' value="<?= $de['id'] ?>"/>
						<table style=font-size:13px; class='table table-striped table table-bordered'>
							<tr><td>No. WO</td> <td>  <input type='text' class='form-control' name='nowo' value="<?= $nowo ?>" readonly></td></tr>
							<tr><td>Mekanik </td> <td>  <input type='text' class='form-control' name='kdmekanik' value="<?= $mekanik ?>" readonly></td></tr>
							<tr><td>Status Kerja </td> <td>  <input type='text' class='form-control' name='kdmekanik' value="<?= $status ?>" readonly></td></tr>
						<tr><td>Tgl. Selesai (M/D/Y)</td><td><input type='date' class='form-control' id='tglselesai' name='tglselesai' value="<?php echo $tglmulai ?>" size='50' autocomplete='off' required></td></tr>
						<tr><td>Jam Selesai</td><td><input type="time" class='form-control' id='jamselesai' name='jamselesai' value='<?= $jamselesai ?>' style='text-transform:uppercase' ></td></tr>
						</table>
						<label>&nbsp;</label>
						<button type='submit' class='btn btn-primary'>Simpan</button>
						<input button type='Button' class='btn btn-danger' value='Batal' onClick='history.back()'/>
				</div></div></form></font>
			<?php }else{
				echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
			}
		}
	}

    if(isset($_GET['tipe'])){
        if($_GET['tipe']=='detail'){
			cekakses($connect,$user,'Laporan Status Kerja');
			$lakses = $_SESSION['aksespakai'];
			if ($lakses == 1) {	
				$query = $connect->prepare("select * from status_wo where id=?");
				$query->bind_param('i',$_GET['id']);
				$result = $query->execute();
				$query->store_result();
				$query->execute();
				$result = $query->get_result();
				$de = $result->fetch_assoc();
				$nowo = htmlspecialchars($de['nowo']);
				$kdmekanik = htmlspecialchars($de['kdmekanik']);
				$mekanik = $kdmekanik.'|'.htmlspecialchars($de['nmmekanik']);
				$kdstatus = htmlspecialchars($de['kdstatus']);
				$status = $kdstatus.'|'.htmlspecialchars($de['nmstatus']);
				if ($de['tglmulai']=='0000-00-00') {
					$tglmulai = $de['tglmulai'];
				}else{
					$tglmulai = date("m-d-Y", strtotime($de['tglmulai']));;
				}
				$jammulai = $de['jammulai'];
				if ($de['tglselesai']=='0000-00-00') {
					$tglselesai = $de['tglselesai'];
				}else{
					$tglselesai = date("m-d-Y", strtotime($de['tglselesai']));
				}
				$jamselesai = $de['jamselesai'];
				$keterangan = htmlspecialchars($de['keterangan']);
				$tgmulai = $tglmulai.' '.$jammulai;
				$tgselesai = $tglselesai.' '.$jamselesai;
				$user = $de['user'];
				?>
				<font face='calibri'>
				<div class='panel panel-default'>
                <div class='panel-heading'>
				<h4>Detail Status Kerja WO</h4></div>
                <div class='panel-body'>
					<form method='post' enctype='multipart/form-data'>
						<input type='hidden' name='username' value="<?= $user ?>">
						<input type='hidden' name='id' value="<?= $de['id'] ?>"/>
						<table style=font-size:13px; class='table table-striped table table-bordered'>
							<tr><td>No. WO</td> <td>  <input type='text' class='form-control' name='nowo' value="<?= $nowo ?>" readonly></td></tr>
							<tr><td>Mekanik </td> <td>  <input type='text' class='form-control' name='kdmekanik' value="<?= $mekanik ?>" readonly></td></tr>
							<tr><td>Status Kerja </td> <td>  <input type='text' class='form-control' name='kdmekanik' value="<?= $status ?>" readonly></td></tr>
							<tr><td>Tgl. Mulai </td> <td>  <input type='text' class='form-control' name='kdmekanik' value="<?= $tgmulai ?>" readonly></td></tr>
							<tr><td>Tgl. Selesai </td> <td>  <input type='text' class='form-control' name='kdmekanik' value="<?= $tgselesai ?>" readonly></td></tr>
							<tr><td>Keterangan </td> <td>  <input type='text' class='form-control' name='kdmekanik' value="<?= $keterangan ?>" readonly></td></tr>
							<tr><td>User</td> <td>  <input type='text' class='form-control' name='user' value="<?= $user ?>" readonly></td></tr>
						</table>
						<label>&nbsp;</label>
								<input button type='Button' class='btn btn-danger' value='Close' onClick="window.location.href='?m=rstatus_kerja'"/>
				</div></div></form></font>
			<?php }else{
				echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
			}
		}
	}else{?>

		<font face="calibri">
		 <h3>Outstanding Work Order Berdasarkan Status Kerja</h3>
			<hr size="10px">
		<form method='post'>
		<div class="row">	 
			<div class="col-md-12 bg">
			<!--<button type='submit' name='kata2' class='btn btn-primary'>
			<span class='glyphicon glyphicon-search'></span> Cari</button>-->
			<a class="btn btn-warning" href="?m=rstatus_kerja&tipe=export">Export data</a>
			</div>
		</div>
		</form>
		<br>

		<!--<div class="table-responsive">
		<table class="table table-bordered table-striped table-hover" cellspacing="0" width="100%">-->
		<div class="box-body table-responsive">
			<table id="example1" class="table table-bordered table-striped">

			<!--<table id="example" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">-->
			<thead>
			    <tr>
			    	<th width='50'>No.</th>
			    	<th width='70'>No. WO</th>
			        <th width='70'>Mekanik</th>
			        <th>Nama Mekanik</th>
					<th>Status Kerja</th>
					<th>Tanggal Mulai</th>
					<th>Jam Mulai</th>
					<th>Tanggal Selesai</th>
					<th>Jam Selesai</th>
					<th>Aksi</th>
			    </tr>
			</thead>
			<?php
				$tampil = mysqli_query($connect,"select wo.nowo,wo.tglwo,status_wo.* from wo inner join status_wo on wo.nowo=status_wo.nowo where wo.proses='N'");
				// $query = $connect->prepare("select * from status_wo where nowo=?");
				// $query->bind_param('s',$nowo);
				// $query->execute();
				// $result = $query->get_result();
				// $de = $result->fetch_assoc();
		        $no=1;
		        //<td><u><a href='?m=wo&tipe=detail&id=$k[id]'><font color='blue'>$k[kode]</font></a></u></td>
		        while($k=mysqli_fetch_assoc($tampil)){
		        	//$date = date("m/d/Y", strtotime($k['tglwo']));
		        	$status = $k['kdstatus'].'|'.$k['nmstatus'];
					if ($k['tglmulai']=='0000-00-00') {
						$tglmulai = $k['tglmulai'];
					}else{
						$tglmulai = date("m-d-Y", strtotime($k['tglmulai']));;
					}
					$jammulai = $k['jammulai'];
					if ($k['tglselesai']=='0000-00-00') {
						$tglselesai = $k['tglselesai'];
					}else{
						$tglselesai = date("m-d-Y", strtotime($k['tglselesai']));
					}
					$jamselesai = $k['jamselesai'];		        	
		            echo "<tr>
		                <td align='center'>$no</td>
		                <td><u><a href='?m=rstatus_kerja&tipe=detail&id=$k[id]'><font color='blue'>$k[nowo]</font></a></u></td>
						<td>$k[kdmekanik]</td>
						<td>$k[nmmekanik]</td>
						<td>$status</td>
						<td>$tglmulai</td>
						<td>$k[jammulai]</td>
						<td>$tglselesai</td>
						<td>$k[jamselesai]</td>
						<td align='center' width='130px'>
						<a class='btn btn-danger' href='?m=rstatus_kerja&tipe=mulai&id=$k[id]'>Mulai</a>
						<a class='btn btn-primary' href='?m=rstatus_kerja&tipe=selesai&id=$k[id]'>Selesai</a>";
					echo "</td>";
					$no++;
				}
			?>
			</table>
		</div>
	<?php }
?>

<?php
	function konversitext($field){
		echo htmlentities($field,ENT_QUOTES);
	}
?>

<script>
    function alert_hapus($kode){
        swal({
          title: "Yakin akan dihapus "+$kode+" ?",
          text: "Once deleted, you will not be able to recover this data!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
          	//alert($kode);
          	$href = "module/tbbank/proses_hapus.php?kode=";
          	window.location.href = $href+$kode;
            // swal("Poof! Your imaginary file has been deleted!", {
            //   icon: "success",
            // });
          } else {
            //swal("Batal Hapus!");
          }
        });
    };  
</script>