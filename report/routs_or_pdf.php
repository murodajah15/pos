<?php
    session_start();
		include "../timeout.php";
    if($_SESSION['login']==1){
		if(!cek_login()){
			$_SESSION['login']=0;
		}
    }
	if($_SESSION['login']==0){
	  header('location:../logout.php');
	}
	//require_once "koneksi.php";
	include "../inc/config.php";
	//require_once "koneksi.php";
	include "../inc/config.php";
	require_once("../dompdf/dompdf_config.inc.php");

	date_default_timezone_set('Asia/Jakarta');
	$who = "Update-".$_SESSION['username']."-".date('d-m-Y H:i:s');
	$tanggal1 = date('m-d-Y', strtotime($_POST['tanggal1']));
	$tanggal2 = date('m-d-Y', strtotime($_POST['tanggal2']));
	$tgl1 = date('Y-m-d', strtotime($_POST['tanggal1']));
	$tgl2 = date('Y-m-d', strtotime($_POST['tanggal1']));
	$nm_perusahaan = $_SESSION['nm_perusahaan'];
	$alamat_perusahaan = $_SESSION['alamat_perusahaan'];
	$telp_perusahaan = $_SESSION['telp_perusahaan'];
	$no=1;
	if (isset($_POST['check1'])) {
		$tanggal = 'Semua Periode';
		$query = mysqli_query($connect,"select * from wo where own_risk>0");
	}else{
		$tanggal = $tanggal1.' s/d '.$tanggal2;
		$query = mysqli_query($connect,"select * from wo where own_risk>0 and (tglwo>='$tgl1' and tglwo<='$tgl2')");
	}

	$html = '<style>
				td { border: 0.5px solid grey; margin: 5px;}
	            th { border: 0.5px solid grey; font-weight:normal;}
	            body { font-family: comic sans ms;}
			</style>
		<font size="2" face="comic sans ms">
		'."$nm_perusahaan".'
		<br>'."$alamat_perusahaan".'
		<br>'."$telp_perusahaan".'</font>
		<font size="2"><br><p><center>LAPORAN OUTSTANDING OR BODY REPAIR</p>
		<br><p><center>TANGGAL : '."$tanggal".'</p>
		<hr size=2></hr></font>


		<table table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
			<tr>
				<th width="30px" height="20"><font size="1" color="black">NO.</th>
				<th width="90px"><font size="1" color="black">NO. WO</th>
				<th width="70px"><font size="1" color="black">TANGGAL</th>
				<th width="80px"><font size="1" color="black">NO. POLISI</th>
				<th width="200px"><font size="1" color="black">NO. SPK</th>
				<th width="80px"><font size="1" color="black">OR</th>
				<th width="80px"><font size="1" color="black">BAYAR</th>
				<th width="250px"><font size="1" color="black">CUSTOMER</th>					
			</tr>';

	while ($row = mysqli_fetch_assoc($query))
	{
		$html .= '<tr>
				<td width="30px" height="35px" align="center">'.$no.'</td>
				<td width="90px" height="35px">&nbsp;'.$row["nowo"].'</td>
				<td width="70px" height="35px" align="center">'.date('d-m-Y', strtotime($row["tglwo"])).'</td>
				<td width="80px" height="35px">&nbsp;'.$row["nopolisi"].'</td>
				<td width="150px" height="35px">&nbsp;'.$row["nospk"].'</td>
				<td width="80px" height="35px" align="right">'.$row["own_risk"].'&nbsp;</td>
				<td width="80px" height="35px" align="right">'.$row["bayar"].'&nbsp;</td>
				<td width="250px" height="35px">&nbsp;'.$row["nmcust"].'</td>
			</tr>';
		$no++;
	}
	$html .= '<p><left>Tanggal cetak : '.date('d-m-Y H:i:s a').'</p>';

	$dompdf = new DOMPDF();
	$dompdf->load_html($html);
	$dompdf->set_paper('A4', 'landscape');
	$dompdf->render();
	$dompdf->stream('laporan_'.$nama.'.pdf', array('Attachment' => false));	
	//$dompdf->stream('laporan_'.$nama.'.pdf'); &&langsung download


?>