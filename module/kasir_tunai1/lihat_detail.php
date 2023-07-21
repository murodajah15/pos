<?php
	include "../../inc/config.php";

	$nokwitansi=$_POST['kode'];
	$query = mysqli_query($connect,"select * from kasir_tunai where nokwitansi='$nokwitansi'");
	$de=mysqli_fetch_assoc($query);
	$bank = strip_tags($de['kdbank'].' | '.$de['nmbank']);
	$jnskartu = strip_tags($de['kdjnskartu'].' | '.$de['nmjnskartu']);
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
<table style=font-size:13px; class='table table-striped table table-bordered'>
<tr><td>No. Kwitansi</td> <td> <input type='text' class='form-control' id='nojual' name='nojual' size='50' value="<?= $nokwitansi ?>" autocomplete='off' readonly required>
<tr><td>Tgl. Kwitansi (M-D-Y) </td> <td> <input type='text' class='form-control' id='nojual' name='nojual' size='50' value="<?= $tglkwitansi ?>" autocomplete='off' readonly required>
<tr><td>No. Penjualan</td> <td> <input type='text' class='form-control' id='nojual' name='nojual' size='50' value="<?= $nojual ?>" autocomplete='off' readonly required>
<tr><td>Customer</td> <td> <input type="text" class='form-control' id='nmcustomer' name='nmcustomer' size='50' value="<?= $nmcustomer ?>" readonly required></td></tr>
<tr><td>Nilai Piutang</td> <td align='right'> <input type="number" class='form-control' id='piutang' name='piutang' size='50' value="<?= $piutang ?>" style='text-align:right' readonly required></td></tr>
<tr><td>Nilai Bayar</td> <td align='right'> <input type="number" class='form-control' id='bayar' name='bayar' size='50' value="<?= $bayar ?>" style='text-align:right' onkeyup="hit_subtotal()" onblur="hit_subtotal()" required readonly></td></tr>
<tr><td>Uang diterima </td> <td> <input type="number" class='form-control' id='uang' name='uang' size='65' value="<?= $uang ?>" style='text-align:right' onkeyup="hit_subtotal()" onblur="hit_subtotal()" required readonly></td>
<tr><td>Kembali </td> <td> <input type="number" class='form-control' id='kembali' name='kembali' size='35' value="<?= $kembali ?>" style='text-align:right' readonly required></td>
<tr><td>Cara Bayar</td><td><input type='text' class='form-control' id='kdbank' name='kdbank' size='20' autocomplete='off' value="<?= $carabayar ?>" readonly required></td>
<tr><td>Bank</td><td><input type='text' class='form-control' id='kdbank' name='kdbank' size='20' autocomplete='off' value="<?= $bank ?>" readonly required>
<tr><td>Jenis Kartu</td><td> <input type='text' class='form-control' id='kdjnskartu' name='kdjnskartu' size='20'  value="<?= $jnskartu ?>" autocomplete='off' readonly required>
<tr><td>No. Rekening</td> <td> <input type="text" class='form-control' id='norek' name='norek' size='50' value="<?= $norek ?>" readonly></td></tr>
<tr><td>No. Giro/Cek</td> <td> <input type="text" class='form-control' id='nocekgiro' name='nocekgiro' size='50' value="<?= $nocekgiro ?>" readonly></td></tr>
<tr><td>Tgl. Terima Cek (M/D/Y)</td><td><input type='date' class='form-control' id='tglterimacekgiro' name='tglterimacekgiro' value="<?php echo $tglterimacekgiro ?>" size='50' autocomplete='off' required readonly></td></tr>
<tr><td>Tgl. Jt.Tempo Cek (M/D/Y)</td><td><input type='date' class='form-control' id='tgljttempocekgiro' name='tgljttempocekgiro' value="<?php echo $tgljttempocekgiro ?>" size='50' autocomplete='off' required readonly></td></tr>
<tr><td>Keterangan</td><td><textarea type='text' class='form-control' id='kerangan' name='keterangan' autocomplete='off' readonly><?= $keterangan ?></textarea></td></tr>
<tr><td>Proses</td> <td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[proses]'"?> readonly></td></tr>
<tr><td>User Input</td> <td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[user]'"?> readonly></td></tr>
<tr><td>User Proses</td> <td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[user_proses]'"?> readonly></td></tr>
</table>

