<?php
session_start();
include "../inc/config.php";
date_default_timezone_set('Asia/Jakarta');
$nm_perusahaan = $_SESSION['nm_perusahaan'];
$alamat_perusahaan = $_SESSION['alamat_perusahaan'];
$telp_perusahaan = $_SESSION['telp_perusahaan'];
$no = 1;

$noopname = $_POST['noopname'];
if ($noopname == "") {
  $queryh = mysqli_query($connect, "select * from opnameh");
} else {
  $queryh = mysqli_query($connect, "select * from opnameh where noopname='$noopname'");
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
<font size="2"><br>LAPORAN STOCK OPNAME
<br><br></font>

<table table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
<tr>
<th width="30px" height="20"><font size="1" color="black">NO.</th>
<th width="90px"><font size="1" color="black">KODE BARANG</th>
<th width="150px"><font size="1" color="black">NAMA BARANG</th>
<th width="95px"><font size="1" color="black">LOKASI</th>
<th width="80px"><font size="1" color="black">QTY</th>
</tr>';
while ($row = mysqli_fetch_assoc($queryh)) {
  $jumqty = 0;
  $noopname = $row['noopname'];
  $tglopname = date('d-m-Y', strtotime($row['tglopname']));
  $pelaksana = strip_tags($row['pelaksana']);
  $keterangan = strip_tags($row['keterangan']);
  echo '<tr><td width="30px" height="20px" align="left" colspan="5">&nbsp;' . $noopname . ', ' . $tglopname . ', ' . $pelaksana . ', ' . $keterangan . '</td></tr>';
  $queryd = mysqli_query($connect, "select * from opnamed where noopname='$noopname'");
  while ($rowd = mysqli_fetch_assoc($queryd)) {
    $qty = number_format($rowd["qty"], 0, ",", ".");
    $jumqty = $jumqty + $rowd["qty"];
    echo '<tr>
<td width="30px"  align="center">' . $no . '</td>
<td >&nbsp;' . $rowd["kdbarang"] . '</td>
<td >&nbsp;' . $rowd["nmbarang"] . '</td>
<td >&nbsp;' . $rowd["lokasi"] . '</td>
<td  align="right">&nbsp;' . $qty . '&nbsp;</td>
</tr>';
    $no++;
  }
  $jumqty = number_format($jumqty, 0, ",", ".");
  echo '<tr>
<td width="30px" height="20px" colspan="4">' . 'Total' . '</td>
<td width="30px" height="20px" align="right">' . $jumqty . '&nbsp;</td></tr></table>';
}

echo '<font size="1"><left>Tanggal cetak : ' . date("d-m-Y H:i:s a") . '<br>';
