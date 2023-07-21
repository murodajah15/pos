<?php
include "../../inc/config.php";

$nokeluar = $_POST['kode'];
$query = mysqli_query($connect, "select * from keluarh where nokeluar='$nokeluar'");
$de = mysqli_fetch_assoc($query);
?>
<!-- <table style=font-size:13px; class='table table-striped table table-bordered'>
<tr><td>No. keluar</td> <td> <input type=text class='form-control' name='noajukan' value=<?php echo "'$de[nokeluar]'" ?> readonly></td></tr>
<tr><td>Tgl. keluar</td> <td> <input type=text class='form-control' name='tglajukan' value=<?php echo "'$de[tglkeluar]'" ?> readonly></td></tr>
<tr><td>No. Referensi</td> <td> <input type=text class='form-control' name='nopolisi' value=<?php echo "'$de[noreferensi]'" ?> readonly></td></tr>
<tr><td>Tgl. Dokumen</td> <td> <input type=text class='form-control' name='nopolisi' value=<?php echo "'$de[tgldokumen]'" ?> readonly></td></tr>
<tr><td>Jenis Transaksi</td> <td> <input type=text class='form-control' name='nopolisi' value=<?php echo "'$de[kdjntrans]'" ?> readonly></td></tr>
<tr><td>Penerima</td> <td> <input type=text class='form-control' name='nopolisi' value=<?php echo "'$de[penerima]'" ?> readonly></td></tr>
<tr><td>Gudang</td> <td> <input type=text class='form-control' name='jenis_order' value=<?php echo "'$de[kdgudang]'" ?> readonly></td></tr>
<tr><td>Biaya Lain</td> <td> <input type=text class='form-control' name='biaya_lain' value=<?php echo "'$de[biaya_lain]'" ?> readonly></td></tr>
<tr><td>Keterangan</td> <td> <textarea type='text' rows='2' class='form-control' name='tahun' readonly><?php echo "$de[keterangan]" ?></textarea></td></tr>
<tr><td>Proses</td> <td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[proses]'" ?> readonly></td></tr>
<tr><td>User Input</td> <td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[user]'" ?> readonly></td></tr>
<tr><td>User Proses</td> <td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[user_proses]'" ?> readonly></td></tr>
</table> -->

<div class='col-md-6'>
	<table style=font-size:12px; class='table table-striped table table-bordered' width='100px'>
		<tr>
			<td>No. keluar</td>
			<td> <input type=text class='form-control' name='noajukan' value=<?php echo "'$de[nokeluar]'" ?> readonly></td>
		</tr>
		<tr>
			<td>Tgl. keluar</td>
			<td> <input type=text class='form-control' name='tglajukan' value=<?php echo "'$de[tglkeluar]'" ?> readonly></td>
		</tr>
		<tr>
			<td>No. Referensi</td>
			<td> <input type=text class='form-control' name='nopolisi' value=<?php echo "'$de[noreferensi]'" ?> readonly></td>
		</tr>
		<tr>
			<td>Tgl. Dokumen</td>
			<td> <input type=text class='form-control' name='nopolisi' value=<?php echo "'$de[tgldokumen]'" ?> readonly></td>
		</tr>
		<tr>
			<td>Jenis Transaksi</td>
			<td> <input type=text class='form-control' name='nopolisi' value=<?php echo "'$de[kdjntrans]'" ?> readonly></td>
		</tr>
		<tr>
			<td>Gudang</td>
			<td> <input type=text class='form-control' name='jenis_order' value=<?php echo "'$de[kdgudang]'" ?> readonly></td>
		</tr>
	</table>
</div>
<div class='col-md-6'>
	<table style=font-size:12px; class='table table-striped table table-bordered' width='100px'>
		<tr>
			<td>Biaya Lain</td>
			<td> <input type=text class='form-control' name='biaya_lain' value=<?php echo "'$de[biaya_lain]'" ?> readonly></td>
		</tr>
		<tr>
			<td>Keterangan</td>
			<td> <textarea type='text' rows='2' class='form-control' name='tahun' readonly><?php echo "$de[keterangan]" ?></textarea></td>
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
			<th width='170'>Kode Barang</th>
			<th>Nama Barang</th>
			<th>Satuan</th>
			<th>QTY</th>
			<th>harga</th>
			<th>Subtotal</th>
		</tr>
		<?php
		$tampil = mysqli_query($connect, "select * from keluard where nokeluar='$nokeluar'");
		$query = $connect->prepare("select * from keluard where nokeluar=?");
		$query->bind_param('s', $nokeluar);
		$query->execute();
		$result = $query->get_result();
		$de = $result->fetch_assoc();
		$no = 1;
		//<td><u><a href='?m=wo&tipe=detail&id=$k[id]'><font color='blue'>$k[kode]</font></a></u></td>
		while ($k = mysqli_fetch_assoc($tampil)) {
			//$date = date("m/d/Y", strtotime($k['tglwo']));
			$kdbarang = strip_tags($de['kdbarang']);
			$nmbarang = strip_tags($de['nmbarang']);
			$qty = number_format($k['qty'], 2, ",", ".");
			$harga = number_format($k['harga'], 0, ",", ".");
			$subtotal = number_format($k['subtotal'], 0, ",", ".");
			echo "<tr><td align='center'>$no</td>
								<td><u><a href='#' onclick =lihat_detail('$k[id]');><font color='blue'>$k[kdbarang]</font></a></u></td>
								<td width='300'>$k[nmbarang]</td>
								<td width='80'>$k[kdsatuan]</td>
								<td align='right'>$qty</td>
								<td align='right'>$harga</td>
								<td align='right'>$subtotal</td>";
			$no++;
		}
		$tampil = mysqli_query($connect, "select sum(qty) as total_qty,sum(subtotal) as total_subtotal from keluard where nokeluar='$nokeluar'");
		$jum = mysqli_fetch_assoc($tampil);
		$total_qty = $jum['total_qty'];
		$total_qty = number_format($total_qty, 2, ",", ".");
		$total = $jum['total_subtotal'];
		$total = number_format($total, 0, ",", ".");
		echo "<tr><td colspan='4'></td>
							<td align='right' style='font-weight:bold'>$total_qty</td>
							<td colspan='1' align='right'></td>
							<td align='right' style='font-weight:bold'>$total</td>";
		?>
	</table>
</div>