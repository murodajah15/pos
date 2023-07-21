<!-- <body>
	<script src="./js/sweet-alert.min.js" type="text/javascript"></script> -->
<?php
$user = $_SESSION['username'];
$kunci_harga_jual = $_SESSION['kunci_harga_jual'];
$kunci_stock = $_SESSION['kunci_stock'];
include "autonumber.php";
cekform();

if (isset($_GET['tipe'])) {
	if ($_GET['tipe'] == 'detail_proses') {
		cekakses($connect, $user, 'Penjualan');
		$lakses = $_SESSION['aksespakai'];
		if ($lakses == 1) {
			$sql = "select * from jualh where id='$_GET[id]'";
			$data = mysqli_fetch_assoc(mysqli_query($connect, $sql));
?>
			<font face='calibri'>
				<div class='panel panel-default'>
					<div class='panel-heading'>
						<font size="4">DETAIL PENJUALAN : <?= $data['nojual'] ?>&nbsp&nbsp<input button type="Button" class="btn btn-danger btn-xs" value="Close" onClick="history.back()" /></font><br>
					</div>
					<div class='panel-body'>

						<!-- <h3>Detail Penjualan : <?= $data['nojual'] ?>&nbsp&nbsp<input button type="Button" class="btn btn-danger btn-xs" value="Close" onClick="history.back()" /></h3><br> -->
						<input type='hidden' name='username' value='<?= $user ?>'>
						<?php
						$query = mysqli_query($connect, "select * from jualh where nojual='$data[nojual]'");
						$de = mysqli_fetch_assoc($query);
						$customer = strip_tags($de['kdcustomer'] . ' | ' . $de['nmcustomer']);
						?>
						<div class='col-md-6'>
							<table style=font-size:13px; class='table table-striped table table-bordered'>
								<tr>
									<td>No. Penjualan</td>
									<td> <input type=text class='form-control' name='noajukan' value=<?php echo "'$de[nojual]'" ?> readonly></td>
								</tr>
								<tr>
									<td>Tgl. Penjualan</td>
									<td> <input type="date" class='form-control' name='tglajukan' value=<?php echo "'$de[tgljual]'" ?> readonly></td>
								</tr>
								<tr>
									<td>No. Surat Jalan</td>
									<td> <input type=text class='form-control' name='noajukan' value=<?php echo "'$de[nosrtjln]'" ?> readonly></td>
								</tr>
								<tr>
									<td>Tgl. Surat Jalan</td>
									<td> <input type="date" class='form-control' name='tglajukan' value=<?php echo "'$de[tglsrtjln]'" ?> readonly></td>
								</tr>
								<tr>
									<td>Customer</td>
									<td> <input type=text class='form-control' name='norangka' value=<?php echo "'$customer'" ?> readonly></td>
								</tr>
								<tr>
									<td>Jenis Order</td>
									<td> <input type=text class='form-control' name='jenis_order' value=<?php echo "'$de[jenis_order]'" ?> readonly></td>
								</tr>
								<tr>
									<td>Biaya Lain</td>
									<td> <input type=text class='form-control' name='biaya_lain' value=<?php echo "'$de[biaya_lain]'" ?> readonly></td>
								</tr>
								<tr>
									<td>Keterangan Biaya Lain</td>
									<td> <input type=text class='form-control' name='ket_biaya_lain' value=<?php echo "'$de[ket_biaya_lain]'" ?> readonly></td>
								</tr>
								<tr>
									<td>Tanggal Kirim<br>(M/D/Y)</br></td>
									<td> <input type="date" class='form-control' name='tglkirim' size='50' value='<?= $de['tglkirim'] ?>' readonly></td>
								</tr>
								<tr>
									<td>Cara Bayar</br></td>
									<td> <input type="text" class='form-control' name='carabayar' size='50' value='<?= $de['carabayar'] ?>' readonly></td>
								</tr>
								<tr>
									<td>Tempo (Hari)</td>
									<td> <input type="number" class='form-control' name='tempo' value='<?= $tempo ?>' size='50' readonly></td>
								</tr>
								<tr>
									<td>Tanggal Jatuh Tempo<br>(M/D/Y)</br></td>
									<td> <input type="date" class='form-control' name='tgl_jt_tempo' value='<?= $de['tgl_jt_tempo'] ?>' size='50' readonly></td>
								</tr>
							</table>
						</div>
						<div class='col-md-6'>
							<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
								<tr>
									<td>Subtotal</td>
									<td> <input type="number" class='form-control' id='ppn' name='ppn' size='50' value='<?= $de['subtotal'] ?>' readonly></td>
								</tr>
								<tr>
									<td>Total Sementara</td>
									<td> <input type="number" class='form-control' id='ppn' name='ppn' size='50' value='<?= $de['total_sementara'] ?>' readonly></td>
								</tr>
								<tr>
									<td>PPn</td>
									<td> <input type="number" class='form-control' name='ppn' size='50' value='<?= $de['ppn'] ?>' readonly></td>
								</tr>
								<tr>
									<td>Materai</td>
									<td> <input type="number" class='form-control' name='materai' size='50' value='<?= $de['materai'] ?>' readonly></td>
								</tr>
								<tr>
									<td>Total</td>
									<td> <input type="number" class='form-control' name='total' size='50' value='<?= $de['total'] ?>' readonly></td>
								</tr>
								<tr>
									<td>Sudah Bayar</td>
									<td> <input type='number' class='form-control' name='tahun' value=<?php echo "$de[sudahbayar]" ?> readonly></td>
								</tr>
								<tr>
									<td>Kurang Bayar</td>
									<td> <input type='text' class='form-control' name='tahun' value=<?php echo "$de[kurangbayar]" ?> readonly></td>
								</tr>
								<tr>
									<td>Keterangan</td>
									<td> <textarea type='text' rows='2' class='form-control' name='tahun' readonly><?php echo "$de[keterangan]" ?></textarea></td>
								</tr>
								<tr>
									<td>Proses</td>
									<td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[proses]'" ?> readonly></td>
								</tr>
								<tr>
									<td>User Input</td>
									<td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[user]'" ?> readonly></td>
								</tr>
								<tr>
									<td>User Proses</td>
									<td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[user_proses]'" ?> readonly></td>
								</tr>
							</table>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table class="table table-bordered table-striped table-hover" id="tbl-detail-jual">
										<thead>
											<tr>
												<th width='50'>No.</th>
												<th width='100'>No. SO</th>
												<th width='170'>Kode Barang</th>
												<th>Nama Barang</th>
												<th width='70'>Satuan</th>
												<th>QTY</th>
												<th>harga</th>
												<th>Disc.(%)</th>
												<th>Subtotal</th>
											</tr>
										</thead>
										<tbody>
											<?php
											// $tampil = mysqli_query($connect, "select * from juald where nojual='$nojual'");
											// $query = $connect->prepare("select * from juald where nojual=?");
											// $query->bind_param('s', $data['nojual']);
											// $query->execute();
											// $result = $query->get_result();
											// $de = $result->fetch_assoc();
											$sql = mysqli_query($connect, "select * from juald where nojual='$data[nojual]'");
											$de = mysqli_fetch_assoc($sql);
											$noso = strip_tags($de['noso']);
											$no = 1;
											//<td><u><a href='#' onclick =lihat_detail('$k[id]');><font color='blue'>$k[noso]</font></a></u></td>
											while ($k = mysqli_fetch_assoc($tampil)) {
												$kdbarang = strip_tags($k['kdbarang']);
												$nmbarang = strip_tags($k['nmbarang']);
												$qty = strip_tags($k['qty']);
												$harga = number_format($k['harga'], 0, ",", ".");
												$discount = strip_tags($k['discount']);
												$subtotal = number_format($k['subtotal'], 0, ",", ".");
												//$date = date("m/d/Y", strtotime($k['tglwo']));
												echo "<tr><td align='center'>$no</td>
							<td width='100'>$k[noso]</td>
							<td width='100'>$k[kdbarang]</td>
							<td width='300'>$k[nmbarang]</td>
							<td width='10'>$k[kdsatuan]</td>
							<td align='right' width='10'>$k[qty]</td>
							<td align='right' width='100'>$harga</td>
							<td align='right' width='70'>$k[discount]</td>
							<td align='right'>$subtotal</td>";
												$no++;
											}
											$tampil = mysqli_query($connect, "select sum(qty) as total_qty,sum(subtotal) as total_subtotal from juald where nojual='$nojual'");
											$jum = mysqli_fetch_assoc($tampil);
											$total_qty = $jum['total_qty'];
											$total = number_format($jum['total_subtotal'], 0, ",", ".");
											echo "</tr></tbody><tr><td colspan='5'></td>
						<td align='right' style='font-weight:bold'>$total_qty</td>
						<td align='right' colspan='3' style='font-weight:bold'>$total</td></tr>";
											?>
									</table>
								</div>
								<input button type='Button' class='btn btn-danger' value='Close' onClick='history.back()' />
							</div>
						</div>
						<div class="row"></div>
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
	if ($_GET['tipe'] == 'detail') {
		cekakses($connect, $user, 'Penjualan');
		$lakses = $_SESSION['aksespakai'];
		// $_SESSION['kdcustomer'] = $_GET['kdcustomer'];
		if ($lakses == 1) {
			$sql = "select * from jualh where id='$_GET[id]'";
			$data = mysqli_fetch_assoc(mysqli_query($connect, $sql));
			$id = $data['id'];
			$kdcustomer = $data['kdcustomer'];
			$_SESSION['kdcustomer'] = $kdcustomer;
			$nojual = $data['nojual'];
			if ($data['proses'] == "Y") {
			?>
				<script>
					swal({
						title: "Data sudah diproses !",
						text: "Data sudah diproses, aksi tidak bisa dilanjutkan",
						icon: "error"
					}).then(function() {
						window.history.back(); //window.location.href='../../dashboard.php?m=jual';
					});
				</script>
			<?php
			} else {
			?>
				<font face='calibri'>
					<div class='panel panel-info'>
						<div class='panel-heading'>
							<font size="4">EDIT DETAIL DATA PENJUALAN : <?= $nojual ?></font>
						</div>
						<div class='panel-body'>
							<form method='post' name='so' enctype='multipart/form-data' action='module/jual/proses_tambah_detail.php'>
								<input type='hidden' name='username' value="<?= $user ?>">
								<input type='hidden' name='kdcustomer' id='kdcustomer' value="<?= $kdcustomer ?>">
								<input type='hidden' name='kunci_stock' id='kunci_stock' value="<?= $kunci_stock ?>">
								<div class='col-md-6'>
									<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
										<form method='post' enctype='multipart/form-data' action='module/jual/proses_tambah_detail.php'>
											<input type='hidden' name='username' value='<?= $user ?>'>
											<input type='hidden' name='id' value='<?= $_GET['id'] ?>'>
											<input type='hidden' name='nojual' value='<?= $nojual ?>'>
											<input type='hidden' name='kata' value='<?= $_GET['kata'] ?>'>
											<input type='hidden' name='page' value='<?= $_GET['page'] ?>'>
											<div class="input-group">
												<span class="input-group-addon">No. SO</span>
												<input type="text" class="form-control" name='noso' id='noso' width='50' placeholder="No. SO" readonly>
												<span class='input-group-btn'></span>
												<button type='button' id='src' class='btn btn-primary' onclick='cari_data_so()'>Cari</button>
												<span class='input-group-btn'></span><button type='submit' class='btn btn-success'>Salin dari Sales Order</button>
											</div>
											<div class='col-md-12'>
												<div class="table-responsive">
													<table class="table table-bordered table-striped table-hover" width="100%">
														<tr>
															<th>Kode Barang <input type="button" class='btn btn-warning btn-xs' value="Clear" onclick="eraseText()"> <input type="checkbox" class="multiprc" name="multiprc" id="multiprc"> Multi Price</th>
															<th>Barang</th>
															<th>Satuan</th>
															<th>QTY</th>
															<th>Harga</th>
															<th>Disc</th>
															<th>Subtotal</th>
															<th>Aksi</th>
														</tr>
														<td>
															<div class='input-group'> <input type='text' class='form-control' style="text-transform: uppercase; width: 9em;" id='kdbarang' name='kdbarang' size='50' autocomplete='off'>
																<span class='input-group-btn'>
																	&nbsp<button type='button' id='srcmp' class='btn btn-primary btn-sm' onclick='cari_data_barang()' disabled>MP</button>
																</span>
																<span class='input-group-btn'>
																	&nbsp<button type='button' id='srctb' class='btn btn-success btn-sm' onclick='cari_data_tbbarang()'>TB</button>
																</span>
														</td>
														<td><input type='text' class='form-control' style='width: 15em' id='nmbarang' name='nmbarang' readonly></td>
														</td>
														<td><input type='text' class='form-control' style='width: 5em' id='kdsatuan' name='kdsatuan' readonly>
														</td>
														<td><input type="text" class='form-control' value='1' id='qty' name='qty' value=0 style='width: 6em' onkeyup="validAngka(this)" onblur="hit_subtotal()" required></td>
														<?php
														if ($kunci_harga_jual == 'Y') {
														?>
															</td>
															<td><input type="text" class='form-control' value='0' id='harga' name='harga' value=0 style='width: 7em' readonly></td>
														<?php
														} else {
														?>
															</td>
															<td><input type="text" class='form-control' value='0' id='harga' name='harga' value=0 style='width: 7em' onkeyup="validAngka_no_titik(this)" onblur="hit_subtotal()"></td>
														<?php
														}
														?>
														</td>
														<td><input type="text" class='form-control' value='0' id='discount' name='discount' value=0 style='width: 6em' onkeyup="validAngka(this)" onblur="hit_subtotal()"></td>
														</td>
														<td><input type="number" class='form-control' value='0' id='subtotal' name='subtotal' value=0 style='width: 8em' readonly></td>
														<td align='center' width='50px'>
															<button type='submit' class='btn btn-primary'>+</button>
													</table>
													<form>
												</div>

												<div class='col-md-12'>
													<div class="box-body table-responsive">
														<table style=font-size:13px; class='table table-striped table table-bordered' id='tbl-detail-jual'>
															<!-- <table id="example3" class="table table-bordered table-striped"> -->
															<thead>
																<tr>
																	<th width='50'>No.</th>
																	<th width='50'>No. SO</th>
																	<th width='170'>Kode Barang</th>
																	<th>Nama Barang</th>
																	<th width='70'>Satuan</th>
																	<th>QTY</th>
																	<th>harga</th>
																	<th>Disc(%)</th>
																	<th>Subtotal</th>
																	<th>Aksi</th>
																</tr>
															</thead>
															<tbody>
																<?php
																$tampil = mysqli_query($connect, "select * from juald where nojual='$nojual'");
																// $query = $connect->prepare("select * from juald where nojual=?");
																// $query->bind_param('s', $nojual);
																// $query->execute();
																// $result = $query->get_result();
																// $de = $result->fetch_assoc();
																$no = 1;
																//<td><u><a href='#' onclick =lihat_detail('$k[id]');><font color='blue'>$k[noso]</font></a></u></td>
																// <td><input type='number' name='qty' id='qty' value='$k[qty]' style='text-align: right; width: 6em' onkeyup='hitung_subtotal_jualh()'></td>

																while ($k = mysqli_fetch_assoc($tampil)) {
																	$noso = strip_tags($k['noso']);
																	$kdbarang = strip_tags($k['kdbarang']);
																	$nmbarang = strip_tags($k['nmbarang']);
																	$qty = number_format($k['qty'], 2, ",", ".");
																	$harga = number_format($k['harga'], 0, ",", ".");
																	$discount = number_format($k['discount'], 2, ",", ".");
																	$subtotal = number_format($k['subtotal'], 0, ",", ".");
																	//$date = date("m/d/Y", strtotime($k['tglwo']));
																	echo "<tr><td align='center'>$no</td>
																		<td width='100'>$k[noso]</td>
																		<td width='100'>$k[kdbarang]</td>
																		<td width='300'>$k[nmbarang]</td>
																		<td width='10'>$k[kdsatuan]</td>
																		<td align='right'>$qty</td>
																		<td align='right'>$harga</td>
																		<td align='right'>$discount</td>
																		<td align='right'>$subtotal</td>
																		<td align='center' width='150px'>";
																	echo "<a class='btn btn-primary btn-sm' href='?m=jual&tipe=edit_detail&id=$k[id]&kdcustomer=$data[kdcustomer]'>Edit</a> ";
																	echo " <input button type='button' class='btn btn-danger btn-sm' value='Hapus' onClick='alert_hapus_detail($k[id])' />";
																	$no++;
																}
																$tampil = mysqli_query($connect, "select sum(qty) as total_qty,sum(subtotal) as total_subtotal from juald where nojual='$nojual'");
																$jum = mysqli_fetch_assoc($tampil);
																$total_qty = $jum['total_qty'];
																$total_qty = number_format($total_qty, 2, ",", ".");
																$total = number_format($jum['total_subtotal'], 0, ",", ".");;
																echo "</tr>
																	</tbody><tr>";
																echo "<td colspan='5'></td>
																	<td align='right' style='font-weight:bold'>$total_qty</td>
																	<td align='right' colspan='3' style='font-weight:bold'>$total</td></tr>";
																?>
														</table>
														<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
															<?php
															if (!empty($_GET['kata']) and !empty($_GET['page'])) {
															?>
																<input button type='Button' class='btn btn-danger' value='Close1 onClick="window.location = ' dashboard.php?m=jual$kata=<?= $_GET['kata'] ?>&page=<?= $_GET['page'] ?>'" />
															<?php
															}
															if (!empty($_GET['page'])) {
															?>
																<input button type='Button' class='btn btn-danger' value='Close' onClick="window.location = 'dashboard.php?m=jual&page=<?= $_GET['page'] ?>'" />
															<?php
															}
															if (empty($_GET['kata']) and empty($_GET['page'])) {
															?>
																<input button type='Button' class='btn btn-danger' value='Close' onClick="window.location = 'dashboard.php?m=jual&module=Penjualan'" />
															<?php
															}
															?>
														</table>
													</div>
												</div>
											</div>
								</div>
							</form>
				</font>
			<?php
			}
		} else {
			echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
		}
	}
}

if (isset($_GET['tipe'])) {
	if ($_GET['tipe'] == 'edit_detail') {
		cekakses($connect, $user, 'Edit Detail Penjualan');
		$lakses = $_SESSION['aksespakai'];
		if ($lakses == 1) {
			// $query = $connect->prepare("select * from juald where id=?");
			// $query->bind_param('i', $_GET['id']);
			// $query->execute();
			// $result = $query->get_result();
			// $de = $result->fetch_assoc();
			$sql = mysqli_query($connect, "select * from juald where id='$_GET[id]'");
			$de = mysqli_fetch_assoc($sql);
			$id = $_GET['id'];
			$noso = strip_tags($de['noso']);
			$nojual = strip_tags($de['nojual']);
			$kdbarang = strip_tags($de['kdbarang']);
			$nmbarang = strip_tags($de['nmbarang']);
			$kdsatuan = strip_tags($de['kdsatuan']);
			$qty = number_format($de['qty'], 2, ",", ".");
			$qty = str_replace(",", ".", $qty);
			$harga = strip_tags($de['harga']);
			$discount = number_format($de['discount'], 2, ",", ".");
			$discount = str_replace(",", ".", $discount);
			$subtotal = strip_tags($de['subtotal']);
			$harga = strip_tags($de['harga']); ?>
			<font face='calibri'>
				<h3>Edit Detail Penjualan</h3>
				<form method='post' enctype='multipart/form-data' action='module/jual/proses_edit_detail.php'>
					<input type='hidden' name='id' value='<?= $id ?>'>
					<input type='hidden' name='username' value='<?= $user ?>'>
					<input type='hidden' name='noso' value='<?= $noso ?>'>
					<input type='hidden' name='nojual' value='<?= $nojual ?>'>
					<table class="table table-bordered table-striped table-hover">
						<tr>
							<td>Nomor Penerimaan</td>
							<td>
								<input type='text' class='form-control' id='nojual' name='nojual' placeholder='No. WO *' style='text-transform:uppercase' value="<?= $nojual ?>" readonly>
							</td>
					</table>
					<table class="table table-bordered table-striped table-hover">
						<tr>
							<th width='170'>Kode Barang</th>
							<th>Nama Barang</th>
							<th width='70'>Satuan</th>
							<th>QTY</th>
							<th>harga</th>
							<th>Disc.(%)</th>
							<th>Subtotal</th>
						</tr>
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
						<td><input type="decimal" class='form-control' id='qty' name='qty' value='<?= $qty ?>' style='width: 10em' onkeyup="validAngka(this)" onblur="hit_subtotal()" required></td>
						<?php
						if ($kunci_harga_jual == 'Y') {
						?>
							</td>
							<td><input type="text" class='form-control' id='harga' name='harga' value='<?= $harga ?>' style='width: 7em' readonly></td>
						<?php
						} else {
						?>
							</td>
							<td><input type="text" class='form-control' id='harga' name='harga' value='<?= $harga ?>' style='width: 7em' onkeyup="validAngka_no_titik(this)" onblur="hit_subtotal()"></td>
						<?php
						}
						?>
						</td>
						<td><input type="text" class='form-control' id='discount' name='discount' value='<?= $discount ?>' style='width: 6em' onkeyup="validAngka(this)" onblur="hit_subtotal()"></td>
						</td>
						<td><input type="number" class='form-control' id='subtotal' name='subtotal' value='<?= $subtotal ?>' style='width: 10em' readonly></td>
					</table>
					<button type='submit' class='btn btn-success'>Simpan</button>
					<input button type='Button' class='btn btn-danger' value='Batal' onClick='history.back()' />
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
		cekakses($connect, $user, 'Penjualan');
		$lakses = $_SESSION['aksestambah'];
		$de = mysqli_fetch_assoc(mysqli_query($connect, "select * from saplikasi where aktif='Y'"));
		$tgl = $de['tgl_berikutnya']; //date('Y-m-d')
		if ($lakses == 1) { ?>
			<font face='calibri'>
				<div class='panel panel-primary'>
					<div class='panel-heading'>
						<font size="4">TAMBAH DATA PENJUALAN</font>
					</div>
					<div class='panel-body'>
						<form method='post' name='so' enctype='multipart/form-data' action='module/jual/proses_tambah.php'>
							<input type='hidden' name='username' value="<?= $user ?>">
							<div class='col-md-6'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>Nomor Penjualan</td>
										<td>
											<input type='text' class='form-control' id='nojual' name='nojual' id='nojual' placeholder='No. Jual *' style='text-transform:uppercase' value="<?php echo autoNumberJL($connect, 'id', 'jualh'); ?>" readonly>
										</td>
									</tr>
									<tr>
										<td>Tgl. (M/D/Y)</td>
										<td><input type='date' class='form-control' id='tgljual' name='tgljual' value="<?php echo $tgl ?>" size='50' autocomplete='off' required readonly></td>
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
										<td>Customer</td>
										<td>
											<div class='input-group'> <input type='text' class='form-control' id='kdcustomer' name='kdcustomer' size='50' autocomplete='off' required>
												<span class='input-group-btn'>
													<button type='button' id='src' class='btn btn-primary' onclick='cari_data_customer()'>Cari</button>
												</span>
										</td>
									<tr>
										<td></td>
										<td> <input type="text" class='form-control' id='nmcustomer' name='nmcustomer' size='50' readonly required></td>
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
										<td> <input type="number" class='form-control' name='biaya_lain' id='biaya_lain' size='50' value='0' required onkeyup="validAngka_no_titik(this)" onblur="hit_total()"></td>
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
									<tr>
										<td>Sales
										<td><select id='kdsales' name='kdsales' class='form-control' style='width: 200x;' onchange='changeValueSales(this.value)'>
												<!--<option value=''> - PILIH SATUAN BARANG - </option>";-->
												<?php
												$jsArraySales = "var prdNameSales = new Array();\n";
												$data = mysqli_query($connect, 'select * from tbsales order by nama');
												while ($row = mysqli_fetch_array($data)) {
													echo '<option name="kdsales"  value="' . $row['kode'] . '">' . $row['kode'] . '|' . $row['nama'] . '</option>';
													$jsArraySales .= "prdNameSales['" . $row['kode'] . "'] = {nmsales:'" . addslashes($row['nama']) . "',kdsales:'" . addslashes($row['kode']) . "'};\n";
												}
												echo '</select>';
												?>
												<input type='hidden' class='form-control' size='50' id='nmsales' name='nmsales' readonly>
								</table>
							</div>
							<div class='col-md-6'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>Cara Bayar
										<td><select required id='carabayar' name='carabayar' id='carabayar' class='form-control' style='width: 200x;'>
												<!--<option value=''> - PILIH CARA BAYAR - </option>";?>-->
												<option value="TUNAI">TUNAI</option>
												<option value="TRANSFER">TRANSFER</option>
												<option value="KREDIT">KREDIT</option>
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
										<td>PPn (%)</td>
										<td> <input type="number" class='form-control' name='ppn' id='ppn' size='50' value='0' onkeyup="hit_total()" onblur="hit_total()"></td>
									</tr>
									<tr>
										<td>Materai</td>
										<td> <input type="number" class='form-control' name='materai' id='materai' size='50' value='0' onkeyup="validAngka_no_titik(this)" onblur="hit_total()"></td>
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
		cekakses($connect, $user, 'Penjualan');
		$lakses = $_SESSION['aksesedit'];
		if ($lakses == 1) {
			$sql = mysqli_query($connect, "select * from jualh where id='$_GET[id]'");
			$de = mysqli_fetch_assoc($sql);
			// $query = $connect->prepare("select * from jualh where id=?");
			// $query->bind_param('i', $_GET['id']);
			// $query->execute();
			// $result = $query->get_result();
			// $de = $result->fetch_assoc();
			$nojual = strip_tags($de['nojual']);
			$tgljual = strip_tags($de['tgljual']);
			$noinvoice = strip_tags($de['noinvoice']);
			$tglinvoice = strip_tags($de['tglinvoice']);
			$kdcustomer = strip_tags($de['kdcustomer']);
			$nmcustomer = strip_tags($de['nmcustomer']);
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
			if ($de['proses'] == "Y") {
			?>
				<script>
					swal({
						title: "Data sudah diproses !",
						text: "Data sudah diproses, aksi tidak bisa dilanjutkan",
						icon: "error"
					}).then(function() {
						window.history.back(); //window.location.href='../../dashboard.php?m=jual';
					});
				</script>
			<?php
			} else {
			?>
				<font face='calibri'>
					<div class="panel panel-success">
						<div class="panel-heading">
							<font size="4">EDIT HEADER DATA PENJUALAN</font>
						</div>
						<div class="panel-body">
							<form method='post' name='jual' enctype='multipart/form-data' action='module/jual/proses_edit.php'>
								<input type='hidden' name='username' value="<?= $user ?>">
								<input type='hidden' name='id' value="<?= $_GET['id'] ?>" />
								<div class='col-md-6'>
									<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
										<tr>
											<td>Nomor Penjualan</td>
											<td>
												<input type='text' class='form-control' id='nojual' name='nojual' placeholder='No. Jual *' style='text-transform:uppercase' value="<?= $nojual ?>" readonly>
											</td>
										</tr>
										<tr>
											<td>Tgl. Penjualan (M/D/Y)</td>
											<td><input type='date' class='form-control' id='tgljual' name='tgljual' value="<?php echo $tgljual ?>" size='50' autocomplete='off' required></td>
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
											<td>Customer</td>
											<td>
												<div class='input-group'> <input type='text' class='form-control' id='kdcustomer' name='kdcustomer' value="<?= $kdcustomer ?>" size='50' autocomplete='off' required>
													<span class='input-group-btn'>
														<button type='button' id='src' class='btn btn-primary' onclick='cari_data_customer()'>Cari</button>
													</span>
											</td>
										<tr>
											<td></td>
											<td> <input type="text" class='form-control' id='nmcustomer' name='nmcustomer' value="<?= $nmcustomer ?>" size='50' readonly required></td>
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
											<td> <input type="number" class='form-control' name='biaya_lain' id='biaya_lain' size='50' value='<?= $biaya_lain ?>' required onkeyup="validAngka_no_titik(this)" onblur="hit_total()"></td>
										</tr>
										<tr>
											<td>Tanggal Kirim<br>(M/D/Y)</br></td>
											<td> <input type="date" class='form-control' name='tglkirim' size='50' value='<?= $tglkirim ?>' required></td>
										</tr>
										<tr>
											<td>Gudang
											<td><select id='kdgudang' name='kdgudang' class='form-control' style='width: 200x;' onchange='changeValueGudang(this.value)'>
													<!--<option value=''> - PILIH SATUAN BARANG - </option>";-->
													<?php
													$jsArrayGudang = "var prdNameGudang = new Array();\n";
													$data = mysqli_query($connect, 'select * from tbgudang order by nama');
													while ($row = mysqli_fetch_array($data)) {
														if ($row['kode'] == $de['kdgudang']) {
															echo "<option value='$row[kode]' selected>$row[kode]|$row[nama] </option>";
														} else {
															echo '<option name="kdgudang"  value="' . $row['kode'] . '">' . $row['kode'] . '|' . $row['nama'] . '</option>';
															$jsArraySatuan .= "prdNameGudang['" . $row['kode'] . "'] = {nmgudang:'" . addslashes($row['nama']) . "',kdgudang:'" . addslashes($row['kode']) . "'};\n";
														}
													}
													echo '</select>';
													?>
													<input type='hidden' class='form-control' size='50' id='nmgudang' name='nmgudang' readonly>
										<tr>
											<td>Sales
											<td><select id='kdsales' name='kdsales' class='form-control' style='width: 200x;' onchange='changeValueSales(this.value)'>
													<!--<option value=''> - PILIH SATUAN BARANG - </option>";-->
													<?php
													$jsArraySales = "var prdNameSales = new Array();\n";
													$data = mysqli_query($connect, 'select * from tbsales order by nama');
													while ($row = mysqli_fetch_array($data)) {
														if ($row['kode'] == $de['kdsales']) {
															echo "<option value=$row[kode] selected>$row[kode]|$row[nama] </option>";
														} else {
															echo '<option name="kdsales"  value="' . $row['kode'] . '">' . $row['kode'] . '|' . $row['nama'] . '</option>';
															$jsArraySales .= "prdNameSales['" . $row['kode'] . "'] = {nmsales:'" . addslashes($row['nama']) . "',kdsales:'" . addslashes($row['kode']) . "'};\n";
														}
													}
													echo '</select>';
													?>
													<input type='hidden' class='form-control' size='50' id='nmsales' name='nmsales' readonly>
									</table>
								</div>
								<div class='col-md-6'>
									<table style=font-size:12px; class='table table-striped table table-bordered' width='600px'>
										<tr>
											<td>CARA BAYAR</td>
											<td><select required name="carabayar" id="carabayar" class='form-control'>
													<?php
													$carabayar = array('TUNAI', 'TRANSFER', 'KREDIT', 'KARTU-KREDIT', 'GIRO', 'CEK');
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
											<td>PPn (%)</td>
											<td> <input type="number" class='form-control' name='ppn' id='ppn' size='50' value='<?= $ppn ?>' onkeyup="validAngka_no_titik(this)" onblur="hit_total()"></td>
										</tr>
										<tr>
											<td>Materai</td>
											<td> <input type="number" class='form-control' name='materai' id='materai' size='50' value='<?= $materai ?>' onkeyup="validAngka_no_titik(this)" onblur="hit_total()"></td>
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
			}
		} else {
			echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
		}
	}
} else {

	?>

	<?php
	include 'cek_akses.php';
	cekform();
	if ($aksesok == 'Y') {
	?>

		<font face="calibri">
			<div class="panel panel-warning">
				<div class="panel-heading">
					<font size="4">PENJUALAN</font>
				</div>
				<div class="panel-body">
					<form method='get'>
						<div class="row">
							<?php
							// include('hal_get.php')
							?>
							<!-- <div class="col-md-4 bg"> -->
							<!-- <input type="hidden" name="m" value="jual"> -->
							<!-- <input type='text' id='kata' name='kata' value="<?= $kata ?>" size='50px' class='form-control' placeholder='NO.JUAL, CUSTOMER' onkeyup='searchTable()'> -->
							<!-- </div> -->
							<!-- <button type='submit' class='btn btn-primary'>
								<span class='glyphicon glyphicon-search'></span> Cari</button> -->
							<div class="col-md-4 bg">
								<a class="btn btn-primary btn-sm" href="?m=jual&tipe=tambah"><i class="fa fa-plus"></i> Tambah data</a>
							</div>
						</div>
					</form>
					</br>
					<div class="table-responsive">
						<table id="tbl-jualh" class="table table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th width='30'>No.</th>
									<th width='60'>Penjualan</th>
									<th width='60'>Tanggal</th>
									<th width='80'>Invoice</th>
									<th width='500'>Customer</th>
									<th width='80'>Total</th>
									<th width='80'>Bayar</th>
									<th width='20'>Pro</th>
									<th width='20'>Btl</th>
									<th width='120'>Aksi</th>
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
				<div class="modal-dialog modal-lg" style="width:80%">
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
				function hit_subtotal() {
					var lharga = parseFloat(document.getElementById('qty').value) * parseFloat(document.getElementById('harga').value);
					var lsubtotal = lharga - (lharga * (parseFloat(document.getElementById('discount').value))) / 100;
					//alert(lsubtotal);
					document.getElementById('subtotal').value = lsubtotal;
				}

				$('#kdcustomer').on('blur', function(e) {
					var checkBox = document.getElementById("kdcustomer");
					let cari = $(this).val()
					var $url = 'repl_customer.php'
					$.ajax({
						url: $url,
						type: 'post',
						data: {
							'kode': cari,
						},
						success: function(response) {
							let data_response = JSON.parse(response);
							if (!data_response) {
								$('#kdcustomer').val('');
								$('#nmcustomer').val('');
								return;
							}
							$('#nmcustomer').val(data_response['nama']);
						},
						error: function() {
							console.log('file not fount');
						}
					})
				})

				$(document).ready(function(e) {
					$('#kdbarang').on('blur', function(e) {
						var checkBox = document.getElementById("multiprc");
						if (checkBox.checked == true) {
							var multiprc = 1
							var $url = 'repl_barang.php'
						} else {
							var multiprc = 0
							var $url = 'repl_tbbarang.php'
						}
						// console.log($url);
						let cari = $(this).val()
						let cari1 = $('#kdcustomer').val()
						$.ajax({
							url: $url,
							type: 'post',
							data: {
								'kode_barang': cari,
								'kode_customer': cari1
							},
							success: function(response) {
								let data_response = JSON.parse(response);
								if (!data_response) {
									$('#nmbarang').val('');
									$('#kdsatuan').val('');
									$('#harga').val('');
									$('#qty').val('');
									if (multiprc === 1) {
										cari_data_barang();
									} else {
										cari_data_tbbarang();
									}
									return;
								}
								$('#nmbarang').val(data_response['nama']);
								$('#kdsatuan').val(data_response['kdsatuan']);
								$('#harga').val(data_response['harga_jual']);
								$('#qty').val('1');
								//console.log(data_response['nama']);
								//console.log(data_response['satuan']);
							},
							error: function() {
								console.log('file not fount');
							}
						})
					})
					// }
					// console.log(cari);

					$('#multiprc').on('ifChanged', function(event) {
						if (this.checked) // if changed state is "CHECKED"
						{
							document.getElementById('srctb').setAttribute("disabled", "disabled");
							document.getElementById('srcmp').removeAttribute('disabled');
						} else {
							document.getElementById('srcmp').setAttribute("disabled", "disabled");
							document.getElementById('srctb').removeAttribute('disabled');
						}
					})

				})

				function lihat_detail(id) {
					$('#modaldetail').modal('show');
					//$('#modaldetail').find('.modal-body').html(id);
					$.ajax({
						url: './module/jual/lihat_detail.php',
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
								$href = "module/jual/proses_hapus_detail.php?id=";
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
				<?php //echo $jsArraySales; 
				?>

				function changeValueSales(id) {
					document.getElementById('kdsales').value = prdNameSales[id].kdsales;
					document.getElementById('nmsales').value = prdNameSales[id].nmsales;
				};
			</script>

			<script type="text/javascript">
				function eraseText() {
					document.getElementById("kdbarang").value = "";
					document.getElementById("nmbarang").value = "";
					document.getElementById("satuan").value = "";
					document.getElementById("qty").value = "";
					document.getElementById("harga").value = "";
					document.getElementById("discount").value = "";
					document.getElementById("subtotal").value = "";
				}

				function hit_total() {
					var lbiaya_lain = parseFloat(document.getElementById('biaya_lain').value);
					var ltotal_sementara = (parseFloat(document.getElementById('biaya_lain').value) + parseFloat(document.getElementById('subtotal').value));
					var lppn = ltotal_sementara * (parseFloat(document.getElementById('ppn').value) / 100);
					var lmaterai = parseFloat(document.getElementById('materai').value);
					var ltotal = ltotal_sementara + lmaterai + lppn;
					document.getElementById('total_sementara').value = ltotal_sementara;
					document.getElementById('total').value = ltotal;
				}
			</script>

			<!-- <script>
				$(document).ready(function() {
					$('#tbldetailjual').DataTable({
						destroy: true,
						"aLengthMenu": [
							[5, 50, 100, -1],
							[5, 50, 100, "All"]
						],
						"iDisplayLength": 5
					})
				});
			</script> -->

			<!-- <script type="text/javascript">
				$(document).ready(function() {
					$('#example1').dataTable()
					$('#example2').dataTable({
						"bPaginate": true,
						"bLengthChange": false,
						"bFilter": false,
						"bSort": true,
						"bInfo": true,
						"bAutoWidth": false
					});
				});
			</script> -->

			<script>
				$(document).ready(function() {
					$('#example3').dataTable({
						"destroy": true,
					})
					$('#example2').dataTable({
						"destroy": true,
						"bPaginate": true,
						"bLengthChange": false,
						"bFilter": false,
						"bSort": true,
						"bInfo": true,
						"bAutoWidth": false
					});
					$('#tbl-detail-jual').DataTable({
						// destroy: true,
						"aLengthMenu": [
							[5, 50, 100, -1],
							[5, 50, 100, "All"]
						],
						"iDisplayLength": 5
					})
					var table = $('#tbl-jualh').DataTable({
						destroy: true,
						"aLengthMenu": [
							[5, 50, 100, -1],
							[5, 50, 100, "All"]
						],
						"iDisplayLength": 5,
						"processing": true,
						"serverSide": true,
						"ajax": "datajualh.php",
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
								"targets": 9,
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
									// html += '<button type="button" class="btn btn-default btn-xs dt-cetak" style="margin-right:10px;"><span class="glyphicon glyphicon-print" aria-hidden="true"> SJ';
									// html += '<button type="button" class="btn btn-default btn-xs dt-cetak-fp" style="margin-right:10px;"><span class="glyphicon glyphicon-print" aria-hidden="true"> FP';
									var html = "";
									html += '<div class="dropdown"> <button class="btn btn-primary btn-sm dropdown-toggle"	type="button"	data-toggle="dropdown"> Pilih Aksi <span class="caret"> </span></button>';
									html += '<ul class = "dropdown-menu">';
									if (data[8] == "Y") { //batal
										html += '<li> <a class="dt-delete"><i class="fa fa-arrow-left"></i>Kembalikan </a></li>';
									} else {
										if (data[7] == "Y") { //proses
											html += '<li><a class="dt-unproses"><i class="fa fa-arrow-left"></i>Unproses </a></li>';
											html += '<li><a class="dt-cetak"><i class="fa fa-print"></i>Cetak Surat Jalan</a></li>';
											html += '<li><a class="dt-cetak-fp"><i class="fa fa-print"></i>Cetak Faktur</a></li>';
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
					$('#tbl-jualh tbody').on('click', '.dt-view', function() {
						var data = table.row($(this).parents('tr')).data();
						window.location.href = "?m=jual&tipe=detail_proses&id=" + data[9];
					});
					$('#tbl-jualh tbody').on('click', '.tblEdit', function() {
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
							window.location.href = "?m=jual&tipe=edit&id=" + data[9];
						} else {
							swal({
								title: "Data sudah di proses !",
								text: "Data sudah di proses, aksi tidak bisa dilanjutkan",
								icon: "error"
							})
						}
					});
					$('#tbl-jualh tbody').on('click', '.dt-detail', function() {
						var data = table.row($(this).parents('tr')).data();
						if (data[8] == "Y") {
							swal({
								title: "Data sudah batal !",
								text: "Aksi tidak bisa dilanjutkan",
								icon: "error"
							})
							exit();
						}
						if (data[7] == "N") {
							window.location.href = "?m=jual&tipe=detail&id=" + data[9] + "&module=Penjualan";
						} else {
							swal({
								title: "Data sudah di proses !",
								text: "Data sudah di proses, aksi tidak bisa dilanjutkan",
								icon: "error"
							})
						}
					});

					$('#tbl-jualh tbody').on('click', '.dt-delete', function() {
						//var data = table.row( $(this).parents('tr') ).data();
						//var id = $(this).attr("id");
						var data = table.row($(this).parents('tr')).data();
						var id = data[9];
						if (data[7] == "Y") {
							swal({
								title: "Data sudah di proses !",
								text: "Data sudah di proses, aksi tidak bisa dilanjutkan",
								icon: "error"
							})
							exit();
						}
						if (data[8] == "Y") {
							swal({
									title: "Data sudah batal !",
									text: "Yakin akan dilanjutkan ?",
									icon: "error"
								})
								.then((willDelete) => {
									if (willDelete) {
										// exit();
										//alert($kode);
										$href = "module/jual/proses_hapus.php?id=";
										window.location.href = $href + id;
										// swal("Poof! Your imaginary file has been deleted!", {
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
										$href = "module/jual/proses_hapus.php?id=";
										window.location.href = $href + id;
										// swal("Poof! Your imaginary file has been deleted!", {
										//   icon: "success",
										// });
									} else {
										//swal("Batal Hapus!");
									}
								});
						}
					});

					$('#tbl-jualh tbody').on('click', '.dt-proses', function() {
						var data = table.row($(this).parents('tr')).data();
						var id = data[9];
						if (data[8] == "Y") {
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
									$href = "module/jual/proses.php?id=";
									window.location.href = $href + id;
									// swal("Poof! Your imaginary file has been deleted!", {
									//   icon: "success",
									// });
								} else {
									//swal("Batal Hapus!");
								}
							});
					});

					$('#tbl-jualh tbody').on('click', '.dt-unproses', function() {
						var data = table.row($(this).parents('tr')).data();
						var id = data[9];
						if (data[8] == "Y") {
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
									// $href = "module/jual/batal_proses.php?id=";
									// window.location.href = $href + id;									
									$('#modalbatalproses').modal('show');
									$.ajax({
										url: './module/jual/pra_batal_proses.php',
										type: 'post',
										data: {
											id: id
										},
										success: function(response) {
											$('#modalbatalproses').find('.modal-body').html(response);
										}
									});
								} else {
									//swal("Batal Hapus!");
								}
							});
					});

					$('#tbl-jualh tbody').on('click', '.dt-cetak', function() {
						var data = table.row($(this).parents('tr')).data();
						var id = data[9];
						if (data[8] == "Y") {
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
								title: "Yakin akan di Cetak Surat Jalan ?",
								text: "",
								icon: "warning",
								buttons: true,
								dangerMode: true,
							})
							.then((willCetak) => {
								if (willCetak) {
									$href = "module/jual/cetak_sj.php?id=";
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

					$('#tbl-jualh tbody').on('click', '.dt-cetak-fp', function() {
						var data = table.row($(this).parents('tr')).data();
						var id = data[9];
						if (data[8] == "Y") {
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
								title: "Yakin akan di Cetak Faktur Penjualan ?",
								text: "",
								icon: "warning",
								buttons: true,
								dangerMode: true,
							})
							.then((willCetak) => {
								if (willCetak) {
									$href = "module/jual/cetak_fp.php?id=";
									window.open($href + id, "_blank");
									//window.location.href = $href+$id "_blank";
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
			<!-- </body> -->