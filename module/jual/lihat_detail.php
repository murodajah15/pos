<?php
include "../../inc/config.php";

$nojual = $_POST['kode'];
$query = mysqli_query($connect, "select * from jualh where nojual='$nojual'");
$de = mysqli_fetch_assoc($query);
$customer = strip_tags($de['kdcustomer'] . ' | ' . $de['nmcustomer']);
?>
<!-- <table style=font-size:13px; class='table table-striped table table-bordered'>
<tr><td>No. Penjualan</td> <td> <input type=text class='form-control' name='noajukan' value=<?php echo "'$de[nojual]'" ?> readonly></td></tr>
<tr><td>Tgl. Penjualan</td> <td> <input type=text class='form-control' name='tglajukan' value=<?php echo "'$de[tgljual]'" ?> readonly></td></tr>
<tr><td>No. Surat Jalan</td> <td> <input type=text class='form-control' name='noajukan' value=<?php echo "'$de[nosrtjln]'" ?> readonly></td></tr>
<tr><td>Tgl. Surat Jalan</td> <td> <input type=text class='form-control' name='tglajukan' value=<?php echo "'$de[tglsrtjln]'" ?> readonly></td></tr>
<tr><td>Customer</td> <td> <input type=text class='form-control' name='norangka' value=<?php echo "'$customer'" ?> readonly></td></tr>
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
<tr><td>Sudah Bayar</td> <td> <input type='number' class='form-control' name='tahun' value=<?php echo "$de[sudahbayar]" ?> readonly></td></tr>
<tr><td>Kurang Bayar</td> <td> <input type='text' class='form-control' name='tahun' value=<?php echo "$de[kurangbayar]" ?> readonly></td></tr>
<tr><td>Keterangan</td> <td> <textarea type='text' rows='2' class='form-control' name='tahun' readonly><?php echo "$de[keterangan]" ?></textarea></td></tr>
<tr><td>Proses</td> <td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[proses]'" ?> readonly></td></tr>
<tr><td>User Input</td> <td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[user]'" ?> readonly></td></tr>
<tr><td>User Proses</td> <td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[user_proses]'" ?> readonly></td></tr>
</table> -->

<div class='col-md-6'>
	<table style=font-size:13px; class='table table-striped table table-bordered'>
		<tr>
			<td>No. Penjualan</td>
			<td> <input type=text class='form-control' name='noajukan' value=<?php echo "'$de[nojual]'" ?> readonly></td>
		</tr>
		<tr>
			<td>Tgl. Penjualan</td>
			<td> <input type="date" class='form-control' name='tglajukan' value=<?php echo "'$de[tgljual]'" ?> readonly></td>
		</tr>
		<tr>
			<td>No. Surat Jalan</td>
			<td> <input type=text class='form-control' name='noajukan' value=<?php echo "'$de[nosrtjln]'" ?> readonly></td>
		</tr>
		<tr>
			<td>Tgl. Surat Jalan</td>
			<td> <input type="date" class='form-control' name='tglajukan' value=<?php echo "'$de[tglsrtjln]'" ?> readonly></td>
		</tr>
		<tr>
			<td>Customer</td>
			<td> <input type=text class='form-control' name='norangka' value=<?php echo "'$customer'" ?> readonly></td>
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
			<td> <input type="date" class='form-control' name='tglkirim' size='50' value='<?= $de['tglkirim'] ?>' readonly></td>
		</tr>
		<tr>
			<td>Gudang</td>
			<td> <input type="text" class='form-control' name='tglkirim' size='50' value='<?= $de['kdgudang'] . '|' . $de['nmgudang'] ?>' readonly></td>
		</tr>
		<tr>
			<td>Sales</td>
			<td> <input type="text" class='form-control' name='tglkirim' size='50' value='<?= $de['kdsales'] . '|' . $de['nmsales'] ?>' readonly></td>
		</tr>
		<tr>
			<td>Cara Bayar</br></td>
			<td> <input type="text" class='form-control' name='carabayar' size='50' value='<?= $de['carabayar'] ?>' readonly></td>
		</tr>
	</table>
</div>
<div class='col-md-6'>
	<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
		<tr>
			<td>Tempo (Hari)</td>
			<td> <input type="number" class='form-control' name='tempo' value='<?= $tempo ?>' size='50' readonly></td>
		</tr>
		<tr>
			<td>Tanggal Jatuh Tempo<br>(M/D/Y)</br></td>
			<td> <input type="date" class='form-control' name='tgl_jt_tempo' value='<?= $de['tgl_jt_tempo'] ?>' size='50' readonly></td>
		</tr>

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
			<td> <input type="number" class='form-control' name='ppn' size='50' value='<?= $de['ppn'] ?>' readonly></td>
		</tr>
		<tr>
			<td>Materai</td>
			<td> <input type="number" class='form-control' name='materai' size='50' value='<?= $de['materai'] ?>' readonly></td>
		</tr>
		<tr>
			<td>Total</td>
			<td> <input type="number" class='form-control' name='total' size='50' value='<?= $de['total'] ?>' readonly></td>
		</tr>
		<tr>
			<td>Sudah Bayar</td>
			<td> <input type='number' class='form-control' name='tahun' value=<?php echo "$de[sudahbayar]" ?> readonly></td>
		</tr>
		<tr>
			<td>Kurang Bayar</td>
			<td> <input type='text' class='form-control' name='tahun' value=<?php echo "$de[kurangbayar]" ?> readonly></td>
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
		<table class="table table-bordered table-striped table-hover" id="tbl-detail-jual">
			<thead>
				<tr>
					<th width='50'>No.</th>
					<th width='100'>No. SO</th>
					<th width='170'>Kode Barang</th>
					<th>Nama Barang</th>
					<th width='70'>Satuan</th>
					<th>QTY</th>
					<th>harga</th>
					<th>Disc.(%)</th>
					<th>Subtotal</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$tampil = mysqli_query($connect, "select * from juald where nojual='$nojual'");
				// $query = $connect->prepare("select * from juald where nojual=?");
				// $query->bind_param('s', $data['nojual']);
				// $query->execute();
				// $result = $query->get_result();
				// $de = $result->fetch_assoc();
				// $noso = strip_tags($de['noso']);
				$no = 1;
				//<td><u><a href='#' onclick =lihat_detail('$k[id]');><font color='blue'>$k[noso]</font></a></u></td>
				while ($k = mysqli_fetch_assoc($tampil)) {
					$kdbarang = strip_tags($k['kdbarang']);
					$nmbarang = strip_tags($k['nmbarang']);
					$qty = strip_tags($k['qty']);
					$harga = number_format($k['harga'], 0, ",", ".");
					$discount = strip_tags($k['discount']);
					$subtotal = number_format($k['subtotal'], 0, ",", ".");
					//$date = date("m/d/Y", strtotime($k['tglwo']));
					echo "<tr><td align='center'>$no</td>
							<td width='100'>$k[noso]</td>
							<td width='100'>$k[kdbarang]</td>
							<td width='300'>$k[nmbarang]</td>
							<td width='10'>$k[kdsatuan]</td>
							<td align='right' width='10'>$k[qty]</td>
							<td align='right' width='100'>$harga</td>
							<td align='right' width='70'>$k[discount]</td>
							<td align='right'>$subtotal</td>";
					$no++;
				}
				$tampil = mysqli_query($connect, "select sum(qty) as total_qty,sum(subtotal) as total_subtotal from juald where nojual='$nojual'");
				$jum = mysqli_fetch_assoc($tampil);
				$total_qty = $jum['total_qty'];
				$total = number_format($jum['total_subtotal'], 0, ",", ".");
				echo "</tr></tbody><tr><td colspan='5'></td>
						<td align='right' style='font-weight:bold'>$total_qty</td>
						<td align='right' colspan='3' style='font-weight:bold'>$total</td></tr>";
				?>
		</table>
	</div>
</div>