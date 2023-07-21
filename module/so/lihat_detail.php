<?php
include "../../inc/config.php";

$noso = $_POST['kode'];
$query = mysqli_query($connect, "select * from soh where noso='$noso'");
$de = mysqli_fetch_assoc($query);
$tglso = strip_tags($de['tglso']);
$customer = strip_tags($de['kdcustomer'] . ' | ' . $de['nmcustomer']);
$biaya_lain = number_format($de['biaya_lain'], 0, ",", ".");
$subtotal = number_format($de['subtotal'], 0, ",", ".");
$total_sementara = number_format($de['total_sementara'], 0, ",", ".");
$ppn = number_format($de['ppn'], 2, ",", ".");
$materai = number_format($de['materai'], 0, ",", ".");
$total = number_format($de['total'], 0, ",", ".");
?>
<!-- <table style=font-size:13px; class='table table-striped table table-bordered'>
<tr><td>No. SO</td><td><input type="text" class="form-control" value="<?= $de['noso'] ?>" readonly></td></tr>
<tr><td>Tgl. SO</td><td><input type="text" class="form-control" value="<?= $de['tglso'] ?>" readonly></td></tr>
<tr><td>No. Referensi</td><td><input type="text" class="form-control" value="<?= $de['noreferensi'] ?>" readonly></td></tr>
<tr><td>No. PO Customer</td><td><input type="text" class="form-control" value="<?= $de['nopo_customer'] ?>" readonly></td></tr>
<tr><td>Tgl. PO Customer</td><td><input type="text" class="form-control" value="<?= $de['tglpo_customer'] ?>" readonly></td></tr>
<tr><td>Kode customer</td><td><input type="text" class="form-control" value="<?= $customer ?>" readonly></td></tr>
<tr><td>Jenis Order</td><td><input type="text" class="form-control" value="<?= $de['jenis_order'] ?>" readonly></td></tr>
<tr><td>Keterangan Biaya Lain</td><td><input type="text" class="form-control" value="<?= $de['ket_biaya_lain'] ?>" readonly></td></tr>
<tr><td>Tanggal Kirim<br>(M/D/Y)</br></td><td><input type="date" class="form-control" value="<?= $de['tglkirim'] ?>" readonly></td></tr>
<tr><td>Cara Bayar</td><td><input type="text" class="form-control" value="<?= $de['carabayar'] ?>" readonly></td></tr>
<tr><td>Tempo (Hari)</td><td><input type="number" class="form-control" value="<?= $tempo ?>" readonly></td></tr>	
<tr><td>Tanggal Jatuh Tempo<br>(M/D/Y)</br></td><td><input type="date" class="form-control" value="<?= $de['tgl_jt_tempo'] ?>" readonly></td></tr>
<tr><td>Biaya Lain</td><td><input type="textr" class="form-control" style="text-align:right;" value="<?= $biaya_lain ?>" readonly></td></tr>
<tr><td>Subtotal</td> <td align="right"> <input type="text" class="form-control" style="text-align:right;" value="<?= $subtotal ?>" readonly></td></tr>
<tr><td>Total Sementara</td><td><input type="text" class="form-control" style="text-align:right;" value="<?= $total_sementara ?>" readonly></td></tr>
<tr><td>PPn (%)</td><td><input type="text" class="form-control" style="text-align:right;" value="<?= $ppn ?>" readonly></td></tr>
<tr><td>Materai</td><td><input type="text" class="form-control" style="text-align:right;" value="<?= $materai ?>" readonly></td></tr>							
<tr><td>Total</td> <td align="right"> <input type="text" class="form-control" style="text-align:right;" value="<?= $total ?>" readonly></td></tr>
<tr><td>Keterangan</td><td><textarea type='text' rows='2' class="form-control" readonly><?= $de['keterangan'] ?></textarea></td></tr>
<tr><td>Proses</td><td><input type="text" class="form-control" value="<?= $de['proses'] ?>" readonly></td></tr>
<tr><td>User Input</td><td><input type="text" class="form-control" value="<?= $de['user'] ?>" readonly></td></tr>
<tr><td>User Proses</td><td><input type="text" class="form-control" value="<?= $de['user_proses'] ?>" readonly></td></tr>
</table> -->

<div class='col-md-6'>
	<table style=font-size:12px; class='table table-striped table table-bordered' width='600px'>
		<tr>
			<td>Nomor Order</td>
			<td>
				<input type='text' class='form-control' id='noso' name='noso' placeholder='No. SO *' style='text-transform:uppercase' value="<?= $noso ?>" readonly>
			</td>
		</tr>
		<tr>
			<td>Tgl. (M/D/Y)</td>
			<td><input type='date' class='form-control' id='tglso' name='tglso' value="<?= $tglso ?>" size='50' autocomplete='off' readonly></td>
		</tr>
		<tr>
			<td>No. Referensi</td>
			<td><input type="text" class="form-control" value="<?= $de['noreferensi'] ?>" readonly></td>
		</tr>
		<tr>
			<td>No. PO Customer</td>
			<td><input type="text" class="form-control" value="<?= $de['nopo_customer'] ?>" readonly></td>
		</tr>
		<tr>
			<td>Tgl. PO Customer</td>
			<td><input type="text" class="form-control" value="<?= $de['tglpo_customer'] ?>" readonly></td>
		</tr>
		<tr>
			<td>Kode customer</td>
			<td><input type="text" class="form-control" value="<?= $customer ?>" readonly></td>
		</tr>
		<tr>
			<td>Jenis Order</td>
			<td><input type="text" class="form-control" value="<?= $de['jenis_order'] ?>" readonly></td>
		</tr>
		<tr>
			<td>Keterangan Biaya Lain</td>
			<td><input type="text" class="form-control" value="<?= $de['ket_biaya_lain'] ?>" readonly></td>
		</tr>
		<tr>
			<td>Tanggal Kirim<br>(M/D/Y)</br></td>
			<td><input type="date" class="form-control" value="<?= $de['tglkirim'] ?>" readonly></td>
		</tr>
		<tr>
			<td>Cara Bayar</td>
			<td><input type="text" class="form-control" value="<?= $de['carabayar'] ?>" readonly></td>
		</tr>
		<tr>
			<td>Tempo (Hari)</td>
			<td><input type="number" class="form-control" value="<?= $tempo ?>" readonly></td>
		</tr>
		<tr>
			<td>Tanggal Jatuh Tempo<br>(M/D/Y)</br></td>
			<td><input type="date" class="form-control" value="<?= $de['tgl_jt_tempo'] ?>" readonly></td>
		</tr>
	</table>
</div>
<div class='col-md-6'>
	<table style=font-size:12px; class='table table-striped table table-bordered' width='600px'>
		<tr>
			<td>Biaya Lain</td>
			<td><input type="textr" class="form-control" style="text-align:right;" value="<?= $biaya_lain ?>" readonly></td>
		</tr>
		<tr>
			<td>Subtotal</td>
			<td align="right"> <input type="text" class="form-control" style="text-align:right;" value="<?= $subtotal ?>" readonly></td>
		</tr>
		<tr>
			<td>Total Sementara</td>
			<td><input type="text" class="form-control" style="text-align:right;" value="<?= $total_sementara ?>" readonly></td>
		</tr>
		<tr>
			<td>PPn (%)</td>
			<td><input type="text" class="form-control" style="text-align:right;" value="<?= $ppn ?>" readonly></td>
		</tr>
		<tr>
			<td>Materai</td>
			<td><input type="text" class="form-control" style="text-align:right;" value="<?= $materai ?>" readonly></td>
		</tr>
		<tr>
			<td>Total</td>
			<td align="right"> <input type="text" class="form-control" style="text-align:right;" value="<?= $total ?>" readonly></td>
		</tr>
		<tr>
			<td>Keterangan</td>
			<td><textarea type='text' rows='2' class="form-control" readonly><?= $de['keterangan'] ?></textarea></td>
		</tr>
		<tr>
			<td>Proses</td>
			<td><input type="text" class="form-control" value="<?= $de['proses'] ?>" readonly></td>
		</tr>
		<tr>
			<td>User Input</td>
			<td><input type="text" class="form-control" value="<?= $de['user'] ?>" readonly></td>
		</tr>
		<tr>
			<td>User Proses</td>
			<td><input type="text" class="form-control" value="<?= $de['user_proses'] ?>" readonly></td>
		</tr>
	</table>
</div>
<div class="col-md-12">
	<div class="table-responsive">
		<table class="table table-bordered table-striped table-hover">
			<tr>
				<th width='50'>No.</th>
				<th width='170'>Kode Barang</th>
				<th>Nama Barang</th>
				<th>Satuan</th>
				<th>QTY</th>
				<th>harga</th>
				<th>Discount</th>
				<th>Subtotal</th>
			</tr>
			<?php
			$tampil = mysqli_query($connect, "select * from sod where noso='$noso'");
			$query = $connect->prepare("select * from sod where noso=?");
			$query->bind_param('s', $noso);
			$query->execute();
			$result = $query->get_result();
			$de = $result->fetch_assoc();
			$no = 1;
			//<td><u><a href='?m=wo&tipe=detail&id=$k[id]'><font color='blue'>$k[kode]</font></a></u></td>
			//<td><u><a href='#' onclick =lihat_detail('$k[id]');><font color='blue'>$k[kdbarang]</font></a></u></td>
			while ($k = mysqli_fetch_assoc($tampil)) {
				//$date = date("m/d/Y", strtotime($k['tglwo']));
				$kdbarang = strip_tags($de['kdbarang']);
				$nmbarang = strip_tags($de['nmbarang']);
				$qty = number_format($k['qty'], 2, ",", ".");
				$harga = number_format($k['harga'], 0, ",", ".");
				$discount = number_format($k['discount'], 2, ",", ".");
				$subtotal = number_format($k['subtotal'], 0, ",", ".");
				echo "<tr><td align='center'>$no</td>
								<td width='100'>$k[kdbarang]</td>
								<td width='300'>$k[nmbarang]</td>
								<td width='80'>$k[kdsatuan]</td>
								<td align='right' width='70'>$qty</td>
								<td align='right' width='100'>$harga</td>
								<td align='right' width='70'>$discount</td>
								<td align='right'>$subtotal</td>";
				$no++;
			}
			$tampil = mysqli_query($connect, "select sum(qty) as total_qty,sum(subtotal) as total_subtotal from sod where noso='$noso'");
			$jum = mysqli_fetch_assoc($tampil);
			$total_qty = $jum['total_qty'];
			$total_qty = number_format($total_qty, 2, ",", ".");
			$total = $jum['total_subtotal'];
			$total = number_format($total, 0, ",", ".");
			echo "<tr><td colspan='4'></td>
							<td align='right' style='font-weight:bold'>$total_qty</td>
							<td colspan='2' align='right'></td>
							<td align='right' style='font-weight:bold'>$total</td>";
			?>
		</table>
	</div>
</div>