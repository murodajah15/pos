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
	$kdcustomer = $_POST['kdcustomer'];
	$no=1;

	if ($_POST['harbul']=="Harian") {
		if (isset($_POST['semuacustomer'])) { //semua customer
			if (isset($_POST['check1'])) {
				$tanggal = 'Semua Periode';
				if (isset($_POST['belumlunas'])) {
					$queryh = mysqli_query($connect,"select nojual,tgljual,nojual,nmcustomer,noinvoice,tglinvoice,carabayar,total,sudahbayar,kurangbayar from jualh where proses='Y' and kurangbayar>0 order by tgljual");
				}else{
					$queryh = mysqli_query($connect,"select nojual,tgljual,nojual,nmcustomer,noinvoice,tglinvoice,carabayar,total,sudahbayar,kurangbayar from jualh where proses='Y' order by tgljual");
				}
			}else{
				$tanggal = $tanggal1.' s/d '.$tanggal2;
				if (isset($_POST['belumlunas'])) {
					$queryh = mysqli_query($connect,"select nojual,tgljual,nojual,nmcustomer,noinvoice,tglinvoice,carabayar,total,sudahbayar,kurangbayar from jualh  where proses='Y' and (tgljual>='$tgl1' and tgljual<='$tgl2') and kurangbayar>0  order by tgljual");
				}else{
					$queryh = mysqli_query($connect,"select nojual,tgljual,nojual,nmcustomer,noinvoice,tglinvoice,carabayar,total,sudahbayar,kurangbayar from jualh  where proses='Y' and (tgljual>='$tgl1' and tgljual<='$tgl2') order by tgljual");
				}
				//echo $tgl1.'  '.$tgl2;
			}
		}else{
			if (isset($_POST['check1'])) {
				$tanggal = 'Semua Periode';
				if (isset($_POST['belumlunas'])) {
					$queryh = mysqli_query($connect,"select nojual,tgljual,nojual,nmcustomer,noinvoice,tglinvoice,carabayar,total,sudahbayar,kurangbayar from jualh where proses='Y' and kurangbayar>0 and kdcustomer='$kdcustomer' order by tgljual");
				}else{
					$queryh = mysqli_query($connect,"select nojual,tgljual,nojual,nmcustomer,noinvoice,tglinvoice,carabayar,total,sudahbayar,kurangbayar from jualh where proses='Y' and kdcustomer='$kdcustomer' order by tgljual");
				}
			}else{
				$tanggal = $tanggal1.' s/d '.$tanggal2;
				if (isset($_POST['belumlunas'])) {				
					$queryh = mysqli_query($connect,"select nojual,tgljual,nojual,nmcustomer,noinvoice,tglinvoice,carabayar,total,sudahbayar,kurangbayar from jualh  where proses='Y' and (tgljual>='$tgl1' and tgljual<='$tgl2') and kurangbayar>0 and kdcustomer='$kdcustomer' order by tgljual");
				}else{
					$queryh = mysqli_query($connect,"select nojual,tgljual,nojual,nmcustomer,noinvoice,tglinvoice,carabayar,total,sudahbayar,kurangbayar from jualh  where proses='Y' and (tgljual>='$tgl1' and tgljual<='$tgl2') and kurangbayar>0 and kdcustomer='$kdcustomer' and kurangbayar>0 order by tgljual");					
				}
				//echo $tgl1.'  '.$tgl2;
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
			<font size="2"><br>LAPORAN HARIAN PIUTANG
			<br>Tanggal : '."$tanggal".'
			<hr size=2></hr></font>

			<table table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
				<tr>
					<th width="30px" height="20"><font size="1" color="black">NO.</th>
					<th width="90px"><font size="1" color="black">NO. JUAL</th>
					<th width="65px"><font size="1" color="black">TGL. JUAL</th>
					<th width="95px"><font size="1" color="black">NO. INVOICE</th>
					<th width="65px"><font size="1" color="black">TGL. INVOICE</th>
					<th width="200px"><font size="1" color="black">CUSTOMER</th>
					<th width="90px"><font size="1" color="black">CARA BAYAR</th>
					<th width="80px"><font size="1" color="black">PIUTANG</th>
					<th width="80px"><font size="1" color="black">BAYAR</th>
					<th width="80px"><font size="1" color="black">SISA</th>
				</tr>';
		$totalpiutang = 0;
		$totalsisa_piutang = 0;
		$totalbayar = 0;
		while ($row = mysqli_fetch_assoc($queryh))	{
			//$subtotal_ppn = $rowd['subtotal'] - ($rowd['subtotal'] * ($row['ppn']/100));
			$piutang = number_format($row['total'],0,",",".");
			$sudahbayar = number_format($row['sudahbayar'],0,",",".");
			$kurangbayar = number_format($row['kurangbayar'],0,",",".");
			$tgljual = date('d-m-Y', strtotime($row['tgljual']));
			$tglinvoice = date('d-m-Y', strtotime($row['tglinvoice']));
			$html .= '<tr>
					<td width="30px"  align="center">'.$no.'</td>
					<td>&nbsp;'.$row["nojual"].'</td>
					<td>&nbsp;'.$tgljual.'</td>
					<td>&nbsp;'.$row["noinvoice"].'</td>
					<td>&nbsp;'.$tglinvoice.'</td>
					<td>&nbsp;'.$row["nmcustomer"].'</td>
					<td>&nbsp;'.$row["carabayar"].'</td>
					<td align="right">&nbsp;'.$piutang.'&nbsp;</td>
					<td align="right">&nbsp;'.$sudahbayar.'&nbsp;</td>
					<td align="right">&nbsp;'.$kurangbayar.'&nbsp;</td>
				</tr>';
			$no++;
			$totalsisa_piutang = $totalsisa_piutang + $row["kurangbayar"];
			$totalpiutang = $totalpiutang + $row["total"];
			$totalbayar = $totalbayar + $row["sudahbayar"];
		}
		$totalpiutang = number_format($totalpiutang,0,",",".");
		$totalsisa_piutang = number_format($totalsisa_piutang,0,",",".");
		$totalbayar = number_format($totalbayar,0,",",".");
		$html .= '<tr><td colspan="7"  align="left">&nbsp;'."Total".'&nbsp;</td>
			<td  align="right">&nbsp;'.$totalpiutang.'&nbsp;</td>
			<td  align="right">&nbsp;'.$totalbayar.'&nbsp;</td>
			<td  align="right">&nbsp;'.$totalsisa_piutang.'&nbsp;</td>
		</tr>';
		$html .= '</table><font size="1"><left>Tanggal cetak : '.date('d-m-Y H:i:s a');
	
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		$dompdf->set_paper('A4', 'landscape');
		$dompdf->render();
		$dompdf->stream('laporan_'.$nama.'.pdf', array('Attachment' => false));	
		//$dompdf->stream('laporan_'.$nama.'.pdf'); &&langsung download
	}else{ //Bulanan
		if (isset($_POST['semuacustomer'])) { //semua customer
			if (isset($_POST['check1'])) {
				$tanggal = 'Semua Periode';
				if (isset($_POST['belumlunas'])) {
					$queryh = mysqli_query($connect,"select * from jualh where proses='Y' group by tgljual order by tgljual and kurangbayar>0");
				}else{
					$queryh = mysqli_query($connect,"select * from jualh where proses='Y' group by tgljual order by tgljual");
				}
			}else{
				$tanggal = $tanggal1.' s/d '.$tanggal2;
				if (isset($_POST['belumlunas'])) {
					$queryh = mysqli_query($connect,"select * from jualh where proses='Y' and (tgljual>='$tgl1' and tgljual<='$tgl2') group by tgljual order by tgljual");
				}else{
					$queryh = mysqli_query($connect,"select * from jualh where proses='Y' and (tgljual>='$tgl1' and tgljual<='$tgl2') and kurangbayar>0 group by tgljual order by tgljual");					
				}
				//echo $tgl1.'  '.$tgl2;
			}
		}else{
			if (isset($_POST['check1'])) {
				$tanggal = 'Semua Periode';
				if (isset($_POST['belumlunas'])) {
					$queryh = mysqli_query($connect,"select * from jualh where proses='Y' and kdcustomer='$kdcustomer' group by tgljual order by tgljual and kurangbayar>0");
				}else{
					$queryh = mysqli_query($connect,"select * from jualh where proses='Y' and kdcustomer='$kdcustomer' group by tgljual order by tgljual");
				}
			}else{
				$tanggal = $tanggal1.' s/d '.$tanggal2;
				if (isset($_POST['belumlunas'])) {
					$queryh = mysqli_query($connect,"select * from jualh where proses='Y' and (tgljual>='$tgl1' and tgljual<='$tgl2') and kdcustomer='$kdcustomer' group by tgljual order by tgljual");
				}else{
					$queryh = mysqli_query($connect,"select * from jualh where proses='Y' and (tgljual>='$tgl1' and tgljual<='$tgl2') and kdcustomer='$kdcustomer' group by tgljual order by tgljual and kurangbayar>0");					
				}
				//echo $tgl1.'  '.$tgl2;
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
			<font size="2"><br>LAPORAN BULANAN PIUTANG
			<br>Tanggal : '."$tanggal".'
			<hr size=2></hr></font>

			<table table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
				<tr>
					<th width="30px" height="20"><font size="1" color="black">NO.</th>
					<th width="65px"><font size="1" color="black">TGL. JUAL</th>
					<th width="80px"><font size="1" color="black">PIUTANG</th>
					<th width="80px"><font size="1" color="black">BAYAR</th>
					<th width="80px"><font size="1" color="black">SISA</th>
				</tr>';
		$totalpiutang = 0;
		$totalsisa_piutang = 0;
		$totalbayar = 0;
		while ($row = mysqli_fetch_assoc($queryh))	{
			$tgljual = $row['tgljual'];
			if (isset($_POST['belumlunas'])) {
				$queryhlagi = mysqli_query($connect,"select sum(total) as total,sum(subtotal) as subtotal,sum(sudahbayar) as sudahbayar,sum(kurangbayar) as kurangbayar from jualh where tgljual='$tgljual' and kurangbayar>0");
			}else{
				$queryhlagi = mysqli_query($connect,"select sum(total) as total,sum(subtotal) as subtotal,sum(sudahbayar) as sudahbayar,sum(kurangbayar) as kurangbayar from jualh where tgljual='$tgljual'");
			}
			while ($rowhlagi = mysqli_fetch_assoc($queryhlagi))	{
				$piutang = number_format($rowhlagi['total'],0,",",".");	
				$sudahbayar = number_format($rowhlagi['sudahbayar'],0,",",".");
				$kurangbayar = number_format($rowhlagi['kurangbayar'],0,",",".");
				$totalsisa_piutang = $totalsisa_piutang + $rowhlagi["kurangbayar"];
				$totalpiutang = $totalpiutang + $rowhlagi["total"];
				$totalbayar = $totalbayar + $rowhlagi["sudahbayar"];
			}
			$month = date('m', strtotime($tgljual));
			$html .= '<tr>
					<td width="30px"  align="center">'.$no.'</td>
					<td>&nbsp;'.$tgljual.'</td>
					<td align="right">&nbsp;'.$piutang.'&nbsp;</td>
					<td align="right">&nbsp;'.$sudahbayar.'&nbsp;</td>
					<td align="right">&nbsp;'.$kurangbayar.'&nbsp;</td>
				</tr>';
			$no++;
		}
		$totalpiutang = number_format($totalpiutang,0,",",".");
		$totalsisa_piutang = number_format($totalsisa_piutang,0,",",".");
		$totalbayar = number_format($totalbayar,0,",",".");
		$html .= '<tr><td colspan="2"  align="left">&nbsp;'."Total".'&nbsp;</td>
			<td  align="right">&nbsp;'.$totalpiutang.'&nbsp;</td>
			<td  align="right">&nbsp;'.$totalbayar.'&nbsp;</td>
			<td  align="right">&nbsp;'.$totalsisa_piutang.'&nbsp;</td>
		</tr>';
		$html .= '</table><font size="1"><left>Tanggal cetak : '.date('d-m-Y H:i:s a');
	
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		$dompdf->set_paper('A4', 'potrait');
		$dompdf->render();
		$dompdf->stream('laporan_'.$nama.'.pdf', array('Attachment' => false));	
		//$dompdf->stream('laporan_'.$nama.'.pdf'); &&langsung download
	}
