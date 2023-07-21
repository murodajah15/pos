<?php
include "../../excel_reader2.php";
include "../../inc/config.php";
date_default_timezone_set('Asia/Jakarta');

// file yang tadinya di upload, di simpan di temporary file PHP, file tersebut yang kita ambil
// dan baca dengan PHP Excel Class
if ($_FILES['fileexcel']['name'] <> "") {
	$query = "delete from mst_pegawai";
	$hasil = mysqli_query($connect,$query);
	
	$data = new Spreadsheet_Excel_Reader($_FILES['fileexcel']['tmp_name']);
	$hasildata = $data->rowcount($sheet_index=0);
	// default nilai 
	$sukses = 0;
	$gagal = 0;

	//nip,nama_alias,npwp,status,kdgrade,nmgrade,golongan,pangkat,jabatan,norek,nama,kdbank,bank
	// for ($i=2; $i<=$hasildata; $i++) {
		// $data1 = $data->val($i,1);
		// $data2 = $data->val($i,2);
		// $data3 = $data->val($i,3);
		// $data4 = $data->val($i,4);
		// $data5 = $data->val($i,5);
		// $data6 = $data->val($i,6);
		// $data7 = $data->val($i,7);
		// $data8 = $data->val($i,8);
		// $data9 = $data->val($i,9);
		// $data10 = $data->val($i,10);
		// $data11 = $data->val($i,11);
		// $data12 = $data->val($i,12);
		// $data13 = $data->val($i,13);
		// $created_by = 'Import by Admin'; 
		// $date = date('d-m-Y H:i:s'); /*date('Y-m-d H:i:s');**/
		// $rand = rand();
		
		// $query = "INSERT INTO mst_pegawai VALUES (null,'$data1','$data2','$data3','$data4','$data5','$data6',
		// '$data7','$data8','$data9','$data10','$data11','$data12','$data13','Y','$created_by-$date')";
		// $hasil = mysqli_query($connect,$query);
		// if ($hasil) $sukses++;
		// else $gagal++;
	// }
	
	//nip,nama_alias,npwp,status,kdgrade,nmgrade,golongan,pangkat,jabatan,norek,nama,kdbank,bank
	for ($i=2; $i<=$hasildata; $i++) {
		$data1 = $data->val($i,1); //
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
		
		$created_by = 'Import by Admin'; 
		$date = date('d-m-Y H:i:s'); /*date('Y-m-d H:i:s');**/
		$rand = rand();
		$aktif = 'Y';
		$user = "Import by Admin"."-".date('d-m-Y H:i:s');
		$user_input = $_POST['kdeselon'].$_POST['kdsatker'];
		// $query = "INSERT INTO mst_pegawai (nip,nama_alias,npwp,norek,bank,nama,aktif,user) VALUES 
		// ('$data2','$data1','$data2','$data5','$data4','$data3','Y','$created_by-$date')";
		// $hasil = mysqli_query($connect,$query);
		// if ($hasil) $sukses++;

		// $query = $connect->prepare("INSERT INTO mst_pegawai (nip,nama_alias,npwp,norek,kdbank,bank,aktif,user,user_input) values (?,?,?,?,?,?,?,?,?)");
		// $query->bind_param('sssssssss',$data2,$data1,$data2,$data5,$data4,$data3,$aktif,$user,$user_input);

		$query = $connect->prepare("INSERT INTO mst_pegawai (nip,nama_alias,npwp,status,golongan,pangkat,divisi,
		kdeselon,nmeselon,kdsatker,nmsatker,kelas_jabatan,jabatan,tukin,norek,nama,kdbank,bank,aktif,user,user_input,pr_pot_pajak) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
		$query->bind_param('sssssssssssssisssssssi',$data1,$data2,$data3,$data4,$data5,$data6,$data7,$data8,$data9,$data10,$data11,$data12,$data13,$data14,$data15,$data16,$data17,$data18,
		$aktif,$user,$user_input,$data19);
		
		if ($query->execute()) $sukses++;		
		else $gagal++;
	}

    	/*Masukan nilai prosentase pajak**/
    	$tampil = mysqli_query($connect,"select nip,golongan from mst_pegawai");
    	while($k=mysqli_fetch_assoc($tampil)){
    	    $golongan = $k['golongan'];
        	$kdgol=explode('/',$golongan,2);
        	//echo $kdgol[0];
        	if ($kdgol[0]=='IV') {
        		$pr_pot_pajak = 15;
        	}elseif ($kdgol[0]=='III') { 
        		$pr_pot_pajak = 5;
        	}else{
        		$pr_pot_pajak = 0;
        	}
        	$querypajak = mysqli_query($connect,"update mst_pegawai set pr_pot_pajak='$pr_pot_pajak' where nip='$k[nip]'");
    	}
    	
	echo "<script>alert('$sukses Data yang berhasil di import, $gagal Data yang gagal di import');history.go(-2);</script>";
	// echo $_FILES['fileexcel']['name'];
	// echo "<br><b>import data selesai.</b><br>";
	// echo $sukses." Data yang berhasil di import<br>";
	// echo $gagal." Data yang gagal diimport<br>";
	// echo "<input button type='Button' class='btn btn-danger' value='Back' onClick='history.back()'/>";
}else{
	echo "<b>Import data gagal.</b><br>";
	echo "<input button type='Button' class='btn btn-danger' value='Back' onClick='history.back()'/>";
}
?>