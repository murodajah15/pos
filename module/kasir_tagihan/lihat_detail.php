<?php
include "../../inc/config.php";

$nokwitansi = $_POST['kode'];
$query = mysqli_query($connect, "select * from kasir_tagihan where nokwitansi='$nokwitansi'");
$de = mysqli_fetch_assoc($query);
$bank = strip_tags($de['kdbank'] . ' | ' . $de['nmbank']);
$jnskartu = strip_tags($de['kdjnskartu'] . ' | ' . $de['nmjnskartu']);
$nokwitansi = strip_tags($de['nokwitansi']);
$tglkwitansi = strip_tags($de['tglkwitansi']);
$jnskwitansi = strip_tags($de['jnskwitansi']);
$nojual = strip_tags($de['nojual']);
$kdcustomer = strip_tags($de['kdcustomer']);
$nmcustomer = strip_tags($de['nmcustomer']);
$piutang = $de['piutang'];
$bayar = $de['bayar'];
$uang = $de['uang'];
$kembali = $de['kembali'];
$carabayar = strip_tags($de['carabayar']);
$kdbank = strip_tags($de['kdbank']);
$nmbank = strip_tags($de['nmbank']);
$kdjnskartu = strip_tags($de['kdjnskartu']);
$nmjnskartu = strip_tags($de['nmjnskartu']);
$norek = strip_tags($de['norek']);
$nocekgiro = strip_tags($de['nocekgiro']);
$tglterimacekgiro = strip_tags($de['tglterimacekgiro']);
$tgljttempocekgiro = strip_tags($de['tgljttempocekgiro']);
$keterangan = strip_tags($de['keterangan']);
?>
<!-- <table style=font-size:13px; class='table table-striped table table-bordered'>
<tr><td>No. Kwitansi</td> <td> <input type='text' class='form-control' id='nojual' name='nojual' size='50' value="<?= $nokwitansi ?>" autocomplete='off' readonly required>
<tr><td>Tgl. Kwitansi (M-D-Y) </td> <td> <input type='text' class='form-control' id='nojual' name='nojual' size='50' value="<?= $tglkwitansi ?>" autocomplete='off' readonly required>
<tr><td>No. Penjualan</td> <td> <input type='text' class='form-control' id='nojual' name='nojual' size='50' value="<?= $nojual ?>" autocomplete='off' readonly required>
<tr><td>Cara Bayar</td><td><input type='text' class='form-control' id='kdbank' name='kdbank' size='20' autocomplete='off' value="<?= $carabayar ?>" readonly required></td>
<tr><td>Bank</td><td><input type='text' class='form-control' id='kdbank' name='kdbank' size='20' autocomplete='off' value="<?= $bank ?>" readonly required>
<tr><td>Jenis Kartu</td><td> <input type='text' class='form-control' id='kdjnskartu' name='kdjnskartu' size='20'  value="<?= $jnskartu ?>" autocomplete='off' readonly required>
<tr><td>No. Rekening</td> <td> <input type="text" class='form-control' id='norek' name='norek' size='50' value="<?= $norek ?>" readonly></td></tr>
<tr><td>No. Giro/Cek</td> <td> <input type="text" class='form-control' id='nocekgiro' name='nocekgiro' size='50' value="<?= $nocekgiro ?>" readonly></td></tr>
<tr><td>Tgl. Terima Cek (M/D/Y)</td><td><input type='date' class='form-control' id='tglterimacekgiro' name='tglterimacekgiro' value="<?php echo $tglterimacekgiro ?>" size='50' autocomplete='off' required readonly></td></tr>
<tr><td>Tgl. Jt.Tempo Cek (M/D/Y)</td><td><input type='date' class='form-control' id='tgljttempocekgiro' name='tgljttempocekgiro' value="<?php echo $tgljttempocekgiro ?>" size='50' autocomplete='off' required readonly></td></tr>
<tr><td>Keterangan</td><td><textarea type='text' class='form-control' id='kerangan' name='keterangan' autocomplete='off' readonly><?= $keterangan ?></textarea></td></tr>
<tr><td>Proses</td> <td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[proses]'" ?> readonly></td></tr>
<tr><td>User Input</td> <td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[user]'" ?> readonly></td></tr>
<tr><td>User Proses</td> <td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[user_proses]'" ?> readonly></td></tr>
</table> -->

<div class='col-md-6'>
	<table style=font-size:13px; class='table table-striped table table-bordered'>
		<tr>
			<td>No. Kwitansi</td>
			<td> <input type='text' class='form-control' id='nojual' name='nojual' size='50' value="<?= $nokwitansi ?>" autocomplete='off' readonly required>
		<tr>
			<td>Tgl. Kwitansi (M-D-Y) </td>
			<td> <input type='date' class='form-control' id='nojual' name='nojual' size='50' value="<?= $tglkwitansi ?>" autocomplete='off' readonly required>
		<tr>
			<td>No. Penjualan</td>
			<td> <input type='text' class='form-control' id='nojual' name='nojual' size='50' value="<?= $nojual ?>" autocomplete='off' readonly required>
		<tr>
			<td>Cara Bayar</td>
			<td><input type='text' class='form-control' id='kdbank' name='kdbank' size='20' autocomplete='off' value="<?= $carabayar ?>" readonly required></td>
		<tr>
			<td>Bank</td>
			<td><input type='text' class='form-control' id='kdbank' name='kdbank' size='20' autocomplete='off' value="<?= $bank ?>" readonly required>
		<tr>
			<td>Jenis Kartu</td>
			<td> <input type='text' class='form-control' id='kdjnskartu' name='kdjnskartu' size='20' value="<?= $jnskartu ?>" autocomplete='off' readonly required>
		<tr>
			<td>No. Rekening</td>
			<td> <input type="text" class='form-control' id='norek' name='norek' size='50' value="<?= $norek ?>" readonly></td>
		</tr>
	</table>
</div>
<div class='col-md-6'>
	<table style=font-size:13px; class='table table-striped table table-bordered'>
		<tr>
			<td>No. Giro/Cek</td>
			<td> <input type="text" class='form-control' id='nocekgiro' name='nocekgiro' size='50' value="<?= $nocekgiro ?>" readonly></td>
		</tr>
		<tr>
			<td>Tgl. Terima Cek (M/D/Y)</td>
			<td><input type='date' class='form-control' id='tglterimacekgiro' name='tglterimacekgiro' value="<?php echo $tglterimacekgiro ?>" size='50' autocomplete='off' required readonly></td>
		</tr>
		<tr>
			<td>Tgl. Jt.Tempo Cek (M/D/Y)</td>
			<td><input type='date' class='form-control' id='tgljttempocekgiro' name='tgljttempocekgiro' value="<?php echo $tgljttempocekgiro ?>" size='50' autocomplete='off' required readonly></td>
		</tr>
		<tr>
			<td>Keterangan</td>
			<td><textarea type='text' class='form-control' id='kerangan' name='keterangan' autocomplete='off' readonly><?= $keterangan ?></textarea></td>
		</tr>
		<tr>
			<td>Proses</td>
			<td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[proses]'" ?> readonly></td>
		</tr>
		<tr>
			<td>User Input</td>
			<td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[user]'" ?> readonly></td>
		</tr>
		<tr>
			<td>User Proses</td>
			<td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[user_proses]'" ?> readonly></td>
		</tr>
	</table>
</div>
<div class='col-md-12'>
	<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
		<tr>
			<th width='50'>No.</th>
			<th width='170'>No. Jual</th>
			<th>Customer</th>
			<th width='70'>Piutang</th>
			<th width='70'>Bayar</th>
		</tr>
		<?php
		$tampil = mysqli_query($connect, "select * from kasir_tagihand where nokwitansi='$nokwitansi'");
		// $query = $connect->prepare("select * from kasir_tagihand where nokwitansi=?");
		// $query->bind_param('s', $nokwitansi);
		// $query->execute();
		// $result = $query->get_result();
		// $de = $result->fetch_assoc();
		$no = 1;
		//<td><u><a href='?m=wo&tipe=detail&id=$k[id]'><font color='blue'>$k[kode]</font></a></u></td>
		//<td><u><a href='#' onclick =lihat_detail('$k[id]');><font color='blue'>$k[kdbarang]</font></a></u></td>
		while ($k = mysqli_fetch_assoc($tampil)) {
			$nojual = strip_tags($k['nojual']);
			$customer = strip_tags($k['kdcustomer']) . '|' . strip_tags($k['nmcustomer']);
			$piutang = number_format($k['piutang'], 0, ",", ".");
			$bayar = number_format($k['bayar'], 0, ",", ".");
			//$date = date("m/d/Y", strtotime($k['tglwo']));
			echo "<tr><td align='center'>$no</td>
								<td width='90'>$k[nojual]</td>
								<td width='250'>$customer</td>
								<td align='right' width='80'>$piutang</td>
								<td align='right' width='80'>$bayar</td>";
			$no++;
		}
		$tampil = mysqli_query($connect, "select sum(bayar) as total_bayar from kasir_tagihand where nokwitansi='$nokwitansi'");
		$jum = mysqli_fetch_assoc($tampil);
		$total_bayar = $jum['total_bayar'];
		$total_bayar = number_format($total_bayar, 0, ",", ".");
		echo "<tr><td colspan='4'></td>
							<td align='right' style='font-weight:bold'>$total_bayar</td>";
		?>
	</table>
</div>