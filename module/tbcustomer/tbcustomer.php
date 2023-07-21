<?php
$user = $_SESSION['username'];
if (isset($_GET['tipe'])) {
	if ($_GET['tipe'] == 'import') {
		cekakses($connect, $user, 'Tabel Customer');
		$lakses = $_SESSION['aksestambah'];
		if ($lakses == 1) { ?>
			<font face='calibri'>
				<div class="panel panel-success">
					<div class="panel-heading">
						<font size="4">IMPORT DATA TABEL CUSTOMER</font>
					</div>
					<div class="panel-body">
						<form method='post' enctype='multipart/form-data' action='module/tbcustomer/proses_import.php'>
							<input type='hidden' name='username' value='<?= $user ?>'>
							Pilih File Excel*:
							<input name='fileexcel' type='file' accept='application/vnd.ms-excel'></br>
							<!--<input name='upload' type='submit' alue='Import'>-->
							<button type='submit' class='btn btn-primary' name='upload' value='import'>Import</button>
							<input button type='Button' class='btn btn-danger' value='Selesai' onClick='history.back()' />
					</div>
				</div>
				</form>
			</font>
		<?php
		} else {
			echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
		}
	}
}

if (isset($_GET['tipe'])) {
	if ($_GET['tipe'] == 'export') {
		cekakses($connect, $user, 'Tabel Customer');
		$lakses = $_SESSION['aksescetak'];
		if ($lakses == 1) { ?>
			<font face='calibri'>
				<div class="panel panel-default">
					<div class="panel-heading">
						<font size="4">EXPORT DATA TABEL CUSTOMER</font>
					</div>
					<div class="panel-body">
						<form method='post' enctype='multipart/form-data' action='module/tbcustomer/proses_export.php'>
							<input type='hidden' name='username' value='<?= $user ?>'>
							Type : <select name=typefile class='form-control' required>
								<option value='Excel'> Excel</option>
								<option value='CSV'> CSV</option>
								<option value='PDF'> PDF</option>
							</select><br>
							<button type='submit' class='btn btn-primary' name='upload' value='export'>Export</button>
							<input button type='Button' class='btn btn-danger' value='Selesai' onClick='history.back()' />
					</div>
				</div>
				</form>
			</font>
		<?php
		} else {
			echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
		}
	}
}

if (isset($_GET['tipe'])) {
	if ($_GET['tipe'] == 'detail') {
		cekakses($connect, $user, 'Tabel Customer');
		$lakses = $_SESSION['aksespakai'];
		if ($lakses == 1) {
			// $query = $connect->prepare("select * from tbcustomer where id=?");
			// $query->bind_param('i', $_GET['id']);
			// $result = $query->execute();
			// $query->store_result();
			// $query->execute();
			// $result = $query->get_result();
			// $de = $result->fetch_assoc();
			$sql = mysqli_query($connect, "select * from tbcustomer where id='$_GET[id]'");
			$de = mysqli_fetch_assoc($sql);
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
					<div class="panel-heading">
						<font size="4">DETAIL DATA TABEL CUSTOMER</font>
					</div>
					<div class="panel-body">
						<form method="post" enctype="multipart/form-data">
							<input type="hidden" name="username" value="<?= $user ?>">
							<input type="hidden" name="id" value="<?= $de["id"] ?>">
							<div class='col-md-6'>
								<table style=font-size:13px; class="table table-striped table table-bordered">
									<tr>
										<td>Kode</td>
										<td> <input type='text' class='form-control' name='kode' value='<?= $kode ?>' size='10' required readonly></td>
									</tr>
									<tr>
										<td>Kelompok</td>
										<td>
											<?php
											echo "<select readonly name='kelompok' class='form-control'>";
											$kelompok = array('Mr.', 'Ms.', 'Mrs.', 'Company');
											$jml_kata = count($kelompok);
											for ($c = 0; $c < $jml_kata; $c += 1) {
												if ($kelompok[$c] == $de['kelompok']) {
													echo "<option value=$kelompok[$c] selected>$kelompok[$c] </option>";
												} else {
													echo "<option value=$kelompok[$c]> $kelompok[$c] </option>";
												}
											}
											echo "</select>";
											?>
									<tr>
										<td>Nama</td>
										<td> <input type='text' class='form-control' name='nama' id='nama' value='<?= $nama ?>' autofocus='autofocus' required readonly></td>
									</tr>
									<tr>
										<td>Alamat</td>
										<td> <textarea rows='3' class='form-control' name='alamat' id='alamat' readonly><?= $alamat ?></textarea></td>
									</tr>
									<tr>
										<td>Kota</td>
										<td> <input type='text' class='form-control' name='kota' id='kota' value='<?= $kota ?>' readonly></td>
									</tr>
									<tr>
										<td>Kode Pos</td>
										<td> <input type='text' class='form-control' name='kodepos' id='kodepos' value='<?= $kodepos ?>' readonly></td>
									</tr>
									<tr>
										<td>Telp</td>
										<td> <input type='text' class='form-control' name='telp1' value='<?= $telp1 ?>' readonly></td>
									</tr>
									<tr>
										<td>
										<td> <input type='text' class='form-control' name='telp2' value='<?= $telp2 ?>' readonly></td>
									</tr>
									<tr>
										<td>Agama
										<td><select readonly id='agama' name='agama' class='form-control' style='width: 200x;'>
												<!--<option value=''> - PILIH AGAMA - </option>";-->
												<?php
												$data = mysqli_query($connect, 'select * from tbagama');
												while ($row = mysqli_fetch_array($data)) {
													if ($row['nama'] == $de['agama']) {
														echo "<option value=$row[nama] selected>$row[nama]</option>";
													} else {
														echo '<option name="nama"  value="' . $row['nama'] . '">' . $row['nama'] . '</option>';
													}
												}
												echo '</select>';
												?>
									<tr>
										<td>Tanggal Lahir (M-D-Y)</td>
										<td> <input type='date' class='form-control' name='tgl_lahir' value='<?= $tgl_lahir ?>' readonly></td>
									</tr>
									<tr>
										<td>Alamat KTP</td>
										<td> <textarea rows='3' class='form-control' name='alamat_ktp' id='alamat_ktp' readonly><?= $alamat_ktp ?></textarea></td>
									</tr>
									<tr>
										<td>Kota KTP</td>
										<td> <input type='text' class='form-control' name='kota_ktp' id='kota_ktp' value='<?= $kota_ktp ?>' readonly></td>
									</tr>
									<tr>
										<td>Kode Pos KPT</td>
										<td> <input type='text' class='form-control' name='kodepos_ktp' id='kodepos_ktp' value='<?= $kodepos_ktp ?>' readonly></td>
									</tr>
								</table>
							</div>
							<div class='col-md-6'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>Alamat Kantor</td>
										<td> <textarea rows='3' class='form-control' name='alamat_ktr' id='alamat_ktr' readonly><?= $alamat_ktr ?></textarea></td>
									</tr>
									<tr>
										<td>Kota Kantor</td>
										<td> <input type='text' class='form-control' name='kota_ktr' id='kota_ktr' value='<?= $kota_ktr ?>' readonly></td>
									</tr>
									<tr>
										<td>Kode Pos Kantor</td>
										<td> <input type='text' class='form-control' name='kodepos_ktr' id='kodepos_ktr' value='<?= $kodepos_ktr ?>' readonly></td>
									</tr>
									<tr>
										<td>Telp Kantor</td>
										<td> <input type='text' class='form-control' name='telp1_ktr' value='<?= $telp1_ktr ?>' readonly></td>
									</tr>
									<tr>
										<td>
										<td> <input type='text' class='form-control' name='telp2_ktr' value='<?= $telp2_ktr ?>' readonly></td>
									</tr>
									<tr>
										<td>NPWP</td>
										<td> <input type='text' class='form-control' name='npwp' value='<?= $npwp ?>' readonly></td>
									</tr>
									<tr>
										<td>Nama NPWP</td>
										<td> <input type='text' class='form-control' name='nama_npwp' id='nama_npwp' value='<?= $nama_npwp ?>' readonly></td>
									</tr>
									<tr>
										<td>Alamat NPWP</td>
										<td> <textarea rows='3' class='form-control' name='alamat_npwp' id='alamat_npwp' readonly><?= $alamat_npwp ?></textarea></td>
									</tr>
									<tr>
										<td>Maksimum Piutang</td>
										<td> <input type='number' class='form-control' name='mak_piutang' value='<?= $mak_piutang ?>' required readonly></td>
									</tr>
									<tr>
										<td>Tanggal Register (M-D-Y)</td>
										<td> <input type='date' class='form-control' name='tgl_register' value='<?= $tgl_register ?>' readonly></td>
									</tr>
								</table>
							</div>
							<div class='col-md-12'>
								<input button type='Button' class='btn btn-danger' value='Close' onClick="window.location.href='?m=tbcustomer'" />
							</div>
					</div>
				</div>
				</form>
			</font>
		<?php } else {
			echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
		}
	}
}

if (isset($_GET['tipe'])) {
	if ($_GET['tipe'] == 'tambah') {
		cekakses($connect, $user, 'Tabel Customer');
		$lakses = $_SESSION['aksestambah'];
		if ($lakses == 1) { ?>
			<font face='calibri'>
				<div class='panel panel-danger'>
					<div class='panel-heading'>
						<font size="4">TAMBAH DATA TABEL CUSTOMER</font>
					</div>
					<div class='panel-body'>
						<form method='post' name='tbcustomer' enctype='multipart/form-data' action='module/tbcustomer/proses_tambah.php'>
							<input type='hidden' name='username' value="<?= $user ?>">
							<div class='col-md-6'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>Kode</td>
										<td> <input type='text' class='form-control' name='kode' size='10' autofocus='autofocus' required></td>
									</tr>
									<tr>
										<td>Kelompok
										<td><select required id='kelompok' name='kelompok' class='form-control' style='width: 200x;'>
												<option value='Mr.'>Mr.</option>
												<option value='Ms.'>Ms.</option>
												<option value='Mrs.'>Mrs.</option>
												<option value='Mrs.'>Company</option>
											</select>
									<tr>
										<td>Nama</td>
										<td> <input type='text' class='form-control' name='nama' id='nama' required></td>
									</tr>
									<tr>
										<td>Alamat</td>
										<td> <textarea rows='3' class='form-control' name='alamat' id='alamat'></textarea></td>
									</tr>
									<tr>
										<td>Kota</td>
										<td> <input type='text' class='form-control' name='kota' id='kota'></td>
									</tr>
									<tr>
										<td>Kode Pos</td>
										<td> <input type='text' class='form-control' name='kodepos' id='kodepos'></td>
									</tr>
									<tr>
										<td>Telp</td>
										<td> <input type='text' class='form-control' name='telp1'></td>
									</tr>
									<tr>
										<td>
										<td> <input type='text' class='form-control' name='telp2'></td>
									</tr>
									<tr>
										<td>Agama
										<td><select id='agama' name='agama' class='form-control' style='width: 200x;'>
												<!--<option value=''> - PILIH AGAMA - </option>";-->
												<?php
												$data = mysqli_query($connect, 'select * from tbagama');
												while ($row = mysqli_fetch_array($data)) {
													echo '<option name="nama"  value="' . $row['nama'] . '">' . $row['nama'] . '</option>';
												}
												echo '</select>';
												?>
									<tr>
										<td>Tanggal Lahir (M-D-Y)</td>
										<td> <input type='date' class='form-control' name='tgl_lahir'></td>
									</tr>
									<tr>
										<td>Alamat KTP<br><input button type='Button' class='btn btn-success' value='Salin' onClick='salin_alamat_ktp()' /></td>
										<td> <textarea rows='3' class='form-control' name='alamat_ktp' id='alamat_ktp'></textarea></td>
									</tr>
									<tr>
										<td>Kota KTP</td>
										<td> <input type='text' class='form-control' name='kota_ktp' id='kota_ktp'></td>
									</tr>
									<tr>
										<td>Kode Pos KPT</td>
										<td> <input type='text' class='form-control' name='kodepos_ktp' id='kodepos_ktp'></td>
									</tr>
								</table>
							</div>
							<div class='col-md-6'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>Alamat Kantor<br><input button type='Button' class='btn btn-success' value='Salin' onClick='salin_alamat_ktr()' /></td>
										<td> <textarea rows='3' class='form-control' name='alamat_ktr' id='alamat_ktr'></textarea></td>
									</tr>
									<tr>
										<td>Kota Kantor</td>
										<td> <input type='text' class='form-control' name='kota_ktr' id='kota_ktr'></td>
									</tr>
									<tr>
										<td>Kode Pos Kantor</td>
										<td> <input type='text' class='form-control' name='kodepos_ktr' id='kodepos_ktr'></td>
									</tr>
									<tr>
										<td>Telp Kantor</td>
										<td> <input type='text' class='form-control' name='telp1_ktr'></td>
									</tr>
									<tr>
										<td>
										<td> <input type='text' class='form-control' name='telp2_ktr'></td>
									</tr>
									<tr>
										<td>NPWP</td>
										<td> <input type='text' class='form-control' name='npwp'></td>
									</tr>
									<tr>
										<td>Nama NPWP<br><input button type='Button' class='btn btn-success' value='Salin' onClick='salin_alamat_npwp()' /></td>
										<td> <input type='text' class='form-control' name='nama_npwp' id='nama_npwp'></td>
									</tr>
									<tr>
										<td>Alamat NPWP</td>
										<td> <textarea rows='3' class='form-control' name='alamat_npwp' id='alamat_npwp'></textarea></td>
									</tr>
									<tr>
										<td>Maksimum Piutang</td>
										<td> <input type='number' class='form-control' name='mak_piutang'></td>
									</tr>
								</table>
							</div>
							<div class='col-md-12'>
								<button type='submit' class='btn btn-success'>Simpan</button>
								<input button type='Button' class='btn btn-danger' value='Batal' onClick='history.back()' />
							</div>
					</div>
				</div>
				</form>
			</font>
		<?php
		} else {
			echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
		}
	} elseif ($_GET['tipe'] == 'edit') {
		cekakses($connect, $user, 'Tabel Customer');
		$lakses = $_SESSION['aksesedit'];
		if ($lakses == 1) {
			// $query = $connect->prepare("select * from tbcustomer where id=?");
			// $query->bind_param('i', $_GET['id']);
			// $query->execute();
			// $result = $query->get_result();
			// $de = $result->fetch_assoc();
			$sql = mysqli_query($connect, "select * from tbcustomer where id='$_GET[id]'");
			$de = mysqli_fetch_assoc($sql);
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
					<div class="panel-heading">
						<font size="4">EDIT DATA TABEL CUSTOMER</font>
					</div>
					<div class="panel-body">
						<form method="post" enctype="multipart/form-data" action="module/tbcustomer/proses_edit.php">
							<input type="hidden" name="username" value="<?= $user ?>">
							<input type="hidden" name="id" value="<?= $de["id"] ?>">
							<div class='col-md-6'>
								<table style=font-size:13px; class="table table-striped table table-bordered">
									<tr>
										<td>Kode</td>
										<td> <input type='text' class='form-control' name='kode' value='<?= $kode ?>' size='10' required readonly></td>
									</tr>
									<tr>
										<td>Kelompok</td>
										<td>
											<?php
											echo "<select name='kelompok' class='form-control'>";
											$kelompok = array('Mr.', 'Ms.', 'Mrs.', 'Company');
											$jml_kata = count($kelompok);
											for ($c = 0; $c < $jml_kata; $c += 1) {
												if ($kelompok[$c] == $de['kelompok']) {
													echo "<option value=$kelompok[$c] selected>$kelompok[$c] </option>";
												} else {
													echo "<option value=$kelompok[$c]> $kelompok[$c] </option>";
												}
											}
											echo "</select>";
											?>
									<tr>
										<td>Nama</td>
										<td> <input type='text' class='form-control' name='nama' id='nama' value='<?= $nama ?>' autofocus='autofocus' required></td>
									</tr>
									<tr>
										<td>Alamat</td>
										<td> <textarea rows='3' class='form-control' name='alamat' id='alamat'><?= $alamat ?></textarea></td>
									</tr>
									<tr>
										<td>Kota</td>
										<td> <input type='text' class='form-control' name='kota' id='kota' value='<?= $kota ?>'></td>
									</tr>
									<tr>
										<td>Kode Pos</td>
										<td> <input type='text' class='form-control' name='kodepos' id='kodepos' value='<?= $kodepos ?>'></td>
									</tr>
									<tr>
										<td>Telp</td>
										<td> <input type='text' class='form-control' name='telp1' value='<?= $telp1 ?>'></td>
									</tr>
									<tr>
										<td>
										<td> <input type='text' class='form-control' name='telp2' value='<?= $telp2 ?>'></td>
									</tr>
									<tr>
										<td>Agama
										<td><select id='agama' name='agama' class='form-control' style='width: 200x;'>
												<!--<option value=''> - PILIH AGAMA - </option>";-->
												<?php
												$data = mysqli_query($connect, 'select * from tbagama');
												while ($row = mysqli_fetch_array($data)) {
													if ($row['nama'] == $de['agama']) {
														echo "<option value=$row[nama] selected>$row[nama]</option>";
													} else {
														echo '<option name="nama"  value="' . $row['nama'] . '">' . $row['nama'] . '</option>';
													}
												}
												echo '</select>';
												?>
									<tr>
										<td>Tanggal Lahir (M-D-Y)</td>
										<td> <input type='date' class='form-control' name='tgl_lahir' value='<?= $tgl_lahir ?>'></td>
									</tr>
								</table>
							</div>
							<div class='col-md-6'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>Alamat KTP<br><input button type='Button' class='btn btn-success' value='Salin' onClick='salin_alamat_ktp()' /></td>
										<td> <textarea rows='3' class='form-control' name='alamat_ktp' id='alamat_ktp'><?= $alamat_ktp ?></textarea></td>
									</tr>
									<tr>
										<td>Kota KTP</td>
										<td> <input type='text' class='form-control' name='kota_ktp' id='kota_ktp' value='<?= $kota_ktp ?>'></td>
									</tr>
									<tr>
										<td>Kode Pos KPT</td>
										<td> <input type='text' class='form-control' name='kodepos_ktp' id='kodepos_ktp' value='<?= $kodepos_ktp ?>'></td>
									</tr>
									<tr>
										<td>Alamat Kantor<br><input button type='Button' class='btn btn-success' value='Salin' onClick='salin_alamat_ktr()' /></td>
										<td> <textarea rows='3' class='form-control' name='alamat_ktr' id='alamat_ktr'><?= $alamat_ktr ?></textarea></td>
									</tr>
									<tr>
										<td>Kota Kantor</td>
										<td> <input type='text' class='form-control' name='kota_ktr' id='kota_ktr' value='<?= $kota_ktr ?>'></td>
									</tr>
									<tr>
										<td>Kode Pos Kantor</td>
										<td> <input type='text' class='form-control' name='kodepos_ktr' id='kodepos_ktr' value='<?= $kodepos_ktr ?>'></td>
									</tr>
									<tr>
										<td>Telp Kantor</td>
										<td> <input type='text' class='form-control' name='telp1_ktr' value='<?= $telp1_ktr ?>'></td>
									</tr>
									<tr>
										<td>
										<td> <input type='text' class='form-control' name='telp2_ktr' value='<?= $telp2_ktr ?>'></td>
									</tr>
									<tr>
										<td>NPWP</td>
										<td> <input type='text' class='form-control' name='npwp' value='<?= $npwp ?>'></td>
									</tr>
									<tr>
										<td>Nama NPWP<br><input button type='Button' class='btn btn-success' value='Salin' onClick='salin_alamat_npwp()' /></td>
										<td> <input type='text' class='form-control' name='nama_npwp' id='nama_npwp' value='<?= $nama_npwp ?>'></td>
									</tr>
									<tr>
										<td>Alamat NPWP</td>
										<td> <textarea rows='3' class='form-control' name='alamat_npwp' id='alamat_npwp'><?= $alamat_npwp ?></textarea></td>
									</tr>
									<tr>
										<td>Maksimum Piutang</td>
										<td> <input type='number' class='form-control' name='mak_piutang' value='<?= $mak_piutang ?>'></td>
									</tr>
								</table>
							</div>
							<div class='col-md-12'>
								<button type="submit" class="btn btn-primary">Simpan</button>
								<input button type="Button" class="btn btn-danger" value="Batal" onClick="history.back()" />
							</div>
					</div>
				</div>
				</form>
			</font>
	<?php
		} else {
			echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
		}
	}
} else {

	?>
	<?php
	include 'cek_akses.php';
	if ($aksesok == 'Y') {
	?>
		<font face="calibri">
			<div class="panel panel-info">
				<div class="panel-heading">
					<font size="4">TABEL CUSTOMER</font>
				</div>
				<div class="panel-body">
					<form method='get'>
						<div class="row">
							<div class="col-md-10 bg">
								<a class="btn btn-danger" href="?m=tbcustomer&tipe=tambah">Tambah data</a>
								<a class="btn btn-success" href="?m=tbcustomer&tipe=import">Import data</a>
								<a class="btn btn-warning" href="?m=tbcustomer&tipe=export">Export data</a>
							</div>
						</div>
					</form>
					</br>
					<div class="box-body table-responsive">
						<table id="tbcustomer" class="table table-bordered table-hover">
							<thead>
								<tr>
									<!-- <th width='40'>No</th> -->
									<th width='40'>Kode</th>
									<th width='200'>Nama</th>
									<th width='350'>Alamat</th>
									<th width='70'>Telpon</th>
									<th width='80'>Aksi</th>
								</tr>
							</thead>
							<?php
							// $tampil = mysqli_query($connect,"SELECT * FROM tbcustomer order by kode");
							// $no=1;
							// while($k=mysqli_fetch_assoc($tampil)){
							// 	echo "<tr>
							// 		<td align='center'>$no</td>
							// 		<td><u><a href='?m=tbbank&tipe=detail&id=$k[id]'><font color='blue'>$k[kode]</font></a></u></td>
							// 		<td>$k[nama]</td>
							// 		<td>$k[alamat]</td>
							// 		<td>$k[telp1]</td>
							// 		<td align='center' width='120px'>
							// 		<a class='btn btn-info' href='?m=tbcustomer&tipe=edit&id=$k[id]'>Edit</a>";
							// 		cekakses($connect,$user,'Tabel Customer');
							// 		$lakses = $_SESSION['akseshapus'];
							// 		if ($lakses == 1) {
							// 			//echo " <a class='btn btn-danger' href='module/tbcustomer/proses_hapus.php?id=$k[id]&kode=$k[kode]'
							// 			//onClick='return confirm(\"Anda yakin akan menghapus ?\")'>Hapus</a>";
							// 			echo " <input button type='Button' class='btn btn-danger' value='Hapus' onClick='alert_hapus($k[id])'/>";
							// 		}else{
							// 			echo " <input button type='Button' class='btn btn-danger' value='Hapus' onClick='alert_hapus($k[id])' disabled/>";
							// 		}
							// 	echo "</td>";
							// 	$no++;
							// }			
							?>
						</table>
					</div>
				</div>
			</div>
		<?php
	} else {
		echo "<font color='red'>Anda tidak punya hak !</font>";
	} ?>
	<?php
}
	?>

	<?php
	function konversitext($field)
	{
		echo htmlentities($field, ENT_QUOTES);
	}
	?>

	<!-- Modal -->
	<div class="modal fade" id="modaldetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content" style="width:900px;">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel1">Detail Data</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<script src="js/jquery.min.js" type="text/javascript"></script>

	<script>
		function alert_hapus($id) {
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
						window.location.href = $href + $id;
						// swal("Poof! Your imaginary file has been deleted!", {
						//   icon: "success",
						// });
					} else {
						//swal("Batal Hapus!");
					}
				});
		};

		function salin_alamat_ktr() {
			document.getElementById('alamat_ktr').value = document.getElementById('alamat').value
			document.getElementById('kota_ktr').value = document.getElementById('kota').value
			document.getElementById('kodepos_ktr').value = document.getElementById('kodepos').value
		}

		function salin_alamat_ktp() {
			document.getElementById('alamat_ktp').value = document.getElementById('alamat').value
			document.getElementById('kota_ktp').value = document.getElementById('kota').value
			document.getElementById('kodepos_ktp').value = document.getElementById('kodepos').value
		}

		function salin_alamat_npwp() {
			document.getElementById('nama_npwp').value = document.getElementById('nama').value
			document.getElementById('alamat_npwp').value = document.getElementById('alamat').value + ' ' + document.getElementById('kota').value + ' ' + document.getElementById('kodepos').value
		}
	</script>