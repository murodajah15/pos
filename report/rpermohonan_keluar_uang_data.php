<?php
session_start();
include "../inc/config.php";
date_default_timezone_set('Asia/Jakarta');
$nm_perusahaan = $_SESSION['nm_perusahaan'];
$alamat_perusahaan = $_SESSION['alamat_perusahaan'];
$telp_perusahaan = $_SESSION['telp_perusahaan'];
$no = 1;

if (isset($_POST['check2'])) {
  $tanggal = 'Outstanding s/d ' . $tanggal2;
  $queryh = mysqli_query($connect, "select * from mohklruangh where proses='Y' and terima='N' order by tglmohon");
} else {
  if (isset($_POST['check1'])) {
    $tanggal = 'Semua Periode';
    $queryh = mysqli_query($connect, "select * from mohklruangh where proses='Y' order by tglmohon");
  } else {
    $tanggal = $tanggal1 . ' s/d ' . $tanggal2;
    $queryh = mysqli_query($connect, "select * from mohklruangh where proses='Y' and (tglmohon>='$tgl1' and tglmohon<='$tgl2') order by tglmohon");
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
		<font size="2"><br>LAPORAN PERMOHONAN PENGELUARAN UANG
		<br>Tanggal : ' . "$tanggal" . '
		<br><br></font>

		<table table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
			<tr>
				<th width="30px" height="20"><font size="1" color="black">NO.</th>
				<th width="100px"><font size="1" color="black">NO. DOKUMEN</th>
				<th width="50px"><font size="1" color="black">TANGGAL</th>
				<th width="250px"><font size="1" color="black">SUPPLIER</th>
				<th width="80px"><font size="1" color="black">TOTAL</th>
			</tr>';
$grandtotal = 0;
while ($row = mysqli_fetch_assoc($queryh)) {
  echo '<tr>
			<td colspan="5" width="573px" height="35px" align="left">&nbsp;' . "No. Permohonan : " . $row["nomohon"] . ', Tanggal : ' . date('d-m-Y', strtotime($row["tglmohon"])) . ', Jenis : ' . $row["nmjnkeluar"] . ', Cara Bayar : ' . $row["carabayar"] . '</td>';
  $nomohon = $row['nomohon'];
  if (isset($_POST['check1'])) {
    $tanggal = 'Semua Periode';
    $queryd = mysqli_query($connect, "select mohklruangh.nomohon,mohklruangh.tglmohon,mohklruangh.nmjnkeluar,mohklruangd.nodokumen,mohklruangd.tgldokumen,mohklruangd.uang,mohklruangd.kdsupplier,mohklruangd.nmsupplier from mohklruangh inner join mohklruangd on mohklruangh.nomohon=mohklruangd.nomohon where mohklruangh.proses='Y' and mohklruangh.nomohon='$nomohon'");
  } else {
    $tanggal = $tanggal1 . ' s/d ' . $tanggal2;
    $queryd = mysqli_query($connect, "select mohklruangh.nomohon,mohklruangh.tglmohon,mohklruangh.nmjnkeluar,mohklruangh.nmcustomer,mohklruangd.nodokumen,mohklruangd.tgldokumen,mohklruangd.uang,mohklruangd.kdsupplier,mohklruangd.nmsupplier from mohklruangh inner join mohklruangd on mohklruangh.nomohon=mohklruangd.nomohon where mohklruangh.proses='Y' and (mohklruangh.tglmohon>='$tgl1' and mohklruangh.tglmohon<='$tgl2') and mohklruangd.nomohon='$nomohon'");
  }
  $jumsubtotal = 0;
  while ($rowd = mysqli_fetch_assoc($queryd)) {
    //$subtotal_ppn = $rowd['subtotal'] - ($rowd['subtotal'] * ($row['ppn']/100));
    $uang = number_format($rowd['uang'], 0, ",", ".");
    $supplier = $rowd['kdsupplier'] . '-' . $rowd['nmsupplier'];
    $tgldokumen = date('d-m-Y', strtotime($rowd['tgldokumen']));
    echo '<tr>
					<td width="30px"  align="center">' . $no . '</td>
					<td width="100px" >&nbsp;' . $rowd["nodokumen"] . '</td>
					<td width="50px"  align="center">&nbsp;' . $tgldokumen . '</td>
					<td width="250px" >&nbsp;' . $supplier . '&nbsp;</td>
					<td width="80px"  align="right">' . $uang . '&nbsp;</td>
				</tr>';
    $no++;
    $jumsubtotal = $jumsubtotal + $rowd['uang'];
    $grandtotal = $grandtotal + $rowd['uang'];
  }
  $total = number_format($jumsubtotal, 0, ",", ".");
  echo '<tr><td colspan="4" height="20px" align="left">&nbsp;' . "Total" . '&nbsp;</td>
			<td height="20px" align="right">&nbsp;' . $total . '&nbsp;</td>
		</tr>';
}
$grandtotal = number_format($grandtotal, 0, ",", ".");
echo '<tr><td colspan="4" height="20px" align="left">&nbsp;' . "Grand Total" . '&nbsp;</td>
		<td height="20px" align="right">&nbsp;' . $grandtotal . '&nbsp;</td>
		</tr></table>';

echo '</table><font size="1"><left>Tanggal cetak : ' . date('d-m-Y H:i:s a');
