<?php
include("./inc/config.php");
$filter = (isset($_POST['isifilter']) ? $_POST['isifilter'] : "");
//$query = mysqli_query($connect,"select * from mst_pegawai where nama_alias like '%$filter%' or nip like '%$filter%' limit 9");

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$username = $_SESSION['username'];

if (isset($_POST['isifilter'])) {
	// 		$queryrows = mysqli_query($connect,"select noopname from opnameh where (noopname like '%$filter%' or tglopname like '%$filter%') and proses='Y'");
	// 		$query = $connect->prepare("select noopaname,tglopname from opnameh where (noopname like ? or tglopname like ?) and proses='Y'"); 
	// 		$query->bind_param("ss",$filter,$filter);
	// 		$filter = "%".$_POST['isifilter']."%";
	// 		$query->execute();
	// 		$query = $query->get_result();
	$queryrows = mysqli_query($connect, "select noopname from opnameh where (noopname like '%$filter%' or tglopname like '%$filter%') and proses='Y'");
	$query = mysqli_query($connect, "select * from opnameh where (noopname like '%$filter%' or tglopname like '%$filter%') and proses='Y'");;
} else {
	$queryrows = mysqli_query($connect, "select noopname from opnameh where proses='Y'");
	$query = mysqli_query($connect, "select * from opnameh where proses='Y' limit 10");
}
echo '<tr><td colspan=2>&nbsp&nbspJumlah data : ' . $queryrows->num_rows . "<BR />\n";
if ($query->num_rows > 0) {
	while ($data = mysqli_fetch_assoc($query)) {
?>
		<tr id="tr" style="cursor: pointer; ">
			<td id="td" name="td3" data-dismiss="modal" onclick="post_opname();"><?= $data['noopname']	?></td> <!--<0-->
			<td data-dismiss="modal" onclick="post_opname();"> <?= $data['tglopname'] ?> </td> <!--<1-->
		</tr>
<?php
	}
}
?>