<?php
include("./inc/config.php");
$filter = (isset($_POST['isifilter']) ? $_POST['isifilter'] : "");
//$query = mysqli_query($connect,"select * from mst_pegawai where nama_alias like '%$filter%' or nip like '%$filter%' limit 9");

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$username = $_SESSION['username'];

if (isset($_POST['isifilter'])) {
	// 		$queryrows = mysqli_query($connect,"select nopo from poh where (nopo like '%$filter%' or nmsupplier like '%$filter%') and proses='Y'");
	// 		$query = $connect->prepare("select nopo,tglpo,kdsupplier,nmsupplier,jenis_order,biaya_lain,ket_biaya_lain,tglkirim,carabayar,tempo,tgl_jt_tempo,subtotal,total_sementara,ppn,materai,total from poh where (nopo like ? or nmsupplier like ?) and proses='Y'"); 
	// 		$query->bind_param("ss",$filter,$filter);
	// 		$filter = "%".$_POST['isifilter']."%";
	// 		$query->execute();
	// 		$query = $query->get_result();
	$queryrows = mysqli_query($connect, "select nopo from poh where (nopo like '%$filter%' or nmsupplier like '%$filter%') and proses='Y'");
	$query = mysqli_query($connect, "select nopo,tglpo,kdsupplier,nmsupplier,jenis_order,biaya_lain,ket_biaya_lain,tglkirim,carabayar,tempo,tgl_jt_tempo,subtotal,total_sementara,ppn,materai,total from poh where (nopo like '%$filter%' or nmsupplier like '%$filter%') and proses='Y'");
} else {
	$queryrows = mysqli_query($connect, "select nopo from poh where proses='Y'");
	$query = mysqli_query($connect, "select nopo,tglpo,kdsupplier,nmsupplier,jenis_order,biaya_lain,ket_biaya_lain,tglkirim,carabayar,tempo,tgl_jt_tempo,subtotal,total_sementara,ppn,materai,total from poh where proses='Y' limit 10");
}
echo '<tr><td colspan=16>&nbsp&nbspJumlah data : ' . $queryrows->num_rows . "<BR />\n";
if ($query->num_rows > 0) {
	while ($data = mysqli_fetch_assoc($query)) {
?>
		<tr id="tr" style="cursor: pointer; ">
			<td id="td" name="td3" data-dismiss="modal" onclick="post_po();"><?= $data['nopo']	?></td> <!--<0-->
			<td data-dismiss="modal" onclick="post_po();"> <?= $data['tglpo'] ?> </td> <!--<1-->
			<td data-dismiss="modal" onclick="post_po();"> <?= $data['kdsupplier'] ?> </td> <!--<2-->
			<td data-dismiss="modal" onclick="post_po();"> <?= $data['nmsupplier'] ?> </td> <!--<3-->
			<td hidden data-dismiss="modal" onclick="post_po();"> <?= $data['jenis_order'] ?> </td> <!--<3-->
			<td hidden data-dismiss="modal" onclick="post_po();"> <?= $data['biaya_lain'] ?> </td> <!--<3-->
			<td hidden data-dismiss="modal" onclick="post_po();"> <?= $data['ket_biaya_lain'] ?> </td> <!--<3-->
			<td hidden data-dismiss="modal" onclick="post_po();"> <?= $data['tglkirim'] ?> </td> <!--<3-->
			<td hidden data-dismiss="modal" onclick="post_po();"> <?= $data['carabayar'] ?> </td> <!--<3-->
			<td hidden data-dismiss="modal" onclick="post_po();"> <?= $data['tempo'] ?> </td> <!--<3-->
			<td hidden data-dismiss="modal" onclick="post_po();"> <?= $data['tgl_jt_tempo'] ?> </td> <!--<3-->
			<td hidden data-dismiss="modal" onclick="post_po();"> <?= $data['subtotal'] ?> </td> <!--<3-->
			<td hidden data-dismiss="modal" onclick="post_po();"> <?= $data['total_sementara'] ?> </td> <!--<3-->
			<td hidden data-dismiss="modal" onclick="post_po();"> <?= $data['ppn'] ?> </td> <!--<3-->
			<td hidden data-dismiss="modal" onclick="post_po();"> <?= $data['materai'] ?> </td> <!--<3-->
			<td hidden data-dismiss="modal" onclick="post_po();"> <?= $data['total'] ?> </td> <!--<3-->
		</tr>
<?php
	}
}
?>