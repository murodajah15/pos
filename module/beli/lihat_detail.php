<?php
include "../../inc/config.php";

$nobeli = $_POST['kode'];
$query = mysqli_query($connect, "select * from belih where nobeli='$nobeli'");
$de = mysqli_fetch_assoc($query);
$supplier = strip_tags($de['kdsupplier'] . ' | ' . $de['nmsupplier']);
?>
<!-- <table style=font-size:13px; class='table table-striped table table-bordered'>
<tr><td>No. Pembelian</td> <td> <input type=text class='form-control' name='noajukan' value=<?php echo "'$de[nobeli]'" ?> readonly></td></tr>
<tr><td>Tgl. Pembelian</td> <td> <input type=text class='form-control' name='tglajukan' value=<?php echo "'$de[tglbeli]'" ?> readonly></td></tr>
<tr><td>Kode Supplier</td> <td> <input type=text class='form-control' name='norangka' value=<?php echo "'$supplier'" ?> readonly></td></tr>
<tr><td>Jenis Order</td> <td> <input type=text class='form-control' name='jenis_order' value=<?php echo "'$de[jenis_order]'" ?> readonly></td></tr>
<tr><td>Biaya Lain</td> <td> <input type=text class='form-control' name='biaya_lain' value=<?php echo "'$de[biaya_lain]'" ?> readonly></td></tr>
<tr><td>Keterangan Biaya Lain</td> <td> <input type=text class='form-control' name='ket_biaya_lain' value=<?php echo "'$de[ket_biaya_lain]'" ?> readonly></td></tr>
<tr><td>Tanggal Kirim<br>(M/D/Y)</br></td> <td> <input type="date" class='form-control' name='tglkirim' size='50' value='<?= $de['tglkirim'] ?>'></td></tr>
<tr><td>Cara Bayar</br></td> <td> <input type="text" class='form-control' name='carabayar' size='50' value='<?= $de['carabayar'] ?>'></td></tr>
<tr><td>Tempo (Hari)</td> <td> <input type="number" class='form-control' name='tempo' value='<?= $tempo ?>' size='50'></td></tr>	
<tr><td>Tanggal Jatuh Tempo<br>(M/D/Y)</br></td> <td> <input type="date" class='form-control' name='tgl_jt_tempo' value='<?= $de['tgl_jt_tempo'] ?>' size='50'></td></tr>
<tr><td>Subtotal</td> <td> <input type="number" class='form-control' id='ppn' name='ppn' size='50' value='<?= $de['subtotal'] ?>' readonly></td></tr>
<tr><td>Total Sementara</td> <td> <input type="number" class='form-control' id='ppn' name='ppn' size='50' value='<?= $de['total_sementara'] ?>' readonly></td></tr>
<tr><td>PPn</td> <td> <input type="number" class='form-control' name='ppn' size='50' value='<?= $de['ppn'] ?>'></td></tr>
<tr><td>Materai</td> <td> <input type="number" class='form-control' name='materai' size='50' value='<?= $de['materai'] ?>'></td></tr>							
<tr><td>Total</td> <td> <input type="number" class='form-control' name='total' size='50' value='<?= $de['total'] ?>' readonly></td></tr>
<tr><td>Keterangan</td> <td> <textarea type='text' rows='2' class='form-control' name='tahun' readonly><?php echo "$de[keterangan]" ?></textarea></td></tr>
<tr><td>Proses</td> <td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[proses]'" ?> readonly></td></tr>
<tr><td>User Input</td> <td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[user]'" ?> readonly></td></tr>
<tr><td>User Proses</td> <td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[user_proses]'" ?> readonly></td></tr>
</table> -->

<div class='col-md-6'>
	<table style=font-size:12px; class='table table-striped table table-bordered' width='100px'>
		<tr>
			<td>No. Pembelian</td>
			<td> <input type=text class='form-control' name='noajukan' value=<?php echo "'$de[nobeli]'" ?> readonly></td>
		</tr>
		<tr>
			<td>Tgl. Pembelian</td>
			<td> <input type=date class='form-control' name='tglajukan' value=<?php echo "'$de[tglbeli]'" ?> readonly></td>
		</tr>
		<tr>
			<td>Kode Supplier</td>
			<td> <input type=text class='form-control' name='norangka' value=<?php echo "'$supplier'" ?> readonly></td>
		</tr>
		<tr>
			<td>Jenis Order</td>
			<td> <input type=text class='form-control' name='jenis_order' value=<?php echo "'$de[jenis_order]'" ?> readonly></td>
		</tr>
		<tr>
			<td>Biaya Lain</td>
			<td> <input type=text class='form-control' name='biaya_lain' value=<?php echo "'$de[biaya_lain]'" ?> readonly></td>
		</tr>
		<tr>
			<td>Keterangan Biaya Lain</td>
			<td> <input type=text class='form-control' name='ket_biaya_lain' value=<?php echo "'$de[ket_biaya_lain]'" ?> readonly></td>
		</tr>
		<tr>
			<td>Tanggal Kirim<br>(M/D/Y)</br></td>
			<td> <input type="date" class='form-control' name='tglkirim' size='50' value='<?= $de['tglkirim'] ?>'></td>
		</tr>
		<tr>
			<td>Cara Bayar</br></td>
			<td> <input type="text" class='form-control' name='carabayar' size='50' value='<?= $de['carabayar'] ?>'></td>
		</tr>
		<tr>
			<td>Tempo (Hari)</td>
			<td> <input type="number" class='form-control' name='tempo' value='<?= $tempo ?>' size='50'></td>
		</tr>
		<tr>
			<td>Tanggal Jatuh Tempo<br>(M/D/Y)</br></td>
			<td> <input type="date" class='form-control' name='tgl_jt_tempo' value='<?= $de['tgl_jt_tempo'] ?>' size='50'></td>
		</tr>
	</table>
</div>
<div class='col-md-6'>
	<table style=font-size:12px; class='table table-striped table table-bordered' width='100px'>
		<tr>
			<td>Subtotal</td>
			<td> <input type="number" class='form-control' id='ppn' name='ppn' size='50' value='<?= $de['subtotal'] ?>' readonly></td>
		</tr>
		<tr>
			<td>Total Sementara</td>
			<td> <input type="number" class='form-control' id='ppn' name='ppn' size='50' value='<?= $de['total_sementara'] ?>' readonly></td>
		</tr>
		<tr>
			<td>PPn</td>
			<td> <input type="number" class='form-control' name='ppn' size='50' value='<?= $de['ppn'] ?>'></td>
		</tr>
		<tr>
			<td>Materai</td>
			<td> <input type="number" class='form-control' name='materai' size='50' value='<?= $de['materai'] ?>'></td>
		</tr>
		<tr>
			<td>Total</td>
			<td> <input type="number" class='form-control' name='total' size='50' value='<?= $de['total'] ?>' readonly></td>
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
<div class="col-md-12">
	<div class="table-responsive">
		<table class="table table-bordered table-striped table-hover">
			<tr>
				<th width='50'>No.</th>
				<th width='100'>No. Order</th>
				<th width='170'>Kode Barang</th>
				<th>Nama Barang</th>
				<th width='70'>Satuan</th>
				<th>QTY</th>
				<th>harga</th>
				<th>Discount</th>
				<th>Subtotal</th>
			</tr>
			<?php
			$tampil = mysqli_query($connect, "select * from belid where nobeli='$nobeli'");
			$query = $connect->prepare("select * from belid where nobeli=?");
			$query->bind_param('s', $nobeli);
			$query->execute();
			$result = $query->get_result();
			$de = $result->fetch_assoc();
			$nopo = strip_tags($de['nopo']);
			$no = 1;
			//<td><u><a href='#' onclick =lihat_detail('$k[id]');><font color='blue'>$k[nopo]</font></a></u></td>
			// <td><input type='number' name='qty' id='qty' value='$k[qty]' style='text-align: right; width: 6em' onkeyup='hitung_subtotal_belih()'></td>

			while ($k = mysqli_fetch_assoc($tampil)) {
				//$date = date("m/d/Y", strtotime($k['tglwo']));
				$kdbarang = strip_tags($k['kdbarang']);
				$nmbarang = strip_tags($k['nmbarang']);
				$qty = number_format($k['qty'], 2, ",", ".");
				$harga = number_format($k['harga'], 0, ",", ".");
				$discount = number_format($k['discount'], 2, ",", ".");
				$subtotal = number_format($k['subtotal'], 0, ",", ".");
				echo "<tr><td align='center'>$no</td>
								<td width='100'>$k[nopo]</td>
								<td width='100'>$k[kdbarang]</td>
								<td width='300'>$k[nmbarang]</td>
								<td width='10'>$k[kdsatuan]</td>
								<td align='right'>$qty</td>
								<td align='right'>$harga</td>
								<td align='right'>$discount</td>
								<td align='right'>$subtotal</td>";
				$no++;
			}
			$tampil = mysqli_query($connect, "select sum(qty) as total_qty,sum(subtotal) as total_subtotal from belid where nobeli='$nobeli'");
			$jum = mysqli_fetch_assoc($tampil);
			$total_qty = $jum['total_qty'];
			$total_qty = number_format($total_qty, 2, ",", ".");
			$total = $jum['total_subtotal'];
			$total = number_format($total, 0, ",", ".");
			echo "<tr><td colspan='5'></td>
							<td align='right' style='font-weight:bold'>$total_qty</td>
							<td align='right' colspan='3' style='font-weight:bold'>$total</td>";
			?>
		</table>
	</div>
</div>