<?php
include("./inc/config.php");
$filter = (isset($_POST['isifilter']) ? $_POST['isifilter'] : "");
//$query = mysqli_query($connect,"select * from mst_pegawai where nama_alias like '%$filter%' or nip like '%$filter%' limit 9");

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$username = $_SESSION['username'];

if (isset($_POST['isifilter'])) {
	// 		$query = $connect->prepare("select kode,nama from tbbarang where (kode like ? or nama like ?) limit 10"); 
	// 		$query->bind_param("ss",$filter,$filter);
	// 		$filter = "%".$_POST['isifilter']."%";
	// 		$query->execute();
	// 		$query = $query->get_result();
	$query = mysqli_query($connect, "select kdbarang as kode,nmbarang as nama, harga as harga_jual,discount from tbmultiprc where (kode like '%$filter%' or nama like '%$filter%') and kdcustomer='$kdcustomer'");
	echo '&nbsp&nbspJumlah data : ' . $query->num_rows . "<BR />\n";
} else {
	//$query = mysqli_query($connect,"select kode,nama,harga_jual,kdsatuan,lokasi from tbbarang limit 10");
	$query = mysqli_query($connect, "select kdbarang as kode,nmbarang as nama, harga as harga_jual,discount from tbmultiprc where kdcustomer='$kdcustomer' limit 10");
	// if ($_SESSION['level']=='ADMINISTRATOR') {
	// 	$query = mysqli_query($connect,"select * from tbmobil limit 10");
	// }else{
	// 	$query = mysqli_query($connect,"select * from tbmobil where user_input='$username' limit 10");
	// }
	//echo '&nbsp&nbspJumlah data : ' . $query->num_rows . "<BR />\n"; 
}
if ($query->num_rows > 0) {
	while ($data = mysqli_fetch_assoc($query)) {
?>
		<tr id="tr" style="cursor: pointer; ">
			<td id="td" name="td3" data-dismiss="modal" onclick="post_barang();"><?= $data['kode']	?></td> <!--<0-->
			<td data-dismiss="modal" onclick="post_barang();"> <?= $data['nama'] ?> </td> <!--<1-->
			<td data-dismiss="modal" onclick="post_barang();"> <?= $data['harga_jual'] ?> </td> <!--<2-->
			<!--<td hidden data-dismiss="modal" onclick="post_barang();"> <?= $data['kdsatuan'] ?> </td> <!--<2-->
			<!--<td hidden data-dismiss="modal" onclick="post_barang();"> <?= $data['lokasi'] ?> </td> <!--<2-->

		</tr>
<?php
	}
}
?>