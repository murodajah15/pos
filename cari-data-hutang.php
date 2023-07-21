<?php
include("./inc/config.php");
$filter = (isset($_POST['isifilter']) ? $_POST['isifilter'] : "");
//$query = mysqli_query($connect,"select * from mst_pegawai where nama_alias like '%$filter%' or nip like '%$filter%' limit 9");

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$username = $_SESSION['username'];

if (isset($_POST['isifilter'])) {
	// 		$queryrows = mysqli_query($connect,"select nobeli from belih where nobeli like '%$filter%' or nmsupplier like '%$filter%'");
	// 		$query = $connect->prepare("select nobeli,tglbeli,kdsupplier,nmsupplier,total from belih where (nobeli like ? or nmsupplier like ?)"); 
	// 		$query->bind_param("ss",$filter,$filter);
	// 		$filter = "%".$_POST['isifilter']."%";
	// 		$query->execute();
	// 		$query = $query->get_result();
	$queryrows = mysqli_query($connect, "select nobeli from belih where nobeli like '%$filter%' or nmsupplier like '%$filter%'");
	$query = mysqli_query($connect, "select nobeli,tglbeli,kdsupplier,nmsupplier,total from belih where nobeli like '%$filter%' or nmsupplier like '%$filter%'");
} else {
	$queryrows = mysqli_query($connect, "select nobeli from belih");
	$query = mysqli_query($connect, "select nobeli,tglbeli,kdsupplier,nmsupplier,total from belih limit 10");
}
echo '<tr><td colspan=5>&nbsp&nbspJumlah data : ' . $queryrows->num_rows . "<BR />\n";
if ($query->num_rows > 0) {
	while ($data = mysqli_fetch_assoc($query)) {
?>
		<tr id="tr" style="cursor: pointer; ">
			<td id="td" name="td3" data-dismiss="modal" onclick="post_hutang();"><?= $data['nobeli']	?></td> <!--<0-->
			<td data-dismiss="modal" onclick="post_hutang();"> <?= $data['tglbeli'] ?> </td> <!--<1-->
			<td data-dismiss="modal" onclick="post_hutang();"> <?= $data['kdsupplier'] ?> </td> <!--<2-->
			<td data-dismiss="modal" onclick="post_hutang();"> <?= $data['nmsupplier'] ?> </td> <!--<2-->
			<td hidden data-dismiss="modal" onclick="post_hutang();"> <?= $data['total'] ?> </td> <!--<2-->

		</tr>
<?php
	}
}
?>