<?php
$user = $_SESSION['username'];
include "autonumber.php";

if (isset($_GET['tipe'])) {
	if ($_GET['tipe'] == 'import') {
		cekakses($connect, $user, 'Stock Opname');
		$lakses = $_SESSION['aksestambah'];
		$noopname = $_GET['noopname'];
		if ($lakses == 1) { ?>
			<font face='calibri'>
				<div class="panel panel-success">
					<div class="panel-heading">
						<font size="4">IMPORT DATA DETAIL STOCK OPNAME</font>
					</div>
					<div class="panel-body">
						<form method='post' enctype='multipart/form-data' action='module/opname/proses_import.php'>
							<input type='hidden' name='username' value='<?= $user ?>'>
							<input type='hidden' name='noopname' value='<?= $noopname ?>'>
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
		cekakses($connect, $user, 'Stock Opname');
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
	if ($_GET['tipe'] == 'detail_proses') {
		cekakses($connect, $user, 'Stock Opname');
		$lakses = $_SESSION['aksespakai'];
		if ($lakses == 1) {
			// $query = $connect->prepare("select * from opnameh where noopname=?");
			// $query->bind_param('s', $_GET['noopname']);
			// $query->execute();
			// $result = $query->get_result();
			// $de = $result->fetch_assoc();
			$sql = mysqli_query($connect, "select * from opnameh where noopname='$_GET[noopname]'");
			$de = mysqli_fetch_assoc($sql);
			$noopname = strip_tags($de['noopname']);
			$proses = strip_tags($de['proses']);
			$tglopname = strip_tags($de['tglopname']); ?>
			<font face='calibri'>
				<h3>Detail Stock Opname</h3>
				<form method='post' enctype='multipart/form-data'>
					<input type='hidden' name='username' value='<?= $user ?>'>
					<table class="table table-bordered table-striped table-hover">
						<tr>
							<td>Nomor Opname</td>
							<td>
								<input type='text' class='form-control' id='noopname' name='noopname' placeholder='No. OPNAME *' style='text-transform:uppercase' value="<?= $noopname ?>" readonly>
							</td>
							<td>Tgl. (M/D/Y)</td>
							<td><input type='date' class='form-control' id='tglopname' name='tglopname' value="<?= $tglopname ?>" size='50' autocomplete='off' readonly></td>
						</tr>
					</table>

					<div class="table-responsive">
						<table class="table table-bordered table-striped table-hover">
							<tr>
								<th width='50'>No.</th>
								<th width='170'>Kode Barang</th>
								<th>Nama Barang</th>
								<th>Lokasi</th>
								<th>QTY</th>
							</tr>
							<?php
							$tampil = mysqli_query($connect, "select * from opnamed where noopname='$_GET[noopname]'");
							// $query = $connect->prepare("select * from opnamed where noopname=?");
							// $query->bind_param('s', $_GET['noopname']);
							// $query->execute();
							// $result = $query->get_result();
							// $de = $result->fetch_assoc();
							$no = 1;
							//<td><u><a href='?m=wo&tipe=detail&id=$k[id]'><font color='blue'>$k[kode]</font></a></u></td>
							//<td><u><a href='#' onclick =lihat_detail('$k[id]');><font color='blue'>$k[kdbarang]</font></a></u></td>
							while ($k = mysqli_fetch_assoc($tampil)) {
								//$date = date("m/d/Y", strtotime($k['tglwo']));
								$kdbarang = strip_tags($k['kdbarang']);
								$nmbarang = strip_tags($k['nmbarang']);
								$lokasi = strip_tags($k['lokasi']);
								$qty = number_format($k['qty'], 2, ",", ".");
								echo "<tr><td align='center'>$no</td>
								<td>$k[kdbarang]</td>
								<td>$k[nmbarang]</td>
								<td>$k[lokasi]</td>
								<td align='right' width='70'>$qty</td>";
								$no++;
							}
							?>
						</table>
					</div>
					<input button type='Button' class='btn btn-danger' value='Close' onClick='history.back()' />
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
		cekakses($connect, $user, 'Stock Opname');
		$lakses = $_SESSION['aksespakai'];
		if ($lakses == 1) {
			// $query = $connect->prepare("select * from opnameh where noopname=?");
			// $query->bind_param('s', $_GET['noopname']);
			// $query->execute();
			// $result = $query->get_result();
			// $de = $result->fetch_assoc();
			$sql = mysqli_query($connect, "select * from opnameh where noopname='$_GET[noopname]'");
			$de = mysqli_fetch_assoc($sql);
			$noopname = strip_tags($de['noopname']);
			$proses = strip_tags($de['proses']);
			$tglopname = strip_tags($de['tglopname']); ?>

			<font face='calibri'>
				<div class='panel panel-danger'>
					<div class='panel-heading'>
						<font size="4">TAMBAH DATA DETAIL STOCK OPNAME</font>
					</div>
					<div class='panel-body'>
						<form method='post' name='opname' enctype='multipart/form-data' action='module/opname/proses_tambah_detail.php'>
							<input type='hidden' name='username' value="<?= $user ?>">
							<a class="btn btn-success" href="?m=opname&tipe=import&noopname=<?= $noopname ?>">Import data</a>
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-hover">
									<tr>
										<td>Nomor OPNAME</td>
										<td>
											<input type='text' class='form-control' id='noopname' name='noopname' placeholder='No. OPNAME *' style='text-transform:uppercase' value="<?= $noopname ?>" readonly>
										</td>
										<td>Tgl. (M/D/Y)</td>
										<td><input type='date' class='form-control' id='tglopname' name='tglopname' value="<?= $tglopname ?>" size='50' autocomplete='off' readonly></td>
									</tr>
								</table>
							</div>
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-hover">
									<tr>
										<th>Kode Barang <input type="button" class="btn btn-black btn-sm" value="Clear" onclick="eraseText()"></th>
										<th>Nama Barang</th>
										<th>Lokasi</th>
										<th>Jumlah</th>
										<th>Aksi</th>
									</tr>
									<td>
										<div class='input-group'> <input type='text' class='form-control' style='text-transform:uppercase' id='kdbarang' name='kdbarang' autocomplete='off' required>
											<span class='input-group-btn'>
												<button type='button' id='src' class='btn btn-primary' onclick='cari_data_tbbarang()'>
													Cari
												</button>
											</span>
									</td>
									</td>
									<td><input type='text' class='form-control' id='nmbarang' name='nmbarang' readonly></td>
									</td>
									<td><input type='text' class='form-control' id='lokasi' name='lokasi' readonly></td>
									</td>
									<td><input type="text" class='form-control' id='qty' name='qty' style='width: 6em' onkeyup="validAngka(this)" required></td>
									<td align='center' width='50px'>
										<button type='submit' class="btn btn-primary btn-sm">+</button>
								</table>
							</div>

							<div class="table-responsive">
								<table class="table table-bordered table-striped table-hover">
									<tr>
										<th width='50'>No.</th>
										<th width='170'>Kode Barang</th>
										<th>Nama Barang</th>
										<th>Lokasi</th>
										<th>Jumlah</th>
										<th>Aksi</th>
									</tr>
									<?php
									$tampil = mysqli_query($connect, "select * from opnamed where noopname='$_GET[noopname]'");
									// $query = $connect->prepare("select * from opnamed where noopname=?");
									// $query->bind_param('s', $_GET['noopname']);
									// $query->execute();
									// $result = $query->get_result();
									// $de = $result->fetch_assoc();
									$no = 1;
									//<td><u><a href='?m=wo&tipe=detail&id=$k[id]'><font color='blue'>$k[kode]</font></a></u></td>
									//<td><u><a href='#' onclick =lihat_detail('$k[id]');><font color='blue'>$k[kdbarang]</font></a></u></td>
									while ($k = mysqli_fetch_assoc($tampil)) {
										$kdbarang = strip_tags($k['kdbarang']);
										$nmbarang = strip_tags($k['nmbarang']);
										$lokasi = strip_tags($k['lokasi']);
										$qty = number_format($k['qty'], 2, ",", ".");
										//$date = date("m/d/Y", strtotime($k['tglwo']));
										echo "<tr><td align='center'>$no</td>
		            <td>$k[kdbarang]</td>
								<td>$k[nmbarang]</td>
								<td>$k[lokasi]</td>
								<td align='right'>$qty</td>
								<td align='center' width='145px'>";
										echo "<a class='btn btn-primary btn-sm' href='?m=opname&tipe=edit_detail&id=$k[id]&noopname=$k[noopname]'>Edit</a> ";
										echo " <input button type='Button' class='btn btn-danger btn-sm' value='Hapus' onClick='alert_hapus_detail($k[id])'/>";
										$no++;
									}
									?>
								</table>
							</div>
							<div class="table-responsive">
								<!--<input button type='Button' class='btn btn-danger' value='Close' onClick='history.back()'/>-->
								<input button type='Button' class='btn btn-danger' value='Close' onClick="window.location = 'dashboard.php?m=opname'" />
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
}

if (isset($_GET['tipe'])) {
	if ($_GET['tipe'] == 'edit_detail') {
		cekakses($connect, $user, 'Stock Opname');
		$lakses = $_SESSION['aksespakai'];
		if ($lakses == 1) {
			// $query = $connect->prepare("select * from opnameh where noopname=?");
			// $query->bind_param('s', $_GET['noopname']);
			// $query->execute();
			// $result = $query->get_result();
			// $de = $result->fetch_assoc();
			$sql = mysqli_query($connect, "select * from opnameh where noopname='$_GET[noopname]'");
			$de = mysqli_fetch_assoc($sql);
			$noopname = strip_tags($de['noopname']);
			$tglopname = strip_tags($de['tglopname']); ?>
			<font face='calibri'>
				<div class='panel panel-default'>
					<div class='panel-heading'>
						<font size="4">EDIT DETAIL DATA STOCK OPNAME</font>
					</div>
					<div class='panel-body'>
						<form method='post' name='opname' enctype='multipart/form-data' action='module/opname/proses_edit_detail.php'>
							<input type='hidden' name='username' value="<?= $user ?>">
							<div class='col-md-12'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<!--<font face='calibri'>
					<h3>Edit Detail STOCK OPNAME</h3>
					<form method='post' enctype='multipart/form-data' action='module/opname/proses_edit_detail.php'>
						<input type='hidden' name='username' value='<?= $user ?>'>
 						<table class="table table-bordered table-striped table-hover">-->
									<tr>
										<td>Nomor Opname</td>
										<td>
											<input type='text' class='form-control' id='noopname' name='noopname' placeholder='No. OPNAME *' style='text-transform:uppercase' value="<?= $noopname ?>" readonly>
										</td>
										<td>Tgl. (M/D/Y)</td>
										<td><input type='date' class='form-control' id='tglopname' name='tglopname' value="<?= $tglopname ?>" size='50' autocomplete='off' readonly></td>
									</tr>
								</table>
							</div>

							<div class='col-md-12'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<th width='170'>Kode Barang <input type="button" class='btn btn-black' value="Clear" onclick="eraseText()"></th>
										<th width='170'>Barang</th>
										<th>Lokasi</th>
										<th>QTY</th>
									</tr>
									<?php
									// $query = $connect->prepare("select * from opnamed where id=?");
									// $query->bind_param('s', $_GET['id']);
									// $query->execute();
									// $result = $query->get_result();
									// $de = $result->fetch_assoc();
									$sql = mysqli_query($connect, "select * from opnamed where id='$_GET[id]'");
									$de = mysqli_fetch_assoc($sql);
									$kdbarang = strip_tags($de['kdbarang']);
									$nmbarang = strip_tags($de['nmbarang']);
									$lokasi = strip_tags($de['lokasi']);
									$qty = number_format($de['qty'], 2, ",", ".");
									$qty = str_replace(",", ".", $qty);
									?>
									<input type='hidden' name='id' value='<?= $de['id'] ?>'>
									<input type='hidden' name='noopname' value='<?= $de['noopname'] ?>'>
									<td>
										<div class='input-group'> <input type='text' class='form-control' style='width: 10em' id='kdbarang' name='kdbarang' value='<?= $kdbarang ?>' size='50' autocomplete='off' required readonly>
											<span class='input-group-btn'>
												<!--<button type='button' id='src' class='btn btn-primary' onclick='cari_data_barang()'>
								Cari
							</button>-->
											</span>
									</td>
									</td>
									<td><input type='text' class='form-control' id='nmbarang' name='nmbarang' value='<?= $nmbarang ?>' readonly></td>
									</td>
									<td><input type='text' class='form-control' id='lokasi' name='lokasi' value='<?= $lokasi ?>' readonly></td>
									</td>
									<td><input type="text" class='form-control' id='qty' name='qty' value='<?= $qty ?>' style='width: 9em' onkeyup="validAngka(this)"></td>
								</table>
							</div>
							<div class='col-md-12'>
								<button type='submit' class='btn btn-primary'>Simpan</button>
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
	}
}

if (isset($_GET['tipe'])) {
	if ($_GET['tipe'] == 'tambah') {
		cekakses($connect, $user, 'Stock Opname');
		$lakses = $_SESSION['aksestambah'];
		$tgl = date('Y-m-d');
		if ($lakses == 1) { ?>
			<font face='calibri'>
				<div class='panel panel-danger'>
					<div class='panel-heading'>
						<font size="4">TAMBAH DATA STOCK OPNAME</font>
					</div>
					<div class='panel-body'>
						<form method='post' name='opname' enctype='multipart/form-data' action='module/opname/proses_tambah.php'>
							<input type='hidden' name='username' value="<?= $user ?>">
							<div class='col-md-12'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>Nomor Order</td>
										<td>
											<input type='text' class='form-control' id='noopname' name='noopname' placeholder='No. Opname *' style='text-transform:uppercase' value="<?php echo autoNumberOP($connect, 'id', 'opnameh'); ?>" readonly>
										</td>
									</tr>
									<tr>
										<td>Tanggal (M/D/Y)</td>
										<td><input type='date' class='form-control' id='tglopname' name='tglopname' value="<?php echo $tgl ?>" size='50' autocomplete='off' required></td>
									</tr>
									<tr>
										<td>Pelaksana</td>
										<td> <input type="text" class='form-control' id='pelaksana' name='pelaksana' </size='50' autocomplete='off' autofocus='autofocus' required></td>
									</tr>
									<tr>
										<td>Keterangan</td>
										<td><textarea type='text' rows='2' class='form-control' id='kerangan' name='keterangan' autocomplete='off'></textarea></td>
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
		cekakses($connect, $user, 'Stock Opname');
		$lakses = $_SESSION['aksesedit'];
		if ($lakses == 1) {
			// $query = $connect->prepare("select * from opnameh where id=?");
			// $query->bind_param('i', $_GET['id']);
			// $query->execute();
			// $result = $query->get_result();
			// $de = $result->fetch_assoc();
			$sql = mysqli_query($connect, "select * from opnameh where id='$_GET[id]'");
			$de = mysqli_fetch_assoc($sql);
			$noopname = strip_tags($de['noopname']);
			$tglopname = strip_tags($de['tglopname']);
			$pelaksana = strip_tags($de['pelaksana']);
			$keterangan = strip_tags($de['keterangan']);
		?>
			<font face='calibri'>
				<div class="panel panel-default">
					<div class="panel-heading">
						<font size="4">EDIT DATA STOCK OPNAME</font>
					</div>
					<div class="panel-body">
						<form method='post' name='opname' enctype='multipart/form-data' action='module/opname/proses_edit.php'>
							<input type='hidden' name='username' value="<?= $user ?>">
							<input type='hidden' name='id' value="<?= $de['id'] ?>" />
							<div class='col-md-12'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>Nomor Opname</td>
										<td>
											<input type='text' class='form-control' id='noopname' name='noopname' placeholder='No. Order *' style='text-transform:uppercase' value="<?= $noopname ?>" readonly>
										</td>
									</tr>
									<tr>
										<td>Tgl. (M/D/Y)</td>
										<td><input type='date' class='form-control' id='tglopname' name='tglopname' value="<?php echo $tglopname ?>" size='50' autocomplete='off' required></td>
									</tr>
									<tr>
										<td>Pelaksana</td>
										<td> <input type="text" class='form-control' id='pelaksana' name='pelaksana' </size='50' value="<?= $pelaksana ?>" autocomplete='off' autofocus='autofocus' required></td>
									</tr>
									<tr>
										<td>Keterangan</td>
										<td><textarea type='text' class='form-control' id='keterangan' name='keterangan' autocomplete='off'><?= $keterangan ?></textarea></td>
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
					<font size="4">STOCK OPNAME</font>
				</div>
				<div class="panel-body">
					<form method='post'>
						<div class="row">
							<div class="col-md-12 bg">
								<a class="btn btn-danger" href="?m=opname&tipe=tambah">Tambah data</a>
								<!--<a class="btn btn-success" href="?m=opname&tipe=import">Import data</a>-->
								<a class="btn btn-warning" href="?m=opname&tipe=export">Export data</a>
							</div>
						</div>
					</form>
					</br>
					<div class="box-body table-responsive">
						<table id="example1" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th width='40'>No.</th>
									<th>No.Opname</th>
									<th>Tgl.Opname</th>
									<th>Pelaksana</th>
									<th>Keterangan</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<?php
							$tampil = mysqli_query($connect, "SELECT * FROM opnameh order by noopname");
							$no = 1;
							while ($k = mysqli_fetch_assoc($tampil)) {
								$date = date("m/d/Y", strtotime($k['tglopname']));
								echo "<tr>
	        <td align='center'>$no</td>
					<td width='110'><u><a href='#' onclick =lihat_detail('$k[noopname]');><font color='blue'>$k[noopname]</font></a></u></td>
					<td width='80'>$date</td>
					<td width='110'>$k[pelaksana]</td>
					<td width='250'>$k[keterangan]</td>
					<td align='center' width='300px'>";
								//echo "<a class='btn btn-success' href='?m=opname&tipe=detail&id=$k[id]'>Upd.Dtl</a> ";
								if ($k['proses'] == 'Y') {
									echo "<a class='btn btn-success btn-sm' href='?m=opname&tipe=detail_proses&noopname=$k[noopname]'>Detail</a> ";
								} else {
									echo "<a class='btn btn-success btn-sm' href='?m=opname&tipe=detail&noopname=$k[noopname]'>Detail</a> ";
								}

								cekakses($connect, $user, 'Stock Opname');
								$lakses = $_SESSION['aksesedit'];
								if ($lakses == 1) {
									if ($k['proses'] == 'Y') {
										echo "<a class='btn btn-info btn-sm' href='?m=opname&tipe=edit&id=$k[id]' disabled>Edit</a>";
									} else {
										echo "<a class='btn btn-info btn-sm' href='?m=opname&tipe=edit&id=$k[id]'>Edit</a>";
									}
								} else {
									echo "<a class='btn btn-info btn-sm' href='?m=opname&tipe=edit&id=$k[id]' disabled>Edit</a>";
								}

								include "tombol-tombol.php";

								$lakses = $_SESSION['aksescetak'];
								if ($lakses == 1) {
									if ($k['proses'] == 'N') {
										echo " <button type='button' class='btn btn-info btn-sm' onClick='alert_cetak($k[id])' disabled/>
							    <span class='glyphicon glyphicon-print'></span>
							  </button>";
									} else {
										echo " <button type='button' class='btn btn-info btn-sm' onClick='alert_cetak($k[id])'/>
							    <span class='glyphicon glyphicon-print'></span>
							  </button>";
									}
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

			<!-- Modal -->
			<div class="modal fade" id="modaldetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
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
			<script type="text/javascript">
				$(document).ready(function() {
					$('#kdbarang').on('blur', function(e) {
						let cari = $(this).val();
						$.ajax({
							url: 'repl_tbbarang.php',
							type: 'post',
							data: {
								kode_barang: cari
							},
							success: function(response) {
								let data_response = JSON.parse(response);
								if (!data_response) {
									$('#nmbarang').val('');
									$('#kdsatuan').val('');
									$('#lokasi').val('');
									cari_data_tbbarang();
									return;
								}
								$('#nmbarang').val(data_response['nama']);
								$('#kdsatuan').val(data_response['kdsatuan']);
								$('#harga').val(data_response['harga']);
								$('#lokasi').val(data_response['lokasi']);
								//console.log(data_response['nama']);
								//console.log(data_response['satuan']);
							},
							error: function() {
								console.log('file not fount');
							}
						})
						// console.log(cari);
					})
				})




				function lihat_detail(id) {
					$('#modaldetail').modal('show');
					//$('#modaldetail').find('.modal-body').html(id);
					$.ajax({
						url: './module/opname/lihat_detail.php',
						type: 'post',
						data: {
							kode: id
						},
						success: function(response) {
							$('#modaldetail').find('.modal-body').html(response);
						}
					});
				}


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
								$href = "module/opname/proses_hapus.php?id=";
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

			<script>
				function alert_hapus_detail($id) {
					swal({
							title: "Yakin akan dihapus ?",
							text: "Once deleted, you will not be able to recover this data!",
							icon: "warning",
							buttons: true,
							dangerMode: true,
						})
						.then((willDelete) => {
							if (willDelete) {
								$href = "module/opname/proses_hapus_detail.php?id=";
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

			<script>
				function alert_proses($id) {
					swal({
							title: "Yakin akan diproses ?",
							text: "",
							icon: "warning",
							buttons: true,
							dangerMode: true,
						})
						.then((willDelete) => {
							if (willDelete) {
								$href = "module/opname/proses.php?id=";
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

			<script>
				function alert_unproses($id) {
					swal({
							title: "Yakin akan di Batal Proses ?",
							text: "",
							icon: "warning",
							buttons: true,
							dangerMode: true,
						})
						.then((willDelete) => {
							if (willDelete) {
								$href = "module/opname/batal_proses.php?id=";
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

			<script type="text/javascript">
				function hit_subtotal() {
					var lharga = (parseInt(document.getElementById('qty').value) * parseInt(document.getElementById('harga').value));
					var ldisc = lharga - (lharga * (document.getElementById('discount').value)) / 100;
					var lsubtotal = ldisc;
					document.getElementById('subtotal').value = lsubtotal;
				}
			</script>

			<script type="text/javascript">
				function hit_total() {
					var lbiaya_lain = parseInt(document.getElementById('biaya_lain').value);
					var ltotal_sementara = (parseInt(document.getElementById('biaya_lain').value) + parseInt(document.getElementById('subtotal').value));
					var lppn = ltotal_sementara * (parseInt(document.getElementById('ppn').value) / 100);
					var lmaterai = parseInt(document.getElementById('materai').value);
					var ltotal = ltotal_sementara + lmaterai + lppn;
					document.getElementById('total_sementara').value = ltotal_sementara;
					document.getElementById('total').value = ltotal;
				}
			</script>

			<script type="text/javascript">
				function eraseText() {
					document.getElementById("kdbarang").value = "";
					document.getElementById("nmbarang").value = "";
					document.getElementById("kdsatuan").value = "";
					document.getElementById("qty").value = "";
					document.getElementById("harga").value = "";
					document.getElementById("discount").value = "";
					document.getElementById("subtotal").value = "";
					document.getElementById("lokasi").value = "";
				}
			</script>

			<script>
				function alert_cetak($id) {
					swal({
							title: "Yakin akan di Cetak ?",
							text: "",
							icon: "warning",
							buttons: true,
							dangerMode: true,
						})
						.then((willCetak) => {
							if (willCetak) {
								$href = "module/opname/cetak.php?id=";
								window.open($href + $id, "_blank");
								//window.location.href = $href+$id;
								// swal("Poof! Your imaginary file has been deleted!", {
								//   icon: "success",
								// });
							} else {
								//swal("Batal Hapus!");
							}
						});
				};
			</script>