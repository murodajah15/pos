<?php
$user = $_SESSION['username'];
include "autonumber.php";

if (isset($_GET['tipe'])) {
	if ($_GET['tipe'] == 'import') {
		cekakses($connect, $user, 'Approv Batas Piutang');
		$lakses = $_SESSION['aksestambah'];
		if ($lakses == 1) { ?>
			<font face='calibri'>
				<div class="panel panel-success">
					<div class="panel-heading">
						<font size="4">IMPORT DATA APPROV BATAS PIUTANG</font>
					</div>
					<div class="panel-body">
						<form method='post' enctype='multipart/form-data' action='module/approv_batas_piutang/proses_import.php'>
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
		cekakses($connect, $user, 'Approv Batas Piutang');
		$lakses = $_SESSION['aksescetak'];
		if ($lakses == 1) { ?>
			<font face='calibri'>
				<div class="panel panel-default">
					<div class="panel-heading">
						<font size="4">EXPORT DATA APPROV BATAS PIUTANG</font>
					</div>
					<div class="panel-body">
						<form method='post' enctype='multipart/form-data' action='module/approv_batas_piutang/proses_export.php'>
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
		cekakses($connect, $user, 'Approv Batas Piutang');
		$lakses = $_SESSION['aksespakai'];
		if ($lakses == 1) {
			// $query = $connect->prepare("select * from approv_batas_piutang where id=?");
			// $query->bind_param('i', $_GET['id']);
			// $result = $query->execute();
			// $query->store_result();
			// $query->execute();
			// $result = $query->get_result();
			// $de = $result->fetch_assoc();
			$sql = mysqli_query($connect, "select * from approv_batas_piutang where id='$_GET[id]'");
			$de = mysqli_fetch_assoc($sql);
			$noapprov = strip_tags($de['noapprov']);
			$noapprov = strip_tags($de['noapprov']);
			$tglapprov = strip_tags($de['tglapprov']);
			$nojual = strip_tags($de['nojual']);
			$tgljual = strip_tags($de['tgljual']);
			$nmcustomer = strip_tags($de['nmcustomer']);
			$total = strip_tags($de['total']);
			$keterangan = strip_tags($de['keterangan']);
		?>
			<font face="calibri">
				<div class="panel panel-warning">
					<div class="panel-heading">
						<font size="4">DETAIL DATA APPROV BATAS PIUTANG</font>
					</div>
					<div class="panel-body">
						<form method="post" enctype="multipart/form-data">
							<input type="hidden" name="username" value="<?= $user ?>">
							<input type="hidden" name="id" value="<?= $de["id"] ?>">
							<div class='col-md-6'>
								<table style=font-size:13px; class="table table-striped table table-bordered">
									<tr>
										<td>Nomor Approv</td>
										<td>
											<input type='text' class='form-control' id='noapprov' name='noapprov' placeholder='No. Approv *' style='text-transform:uppercase' value="<?= $noapprov ?>" readonly>
										</td>
									</tr>
									<tr>
										<td>Tgl. Approv (M/D/Y)</td>
										<td><input type='date' class='form-control' id='tglapprov' name='tglapprov' value="<?= $tglapprov ?>" autocomplete='off' required></td>
									</tr>
									<tr>
										<td>Nomor Penjualan</td>
										<td>
											<div class='input-group'> <input type='text' class='form-control' id='nojual' name='nojual' size='50' value='<?= $nojual ?>' autocomplete='off' readonly required>
									<tr>
										<td></td>
										<td> <input type="date" class='form-control' id='tgljual' name='tgljual' value="<?= $tgljual ?>" readonly required></td>
									</tr>
									<tr>
										<td></td>
										<td> <input type="text" class='form-control' id='nmcustomer' name='nmcustomer' value="<?= $nmcustomer ?>" readonly required></td>
									</tr>
									<tr>
										<td></td>
										<td> <input type="number" class='form-control' id='total' name='total' value="<?= $total ?>" readonly required></td>
									</tr>
									<tr>
										<td>Keterangan</td>
										<td> <textarea rows='3' class='form-control' name='keterangan' id='keterangan' readonly><?= $keterangan ?></textarea></td>
									</tr>
								</table>
							</div>
							<div class='col-md-12'>
								<input button type='Button' class='btn btn-danger' value='Close' onClick='history.back()' />
								<!--<input button type='Button' class='btn btn-danger' value='Close' onClick="window.location.href='?m=approv_batas_piutang'"/>-->
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
		cekakses($connect, $user, 'Approv Batas Piutang');
		$lakses = $_SESSION['aksestambah'];
		$tgl = date('Y-m-d');
		if ($lakses == 1) { ?>
			<font face='calibri'>
				<div class='panel panel-danger'>
					<div class='panel-heading'>
						<font size="4">TAMBAH DATA APPROV BATAS PIUTANG</font>
					</div>
					<div class='panel-body'>
						<form method='post' name='approv_batas_piutang' enctype='multipart/form-data' action='module/approv_batas_piutang/proses_tambah.php'>
							<input type='hidden' name='username' value="<?= $user ?>">
							<div class='col-md-6'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>Nomor Approv</td>
										<td>
											<input type='text' class='form-control' id='noapprov' name='noapprov' placeholder='No. Approv *' style='text-transform:uppercase' value="<?php echo autoNumberAP($connect, 'id', 'approv_batas_piutang'); ?>" readonly>
										</td>
									</tr>
									<tr>
										<td>Tgl. Approv (M/D/Y)</td>
										<td><input type='date' class='form-control' id='tglapprov' name='tglapprov' value="<?php echo $tgl ?>" size='50' autocomplete='off' required readonly></td>
									</tr>
									<tr>
										<td>Nomor Penjualan</td>
										<td>
											<div class='input-group'> <input type='text' class='form-control' id='nojual' name='nojual' size='50' autocomplete='off' readonly required>
												<span class='input-group-btn'>
													<button type='button' id='src' class='btn btn-primary' onclick='cari_data_penjualan()'>Cari</button>
												</span>
										</td>
									<tr>
										<td></td>
										<td> <input type="text" class='form-control' id='tgljual' name='tgljual' readonly required></td>
									</tr>
									<tr>
										<td></td>
										<td> <input type="text" class='form-control' id='nmcustomer' name='nmcustomer' readonly required></td>
									</tr>
									<tr>
										<td></td>
										<td> <input type="number" class='form-control' id='total' name='total' readonly required></td>
									</tr>
									<tr>
										<td>Keterangan</td>
										<td> <textarea rows='3' class='form-control' name='keterangan' id='keterangan'></textarea></td>
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
		cekakses($connect, $user, 'Approv Batas Piutang');
		$lakses = $_SESSION['aksesedit'];
		if ($lakses == 1) {
			$proses = 'N';
			// $query = $connect->prepare("select * from approv_batas_piutang where proses=? and id=?");
			// $query->bind_param('si', $proses, $_GET['id']);
			// $query->execute();
			// $result = $query->get_result();
			// $de = $result->fetch_assoc();
			$sql = mysqli_query($connect, "select * from approv_batas_piutang where id='$_GET[id]'");
			$de = mysqli_fetch_assoc($sql);
			$noapprov = strip_tags($de['noapprov']);
			$noapprov = strip_tags($de['noapprov']);
			$tglapprov = strip_tags($de['tglapprov']);
			$nojual = strip_tags($de['nojual']);
			$tgljual = strip_tags($de['tgljual']);
			$nmcustomer = strip_tags($de['nmcustomer']);
			$total = strip_tags($de['total']);
			$keterangan = strip_tags($de['keterangan']);
		?>
			<font face="calibri">
				<div class="panel panel-info">
					<div class="panel-heading">
						<font size="4">EDIT DATA APPROV BATAS PIUTANG</font>
					</div>
					<div class="panel-body">
						<form method="post" enctype="multipart/form-data" action="module/approv_batas_piutang/proses_edit.php">
							<input type="hidden" name="username" value="<?= $user ?>">
							<input type="hidden" name="id" value="<?= $de["id"] ?>">
							<div class='col-md-6'>
								<table style=font-size:13px; class="table table-striped table table-bordered">
									<tr>
										<td>Nomor Approv</td>
										<td>
											<input type='text' class='form-control' id='noapprov' name='noapprov' placeholder='No. Approv *' style='text-transform:uppercase' value="<?= $noapprov ?>" readonly>
										</td>
									</tr>
									<tr>
										<td>Tgl. Approv (M/D/Y)</td>
										<td><input type='date' class='form-control' id='tglapprov' name='tglapprov' value="<?= $tglapprov ?>" autocomplete='off' required></td>
									</tr>
									<tr>
										<td>Nomor Penjualan</td>
										<td>
											<div class='input-group'> <input type='text' class='form-control' id='nojual' name='nojual' size='50' value='<?= $nojual ?>' autocomplete='off' readonly required>
												<span class='input-group-btn'>
													<button type='button' id='src' class='btn btn-primary' onclick='cari_data_penjualan()'>Cari</button>
												</span>
										</td>
									<tr>
										<td></td>
										<td> <input type="date" class='form-control' id='tgljual' name='tgljual' value="<?= $tgljual ?>" readonly required></td>
									</tr>
									<tr>
										<td></td>
										<td> <input type="text" class='form-control' id='nmcustomer' name='nmcustomer' value="<?= $nmcustomer ?>" readonly required></td>
									</tr>
									<tr>
										<td></td>
										<td> <input type="number" class='form-control' id='total' name='total' value="<?= $total ?>" readonly required></td>
									</tr>
									<tr>
										<td>Keterangan</td>
										<td> <textarea rows='3' class='form-control' name='keterangan' id='keterangan'><?= $keterangan ?></textarea></td>
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
					<font size="4">APPROV BATAS PIUTANG</font>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-4 bg">
							<a class="btn btn-primary btn-sm" href="?m=approv_batas_piutang&tipe=tambah"><i class="fa fa-plus"></i> Tambah data</a>
						</div>
					</div>
					</br>
					<div class="box-body table-responsive">
						<!-- <table id="example1" class="table table-bordered table-striped"> -->
						<table id="tbl-approv" class="table table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th width='30'>No.</th>
									<th width='80'>No. Approv</th>
									<th width='80'>Tgl. Approv</th>
									<th width='80'>No.Penjualan</th>
									<th width='70'>Tgl.Penjualan</th>
									<th width='70'>Total</th>
									<th width='20'>Proses</th>
									<th width='20'>Batal</th>
									<th width='100'>Aksi</th>
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

			<?php
			function konversitext($field)
			{
				echo htmlentities($field, ENT_QUOTES);
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
				function lihat_detail(id) {
					$('#modaldetail').modal('show');
					//$('#modaldetail').find('.modal-body').html(id);
					$.ajax({
						url: './module/approv_batas_piutang/lihat_detail.php',
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
								//alert($noapprov);
								$href = "module/approv_batas_piutang/proses_hapus.php?id=";
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
								$href = "module/approv_batas_piutang/proses.php?id=";
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
				$(document).ready(function() {
					$('#tbl-detail-terima').DataTable({
						// destroy: true,
						"aLengthMenu": [
							[5, 50, 100, -1],
							[5, 50, 100, "All"]
						],
						"iDisplayLength": 5
					})
					var table = $('#tbl-approv').DataTable({
						destroy: true,
						"aLengthMenu": [
							[5, 50, 100, -1],
							[5, 50, 100, "All"]
						],
						"iDisplayLength": 5,
						"processing": true,
						"serverSide": true,
						"ajax": "dataapprov_batas_piutang.php",
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
								"targets": 8,
								"data": null,
								"render": function(data, type, row) { // Tampilkan kolom aksi
									var html = "";
									// var html = "<a class='btn btn-success btn-xs' href='?m=jual&tipe=detail_proses&nojual=$k[nojual]&kdcustomer=$k[kdcustomer]'>Detail</a> ";
									// var html = '<button type="button" class="btn btn-success btn-xs dt-view" style="margin-right:10px;"><span class="glyphicon glyphicon-eye-open glyphicon-info-sign" aria-hidden="true"></span></button>';
									html += '<button type="button" class="btn btn-info btn-xs tblEdit" style="margin-right:10px;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>';
									// html += '<button type="button" class="btn btn-info btn-xs dt-detail" style="margin-right:10px;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>D</button>';
									html += '<button type="button" class="btn btn-danger btn-xs dt-delete" style="margin-right:10px;"><span class="glyphicon glyphicon-remove glyphicon-trash" aria-hidden="true">';
									html += '<button type="button" class="btn btn-warning btn-xs dt-proses" style="margin-right:10px;"><span class="glyphicon glyphicon-circle-arrow-right" aria-hidden="true">';
									html += '<button type="button" class="btn btn-danger btn-xs dt-unproses" style="margin-right:10px;"><span class="glyphicon glyphicon-circle-arrow-left" aria-hidden="true">';
									// html += '<button type="button" class="btn btn-default btn-xs dt-cetak" style="margin-right:10px;"><span class="glyphicon glyphicon-print" aria-hidden="true">';
									// html += '<button type="button" class="btn btn-default btn-xs dt-cetak-fp" style="margin-right:10px;"><span class="glyphicon glyphicon-print" aria-hidden="true"> FP';
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
					$('#tbl-approv tbody').on('click', '.dt-view', function() {
						var data = table.row($(this).parents('tr')).data();
						window.location.href = "?m=approv_batas_piutang&tipe=detail_proses&id=" + data[9]
					});
					$('#tbl-approv tbody').on('click', '.tblEdit', function() {
						var data = table.row($(this).parents('tr')).data();
						if (data[9] == "Y") {
							swal({
								title: "Data sudah batal !",
								text: "Aksi tidak bisa dilanjutkan",
								icon: "error"
							})
							exit();
						}
						if (data[8] == "N") {
							window.location.href = "?m=approv_batas_piutang&tipe=edit&id=" + data[9]
						} else {
							swal({
								title: "Data sudah di proses !",
								text: "Aksi tidak bisa dilanjutkan",
								icon: "error"
							})
						}
					});
					$('#tbl-approv tbody').on('click', '.dt-detail', function() {
						var data = table.row($(this).parents('tr')).data();
						if (data[9] == "Y") {
							swal({
								title: "Data sudah batal !",
								text: "Aksi tidak bisa dilanjutkan",
								icon: "error"
							})
							exit();
						}
						if (data[8] == "N") {
							window.location.href = "?m=approv_batas_piutang&tipe=detail&id=" + data[9]
						} else {
							swal({
								title: "Data sudah di proses !",
								text: "Aksi tidak bisa dilanjutkan",
								icon: "error"
							})
						}
					});

					$('#tbl-approv tbody').on('click', '.dt-delete', function() {
						//var data = table.row( $(this).parents('tr') ).data();
						//var id = $(this).attr("id");
						var data = table.row($(this).parents('tr')).data();
						var id = data[9];
						if (data[8] == "Y") {
							swal({
								title: "Data sudah di proses",
								text: "Aksi tidak bisa dilanjutkan",
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
										$href = "module/approv_batas_piutang/proses_hapus.php?id=";
										window.location.href = $href + id;
										// swal("terimaof! Your imaginary file has been deleted!", {
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
										$href = "module/approv_batas_piutang/proses_hapus.php?id=";
										window.location.href = $href + id;
										// swal("terimaof! Your imaginary file has been deleted!", {
										//   icon: "success",
										// });
									} else {
										//swal("Batal Hapus!");
									}
								});
						}
					});

					$('#tbl-approv tbody').on('click', '.dt-proses', function() {
						var data = table.row($(this).parents('tr')).data();
						var id = data[9];
						if (data[10] == "Y") {
							swal({
								title: "Data sudah batal !",
								text: "Aksi tidak bisa dilanjutkan",
								icon: "error"
							})
							exit();
						}
						if (data[8] == "Y") {
							swal({
								title: "Data sudah di proses !",
								text: "Aksi tidak bisa dilanjutkan",
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
									$href = "module/approv_batas_piutang/proses.php?id=";
									window.location.href = $href + id;
									// swal("terimaof! Your imaginary file has been deleted!", {
									//   icon: "success",
									// });
								} else {
									//swal("Batal Hapus!");
								}
							});
					});

					$('#tbl-approv tbody').on('click', '.dt-unproses', function() {
						var data = table.row($(this).parents('tr')).data();
						var id = data[9];
						if (data[10] == "Y") {
							swal({
								title: "Data sudah batal !",
								text: "Aksi tidak bisa dilanjutkan",
								icon: "error"
							})
							exit();
						}
						if (data[8] == "N") {
							swal({
								title: "Data belum diproses !",
								text: "Aksi tidak bisa dilanjutkan",
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
									$href = "module/approv_batas_piutang/batal_proses.php?id=";
									window.location.href = $href + id;
									// swal("terimaof! Your imaginary file has been deleted!", {
									//   icon: "success",
									// });
								} else {
									//swal("Batal Hapus!");
								}
							});
					});


					$('#tbl-approv tbody').on('click', '.dt-cetak', function() {
						var data = table.row($(this).parents('tr')).data();
						var id = data[9];
						if (data[8] == "N") {
							swal({
								title: "Data belum diproses !",
								text: "Aksi tidak bisa dilanjutkan",
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
									$href = "module/approv_batas_piutang/cetak.php?id=";
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