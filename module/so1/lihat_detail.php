<?php
	include "../../inc/config.php";

	$noso=$_POST['kode'];
	$query = mysqli_query($connect,"select * from soh where noso='$noso'");
	$de=mysqli_fetch_assoc($query);
	$customer = strip_tags($de['kdcustomer'].' | '.$de['nmcustomer']);
	$biaya_lain = number_format($de['biaya_lain'],0,",",".");
	$subtotal = number_format($de['subtotal'],0,",",".");
	$total_sementara = number_format($de['total_sementara'],0,",",".");
	$ppn = number_format($de['ppn'],2,",",".");
	$materai = number_format($de['materai'],0,",",".");
	$total = number_format($de['total'],0,",",".");
?>
<table style=font-size:13px; class='table table-striped table table-bordered'>
<tr><td>No. SO</td><td><input type="text" class="form-control" value="<?=$de['noso']?>" readonly></td></tr>
<tr><td>Tgl. SO</td><td><input type="text" class="form-control" value="<?=$de['tglso']?>" readonly></td></tr>
<tr><td>No. Referensi</td><td><input type="text" class="form-control" value="<?=$de['noreferensi']?>" readonly></td></tr>
<tr><td>No. PO Customer</td><td><input type="text" class="form-control" value="<?=$de['nopo_customer']?>" readonly></td></tr>
<tr><td>Tgl. PO Customer</td><td><input type="text" class="form-control" value="<?=$de['tglpo_customer']?>" readonly></td></tr>
<tr><td>Kode customer</td><td><input type="text" class="form-control" value="<?=$customer?>" readonly></td></tr>
<tr><td>Jenis Order</td><td><input type="text" class="form-control" value="<?=$de['jenis_order']?>" readonly></td></tr>
<tr><td>Keterangan Biaya Lain</td><td><input type="text" class="form-control" value="<?=$de['ket_biaya_lain']?>" readonly></td></tr>
<tr><td>Tanggal Kirim<br>(M/D/Y)</br></td><td><input type="date" class="form-control" value="<?=$de['tglkirim']?>" readonly></td></tr>
<tr><td>Cara Bayar</td><td><input type="text" class="form-control" value="<?=$de['carabayar']?>" readonly></td></tr>
<tr><td>Tempo (Hari)</td><td><input type="number" class="form-control" value="<?=$tempo?>" readonly></td></tr>	
<tr><td>Tanggal Jatuh Tempo<br>(M/D/Y)</br></td><td><input type="date" class="form-control" value="<?=$de['tgl_jt_tempo']?>" readonly></td></tr>
<tr><td>Biaya Lain</td><td><input type="textr" class="form-control" style="text-align:right;" value="<?=$biaya_lain?>" readonly></td></tr>
<tr><td>Subtotal</td> <td align="right"> <input type="text" class="form-control" style="text-align:right;" value="<?=$subtotal?>" readonly></td></tr>
<tr><td>Total Sementara</td><td><input type="text" class="form-control" style="text-align:right;" value="<?=$total_sementara?>" readonly></td></tr>
<tr><td>PPn (%)</td><td><input type="text" class="form-control" style="text-align:right;" value="<?=$ppn?>" readonly></td></tr>
<tr><td>Materai</td><td><input type="text" class="form-control" style="text-align:right;" value="<?=$materai?>" readonly></td></tr>							
<tr><td>Total</td> <td align="right"> <input type="text" class="form-control" style="text-align:right;" value="<?=$total?>" readonly></td></tr>
<tr><td>Keterangan</td><td><textarea type='text' rows='2' class="form-control" readonly><?=$de['keterangan']?></textarea></td></tr>
<tr><td>Proses</td><td><input type="text" class="form-control" value="<?=$de['proses']?>" readonly></td></tr>
<tr><td>User Input</td><td><input type="text" class="form-control" value="<?=$de['user']?>" readonly></td></tr>
<tr><td>User Proses</td><td><input type="text" class="form-control" value="<?=$de['user_proses']?>" readonly></td></tr>
</table>
