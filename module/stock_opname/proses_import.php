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
		$data2 = $data->val($i,2);
		$data3 = $data->val($i,3);
		$data4 = $data->val($i,4);
		$data5 = $data->val($i,5);
		$data6 = $data->val($i,6);
		$data7 = $data->val($i,7);
		$data8 = $data->val($i,8);
		$data9 = $data->val($i,9);
		$data10 = $data->val($i,10);
		$data11 = $data->val($i,11);
		$data12 = $data->val($i,12);
		$data13 = $data->val($i,13);
		$data14 = $data->val($i,14);
		$data15 = $data->val($i,15);
		$data16 = $data->val($i,16);
		$data17 = $data->val($i,17);
		$data18 = $data->val($i,18);
		$data19 = $data->val($i,19);
		$data20 = $data->val($i,20);
		$data21 = $data->val($i,21);
		$data22 = $data->val($i,22);
		$created_by = 'Import by Admin'; 
		$date = date('d-m-Y H:i:s'); /*date('Y-m-d H:i:s');**/
		$rand = rand();
	 
		$query = "INSERT INTO tbcustomer VALUES (null,'$data1','$data2','$data3','$data4','$data5','$data6','$data7','$data8','$data9','$data10','$data11','$data12','$data13','$data14','$data15','$data16','$data17','$data18','$data19','$data20','$data21','$data22','$created_by-$date')";
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