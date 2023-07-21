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
	$kdsales = $_POST['kdsales'];
	$no=1;

	if (isset($_POST['semuacustomer'])) { //semua customer
		if (isset($_POST['semuasales'])) { //semua sales
			if (isset($_POST['check2'])) {
				$tanggal = 'Outstanding s/d '.$tanggal2;
				$queryh = mysqli_query($connect,"select * from jualh where proses='Y' and terima='N' order by tgljual");
			}else{
				if (isset($_POST['check1'])) {
					$tanggal = 'Semua Periode';
					$queryh = mysqli_query($connect,"select * from jualh where proses='Y' order by tgljual");
				}else{
					$tanggal = $tanggal1.' s/d '.$tanggal2;
					$queryh = mysqli_query($connect,"select * from jualh where (tgljual>='$tgl1' and tgljual<='$tgl2') and proses='Y' order by tgljual");
					//$jumrec = mysqli_num_rows(mysqli_query($connect,"select * from jualh where (tgljual>='$tgl1' and tgljual<='$tgl2') and proses='Y' order by tgljual"));
					//echo $jumrec;
					//echo $tgl1.'  '.$tgl2;
				}
			}
		}else{
			if (isset($_POST['check2'])) {
				$tanggal = 'Outstanding s/d '.$tanggal2;
				$queryh = mysqli_query($connect,"select * from jualh where proses='Y' and terima='N' and kdsales='$kdsales' order by tgljual");
			}else{
				if (isset($_POST['check1'])) {
					$tanggal = 'Semua Periode';
					$queryh = mysqli_query($connect,"select * from jualh where proses='Y' and kdsales='$kdsales' order by tgljual");
				}else{
					$tanggal = $tanggal1.' s/d '.$tanggal2;
					$queryh = mysqli_query($connect,"select * from jualh where (tgljual>='$tgl1' and tgljual<='$tgl2') and proses='Y' and kdsales='$kdsales' order by tgljual");
					// $jumrec = mysqli_num_rows(mysqli_query($connect,"select * from jualh where (tgljual>='$tgl1' and tgljual<='$tgl2') and proses='Y' and kdsales='$kdsales' order by tgljual"));
					// echo $jumrec;
					// echo $kdsales;
					//echo $tgl1.'  '.$tgl2;
				}
			}
		}
		echo 'test1';
	}else{
		if (isset($_POST['semuasales'])) { //semua sales
			if (isset($_POST['check2'])) {
				$tanggal = 'Outstanding s/d '.$tanggal2;
				$queryh = mysqli_query($connect,"select * from jualh where proses='Y' and terima='N' and kdcustomer='$kdcustomer' order by tgljual");
			}else{
				if (isset($_POST['check1'])) {
					$tanggal = 'Semua Periode';
					$queryh = mysqli_query($connect,"select * from jualh where proses='Y' and kdcustomer='$kdcustomer' order by tgljual");
				}else{
					$tanggal = $tanggal1.' s/d '.$tanggal2;
					$queryh = mysqli_query($connect,"select * from jualh where (tgljual>='$tgl1' and tgljual<='$tgl2') and proses='Y' and kdcustomer='$kdcustomer' order by tgljual");
					//echo $tgl1.'  '.$tgl2;
				}
			}
		}else{
			if (isset($_POST['check2'])) {
				$tanggal = 'Outstanding s/d '.$tanggal2;
				$queryh = mysqli_query($connect,"select * from jualh where proses='Y' and terima='N' and kdcustomer='$kdcustomer' and kdsales='$kdsales' order by tgljual");
			}else{
				if (isset($_POST['check1'])) {
					$tanggal = 'Semua Periode';
					$queryh = mysqli_query($connect,"select * from jualh where proses='Y' and kdcustomer='$kdcustomer' and kdsales='$kdsales' order by tgljual");
				}else{
					$tanggal = $tanggal1.' s/d '.$tanggal2;
					$queryh = mysqli_query($connect,"select * from jualh where (tgljual>='$tgl1' and tgljual<='$tgl2') and proses='Y' and kdcustomer='$kdcustomer' and kdsales='$kdsales' order by tgljual");
					//echo $tgl1.'  '.$tgl2;
				}
			}
		}
	}

	$html = '<style>
				td { border: 0.5px solid grey; margin: 5px;}
	            th { border: 0.5px solid grey; font-weight:normal;}
	            body { font-family: comic sans ms;}
			</style>
		<font size="3" face="comic sans ms">
		'."$nm_perusahaan".'</font>
		<br>'.'<font size="1" face="comic sans ms">'."$alamat_perusahaan".'
		<br>'."$telp_perusahaan".'</font><br>
		<font size="2"><br>LAPORAN PENJUALAN
		<br>Tanggal : '."$tanggal".'
		<hr size=2></hr></font>';

	if (isset($_POST['rincian'])) { 
		$html .='<table table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
			<tr>
				<th width="30px" height="20"><font size="1" color="black">NO.</th>
				<th width="90px"><font size="1" color="black">KODE BARANG</th>
				<th width="200px"><font size="1" color="black">NAMA BARANG</th>
				<th width="50px"><font size="1" color="black">QTY</th>
				<th width="60px"><font size="1" color="black">HARGA</th>
				<th width="60px"><font size="1" color="black">SUBTOTAL</th>
				<th width="60px"><font size="1" color="black">DISC.</th>
				<th width="60px"><font size="1" color="black">PPN</th>
				<th width="70px"><font size="1" color="black">TOTAL</th>
			</tr>';
		$grandtotal=0;
		$grandjual=0;
		$grandppn=0;
		$granddiscount=0;
		while ($row = mysqli_fetch_assoc($queryh))	{
			$html .= '<tr>
				<td colspan="9" width="573px" height="35px" align="left">&nbsp;'."No. Jual : ".$row["nojual"].', Tanggal : '.date('d-m-Y', strtotime($row["tgljual"])).', No. Invoice : '.$row["noinvoice"].', Biaya Lain : '.$row["biaya_lain"].', Customer : '.$row["nmcustomer"].'</td>';
			$nojual = $row['nojual'];
			if (isset($_POST['check1'])) {
				$tanggal = 'Semua Periode';
				$queryd = mysqli_query($connect,"select jualh.nojual,jualh.tgljual,jualh.noinvoice,jualh.nmcustomer,juald.kdbarang,juald.nmbarang,juald.qty,juald.harga,juald.discount,juald.subtotal from jualh inner join juald on jualh.nojual=juald.nojual where jualh.proses='Y' and jualh.nojual='$nojual'");
			}else{
				$tanggal = $tanggal1.' s/d '.$tanggal2;
				$queryd = mysqli_query($connect,"select jualh.nojual,jualh.tgljual,jualh.noinvoice,jualh.nmcustomer,juald.kdbarang,juald.nmbarang,juald.qty,juald.harga,juald.discount,juald.subtotal from jualh inner join juald on jualh.nojual=juald.nojual where (jualh.tgljual>='$tgl1' and jualh.tgljual<='$tgl2') and jualh.proses='Y' and juald.nojual='$nojual'");
			}
			$subtotaljual=0;
			$subtotalppn=0;
			$subtotaldiscount=0;
			$jumsubtotal = 0;
			while ($rowd = mysqli_fetch_assoc($queryd))
			{
				//$subtotal_ppn = $rowd['subtotal'] - ($rowd['subtotal'] * ($row['ppn']/100));
				$qty = number_format($rowd['qty'],2,",",".");
				$harga = number_format($rowd['harga'],0,",",".");
				$ndiscount = ($rowd['qty'] * $rowd['harga']) * ($rowd['discount']/100);
				$discount = number_format($ndiscount,0,",",".");
				$nppn = (($rowd['qty'] * $rowd['harga']) - $ndiscount) * ($row['ppn']/100);
				$ppn = number_format($nppn,0,",",".");
				$harga = number_format($rowd['harga'],0,",",".");
				$nsubtotal = ($rowd['qty'] * $rowd['harga']) - $ndiscount + $nppn;
				$subtotal = number_format($nsubtotal,0,",",".");
				$njual = ($rowd['qty'] * $rowd['harga']);
				$jual = number_format($njual,0,",",".");
				$html .= '<tr>
						<td align="center">'.$no.'</td>
						<td>&nbsp;'.$rowd["kdbarang"].'</td>
						<td>&nbsp;'.$rowd["nmbarang"].'</td>
						<td align="right">'.$qty.'&nbsp;</td>
						<td align="right">'.$harga.'&nbsp;</td>
						<td align="right">'.$jual.'&nbsp;</td>
						<td align="right">'.$discount.'&nbsp;</td>
						<td align="right">'.$ppn.'&nbsp;</td>
						<td align="right">'.$subtotal.'&nbsp;</td>
					</tr>';
				$no++;
				$grandjual = $grandjual + $njual;
				$grandppn = $grandppn + $nppn;
				$granddiscount = $granddiscount + $ndiscount;
				$subtotaljual = $subtotaljual + $njual;
				$subtotalppn = $subtotalppn + $nppn;
				$subtotaldiscount = $subtotaldiscount + $ndiscount;
				$grandtotal = $grandtotal + $nsubtotal;
				$jumsubtotal = $jumsubtotal + $nsubtotal;
			}
			$subtotaljual = number_format($subtotaljual,0,",",".");
			$subtotalppn = number_format($subtotalppn,0,",",".");
			$subtotaldiscount = number_format($subtotaldiscount,0,",",".");
			$total = number_format($jumsubtotal,0,",",".");
			$html .= '<tr><td colspan="5" height="20px" align="left">&nbsp;'."Total".'&nbsp;</td>
				<td height="20px" align="right">&nbsp;'.$subtotaljual.'&nbsp;</td>
				<td height="20px" align="right">&nbsp;'.$subtotaldiscount.'&nbsp;</td>
				<td height="20px" align="right">&nbsp;'.$subtotalppn.'&nbsp;</td>
				<td height="20px" align="right">&nbsp;'.$total.'&nbsp;</td>
			</tr>';
			
		}
		$grandtotal = number_format($grandtotal,0,",",".");
		$grandjual = number_format($grandjual,0,",",".");
		$grandppn = number_format($grandppn,0,",",".");
		$granddiscount = number_format($granddiscount,0,",",".");
		$html .= '<tr><td colspan="5" height="20px" align="left">&nbsp;'."Grand Total".'&nbsp;</td>
			<td height="20px" align="right">&nbsp;'.$grandjual.'&nbsp;</td>
			<td height="20px" align="right">&nbsp;'.$granddiscount.'&nbsp;</td>
			<td height="20px" align="right">&nbsp;'.$grandppn.'&nbsp;</td>
			<td height="20px" align="right">&nbsp;'.$grandtotal.'&nbsp;</td>
			</tr>';	
	}else{
		$html .='<table table-layout="fixed"; cellpadding="2"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
			<tr>
				<th width="30px" height="20"><font size="1" color="black">NO.</th>
				<th width="90px"><font size="1" color="black">NO. PENJUALAN</th>
				<th width="60px"><font size="1" color="black">TANGGAL</th>
				<th width="300px"><font size="1" color="black">CUSTOMER</th>
				<th width="80px"><font size="1" color="black">TOTAL<br>SEMENTARA</th>
				<th width="70px"><font size="1" color="black">DISKON<br>Rp.</th>
				<th width="70px"><font size="1" color="black">PPN</th>
				<th width="75px"><font size="1" color="black">TOTAL</th>
				<th width="80px"><font size="1" color="black">JUMLAH<br>PEMBAYARAN</th>
				<th width="80px"><font size="1" color="black">SISA<br>PEMBAYARAN</th>
				<th width="60px"><font size="1" color="black">STATUS<br>BAYAR</th>
			</tr>';
		$grandtotal_sementara=0;
		$granddiscount=0;
		$grandppn=0;
		$grandtotal=0;
		$grandsudahbayar=0;
		$grandkurangbayar=0;
		$no=1;
		while ($row = mysqli_fetch_assoc($queryh))	{
			$nojual = $row['nojual'];
			$tgljual = date('d-m-Y', strtotime($row['tgljual']));
			$nppn = $row['total_sementara'] * ($row['ppn']/100);
			$ppn = number_format($nppn,0,",",".");	
			$total = number_format($row['total'],0,",",".");	
			$sudahbayar = number_format($row['sudahbayar'],0,",",".");	
			$kurangbayar = number_format($row['kurangbayar'],0,",",".");	
			
			$queryd = mysqli_query($connect,"select qty,harga,discount from juald where nojual='$nojual'");
			$ndiscount = 0;
			$ntotal_sementara = 0;
			while ($rowd = mysqli_fetch_assoc($queryd)) {
				//$subtotal_ppn = $rowd['subtotal'] - ($rowd['subtotal'] * ($row['ppn']/100));
				$ndiscount = $ndiscount + ($rowd['qty']*$rowd['harga']) * ($rowd['discount']/100);
				$ntotal_sementara = $ntotal_sementara + ($rowd['qty']*$rowd['harga']);
			}
			$discount = number_format($ndiscount,0,",",".");	
			$total_sementara = number_format($ntotal_sementara,0,",",".");	
			$html .= '<tr>
				<td height="10px" align="center">&nbsp;'.$no.'</td>
				<td height="10px" align="left">&nbsp;'.$row["nojual"].'</td>
				<td height="10px" align="center">&nbsp;'.$tgljual.'</td>
				<td height="10px" align="left">'.$row["nmcustomer"].'</td>
				<td height="10px" align="right">&nbsp;'.$total_sementara.'</td>
				<td height="10px" align="right">&nbsp;'.$discount.'</td>
				<td height="10px" align="right">&nbsp;'.$ppn.'</td>
				<td height="10px" align="right">&nbsp;'.$total.'</td>
				<td height="10px" align="right">&nbsp;'.$sudahbayar.'</td>
				<td height="10px" align="right">&nbsp;'.$kurangbayar.'</td>
				<td height="10px" align="center">&nbsp;'.$row["carabayar"].'</td>';
			$grandtotal_sementara=$grandtotal_sementara+$ntotal_sementara;
			$granddiscount=$granddiscount+$ndiscount;
			$grandppn=$grandppn+$nppn;
			$grandtotal=$grandtotal+$row['total'];
			$grandsudahbayar=$grandsudahbayar+$row['sudahbayar'];
			$grandkurangbayar=$grandkurangbayar+$row['kurangbayar'];
			$no++;
		}
		$grandtotal_sementara=number_format($grandtotal_sementara,0,",",".");
		$granddiscount=number_format($granddiscount,0,",",".");	
		$grandppn=number_format($grandppn,0,",",".");	
		$grandtotal=number_format($grandtotal,0,",",".");	
		$grandsudahbayar=number_format($grandsudahbayar,0,",",".");	
		$grandkurangbayar=number_format($grandkurangbayar,0,",",".");	
		$html .= '<tr>
				<td colspan="4" height="10px" align="center"></td>
				<td height="10px" align="right">&nbsp;'.$grandtotal_sementara.'</td>
				<td height="10px" align="right">&nbsp;'.$granddiscount.'</td>
				<td height="10px" align="right">&nbsp;'.$grandppn.'</td>
				<td height="10px" align="right">&nbsp;'.$grandtotal.'</td>
				<td height="10px" align="right">&nbsp;'.$grandsudahbayar.'</td>
				<td height="10px" align="right">&nbsp;'.$grandkurangbayar.'</td>
				<td height="10px" align="right"></td>';


	}
	$html .= '</table><font size="1"><left>Tanggal cetak : '.date('d-m-Y H:i:s a');


	echo 'Proses PDF !';
	$dompdf = new DOMPDF();
	$dompdf->load_html($html);
	if (isset($_POST['rincian'])) { 
		$dompdf->set_paper('A4', 'Potrait');
	}else{
		$dompdf->set_paper('A4', 'Landscape');
	}
	$dompdf->render();
	$dompdf->stream('laporan_'.$nama.'.pdf', array('Attachment' => false));	
	//$dompdf->stream('laporan_'.$nama.'.pdf'); &&langsung download
?>