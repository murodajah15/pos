<?php
include("./inc/config.php");
$filter = (isset($_POST['isifilter']) ? $_POST['isifilter'] : "");
//$query = mysqli_query($connect,"select * from mst_pegawai where nama_alias like '%$filter%' or nip like '%$filter%' limit 9");

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$username = $_SESSION['username'];

if (isset($_POST['isifilter'])) {
	// 	$queryrows = mysqli_query($connect, "select kode from tbcustomer where kode like '%$filter%' or nama like '%$filter%' or alamat like '%$filter%'");
	// 	$query = $connect->prepare("select kode,nama,alamat from tbcustomer where (kode like ? or nama like ? or alamat like ?)");
	// 	$query->bind_param("sss", $filter, $filter, $filter);
	// 	$filter = "%" . $_POST['isifilter'] . "%";
	// 	$query->execute();
	// 	$query = $query->get_result();
	$queryrows = mysqli_query($connect, "select kode from tbcustomer where kode like '%$filter%' or nama like '%$filter%' or alamat like '%$filter%'");
	$query = mysqli_query($connect, "select kode,nama,alamat from tbcustomer where kode like '%$filter%' or nama like '%$filter%' or alamat like '%$filter%'");
} else {
	$queryrows = mysqli_query($connect, "select kode from tbcustomer");
	$query = mysqli_query($connect, "select kode,nama,alamat from tbcustomer limit 10");
}
echo '<tr><td colspan=3>&nbsp&nbspJumlah data : ' . $queryrows->num_rows . "<BR />\n";
if ($query->num_rows > 0) {
	while ($data = mysqli_fetch_assoc($query)) {
?>
		<tr id="tr" style="cursor: pointer; ">
			<td id="td" name="td3" data-dismiss="modal" onclick="post_customer();"><?= $data['kode']	?></td> <!--<0-->
			<td data-dismiss="modal" onclick="post_customer();"> <?= $data['nama'] ?> </td> <!--<1-->
			<td data-dismiss="modal" onclick="post_customer();"> <?= $data['alamat'] ?> </td> <!--<2-->
		</tr>
<?php
	}
}
?>