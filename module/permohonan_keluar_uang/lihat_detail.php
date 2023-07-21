<?php
include "../../inc/config.php";

$nomohon = $_POST['kode'];
$query = mysqli_query($connect, "select * from mohklruangh where nomohon='$nomohon'");
$de = mysqli_fetch_assoc($query);
$jnkeluar = strip_tags($de['kdjnkeluar'] . ' | ' . $de['nmjnkeluar']);
$bank = strip_tags($de['kdbank'] . ' | ' . $de['nmbank']);
$jnskartu = strip_tags($de['kdjnskartu'] . ' | ' . $de['nmjnskartu']);
?>
<!-- <table style=font-size:13px; class='table table-striped table table-bordered'>
<tr><td>No. Permohonan</td> <td> <input type=text class='form-control' name='noajukan' value=<?php echo "'$de[nomohon]'" ?> readonly></td></tr>
<tr><td>Tgl. Permohonan</td> <td> <input type=text class='form-control' name='tglajukan' value=<?php echo "'$de[tglmohon]'" ?> readonly></td></tr>
<tr><td>Jenis Pengeluaran</td> <td> <input type=text class='form-control' name='tglajukan' value=<?php echo "$jnkeluar" ?> readonly></td></tr>
<tr><td>Cara Bayar<br>(M/D/Y)</br></td> <td> <input type="text" class='form-control' name='carabayar' size='50' value='<?= $de['carabayar'] ?>'></td></tr>
<tr><td>Bank<br>(M/D/Y)</br></td> <td> <input type="text" class='form-control' name='carabayar' size='50' value='<?= $bank ?>'></td></tr>
<tr><td>Bank<br>(M/D/Y)</br></td> <td> <input type="text" class='form-control' name='carabayar' size='50' value='<?= $jnskartu ?>'></td></tr>
<tr><td>Tempo (Hari)</td> <td> <input type="number" class='form-control' name='tempo' value='<?= $tempo ?>' size='50'></td></tr>
<tr><td>Tanggal Jatuh Tempo<br>(M/D/Y)</br></td> <td> <input type="date" class='form-control' name='tgl_jt_tempo' value='<?= $de['tgl_jt_tempo'] ?>' size='50'></td></tr>
<tr><td>Subtotal</td> <td> <input type="number" class='form-control' id='ppn' name='ppn' size='50' value='<?= $de['subtotal'] ?>' readonly></td></tr>
<tr><td>Materai</td> <td> <input type="number" class='form-control' name='materai' size='50' value='<?= $de['materai'] ?>'></td></tr>							
<tr><td>Total</td> <td> <input type="number" class='form-control' name='total' size='50' value='<?= $de['total'] ?>' readonly></td></tr>
<tr><td>Keterangan</td> <td> <textarea type='text' rows='2' class='form-control' name='tahun' readonly><?php echo "$de[keterangan]" ?></textarea></td></tr>
<tr><td>Proses</td> <td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[proses]'" ?> readonly></td></tr>
<tr><td>User Input</td> <td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[user]'" ?> readonly></td></tr>
<tr><td>User Proses</td> <td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[user_proses]'" ?> readonly></td></tr>
</table> -->

<div class='col-md-6'>
	<table style=font-size:13px; class='table table-striped table table-bordered'>
		<tr>
			<td>No. Permohonan</td>
			<td> <input type=text class='form-control' name='noajukan' value=<?php echo "'$de[nomohon]'" ?> readonly></td>
		</tr>
		<tr>
			<td>Tgl. Permohonan</td>
			<td> <input type=date class='form-control' name='tglajukan' value=<?php echo "'$de[tglmohon]'" ?> readonly></td>
		</tr>
		<tr>
			<td>Jenis Pengeluaran</td>
			<td> <input type=text class='form-control' name='tglajukan' value=<?php echo "$jnkeluar" ?> readonly></td>
		</tr>
		<tr>
			<td>Cara Bayar<br>(M/D/Y)</br></td>
			<td> <input type="text" class='form-control' name='carabayar' size='50' value='<?= $de['carabayar'] ?>'></td>
		</tr>
		<tr>
			<td>Bank<br>(M/D/Y)</br></td>
			<td> <input type="text" class='form-control' name='carabayar' size='50' value='<?= $bank ?>'></td>
		</tr>
		<tr>
			<td>Bank<br>(M/D/Y)</br></td>
			<td> <input type="text" class='form-control' name='carabayar' size='50' value='<?= $jnskartu ?>'></td>
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
	<table style=font-size:13px; class='table table-striped table table-bordered'>
		<tr>
			<td>Subtotal</td>
			<td> <input type="number" class='form-control' id='ppn' name='ppn' size='50' value='<?= $de['subtotal'] ?>' readonly></td>
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
<div class='col-md-12'>
	<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
		<tr>
			<th width='50'>No.</th>
			<th width='100'>No. Dokumen</th>
			<th>Tanggal</th>
			<th>Supplier|Penerima</th>
			<th>Jumlah</th>
		</tr>
		<?php
		$tampil = mysqli_query($connect, "select * from mohklruangd where nomohon='$nomohon'");
		// $query = $connect->prepare("select * from mohklruangd where nomohon=?");
		// $query->bind_param('s', $nomohon);
		// $query->execute();
		// $result = $query->get_result();
		// $de = $result->fetch_assoc();
		$no = 1;
		//<td><u><a href='?m=wo&tipe=detail&id=$k[id]'><font color='blue'>$k[kode]</font></a></u></td>
		//<td><u><a href='#' onclick =lihat_detail('$k[id]');><font color='blue'>$k[nodokumen]</font></a></u></td>
		while ($k = mysqli_fetch_assoc($tampil)) {
			//$date = date("m/d/Y", strtotime($k['tglwo']));
			$tgldokumen = strip_tags($k['nodokumen']);
			$tgldokumen = strip_tags($k['tgldokumen']);
			$supplier = strip_tags($k['kdsupplier']) . '|' . strip_tags($de['nmsupplier']);
			$uang = number_format($k['uang'], 0, ",", ".");
			echo "<tr><td align='center'>$no</td>
									<td width=100'>$k[nodokumen]</td>
									<td width=70'>$k[tgldokumen]</td>
									<td width='300'>$supplier</td>
									<td width='80' align='right'>$uang</td>";
			$no++;
		}
		$tampil = mysqli_query($connect, "select sum(uang) as total_subtotal from mohklruangd where nomohon='$nomohon'");
		$jum = mysqli_fetch_assoc($tampil);
		$total = $jum['total_subtotal'];
		$total = number_format($total, 0, ",", ".");
		echo "<tr><td colspan='3'></td>
								<td colspan='1' align='right'></td>
								<td align='right' style='font-weight:bold'>$total</td>";
		?>
	</table>
</div>