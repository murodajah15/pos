<?php
include("./inc/config.php");
$filter = (isset($_POST['isifilter']) ? $_POST['isifilter'] : "");
//$query = mysqli_query($connect,"select * from mst_pegawai where nama_alias like '%$filter%' or nip like '%$filter%' limit 9");

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$username = $_SESSION['username'];

if (isset($_POST['isifilter'])) {
	// 		$queryrows = mysqli_query($connect,"select nomohon from mohklruangh where (nomohon like '%$filter%' or nmjnkeluar like '%$filter%') and proses='Y' and kurang>0");
	// 		$query = $connect->prepare("select nomohon,tglmohon,nmjnkeluar,kdjnkeluar from mohklruangh where proses='Y' and kurang>0 and (nomohon like ? or nmjnkeluar like ?) and proses='Y' and kurang>0"); 
	// 		$query->bind_param("ss",$filter,$filter);
	// 		$filter = "%".$_POST['isifilter']."%";
	// 		$query->execute();
	// 		$query = $query->get_result();
	$queryrows = mysqli_query($connect, "select nomohon from mohklruangh where (nomohon like '%$filter%' or nmjnkeluar like '%$filter%') and proses='Y' and kurang>0");
	$query = mysqli_query($connect, "select nomohon,tglmohon,nmjnkeluar,kdjnkeluar from mohklruangh where (nomohon like '%$filter%' or nmjnkeluar like '%$filter%') and proses='Y' and kurang>0");
} else {
	$queryrows = mysqli_query($connect, "select nomohon from mohklruangh where proses='Y' and kurang>0");
	$query = mysqli_query($connect, "select nomohon,tglmohon,nmjnkeluar,kdjnkeluar from mohklruangh where proses='Y' and kurang>0 limit 10");
}
echo '<tr><td colspan=4>&nbsp&nbspJumlah data : ' . $queryrows->num_rows . "<BR />\n";
if ($query->num_rows > 0) {
	while ($data = mysqli_fetch_assoc($query)) {
?>
		<tr id="tr" style="cursor: pointer; ">
			<td id="td" name="td3" data-dismiss="modal" onclick="post_permohonan();"><?= $data['nomohon']	?></td> <!--<0-->
			<td data-dismiss="modal" onclick="post_permohonan();"> <?= $data['tglmohon'] ?> </td> <!--<1-->
			<td data-dismiss="modal" onclick="post_permohonan();"> <?= $data['nmjnkeluar'] ?> </td> <!--<2-->
			<td hidden data-dismiss="modal" onclick="post_permohonan();"> <?= $data['kdjnkeluar'] ?> </td> <!--<2-->

		</tr>
<?php
	}
}
?>