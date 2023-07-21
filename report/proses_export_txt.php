<?php
	include "../inc/config.php";
	$bulan = $_POST['bulan'];
	$tahun = $_POST['tahun'];
	$kdsatker = $_POST['kdsatker'];
	$kdeselon = $_POST['kdeselon'];
	//echo $_POST['bulan'].$_POST['tahun'].$_POST['kdsatker'].$_POST['kdeselon'];
	/*nama file hasil export**/
	$namaFile = "tunjangan.txt";
	/*karakter separator**/
	$separator = "\t"; //tab
	/* header file text**/
	header("Content-type: text/plain");
	header("Content-Disposition: attachment; filename=".$namaFile);

	if ($kdsatker<>"") {
		if ($kdeselon<>"") {
			$query = "select tunjanganh.nourut,tunjanganh.kdpos,tunjanganh.kdbankspan,tunjanganh.kdnegara,tunjanganh.kdkppn,tunjanganh.kdtipe_supplier,
			tunjanganh.nmkota,tunjanganh.nmprovinsi,tunjanganh.email,tunjanganh.telp,tunjanganh.kdnab,mst_pegawai.npwp,tunjangan.* from tunjanganh 
			inner join tunjangan on tunjangan.nourut=tunjanganh.nourut inner join mst_pegawai on mst_pegawai.nip=tunjangan.nip
			where tunjangan.kdsatker='$kdsatker' and tunjangan.kdeselon='$kdeselon' and tunjanganh.proses='Y' and tunjanganh.bulan='$bulan' and tunjanganh.tahun='$tahun'";
		}else{
			$query = "select tunjanganh.nourut,tunjanganh.kdpos,tunjanganh.kdbankspan,tunjanganh.kdnegara,tunjanganh.kdkppn,tunjanganh.kdtipe_supplier,
			tunjanganh.nmkota,tunjanganh.nmprovinsi,tunjanganh.email,tunjanganh.telp,tunjanganh.kdnab,mst_pegawai.npwp,tunjangan.* from tunjanganh 
			inner join tunjangan on tunjangan.nourut=tunjanganh.nourut inner join mst_pegawai on mst_pegawai.nip=tunjangan.nip
			where tunjangan.kdsatker='$kdsatker' and tunjanganh.proses='Y' and tunjanganh.bulan='$bulan' and tunjanganh.tahun='$tahun'";			
		}
	}else{
		if ($kdeselon<>"") {
			$query = "select tunjanganh.nourut,tunjanganh.kdpos,tunjanganh.kdbankspan,tunjanganh.kdnegara,tunjanganh.kdkppn,tunjanganh.kdtipe_supplier,
			tunjanganh.nmkota,tunjanganh.nmprovinsi,tunjanganh.email,tunjanganh.telp,tunjanganh.kdnab,mst_pegawai.npwp,tunjangan.* from tunjanganh 
			inner join tunjangan on tunjangan.nourut=tunjanganh.nourut inner join mst_pegawai on mst_pegawai.nip=tunjangan.nip
			where kdeselon='$kdeselon' and tunjanganh.proses='Y' and tunjanganh.bulan='$bulan' and tunjanganh.tahun='$tahun'";
		}else{
			//echo "<script>alert('est')</script>";
			$query =  mysqli_query($connect, "select tunjanganh.nourut,tunjanganh.kdpos,tunjanganh.kdbankspan,tunjanganh.kdnegara,tunjanganh.kdkppn,tunjanganh.kdtipe_supplier,
			tunjanganh.nmkota,tunjanganh.nmprovinsi,tunjanganh.email,tunjanganh.telp,tunjanganh.kdnab,mst_pegawai.npwp,tunjangan.* from tunjanganh 
			inner join tunjangan on tunjangan.nourut=tunjanganh.nourut inner join mst_pegawai on mst_pegawai.nip=tunjangan.nip 
			where tunjanganh.proses='Y' and tunjanganh.bulan='$bulan' and tunjanganh.tahun='$tahun'");

		}
	}

	/*$jumrec = mysqli_num_rows($query);
	while ($row = mysqli_fetch_assoc($query)) {
		echo $row['nip'];
	}
    echo 'jumrec'.$jumrec;
	if ($jumrec>0)**/
	
	while ($data = mysqli_fetch_assoc($query)) {
	/*mengisi data ke file text dengan separator**/
		echo $data['nama_alias'].$separator.$data['npwp'].$separator.$data['nama'].$separator.$data['bank'].
		$separator.$data['norek'].$separator.$data['netto'].$separator.$data['kdbankspan'].$separator.$data['kdpos'].
		$separator.$data['kdnegara'].$separator.$data['kdkppn'].$separator.$data['kdtipe_supplier'].
		$separator.$data['nmkota'].$separator.$data['nmprovinsi'].$separator.$data['email'].
		$separator.$data['telp'].$separator.$data['kdnab'].$separator.$data['nip']."\r\n";
	}
?>