<?php
	$user = $_SESSION['username'];
  if(isset($_GET['tipe'])){
    if($_GET['tipe']=='import'){
			cekakses($connect,$user,'Tabel Customer');
			$lakses = $_SESSION['aksestambah'];
			if ($lakses == 1) {?>
				<font face='calibri'>
				<div class="panel panel-success">
				<div class="panel-heading"><font size="4">IMPORT DATA TABEL CUSTOMER</font></div>
				<div class="panel-body">
				<form method='post' enctype='multipart/form-data' action='module/tbcustomer/proses_import.php'>
				<input type='hidden' name='username' value='<?= $user ?>'>
				Pilih File Excel*: 
				<input name='fileexcel' type='file' accept='application/vnd.ms-excel'></br> <!--<input name='upload' type='submit' alue='Import'>-->
				<button type='submit' class='btn btn-primary' name='upload' value='import'>Import</button>
				<input button type='Button' class='btn btn-danger' value='Selesai' onClick='history.back()'/>
	       </div></div>
	       </form></font>
		     <?php
			}else{
				echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
			}
		}
	}

  if(isset($_GET['tipe'])){
    if($_GET['tipe']=='export'){
			cekakses($connect,$user,'Tabel Customer');
			$lakses = $_SESSION['aksescetak'];
			if ($lakses == 1) {?>
				<font face='calibri'>
				<div class="panel panel-default">
				<div class="panel-heading"><font size="4">EXPORT DATA TABEL CUSTOMER</font></div>
				<div class="panel-body">
				<form method='post' enctype='multipart/form-data' action='module/tbcustomer/proses_export.php'>
				<input type='hidden' name='username' value='<?= $user ?>'>
				Type : <select name=typefile class='form-control' required>
						<option value='Excel'> Excel</option>
													<option value='CSV'> CSV</option>
													<option value='PDF'> PDF</option>
												</select><br>
				<button type='submit' class='btn btn-primary' name='upload' value='export'>Export</button>
				<input button type='Button' class='btn btn-danger' value='Selesai' onClick='history.back()'/>
				</div></div>
        </form></font>
      <?php
			}else{
				echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
			}
		}
	}

  if(isset($_GET['tipe'])){
    if($_GET['tipe']=='detail'){
			cekakses($connect,$user,'Tabel Customer');
			$lakses = $_SESSION['aksespakai'];
			if ($lakses == 1) {	
				$query = $connect->prepare("select * from tbcustomer where id=?");
				$query->bind_param('i',$_GET['id']);
				$result = $query->execute();
				$query->store_result();
				$query->execute();
				$result = $query->get_result();
				$de = $result->fetch_assoc();
				$kode = strip_tags($de['kode']);
				$kelompok = strip_tags($de['kelompok']);
				$nama = strip_tags($de['nama']);
				$alamat = strip_tags($de['alamat']);
				$kota = strip_tags($de['kota']);
				$kodepos = strip_tags($de['kodepos']);
				$telp1 = strip_tags($de['telp1']);
				$telp2 = strip_tags($de['telp2']);
				$agama = strip_tags($de['agama']);
				$tgl_lahir = strip_tags($de['tgl_lahir']);
				$alamat_ktr = strip_tags($de['alamat_ktr']);
				$kota_ktr = strip_tags($de['kota_ktr']);
				$kodepos_ktr = strip_tags($de['kodepos_ktr']);
				$telp1_ktr = strip_tags($de['telp1_ktr']);
				$telp2_ktr = strip_tags($de['telp2_ktr']);
				$npwp = strip_tags($de['npwp']);
				$alamat_npwp = strip_tags($de['alamat_npwp']);
				$nama_npwp = strip_tags($de['nama_npwp']);
				$alamat_ktp = strip_tags($de['alamat_ktp']);
				$kota_ktp = strip_tags($de['kota_ktp']);
				$kodepos_ktp = strip_tags($de['kodepos_ktp']);
				$tgl_register = date('Y-m-d');
				$mak_piutang = strip_tags($de['mak_piutang']);
				?>
				<font face="calibri">
					<div class="panel panel-warning">
					<div class="panel-heading"><font size="4">DETAIL DATA TABEL CUSTOMER</font></div>
					<div class="panel-body">
					<form method="post" enctype="multipart/form-data">
						<input type="hidden" name="username" value="<?= $user ?>">
						<input type="hidden" name="id" value="<?= $de["id"] ?>">
						<div class='col-md-6'>
						<table style=font-size:13px; class="table table-striped table table-bordered">
	          <tr><td>Kode</td> <td> <input type='text' class='form-control' name='kode' value='<?= $kode ?>' size='10' required readonly></td></tr>
 						<tr><td>Kelompok</td><td>
						<?php
							echo "<select readonly name='kelompok' class='form-control'>";
							$kelompok=array('Mr.','Ms.','Mrs.','Company');
							$jml_kata=count($kelompok);
							for($c=0; $c<$jml_kata; $c+=1){
								if ($kelompok[$c]==$de[kelompok]){
									echo "<option value=$kelompok[$c] selected>$kelompok[$c] </option>";
								}else{
									echo "<option value=$kelompok[$c]> $kelompok[$c] </option>";
								}
							}						
							echo "</select>";
						?>
	          <tr><td>Nama</td> <td> <input type='text' class='form-control' name='nama' id='nama' value='<?= $nama ?>' autofocus='autofocus' required readonly></td></tr>
	          <tr><td>Alamat</td> <td> <textarea rows='3' class='form-control' name='alamat' id='alamat' readonly><?= $alamat ?></textarea></td></tr>
	          <tr><td>Kota</td> <td> <input type='text' class='form-control' name='kota' id='kota' value='<?= $kota ?>' readonly></td></tr>
	          <tr><td>Kode Pos</td> <td> <input type='text' class='form-control' name='kodepos' id='kodepos' value='<?= $kodepos ?>' readonly></td></tr>
	          <tr><td>Telp</td> <td> <input type='text' class='form-control' name='telp1' value='<?= $telp1 ?>' readonly></td></tr>
	          <tr><td><td> <input type='text' class='form-control' name='telp2' value='<?= $telp2 ?>' readonly></td></tr>
 						<tr><td>Agama<td><select readonly id='agama' name='agama' class='form-control' style='width: 200x;'>
						<!--<option value=''> - PILIH AGAMA - </option>";-->
						<?php
						$data = mysqli_query($connect,'select * from tbagama');
						while ($row=mysqli_fetch_array($data))
						{
							if ($row['nama']==$de['agama']) {
								echo "<option value=$row[nama] selected>$row[nama]</option>";
							}else{
								echo '<option name="nama"  value="'.$row['nama'].'">'.$row['nama'].'</option>';
							}
						}
						echo '</select>';
						?>
						<tr><td>Tanggal Lahir (M-D-Y)</td> <td> <input type='date' class='form-control' name='tgl_lahir' value='<?= $tgl_lahir ?>' readonly></td></tr>
	          <tr><td>Alamat KTP</td> <td> <textarea rows='3' class='form-control' name='alamat_ktp' id='alamat_ktp' readonly><?= $alamat_ktp ?></textarea></td></tr>
	          <tr><td>Kota KTP</td> <td> <input type='text' class='form-control' name='kota_ktp' id='kota_ktp' value='<?= $kota_ktp ?>' readonly></td></tr>
	          <tr><td>Kode Pos KPT</td> <td> <input type='text' class='form-control' name='kodepos_ktp' id='kodepos_ktp' value='<?= $kodepos_ktp ?>' readonly></td></tr>
					</table>
				</div>
				<div class='col-md-6'>
	        <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
	          <tr><td>Alamat Kantor</td> <td> <textarea rows='3' class='form-control' name='alamat_ktr' id='alamat_ktr' readonly><?= $alamat_ktr ?></textarea></td></tr>
	          <tr><td>Kota Kantor</td> <td> <input type='text' class='form-control' name='kota_ktr' id='kota_ktr' value='<?= $kota_ktr ?>' readonly></td></tr>
	          <tr><td>Kode Pos Kantor</td> <td> <input type='text' class='form-control' name='kodepos_ktr' id='kodepos_ktr' value='<?= $kodepos_ktr ?>' readonly></td></tr>
	          <tr><td>Telp Kantor</td> <td> <input type='text' class='form-control' name='telp1_ktr' value='<?= $telp1_ktr ?>' readonly></td></tr>
	          <tr><td><td> <input type='text' class='form-control' name='telp2_ktr' value='<?= $telp2_ktr ?>' readonly></td></tr>
	          <tr><td>NPWP</td> <td> <input type='text' class='form-control' name='npwp' value='<?= $npwp ?>' readonly></td></tr>
	          <tr><td>Nama NPWP</td> <td> <input type='text' class='form-control' name='nama_npwp' id='nama_npwp' value='<?= $nama_npwp ?>' readonly></td></tr>
	          <tr><td>Alamat NPWP</td> <td> <textarea rows='3' class='form-control' name='alamat_npwp' id='alamat_npwp' readonly><?= $alamat_npwp ?></textarea></td></tr>
	          <tr><td>Maksimum Piutang</td> <td> <input type='number' class='form-control' name='mak_piutang' value='<?= $mak_piutang ?>'required readonly></td></tr>
						<tr><td>Tanggal Register (M-D-Y)</td> <td> <input type='date' class='form-control' name='tgl_register' value='<?= $tgl_register ?>' readonly></td></tr>
					</table>
				</div>
				<div class='col-md-12'>
					<input button type='Button' class='btn btn-danger' value='Close' onClick="window.location.href='?m=tbcustomer'"/>
				</div>
				</div></div></form></font>
			<?php }else{
				echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
			}
		}
	}
	
  if(isset($_GET['tipe'])){
    if($_GET['tipe']=='tambah'){
      cekakses($connect,$user,'Tabel Customer');
      $lakses = $_SESSION['aksestambah'];
      if ($lakses == 1) {?>
        <font face='calibri'>
        <div class='panel panel-danger'>
        <div class='panel-heading'><font size="4">TAMBAH DATA TABEL CUSTOMER</font></div>
        <div class='panel-body'>
        <form method='post' name='tbcustomer' enctype='multipart/form-data' action='module/tbcustomer/proses_tambah.php'>
				<input type='hidden' name='username' value="<?= $user ?>">
				<div class='col-md-6'>
	        <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
	          <tr><td>Kode</td> <td> <input type='text' class='form-control' name='kode' size='10' autofocus='autofocus' required></td></tr>
 						<tr><td>Kelompok<td><select required id='kelompok' name='kelompok' class='form-control' style='width: 200x;'>
						<option value='Mr.'>Mr.</option>
						<option value='Ms.'>Ms.</option>
						<option value='Mrs.'>Mrs.</option>
						<option value='Mrs.'>Company</option>
						</select>
	          <tr><td>Nama</td> <td> <input type='text' class='form-control' name='nama' id='nama' required></td></tr>
	          <tr><td>Alamat</td> <td> <textarea rows='3' class='form-control' name='alamat' id='alamat' ></textarea></td></tr>
	          <tr><td>Kota</td> <td> <input type='text' class='form-control' name='kota' id='kota'></td></tr>
	          <tr><td>Kode Pos</td> <td> <input type='text' class='form-control' name='kodepos' id='kodepos'></td></tr>
	          <tr><td>Telp</td> <td> <input type='text' class='form-control' name='telp1' ></td></tr>
	          <tr><td><td> <input type='text' class='form-control' name='telp2' ></td></tr>
 						<tr><td>Agama<td><select id='agama' name='agama' class='form-control' style='width: 200x;'>
						<!--<option value=''> - PILIH AGAMA - </option>";-->
						<?php
						$data = mysqli_query($connect,'select * from tbagama');
						while ($row=mysqli_fetch_array($data))
						{
							echo '<option name="nama"  value="'.$row['nama'].'">'.$row['nama'].'</option>';
						}
						echo '</select>';
						?>
						<tr><td>Tanggal Lahir (M-D-Y)</td> <td> <input type='date' class='form-control' name='tgl_lahir' ></td></tr>
	          <tr><td>Alamat KTP<br><input button type='Button' class='btn btn-success' value='Salin' onClick='salin_alamat_ktp()'/></td> <td> <textarea rows='3' class='form-control' name='alamat_ktp' id='alamat_ktp'></textarea></td></tr>
	          <tr><td>Kota KTP</td> <td> <input type='text' class='form-control' name='kota_ktp' id='kota_ktp' ></td></tr>
	          <tr><td>Kode Pos KPT</td> <td> <input type='text' class='form-control' name='kodepos_ktp' id='kodepos_ktp' ></td></tr>
	          </table>
				</div>
				<div class='col-md-6'>
	        <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
	          <tr><td>Alamat Kantor<br><input button type='Button' class='btn btn-success' value='Salin' onClick='salin_alamat_ktr()'/></td> <td> <textarea rows='3' class='form-control' name='alamat_ktr' id='alamat_ktr'></textarea></td></tr>
	          <tr><td>Kota Kantor</td> <td> <input type='text' class='form-control' name='kota_ktr' id='kota_ktr'></td></tr>
	          <tr><td>Kode Pos Kantor</td> <td> <input type='text' class='form-control' name='kodepos_ktr' id='kodepos_ktr'></td></tr>
	          <tr><td>Telp Kantor</td> <td> <input type='text' class='form-control' name='telp1_ktr'></td></tr>
	          <tr><td><td> <input type='text' class='form-control' name='telp2_ktr' ></td></tr>
	          <tr><td>NPWP</td> <td> <input type='text' class='form-control' name='npwp' ></td></tr>
	          <tr><td>Nama NPWP<br><input button type='Button' class='btn btn-success' value='Salin' onClick='salin_alamat_npwp()'/></td> <td> <input type='text' class='form-control' name='nama_npwp' id='nama_npwp'></td></tr>
	          <tr><td>Alamat NPWP</td> <td> <textarea rows='3' class='form-control' name='alamat_npwp' id='alamat_npwp'></textarea></td></tr>
	          <tr><td>Maksimum Piutang</td> <td> <input type='number' class='form-control' name='mak_piutang'></td></tr>
					</table>
				</div>
				<div class='col-md-12'>
					<button type='submit' class='btn btn-success'>Simpan</button>
	        <input button type='Button' class='btn btn-danger' value='Batal' onClick='history.back()'/>
	      </div>
        </div></div></form></font>
        <?php 
      }else{
      echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
      }

    }elseif($_GET['tipe']=='edit'){
			cekakses($connect,$user,'Tabel Customer');
			$lakses = $_SESSION['aksesedit'];
			if ($lakses == 1) {	
				$query = $connect->prepare("select * from tbcustomer where id=?");
				$query->bind_param('i',$_GET['id']);
				$query->execute();
				$result = $query->get_result();
				$de = $result->fetch_assoc();
				$kode = strip_tags($de['kode']);
				$kelompok = strip_tags($de['kelompok']);
				$nama = strip_tags($de['nama']);
				$alamat = strip_tags($de['alamat']);
				$kota = strip_tags($de['kota']);
				$kodepos = strip_tags($de['kodepos']);
				$telp1 = strip_tags($de['telp1']);
				$telp2 = strip_tags($de['telp2']);
				$agama = strip_tags($de['agama']);
				$tgl_lahir = strip_tags($de['tgl_lahir']);
				$alamat_ktr = strip_tags($de['alamat_ktr']);
				$kota_ktr = strip_tags($de['kota_ktr']);
				$kodepos_ktr = strip_tags($de['kodepos_ktr']);
				$telp1_ktr = strip_tags($de['telp1_ktr']);
				$telp2_ktr = strip_tags($de['telp2_ktr']);
				$npwp = strip_tags($de['npwp']);
				$alamat_npwp = strip_tags($de['alamat_npwp']);
				$nama_npwp = strip_tags($de['nama_npwp']);
				$alamat_ktp = strip_tags($de['alamat_ktp']);
				$kota_ktp = strip_tags($de['kota_ktp']);
				$kodepos_ktp = strip_tags($de['kodepos_ktp']);
				$tgl_register = date('Y-m-d');
				$mak_piutang = strip_tags($de['mak_piutang']);
				?>
				<font face="calibri">
					<div class="panel panel-warning">
					<div class="panel-heading"><font size="4">EDIT DATA TABEL CUSTOMER</font></div>
					<div class="panel-body">
					<form method="post" enctype="multipart/form-data" action="module/tbcustomer/proses_edit.php">
						<input type="hidden" name="username" value="<?= $user ?>">
						<input type="hidden" name="id" value="<?= $de["id"] ?>">
						<div class='col-md-6'>
						<table style=font-size:13px; class="table table-striped table table-bordered">
	          <tr><td>Kode</td> <td> <input type='text' class='form-control' name='kode' value='<?= $kode ?>' size='10' required readonly></td></tr>
 						<tr><td>Kelompok</td><td>
						<?php
							echo "<select name='kelompok' class='form-control'>";
							$kelompok=array('Mr.','Ms.','Mrs.','Company');
							$jml_kata=count($kelompok);
							for($c=0; $c<$jml_kata; $c+=1){
								if ($kelompok[$c]==$de[kelompok]){
									echo "<option value=$kelompok[$c] selected>$kelompok[$c] </option>";
								}else{
									echo "<option value=$kelompok[$c]> $kelompok[$c] </option>";
								}
							}						
							echo "</select>";
						?>
	          <tr><td>Nama</td> <td> <input type='text' class='form-control' name='nama' id='nama' value='<?= $nama ?>' autofocus='autofocus' required></td></tr>
	          <tr><td>Alamat</td> <td> <textarea rows='3' class='form-control' name='alamat' id='alamat' ><?= $alamat ?></textarea></td></tr>
	          <tr><td>Kota</td> <td> <input type='text' class='form-control' name='kota' id='kota' value='<?= $kota ?>'></td></tr>
	          <tr><td>Kode Pos</td> <td> <input type='text' class='form-control' name='kodepos' id='kodepos' value='<?= $kodepos ?>'></td></tr>
	          <tr><td>Telp</td> <td> <input type='text' class='form-control' name='telp1' value='<?= $telp1 ?>'></td></tr>
	          <tr><td><td> <input type='text' class='form-control' name='telp2' value='<?= $telp2 ?>'></td></tr>
 						<tr><td>Agama<td><select id='agama' name='agama' class='form-control' style='width: 200x;'>
						<!--<option value=''> - PILIH AGAMA - </option>";-->
						<?php
						$data = mysqli_query($connect,'select * from tbagama');
						while ($row=mysqli_fetch_array($data))
						{
							if ($row['nama']==$de['agama']) {
								echo "<option value=$row[nama] selected>$row[nama]</option>";
							}else{
								echo '<option name="nama"  value="'.$row['nama'].'">'.$row['nama'].'</option>';
							}
						}
						echo '</select>';
						?>
						<tr><td>Tanggal Lahir (M-D-Y)</td> <td> <input type='date' class='form-control' name='tgl_lahir' value='<?= $tgl_lahir ?>'></td></tr>
					</table>
				</div>
				<div class='col-md-6'>
	        <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
	          <tr><td>Alamat KTP<br><input button type='Button' class='btn btn-success' value='Salin' onClick='salin_alamat_ktp()'/></td> <td> <textarea rows='3' class='form-control' name='alamat_ktp' id='alamat_ktp'><?= $alamat_ktp ?></textarea></td></tr>
	          <tr><td>Kota KTP</td> <td> <input type='text' class='form-control' name='kota_ktp' id='kota_ktp' value='<?= $kota_ktp ?>'></td></tr>
	          <tr><td>Kode Pos KPT</td> <td> <input type='text' class='form-control' name='kodepos_ktp' id='kodepos_ktp' value='<?= $kodepos_ktp ?>'></td></tr>
	          <tr><td>Alamat Kantor<br><input button type='Button' class='btn btn-success' value='Salin' onClick='salin_alamat_ktr()'/></td> <td> <textarea rows='3' class='form-control' name='alamat_ktr' id='alamat_ktr'><?= $alamat_ktr ?></textarea></td></tr>
	          <tr><td>Kota Kantor</td> <td> <input type='text' class='form-control' name='kota_ktr' id='kota_ktr' value='<?= $kota_ktr ?>'></td></tr>
	          <tr><td>Kode Pos Kantor</td> <td> <input type='text' class='form-control' name='kodepos_ktr' id='kodepos_ktr' value='<?= $kodepos_ktr ?>'></td></tr>
	          <tr><td>Telp Kantor</td> <td> <input type='text' class='form-control' name='telp1_ktr' value='<?= $telp1_ktr ?>'></td></tr>
	          <tr><td><td> <input type='text' class='form-control' name='telp2_ktr' value='<?= $telp2_ktr ?>'></td></tr>
	          <tr><td>NPWP</td> <td> <input type='text' class='form-control' name='npwp' value='<?= $npwp ?>'></td></tr>
	          <tr><td>Nama NPWP<br><input button type='Button' class='btn btn-success' value='Salin' onClick='salin_alamat_npwp()'/></td> <td> <input type='text' class='form-control' name='nama_npwp' id='nama_npwp' value='<?= $nama_npwp ?>'></td></tr>
	          <tr><td>Alamat NPWP</td> <td> <textarea rows='3' class='form-control' name='alamat_npwp' id='alamat_npwp'><?= $alamat_npwp ?></textarea></td></tr>
	          <tr><td>Maksimum Piutang</td> <td> <input type='number' class='form-control' name='mak_piutang' value='<?= $mak_piutang ?>'></td></tr>
					</table>
				</div>
						<div class='col-md-12'>
							<button type="submit" class="btn btn-primary">Simpan</button>
							<input button type="Button" class="btn btn-danger" value="Batal" onClick="history.back()"/>
						</div>
					</div></div></form></font>
			<?php 
			}else{
				echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
			}
  	}
	}else{

	?>
	<?php
		include 'cek_akses.php';
		if ($aksesok == 'Y') {
	?>
	<font face="calibri">
	  <div class="panel panel-info">
	    <div class="panel-heading"><font size="4">TABEL CUSTOMER</font></div>
	    <div class="panel-body">
		 	<form method='get'>
				<div class="row">
					<?php
						include('hal_get.php')
					?>
					<div class="col-md-4 bg">
						<input type="hidden" name="m" value="tbcustomer">
						<input type='text' id='kata' name='kata' value="<?= $kata ?>" size='50px' class='form-control' placeholder='KODE,NAMA,ALAMAT,TELPON'  onkeyup='searchTable()'>
					</div>
					<button type='submit' class='btn btn-primary'>
					<span class='glyphicon glyphicon-search'></span> Cari</button>
					<a class="btn btn-danger" href="?m=tbcustomer&tipe=tambah">Tambah data</a>
					<a class="btn btn-success" href="?m=tbcustomer&tipe=import">Import data</a>
					<a class="btn btn-warning" href="?m=tbcustomer&tipe=export">Export data</a>
				</div>
			</form>
	    </br>
	<!--<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover" cellspacing="0" width="100%">-->
	<div class="box-body table-responsive">
		<table id="example1" class="table table-bordered table-striped">
		<tbody>
		<tr>
			<th width='50'>No.</th>
			<th width='90'>Kode</th>
			<th width='200'>Nama</th>
			<th width='200'>Alamat</th>
			<th width='80'>Telpon 1</th>
			<th width='80'>Telpon 2</th>
			<th width='180'>Aksi</th>
		</tr>
		<?php
			// Cek apakah terdapat data page pada URL
			$page = (isset($_GET['page']) ? $_GET['page'] : 1);
			if (isset($_GET['record'])){
				$_SESSION['jmlperhalaman']=$_GET['record'];
				$limit = $_GET['record']; //5; // Jumlah data per halamannya**/
			}else{
				$limit = $_SESSION['jmlperhalaman'];
			}
			$limit_start = ($page - 1) * $limit;
			// Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database
			if (empty($_GET['kata'])){
				$tampil = mysqli_query($connect,"SELECT * FROM tbcustomer order by kode desc LIMIT ".$limit_start.",".$limit);
				}
			else{
				$cari = $_GET['kata'];
				$tampil = mysqli_query($connect,"SELECT * FROM tbcustomer WHERE (kode like '%$cari%' or nama like '%$cari%' or alamat like '%$cari%'or telp1 like '%$cari%'or telp2 like '%$cari%') order by kode  desc LIMIT ".$limit_start.",".$limit);
			}
			if ($page==1) {
				$posisi=0;
				$_GET['halaman']=1;
			}
			else{
				$posisi = ($_GET['page']-1) * $limit;
			}
			$no=$posisi+1;
			while($k=mysqli_fetch_assoc($tampil)){
				echo "<tr>
					<td align='center'>$no</td>
					<td><u><a href='?m=tbcustomer&tipe=detail&id=$k[id]'><font color='blue'>$k[kode]</font></a></u></td>
					<td>$k[nama]</td>
					<td>$k[alamat]</td>
					<td>$k[telp1]</td>
					<td>$k[telp2]</td>
					<td align='center' width='120px'>
						<a class='btn btn-info' href='?m=tbcustomer&tipe=edit&id=$k[id]'>Edit</a>";
						cekakses($connect,$user,'Tabel Customer');
						$lakses = $_SESSION['akseshapus'];
						if ($lakses == 1) {
							//echo " <a class='btn btn-danger' href='module/tbcustomer/proses_hapus.php?id=$k[id]&kode=$k[kode]'
							//onClick='return confirm(\"Anda yakin akan menghapus ?\")'>Hapus</a>";
							echo " <input button type='Button' class='btn btn-danger' value='Hapus' onClick='alert_hapus($k[id])'/>";
						}else{
							echo " <input button type='Button' class='btn btn-danger' value='Hapus' onClick='alert_hapus($k[id])' disabled/>";
						}
					echo "</td>";
				$no++;
			}
		?>
	</tbody>
		</table>
		<?php
			if (empty($_GET['kata'])){
				$query = mysqli_query($connect,"select count(*) as jumrec from tbcustomer");
			}else{
				$cari = $_GET['kata'];
				$query = mysqli_query($connect,"select count(*) as jumrec from tbcustomer where (kode like '%$cari%' or nama like '%$cari%')");
			}
			$result = mysqli_fetch_array($query);
			echo "<p style='text-align:left'>Jumlah Record : ".number_format($result['jumrec'],0,",",".");
		?>
		</div>
		<ul class="pagination">
			<!-- LINK FIRST AND PREV -->
			<?php
				if($page == 1){ // Jika page adalah page ke 1, maka disable link PREV
			?>
			<li class="disabled"><a href="#">First</a></li>
			<li class="disabled"><a href="#">&laquo;</a></li>
			<?php
			}else{ // Jika page bukan page ke 1
			  $link_prev = ($page > 1)? $page - 1 : 1;
			?>
			  <li><a href="dashboard.php?m=tbcustomer&kata=<?= $kata ?>&page=1">First</a></li>
			  <li><a href="dashboard.php?m=tbcustomer&kata=<?= $kata ?>&page=<?php echo $link_prev; ?>">&laquo;</a></li>
			<?php
			}
			?>
			<!-- LINK NUMBER -->
			<?php
			// Buat query untuk menghitung semua jumlah data
			if (empty($_GET['kata'])){
				$tampil = mysqli_query($connect,"SELECT * FROM tbcustomer order by kode desc ");
				}
			else{
				$cari = $_GET['kata'];
				$tampil = mysqli_query($connect,"SELECT * FROM tbcustomer WHERE (kode like '%$cari%' or nama like '%$cari%' or alamat like '%$cari%' or telp1 like '%$cari%' or telp2 like '%$cari%') order by kode desc ");
			}
			$get_jumlah = mysqli_num_rows($tampil);
			//echo $get_jumlah;			
			/*$jumlah_page = ceil($get_jumlah['jumlah'] / $limit); // Hitung jumlah halamannya**/
			$jumlah_page = ceil($get_jumlah/$limit);
			$jumlah_number = 2; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
			$start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1; // Untuk awal link number
			$end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page; // Untuk akhir link number
			
			for($i = $start_number; $i <= $end_number; $i++){
			  $link_active = ($page == $i)? ' class="active"' : '';
			?>
			  <li<?php echo $link_active; ?>><a href="dashboard.php?m=tbcustomer&kata=<?= $kata ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
			<?php
			}
			?>
			
			<!-- LINK NEXT AND LAST -->
			<?php
			// Jika page sama dengan jumlah page, maka disable link NEXT nya
			// Artinya page tersebut adalah page terakhir 
			if($page == $jumlah_page){ // Jika page terakhir
				?>
				  <li class="disabled"><a href="#">&raquo;</a></li>
				  <li class="disabled"><a href="#">Last</a></li>
				<?php
			}else{ // Jika Bukan page terakhir
			  $link_next = ($page < $jumlah_page)? $page + 1 : $jumlah_page;
				?>
			  <li><a href="dashboard.php?m=tbcustomer&kata=<?= $kata ?>&page=<?php echo $link_next; ?>">&raquo;</a></li>
			  <li><a href="dashboard.php?m=tbcustomer&kata=<?= $kata ?>&page=<?php echo $jumlah_page; ?>">Last</a></li>
			<?php
			}
			?>
		</ul>
	</div>	
	<?php
	}else{
	echo "<font color='red'>Anda tidak punya hak !</font>";
	}?>
	<?php
		}
?>

<?php
	function konversitext($field){
		echo htmlentities($field,ENT_QUOTES);
	}
?>

<script>
    function alert_hapus($id){
        swal({
          title: "Yakin akan dihapus ?",
          text: "Once deleted, you will not be able to recover this data!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
          	//alert($kode);
          	$href = "module/tbcustomer/proses_hapus.php?id=";
          	window.location.href = $href+$id;
            // swal("Poof! Your imaginary file has been deleted!", {
            //   icon: "success",
            // });
          } else {
            //swal("Batal Hapus!");
          }
        });
    };  

    function salin_alamat_ktr(){
    	document.getElementById('alamat_ktr').value = document.getElementById('alamat').value
    	document.getElementById('kota_ktr').value = document.getElementById('kota').value
    	document.getElementById('kodepos_ktr').value = document.getElementById('kodepos').value
    }
    function salin_alamat_ktp(){
    	document.getElementById('alamat_ktp').value = document.getElementById('alamat').value
    	document.getElementById('kota_ktp').value = document.getElementById('kota').value
    	document.getElementById('kodepos_ktp').value = document.getElementById('kodepos').value
    }    
    function salin_alamat_npwp(){
    	document.getElementById('nama_npwp').value = document.getElementById('nama').value
    	document.getElementById('alamat_npwp').value = document.getElementById('alamat').value +' '+document.getElementById('kota').value +' '+ document.getElementById('kodepos').value
    }    
</script>