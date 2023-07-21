<?php
include("./inc/config.php");
$filter = (isset($_POST['isifilter']) ? $_POST['isifilter'] : "");
//$query = mysqli_query($connect,"select * from mst_pegawai where nama_alias like '%$filter%' or nip like '%$filter%' limit 9");

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$username = $_SESSION['username'];

if (isset($_POST['isifilter'])) {
	// 		$queryrows = mysqli_query($connect,"select nojual from jualh where (nojual like '%$filter%' or nmcustomer like '%$filter%') and sudahbayar>0");
	// 		$query = $connect->prepare("select nojual,tgljual,kdcustomer,nmcustomer,sudahbayar as total from jualh where (nojual like ? or nmcustomer like ?) and sudahbayar>0"); 
	// 		$query->bind_param("ss",$filter,$filter);
	// 		$filter = "%".$_POST['isifilter']."%";
	// 		$query->execute();
	// $query = $query->get_result();
	$queryrows = mysqli_query($connect, "select nojual from jualh where (nojual like '%$filter%' or nmcustomer like '%$filter%') and sudahbayar>0");
	$query = mysqli_query($connect, "select nojual,tgljual,kdcustomer,nmcustomer,sudahbayar as total from jualh where (nojual like '%$filter%' or nmcustomer like '%$filter%') and sudahbayar>0");
} else {
	$queryrows = mysqli_query($connect, "select nojual from jualh where sudahbayar>0");
	$query = mysqli_query($connect, "select nojual,tgljual,kdcustomer,nmcustomer,sudahbayar as total from jualh where sudahbayar>0 limit 10");
}
echo '<tr><td colspan=5>&nbsp&nbspJumlah data : ' . $queryrows->num_rows . "<BR />\n";
if ($query->num_rows > 0) {
	while ($data = mysqli_fetch_assoc($query)) {
?>
		<tr id="tr" style="cursor: pointer; ">
			<td id="td" name="td3" data-dismiss="modal" onclick="post_kembali();"><?= $data['nojual']	?></td> <!--<0-->
			<td data-dismiss="modal" onclick="post_kembali();"> <?= $data['tgljual'] ?> </td> <!--<1-->
			<td data-dismiss="modal" onclick="post_kembali();"> <?= $data['kdcustomer'] ?> </td> <!--<2-->
			<td data-dismiss="modal" onclick="post_kembali();"> <?= $data['nmcustomer'] ?> </td> <!--<2-->
			<td hidden data-dismiss="modal" onclick="post_kembali();"> <?= $data['total'] ?> </td> <!--<2-->

		</tr>
<?php
	}
}
?>