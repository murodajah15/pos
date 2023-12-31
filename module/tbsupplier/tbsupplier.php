<?php
$user = $_SESSION['username'];
if (isset($_GET['tipe'])) {
	if ($_GET['tipe'] == 'import') {
		cekakses($connect, $user, 'Tabel Supplier');
		$lakses = $_SESSION['aksestambah'];
		if ($lakses == 1) { ?>
			<font face='calibri'>
				<div class="panel panel-success">
					<div class="panel-heading">
						<font size="4">IMPORT DATA TABEL SUPPLIER</font>
					</div>
					<div class="panel-body">
						<form method='post' enctype='multipart/form-data' action='module/tbsupplier/proses_import.php'>
							<input type='hidden' name='username' value='<?= $user ?>'>
							Pilih File Excel*:
							<input name='fileexcel' type='file' accept='application/vnd.ms-excel'></br> <!--<input name='upload' type='submit' alue='Import'>-->
							<button type='submit' class='btn btn-primary btn-sm' name='upload' value='import'>Import</button>
							<input button type='Button' class='btn btn-danger btn-sm' value='Selesai' onClick='history.back()' />
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
		cekakses($connect, $user, 'Tabel Supplier');
		$lakses = $_SESSION['aksescetak'];
		if ($lakses == 1) { ?>
			<font face='calibri'>
				<div class="panel panel-default">
					<div class="panel-heading">
						<font size="4">EXPORT DATA TABEL SUPPLIER</font>
					</div>
					<div class="panel-body">
						<form method='post' enctype='multipart/form-data' action='module/tbsupplier/proses_export.php'>
							<input type='hidden' name='username' value='<?= $user ?>'>
							Type : <select name=typefile class='form-control' required>
								<option value='Excel'> Excel</option>
								<option value='CSV'> CSV</option>
								<option value='PDF'> PDF</option>
							</select><br>
							<button type='submit' class='btn btn-primary btn-sm' name='upload' value='export'>Export</button>
							<input button type='Button' class='btn btn-danger btn-sm' value='Selesai' onClick='history.back()' />
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
		cekakses($connect, $user, 'Tabel Supplier');
		$lakses = $_SESSION['aksespakai'];
		if ($lakses == 1) {
			// $query = $connect->prepare("select * from tbsupplier where id=?");
			// $query->bind_param('i',$_GET['id']);
			// $result = $query->execute();
			// $query->store_result();
			// $query->execute();
			// $result = $query->get_result();
			// $de = $result->fetch_assoc();
			$sql = mysqli_query($connect, "select * from tbsupplier where id='$_GET[id]'");
			$de = mysqli_fetch_assoc($sql);
			$kode = strip_tags($de['kode']);
			$nama = strip_tags($de['nama']);
			$alamat = strip_tags($de['alamat']);
			$kota = strip_tags($de['kota']);
			$kodepos = strip_tags($de['kodepos']);
			$telp1 = strip_tags($de['telp1']);
			$telp2 = strip_tags($de['telp2']);
			$contact_person = strip_tags($de['contact_person']);
			$npwp = strip_tags($de['npwp']);
		?>
			<font face="calibri">
				<div class="panel panel-warning">
					<div class="panel-heading">
						<font size="4">DETAIL DATA TABEL SUPPLIER</font>
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
								</table>
							</div>
							<div class='col-md-6'>
								<table style=font-size:13px; class="table table-striped table table-bordered">
									<tr>
										<td>NPWP</td>
										<td> <input type='text' class='form-control' name='npwp' value='<?= $npwp ?>' readonly></td>
									</tr>
									<tr>
										<td>Contact Person</td>
										<td> <input type='text' class='form-control' name='contact_person' id='contact_person' value='<?= $contact_person ?>' readonly></td>
									</tr>
								</table>
							</div>
							<div class='col-md-12'>
								<input button type='Button' class='btn btn-danger btn-sm' value='Close' onClick="window.location.href='?m=tbsupplier'" />
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
		cekakses($connect, $user, 'Tabel Supplier');
		$lakses = $_SESSION['aksestambah'];
		if ($lakses == 1) { ?>
			<font face='calibri'>
				<div class='panel panel-danger'>
					<div class='panel-heading'>
						<font size="4">TAMBAH DATA TABEL SUPPLIER</font>
					</div>
					<div class='panel-body'>
						<form method='post' name='tbsupplier' enctype='multipart/form-data' action='module/tbsupplier/proses_tambah.php'>
							<input type='hidden' name='username' value="<?= $user ?>">
							<div class='col-md-6'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>Kode</td>
										<td> <input type='text' class='form-control' name='kode' size='10' autofocus='autofocus' required></td>
									</tr>
									<tr>
										<td>Nama</td>
										<td> <input type='text' class='form-control' name='nama' required></td>
									</tr>
									<tr>
										<td>Alamat</td>
										<td> <textarea rows='3' class='form-control' name='alamat'></textarea></td>
									</tr>
									<tr>
										<td>Kota</td>
										<td> <input type='text' class='form-control' name='kota'></td>
									</tr>
									<tr>
										<td>Kode Pos</td>
										<td> <input type='text' class='form-control' name='kodepos'></td>
									</tr>
									<tr>
										<td>Telp</td>
										<td> <input type='text' class='form-control' name='telp1'></td>
									</tr>
									<tr>
										<td>
										<td> <input type='text' class='form-control' name='telp2'></td>
									</tr>
								</table>
							</div>
							<div class='col-md-6'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>NPWP</td>
										<td> <input type='text' class='form-control' name='npwp'></td>
									</tr>
									<tr>
										<td>Contact Person</td>
										<td> <input type='text' class='form-control' name='contact_person'></td>
									</tr>
								</table>
							</div>
							<div class='col-md-12'>
								<button type='submit' class='btn btn-success btn-sm'>Simpan</button>
								<input button type='Button' class='btn btn-danger btn-sm' value='Batal' onClick='history.back()' />
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
		cekakses($connect, $user, 'Tabel Supplier');
		$lakses = $_SESSION['aksesedit'];
		if ($lakses == 1) {
			// $query = $connect->prepare("select * from tbsupplier where id=?");
			// $query->bind_param('i',$_GET['id']);
			// $query->execute();
			// $result = $query->get_result();
			// $de = $result->fetch_assoc();
			$sql = mysqli_query($connect, "select * from tbsupplier where id='$_GET[id]'");
			$de = mysqli_fetch_assoc($sql);
			$kode = strip_tags($de['kode']);
			$nama = strip_tags($de['nama']);
			$alamat = strip_tags($de['alamat']);
			$kota = strip_tags($de['kota']);
			$kodepos = strip_tags($de['kodepos']);
			$telp1 = strip_tags($de['telp1']);
			$telp2 = strip_tags($de['telp2']);
			$npwp = strip_tags($de['npwp']);
			$contact_person = strip_tags($de['contact_person']);
		?>
			<font face="calibri">
				<div class="panel panel-warning">
					<div class="panel-heading">
						<font size="4">EDIT DATA TABEL SUPPLIER</font>
					</div>
					<div class="panel-body">
						<form method="post" enctype="multipart/form-data" action="module/tbsupplier/proses_edit.php">
							<input type="hidden" name="username" value="<?= $user ?>">
							<input type="hidden" name="id" value="<?= $de["id"] ?>">
							<div class='col-md-6'>
								<table style=font-size:13px; class="table table-striped table table-bordered">
									<tr>
										<td>Kode</td>
										<td> <input type='text' class='form-control' name='kode' value='<?= $kode ?>' size='10' required readonly></td>
									</tr>
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
								</table>
							</div>
							<div class='col-md-6'>
								<table style=font-size:13px; class="table table-striped table table-bordered">
									<tr>
										<td>NPWP</td>
										<td> <input type='text' class='form-control' name='npwp' value='<?= $npwp ?>'></td>
									</tr>
									<tr>
										<td>Contact Person</td>
										<td> <input type='text' class='form-control' name='contact_person' value='<?= $contact_person ?>'></td>
									</tr>
								</table>
							</div>
					</div>
					<div class='col-md-12'>
						<button type="submit" class="btn btn-primary btn-sm">Simpan</button>
						<input button type="Button" class="btn btn-danger btn-sm" value="Batal" onClick="history.back()" />
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
					<font size="4">TABEL SUPPLIER</font>
				</div>
				<div class="panel-body">
					<form method='post'>
						<div class="row">
							<div class="col-md-12 bg">
								<a class="btn btn-danger btn-sm" href="?m=tbsupplier&tipe=tambah">Tambah data</a>
								<a class="btn btn-success btn-sm" href="?m=tbsupplier&tipe=import">Import data</a>
								<a class="btn btn-warning btn-sm" href="?m=tbsupplier&tipe=export">Export data</a>
							</div>
						</div>
					</form>
					</br>
					<!--<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover" cellspacing="0" width="100%">-->
					<div class="box-body table-responsive">
						<table id="example1" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th width='50'>No.</th>
									<th>Kode</th>
									<th width='250'>Nama</th>
									<th>Alamat</th>
									<th>Telpon 1</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<?php
							$tampil = mysqli_query($connect, "SELECT * FROM tbsupplier order by kode");
							$no = 1;
							while ($k = mysqli_fetch_assoc($tampil)) {
								echo "<tr>
					<td align='center'>$no</td>
					<td><u><a href='?m=tbsupplier&tipe=detail&id=$k[id]'><font color='blue'>$k[kode]</font></a></u></td>
					<td>$k[nama]</td>
					<td>$k[alamat]</td>
					<td>$k[telp1]</td>
					<td align='center' width='120px'>
						<a class='btn btn-info btn-sm' href='?m=tbsupplier&tipe=edit&id=$k[id]'>Edit</a>";
								cekakses($connect, $user, 'Tabel Supplier');
								$lakses = $_SESSION['akseshapus'];
								if ($lakses == 1) {
									//echo " <a class='btn btn-danger' href='module/tbsupplier/proses_hapus.php?id=$k[id]&kode=$k[kode]'
									//onClick='return confirm(\"Anda yakin akan menghapus ?\")'>Hapus</a>";
									echo " <input button type='Button' class='btn btn-danger btn-sm' value='Hapus' onClick='alert_hapus($k[id])'/>";
								} else {
									echo " <input button type='Button' class='btn btn-danger btn-sm' value='Hapus' onClick='alert_hapus($k[id])' disabled/>";
								}
								echo "</td>";
								$no++;
							}
							?>
						</table>
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
								$href = "module/tbsupplier/proses_hapus.php?id=";
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