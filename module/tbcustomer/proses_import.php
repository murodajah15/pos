<?php
include "../../excel_reader2.php";
include "../../inc/config.php";
date_default_timezone_set('Asia/Jakarta');

// file yang tadinya di upload, di simpan di temporary file PHP, file tersebut yang kita ambil
// dan baca dengan PHP Excel Class
if ($_FILES['fileexcel']['name'] <> "") {
	$query = "delete from tbcustomer";
	$hasil = mysqli_query($connect,$query);
	
	$data = new Spreadsheet_Excel_Reader($_FILES['fileexcel']['tmp_name']);
	$hasildata = $data->rowcount($sheet_index=0);
	// default nilai 
	$sukses = 0;
	$gagal = 0;

	for ($i=2; $i<=$hasildata; $i++) {
		$data1 = $data->val($i,1);
		$data2 = addslashes(substr($data->val($i,2),0));
		$data3 = addslashes(substr($data->val($i,3),0));
		$data4 = addslashes(substr($data->val($i,4),0));
		$data5 = addslashes(substr($data->val($i,5),0));
		$data6 = addslashes(substr($data->val($i,6),0));
		$data7 = addslashes(substr($data->val($i,7),0));
		$data8 = addslashes(substr($data->val($i,8),0));
		$data9 = addslashes(substr($data->val($i,9),0));
		$data10 = addslashes(substr($data->val($i,10),0));
		$data11 = $data->val($i,11);
		$data12 = addslashes(substr($data->val($i,12),0));
		$data13 = addslashes(substr($data->val($i,13),0));
		$data14 = addslashes(substr($data->val($i,14),0));
		$data15 = addslashes(substr($data->val($i,15),0));
		$data16 = addslashes(substr($data->val($i,16),0));
		$data17 = addslashes(substr($data->val($i,17),0));
		$data18 = addslashes(substr($data->val($i,18),0));
		$data19 = addslashes(substr($data->val($i,19),0));
		$data20 = addslashes(substr($data->val($i,20),0));
		$data21 = addslashes(substr($data->val($i,21),0));
		$data22 = addslashes(substr($data->val($i,22),0));
		$data23 = addslashes(substr($data->val($i,23),0));
		$data24 = $data->val($i,24);
		$data25 = $data->val($i,25);
		$created_by = 'Import by Admin'; 
		$date = date('d-m-Y H:i:s'); /*date('Y-m-d H:i:s');**/
		$rand = rand();
	 
		$query = "INSERT INTO tbcustomer VALUES (null,'$data2','$data3','$data4','$data5','$data6','$data7','$data8','$data9','$data10','$data11','$data12','$data13','$data14','$data15','$data16','$data17','$data18','$data19','$data20','$data21','$data22','$data23','$data24','$data25','$created_by-$date')";
		$hasil = mysqli_query($connect,$query);
		 
		if ($hasil) $sukses++;
		else $gagal++;
		 
		//echo "< pre>";
		//print_r($query);
		//echo "< /pre>";
	}
	echo "<script>alert('$sukses Data yang berhasil di import, $gagal Data yang gagal di import');history.go(-2);</script>";
	/*echo $_FILES['fileexcel']['name'];
	echo "<br><b>import data selesai.</b><br>";
	echo $sukses." Data yang berhasil di import<br>";
	echo $gagal." Data yang gagal diimport<br>";
	echo "<input button type='Button' class='btn btn-danger' value='Back' onClick='history.back()'/>";**/
}else{
	echo "<b>Import data gagal.</b><br>";
	echo "<input button type='Button' class='btn btn-danger' value='Back' onClick='history.back()'/>";
}
?>