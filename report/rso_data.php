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

if (isset($_POST['check2'])) {
	$tanggal = 'Outstanding s/d ' . $tanggal2;
	$queryh = mysqli_query($connect, "select * from soh where proses='Y' and terima='N' order by tglso");
} else {
	if (isset($_POST['check1'])) {
		$tanggal = 'Semua Periode';
		$queryh = mysqli_query($connect, "select * from soh where proses='Y' order by tglso");
	} else {
		$tanggal = $tanggal1 . ' s/d ' . $tanggal2;
		$queryh = mysqli_query($connect, "select * from soh where proses='Y' and (tglso>='$tgl1' and tglso<='$tgl2') order by tglso");
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
		<font size="2"><br>LAPORAN SALES ORDER
		<br>Tanggal : ' . "$tanggal" . '
		<br><br></font>

		<table table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
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
$grandtotal = 0;
$grandjual = 0;
$grandppn = 0;
$granddiscount = 0;
$no = 1;
while ($row = mysqli_fetch_assoc($queryh)) {
	echo  '<tr>
		<td align=center>' . $no . '</td>' . '
			<td colspan="9" width="573px" height="35px" align="left">&nbsp;' . "No. SO : " . $row["noso"] . ', Tanggal : ' . date('d-m-Y', strtotime($row["tglso"])) . ', No. Invoice : ' . $row["noreferensi"] . ', Biaya Lain : ' . $row["biaya_lain"] . ', Customer : ' . $row["nmcustomer"] . '</td>';
	$noso = $row['noso'];
	if (isset($_POST['check1'])) {
		$tanggal = 'Semua Periode';
		$queryd = mysqli_query($connect, "select soh.noso,soh.tglso,soh.noreferensi,soh.nmcustomer,sod.kdbarang,sod.nmbarang,sod.qty,sod.harga,sod.discount,sod.subtotal from soh inner join sod on soh.noso=sod.noso where soh.proses='Y' and soh.noso='$noso'");
	} else {
		$tanggal = $tanggal1 . ' s/d ' . $tanggal2;
		$queryd = mysqli_query($connect, "select soh.noso,soh.tglso,soh.noreferensi,soh.nmcustomer,sod.kdbarang,sod.nmbarang,sod.qty,sod.harga,sod.discount,sod.subtotal from soh inner join sod on soh.noso=sod.noso where soh.proses='Y' and (soh.tglso>='$tgl1' and soh.tglso<='$tgl2') and sod.noso='$noso'");
	}
	$subtotaljual = 0;
	$subtotalppn = 0;
	$subtotaldiscount = 0;
	$jumsubtotal = 0;
	while ($rowd = mysqli_fetch_assoc($queryd)) {
		//$subtotal_ppn = $rowd['subtotal'] - ($rowd['subtotal'] * ($row['ppn']/100));
		$qty = number_format($rowd['qty'], 2, ",", ".");
		$harga = number_format($rowd['harga'], 0, ",", ".");
		$ndiscount = ($rowd['qty'] * $rowd['harga']) * ($rowd['discount'] / 100);
		$discount = number_format($ndiscount, 0, ",", ".");
		$nppn = (($rowd['qty'] * $rowd['harga']) - $ndiscount) * ($row['ppn'] / 100);
		$ppn = number_format($nppn, 0, ",", ".");
		$harga = number_format($rowd['harga'], 0, ",", ".");
		$nsubtotal = ($rowd['qty'] * $rowd['harga']) - $ndiscount + $nppn;
		$subtotal = number_format($nsubtotal, 0, ",", ".");
		$njual = ($rowd['qty'] * $rowd['harga']);
		$jual = number_format($njual, 0, ",", ".");
		echo  '<tr>
					<td></td>
					<td width="90px" >&nbsp;' . $rowd["kdbarang"] . '</td>
					<td width="200px" >&nbsp;' . $rowd["nmbarang"] . '</td>
					<td width="50px"  align="right">' . $qty . '&nbsp;</td>
					<td width="60px"  align="right">' . $harga . '&nbsp;</td>
					<td width="60px"  align="right">' . $jual . '&nbsp;</td>
					<td width="40px"  align="right">' . $discount . '&nbsp;</td>
					<td width="40px"  align="right">' . $ppn . '&nbsp;</td>
					<td width="70px"  align="right">' . $subtotal . '&nbsp;</td>
				</tr>';
		$grandjual = $grandjual + $njual;
		$grandppn = $grandppn + $nppn;
		$granddiscount = $granddiscount + $ndiscount;
		$subtotaljual = $subtotaljual + $njual;
		$subtotalppn = $subtotalppn + $nppn;
		$subtotaldiscount = $subtotaldiscount + $ndiscount;
		$grandtotal = $grandtotal + $nsubtotal;
		$jumsubtotal = $jumsubtotal + $nsubtotal;
	}
	$subtotaljual = number_format($subtotaljual, 0, ",", ".");
	$subtotalppn = number_format($subtotalppn, 0, ",", ".");
	$subtotaldiscount = number_format($subtotaldiscount, 0, ",", ".");
	$total = number_format($jumsubtotal, 0, ",", ".");
	echo  '<tr><td colspan="5" height="20px" align="left">&nbsp;' . "Total" . '&nbsp;</td>
			<td height="20px" align="right">&nbsp;' . $subtotaljual . '&nbsp;</td>
			<td height="20px" align="right">&nbsp;' . $subtotaldiscount . '&nbsp;</td>
			<td height="20px" align="right">&nbsp;' . $subtotalppn . '&nbsp;</td>
			<td height="20px" align="right">&nbsp;' . $total . '&nbsp;</td>
		</tr>';
	$no++;
}
$grandtotal = number_format($grandtotal, 0, ",", ".");
$grandjual = number_format($grandjual, 0, ",", ".");
$grandppn = number_format($grandppn, 0, ",", ".");
$granddiscount = number_format($granddiscount, 0, ",", ".");
echo  '<tr><td colspan="5" height="20px" align="left">&nbsp;' . "Grand Total" . '&nbsp;</td>
		<td height="20px" align="right">&nbsp;' . $grandjual . '&nbsp;</td>
		<td height="20px" align="right">&nbsp;' . $granddiscount . '&nbsp;</td>
		<td height="20px" align="right">&nbsp;' . $grandppn . '&nbsp;</td>
		<td height="20px" align="right">&nbsp;' . $grandtotal . '&nbsp;</td>
		</tr></table>';

echo '<font size="1"><left>Tanggal cetak : ' . date("d-m-Y H:i:s a") . '<br>';
