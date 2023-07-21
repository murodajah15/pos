<?php
	include("./inc/config.php");
	$filter = (isset($_POST['isifilter']) ? $_POST['isifilter'] : "");
	//$query = mysqli_query($connect,"select * from mst_pegawai where nama_alias like '%$filter%' or nip like '%$filter%' limit 9");
		
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	session_start();
	$username = $_SESSION['username'];
	
	if (isset($_POST['isifilter'])) {
// 		if ($_SESSION['level']=='ADMINISTRATOR') {
// 			$query = $connect->prepare("select * from mst_pegawai mst_pegawai where (nama_alias like ? or nip like ?)"); 
// 			$query->bind_param("ss",$filter,$filter);
// 		}else{
// 			$query = $connect->prepare("select * from mst_pegawai mst_pegawai where (nama_alias like ? or nip like ?) and user_input=?"); 
// 			$query->bind_param("sss",$filter,$filter,$username);			
// 		}
// 		$filter = "%".$_POST['isifilter']."%";
// 		$query->execute();
// 		$query = $query->get_result();
        if ($_SESSION['level']=='ADMINISTRATOR') {
			$query = mysqli_query($connect,"select * from mst_pegawai mst_pegawai where (nama_alias like ? or nip like ?)"); 
		}else{
			$query = mysqli_query($connect,"select * from mst_pegawai mst_pegawai where (nama_alias like ? or nip like ?) and user_input=?"); 
		}
		echo '&nbsp&nbspJumlah data : ' . $query->num_rows . "<BR />\n"; 
	}else{
		if ($_SESSION['level']=='ADMINISTRATOR') {
			$query = mysqli_query($connect,"select * from mst_pegawai limit 10");
		}else{
			$query = mysqli_query($connect,"select * from mst_pegawai where user_input='$username' limit 10");
		}
		//echo '&nbsp&nbspJumlah data : ' . $query->num_rows . "<BR />\n"; 
	}
	if ($query->num_rows > 0) {
		while($data = mysqli_fetch_assoc($query)){
?>
		<tr id="tr" style="cursor: pointer; ">
			<td id="td" name="td3" data-dismiss="modal" onclick="post();" ><?= $data['nip']	?></td> <!--<0-->
			<td data-dismiss="modal" onclick="post();"> <?= $data['nama_alias'] ?> </td> <!--<1-->
			<td data-dismiss="modal" onclick="post();"> <?= $data['norek'] ?> </td> <!--<2-->
			<td hidden data-dismiss="modal" onclick="post();"> <?= $data['nama'] ?> </td>
			<td hidden data-dismiss="modal" onclick="post();"> <?= $data['tukin'] ?> </td> <!--4-->
			<td hidden data-dismiss="modal" onclick="post();"> <?= $data['kdbank'] ?> </td> <!--5-->
			<td hidden data-dismiss="modal" onclick="post();"> <?= $data['bank'] ?> </td> <!--6-->
			<td hidden data-dismiss="modal" onclick="post();"> <?= $data['golongan'] ?> </td> <!--7-->
			<td hidden data-dismiss="modal" onclick="post();"> <?= $data['pangkat'] ?> </td> <!--8-->
			<td hidden data-dismiss="modal" onclick="post();"> <?= $data['kdeselon'] ?> </td> <!--9-->
			<td hidden data-dismiss="modal" onclick="post();"> <?= $data['nmeselon'] ?> </td> <!--10-->
			<td hidden data-dismiss="modal" onclick="post();"> <?= $data['kdsatker'] ?> </td> <!--11-->
			<td hidden data-dismiss="modal" onclick="post();"> <?= $data['nmsatker'] ?> </td> <!--12-->
			<td hidden data-dismiss="modal" onclick="post();"> <?= $data['divisi'] ?> </td> <!--13-->
			<td hidden data-dismiss="modal" onclick="post();"> <?= $data['kelas_jabatan'] ?> </td> <!--14-->
			<td hidden data-dismiss="modal" onclick="post();"> <?= $data['pr_pot_pajak'] ?> </td> <!--15-->
		</tr>
<?php
	}
	}
?>