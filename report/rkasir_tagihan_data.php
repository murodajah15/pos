<?php
session_start();
include "../inc/config.php";
date_default_timezone_set('Asia/Jakarta');
$nm_perusahaan = $_SESSION['nm_perusahaan'];
$alamat_perusahaan = $_SESSION['alamat_perusahaan'];
$telp_perusahaan = $_SESSION['telp_perusahaan'];
$no = 1;

$nmkasir = $_POST['nmkasir'];
if ($nmkasir == "") {
  if (isset($_POST['check1'])) {
    $tanggal = 'Semua Periode';
    $queryh = mysqli_query($connect, "select carabayar,user_input, nokwitansi,tglkwitansi,nojual,nmcustomer,piutang,bayar,if(carabayar='Cash',bayar,0) as cash,
      if(carabayar='Transfer',bayar,0) as transfer,
      if(carabayar='Cek/Giro',bayar,0) as cek_giro,
      if(carabayar='Debit Card',bayar,0) as debit_card,
      if(carabayar='Credit Card',bayar,0) as credit_card,
       piutang-bayar as sisa_piutang from kasir_tagihan where proses='Y' order by tglkwitansi");
  } else {
    $tanggal = $tanggal1 . ' s/d ' . $tanggal2;
    $queryh = mysqli_query($connect, "select carabayar,user_input, nokwitansi,tglkwitansi,nojual,nmcustomer,piutang,bayar,
      if(carabayar='Cash',bayar,0) as cash,
      if(carabayar='Transfer',bayar,0) as transfer,
      if(carabayar='Cek/Giro',bayar,0) as cek_giro,
      if(carabayar='Debit Card',bayar,0) as debit_card,
      if(carabayar='Credit Card',bayar,0) as credit_card,
      piutang-bayar as sisa_piutang from kasir_tagihan where proses='Y' and (tglkwitansi>='$tgl1' and tglkwitansi<='$tgl2') order by tglkwitansi");
    //echo $tgl1.'  '.$tgl2;
  }
} else {
  if (isset($_POST['check1'])) {
    $tanggal = 'Semua Periode';
    $queryh = mysqli_query($connect, "select carabayar,user_input,nokwitansi,tglkwitansi,nojual,nmcustomer,piutang,bayar,if(carabayar='Cash',bayar,0) as cash,
      if(carabayar='Transfer',bayar,0) as transfer,
      if(carabayar='Cek/Giro',bayar,0) as cek_giro,
      if(carabayar='Debit Card',bayar,0) as debit_card,
      if(carabayar='Credit Card',bayar,0) as credit_card,
      piutang-bayar as sisa_piutang from kasir_tagihan where proses='Y' and user_input='$nmkasir' order by tglkwitansi");
  } else {
    $tanggal = $tanggal1 . ' s/d ' . $tanggal2;
    $queryh = mysqli_query($connect, "select carabayar,user_input,nokwitansi,tglkwitansi,nojual,nmcustomer,piutang,bayar,if(carabayar='Cash',bayar,0) as cash,
      if(carabayar='Transfer',bayar,0) as transfer,
      if(carabayar='Cek/Giro',bayar,0) as cek_giro,
      if(carabayar='Debit Card',bayar,0) as debit_card,
      if(carabayar='Credit Card',bayar,0) as credit_card,
      piutang-bayar as sisa_piutang from kasir_tagihan where proses='Y' and user_input='$nmkasir' and (tglkwitansi>='$tgl1' and tglkwitansi<='$tgl2') order by tglkwitansi");
    //echo $tgl1.'  '.$tgl2;
  }
}

$cek = mysqli_num_rows($queryh);
if (empty($cek)) {
  echo '<script>alert(\'Tidak Ada sesuai kriteria\')
 window.close()</script>';
}

echo '<style>
				td { border: 0.5px solid grey; margin: 5px;}
	            th { border: 0.5px solid grey; font-weight:normal;}
	            body { font-family: comic sans ms;}
			</style>
		<font size="1" face="comic sans ms">
		' . "$nm_perusahaan" . '
		<br>' . "$alamat_perusahaan" . '
		<br>' . "$telp_perusahaan" . '</font><br>
		<font size="2"><br>LAPORAN PENERIMAAN KASIR TAGIHAN
		<br>Tanggal : ' . "$tanggal" . '
		<br><br></font>';

if (isset($_POST['carabayar'])) {
  echo '<table table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
			<tr>
				<th width="30px" height="20"><font size="1" color="black">NO.</th>
				<th width="120px"><font size="1" color="black">NO. KWITANSI</th>
                <th width="80px"><font size="1" color="black">TANGGAL</th>
				<th width="120px"><font size="1" color="black">NO. PENJUALAN</th>
				<th width="80px">CARA BAYAR</th>
				<th width="80px">TOTAL</th>
				<th width="120px">KASIR</th>
			</tr>';
  $querycarabayar = mysqli_query($connect, "select carabayar from kasir_tagihan where proses='Y' group by carabayar");
  while ($rowcarabayar = mysqli_fetch_assoc($querycarabayar)) {
    // echo $rowcarabayar['carabayar'] . '<br>';
    $no = 0;
    while ($row = mysqli_fetch_assoc($queryh)) {
      $no++;
      $nokwitansi = $row['nokwitansi'];
      if ($row['carabayar'] == $rowcarabayar['carabayar']) {
        $queryd = mysqli_query($connect, "select * from kasir_tagihand where nokwitansi='$nokwitansi'");
        while ($rowd = mysqli_fetch_assoc($queryd)) {
          $bayarf = number_format($rowd['bayar'], 0, ",", ".");
          echo '<tr><td align="center">&nbsp;' . $no . '</td>
          <td>&nbsp;' . $row["nokwitansi"] . '</td>
          <td>&nbsp;' . $row["tglkwitansi"] . '</td>
          <td>&nbsp;' . $rowd["nojual"] . '</td>
          <td>&nbsp;' . $row["carabayar"] . '</td>
          <td align="right">' . $bayarf . '&nbsp;</td>
          <td>&nbsp;' . $row["user_input"] . '</td>
          </tr>';
        }
      }
    }
  }
} else {
  echo '<table table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
			<tr>
				<th width="30px" height="20" rowspan="2"><font size="1" color="black">NO.</th>
				<th width="90px" rowspan="2"><font size="1" color="black">NO. KWITANSI<br>NO. PPENJUALAN</th>
				<th width="65px" rowspan="2"><font size="1" color="black">TANGGAL</th>
				<th colspan="5">CARA BAYAR</th>
				<th width="80px" rowspan="2">TOTAL</th>
				<tr><th width="70px">TUNAI</th>
				<th width="70px">TRANSFER</th>
				<th width="70px">CEK/GIRO</th>
				<th width="70px">DEBIT<br>CARD</th>
				<th width="70px">CREDIT<br>CARD</th>
			</tr>';
  $gtotalcash = 0;
  $gtotaltransfer = 0;
  $gtotalcek_giro = 0;
  $gtotaldebit_card = 0;
  $gtotalcredit_card = 0;
  $gtotalbayar = 0;
  while ($row = mysqli_fetch_assoc($queryh)) {
    //$subtotal_ppn = $rowd['subtotal'] - ($rowd['subtotal'] * ($row['ppn']/100));
    $piutang = number_format($row['piutang'], 0, ",", ".");
    $cash = number_format($row['cash'], 0, ",", ".");
    $transfer = number_format($row['transfer'], 0, ",", ".");
    $cek_giro = number_format($row['cek_giro'], 0, ",", ".");
    $debit_card = number_format($row['debit_card'], 0, ",", ".");
    $credit_card = number_format($row['credit_card'], 0, ",", ".");
    $sisa_piutang = number_format($row['sisa_piutang'], 0, ",", ".");
    $bayar = number_format($row['bayar'], 0, ",", ".");
    $tglkwitansi = date('d-m-Y', strtotime($row['tglkwitansi']));
    $nokwitansi = $row['nokwitansi'];
    // <td  align="right">&nbsp;'.$cash.'&nbsp;</td>
    // <td  align="right">&nbsp;'.$transfer.'&nbsp;</td>
    // <td  align="right">&nbsp;'.$cek_giro.'&nbsp;</td>
    // <td  align="right">&nbsp;'.$debit_card.'&nbsp;</td>
    // <td  align="right">&nbsp;'.$credit_card.'&nbsp;</td>
    // <td  align="right">&nbsp;'.$bayar.'&nbsp;</td>
    echo '<tr>
				<td width="30px" align="center">&nbsp;' . $no . '</td>
				<td >&nbsp;' . $row["nokwitansi"] . '</td>
				<td >&nbsp;' . $tglkwitansi . '</td>
				<td colspan="6" >&nbsp;' . $row["nmcustomer"] . '</td>
			</tr>';
    $no++;
    $queryd = mysqli_query($connect, "select kasir_tagihand.nojual, kasir_tagihand.bayar,jualh.tgljual,
					if(kasir_tagihan.carabayar='Cash',kasir_tagihand.bayar,0) as cash,
					if(kasir_tagihan.carabayar='Transfer',kasir_tagihand.bayar,0) as transfer,
					if(kasir_tagihan.carabayar='Cek/Giro',kasir_tagihand.bayar,0) as cek_giro,
					if(kasir_tagihan.carabayar='Debit Card',kasir_tagihand.bayar,0) as debit_card,
					if(kasir_tagihan.carabayar='Credit Card',kasir_tagihand.bayar,0) as credit_card
	 				from kasir_tagihand inner join kasir_tagihan on kasir_tagihan.nokwitansi=kasir_tagihand.nokwitansi inner join jualh on jualh.nojual=kasir_tagihand.nojual where kasir_tagihand.nokwitansi='$nokwitansi'");
    $totalcash = 0;
    $totaltransfer = 0;
    $totalcek_giro = 0;
    $totaldebit_card = 0;
    $totalcredit_card = 0;
    $totalsisa_piutang = 0;
    $totalpiutang = 0;
    $totalbayar = 0;
    $nod = 1;
    while ($d = mysqli_fetch_assoc($queryd)) {
      $cash = number_format($d['cash'], 0, ",", ".");
      $transfer = number_format($d['transfer'], 0, ",", ".");
      $cek_giro = number_format($d['cek_giro'], 0, ",", ".");
      $debit_card = number_format($d['debit_card'], 0, ",", ".");
      $credit_card = number_format($d['credit_card'], 0, ",", ".");
      $bayar = number_format($d['bayar'], 0, ",", ".");
      echo '<tr><td align="center">&nbsp;' . $nod . '</td>
								<td>&nbsp;' . $d["nojual"] . '</td>
								<td colspan="1">&nbsp;' . $d["tgljual"] . '</td>
							  <td align="right">&nbsp;' . $cash . '&nbsp;</td>
							  <td align="right">&nbsp;' . $transfer . '&nbsp;</td>
							  <td align="right">&nbsp;' . $cek_giro . '&nbsp;</td>
							  <td align="right">&nbsp;' . $debit_card . '&nbsp;</td>
							  <td align="right">&nbsp;' . $credit_card . '&nbsp;</td>
							  <td align="right">&nbsp;' . $bayar . '&nbsp;</td>
							  </tr>';
      $nod++;
      $totalcash = $totalcash + $d["cash"];
      $totaltransfer = $totaltransfer + $d["transfer"];
      $totalcek_giro = $totalcek_giro + $d["cek_giro"];
      $totaldebit_card = $totaldebit_card + $d["debit_card"];
      $totalcredit_card = $totalcredit_card + $d["credit_card"];
      $totalbayar = $totalbayar + $d["bayar"];
    }

    $gtotalcash = $gtotalcash + $totalcash;
    $gtotaltransfer = $gtotaltransfer + $totaltransfer;
    $gtotalcek_giro = $gtotalcek_giro + $totalcek_giro;
    $gtotaldebit_card = $gtotaldebit_card + $totaldebit_card;
    $gtotalcredit_card = $gtotalcredit_card + $totalcredit_card;
    $gtotalbayar = $gtotalbayar + $totalbayar;

    $totalcash = number_format($totalcash, 0, ",", ".");
    $totaltransfer = number_format($totaltransfer, 0, ",", ".");
    $totalcek_giro = number_format($totalcek_giro, 0, ",", ".");
    $totaldebit_card = number_format($totaldebit_card, 0, ",", ".");
    $totalcredit_card = number_format($totalcredit_card, 0, ",", ".");
    $totalbayar = number_format($totalbayar, 0, ",", ".");
    echo '<tr><td colspan="3" height="20px" align="left">&nbsp;' . "Total" . '&nbsp;</td>
			<td height="20px" align="right">&nbsp;' . $totalcash . '&nbsp;</td>
			<td height="20px" align="right">&nbsp;' . $totaltransfer . '&nbsp;</td>
			<td height="20px" align="right">&nbsp;' . $totalcek_giro . '&nbsp;</td>
			<td height="20px" align="right">&nbsp;' . $totaldebit_card . '&nbsp;</td>
			<td height="20px" align="right">&nbsp;' . $totalcredit_card . '&nbsp;</td>
			<td height="20px" align="right">&nbsp;' . $totalbayar . '&nbsp;</td>
		</tr>';
  }
  $gtotalcash = number_format($gtotalcash, 0, ",", ".");
  $gtotaltransfer = number_format($gtotaltransfer, 0, ",", ".");
  $gtotalcek_giro = number_format($gtotalcek_giro, 0, ",", ".");
  $gtotaldebit_card = number_format($gtotaldebit_card, 0, ",", ".");
  $gtotalcredit_card = number_format($gtotalcredit_card, 0, ",", ".");
  $gtotalbayar = number_format($gtotalbayar, 0, ",", ".");
  echo '<tr><td colspan="3" height="20px" align="left">&nbsp;' . "Grand Total" . '&nbsp;</td>
		<td height="20px" align="right">&nbsp;' . $gtotalcash . '&nbsp;</td>
		<td height="20px" align="right">&nbsp;' . $gtotaltransfer . '&nbsp;</td>
		<td height="20px" align="right">&nbsp;' . $gtotalcek_giro . '&nbsp;</td>
		<td height="20px" align="right">&nbsp;' . $gtotaldebit_card . '&nbsp;</td>
		<td height="20px" align="right">&nbsp;' . $gtotalcredit_card . '&nbsp;</td>
		<td height="20px" align="right">&nbsp;' . $gtotalbayar . '&nbsp;</td>
	</tr>';

  echo '</table><font size="1"><left>Tanggal cetak : ' . date('d-m-Y H:i:s a');

  echo '<br><br><table border="0">
				<tr>
				<th width="30px" height="50" valign="top"><font size="1" color="black">KASIR</th>
				<tr><td height="20px" width="120" align="center">&nbsp;( ' . $nmkasir . '&nbsp;)</td>
			</tr>';
}
