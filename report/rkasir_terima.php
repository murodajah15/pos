<?php
	include 'cek_akses.php';
	$user = $_SESSION['username'];
	require_once 'dompdf/dompdf_config.inc.php';
?>
<?php
	if ($aksesok == 'Y') {
		$tanggal = date('Y-m-d');
		$tgl = getdate();
		$tahun = $tgl['year'];
		$tampil=mysqli_fetch_assoc(mysqli_query($connect,"select * from judullap where namalap='rspkasuransi'"));?>
		<font face="calibri">
			<h3>Laporan Kasir Penerimaan</h3>
			<hr size="10px">
			<form method='post' target='_blank' action='report/rkasir_terima_pdf.php'> 
	<!-- 			<input type='hidden' name='username' value='$user'>
				<input type='hidden' name='namalap' value='rspkasuransi'>
				Judul Laporan 
				<input button type='Button' class='btn btn-danger' value='Simpan' onClick="simpan_judul('$namalap','$username')"/>
				<h4></h4>
				<input type="text" class='form-control' size='50' name='judul1' value="<?= $tampil['judul1'] ?>">
				<input type="text" class='form-control' size='50' name='judul2' value="<?= $tampil['judul2'] ?>">
				<input type="text" class='form-control' size='50' name='judul3' value="<?= $tampil['judul3'] ?>"><br> -->
				<input type='checkbox' class='form-control' name='check1' value='semuaperiode' checked ="checked"> Semua Periode
				<!--<div class="form-group">-->
					<input type="date" class='form-group' size='50' name='tanggal1' value="<?= $tanggal ?>">
					s/d
					<input type="date" class='form-group' size='50' name='tanggal2' value="<?= $tanggal ?>">
				<!--</div>-->
				<br><button type='submit' class='btn btn-primary'>Cetak</button>
			</form>
		</font>
	<?php
	}else{
		echo "<font color='red'>Anda tidak punya hak !</font>";
	}
?>

<script type="text/javascript">
	$(function () {
		$('#datetimepicker').datetimepicker({
			format: 'L'
		})            
	});
</script>

<script>
    function simpan_judul($id,$username,$judul1,$judul2,$judul3){
        swal({
          title: "Yakin akan simpan ?",
          text: "",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
          	$href = "report/simpan_judul.php?id=";window.location.href = $href+$id+"&username="+$username+"&judul1="+$judul1+"&judul2="+$judul2+"&judul3="+$judul3;
            // swal("Poof! Your imaginary file has been deleted!", {
            //   icon: "success",
            // });
          } else {
            //swal("Batal Hapus!");
          }
        });
    };  
</script>    
