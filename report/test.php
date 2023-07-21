	//require_once "koneksi.php";
	include "../inc/config.php";
	require_once("../dompdf/dompdf_config.inc.php");

	$no=1;
	$bulan = $_POST['bulan'];
	$tahun = $_POST['tahun'];
	$kdsatker = $_POST['kdsatker'];
	$kdeselon = $_POST['kdeselon'];
	
	if ($kdsatker<>"") {
		if ($kdeselon<>"") {
			$query = mysqli_query($connect, "select kelas_jabatan, count(kelas_jabatan) as jumlah_penerima,sum(jumlah) as jumlah,sum(pajak) as pajak,
			sum(total) as total,sum(netto) as netto,sum(pot_tl) as pot_tl,sum(pot_psw) as pot_psw,sum(pot_tdk_ditempat) as pot_tdk_ditempat,
			sum(pot_tdk_disiplin) as pot_tdk_disiplin,sum(pot_tdk_upacara) as pot_tdk_upacara,sum(pot_tdk_seragam) as pot_tdk_seragam,
			sum(pot_cuti_besar) as pot_cuti_besar,sum(pot_cuti_penting) as pot_cuti_penting,sum(pot_cuti_sakit) as pot_cuti_sakit,
			sum(pot_skp_bulanan) as pot_skp_bulanan from tunjangan where kdsatker='$kdsatker' and kdeselon='$kdeselon' and proses='Y' and bulan='$bulan' and tahun='$tahun' 
			group by kelas_jabatan order by kelas_jabatan desc");
		}else{
			$query = mysqli_query($connect, "select kelas_jabatan, count(kelas_jabatan) as jumlah_penerima,sum(jumlah) as jumlah,sum(pajak) as pajak,
			sum(total) as total,sum(netto) as netto,sum(pot_tl) as pot_tl,sum(pot_psw) as pot_psw,sum(pot_tdk_ditempat) as pot_tdk_ditempat,
			sum(pot_tdk_disiplin) as pot_tdk_disiplin,sum(pot_tdk_upacara) as pot_tdk_upacara,sum(pot_tdk_seragam) as pot_tdk_seragam,
			sum(pot_cuti_besar) as pot_cuti_besar,sum(pot_cuti_penting) as pot_cuti_penting,sum(pot_cuti_sakit) as pot_cuti_sakit,
			sum(pot_skp_bulanan) as pot_skp_bulanan from tunjangan where kdsatker='$kdsatker' and proses='Y' and bulan='$bulan' and tahun='$tahun' 
			group by kelas_jabatan order by kelas_jabatan desc");			
		}
	}else{
		if ($kdeselon<>"") {
			$query = mysqli_query($connect, "select kelas_jabatan, count(kelas_jabatan) as jumlah_penerima,sum(jumlah) as jumlah,sum(pajak) as pajak,
			sum(total) as total,sum(netto) as netto,sum(pot_tl) as pot_tl,sum(pot_psw) as pot_psw,sum(pot_tdk_ditempat) as pot_tdk_ditempat,
			sum(pot_tdk_disiplin) as pot_tdk_disiplin,sum(pot_tdk_upacara) as pot_tdk_upacara,sum(pot_tdk_seragam) as pot_tdk_seragam,
			sum(pot_cuti_besar) as pot_cuti_besar,sum(pot_cuti_penting) as pot_cuti_penting,sum(pot_cuti_sakit) as pot_cuti_sakit,
			sum(pot_skp_bulanan) as pot_skp_bulanan from tunjangan where kdeselon='$kdeselon' and proses='Y' and bulan='$bulan' and tahun='$tahun' 
			group by kelas_jabatan order by kelas_jabatan desc");			
		}else{
			$query = mysqli_query($connect, "select kelas_jabatan, count(kelas_jabatan) as jumlah_penerima,sum(jumlah) as jumlah,sum(pajak) as pajak,
			sum(total) as total,sum(netto) as netto,sum(pot_tl) as pot_tl,sum(pot_psw) as pot_psw,sum(pot_tdk_ditempat) as pot_tdk_ditempat,
			sum(pot_tdk_disiplin) as pot_tdk_disiplin,sum(pot_tdk_upacara) as pot_tdk_upacara,sum(pot_tdk_seragam) as pot_tdk_seragam,
			sum(pot_cuti_besar) as pot_cuti_besar,sum(pot_cuti_penting) as pot_cuti_penting,sum(pot_cuti_sakit) as pot_cuti_sakit,
			sum(pot_skp_bulanan) as pot_skp_bulanan from tunjangan where proses='Y' and bulan='$bulan' and tahun='$tahun' 
			group by kelas_jabatan order by kelas_jabatan desc");			
		}
	}	
	// $jumrec = mysqli_num_rows($query);
	// while ($row = mysqli_fetch_assoc($query)) {
		// echo $row['jumlah_penerima'];
	// }
	// echo 'jumrec'.$jumrec;

	$html = '<style>
			td {
				border-bottom: 1px solid #ddd;
				margin: 5px;
			}
    table th {
        font-weight:normal;
    }
			
			</style>
		<font size="2" face="comic sans ms">
		<br><dd><dd><dd><dd><dd><dd><dd><dd><dd>LAMPIRAN II</br>'.
		'<br>PERATURAN DIREKTUR JENDERAL PERBENDAHARAAN</br>'.
		'<br>NOMOR PER 2/PB/2015 TENTANG PERUBAHAN ATAS PERATURAN</br>'.
		'<br>DIREKTUR PERBENDAHARAAN NOMOR PER 30/PB/2011 TENTANG</br>'.
		'<br>KERJA BADAN LAYANAN UMUM</br></font>'.
		'<br></dd></dd></dd></dd></dd></dd></dd></dd></dd>'.
		'<center>KEMENTERIAN PERTANIAN </center>'.
		/*'<center>SEKRETARIAT JENDERAL BIRO PERENCANAAN</center>'.**/
		'<center>'.$_POST['judul1'].'</center>'.
		'<center>REKAPITULASI DAFTAR PEMBAYARAN TUNJANGAN KINERJA PEGAWAI</center>'.
		'<center>BULAN : '.$bulan.'</center><br><br>'.
		'<table table-layout="fixed"; cellpadding="0"; cellspacing="1"; style=font-size:13px; class="table table-striped table table-bordered;"> <!--rules="none", border="1"-->
				<thead style="background-color: #eeeeee; border: none;">
					<tr>
						<th width="50px">No.</th>
						<th width="90px">Uraian<br>Kelas<br>Jabatan</th>
						<th width="90px">Jumlah<br>Penerima</th>
						<th width="140px">Tunjangan Kinerja<br>Per Kelas Jabatan</th>
						<th width="5px" align="left">
						<th width="10px" align="left">1.<br>2.<br>3.<br></th>
						<th width="140px" align="left">Jumlah Tunjangan<br>Pajak<br>Jumlah</th>
						<th width="5px" align="left">
						<th width="10px" align="left">1.<br>2.</th>
						<th width="130px" align="left">Potongan Pajak<br>Jumlah Netto</th>
					</tr>
				</thead>';
	
	while ($row = mysqli_fetch_assoc($query))
	{
		$tukin = number_format($row['jumlah']);
		$total_potongan = $row['pot_tl']+$row['pot_psw']+$row['pot_tdk_ditempat']+$row['pot_tdk_disiplin']+$row['pot_tdk_upacara']+
			$row['pot_tdk_seragam']+$row['pot_cuti_besar']+$row['pot_cuti_penting']+$row['pot_cuti_sakit']+$row['pot_skp_bulanan'];
		$jumlah = number_format($row['jumlah']-$total_potongan);
		$pajak = number_format($row['pajak']);
		$total = number_format($row['jumlah']+$row['pajak']);
		$netto = number_format($row['netto']);
		
		$html .= '<tbody border-bottom: 1px solid #ddd;>
					<tr><td width="50px" height="35px" align="center">'.$no.'</td>
					<td width="70px" height="35px" align="center">'.$row["kelas_jabatan"].'</td>
					<td width="70px" height="35px" align="center">'.$row["jumlah_penerima"].'</td>
					<td width="140px" height="35px" align="right">'.$tukin.'</td>
					<td width="5px" height="35px" align="center">
					<td width="5px" height="35px" align="center">
					<td width="140px" height="35px" align="right">'.$jumlah.'<br>'.$pajak.'<br>'.$total.'</td>
					<td width="5px" height="35px" align="center"></td>
					<td width="5px" height="35px" align="center"></td>
					<td width="130px" height="35px" align="right">'.$pajak.'<br>'.$netto.'</td>
				</tr>
				</tbody>';
		$no++;
	}
	
	if ($kdsatker<>"") {
		if ($kdeselon<>"") {
			$query = mysqli_query($connect, "select kelas_jabatan, count(kelas_jabatan) as jumlah_penerima,sum(jumlah) as jumlah,sum(pajak) as pajak,
			sum(total) as total,sum(netto) as netto,sum(pot_tl) as pot_tl,sum(pot_psw) as pot_psw,sum(pot_tdk_ditempat) as pot_tdk_ditempat,
			sum(pot_tdk_disiplin) as pot_tdk_disiplin,sum(pot_tdk_upacara) as pot_tdk_upacara,sum(pot_tdk_seragam) as pot_tdk_seragam,
			sum(pot_cuti_besar) as pot_cuti_besar,sum(pot_cuti_penting) as pot_cuti_penting,sum(pot_cuti_sakit) as pot_cuti_sakit,
			sum(pot_skp_bulanan) as pot_skp_bulanan from tunjangan where 
			kdsatker='$kdsatker' and kdeselon='$kdeselon' and proses='Y' and bulan='$bulan' and tahun='$tahun'");
		}else{
			$query = mysqli_query($connect, "select kelas_jabatan, count(kelas_jabatan) as jumlah_penerima,sum(jumlah) as jumlah,sum(pajak) as pajak,
			sum(total) as total,sum(netto) as netto,sum(pot_tl) as pot_tl,sum(pot_psw) as pot_psw,sum(pot_tdk_ditempat) as pot_tdk_ditempat,
			sum(pot_tdk_disiplin) as pot_tdk_disiplin,sum(pot_tdk_upacara) as pot_tdk_upacara,sum(pot_tdk_seragam) as pot_tdk_seragam,
			sum(pot_cuti_besar) as pot_cuti_besar,sum(pot_cuti_penting) as pot_cuti_penting,sum(pot_cuti_sakit) as pot_cuti_sakit,
			sum(pot_skp_bulanan) as pot_skp_bulanan from tunjangan inner join tunjangan on tunjangan.nourut=tunjanganh.nourut where
			kdsatker='$kdsatker' and proses='Y' and bulan='$bulan' and tahun='$tahun'");
		}
	}else{
		if ($kdeselon<>"") {
			$query = mysqli_query($connect, "select kelas_jabatan, count(kelas_jabatan) as jumlah_penerima,sum(jumlah) as jumlah,sum(pajak) as pajak,
			sum(total) as total,sum(netto) as netto,sum(pot_tl) as pot_tl,sum(pot_psw) as pot_psw,sum(pot_tdk_ditempat) as pot_tdk_ditempat,
			sum(pot_tdk_disiplin) as pot_tdk_disiplin,sum(pot_tdk_upacara) as pot_tdk_upacara,sum(pot_tdk_seragam) as pot_tdk_seragam,
			sum(pot_cuti_besar) as pot_cuti_besar,sum(pot_cuti_penting) as pot_cuti_penting,sum(pot_cuti_sakit) as pot_cuti_sakit,
			sum(pot_skp_bulanan) as pot_skp_bulanan from tunjangan where 
			kdeselon='$kdeselon' and proses='Y' and bulan='$bulan' and tahun='$tahun'");			
		}else{
			$query = mysqli_query($connect, "select kelas_jabatan, count(kelas_jabatan) as jumlah_penerima,sum(jumlah) as jumlah,sum(pajak) as pajak,
			sum(total) as total,sum(netto) as netto,sum(pot_tl) as pot_tl,sum(pot_psw) as pot_psw,sum(pot_tdk_ditempat) as pot_tdk_ditempat,
			sum(pot_tdk_disiplin) as pot_tdk_disiplin,sum(pot_tdk_upacara) as pot_tdk_upacara,sum(pot_tdk_seragam) as pot_tdk_seragam,
			sum(pot_cuti_besar) as pot_cuti_besar,sum(pot_cuti_penting) as pot_cuti_penting,sum(pot_cuti_sakit) as pot_cuti_sakit,
			sum(pot_skp_bulanan) as pot_skp_bulanan from tunjangan where proses='Y' and bulan='$bulan' and tahun='$tahun'");
		}
	}
	$row = mysqli_fetch_assoc($query);

	// $jumrec = mysqli_num_rows($query);
	// while ($row = mysqli_fetch_assoc($query)) {
		// echo "<table><thead>
		// <tr><th>test</th></tr></thead>
		// <tbody><tr><td>$row[jumlah_penerima]</td></table></tr></td></tbody>";
	// }
	// echo $jumrec;

	$tukin = number_format($row['jumlah']);
	$total_potongan = $row['pot_tl']+$row['pot_psw']+$row['pot_tdk_ditempat']+$row['pot_tdk_disiplin']+$row['pot_tdk_upacara']+
		$row['pot_tdk_seragam']+$row['pot_cuti_besar']+$row['pot_cuti_penting']+$row['pot_cuti_sakit']+$row['pot_skp_bulanan'];
	$jumlah = number_format($row['jumlah']-$total_potongan);
	$pajak = number_format($row['pajak']);
	$total = number_format($row['jumlah']+$row['pajak']);
	$netto = number_format($row['netto']);	
	$html .= '<tr><td width="50px"><td width="70px" height="35px" align="center">Jumlah</td>
			<td width="70px" height="35px" align="center">'.$row['jumlah_penerima'].'</td>
			<td width="140px" height="35px" align="right">'.$tukin.'</td>
			<td width="5px" height="35px">'.'</td>
			<td width="10px" height="35px">1.<br>2.<br>3.<br></td>
			<td width="140px" height="35px" align="right">'.$jumlah.'<br>'.$pajak.'<br>'.$total.'</td>
			<td width="5px" height="35px">'.'</td>
			<td>1.<br>2.<br></td>
			<td width="130px" height="35px" align="right">'.$pajak.'<br>'.$netto.'</td>
			</tr></table>';
	$html .= '<font size="2" face="comic sans ms"><br><dd><dd><dd><dd><dd><dd><dd><dd><dd><dd><dd><dd>'.$_POST['daerah'].', '.$_POST['tgl_cetak'].'<br>
			</dd></dd></dd></dd></dd></dd></dd></dd></dd></dd></dd></dd>
			<table>
			<thead>
					<tr>
						<th width="230px" align="left"><font size="2"><p style="font-weight:normal>'.$_POST['jabatan1'].'</p></font></th>
						<th width="230px" align="left"><font size="1">'.$_POST['jabatan2'].'</th>
						<th width="230px" align="left"><font size="1">'.$_POST['jabatan3'].'</font></th>
					</tr>
			</thead>
			</table>
			<br><br><br><br><br><br><br>
			<table>
			<thead style="border: none;">
					<tr>
						<th width="200px" align="left">'.$_POST['pejabat1'].'</th>
						<th width="250px" align="left">'.$_POST['pejabat2'].'</th>
						<th width="230px" align="left">'.$_POST['pejabat2'].'</th>
					</tr>
			</thead>
			<tfoot style="border: none;">
					<tr>
						<th width="200px" align="left">NIP :'.$_POST['nip1'].'</th>
						<th width="250px" align="left">NIP :'.$_POST['nip2'].'</th>
						<th width="230px" align="left">NIP :'.$_POST['nip2'].'</th>
					</tr>
			</tfoot>
			</table>';
	$dompdf = new DOMPDF();
	$dompdf->load_html($html);
	$dompdf->set_paper('A4', 'potrait');
	$dompdf->render();
	$dompdf->stream('laporan_'.$nama.'.pdf', array('Attachment' => false));
	/*$dompdf->stream('laporan_'.$nama.'.pdf'); &&langsung download**/