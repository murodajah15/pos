<?php
include("./inc/config.php");
$filter = (isset($_POST['isifilter']) ? $_POST['isifilter'] : "");
//$query = mysqli_query($connect,"select * from mst_pegawai where nama_alias like '%$filter%' or nip like '%$filter%' limit 9");

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$username = $_SESSION['username'];
if (isset($_POST['isifilter'])) {
	// 		$queryrows = $connect->prepare("select noso from soh where (noso like '%$filter%' or nmcustomer like '%$filter%') and proses='Y' and terima='N'"); 
	// 		$query = $connect->prepare("select noso,tglso,kdcustomer,nmcustomer,jenis_order,biaya_lain,ket_biaya_lain,tglkirim,carabayar,tempo,tgl_jt_tempo,subtotal,total_sementara,ppn,materai,total from soh where (noso like ? or nmcustomer like ?) and proses='Y' and terima='N'"); 
	// 		$query->bind_param("ss",$filter,$filter);
	// 		$filter = "%".$_POST['isifilter']."%";
	// 		$query->execute();
	// 		$query = $query->get_result();
	$queryrows = mysqli_query($connect, "select noso from soh where (noso like '%$filter' or nmcustomer like '%$filter') and proses='Y' and terima='N'");
	$query = mysqli_query($connect, "select noso,tglso,kdcustomer,nmcustomer,jenis_order,biaya_lain,ket_biaya_lain,tglkirim,carabayar,tempo,tgl_jt_tempo,subtotal,total_sementara,ppn,materai,total from soh where (noso like '%$filter%' or nmcustomer like '%$filter%') and proses='Y' and terima='N'");
} else {
	$queryrows = mysqli_query($connect, "select noso from soh where proses='Y' and terima='N'");
	$query = mysqli_query($connect, "select noso,tglso,kdcustomer,nmcustomer,jenis_order,biaya_lain,ket_biaya_lain,tglkirim,carabayar,tempo,tgl_jt_tempo,subtotal,total_sementara,ppn,materai,total from soh where proses='Y' and terima='N' limit 10");
}
echo '<tr><td colspan=16>&nbsp&nbspJumlah data : ' . $queryrows->num_rows . "<BR />\n";
if ($query->num_rows > 0) {
	while ($data = mysqli_fetch_assoc($query)) {
?>
		<tr id="tr" style="cursor: pointer; ">
			<td id="td" name="td3" data-dismiss="modal" onclick="post_so();"><?= $data['noso']	?></td> <!--<0-->
			<td data-dismiss="modal" onclick="post_so();"> <?= $data['tglso'] ?> </td> <!--<1-->
			<td data-dismiss="modal" onclick="post_so();"> <?= $data['kdcustomer'] ?> </td> <!--<2-->
			<td data-dismiss="modal" onclick="post_so();"> <?= $data['nmcustomer'] ?> </td> <!--<3-->
			<td hidden data-dismiss="modal" onclick="post_so();"> <?= $data['jenis_order'] ?> </td> <!--<3-->
			<td hidden data-dismiss="modal" onclick="post_so();"> <?= $data['biaya_lain'] ?> </td> <!--<3-->
			<td hidden data-dismiss="modal" onclick="post_so();"> <?= $data['ket_biaya_lain'] ?> </td> <!--<3-->
			<td hidden data-dismiss="modal" onclick="post_so();"> <?= $data['tglkirim'] ?> </td> <!--<3-->
			<td hidden data-dismiss="modal" onclick="post_so();"> <?= $data['carabayar'] ?> </td> <!--<3-->
			<td hidden data-dismiss="modal" onclick="post_so();"> <?= $data['tempo'] ?> </td> <!--<3-->
			<td hidden data-dismiss="modal" onclick="post_so();"> <?= $data['tgl_jt_tempo'] ?> </td> <!--<3-->
			<td hidden data-dismiss="modal" onclick="post_so();"> <?= $data['subtotal'] ?> </td> <!--<3-->
			<td hidden data-dismiss="modal" onclick="post_so();"> <?= $data['total_sementara'] ?> </td> <!--<3-->
			<td hidden data-dismiss="modal" onclick="post_so();"> <?= $data['ppn'] ?> </td> <!--<3-->
			<td hidden data-dismiss="modal" onclick="post_so();"> <?= $data['materai'] ?> </td> <!--<3-->
			<td hidden data-dismiss="modal" onclick="post_so();"> <?= $data['total'] ?> </td> <!--<3-->
		</tr>
<?php
	}
}
?>