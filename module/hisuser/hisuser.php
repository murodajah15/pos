<?php
$user = $_SESSION['username'];
if (isset($_GET['tipe'])) {
	if ($_GET['tipe'] == 'export') {
		cekakses($connect, $user, 'History User');
		$lakses = $_SESSION['aksescetak'];
		if ($lakses == 1) { ?>
			<font face='calibri'>
				<div class="panel panel-default">
					<div class="panel-heading">
						<font size="4">EXPORT DATA HISTORY USER</font>
					</div>
					<div class="panel-body">
						<form method='post' enctype='multipart/form-data' action='module/hisuser/proses_export.php'>
							<input type='hidden' name='username' value='<?= $user ?>'>
							Type : <select name=typefile class='form-control' required>
								<option value='Excel'> Excel</option>
								<option value='CSV'> CSV</option>
								<!-- <option value='PDF'> PDF</option> -->
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
} else {

	?>
	<?php
	include 'cek_akses.php';
	if ($aksesok == 'Y') {
	?>
		<font face="calibri">
			<div class="panel panel-info">
				<div class="panel-heading">
					<font size="4">HISTORY USER</font>
				</div>
				<div class="panel-body">
					<form method='post'>
						<div class="row">
							<div class="col-md-12 bg">
								<a class="btn btn-warning btn-sm" href="?m=hisuser&tipe=export">Export data</a>
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
									<th width='0'>No.</th>
									<th width='120'>Tanggal</th>
									<th>Dokumen</th>
									<th width='120'>Form</th>
									<th>Status</th>
									<th width='70'>User</th>
									<th>Catatan</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<?php
							$tampil = mysqli_query($connect, "SELECT * FROM hisuser order by datetime desc");
							$no = 1;
							// <td><u><a href='?m=hisuser&tipe=detail&id=$k[id]'><font color='blue'>$k[datetime]</font></a></u></td>
							while ($k = mysqli_fetch_assoc($tampil)) {
								echo "<tr>
					<td align='center'>$no</td>
					<td>$k[datetime]</td>
					<td>$k[dokumen]</td>
					<td>$k[form]</td>
					<td>$k[status]</td>
					<td>$k[user]</td>
					<td>$k[catatan]</td>
					<td align='center' width='60px'>";
								if ($_SESSION['level'] == 'ADMINISTRATOR') {
									cekakses($connect, $user, 'History User');
									$lakses = $_SESSION['akseshapus'];
									if ($lakses == 1) {
										//echo " <a class='btn btn-danger' href='module/tbbank/proses_hapus.php?id=$k[id]&kode=$k[kode]'
										//onClick='return confirm(\"Anda yakin akan menghapus ?\")'>Hapus</a>";
										echo " <input button type='Button' class='btn btn-danger btn-sm' value='Hapus' onClick='alert_hapus($k[id])'/>";
									} else {
										echo " <input button type='Button' class='btn btn-danger btn-sm' value='Hapus' onClick='alert_hapus($k[id])' disabled/>";
									}
								}
								echo "</td>";
								$no++;
							}
							?>
						</table>
					</div>
				</div>
			</div>
		</font>
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
					$href = "module/hisuser/proses_hapus.php?id=";
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