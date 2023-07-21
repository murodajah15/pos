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
	$nmkasir = $_POST['nmkasir'];

	if ($nmkasir=="") {
		if (isset($_POST['check2'])) {
			$tanggal = 'Outstanding s/d '.$tanggal2;
			$queryh = mysqli_query($connect,"select * from kasir_tunai where proses='Y' and terima='N' order by tglkwitansi");
		}else{
			if (isset($_POST['check1'])) {
				$tanggal = 'Semua Periode';
				$queryh = mysqli_query($connect,"select nokwitansi,tglkwitansi,nojual,nmcustomer,piutang,if(carabayar='Cash',bayar,0) as cash,
					if(carabayar='Transfer',bayar,0) as transfer,
					if(carabayar='Cek/Giro',bayar,0) as cek_giro,
					if(carabayar='Debit Card',bayar,0) as debit_card,
					if(carabayar='Credit Card',bayar,0) as credit_card,
					piutang-bayar as sisa_piutang from kasir_tunai where proses='Y' order by tglkwitansi");
			}else{
				$tanggal = $tanggal1.' s/d '.$tanggal2;
				$queryh = mysqli_query($connect,"select nokwitansi,tglkwitansi,nojual,nmcustomer,piutang,if(carabayar='Cash',bayar,0) as cash,
					if(carabayar='Transfer',bayar,0) as transfer,
					if(carabayar='Cek/Giro',bayar,0) as cek_giro,
					if(carabayar='Debit Card',bayar,0) as debit_card,
					if(carabayar='Credit Card',bayar,0) as credit_card,
					piutang-bayar as sisa_piutang from kasir_tunai where proses='Y' and (tglkwitansi>='$tgl1' and tglkwitansi<='$tgl2') order by tglkwitansi");
				//echo $tgl1.'  '.$tgl2;
			}
		}
	}else{
		if (isset($_POST['check2'])) {
			$tanggal = 'Outstanding s/d '.$tanggal2;
			$queryh = mysqli_query($connect,"select * from kasir_tunai where proses='Y' and terima='N' order by tglkwitansi");
		}else{
			if (isset($_POST['check1'])) {
				$tanggal = 'Semua Periode';
				$queryh = mysqli_query($connect,"select * from kasir_tunai where proses='Y' and user_input='$nmkasir' order by tglkwitansi");
			}else{
				$tanggal = $tanggal1.' s/d '.$tanggal2;
				$queryh = mysqli_query($connect,"select * from kasir_tunai where proses='Y' and user_input='$nmkasir' and (tglkwitansi>='$tgl1' and tglkwitansi<='$tgl2') order by tglkwitansi");
				//echo $tgl1.'  '.$tgl2;
			}
		}		
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
		<font size="2"><br>LAPORAN PENERIMAAN KASIR TUNAI
		<br>Tanggal : '."$tanggal".'
		<hr size=2></hr></font>

		<table table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
			<tr>
				<th width="30px" height="20" rowspan="2"><font size="1" color="black">NO.</th>
				<th width="90px" rowspan="2"><font size="1" color="black">NO. KWITANSI</th>
				<th width="65px" rowspan="2"><font size="1" color="black">TANGGAL</th>
				<th width="95px" rowspan="2"><font size="1" color="black">NO. DOKUMEN</th>
				<th width="200px" rowspan="2"><font size="1" color="black">CUSTOMER</th>
				<th width="80px" rowspan="2"><font size="1" color="black">PIUTANG</th>
				<th colspan="5">CARA BAYAR</th>
				<th width="80px" rowspan="2">SISA<br>PIUTANG</th>
				<tr><th width="70px">TUNAI</th>
				<th width="70px">TRANSFER</th>
				<th width="70px">CEK/GIRO</th>
				<th width="70px">DEBIT<br>CARD</th>
				<th width="70px">CREDIT<br>CARD</th>
			</tr>';
	$totalcash = 0;
	$totaltransfer = 0;
	$totalcek_giro = 0;
	$totaldebit_card = 0;
	$totalcredit_card = 0;
	$totalsisa_piutang = 0;
	$totalpiutang = 0;
	while ($row = mysqli_fetch_assoc($queryh))	{
		//$subtotal_ppn = $rowd['subtotal'] - ($rowd['subtotal'] * ($row['ppn']/100));
		$piutang = number_format($row['piutang'],0,",",".");
		$cash = number_format($row['cash'],0,",",".");
		$transfer = number_format($row['transfer'],0,",",".");
		$cek_giro = number_format($row['cek_giro'],0,",",".");
		$debit_card = number_format($row['debit_card'],0,",",".");
		$credit_card = number_format($row['credit_card'],0,",",".");
		$sisa_piutang = number_format($row['sisa_piutang'],0,",",".");
		$tglkwitansi = date('d-m-Y', strtotime($row['tglkwitansi']));
		$html .= '<tr>
				<td width="30px"  align="center">'.$no.'</td>
				<td >&nbsp;'.$row["nokwitansi"].'</td>
				<td >&nbsp;'.$tglkwitansi.'</td>
				<td >&nbsp;'.$row["nojual"].'</td>
				<td >&nbsp;'.$row["nmcustomer"].'</td>
				<td  align="right">&nbsp;'.$piutang.'&nbsp;</td>
				<td  align="right">&nbsp;'.$cash.'&nbsp;</td>
				<td  align="right">&nbsp;'.$transfer.'&nbsp;</td>
				<td  align="right">&nbsp;'.$cek_giro.'&nbsp;</td>
				<td  align="right">&nbsp;'.$debit_card.'&nbsp;</td>
				<td  align="right">&nbsp;'.$credit_card.'&nbsp;</td>
				<td  align="right">&nbsp;'.$sisa_piutang.'&nbsp;</td>
			</tr>';
		$no++;
		$totalcash = $totalcash + $row["cash"];
		$totaltransfer = $totaltransfer + $row["transfer"];
		$totalcek_giro = $totalcek_giro + $row["cek_giro"];
		$totaldebit_card = $totaldebit_card + $row["debit_card"];
		$totalcredit_card = $totalcredit_card + $row["credit_card"];
		$totalsisa_piutang = $totalsisa_piutang + $row["sisa_piutang"];
		$totalpiutang = $totalpiutang + $row["piutang"];
	}
	$totalpiutang = number_format($totalpiutang,0,",",".");
	$totalcash = number_format($totalcash,0,",",".");
	$totaltransfer = number_format($totaltransfer,0,",",".");
	$totalcek_giro = number_format($totalcek_giro,0,",",".");
	$totaldebit_card = number_format($totaldebit_card,0,",",".");
	$totalcredit_card = number_format($totalcredit_card,0,",",".");
	$totalsisa_piutang = number_format($totalsisa_piutang,0,",",".");
	$html .= '<tr><td colspan="5" height="20px" align="left">&nbsp;'."Total".'&nbsp;</td>
		<td height="20px" align="right">&nbsp;'.$totalpiutang.'&nbsp;</td>
		<td height="20px" align="right">&nbsp;'.$totalcash.'&nbsp;</td>
		<td height="20px" align="right">&nbsp;'.$totaltransfer.'&nbsp;</td>
		<td height="20px" align="right">&nbsp;'.$totalcek_giro.'&nbsp;</td>
		<td height="20px" align="right">&nbsp;'.$totaldebit_card.'&nbsp;</td>
		<td height="20px" align="right">&nbsp;'.$totalcredit_card.'&nbsp;</td>
		<td height="20px" align="right">&nbsp;'.$totalsisa_piutang.'&nbsp;</td>
	</tr>';
	$html .= '</table><font size="1"><left>Tanggal cetak : '.date('d-m-Y H:i:s a');

	$dompdf = new DOMPDF();
	$dompdf->load_html($html);
	$dompdf->set_paper('A4', 'landscape');
	$dompdf->render();
	$dompdf->stream('laporan_'.$nama.'.pdf', array('Attachment' => false));	
	//$dompdf->stream('laporan_'.$nama.'.pdf'); &&langsung download
?>