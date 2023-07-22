<?php
$user = $_SESSION['username'];
if (isset($_GET['tipe'])) {
	if ($_GET['tipe'] == 'import') {
		cekakses($connect, $user, 'Tabel Bank');
		$lakses = $_SESSION['aksestambah'];
		if ($lakses == 1) { ?>
			<font face='calibri'>
				<div class="panel panel-success">
					<div class="panel-heading">
						<font size="4">IMPORT DATA TABEL BANK</font>
					</div>
					<div class="panel-body">
						<form method='post' enctype='multipart/form-data' action='module/tbbank/proses_import.php'>
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
		cekakses($connect, $user, 'Tabel Bank');
		$lakses = $_SESSION['aksescetak'];
		if ($lakses == 1) { ?>
			<font face='calibri'>
				<div class="panel panel-default">
					<div class="panel-heading">
						<font size="4">EXPORT DATA TABEL BANK</font>
					</div>
					<div class="panel-body">
						<form method='post' enctype='multipart/form-data' action='module/tbbank/proses_export.php'>
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
		cekakses($connect, $user, 'Tabel Bank');
		$lakses = $_SESSION['aksespakai'];
		if ($lakses == 1) {
			// $query = $connect->prepare("select * from tbbank where id=?");
			// $query->bind_param('i',$_GET['id']);
			// $result = $query->execute();
			// $query->store_result();
			// $query->execute();
			// $result = $query->get_result();
			// $de = $result->fetch_assoc();
			$sql = mysqli_query($connect, "select * from tbbank where id='$_GET[id]'");
			$de = mysqli_fetch_assoc($sql);
			$kode = htmlspecialchars($de['kode']);
			$nama = htmlspecialchars($de['nama']);
			$user = $de['user'];
		?>
			<font face='calibri'>
				<div class="panel panel-default">
					<div class="panel-heading">
						<font size="4">DETAIL DATA TABEL BANK</font>
					</div>
					<div class="panel-body">
						<form method='post' enctype='multipart/form-data'>
							<input type='hidden' name='username' value="<?= $user ?>">
							<input type='hidden' name='id' value="<?= $de['id'] ?>" />
							<table style=font-size:13px; class='table table-striped table table-bordered'>
								<tr>
									<td>Kode</td>
									<td> <input type='text' class='form-control' name='kode' value="<?= $kode ?>" readonly></td>
								</tr>
								<tr>
									<td>Nama</td>
									<td> <input type='text' class='form-control' name='nama' value="<?= $nama ?>" readonly></td>
								</tr>
								<tr>
									<td>User</td>
									<td> <input type='text' class='form-control' name='user' value="<?= $user ?>" readonly></td>
								</tr>
							</table>
							<input button type='Button' class='btn btn-danger btn-sm' value='Close' onClick="window.location.href='?m=tbbank'" />
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
		cekakses($connect, $user, 'Tabel Bank');
		$lakses = $_SESSION['aksestambah'];
		if ($lakses == 1) { ?>
			<font face='calibri'>
				<div class='panel panel-danger'>
					<div class='panel-heading'>
						<font size="4">TAMBAH DATA TABEL BANK</font>
					</div>
					<div class='panel-body'>
						<form method='post' name='tbbank' enctype='multipart/form-data' action='module/tbbank/proses_tambah.php'>
							<input type='hidden' name='username' value="<?= $user ?>">
							<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
								<tr>
									<td>Kode</td>
									<td> <input type='text' class='form-control' name='kode' size='10' autofocus='autofocus' required></td>
								<tr>
									<td width='100px'>Nama</td>
									<td> <input type='text' class='form-control' name='nama' width='150px' required></td>
								</tr>
							</table>
							<button type='submit' class='btn btn-success btn-sm'>Simpan</button>
							<input button type='Button' class='btn btn-danger btn-sm' value='Batal' onClick='history.back()' />
					</div>
				</div>
				</form>
			</font>
		<?php
		} else {
			echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
		}
	} elseif ($_GET['tipe'] == 'edit') {
		cekakses($connect, $user, 'Tabel Bank');
		$lakses = $_SESSION['aksesedit'];
		if ($lakses == 1) {
			// $query = $connect->prepare("select * from tbbank where id=?");
			// $query->bind_param('i', $_GET['id']);
			// $query->execute();
			// $result = $query->get_result();
			// $de = $result->fetch_assoc();
			$sql = mysqli_query($connect, "select * from tbbank where id='$_GET[id]'");
			$de = mysqli_fetch_assoc($sql);
			$kode = htmlspecialchars($de["kode"]);
			$nama = htmlspecialchars($de["nama"]);
		?>
			<font face="calibri">
				<div class="panel panel-warning">
					<div class="panel-heading">
						<font size="4">EDIT DATA TABEL BANK</font>
					</div>
					<div class="panel-body">
						<form method="post" enctype="multipart/form-data" action="module/tbbank/proses_edit.php">
							<input type="hidden" name="username" value="<?= $user ?>">
							<input type="hidden" name="id" value="<?= $de["id"] ?>">
							<table style=font-size:13px; class="table table-striped table table-bordered">
								<tr>
									<td>Kode</td>
									<td> <input type="text" class="form-control" name="kode" value="<?= $kode ?>" readonly></td>
								</tr>
								<tr>
									<td>Nama</td>
									<td> <input type="text" class="form-control" name="nama" id="nama" value="<?= $nama ?>" autofocus="autofocus"></td>
								</tr>
							</table>
							<button type="submit" class="btn btn-primary btn-sm">Simpan</button>
							<input button type="Button" class="btn btn-danger btn-sm" value="Batal" onClick="history.back()" />
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
					<font size="4">TABEL BANK</font>
				</div>
				<div class="panel-body">
					<form method='post'>
						<div class="row">
							<div class="col-md-12 bg">
								<a class="btn btn-danger btn-sm" href="?m=tbbank&tipe=tambah">Tambah data</a>
								<a class="btn btn-success btn-sm" href="?m=tbbank&tipe=import">Import data</a>
								<a class="btn btn-warning btn-sm" href="?m=tbbank&tipe=export">Export data</a>
							</div>
						</div>
					</form>
					</br>
					<!--<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover" cellspacing="0" width="100%">-->
					<div class="box-body table-responsive">
						<table id="tbbank" class="table table-bordered table-striped">
							<thead>
								<tr>
									<!-- <th width='50'>No.</th> -->
									<th width='50'>Kode</th>
									<th width='250'>Nama</th>
									<th width='150'>User</th>
									<th width='70'>Aksi</th>
								</tr>
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
								$href = "module/tbbank/proses_hapus.php?id=";
								window.location.href = $href + $id;
								// swal("Poof! Your imaginary file has been deleted!", {
								//   icon: "success",
								// });
							} else {
								//swal("Batal Hapus!");
							}
						});
				};
			</script>