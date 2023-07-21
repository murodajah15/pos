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
	$nm_perusahaan = $_SESSION['nm_perusahaan'];
	$alamat_perusahaan = $_SESSION['alamat_perusahaan'];
	$telp_perusahaan = $_SESSION['telp_perusahaan'];
	$no=1;
	$noopname = $_POST['noopname'];

	if ($noopname=="") {
		$queryh = mysqli_query($connect,"select * from opnameh");
	}else{
		$queryh = mysqli_query($connect,"select * from opnameh where noopname='$noopname'");
	}

	$html = '<style>
				td { border: 0.5px solid grey; margin: 5px;}
	            th { border: 0.5px solid grey; font-weight:normal;}
	            body { font-family: comic sans ms;}
			</style>
		<font size="1" face="comic sans ms">
		'."$nm_perusahaan".'
		<br>'."$alamat_perusahaan".'
		<br>'."$telp_perusahaan".'</font><br>
		<font size="2"><br>LAPORAN STOCK OPNAME
		<hr size=2></hr></font>

		<table table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
			<tr>
				<th width="30px" height="20"><font size="1" color="black">NO.</th>
				<th width="90px"><font size="1" color="black">KODE BARANG</th>
				<th width="150px"><font size="1" color="black">NAMA BARANG</th>
				<th width="95px"><font size="1" color="black">LOKASI</th>
				<th width="80px"><font size="1" color="black">QTY</th>
			</tr>';
	while ($row = mysqli_fetch_assoc($queryh))	{
		$jumqty=0;
		$noopname = $row['noopname'];
		$tglopname = date('d-m-Y', strtotime($row['tglopname']));
		$pelaksana = strip_tags($row['pelaksana']);
		$keterangan = strip_tags($row['keterangan']);
		$html .= '<tr><td width="30px" height="20px" align="left" colspan="5">&nbsp;'.$noopname.', '.$tglopname.', '.$pelaksana.', '.$keterangan.'</td></tr>';
		$queryd = mysqli_query($connect,"select * from opnamed where noopname='$noopname'");
		while ($rowd = mysqli_fetch_assoc($queryd))	{
			$qty = number_format($rowd["qty"],0,",",".");
			$jumqty = $jumqty + $rowd["qty"];
			$html .= '<tr>
				<td width="30px"  align="center">'.$no.'</td>
				<td >&nbsp;'.$rowd["kdbarang"].'</td>
				<td >&nbsp;'.$rowd["nmbarang"].'</td>
				<td >&nbsp;'.$rowd["lokasi"].'</td>
				<td  align="right">&nbsp;'.$qty.'&nbsp;</td>
				</tr>';
			$no++;
		}
		$jumqty = number_format($jumqty,0,",",".");
		$html .= '<tr>
			<td width="30px" height="20px" colspan="4">'.'Total'.'</td>
			<td width="30px" height="20px" align="right">'.$jumqty.'&nbsp;</td></tr>';
	}

	$html .= '</table><font size="1"><left>Tanggal cetak : '.date('d-m-Y H:i:s a');

	$dompdf = new DOMPDF();
	$dompdf->load_html($html);
	$dompdf->set_paper('A4', 'landscape');
	$dompdf->render();
	$dompdf->stream('laporan_'.$nama.'.pdf', array('Attachment' => false));	
	//$dompdf->stream('laporan_'.$nama.'.pdf'); &&langsung download
?>