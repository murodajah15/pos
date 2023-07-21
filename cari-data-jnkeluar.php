<?php
include("./inc/config.php");
$filter = (isset($_POST['isifilter']) ? $_POST['isifilter'] : "");
//$query = mysqli_query($connect,"select * from mst_pegawai where nama_alias like '%$filter%' or nip like '%$filter%' limit 9");

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$username = $_SESSION['username'];

if (isset($_POST['isifilter'])) {
	// 		$queryrows = mysqli_query($connect,"select kode from tbjnkeluar where kode like '%$filter%' or nama like '%$filter%'");
	// 		$query = $connect->prepare("select kode,nama from tbjnkeluar where (kode like ? or nama like ?)"); 
	// 		$query->bind_param("ss",$filter,$filter);
	// 		$filter = "%".$_POST['isifilter']."%";
	// 		$query->execute();
	// 		$query = $query->get_result();
	$queryrows = mysqli_query($connect, "select kode from tbjnkeluar where kode like '%$filter%' or nama like '%$filter%'");
	$query = mysqli_query($connect, "select * from tbjnkeluar where kode like '%$filter%' or nama like '%$filter%'");
} else {
	$queryrows = mysqli_query($connect, "select kode from tbjnkeluar");
	$query = mysqli_query($connect, "select * from tbjnkeluar limit 10");
}
echo '<tr><td colspan=2>&nbsp&nbspJumlah data : ' . $queryrows->num_rows . "<BR />\n";
if ($query->num_rows > 0) {
	while ($data = mysqli_fetch_assoc($query)) {
?>
		<tr id="tr" style="cursor: pointer; ">
			<td id="td" name="td3" data-dismiss="modal" onclick="post_jnkeluar();"><?= $data['kode']	?></td> <!--<0-->
			<td data-dismiss="modal" onclick="post_jnkeluar();"> <?= $data['nama'] ?> </td> <!--<1-->
		</tr>
<?php
	}
}
?>