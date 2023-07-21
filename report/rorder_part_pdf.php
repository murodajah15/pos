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

	if (isset($_POST['check2'])) {
		$tanggal = 'Outstanding s/d '.$tanggal2;
		$queryh = mysqli_query($connect,"select * from order_part where proses='Y' and terima='N' order by tglorder");
	}else{
		if (isset($_POST['check1'])) {
			$tanggal = 'Semua Periode';
			$queryh = mysqli_query($connect,"select * from order_part where proses='Y' order by tglorder");
		}else{
			$tanggal = $tanggal1.' s/d '.$tanggal2;
			$queryh = mysqli_query($connect,"select * from order_part where proses='Y' and (tglorder>='$tgl1' and tglorder<='$tgl2') order by tglorder");
		}
	}

	$html = '<style>
				td { border: 0.5px solid grey; margin: 5px;}
	            th { border: 0.5px solid grey; font-weight:normal;}
	            body { font-family: comic sans ms;}
			</style>
		<font size="2" face="comic sans ms">
		'."$nm_perusahaan".'
		<br>'."$alamat_perusahaan".'
		<br>'."$telp_perusahaan".'</font><br>
		<font size="2"><br><p><center>LAPORAN ORDER SPARE PART</p>
		<br><p><center>TANGGAL : '."$tanggal".'</p>
		<hr size=2></hr></font>

		<table table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
			<tr>
				<th width="30px" height="20"><font size="1" color="black">NO.</th>
				<th width="90px"><font size="1" color="black">KD. BARANG</th>
				<th width="200px"><font size="1" color="black">NM. BARANG</th>
				<th width="60px"><font size="1" color="black">SATUAN</th>
				<th width="50px"><font size="1" color="black">QTY</th>
				<th width="60px"><font size="1" color="black">HARGA</th>
				<th width="40px"><font size="1" color="black">DISC.</th>
				<th width="70px"><font size="1" color="black">SUBTOTAL</th>
				<th width="40px"><font size="1" color="black">PPn %</th>
				<th width="80px"><font size="1" color="black">TOTAL</th>
			</tr>';

	while ($row = mysqli_fetch_assoc($queryh))
	{
		$html .= '<tr>
			<td colspan="10" width="573px" height="35px" align="left">&nbsp;'."No. Order : ".$row["noorder"].', Tanggal : '.date('d-m-Y', strtotime($row["tglorder"])).', No. WO : '.$row["nowo"].', No. Polisi : '.$row["nopolisi"].'</td></tr>';
		$noorder = $row['noorder'];
		if (isset($_POST['check1'])) {
			$tanggal = 'Semua Periode';
			$queryd = mysqli_query($connect,"select order_part.noorder,order_part.tglorder,order_part.nowo,order_part.nopolisi,order_partd.kdbarang,order_partd.nmbarang,order_partd.satuan,order_partd.qty,order_partd.harga,order_partd.discount,order_partd.subtotal from order_part inner join order_partd on order_part.noorder=order_partd.noorder where order_part.proses='Y' and order_part.noorder='$noorder'");
		}else{
			$tanggal = $tanggal1.' s/d '.$tanggal2;
			$queryd = mysqli_query($connect,"select order_part.noorder,order_part.tglorder,order_part.nowo,order_part.nopolisi,order_partd.kdbarang,order_partd.nmbarang,order_partd.satuan,order_partd.qty,order_partd.harga,order_partd.discount,order_partd.subtotal from order_part inner join order_partd on order_part.noorder=order_partd.noorder where order_part.proses='Y' and (order_part.tglorder>='$tgl1' and order_part.tglorder<='$tgl2') and order_partd.noorder='$noorder'");
		}
		$html .= '<table table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">';
		while ($rowd = mysqli_fetch_assoc($queryd))
		{
			$subtotal_ppn = $rowd['subtotal'] - ($rowd['subtotal'] * ($row['ppn']/100));
			$html .= '<tr>
					<td width="30px" height="35px" align="center">'.$no.'</td>
					<td width="90px" height="35px">&nbsp;'.$rowd["kdbarang"].'</td>
					<td width="200px" height="35px">&nbsp;'.$rowd["nmbarang"].'</td>
					<td width="60px" height="35px">&nbsp;'.$rowd["satuan"].'</td>
					<td width="50px" height="35px" align="right">'.$rowd["qty"].'&nbsp;</td>
					<td width="60px" height="35px" align="right">'.round($rowd["harga"]).'&nbsp;</td>
					<td width="40px" height="35px" align="right">'.round($rowd["discount"]).'&nbsp;</td>
					<td width="70px" height="35px" align="right">'.round($rowd["subtotal"]).'&nbsp;</td>
					<td width="40px" height="35px" align="right">'.$row["ppn"].'&nbsp;</td>
					<td width="80px" height="35px" align="right">'.round($subtotal_ppn).'&nbsp;</td>
				</tr>';
			$no++;
		}
		$html .= '<tr><td colspan="7" height="35px" align="left">&nbsp;'."Total".'&nbsp;</td>
			<td height="35px" align="right">&nbsp;'.round($row["total"]).'&nbsp;</td>
			<td></td>
			<td height="35px" align="right">&nbsp;'.round($row["total"]).'&nbsp;</td>
		</tr>';
		
	}
	$html .= '<p><left>Tanggal cetak : '.date('d-m-Y H:i:s a').'</p>';

	$dompdf = new DOMPDF();
	$dompdf->load_html($html);
	$dompdf->set_paper('A4', 'potrait');
	$dompdf->render();
	$dompdf->stream('laporan_'.$nama.'.pdf', array('Attachment' => false));	
	//$dompdf->stream('laporan_'.$nama.'.pdf'); &&langsung download


?>