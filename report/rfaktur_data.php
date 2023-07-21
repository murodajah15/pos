<?php
session_start();
include "../inc/config.php";
date_default_timezone_set('Asia/Jakarta');
$tanggal1 = date('d-m-Y', strtotime($_POST['tanggal1']));
$tanggal2 = date('d-m-Y', strtotime($_POST['tanggal2']));
$tgl1 = date('Y-m-d', strtotime($_POST['tanggal1']));
$tgl2 = date('Y-m-d', strtotime($_POST['tanggal2']));
$nm_perusahaan = $_SESSION['nm_perusahaan'];
$alamat_perusahaan = $_SESSION['alamat_perusahaan'];
$telp_perusahaan = $_SESSION['telp_perusahaan'];
$no = 1;

$tanggal = $tanggal1 . ' s/d ' . $tanggal2;
$queryh = mysqli_query($connect, "select * from jualh where (tgljual>='$tgl1' and tgljual<='$tgl2') and proses='Y' order by tgljual");
$cek = mysqli_num_rows($queryh);
if (empty($cek)) {
	echo '<script>alert(\'Tidak ada data sesuai kriteria111\')
 window.close()</script>';
}
// echo $qry;

echo '<style>
				td { border: 0.5px solid grey; margin: 5px;}
	            th { border: 0.5px solid grey; font-weight:normal;}
	            body { font-family: comic sans ms;}
			</style>
		<font size="3" face="comic sans ms">
		' . "$nm_perusahaan" . '
		<font size="1" face="comic sans ms">
		<br>' . "$alamat_perusahaan" . '
		<br>' . "$telp_perusahaan" . '</font><br>
		<font size="2"><br>LAPORAN FAKTUR HARIAN
		<br>Tanggal : ' . "$tanggal" . '
		<br><br>' . "PENERIMAAN TUNAI" . '
		<font size="1" face="comic sans ms"><br>';
// <hr size=2></hr></font>

echo
'<table table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
			<tr>
				<th width="30px" height="20" rowspan="2"><font size="1" color="black">NO.</th>
				<th width="90px" rowspan="2"><font size="1" color="black">NO. FAKTUR</th>
				<th width="80px" rowspan="2"><font size="1" color="black">TANGGAL</th>
				<th width="260px" rowspan="2"><font size="1" color="black">NAMA CUSTOMER</th>
				<th width="90px" rowspan="2"><font size="1" color="black">NILAI<br>PIUTANG</th>
				<th colspan="5">CARA BAYAR</th>
				<th width="90px" rowspan="2"><font size="1" color="black">SALDO<br>PIUTANG</th>
				<tr><th width="90px">TUNAI</th>
				<th width="90px">TRANSFER</th>
				<th width="90px">CEK/GIRO</th>
				<th width="90px">DEBIT<br>CARD</th>
				<th width="90px">CREDIT<br>CARD</th>
			</tr>';

$gtotal = 0;
$gcash = 0;
$gtransfer = 0;
$gcek_giro = 0;
$gdebit_card = 0;
$gcredit_card = 0;
$gkurangbayar =  0;
while ($row = mysqli_fetch_assoc($queryh)) {
	$nojual = $row['nojual'];
	$tgljual = $row['tgljual'];
	$tgljual = date('d-m-Y', strtotime($tgljual));
	$nmcustomer = $row['nmcustomer'];
	$ntotal = $row['total'];
	$total = number_format($row['total'], 0, ",", ".");
	$queryd = mysqli_query($connect, "select if(carabayar='Cash',bayar,0) as cash,
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
	while ($rowd = mysqli_fetch_assoc($queryd)) {
		$ncash = $ncash + $rowd['cash'];
		$ntransfer = $ntransfer + $rowd['transfer'];
		$ncek_giro = $ncek_giro + $rowd['cek_giro'];
		$ndebit_card = $ndebit_card + $rowd['debit_card'];
		$ncredit_card = $ncredit_card + $rowd['credit_card'];
	}
	//and (tglkwitansi>='$tgl1' and tglkwitansi<='$tgl2')
	//$rowd = mysqli_fetch_assoc($queryd);
	$cash = number_format($ncash, 0, ",", ".");
	$transfer = number_format($ntransfer, 0, ",", ".");
	$cek_giro = number_format($ncek_giro, 0, ",", ".");
	$debit_card = number_format($ndebit_card, 0, ",", ".");
	$credit_card = number_format($ncredit_card, 0, ",", ".");
	$nbayar = $ncash + $ntransfer + $ncek_giro + $ndebit_card + $ncredit_card;
	$nkurangbayar = $ntotal - $nbayar;
	$kurangbayar = number_format($nkurangbayar, 0, ",", ".");
	echo '<tr>
		<td align="center">' . $no . '</td>
		<td>&nbsp;' . $nojual . '</td>
		<td>&nbsp;' . $tgljual . '</td>
		<td>&nbsp;' . $nmcustomer . '</td>
		<td align="right">' . $total . '&nbsp;</td>
		<td align="right">' . $cash . '&nbsp;</td>
		<td align="right">' . $transfer . '&nbsp;</td>
		<td align="right">' . $cek_giro . '&nbsp;</td>
		<td align="right">' . $debit_card . '&nbsp;</td>
		<td align="right">' . $credit_card . '&nbsp;</td>
		<td align="right">' . $kurangbayar . '&nbsp;</td>
		</tr>';
	$no++;
	$gtotal = $gtotal + $ntotal;
	$gcash = $gcash + $ncash;
	$gtransfer = $gtransfer + $ntransfer;
	$gcek_giro = $gcek_giro + $ncek_giro;
	$gdebit_card = $gdebit_card + $ndebit_card;
	$gcredit_card = $gcredit_card + $ncredit_card;
	$gkurangbayar =  $gkurangbayar + $nkurangbayar;
}
$gtotal = number_format($gtotal, 0, ",", ".");
$gcash = number_format($gcash, 0, ",", ".");
$gtransfer = number_format($gtransfer, 0, ",", ".");
$gcek_giro = number_format($gcek_giro, 0, ",", ".");
$gdebit_card = number_format($gdebit_card, 0, ",", ".");
$gcredit_card = number_format($gcredit_card, 0, ",", ".");
$gkurangbayar = number_format($gkurangbayar, 0, ",", ".");
echo '<tr><td colspan="4" height="10px" align="right">&nbsp;' . "Grand Total ..." . '&nbsp;</td>
		<td align="right">&nbsp;' . $gtotal . '&nbsp;</td>
		<td align="right">&nbsp;' . $gcash . '&nbsp;</td>
		<td align="right">&nbsp;' . $gtransfer . '&nbsp;</td>
		<td align="right">&nbsp;' . $gcek_giro . '&nbsp;</td>
		<td align="right">&nbsp;' . $gdebit_card . '&nbsp;</td>
		<td align="right">&nbsp;' . $gcredit_card . '&nbsp;</td>
		<td align="right">&nbsp;' . $gkurangbayar . '&nbsp;</td>
		</tr>';

echo '</table><br>PENERIMAAN TAGIHAN';
echo '<table table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
			<tr>
				<th width="30px" height="20" rowspan="2"><font size="1" color="black">NO.</th>
				<th width="90px" rowspan="2"><font size="1" color="black">NO. FAKTUR</th>
				<th width="80px" rowspan="2"><font size="1" color="black">TANGGAL</th>
				<th width="260px" rowspan="2"><font size="1" color="black">NAMA CUSTOMER</th>
				<th width="90px" rowspan="2"><font size="1" color="black">NILAI<br>PIUTANG</th>
				<th colspan="5">CARA BAYAR</th>
				<th width="90px" rowspan="2"><font size="1" color="black">SALDO<br>PIUTANG</th>
				<tr><th width="90px">TUNAI</th>
				<th width="90px">TRANSFER</th>
				<th width="90px">CEK/GIRO</th>
				<th width="90px">DEBIT<br>CARD</th>
				<th width="90px">CREDIT<br>CARD</th>
			</tr>';

$gtotal = 0;
$gcash = 0;
$gtransfer = 0;
$gcek_giro = 0;
$gdebit_card = 0;
$gcredit_card = 0;
$gkurangbayar =  0;
$querydok = mysqli_query($connect, "select kasir_tagihand.nojual from kasir_tagihan inner join kasir_tagihand on kasir_tagihand.nokwitansi=kasir_tagihan.nokwitansi where kasir_tagihan.proses='Y' 
			and (kasir_tagihan.tglkwitansi>='$tgl1' and kasir_tagihan.tglkwitansi<='$tgl2') group by kasir_tagihand.nojual");
// $querydok = mysqli_query($connect,"select nojual from kasir_tagihan where proses='Y' 
// 		and (tglkwitansi>='$tgl1' and tglkwitansi<='$tgl2') group by nojual");
while ($rowdok = mysqli_fetch_assoc($querydok)) {
	$nojual = $rowdok['nojual'];
	// $queryh = mysqli_query($connect,"select nojual,if(carabayar='Cash',bayar,0) as cash,
	// 	if(carabayar='Transfer',bayar,0) as transfer,
	// 	if(carabayar='Cek/Giro',bayar,0) as cek_giro,
	// 	if(carabayar='Debit Card',bayar,0) as debit_card,
	// 	if(carabayar='Credit Card',bayar,0) as credit_card from kasir_tagihan where proses='Y' 
	// 	and (tglkwitansi>='$tgl1' and tglkwitansi<='$tgl2') and nojual='$nojual'"); 					
	$queryh = mysqli_query($connect, "select kasir_tagihand.nojual, kasir_tagihand.bayar,jualh.tgljual,
					if(kasir_tagihan.carabayar='Cash',kasir_tagihand.bayar,0) as cash,
					if(kasir_tagihan.carabayar='Transfer',kasir_tagihand.bayar,0) as transfer,
					if(kasir_tagihan.carabayar='Cek/Giro',kasir_tagihand.bayar,0) as cek_giro,
					if(kasir_tagihan.carabayar='Debit Card',kasir_tagihand.bayar,0) as debit_card,
					if(kasir_tagihan.carabayar='Credit Card',kasir_tagihand.bayar,0) as credit_card
	 				from kasir_tagihand inner join kasir_tagihan on kasir_tagihan.nokwitansi=kasir_tagihand.nokwitansi inner join jualh on jualh.nojual=kasir_tagihand.nojual where kasir_tagihand.nojual='$nojual'");
	$ncash = 0;
	$ntransfer = 0;
	$ncek_giro = 0;
	$ndebit_card = 0;
	$ncredit_card = 0;
	$no = 1;
	while ($rowd = mysqli_fetch_assoc($queryh)) {
		$ncash = $ncash + $rowd['cash'];
		$ntransfer = $ntransfer + $rowd['transfer'];
		$ncek_giro = $ncek_giro + $rowd['cek_giro'];
		$ndebit_card = $ndebit_card + $rowd['debit_card'];
		$ncredit_card = $credit_card + $rowd['credit_card'];
	}
	$queryjual = mysqli_query($connect, "select * from jualh where proses='Y' and nojual='$nojual'");
	$de = mysqli_fetch_assoc($queryjual);
	$tgljual = $de['tgljual'];
	$tgljual = date('d-m-Y', strtotime($tgljual));
	$nmcustomer = $de['nmcustomer'];
	$ntotal = $de['total'];
	$total = number_format($ntotal, 0, ",", ".");
	$cash = number_format($ncash, 0, ",", ".");
	$transfer = number_format($ntransfer, 0, ",", ".");
	$cek_giro = number_format($ncek_giro, 0, ",", ".");
	$debit_card = number_format($ndebit_card, 0, ",", ".");
	$credit_card = number_format($ncredit_card, 0, ",", ".");
	$nbayar = $ncash + $ntransfer + $ncek_giro + $ndebit_card + $ncredit_card;
	$nkurangbayar = $ntotal - $nbayar;
	$kurangbayar = number_format($nkurangbayar, 0, ",", ".");
	echo '<tr>
		<td height="10px" align="center">' . $no . '</td>
		<td>&nbsp;' . $nojual . '</td>
		<td>&nbsp;' . $tgljual . '</td>
		<td>&nbsp;' . $nmcustomer . '</td>
		<td align="right">' . $total . '&nbsp;</td>
		<td align="right">' . $cash . '&nbsp;</td>
		<td align="right">' . $transfer . '&nbsp;</td>
		<td align="right">' . $cek_giro . '&nbsp;</td>
		<td align="right">' . $debit_card . '&nbsp;</td>
		<td align="right">' . $credit_card . '&nbsp;</td>
		<td align="right">' . $kurangbayar . '&nbsp;</td>
		</tr>';
	$no++;
	$gtotal = $gtotal + $ntotal;
	$gcash = $gcash + $ncash;
	$gtransfer = $gtransfer + $ntransfer;
	$gcek_giro = $gcek_giro + $ncek_giro;
	$gdebit_card = $gdebit_card + $ndebit_card;
	$gcredit_card = $gcredit_card + $ncredit_card;
	$gkurangbayar =  $gkurangbayar + $nkurangbayar;
}
$gtotal = number_format($gtotal, 0, ",", ".");
$gcash = number_format($gcash, 0, ",", ".");
$gtransfer = number_format($gtransfer, 0, ",", ".");
$gcek_giro = number_format($gcek_giro, 0, ",", ".");
$gdebit_card = number_format($gdebit_card, 0, ",", ".");
$gcredit_card = number_format($gcredit_card, 0, ",", ".");
$gkurangbayar = number_format($gkurangbayar, 0, ",", ".");
echo '<tr><td colspan="4" height="10px" align="right">&nbsp;' . "Grand Total ..." . '&nbsp;</td>
		<td height="10px" align="right">&nbsp;' . $gtotal . '&nbsp;</td>
		<td height="10px" align="right">&nbsp;' . $gcash . '&nbsp;</td>
		<td height="10px" align="right">&nbsp;' . $gtransfer . '&nbsp;</td>
		<td height="10px" align="right">&nbsp;' . $gcek_giro . '&nbsp;</td>
		<td height="10px" align="right">&nbsp;' . $gdebit_card . '&nbsp;</td>
		<td height="10px" align="right">&nbsp;' . $gcredit_card . '&nbsp;</td>
		<td height="10px" align="right">&nbsp;' . $gkurangbayar . '&nbsp;</td>
		</tr></table>';

echo '<font size="1"><left>Tanggal cetak : ' . date("d-m-Y H:i:s a") . '<br>';
