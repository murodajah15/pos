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
$kdcustomer = $_POST['kdcustomer'];
$kdsales = $_POST['kdsales'];
$no = 1;
if (isset($_POST['semuacustomer'])) { //semua customer
	if (isset($_POST['semuasales'])) { //semua sales
		if (isset($_POST['check2'])) {
			$tanggal = 'Outstanding s/d ' . $tanggal2;
			if ($_POST['pilihanppn'] == 'ppnnonppn') {
				$qry = "select * from jualh where proses='Y' and terima='N' order by tgljual";
			}
			if ($_POST['pilihanppn'] == 'ppn') {
				$qry = "select * from jualh where proses='Y' and terima='N' and ppn>0 order by tgljual";
			}
			if ($_POST['pilihanppn'] == 'nonppn') {
				$qry = "select * from jualh where proses='Y' and terima='N' and ppn=0 order by tgljual";
			}
			$queryh = mysqli_query($connect, $qry);
		} else {
			if (isset($_POST['check1'])) {
				$tanggal = 'Semua Periode';
				if ($_POST['pilihanppn'] == 'ppnnonppn') {
					$qry = "select * from jualh where proses='Y' order by tgljual";
				}
				if ($_POST['pilihanppn'] == 'ppn') {
					$qry = "select * from jualh where proses='Y' and ppn>0 order by tgljual";
				}
				if ($_POST['pilihanppn'] == 'nonppn') {
					$qry = "select * from jualh where proses='Y' and ppn=0 order by tgljual";
				}
				$queryh = mysqli_query($connect, $qry);
			} else {
				$tanggal = $tanggal1 . ' s/d ' . $tanggal2;
				$qry = "select * from jualh where (tgljual>='$tgl1' and tgljual<='$tgl2') and proses='Y' order by tgljual";
				$queryh = mysqli_query($connect, $qry);
				//$jumrec = mysqli_num_rows(mysqli_query($connect,"select * from jualh where (tgljual>='$tgl1' and tgljual<='$tgl2') and proses='Y' order by tgljual"));
				//echo $jumrec;
				//echo $tgl1.'  '.$tgl2;
			}
		}
	} else {
		if (isset($_POST['check2'])) {
			$tanggal = 'Outstanding s/d ' . $tanggal2;
			if ($_POST['pilihanppn'] == 'ppnnonppn') {
				$qry = "select * from jualh where proses='Y' and terima='N' and kdsales='$kdsales' order by tgljual";
			}
			if ($_POST['pilihanppn'] == 'ppn') {
				$qry = "select * from jualh where proses='Y' and terima='N' and kdsales='$kdsales' and ppn>0 order by tgljual";
			}
			if ($_POST['pilihanppn'] == 'nonppn') {
				$qry = "select * from jualh where proses='Y' and terima='N' and kdsales='$kdsales' and ppn=0 order by tgljual";
			}
			$queryh = mysqli_query($connect, $qry);
		} else {
			if (isset($_POST['check1'])) {
				$tanggal = 'Semua Periode';
				$qry = "select * from jualh where proses='Y' and kdsales='$kdsales' order by tgljual";
				$queryh = mysqli_query($connect, $qry);
			} else {
				$tanggal = $tanggal1 . ' s/d ' . $tanggal2;
				if ($_POST['pilihanppn'] == 'ppnonppn') {
					$qry = "select * from jualh where (tgljual>='$tgl1' and tgljual<='$tgl2') and proses='Y' and kdsales='$kdsales' order by tgljual";
				}
				if ($_POST['pilihanppn'] == 'ppn') {
					$qry = "select * from jualh where (tgljual>='$tgl1' and tgljual<='$tgl2') and proses='Y' and kdsales='$kdsales' and ppn>0 order by tgljual";
				}
				if ($_POST['pilihanppn'] == 'nonppn') {
					$qry = "select * from jualh where (tgljual>='$tgl1' and tgljual<='$tgl2') and proses='Y' and kdsales='$kdsales' and ppn=0 order by tgljual";
				}
				$queryh = mysqli_query($connect, $qry);
				// $jumrec = mysqli_num_rows(mysqli_query($connect,"select * from jualh where (tgljual>='$tgl1' and tgljual<='$tgl2') and proses='Y' and kdsales='$kdsales' order by tgljual"));
				// echo $jumrec;
				// echo $kdsales;
				//echo $tgl1.'  '.$tgl2;
			}
		}
	}
} else {
	if (isset($_POST['semuasales'])) { //semua sales
		if (isset($_POST['check2'])) {
			$tanggal = 'Outstanding s/d ' . $tanggal2;
			$qry = "select * from jualh where proses='Y' and terima='N' and kdcustomer='$kdcustomer' order by tgljual";
			$queryh = mysqli_query($connect, $qry);
		} else {
			if (isset($_POST['check1'])) {
				$tanggal = 'Semua Periode';
				if ($_POST['pilihanppn'] == 'ppnnonppn') {
					$qry = "select * from jualh where proses='Y' and kdcustomer='$kdcustomer' order by tgljual";
				}
				if ($_POST['pilihanppn'] == 'ppn') {
					$qry = "select * from jualh where proses='Y' and kdcustomer='$kdcustomer' and ppn>0 order by tgljual";
				}
				if ($_POST['pilihanppn'] == 'nonppn') {
					$qry = "select * from jualh where proses='Y' and kdcustomer='$kdcustomer' and ppn=0 order by tgljual";
				}
				$queryh = mysqli_query($connect, $qry);
			} else {
				$tanggal = $tanggal1 . ' s/d ' . $tanggal2;
				if ($_POST['pilihanppn'] == 'ppnnonppn') {
					$qry = "select * from jualh where (tgljual>='$tgl1' and tgljual<='$tgl2') and proses='Y' and kdcustomer='$kdcustomer' order by tgljual";
				}
				if ($_POST['pilihanppn'] == 'ppn') {
					$qry = "select * from jualh where (tgljual>='$tgl1' and tgljual<='$tgl2') and proses='Y' and kdcustomer='$kdcustomer' and ppn>0 order by tgljual";
				}
				if ($_POST['pilihanppn'] == 'nonppn') {
					$qry = "select * from jualh where (tgljual>='$tgl1' and tgljual<='$tgl2') and proses='Y' and kdcustomer='$kdcustomer' and ppn=0 order by tgljual";
				}
				$queryh = mysqli_query($connect, $qry);
				//echo $tgl1.'  '.$tgl2;
			}
		}
	} else {
		if (isset($_POST['check2'])) {
			$tanggal = 'Outstanding s/d ' . $tanggal2;
			if ($_POST['pilihanppn'] == 'ppnnonppn') {
				$qry = "select * from jualh where proses='Y' and terima='N' and kdcustomer='$kdcustomer' and kdsales='$kdsales' order by tgljual";
			}
			if ($_POST['pilihanppn'] == 'ppn') {
				$qry = "select * from jualh where proses='Y' and terima='N' and kdcustomer='$kdcustomer' and kdsales='$kdsales' and ppn>0 order by tgljual";
			}
			if ($_POST['pilihanppn'] == 'nonppn') {
				$qry = "select * from jualh where proses='Y' and terima='N' and kdcustomer='$kdcustomer' and kdsales='$kdsales' and ppn=0 order by tgljual";
			}
			$queryh = mysqli_query($connect, $qry);
		} else {
			if (isset($_POST['check1'])) {
				$tanggal = 'Semua Periode';
				if ($_POST['pilihanppn'] == 'ppnnonppn') {
					$qry = "select * from jualh where proses='Y' and kdcustomer='$kdcustomer' and kdsales='$kdsales' order by tgljual";
				}
				if ($_POST['pilihanppn'] == 'ppn') {
					$qry = "select * from jualh where proses='Y' and kdcustomer='$kdcustomer' and kdsales='$kdsales' and ppn>0 order by tgljual";
				}
				if ($_POST['pilihanppn'] == 'nonppn') {
					$qry = "select * from jualh where proses='Y' and kdcustomer='$kdcustomer' and kdsales='$kdsales' and ppn=0 order by tgljual";
				}
				$queryh = mysqli_query($connect, $qry);
			} else {
				$tanggal = $tanggal1 . ' s/d ' . $tanggal2;
				if ($_POST['pilihanppn'] == 'ppnnonppn') {
					$qry = "select * from jualh where (tgljual>='$tgl1' and tgljual<='$tgl2') and proses='Y' and kdcustomer='$kdcustomer' and kdsales='$kdsales' order by tgljual";
				}
				if ($_POST['pilihanppn'] == 'ppn') {
					$qry = "select * from jualh where (tgljual>='$tgl1' and tgljual<='$tgl2') and proses='Y' and kdcustomer='$kdcustomer' and kdsales='$kdsales' and ppn>0 order by tgljual";
				}
				if ($_POST['pilihanppn'] == 'nonppn') {
					$qry = "select * from jualh where (tgljual>='$tgl1' and tgljual<='$tgl2') and proses='Y' and kdcustomer='$kdcustomer' and kdsales='$kdsales' and ppn=0 order by tgljual";
				}
				$queryh = mysqli_query($connect, $qry);
				//echo $tgl1.'  '.$tgl2;
			}
		}
	}
}

$cek = mysqli_num_rows($queryh);
if (empty($cek)) {
	echo '<script>alert(\'Tidak ada data sesuai kriteria\')
 window.close()</script>';
}
// echo $qry;

if ($_POST['kdcustomer'] == "") {
	$customer = 'Semua Customer';
} else {
	$customer = $_POST['nmcustomer'];
}
if ($_POST['kdsales'] == "") {
	$sales = 'Semua Sales';
} else {
	$sales = $_POST['nmsales'];
}
echo '<style>
				td { border: 0.5px solid grey; margin: 5px;}
	            th { border: 0.5px solid grey; font-weight:normal;}
	            body { font-family: comic sans ms;}
			</style>
		<font size="3" face="comic sans ms">
		' . "$nm_perusahaan" . '</font>
		<br>' . '<font size="1" face="comic sans ms">' . "$alamat_perusahaan" . '
		<br>' . "$telp_perusahaan" . '</font>
		<font size="1" face="comic sans ms"><br>
		<font size="2"><br>REPORT DAFTAR PENJUALAN
		<br>Tanggal : ' . "$tanggal" . '
		<br>Customer : ' . $customer . '
		<br>Sales : ' . $sales . '
		</font>
		<font size="1" face="comic sans ms"><br><br>';

if (isset($_POST['rincian'])) {
	echo '<table table-layout="fixed"; cellpadding="2"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
		<tr>
			<th width="30px" height="20"><font size="1" color="black">NO.</th>
			<th width="75px"><font size="1" color="black">KODE BARANG</th>
			<th width="250px"><font size="1" color="black">NAMA BARANG</th>
			<th width="70px"><font size="1" color="black">QTY</th>
			<th width="100px"><font size="1" color="black">HARGA</th>
			<th width="100px"><font size="1" color="black">SUBTOTAL</th>
			<th width="90px"><font size="1" color="black">DISC.</th>
			<th width="90px"><font size="1" color="black">PPN</th>
			<th width="100px"><font size="1" color="black">TOTAL</th>
		</tr>';

	$no = 1;
	$gtsubtotal = 0;
	$gtdiscount = 0;
	$gtppn = 0;
	$gttotal = 0;
	while ($row = mysqli_fetch_assoc($queryh)) {
		$tgljual = date('d-m-Y', strtotime($row['tgljual']));
		$nojual = $row['nojual'];
		$ppn = $row['ppn'];
		$gsubtotal = 0;
		$gdiscount = 0;
		$gppn = 0;
		$gtotal = 0;
		echo '<tr>
    	<td height="10px" align="center">&nbsp;' . $no . '</td>
    	<td height="10px" colspan=8>&nbsp;' . $row["nojual"] . ', ' . $tgljual . ' ,' . $row["noinvoice"] . ', ' . $row["kdcustomer"] . ', ' . $row["nmcustomer"] . '</td>';
		$queryd = mysqli_query($connect, "select * from juald where nojual='$nojual'");
		while ($detail = mysqli_fetch_assoc($queryd)) {
			$harga = number_format($detail['harga'], 2, ",", ".");
			$subtotal = $detail['harga'] * $detail['qty'];
			$subtotalf = number_format($subtotal, 2, ",", ".");
			$discount = $subtotal * ($detail['discount'] / 100);
			$discountf = number_format($discount, 2, ",", ".");
			$nppn = ($subtotal - $discount) * ($ppn / 100);
			$nppnf = number_format($nppn, 2, ",", ".");
			$total = $subtotal - $discount + $nppn;
			$totalf = number_format($total, 2, ",", ".");
			echo '<tr>
    				<td></td>
    				<td height="10px" align="left">' . $detail["kdbarang"] . '</td>
    				<td height="10px" align="left">' . $detail["nmbarang"] . '</td>
    				<td height="10px" align="right">' . $detail["qty"] . '</td>
    				<td height="10px" align="right">' . $harga  . '</td>
    				<td height="10px" align="right">' . $subtotalf  . '</td>
    				<td height="10px" align="right">' . $discountf  . '</td>
    				<td height="10px" align="right">' . $nppnf  . '</td>
    				<td height="10px" align="right">' . $totalf  . '</td>';
			$gsubtotal = $gsubtotal + $detail['subtotal'];
			$gdiscount = $gdiscount + $discount;
			$gppn = $gppn + $nppn;
			$gtotal = $gtotal + $total;
		}
		$gsubtotalf = number_format($gsubtotal, 2, ",", ".");
		$gdiscountf = number_format($gdiscount, 2, ",", ".");
		$gppnf = number_format($gppn, 2, ",", ".");
		$gtotalf = number_format($gtotal, 2, ",", ".");
		$gtsubtotal = $gtsubtotal + $gsubtotal;
		$gtdiscount = $gtdiscount + $gdiscount;
		$gtppn = $gtppn + $gppn;
		$gttotal = $gttotal + $gtotal;
		echo '<tr>
    	<td></td>
    	<td height="10px" colspan=4 align="right">&nbsp;' . 'Total &nbsp;</td>' . '<td align="right">' . $gsubtotalf . '</td>' . '<td align="right">' . $gdiscountf .
			'</td>' . '<td align="right">' . $gppnf . '</td>' . '<td align="right">' . $gtotalf . '</td>';
		$no++;
	}
	$gtsubtotalf = number_format($gtsubtotal, 2, ",", ".");
	$gtdiscountf = number_format($gtdiscount, 2, ",", ".");
	$gtppnf = number_format($gtppn, 2, ",", ".");
	$gttotalf = number_format($gttotal, 2, ",", ".");
	echo '<tr>
    <td></td>
    <td height="10px" colspan=4>&nbsp;' . 'Grand Total &nbsp;</td>' . '<td align="right">' . $gtsubtotalf . '</td>' . '<td align="right">' . $gtdiscountf .
		'</td>' . '<td align="right">' . $gtppnf . '</td>' . '<td align="right">' . $gttotalf .
		'</td></table><br>';
} else {
	echo '<table table-layout="fixed"; cellpadding="2"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
	<tr>
		<th width="30px" height="20"><font size="1" color="black">NO.</th>
		<th width="75px"><font size="1" color="black">NOMOR</th>
		<th width="80px"><font size="1" color="black">TANGGAL</th>
		<th width="90px"><font size="1" color="black">KD. CUSTOMER</th>
		<th width="250px"><font size="1" color="black">CUSTOMER</th>
		<th width="90px"><font size="1" color="black">CARA BAYAR</th>
		<th width="90px"><font size="1" color="black">SUBTOTAL</th>
		<th width="90px"><font size="1" color="black">PPN</th>
		<th width="100px"><font size="1" color="black">TOTAL</th>
	</tr>';

	$no = 1;
	$gtsubtotal = 0;
	$gtdiscount = 0;
	$gtppn = 0;
	$gttotal = 0;
	while ($row = mysqli_fetch_assoc($queryh)) {
		$tgljual = date('d-m-Y', strtotime($row['tgljual']));
		$nojual = $row['nojual'];
		$ppn = $row['ppn'];
		$rp_ppn = $row['total_sementara'] * ($ppn / 100);
		$subtotal = $row['subtotal'];
		$total = $row['total'];
		$subtotalf = number_format($subtotal, 0, ",", ".");
		$rp_ppnf = number_format($rp_ppn, 0, ",", ".");
		$totalf = number_format($total, 0, ",", ".");
		echo '<tr>
    	<td height="10px" align="center">&nbsp;' . $no . '</td>
		<td height="10px">' . $nojual . '</td>
		<td height="10px">' . $tgljual . '</td>
		<td height="10px">' . $row["kdcustomer"] . '</td>
		<td height="10px">' . $row["nmcustomer"] . '</td>
		<td height="10px">' . $row["carabayar"] . '</td>
		<td height="10px" align="right">' . $subtotalf . '</td>
		<td height="10px" align="right">' . $rp_ppnf . '</td>
		<td height="10px" align="right">' . $totalf . '</td>';
		$no++;
	}
	echo '</table>';
}

echo '<font size="1"><left>Tanggal cetak : ' . date("d-m-Y H:i:s a") . '<br>';
