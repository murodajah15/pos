<?php
$user = $_SESSION['username'];
include 'autonumber.php';
if (isset($_GET['tipe'])) {
	if ($_GET['tipe'] == 'detail_proses') {
		cekakses($connect, $user, 'Penerimaan Pembelian');
		$lakses = $_SESSION['aksespakai'];
		if ($lakses == 1) { ?>
			<font face='calibri'>
				<h3>Detail Penerimaan Pembelian : <?= $_GET['nobeli'] ?></h3><br>
				<form method='post'>
					<div class="row">
						<div class="col-md-4 bg">
							<input type="text" id='kata' name='kata' size='50px' class='form-control' placeholder='Kode, Nama' onkeyup='searchTable()'>
						</div>
						<?php
						include 'hal.php';
						?>
						<button type='submit' name='kata2' class='btn btn-primary'>
							<span class='glyphicon glyphicon-search'></span> Cari</button>
						<!--<a class="btn btn-danger" href="?m=beli&tipe=tambah_detail">Tambah data</a>
							<a class="btn btn-success" href="?m=beli&tipe=import">Import data</a>-->
					</div>
					<input type='hidden' name='username' value='<?= $user ?>'>
					<table class="table table-bordered table-striped table-hover">
						<!-- 						<tr><td>Nomor Penerimaan</td><td>
						<input type='text' class='form-control' id='nobeli' name='nobeli' placeholder='No. Penerimaan *' style='text-transform:uppercase' value="<?= $nobeli ?>" readonly></td>
						<td>Tgl. (M/D/Y)</td><td><input type='date' class='form-control' id='tglbeli' name='tglbeli' value="<?= $tglbeli ?>" size='50' autocomplete='off' readonly></td></tr> -->
					</table>
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-hover">
							<tr>
								<th width='50'>No.</th>
								<th width='100'>No. Order</th>
								<th width='170'>Kode Barang</th>
								<th>Nama Barang</th>
								<th width='70'>Satuan</th>
								<th>QTY</th>
								<th>harga</th>
								<th>Discount</th>
								<th>Subtotal</th>
							</tr>
							<?php
							// $tampil = mysqli_query($connect, "select * from belid where nobeli='$_GET[nobeli]'");
							// $query = $connect->prepare("select * from belid where nobeli=?");
							// $query->bind_param('s', $_GET['nobeli']);
							// $query->execute();
							// $result = $query->get_result();
							// $de = $result->fetch_assoc();
							$sql = mysqli_query($connect, "select * from belid where nobeli='$_GET[nobeli]'");
							$de = mysqli_fetch_assoc($sql);
							$nopo = strip_tags($de['nopo']);
							$no = 1;
							//<td><u><a href='#' onclick =lihat_detail('$k[id]');><font color='blue'>$k[nopo]</font></a></u></td>
							while ($k = mysqli_fetch_assoc($tampil)) {
								//$date = date("m/d/Y", strtotime($k['tglwo']));
								$kdbarang = strip_tags($k['kdbarang']);
								$nmbarang = strip_tags($k['nmbarang']);
								$qty = number_format($k['qty'], 2, ",", ".");
								$harga = number_format($k['harga'], 0, ",", ".");
								$discount = number_format($k['discount'], 2, ",", ".");
								$subtotal = number_format($k['subtotal'], 0, ",", ".");
								echo "<tr><td align='center'>$no</td>
								<td width='100'>$k[nopo]</td>
								<td width='100'>$k[kdbarang]</td>
								<td width='300'>$k[nmbarang]</td>
								<td width='10'>$k[kdsatuan]</td>
								<td align='right'>$qty</td>
								<td align='right'>$harga</td>
								<td align='right'>$discount</td>
								<td align='right'>$subtotal</td>";
								$no++;
							}
							$tampil = mysqli_query($connect, "select sum(qty) as total_qty,sum(subtotal) as total_subtotal from belid where nobeli='$_GET[nobeli]'");
							$jum = mysqli_fetch_assoc($tampil);
							$total_qty = $jum['total_qty'];
							$total_qty = number_format($total_qty, 2, ",", ".");
							$total = $jum['total_subtotal'];
							$total = number_format($total, 0, ",", ".");
							echo "<tr><td colspan='5'></td>
							<td align='right' style='font-weight:bold'>$total_qty</td>
							<td align='right' colspan='3' style='font-weight:bold'>$total</td>";
							?>
						</table>
					</div>
					<input button type="Button" class="btn btn-danger" value="Close" onClick="history.back()" />
					<!--<input button type='Button' class='btn btn-danger' value='Close' onClick="window.location = 'dashboard.php?m=beli'" />-->
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
		cekakses($connect, $user, 'Penerimaan Pembelian');
		$lakses = $_SESSION['aksespakai'];
		// $query = $connect->prepare("select * from belih where id=?");
		// $query->bind_param('s', $_GET['id']);
		// $query->execute();
		// $result = $query->get_result();
		// $de = $result->fetch_assoc();
		$sql = mysqli_query($connect, "select * from belih where id='$_GET[id]'");
		$de = mysqli_fetch_assoc($sql);
		$nobeli = strip_tags($de['nobeli']);
		if ($lakses == 1) { ?>
			<font face='calibri'>
				<div class="panel panel-info">
					<div class="panel-heading">
						<font size="4">EDIT DETAIL PENERIMAAN PEMBELIAN : <?= $nobeli ?></font>
					</div>
					<div class="panel-body">
						<!-- <form method='post'> -->
						<!-- <div class="col-md-4 bg">
							<input type="text" id='kata' name='kata' size='50px' class='form-control' placeholder='Kode, Nama' onkeyup='searchTable()'>
						</div> -->
						<?php
						// include 'hal.php';
						?>
						<!-- <button type='submit' name='kata2' class='btn btn-primary'>
							<span class='glyphicon glyphicon-search'></span> Cari</button> -->
						<!--<a class="btn btn-danger" href="?m=beli&tipe=tambah_detail">Tambah data</a>
							<a class="btn btn-success" href="?m=beli&tipe=import">Import data</a>-->
						<!-- </div> -->
						<div class="col-md-12">
							<input type='hidden' name='username' value='<?= $user ?>'>
							<!-- <table class="table table-bordered table-striped table-hover"> -->
							<!-- 						<tr><td>Nomor Penerimaan</td><td>
						<input type='text' class='form-control' id='nobeli' name='nobeli' placeholder='No. Penerimaan *' style='text-transform:uppercase' value="<?= $nobeli ?>" readonly></td>
						<td>Tgl. (M/D/Y)</td><td><input type='date' class='form-control' id='tglbeli' name='tglbeli' value="<?= $tglbeli ?>" size='50' autocomplete='off' readonly></td></tr> -->
							<!-- </table> -->
							<form method='post' enctype='multipart/form-data' action='module/beli/proses_tambah_detail.php'>
								<input type='hidden' name='username' value='<?= $user ?>'>
								<input type='hidden' name='nobeli' value='<?= $nobeli ?>'>
								<input type='hidden' name='id' value='<?= $_GET['id'] ?>'>

								<div class="input-group">
									<span class="input-group-addon">No. PO</span>
									<input type="text" class="form-control" name='nopo' id='nopo' size='50' placeholder="No. PO" readonly>
									<span class='input-group-btn'></span>
									<button type='button' id='src' class='btn btn-primary' onclick='cari_data_po()'>Cari</button>
									<span class='input-group-btn'></span><button type='submit' class='btn btn-success'>+</button>
								</div>
								<br>
								<div class="table-responsive">
									<table class="table table-bordered table-striped table-hover">
										<tr>
											<th>Kode Barang <input type="button" class='btn btn-black' value="Clear" onclick="eraseText()"></th>
											<th>Barang</th>
											<th>QTY</th>
											<th>Harga</th>
											<th>Disc</th>
											<th>Subtotal</th>
											<th>Aksi</th>
										</tr>
										<td>
											<div class='input-group'> <input type='text' class='form-control' id='kdbarang' name='kdbarang' size='50' style="text-transform: uppercase; width: 9em;" autocomplete='off'>
												<span class='input-group-btn'>
													<button type='button' id='src' class='btn btn-primary' onclick='cari_data_barang_beli()'>Cari</button>
												</span>
										</td>
										<input type='hidden' class='form-control' style='width: 15em' id='kdsatuan' name='kdsatuan' readonly>
										</td>
										<td><input type='text' class='form-control' style='width: 15em' id='nmbarang' name='nmbarang' readonly></td>
										</td>
										<td><input type="text" class='form-control' value='1' id='qty' name='qty' style='width: 6em' onkeyup="validAngka(this)" onblur="hit_subtotal()"></td>
										</td>
										<td><input type="text" class='form-control' value='0' id='harga' name='harga' style='width: 7em' onkeyup="validAngka_no_titik(this)" onblur="hit_subtotal()"></td>
										</td>
										<td><input type="text" class='form-control' value='0' id='discount' name='discount' style='width: 6em' onkeyup="validAngka(this)" onblur="hit_subtotal()"></td>
										</td>
										<td><input type="number" class='form-control' value='0' id='subtotal' name='subtotal' style='width: 10em' readonly></td>
										<td align='center' width='50px'>
											<button type='submit' class='btn btn-primary'>+</button>
									</table>
									<form>
								</div>

								<div class="table-responsive">
									<table class="table table-bordered table-striped table-hover">
										<tr>
											<th width='50'>No.</th>
											<th width='100'>No. Order</th>
											<th width='170'>Kode Barang</th>
											<th>Nama Barang</th>
											<th width='70'>Satuan</th>
											<th>QTY</th>
											<th>harga</th>
											<th>Discount</th>
											<th>Subtotal</th>
											<th>Aksi</th>
										</tr>
										<?php
										$tampil = mysqli_query($connect, "select * from belid where nobeli='$nobeli'");
										// $query = $connect->prepare("select * from belid where nobeli=?");
										// $query->bind_param('s', $nobeli);
										// $query->execute();
										// $result = $query->get_result();
										// $de = $result->fetch_assoc();
										// $nopo = strip_tags($de['nopo']);
										$no = 1;
										//<td><u><a href='#' onclick =lihat_detail('$k[id]');><font color='blue'>$k[nopo]</font></a></u></td>
										// <td><input type='number' name='qty' id='qty' value='$k[qty]' style='text-align: right; width: 6em' onkeyup='hitung_subtotal_belih()'></td>

										while ($k = mysqli_fetch_assoc($tampil)) {
											//$date = date("m/d/Y", strtotime($k['tglwo']));
											$kdbarang = strip_tags($k['kdbarang']);
											$nmbarang = strip_tags($k['nmbarang']);
											$qty = number_format($k['qty'], 2, ",", ".");
											$harga = number_format($k['harga'], 0, ",", ".");
											$discount = number_format($k['discount'], 2, ",", ".");
											$subtotal = number_format($k['subtotal'], 0, ",", ".");
											echo "<tr><td align='center'>$no</td>
								<td width='100'>$k[nopo]</td>
								<td width='100'>$k[kdbarang]</td>
								<td width='300'>$k[nmbarang]</td>
								<td width='10'>$k[kdsatuan]</td>
								<td align='right'>$qty</td>
								<td align='right'>$harga</td>
								<td align='right'>$discount</td>
								<td align='right'>$subtotal</td>
								<td align='center' width='160px'>";
											echo "<a class='btn btn-success btn-sm' href='?m=beli&tipe=edit_detail&id=$k[id]'>Edit</a> ";
											echo " <input button type='Button' class='btn btn-danger btn-sm' value='Hapus' onClick='alert_hapus_detail($k[id])'/>";
											$no++;
										}
										$tampil = mysqli_query($connect, "select sum(qty) as total_qty,sum(subtotal) as total_subtotal from belid where nobeli='$nobeli'");
										$jum = mysqli_fetch_assoc($tampil);
										$total_qty = $jum['total_qty'];
										$total_qty = number_format($total_qty, 2, ",", ".");
										$total = $jum['total_subtotal'];
										$total = number_format($total, 0, ",", ".");
										echo "<tr><td colspan='5'></td>
							<td align='right' style='font-weight:bold'>$total_qty</td>
							<td align='right' colspan='3' style='font-weight:bold'>$total</td>";
										?>
									</table>
								</div>
								<input button type='Button' class='btn btn-danger' value='Close' onClick="window.location = 'dashboard.php?m=beli'" />
						</div>
						</form>
					</div>
				</div>
			</font>
		<?php
		} else {
			echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
		}
	}
}

if (isset($_GET['tipe'])) {
	if ($_GET['tipe'] == 'edit_detail') {
		cekakses($connect, $user, 'Edit Detail Penerimaan Pembelian');
		$lakses = $_SESSION['aksespakai'];
		if ($lakses == 1) {
			// $query = $connect->prepare("select * from belid where id=?");
			// $query->bind_param('i', $_GET['id']);
			// $query->execute();
			// $result = $query->get_result();
			// $de = $result->fetch_assoc();
			$sql = mysqli_query($connect, "select * from belid where id='$_GET[id]'");
			$de = mysqli_fetch_assoc($sql);
			$id = $_GET['id'];
			$nopo = strip_tags($de['nopo']);
			$nobeli = strip_tags($de['nobeli']);
			$kdbarang = strip_tags($de['kdbarang']);
			$nmbarang = strip_tags($de['nmbarang']);
			$kdsatuan = strip_tags($de['kdsatuan']);
			$qty = number_format($de['qty'], 2, ",", ".");
			$qty = str_replace(",", ".", $qty);
			$harga = strip_tags($de['harga']);
			$discount = number_format($de['discount'], 2, ",", ".");
			$discount = str_replace(",", ".", $discount);
			$subtotal = strip_tags($de['subtotal']); ?>
			<font face='calibri'>
				<h3>Edit Detail Penerimaan Pembelian</h3>
				<form method='post' enctype='multipart/form-data' action='module/beli/proses_edit_detail.php'>
					<input type='hidden' name='id' value='<?= $id ?>'>
					<input type='hidden' name='username' value='<?= $user ?>'>
					<input type='hidden' name='nopo' value='<?= $nopo ?>'>
					<input type='hidden' name='nobeli' value='<?= $nobeli ?>'>
					<table class="table table-bordered table-striped table-hover">
						<tr>
							<td>Nomor Penerimaan</td>
							<td>
								<input type='text' class='form-control' id='nobeli' name='nobeli' placeholder='No. WO *' style='text-transform:uppercase' value="<?= $nobeli ?>" readonly>
							</td>
					</table>
					<table class="table table-bordered table-striped table-hover">
						<td>
							<div class='input-group'> <input type='text' class='form-control' id='kdbarang' name='kdbarang' value='<?= $kdbarang ?>' size='50' autocomplete='off' readonly required>
								<!--<span class='input-group-btn'>
								<button type='button' id='src' class='btn btn-primary' onclick='cari_data_barang()'>
									Cari
								</button>
							</span></td>-->
						</td>
						<td><input type='text' class='form-control' style='width: 15em' id='nmbarang' name='nmbarang' value='<?= $nmbarang ?>' readonly></td>
						</td>
						<td><input type='text' class='form-control' style='width: 5em' id='kdsatuan' name='kdsatuan' value='<?= $kdsatuan ?>' readonly></td>
						</td>
						<td><input type="text" class='form-control' id='qty' name='qty' value='<?= $qty ?>' style='width: 6em' required onkeyup="validAngka(this)" onblur="hit_subtotal()"></td>
						</td>
						<td><input type="text" class='form-control' id='harga' name='harga' value='<?= $harga ?>' style='width: 8em' onkeyup="validAngka_no_titik(this)" onblur="hit_subtotal()"></td>
						</td>
						<td><input type="text" class='form-control' id='discount' name='discount' value='<?= $discount ?>' style='width: 6em' onkeyup="validAngka(this)" onblur="hit_subtotal()"></td>
						</td>
						<td><input type="number" class='form-control' id='subtotal' name='subtotal' value='<?= $subtotal ?>' style='width: 10em' readonly></td>
					</table>
					<button type='submit' class='btn btn-success'>Simpan</button>
					<input button type="Button" class="btn btn-danger" value="Close" onClick="history.back()" />
					<!--<input button type='Button' class='btn btn-danger' value='Close' onClick="window.location = 'dashboard.php?m=beli'"></input>-->
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
		cekakses($connect, $user, 'PENERIMAAN PEMBELIAN');
		$lakses = $_SESSION['aksestambah'];
		$de = mysqli_fetch_assoc(mysqli_query($connect, "select * from saplikasi where aktif='Y'"));
		$tgl = $de['tgl_berikutnya']; //date('Y-m-d')
		if ($lakses == 1) { ?>
			<font face='calibri'>
				<div class='panel panel-danger'>
					<div class='panel-heading'>
						<font size="4">TAMBAH DATA PENERIMAAN PEMBELIAN</font>
					</div>
					<div class='panel-body'>
						<form method='post' name='po' enctype='multipart/form-data' action='module/beli/proses_tambah.php'>
							<input type='hidden' name='username' value="<?= $user ?>">
							<div class='col-md-6'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>Nomor Pembelian</td>
										<td>
											<input type='text' class='form-control' id='nobeli' name='nobeli' id='nobeli' placeholder='No. Order *' style='text-transform:uppercase' value="<?php echo autoNumberBE($connect, 'id', 'belih'); ?>" readonly>
										</td>
									</tr>
									<tr>
										<td>Tgl. (M/D/Y)</td>
										<td><input type='date' class='form-control' id='tglbeli' name='tglbeli' value="<?php echo $tgl ?>" size='50' autocomplete='off' required readonly></td>
									</tr>
									<tr>
										<td>No. Invoice</td>
										<td><input type='text' class='form-control' id='noinvoice' name='noinvoice' size='50' autocomplete='off' required></td>
									</tr>
									<tr>
										<td>Tgl. Invoice (M/D/Y)</td>
										<td><input type='date' class='form-control' id='tglinvoice' name='tglinvoice' size='50' autocomplete='off' required></td>
									</tr>
									<tr>
										<td>Supplier</td>
										<td>
											<div class='input-group'> <input type='text' class='form-control' id='kdsupplier' name='kdsupplier' size='50' autocomplete='off' readonly required>
												<span class='input-group-btn'>
													<button type='button' id='src' class='btn btn-primary' onclick='cari_data_supplier()'>Cari</button>
												</span>
										</td>
									<tr>
										<td></td>
										<td> <input type="text" class='form-control' id='nmsupplier' name='nmsupplier' size='50' readonly required></td>
									</tr>
									<tr>
										<td>Jenis Order
										<td><select required id='jenis_order' name='jenis_order' id='jenis_order' class='form-control' style='width: 200x;'>
												<option value="URGENT">URGENT</option>
												<option value="NORMAL">NORMAL</option>
												<option value="LAIN">LAIN-LAIN</option>
											</select>
									<tr>
										<td>Biaya Lain</td>
										<td> <input type="text" class='form-control' name='ket_biaya_lain' id='ket_biaya_lain'></td>
									</tr>
									<tr>
										<td></td>
										<td> <input type="number" class='form-control' name='biaya_lain' id='biaya_lain' size='50' value='0' required onkeyup="hit_total()" onblur="hit_total()"></td>
									</tr>
									<tr>
										<td>Tanggal Kirim<br>(M/D/Y)</br></td>
										<td> <input type="date" class='form-control' name='tglkirim' id='tglkirim' size='50' required></td>
									</tr>
									<tr>
										<td>Gudang
										<td><select id='kdgudang' name='kdgudang' class='form-control' style='width: 200x;' onchange='changeValueGudang(this.value)'>
												<!--<option value=''> - PILIH SATUAN BARANG - </option>";-->
												<?php
												$jsArrayGudang = "var prdNameGudang = new Array();\n";
												$data = mysqli_query($connect, 'select * from tbgudang order by nama');
												while ($row = mysqli_fetch_array($data)) {
													echo '<option name="kdgudang"  value="' . $row['kode'] . '">' . $row['kode'] . '|' . $row['nama'] . '</option>';
													$jsArraySatuan .= "prdNameGudang['" . $row['kode'] . "'] = {nmgudang:'" . addslashes($row['nama']) . "',kdgudang:'" . addslashes($row['kode']) . "'};\n";
												}
												echo '</select>';
												?>
												<input type='hidden' class='form-control' size='50' id='nmgudang' name='nmgudang' readonly>
								</table>
							</div>
							<div class='col-md-6'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>Cara Bayar
										<td><select required id='carabayar' name='carabayar' id='carabayar' class='form-control' style='width: 200x;'>
												<!--<option value=''> - PILIH CARA BAYAR - </option>";?>-->
												<option value="TUNAI">TUNAI</option>
												<option value="KARTU-KREDIT">KARTU-KREDIT</option>
												<option value="GIRO">GIRO</option>
												<option value="CEK">CEK</option>
											</select>
									<tr>
										<td>Tempo (Hari)</td>
										<td> <input type="number" class='form-control' name='tempo' id='tempo' size='50'></td>
									</tr>
									<tr>
										<td>Tanggal Jatuh Tempo<br>(M/D/Y)</br></td>
										<td> <input type="date" class='form-control' name='tgl_jt_tempo' id='tgl_jt_tempo' size='50'></td>
									</tr>
									<tr>
										<td>Subtotal</td>
										<td> <input type="number" class='form-control' name='subtotal' id='subtotal' value='0' size='50' readonly></td>
									</tr>
									<tr>
										<td>Total Sementara</td>
										<td> <input type="number" class='form-control' id='total_sementara' name='total_sementara' size='50' value='0' readonly></td>
									</tr>
									<tr>
										<td>PPn</td>
										<td> <input type="number" class='form-control' name='ppn' id='ppn' size='50' value='0' onkeyup="hit_total()" onblur="hit_total()"></td>
									</tr>
									<tr>
										<td>Materai</td>
										<td> <input type="number" class='form-control' name='materai' id='materai' size='50' value='0' onkeyup="hit_total()" onblur="hit_total()"></td>
									</tr>
									<tr>
										<td>Total</td>
										<td> <input type="number" class='form-control' name='total' id='total' size='50' value='0' readonly></td>
									</tr>
									<tr>
										<td>Keterangan</td>
										<td><textarea type='text' rows='2' class='form-control' id='kerangan' name='keterangan' autocomplete='off'></textarea></td>
									</tr>
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
	} elseif ($_GET['tipe'] == 'edit') {
		cekakses($connect, $user, 'Penerimaan Pembelian');
		$lakses = $_SESSION['aksesedit'];
		if ($lakses == 1) {
			$sql = mysqli_query($connect, "select * from belih where id='$_GET[id]'");
			$de = mysqli_fetch_assoc($sql);
			// $query = $connect->prepare("select * from belih where id=?");
			// $query->bind_param('i', $_GET['id']);
			// $query->execute();
			// $result = $query->get_result();
			// $de = $result->fetch_assoc();
			$nobeli = strip_tags($de['nobeli']);
			$tglbeli = strip_tags($de['tglbeli']);
			$noinvoice = strip_tags($de['noinvoice']);
			$tglinvoice = strip_tags($de['tglinvoice']);
			$kdsupplier = strip_tags($de['kdsupplier']);
			$nmsupplier = strip_tags($de['nmsupplier']);
			$jenis_order = strip_tags($de['jenis_order']);
			$tglkirim = strip_tags($de['tglkirim']);
			$biaya_lain = strip_tags($de['biaya_lain']);
			$ket_biaya_lain = strip_tags($de['ket_biaya_lain']);
			$carabayar = strip_tags($de['carabayar']);
			$tempo = strip_tags($de['tempo']);
			$tgl_jt_tempo = strip_tags($de['tgl_jt_tempo']);
			$subtotal = strip_tags($de['subtotal']);
			$total_sementara = strip_tags($de['total_sementara']);
			$ppn = strip_tags($de['ppn']);
			$materai = strip_tags($de['materai']);
			$total = strip_tags($de['total']);
			$keterangan = strip_tags($de['keterangan']);
		?>
			<font face='calibri'>
				<div class="panel panel-success">
					<div class="panel-heading">
						<font size="4">EDIT HEADER DATA PENERIMAAN PEMBELIAN</font>
					</div>
					<div class="panel-body">
						<form method='post' name='beli' enctype='multipart/form-data' action='module/beli/proses_edit.php'>
							<input type='hidden' name='username' value="<?= $user ?>">
							<input type='hidden' name='id' value="<?= $de['id'] ?>" />
							<div class='col-md-6'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>Nomor Pembelian</td>
										<td>
											<input type='text' class='form-control' id='nobeli' name='nobeli' placeholder='No. Order *' style='text-transform:uppercase' value="<?= $nobeli ?>" readonly>
										</td>
									</tr>
									<tr>
										<td>Tgl. Pembelian (M/D/Y)</td>
										<td><input type='date' class='form-control' id='tglbeli' name='tglbeli' value="<?php echo $tglbeli ?>" size='50' autocomplete='off' required readonly></td>
									</tr>
									<tr>
										<td>No. Invoice</td>
										<td><input type='text' class='form-control' id='noinvoice' name='noinvoice' value='<?= $noinvoice ?>' size='50' autocomplete='off' required></td>
									</tr>
									<tr>
										<td>Tgl. Invoice (M/D/Y)</td>
										<td><input type='date' class='form-control' id='tglinvoice' name='tglinvoice' size='50' value='<?= $tglinvoice ?>' autocomplete='off' required></td>
									</tr>
									<tr>
										<td>Supplier</td>
										<td>
											<div class='input-group'> <input type='text' class='form-control' id='kdsupplier' name='kdsupplier' value="<?= $kdsupplier ?>" size='50' autocomplete='off' readonly required>
												<span class='input-group-btn'>
													<button type='button' id='src' class='btn btn-primary' onclick='cari_data_supplier()'>Cari</button>
												</span>
										</td>
									<tr>
										<td></td>
										<td> <input type="text" class='form-control' id='nmsupplier' name='nmsupplier' value="<?= $nmsupplier ?>" size='50' readonly required></td>
									</tr>
									<tr>
										<td>Jenis Order
										<td><select required id='jenis_order' name='jenis_order' class='form-control' style='width: 200x;'>
												<?php
												$jenis_order = array('URGENT', 'NORMAL', 'LAIN-LAIN');
												$jml_kata = count($jenis_order);
												for ($c = 0; $c < $jml_kata; $c += 1) {
													if ($jenis_order[$c] == $de['jenis_order']) {
														echo "<option value=$jenis_order[$c] selected>$jenis_order[$c] </option>";
													} else {
														echo "<option value=$jenis_order[$c]> $jenis_order[$c] </option>";
													}
												}
												echo "</select>";
												?>
									<tr>
										<td>Biaya Lain</td>
										<td> <input type="text" class='form-control' name='ket_biaya_lain' value='<?= $ket_biaya_lain ?>'></td>
									</tr>
									<tr>
										<td></td>
										<td> <input type="number" class='form-control' name='biaya_lain' id='biaya_lain' size='50' value='<?= $biaya_lain ?>' required onkeyup="hit_total()" onblur="hit_total()"></td>
									</tr>
									<tr>
										<td>Tanggal Kirim<br>(M/D/Y)</br></td>
										<td> <input type="date" class='form-control' name='tglkirim' size='50' value='<?= $tglkirim ?>' required></td>
									</tr>
								</table>
							</div>
							<div class='col-md-6'>
								<table style=font-size:12px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>CARA BAYAR</td>
										<td><select required name="carabayar" id="carabayar" class='form-control'>
												<?php
												$carabayar = array('TUNAI', 'KARTU-KREDIT', 'GIRO', 'CEK');
												$jml_kata = count($carabayar);
												for ($c = 0; $c < $jml_kata; $c += 1) {
													if ($carabayar[$c] == $de['carabayar']) {
														echo "<option value=$carabayar[$c] selected>$carabayar[$c] </option>";
													} else {
														echo "<option value=$carabayar[$c]> $carabayar[$c] </option>";
													}
												}
												echo "</select>";
												?>
										</td>
									</tr>
									<tr>
										<td>Tempo (Hari)</td>
										<td> <input type="number" class='form-control' name='tempo' value='<?= $tempo ?>' size='50'></td>
									</tr>
									<tr>
										<td>Tanggal Jatuh Tempo<br>(M/D/Y)</br></td>
										<td> <input type="date" class='form-control' name='tgl_jt_tempo' value='<?= $tgl_jt_tempo ?>' size='50'></td>
									</tr>
									<tr>
										<td>Subtotal</td>
										<td> <input type="number" class='form-control' name='subtotal' id='subtotal' size='50' value='<?= $subtotal ?>' readonly></td>
									</tr>
									<tr>
										<td>Total Sementara</td>
										<td> <input type="number" class='form-control' id='total_sementara' name='total_sementara' size='50' value='<?= $total_sementara ?>' readonly></td>
									</tr>
									<tr>
										<td>PPn</td>
										<td> <input type="number" class='form-control' name='ppn' id='ppn' size='50' value='<?= $ppn ?>' onkeyup="hit_total()" onblur="hit_total()"></td>
									</tr>
									<tr>
										<td>Materai</td>
										<td> <input type="number" class='form-control' name='materai' id='materai' size='50' value='<?= $materai ?>' onkeyup="hit_total()" onblur="hit_total()"></td>
									</tr>
									<tr>
										<td>Total</td>
										<td> <input type="number" class='form-control' name='total' id='total' size='50' value='<?= $total ?>' readonly></td>
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
					<font size="4">PENERIMAAN PEMBELIAN</font>
				</div>
				<div class="panel-body">
					<form method='get'>
						<div class="row">
							<?php
							// include('hal_get.php')
							?>
							<div class="col-md-4 bg">
								<!-- <input type="hidden" name="m" value="beli">
								<input type='text' id='kata' name='kata' value="<?= $kata ?>" size='50px' class='form-control' placeholder='NO.BELI, SUPPLIER' onkeyup='searchTable()'>
							</div>
							<button type='submit' class='btn btn-primary'>
								<span class='glyphicon glyphicon-search'></span> Cari</button> -->
								<a class="btn btn-primary btn-sm" href="?m=beli&tipe=tambah"><i class="fa fa-plus"></i> Tambah data</a>
							</div>
						</div>
					</form>
					</br>
					<div class="box-body table-responsive">
						<!-- <table id="example1" class="table table-bordered table-striped"> -->
						<table id="tbl-belih" class="table table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th width='30'>No.</th>
									<th width='80'>No.Pembelian</th>
									<th width='50'>Tanggal</th>
									<th width='200'>Supplier</th>
									<th width='70'>Total</th>
									<th width='20'>Prs</th>
									<th width='20'>Btl</th>
									<th width='70'>Aksi</th>
								</tr>
							</thead>
							<tbody></tbody>
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
			<!-- <div class="modal fade" id="modaldetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
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
			</div> -->

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
									$('#harga').val('');
									cari_data_barang_beli();
									return;
								}
								$('#nmbarang').val(data_response['nama']);
								$('#kdsatuan').val(data_response['kdsatuan']);
								$('#harga').val(data_response['harga_beli']);
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
						url: './module/beli/lihat_detail.php',
						type: 'post',
						data: {
							kode: id
						},
						success: function(response) {
							$('#modaldetail').find('.modal-body').html(response);
						}
					});
				}
			</script>

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
								$href = "module/beli/proses_hapus.php?id=";
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
								$href = "module/beli/proses_hapus_detail.php?id=";
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
								$href = "module/beli/proses.php?id=";
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
								$href = "module/beli/batal_proses.php?id=";
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
				function eraseText() {
					document.getElementById("kdbarang").value = "";
					document.getElementById("nmbarang").value = "";
					document.getElementById("qty").value = "0";
					document.getElementById("harga").value = "0";
					document.getElementById("discount").value = "0";
					document.getElementById("subtotal").value = "0";
				}

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
								$href = "module/beli/cetak.php?id=";
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

			<script>
				$(document).ready(function() {
					$('#tbl-detail-beli').DataTable({
						// destroy: true,
						"aLengthMenu": [
							[5, 50, 100, -1],
							[5, 50, 100, "All"]
						],
						"iDisplayLength": 5
					})
					var table = $('#tbl-belih').DataTable({
						destroy: true,
						"aLengthMenu": [
							[5, 50, 100, -1],
							[5, 50, 100, "All"]
						],
						"iDisplayLength": 5,
						"processing": true,
						"serverSide": true,
						"ajax": "databelih.php",
						"columnDefs": [{
								"targets": 0,
								"data": null,
								"orderable": false,
								"searchable": false,
								"className": "text-center",
								// "render": function(data, type, row, meta) {
								// 	var html = meta.row + meta.settings._iDisplayStart + 1
								// 	return html
								// },
								render: function(data, type, row, meta) {
									return meta.row + meta.settings._iDisplayStart + 1;
								}
							},
							{
								"targets": 7,
								"data": null,
								"render": function(data, type, row) { // Tampilkan kolom aksi
									// var html = "";
									// // var html = "<a class='btn btn-success btn-xs' href='?m=jual&tipe=detail_proses&nojual=$k[nojual]&kdcustomer=$k[kdcustomer]'>Detail</a> ";
									// // var html = '<button type="button" class="btn btn-success btn-xs dt-view" style="margin-right:10px;"><span class="glyphicon glyphicon-eye-open glyphicon-info-sign" aria-hidden="true"></span></button>';
									// html += '<button type="button" class="btn btn-success btn-xs tblEdit" style="margin-right:10px;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>H</button>';
									// html += '<button type="button" class="btn btn-info btn-xs dt-detail" style="margin-right:10px;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>D</button>';
									// html += '<button type="button" class="btn btn-danger btn-xs dt-delete" style="margin-right:10px;"><span class="glyphicon glyphicon-remove glyphicon-trash" aria-hidden="true">';
									// html += '<button type="button" class="btn btn-warning btn-xs dt-proses" style="margin-right:10px;"><span class="glyphicon glyphicon-circle-arrow-right" aria-hidden="true">';
									// html += '<button type="button" class="btn btn-danger btn-xs dt-unproses" style="margin-right:10px;"><span class="glyphicon glyphicon-circle-arrow-left" aria-hidden="true">';
									// html += '<button type="button" class="btn btn-default btn-xs dt-cetak" style="margin-right:10px;"><span class="glyphicon glyphicon-print" aria-hidden="true">';
									// // html += '<button type="button" class="btn btn-default btn-xs dt-cetak-fp" style="margin-right:10px;"><span class="glyphicon glyphicon-print" aria-hidden="true"> FP';
									var html = "";
									html += '<div class="dropdown"> <button class="btn btn-primary btn-sm dropdown-toggle"	type="button"	data-toggle="dropdown"> Pilih Aksi <span class="caret"> </span></button>';
									html += '<ul class = "dropdown-menu">';
									if (data[9] == "Y") { //batal
										html += '<li> <a class="dt-delete"><i class="fa fa-arrow-left"></i>Kembalikan </a></li>';
									} else {
										if (data[7] == "Y") { //proses
											html += '<li><a class="dt-unproses"><i class="fa fa-arrow-left"></i>Unproses </a></li>';
											html += '<li><a class="dt-cetak"><i class="fa fa-print"></i>Cetak Pembelian</a></li>';
										} else {
											html += '<li><a class="tblEdit"><i class="fa fa-edit"></i>Edit Header</a></li>';
											html += '<li><a class="dt-detail"><i class="fa fa-edit"></i>Edit Detail</a></li>';
											html += '<li><a class="dt-delete"><i class="fa fa-times"></i>Hapus</a></li>';
											html += '<li><a class="dt-proses"><i class="fa fa-arrow-right"></i>Proses </a></li>';
										}
									}
									return html
								}
							},
						],
						order: [
							[0, 'asc'],
							[1, 'desc'],
							[2, 'asc'],
							[3, 'asc'],
							[4, 'asc'],
						],
					});
					$('#tbl-belih tbody').on('click', '.dt-view', function() {
						var data = table.row($(this).parents('tr')).data();
						window.location.href = "?m=beli&tipe=detail_proses&id=" + data[8]
					});
					$('#tbl-belih tbody').on('click', '.tblEdit', function() {
						var data = table.row($(this).parents('tr')).data();
						if (data[9] == "Y") {
							swal({
								title: "Data sudah batal !",
								text: "Aksi tidak bisa dilanjutkan",
								icon: "error"
							})
							exit();
						}
						if (data[7] == "N") {
							window.location.href = "?m=beli&tipe=edit&id=" + data[8]
						} else {
							swal({
								title: "Data sudah di proses !",
								text: "Data sudah di proses, aksi tidak bisa dilanjutkan",
								icon: "error"
							})
						}
					});
					$('#tbl-belih tbody').on('click', '.dt-detail', function() {
						var data = table.row($(this).parents('tr')).data();
						if (data[9] == "Y") {
							swal({
								title: "Data sudah batal !",
								text: "Aksi tidak bisa dilanjutkan",
								icon: "error"
							})
							exit();
						}
						if (data[7] == "N") {
							window.location.href = "?m=beli&tipe=detail&id=" + data[8]
						} else {
							swal({
								title: "Data sudah di proses !",
								text: "Data sudah di proses, aksi tidak bisa dilanjutkan",
								icon: "error"
							})
						}
					});

					$('#tbl-belih tbody').on('click', '.dt-delete', function() {
						//var data = table.row( $(this).parents('tr') ).data();
						//var id = $(this).attr("id");
						var data = table.row($(this).parents('tr')).data();
						var id = data[8];
						if (data[7] == "Y") {
							swal({
								title: "Data sudah di proses !",
								text: "Data sudah di proses, aksi tidak bisa dilanjutkan",
								icon: "error"
							})
							exit();
						}
						if (data[9] == "Y") {
							swal({
									title: "Data sudah batal !",
									text: "Yakin akan dilanjutkan ?",
									icon: "error"
								})
								.then((willDelete) => {
									if (willDelete) {
										//alert($kode);
										$href = "module/beli/proses_hapus.php?id=";
										window.location.href = $href + id;
										// swal("beliof! Your imaginary file has been deleted!", {
										//   icon: "success",
										// });
									} else {
										//swal("Batal Hapus!");
									}
								});
						} else {
							swal({
									title: "Yakin akan batalkan ?",
									text: "",
									icon: "warning",
									buttons: true,
									dangerMode: true,
								})
								.then((willDelete) => {
									if (willDelete) {
										//alert($kode);
										$href = "module/beli/proses_hapus.php?id=";
										window.location.href = $href + id;
										// swal("beliof! Your imaginary file has been deleted!", {
										//   icon: "success",
										// });
									} else {
										//swal("Batal Hapus!");
									}
								});
						}
					});

					$('#tbl-belih tbody').on('click', '.dt-proses', function() {
						var data = table.row($(this).parents('tr')).data();
						var id = data[8];
						if (data[9] == "Y") {
							swal({
								title: "Data sudah batal !",
								text: "Aksi tidak bisa dilanjutkan",
								icon: "error"
							})
							exit();
						}
						if (data[7] == "Y") {
							swal({
								title: "Data sudah di proses !",
								text: "Data sudah di proses, aksi tidak bisa dilanjutkan",
								icon: "error"
							})
							exit();
						}
						swal({
								title: "Yakin akan diproses ?",
								text: "",
								icon: "warning",
								buttons: true,
								dangerMode: true,
							})
							.then((willDelete) => {
								if (willDelete) {
									$href = "module/beli/proses.php?id=";
									window.location.href = $href + id;
									// swal("beliof! Your imaginary file has been deleted!", {
									//   icon: "success",
									// });
								} else {
									//swal("Batal Hapus!");
								}
							});
					});

					$('#tbl-belih tbody').on('click', '.dt-unproses', function() {
						var data = table.row($(this).parents('tr')).data();
						var id = data[8];
						if (data[9] == "Y") {
							swal({
								title: "Data sudah batal !",
								text: "Aksi tidak bisa dilanjutkan",
								icon: "error"
							})
							exit();
						}
						if (data[7] == "N") {
							swal({
								title: "Data belum diproses !",
								text: "Data belum diproses, aksi tidak bisa dilanjutkan",
								icon: "error"
							})
							exit();
						}
						swal({
								title: "Yakin akan di Batal Proses ?",
								text: "",
								icon: "warning",
								buttons: true,
								dangerMode: true,
							})
							.then((willDelete) => {
								if (willDelete) {
									$href = "module/beli/batal_proses.php?id=";
									window.location.href = $href + id;
									// swal("beliof! Your imaginary file has been deleted!", {
									//   icon: "success",
									// });
								} else {
									//swal("Batal Hapus!");
								}
							});
					});


					$('#tbl-belih tbody').on('click', '.dt-cetak', function() {
						var data = table.row($(this).parents('tr')).data();
						var id = data[8];
						if (data[7] == "N") {
							swal({
								title: "Data belum diproses !",
								text: "Data belum diproses, aksi tidak bisa dilanjutkan",
								icon: "error"
							})
							exit();
						}
						swal({
								title: "Yakin akan di Cetak ?",
								text: "",
								icon: "warning",
								buttons: true,
								dangerMode: true,
							})
							.then((willCetak) => {
								if (willCetak) {
									$href = "module/beli/cetak.php?id=";
									window.open($href + id, "_blank");
									// window.location.href = $href + id, "_blank";
									// swal("Poof! Your imaginary file has been deleted!", {
									//   icon: "success",
									// });
								} else {
									//swal("Batal Hapus!");
								}
							});
					});
				});
			</script>