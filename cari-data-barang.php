<?php
include("./inc/config.php");
$filter = (isset($_POST['isifilter']) ? $_POST['isifilter'] : "");
//$query = mysqli_query($connect,"select * from mst_pegawai where nama_alias like '%$filter%' or nip like '%$filter%' limit 9");

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$username = $_SESSION['username'];
$kdcustomer = $_SESSION['kdcustomer'];

if (isset($_POST['isifilter'])) {
	// 	$query = $connect->prepare("select kdbarang as kode,nmbarang as nama, harga as harga_jual,discount from tbmultiprc where (kdbarang like ? or nmbarang like ?) and kdcustomer=? limit 10");
	// 	$query->bind_param("sss", $filter, $filter, $kdcustomer);
	// 	$filter = "%" . $_POST['isifilter'] . "%";
	// 	$query->execute();
	// 	$query = $query->get_result();
	// $query = mysqli_query($connect, "select kdbarang as kode,nmbarang as nama, harga as harga_jual,discount from tbmultiprc where (kdbarang like '$filter' or nmbarang like '$filter') and kdcustomer='$kdcustomer' limit 10");
	$query = mysqli_query($connect, "select tbmultiprc.kdbarang as kode,tbmultiprc.nmbarang as nama, tbmultiprc.harga as harga_jual,tbmultiprc.discount,
	tbbarang.stock from tbmultiprc inner join tbbarang on tbmultiprc.kdbarang=tbbarang.kode where (tbmultiprc.kdbarang like '%$filter%' or tbmultiprc.nmbarang like '%$filter%') and tbmultiprc.kdcustomer='$kdcustomer'");
	$queryrows = mysqli_query($connect, "select kdbarang from tbmultiprc where (kdbarang like '%$filter%' or nmbarang like '%$filter%') and kdcustomer='$kdcustomer'");
	echo '&nbsp&nbspJumlah data : ' . $queryrows->num_rows . "<BR />\n";
} else {
	$query = mysqli_query($connect, "select tbmultiprc.kdbarang as kode,tbmultiprc.nmbarang as nama, tbmultiprc.harga as harga_jual,tbmultiprc.discount,
	tbbarang.stock from tbmultiprc inner join tbbarang on tbmultiprc.kdbarang=tbbarang.kode where tbmultiprc.kdcustomer='$kdcustomer' limit 10");
	$queryrows = mysqli_query($connect, "select kdbarang from tbmultiprc where kdcustomer='$kdcustomer'");
	echo '&nbsp&nbspJumlah data : ' . $queryrows->num_rows . "<BR />\n";
}
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
					<td id="td" name="td3" data-dismiss="modal" onclick="post_barang();"><?= $data['kode']	?></td>
					<td data-dismiss="modal" onclick="post_barang();"> <?= $data['nama'] ?> </td>
					<td style="text-align:right;" data-dismiss="modal" onclick="post_barang();"> <?= $data['harga_jual'] ?> </td>
					<td style="text-align:right;" data-dismiss="modal" onclick="post_barang();"> <?= $data['stock'] ?> </td>
					<!--<td hidden data-dismiss="modal" onclick="post_barang();"> <?= $data['kdsatuan'] ?> </td> <!--<2-->
					<!--<td hidden data-dismiss="modal" onclick="post_barang();"> <?= $data['lokasi'] ?> </td> <!--<2-->
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