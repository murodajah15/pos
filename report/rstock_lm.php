<body>
<?php
	include 'cek_akses.php';
	$user = $_SESSION['username'];
	require_once 'dompdf/dompdf_config.inc.php';
?>
<?php
	if ($aksesok == 'Y') {
		$tanggal = date('Y-m-d');
		$tgl = getdate();
		$tahun = $tgl['year'];?>
		<font face="calibri">
			<h3>Laporan Stock Barang</h3>
			<hr size="10px">
			<form method='post' target='_blank' action='report/rstock_pdf.php'>
				<!--<input type='checkbox' class='form-control' name='check2' value='outstanding'> Outstanding-->
				<br><input type='checkbox' class='form-control' name='check1' id='check1' value='semuaperiode' onclik='semua_periode()'> Semua Periode (M-D-Y) 
				<input id="tanggal1" type="date" class='form-group' name='tanggal1' value="<?= $tanggal ?>">
				s/d
				<input id="tanggal2" type="date" class='form-group' name='tanggal2' value="<?= $tanggal ?>"> <!--style="display:block" -->
				<br>
				Bentuk : <td><input type="radio" name="bentuk" value="Rincian" <?php echo 'checked'?>> Rincian
				<input type="radio" name="bentuk" value="Rekapitulasi"> Rekapitulasi				
				<br>
				Pilihan : <input type="radio" name="pilihan" value="Perbarang" <?php echo 'checked'?>> Perbarang
				<input type="radio" name="pilihan" value="Semua"> Semua Barang
				<br><br>
				<div class='input-group'> <input type='text' class='form-control' style="text-transform: uppercase; width: 9em;" id='kdbarang' name='kdbarang' size='50' autocomplete='off' >
				<input type='text' class='form-control' style='width: 15em' id='nmbarang' name='nmbarang' readonly>
				<button type='button' id='src' class='btn btn-primary' onclick='cari_data_barang_beli()'>Cari</button>
				</div>
				<br>
				<br><button type='submit' class='btn btn-primary'>Cetak</button>
			</form>
		</font>
	<?php
	}else{
		echo "<font color='red'>Anda tidak punya hak !</font>";
	}
?>

<script>
function semua_periode() {
  var checkBox = document.getElementById("check1");
  var tanggal1 = document.getElementById("tanggal1");
  var tanggal2 = document.getElementById("tanggal2");
  if (checkBox.checked == true){
    tanggal1.style.display = "block";
    tanggal2.style.display = "block";
  } else {
     tanggal1.style.display = "none";
     tanggal2.style.display = "none";
  }
}
</script>


<script src="js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript"> 

$(document).ready(function(){
	$('#kdbarang').on('blur',function(e){
		let cari = $(this).val();
		$.ajax({
			url: 'repl_barang.php',
			type: 'post',
			data: {kode_barang : cari},
			success: function(response){
				let data_response = JSON.parse(response);
				if (!data_response){
					$('#nmbarang').val('');
					$('#kdsatuan').val('');					
					$('#harga').val('');
					cari_data_barang_beli();
					return;
				}
				$('#nmbarang').val(data_response['nama']);
				$('#kdsatuan').val(data_response['kdsatuan']);
				$('#harga').val(data_response['harga_beli']);
				//console.log(data_response['nama']);
				//console.log(data_response['satuan']);
			},
			error:function(){
				console.log('file not fount');
			}
		})
		// console.log(cari);
	})
})
</script>