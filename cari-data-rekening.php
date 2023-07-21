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
// 			$query = $connect->prepare("select * from mst_rekening where (norek like ? or nama like ? or bank like ? or kdbank like ?)"); 
// 			$query->bind_param("ssss",$filter,$filter,$filter,$filter);
// 		}else{
// 			$query = $connect->prepare("select * from mst_rekening where (norek like ? or nama like ? or bank like ? or kdbank like ?) and user_input=?"); 
// 			$query->bind_param("sssss",$filter,$filter,$filter,$filter,$username);
// 		}
// 		$filter = "%".$_POST['isifilter']."%";
// 		$query->execute();
// 		$query = $query->get_result();
		if ($_SESSION['level']=='ADMINISTRATOR') {
			$query = mysqli_query($connect,"select * from mst_rekening where (norek like ? or nama like ? or bank like ? or kdbank like ?)"); 
		}else{
			$query = mysqli_query($connect,"select * from mst_rekening where (norek like ? or nama like ? or bank like ? or kdbank like ?) and user_input=?"); 
		}
		echo '&nbsp&nbspJumlah data : ' . $query->num_rows . "<BR />\n"; 
	}else{
		if ($_SESSION['level']=='ADMINISTRATOR') {
			$query = mysqli_query($connect,"select * from mst_rekening limit 10");
		}else{
			$query = mysqli_query($connect,"select * from mst_rekening where user_input='$username' limit 10");
		}
		//echo '&nbsp&nbspJumlah data : ' . $query->num_rows . "<BR />\n"; 
	}
	if ($query->num_rows > 0) {
		while($data = mysqli_fetch_assoc($query)){
?>
		<tr id="tr" style="cursor: pointer; ">
			<td id="td" name="td3" data-dismiss="modal" onclick="post1();" ><?= $data['norek']	?></td> <!--<0-->
			<td data-dismiss="modal" onclick="post1();"> <?= $data['nama'] ?> </td> <!--<1-->
			<td hidden data-dismiss="modal" onclick="post1();"> <?= $data['kdbank'] ?> </td> <!--<2-->
			<td data-dismiss="modal" onclick="post1();"> <?= $data['bank'] ?> </td>
		</tr>
<?php
	}
	}
?>