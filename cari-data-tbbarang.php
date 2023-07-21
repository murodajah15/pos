<?php
include("./inc/config.php");
$filter = (isset($_POST['isifilter']) ? $_POST['isifilter'] : "");
//$query = mysqli_query($connect,"select * from mst_pegawai where nama_alias like '%$filter%' or nip like '%$filter%' limit 9");

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$username = $_SESSION['username'];

if (isset($_POST['isifilter'])) {
	$queryrows = mysqli_query($connect, "select kode from tbbarang where kode like '%$filter%' or nama like '%$filter%'");
	$query = mysqli_query($connect, "select kode,nama,harga_jual,stock from tbbarang where kode like '%$filter%' or nama like '%$filter%'");
} else {
	$queryrows = mysqli_query($connect, "select kode from tbbarang");
	$query = mysqli_query($connect, "select kode,nama,harga_jual,stock from tbbarang limit 10");
}
echo '<tr><td colspan=3>&nbsp&nbspJumlah data : ' . $queryrows->num_rows . "<BR />\n";
?>

<table id="tbl-cari-barang" class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Kode</th>
			<th>Nama</th>
			<th>Harga</th>
			<th>Stock</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if ($query->num_rows > 0) {
			while ($data = mysqli_fetch_assoc($query)) {
		?>
				<tr id="tr" style="cursor: pointer; ">
					<td id="td" name="td3" data-dismiss="modal" onclick="post_tbbarang();"><?= $data['kode']	?></td>
					<!--<0-->
					<td data-dismiss="modal" onclick="post_tbbarang();"> <?= $data['nama'] ?> </td>
					<!--<1-->
					<td style="text-align:right;" data-dismiss="modal" onclick="post_tbbarang();"> <?= $data['harga_jual'] ?> </td>
					<td hidden style="text-align:right;" data-dismiss="modal" onclick="post_tbbarang();"> <?= $data['kdsatuan'] ?> </td>
					<td style="text-align:right;" data-dismiss="modal" onclick="post_tbbarang();"> <?= $data['stock'] ?> </td>
					<!--<2-->
				</tr>
			<?php
			}
			?>
	</tbody>
</table>
<?php
		}
?>

<!-- <script>
	$(document).ready(function() {
		$('#tbl-cari-barang').DataTable({
			// destroy: true,
			"aLengthMenu": [
				[5, 50, 100, -1],
				[5, 50, 100, "All"]
			],
			"iDisplayLength": 5
		})
	})
</script> -->