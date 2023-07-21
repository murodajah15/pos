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
	$tanggal1 = date('d-m-Y', strtotime($_POST['tanggal1']));
	$tanggal2 = date('d-m-Y', strtotime($_POST['tanggal2']));
	$tgl1 = date('Y-m-d', strtotime($_POST['tanggal1']));
	$tgl2 = date('Y-m-d', strtotime($_POST['tanggal2']));
	$nm_perusahaan = $_SESSION['nm_perusahaan'];
	$alamat_perusahaan = $_SESSION['alamat_perusahaan'];
	$telp_perusahaan = $_SESSION['telp_perusahaan'];
	$no=1;

	$tanggal = $tanggal1.' s/d '.$tanggal2;
	$queryh = mysqli_query($connect,"select * from jualh where proses='Y' and (tgljual>='$tgl1' and tgljual<='$tgl2') order by tgljual");

	$html = '<style>
				td { border: 0.5px solid grey; margin: 5px;}
	            th { border: 0.5px solid grey; font-weight:normal;}
	            body { font-family: comic sans ms;}
			</style>
		<font size="1" face="comic sans ms">
		'."$nm_perusahaan".'
		<br>'."$alamat_perusahaan".'
		<br>'."$telp_perusahaan".'</font><br>
		<font size="2"><br>LAPORAN FAKTUR HARIAN
		<br>Tanggal : '."$tanggal".'
		<br><font size="1"><br>PENERIMAAN TUNAI

		<table table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
			<tr>
				<th width="30px" height="20" rowspan="2"><font size="1" color="black">NO.</th>
				<th width="95px" rowspan="2"><font size="1" color="black">NO. FAKTUR</th>
				<th width="60px" rowspan="2"><font size="1" color="black">TANGGAL</th>
				<th width="200px" rowspan="2"><font size="1" color="black">NAMA CUSTOMER</th>
				<th width="80px" rowspan="2"><font size="1" color="black">NILAI<br>PIUTANG</th>
				<th colspan="5">CARA BAYAR</th>
				<th width="80px" rowspan="2"><font size="1" color="black">SALDO<br>PIUTANG</th>
				<tr><th width="70px">TUNAI</th>
				<th width="70px">TRANSFER</th>
				<th width="70px">CEK/GIRO</th>
				<th width="70px">DEBIT<br>CARD</th>
				<th width="70px">CREDIT<br>CARD</th>
			</tr>';
	while ($row = mysqli_fetch_assoc($queryh))	{
		$nojual = $row['nojual'];
		$tgljual = $row['tgljual'];
		$nmcustomer = $row['nmcustomer'];
		$ntotal = $row['total'];
		$total = number_format($row['total'],0,",",".");
		$queryd = mysqli_query($connect,"select if(carabayar='Cash',bayar,0) as cash,
			if(carabayar='Transfer',bayar,0) as transfer,
			if(carabayar='Cek/Giro',bayar,0) as cek_giro,
			if(carabayar='Debit Card',bayar,0) as debit_card,
			if(carabayar='Credit Card',bayar,0) as credit_card from kasir_tunai where proses='Y' and nojual='$nojual' 
			and (tglkwitansi>='$tgl1' and tglkwitansi<='$tgl2')"); 
		$ncash = 0;
		$ntransfer = 0;
		$ncek_giro = 0;
		$ndebit_card = 0;
		$ncredit_card = 0;
		while ($rowd = mysqli_fetch_assoc($queryd))	{
			$ncash = $ncash + $rowd['cash'];
			$ntransfer = $ntransfer + $rowd['transfer'];
			$ncek_giro = $ncek_giro + $rowd['cek_giro'];
			$ndebit_card = $ndebit_card + $rowd['debit_card'];
			$ncredit_card = $ncredit_card + $rowd['credit_card'];
		}
			//and (tglkwitansi>='$tgl1' and tglkwitansi<='$tgl2')
		//$rowd = mysqli_fetch_assoc($queryd);
		$cash = number_format($ncash,0,",",".");
		$transfer = number_format($ntransfer,0,",",".");
		$cek_giro = number_format($ncek_giro,0,",",".");
		$debit_card = number_format($ndebit_card,0,",",".");
		$credit_card = number_format($ncredit_card,0,",",".");
		$nbayar = $ncash+$ntransfer+$ncek_giro+$ndebit_card+$ncredit_card;
		$kurangbayar = $ntotal - $nbayar;
		$kurangbayar = number_format($kurangbayar,0,",",".");
		$html .= '<tr>
		<td  align="center">'.$no.'</td>
		<td >&nbsp;'.$nojual.'</td>
		<td >&nbsp;'.$tgljual.'</td>
		<td >&nbsp;'.$nmcustomer.'</td>
		<td  align="right">'.$total.'&nbsp;</td>
		<td  align="right">'.$cash.'&nbsp;</td>
		<td  align="right">'.$transfer.'&nbsp;</td>
		<td  align="right">'.$cek_giro.'&nbsp;</td>
		<td  align="right">'.$debit_card.'&nbsp;</td>
		<td  align="right">'.$credit_card.'&nbsp;</td>
		<td  align="right">'.$kurangbayar.'&nbsp;</td>
		</tr>';
		$no++;
	}
	// $html .= '<tr><td colspan="5" height="20px" align="left">&nbsp;'."Grand Total".'&nbsp;</td>
	// 	<td height="20px" align="right">&nbsp;'.$grandjual.'&nbsp;</td>
	// 	<td height="20px" align="right">&nbsp;'.$granddiscount.'&nbsp;</td>
	// 	<td height="20px" align="right">&nbsp;'.$grandppn.'&nbsp;</td>
	// 	<td height="20px" align="right">&nbsp;'.$grandtotal.'&nbsp;</td>
	// 	</tr>';	
	$html .= '<br><font size="1"><br>PENERIMAAN TAGIHAN';
	$html .= '<table table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
			<tr>
				<th width="30px" height="20" rowspan="2"><font size="1" color="black">NO.</th>
				<th width="95px" rowspan="2"><font size="1" color="black">NO. FAKTUR</th>
				<th width="60px" rowspan="2"><font size="1" color="black">TANGGAL</th>
				<th width="200px" rowspan="2"><font size="1" color="black">NAMA CUSTOMER</th>
				<th width="80px" rowspan="2"><font size="1" color="black">NILAI<br>PIUTANG</th>
				<th colspan="5">CARA BAYAR</th>
				<th width="80px" rowspan="2"><font size="1" color="black">SALDO<br>PIUTANG</th>
				<tr><th width="70px">TUNAI</th>
				<th width="70px">TRANSFER</th>
				<th width="70px">CEK/GIRO</th>
				<th width="70px">DEBIT<br>CARD</th>
				<th width="70px">CREDIT<br>CARD</th>
			</tr>';

	$querydok = mysqli_query($connect,"select nojual from kasir_tagihan where proses='Y' 
			and (tglkwitansi>='$tgl1' and tglkwitansi<='$tgl2') group by nojual");
	while ($rowdok = mysqli_fetch_assoc($querydok))	{
		$nojual = $rowdok['nojual'];
		$queryh = mysqli_query($connect,"select nojual,if(carabayar='Cash',bayar,0) as cash,
			if(carabayar='Transfer',bayar,0) as transfer,
			if(carabayar='Cek/Giro',bayar,0) as cek_giro,
			if(carabayar='Debit Card',bayar,0) as debit_card,
			if(carabayar='Credit Card',bayar,0) as credit_card from kasir_tagihan where proses='Y' 
			and (tglkwitansi>='$tgl1' and tglkwitansi<='$tgl2') and nojual='$nojual'"); 					
		$ncash = 0;
		$ntransfer = 0;
		$ncek_giro = 0;
		$ndebit_card =0;
		$ncredit_card = 0;
		while ($rowd = mysqli_fetch_assoc($queryh))	{
			$ncash = $ncash + $rowd['cash'];
			$ntransfer = $ntransfer + $rowd['transfer'];
			$ncek_giro = $ncek_giro + $rowd['cek_giro'];
			$ndebit_card = $ndebit_card + $rowd['debit_card'];
			$ncredit_card = $credit_card + $rowd['credit_card'];
		}
		$queryjual = mysqli_query($connect,"select * from jualh where proses='Y' and nojual='$nojual'");	
		$de = mysqli_fetch_assoc($queryjual);
		$tgljual = $de['tgljual'];
		$nmcustomer = $de['nmcustomer'];
		$ntotal = $de['total'];
		$total = number_format($ntotal,0,",",".");
		$cash = number_format($ncash,0,",",".");
		$transfer = number_format($ntransfer,0,",",".");
		$cek_giro = number_format($ncek_giro,0,",",".");
		$debit_card = number_format($ndebit_card,0,",",".");
		$credit_card = number_format($ncredit_card,0,",",".");		
		$nbayar = $ncash+$ntransfer+$ncek_giro+$ndebit_card+$ncredit_card;
		$kurangbayar = $ntotal - $nbayar;
		$kurangbayar = number_format($kurangbayar,0,",",".");
		$html .= '<tr>
		<td height="20px" align="center">'.$no.'</td>
		<td height="20px">&nbsp;'.$nojual.'</td>
		<td height="20px">&nbsp;'.$tgljual.'</td>
		<td height="20px">&nbsp;'.$nmcustomer.'</td>
		<td height="20px" align="right">'.$total.'&nbsp;</td>
		<td height="20px" align="right">'.$cash.'&nbsp;</td>
		<td height="20px" align="right">'.$transfer.'&nbsp;</td>
		<td height="20px" align="right">'.$cek_giro.'&nbsp;</td>
		<td height="20px" align="right">'.$debit_card.'&nbsp;</td>
		<td height="20px" align="right">'.$credit_card.'&nbsp;</td>
		<td height="20px" align="right">'.$kurangbayar.'&nbsp;</td>
		</tr>';		
		$no++;
	}

	// $queryh = mysqli_query($connect,"select nojual,if(carabayar='Cash',bayar,0) as cash,
	// 		if(carabayar='Transfer',bayar,0) as transfer,
	// 		if(carabayar='Cek/Giro',bayar,0) as cek_giro,
	// 		if(carabayar='Debit Card',bayar,0) as debit_card,
	// 		if(carabayar='Credit Card',bayar,0) as credit_card from kasir_tagihan where proses='Y' 
	// 		and (tglkwitansi>='$tgl1' and tglkwitansi<='$tgl2')"); 			
	// while ($rowd = mysqli_fetch_assoc($queryh))	{
	// 	$nojual = $rowd['nojual'];
	// 	$ncash = $rowd['cash'];
	// 	$ntransfer = $rowd['transfer'];
	// 	$ncek_giro = $rowd['cek_giro'];
	// 	$ndebit_card = $rowd['debit_card'];
	// 	$ncredit_card = $rowd['credit_card'];
	// 	$queryjual = mysqli_query($connect,"select * from jualh where proses='Y' and nojual='$nojual'");	
	// 	$de = mysqli_fetch_assoc($queryjual);
	// 	$tgljual = $de['tgljual'];
	// 	$nmcustomer = $de['nmcustomer'];

	// 	//Hitunga saldo piutang dulu
	// 	$query_tunai = mysqli_query($connect,"select sum(bayar) as bayar from kasir_tunai where proses='Y' and nojual='$nojual' group by nojual");
	// 	$dbayar = mysqli_fetch_assoc($query_tunai);
	// 	$sudah_bayar = $dbayar['bayar'];

	// 	$ntotal = $de['total'] - $sudah_bayar; 
	// 	$total = number_format($ntotal,0,",",".");
	// 	$cash = number_format($ncash,0,",",".");
	// 	$transfer = number_format($ntransfer,0,",",".");
	// 	$cek_giro = number_format($ncek_giro,0,",",".");
	// 	$debit_card = number_format($ndebit_card,0,",",".");
	// 	$credit_card = number_format($ncredit_card,0,",",".");
	// 	$nbayar = $ncash+$ntransfer+$ncek_giro+$ndebit_card+$ncredit_card;
	// 	$kurangbayar = $ntotal - $nbayar;
	// 	$kurangbayar = number_format($kurangbayar,0,",",".");
	// 	$html .= '<tr>
	// 	<td height="20px" align="center">'.$no.'</td>
	// 	<td height="20px">&nbsp;'.$nojual.'</td>
	// 	<td height="20px">&nbsp;'.$tgljual.'</td>
	// 	<td height="20px">&nbsp;'.$nmcustomer.'</td>
	// 	<td height="20px" align="right">'.$total.'&nbsp;</td>
	// 	<td height="20px" align="right">'.$cash.'&nbsp;</td>
	// 	<td height="20px" align="right">'.$transfer.'&nbsp;</td>
	// 	<td height="20px" align="right">'.$cek_giro.'&nbsp;</td>
	// 	<td height="20px" align="right">'.$debit_card.'&nbsp;</td>
	// 	<td height="20px" align="right">'.$credit_card.'&nbsp;</td>
	// 	<td height="20px" align="right">'.$kurangbayar.'&nbsp;</td>
	// 	</tr>';
	// 	$no++;
	// }	
	$html .= '</table><font size="1"><left>Tanggal cetak : '.date('d-m-Y H:i:s a');

	$dompdf = new DOMPDF();
	$dompdf->load_html($html);
	$dompdf->set_paper('A4', 'landscape');
	$dompdf->render();
	$dompdf->stream('laporan_'.$nama.'.pdf', array('Attachment' => false));	
	//$dompdf->stream('laporan_'.$nama.'.pdf'); &&langsung download
?>