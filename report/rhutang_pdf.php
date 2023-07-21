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


	if ($_POST['harbul']=="Harian") {
		if (isset($_POST['check1'])) {
			$tanggal = 'Semua Periode';
			$queryh = mysqli_query($connect,"select nobeli,tglbeli,nobeli,nmsupplier,noinvoice,tglinvoice,carabayar,total,sudahbayar,kurangbayar from belih where proses='Y' and kurangbayar>0 order by tglbeli");
		}else{
			$tanggal = $tanggal1.' s/d '.$tanggal2;
			$queryh = mysqli_query($connect,"select nobeli,tglbeli,nobeli,nmsupplier,noinvoice,tglinvoice,carabayar,total,sudahbayar,kurangbayar from belih  where proses='Y' and (tglbeli>='$tgl1' and tglbeli<='$tgl2') and kurangbayar>0  order by tglbeli");
			//echo $tgl1.'  '.$tgl2;
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
			<font size="2"><br>LAPORAN HARIAN HUTANG
			<br>Tanggal : '."$tanggal".'
			<hr size=2></hr></font>

			<table table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
				<tr>
					<th width="30px" height="20"><font size="1" color="black">NO.</th>
					<th width="90px"><font size="1" color="black">NO. BELI</th>
					<th width="65px"><font size="1" color="black">TGL. BELI</th>
					<th width="95px"><font size="1" color="black">NO. INVOICE</th>
					<th width="65px"><font size="1" color="black">TGL. INVOICE</th>
					<th width="200px"><font size="1" color="black">SUPPLIER</th>
					<th width="90px"><font size="1" color="black">CARA BAYAR</th>
					<th width="80px"><font size="1" color="black">HUTANG</th>
					<th width="80px"><font size="1" color="black">BAYAR</th>
					<th width="80px"><font size="1" color="black">SISA</th>
				</tr>';
		$totalhutang = 0;
		$totalsisa_hutang = 0;
		$totalbayar = 0;
		while ($row = mysqli_fetch_assoc($queryh))	{
			//$subtotal_ppn = $rowd['subtotal'] - ($rowd['subtotal'] * ($row['ppn']/100));
			$hutang = number_format($row['total'],0,",",".");
			$sudahbayar = number_format($row['sudahbayar'],0,",",".");
			$kurangbayar = number_format($row['kurangbayar'],0,",",".");
			$tglbeli = date('d-m-Y', strtotime($row['tglbeli']));
			$tglinvoice = date('d-m-Y', strtotime($row['tglinvoice']));
			$html .= '<tr>
					<td width="30px"  align="center">'.$no.'</td>
					<td>&nbsp;'.$row["nobeli"].'</td>
					<td>&nbsp;'.$tglbeli.'</td>
					<td>&nbsp;'.$row["noinvoice"].'</td>
					<td>&nbsp;'.$tglinvoice.'</td>
					<td>&nbsp;'.$row["nmsupplier"].'</td>
					<td>&nbsp;'.$row["carabayar"].'</td>
					<td align="right">&nbsp;'.$hutang.'&nbsp;</td>
					<td align="right">&nbsp;'.$sudahbayar.'&nbsp;</td>
					<td align="right">&nbsp;'.$kurangbayar.'&nbsp;</td>
				</tr>';
			$no++;
			$totalsisa_hutang = $totalsisa_hutang + $row["kurangbayar"];
			$totalhutang = $totalhutang + $row["total"];
			$totalbayar = $totalbayar + $row["sudahbayar"];
		}
		$totalhutang = number_format($totalhutang,0,",",".");
		$totalsisa_hutang = number_format($totalsisa_hutang,0,",",".");
		$totalbayar = number_format($totalbayar,0,",",".");
		$html .= '<tr><td colspan="7"  align="left">&nbsp;'."Total".'&nbsp;</td>
			<td  align="right">&nbsp;'.$totalhutang.'&nbsp;</td>
			<td  align="right">&nbsp;'.$totalbayar.'&nbsp;</td>
			<td  align="right">&nbsp;'.$totalsisa_hutang.'&nbsp;</td>
		</tr>';
		$html .= '</table><font size="1"><left>Tanggal cetak : '.date('d-m-Y H:i:s a');
	
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		$dompdf->set_paper('A4', 'landscape');
		$dompdf->render();
		$dompdf->stream('laporan_'.$nama.'.pdf', array('Attachment' => false));	
		//$dompdf->stream('laporan_'.$nama.'.pdf'); &&langsung download
	}else{ //Bulanan
		if (isset($_POST['check1'])) {
			$tanggal = 'Semua Periode';
			$queryh = mysqli_query($connect,"select * from belih where proses='Y' group by tglbeli order by tglbeli");
		}else{
			$tanggal = $tanggal1.' s/d '.$tanggal2;
			$queryh = mysqli_query($connect,"select * from belih where proses='Y' and (tglbeli>='$tgl1' and tglbeli<='$tgl2') group by tglbeli order by tglbeli");
			//echo $tgl1.'  '.$tgl2;
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
			<font size="2"><br>LAPORAN BULANAN HUTANG
			<br>Tanggal : '."$tanggal".'
			<hr size=2></hr></font>

			<table table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
				<tr>
					<th width="30px" height="20"><font size="1" color="black">NO.</th>
					<th width="65px"><font size="1" color="black">TGL. BELI</th>
					<th width="80px"><font size="1" color="black">HUTANG</th>
					<th width="80px"><font size="1" color="black">BAYAR</th>
					<th width="80px"><font size="1" color="black">SISA</th>
				</tr>';
		$totalhutang = 0;
		$totalsisa_hutang = 0;
		$totalbayar = 0;
		while ($row = mysqli_fetch_assoc($queryh))	{
			$tglbeli = $row['tglbeli'];
			$queryhlagi = mysqli_query($connect,"select sum(total) as total,sum(subtotal) as subtotal,sum(sudahbayar) as sudahbayar,sum(kurangbayar) as kurangbayar from belih where tglbeli='$tglbeli'");
			while ($rowhlagi = mysqli_fetch_assoc($queryhlagi))	{
				$hutang = number_format($rowhlagi['total'],0,",",".");	
				$sudahbayar = number_format($rowhlagi['sudahbayar'],0,",",".");
				$kurangbayar = number_format($rowhlagi['kurangbayar'],0,",",".");
				$totalsisa_hutang = $totalsisa_hutang + $rowhlagi["kurangbayar"];
				$totalhutang = $totalhutang + $rowhlagi["total"];
				$totalbayar = $totalbayar + $rowhlagi["sudahbayar"];
			}
			$month = date('m', strtotime($tglbeli));
			$html .= '<tr>
					<td width="30px"  align="center">'.$no.'</td>
					<td>&nbsp;'.$tglbeli.'</td>
					<td align="right">&nbsp;'.$hutang.'&nbsp;</td>
					<td align="right">&nbsp;'.$sudahbayar.'&nbsp;</td>
					<td align="right">&nbsp;'.$kurangbayar.'&nbsp;</td>
				</tr>';
			$no++;
		}
		$totalhutang = number_format($totalhutang,0,",",".");
		$totalsisa_hutang = number_format($totalsisa_hutang,0,",",".");
		$totalbayar = number_format($totalbayar,0,",",".");
		$html .= '<tr><td colspan="2"  align="left">&nbsp;'."Total".'&nbsp;</td>
			<td  align="right">&nbsp;'.$totalhutang.'&nbsp;</td>
			<td  align="right">&nbsp;'.$totalbayar.'&nbsp;</td>
			<td  align="right">&nbsp;'.$totalsisa_hutang.'&nbsp;</td>
		</tr>';
		$html .= '</table><font size="1"><left>Tanggal cetak : '.date('d-m-Y H:i:s a');
	
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		$dompdf->set_paper('A4', 'potrait');
		$dompdf->render();
		$dompdf->stream('laporan_'.$nama.'.pdf', array('Attachment' => false));	
		//$dompdf->stream('laporan_'.$nama.'.pdf'); &&langsung download
	}
?>