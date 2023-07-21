<?php
	include "../../inc/config.php";
	$data = mysqli_query($connect,"select nip,nama_alias,npwp,status,golongan,pangkat,divisi,kdeselon,nmeselon,kdsatker,nmsatker,
	kelas_jabatan,jabatan,tukin,norek,nama,kdbank,bank,pr_pot_pajak from mst_pegawai");
	
	// Load plugin PHPExcel nya
	require_once '../../PHPExcel/PHPExcel.php';

	// Panggil class PHPExcel nya
	$excel = new PHPExcel();

	// Settingan awal fil excel
	$excel->getProperties()->setCreator('tukin')
						   ->setLastModifiedBy('tukin')
						   ->setTitle("Data Rekening")
						   ->setSubject("Rekening")
						   ->setDescription("Laporan Semua Data Rekening")
						   ->setKeywords("Data Rekening");

	// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
	$style_col = array(
		'font' => array('bold' => true), // Set font nya jadi bold
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		),
		'borders' => array(
			'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		)
	);

	// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
	$style_row = array(
		'alignment' => array(
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		),
		'borders' => array(
			'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		)
	);

	$excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA MASTER PEGAWAI"); // Set kolom A1 dengan tulisan "DATA SISWA"
	$excel->getActiveSheet()->mergeCells('A1:R1'); // Set Merge Cell pada kolom A1 sampai F1
	$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
	$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
	$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

	// Buat header tabel nya pada baris ke 3
	$excel->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
	$excel->setActiveSheetIndex(0)->setCellValue('B3', "NIP"); // Set kolom B3 dengan tulisan "NIS"
	$excel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA ALIAS"); // Set kolom B3 dengan tulisan "NIS"
	$excel->setActiveSheetIndex(0)->setCellValue('D3', "NPWP"); // Set kolom C3 dengan tulisan "NAMA"
	$excel->setActiveSheetIndex(0)->setCellValue('E3', "STATUS"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
	$excel->setActiveSheetIndex(0)->setCellValue('F3', "GOLONGAN"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
	$excel->setActiveSheetIndex(0)->setCellValue('G3', "PANGKAT"); // Set kolom E3 dengan tulisan "TELEPON"
	$excel->setActiveSheetIndex(0)->setCellValue('H3', "DIVISI"); // Set kolom E3 dengan tulisan "TELEPON"
	$excel->setActiveSheetIndex(0)->setCellValue('I3', "KDESELON"); // Set kolom E3 dengan tulisan "TELEPON"
	$excel->setActiveSheetIndex(0)->setCellValue('J3', "NMESELON"); // Set kolom E3 dengan tulisan "TELEPON"
	$excel->setActiveSheetIndex(0)->setCellValue('K3', "KDSATKER"); // Set kolom E3 dengan tulisan "TELEPON"
	$excel->setActiveSheetIndex(0)->setCellValue('L3', "NMSATKER"); // Set kolom E3 dengan tulisan "TELEPON"
	$excel->setActiveSheetIndex(0)->setCellValue('M3', "KELAS_JABATAN"); // Set kolom E3 dengan tulisan "TELEPON"
	$excel->setActiveSheetIndex(0)->setCellValue('N3', "JABATAN"); // Set kolom E3 dengan tulisan "TELEPON"
	$excel->setActiveSheetIndex(0)->setCellValue('O3', "TUKIN"); // Set kolom E3 dengan tulisan "TELEPON"
	$excel->setActiveSheetIndex(0)->setCellValue('P3', "NOREK"); // Set kolom E3 dengan tulisan "TELEPON"
	$excel->setActiveSheetIndex(0)->setCellValue('Q3', "NAMA"); // Set kolom E3 dengan tulisan "TELEPON"
	$excel->setActiveSheetIndex(0)->setCellValue('R3', "KDBANK"); // Set kolom E3 dengan tulisan "TELEPON"
	$excel->setActiveSheetIndex(0)->setCellValue('S3', "BANK"); // Set kolom E3 dengan tulisan "TELEPON"

	// Apply style header yang telah kita buat tadi ke masing-masing kolom header
	$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('N3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('O3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('P3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('Q3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('R3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('S3')->applyFromArray($style_col);

	// Set height baris ke 1, 2 dan 3
	$excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
	$excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
	$excel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);

	// Buat query untuk menampilkan semua data siswa
	//$sql = $connect->prepare("select norek,nama,kdbank,bank from mst_rekening");
	//$sql->execute(); // Eksekusi querynya

	$sql = mysqli_query($connect,"select nip,nama_alias,npwp,status,golongan,pangkat,divisi,kdeselon,nmeselon,kdsatker,nmsatker,
	kelas_jabatan,jabatan,tukin,norek,nama,kdbank,bank from mst_pegawai");

	$no = 1; // Untuk penomoran tabel, di awal set dengan 1
	$numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
	while($data = mysqli_fetch_assoc($sql)){ // Ambil semua data dari hasil eksekusi $sql
		$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('B'.$numrow, $data['nip'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data['nama_alias']);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('D'.$numrow, $data['npwp'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data['status']);
		$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data['golongan']);
		$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data['pangkat']);
		$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data['divisi']);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('I'.$numrow, $data['kdeselon'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $data['nmeselon']);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('K'.$numrow, $data['kdsatker'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $data['nmsatker']);
		$excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $data['kelas_jabatan']);
		$excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $data['jabatan']);
		$excel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, $data['tukin']);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('P'.$numrow, $data['norek'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValue('Q'.$numrow, $data['nama']);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('R'.$numrow, $data['kdbank'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValue('S'.$numrow, $data['bank']);
		
		// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
		$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('O'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('P'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('Q'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('R'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('S'.$numrow)->applyFromArray($style_row);
		
		$excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
		
		$no++; // Tambah 1 setiap kali looping
		$numrow++; // Tambah 1 setiap kali looping
	}

		$sql = mysqli_query($connect,"select nip,nama_alias,npwp,status,golongan,pangkat,divisi,kdeselon,nmeselon,kdsatker,nmsatker,
	kelas_jabatan,jabatan,tukin,norek,nama,kdbank,bank from mst_pegawai");
	
	// Set width kolom
	$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
	$excel->getActiveSheet()->getColumnDimension('B')->setWidth(20); // Set width kolom NIP
	$excel->getActiveSheet()->getColumnDimension('C')->setWidth(70); // Set width kolom NAMA_ALIAS
	$excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom NPWP
	$excel->getActiveSheet()->getColumnDimension('E')->setWidth(10); // Set width kolom STATUS
	$excel->getActiveSheet()->getColumnDimension('F')->setWidth(10); // Set width kolom GOLONGAN
	$excel->getActiveSheet()->getColumnDimension('G')->setWidth(50); // Set width kolom PANGKAT
	$excel->getActiveSheet()->getColumnDimension('H')->setWidth(50); // Set width kolom DIVISI
	$excel->getActiveSheet()->getColumnDimension('I')->setWidth(10); // Set width kolom KDESELON
	$excel->getActiveSheet()->getColumnDimension('J')->setWidth(100); // Set width kolom NMESELON
	$excel->getActiveSheet()->getColumnDimension('K')->setWidth(10); // Set width kolom KDSATKER
	$excel->getActiveSheet()->getColumnDimension('L')->setWidth(100); // Set width kolom NMSATKER
	$excel->getActiveSheet()->getColumnDimension('M')->setWidth(10); // Set width kolom KELAS_JABATAN
	$excel->getActiveSheet()->getColumnDimension('N')->setWidth(50); // Set width kolom JABATAN
	$excel->getActiveSheet()->getColumnDimension('O')->setWidth(15); // Set width kolom TUKIN
	$excel->getActiveSheet()->getColumnDimension('P')->setWidth(20); // Set width kolom NOREK
	$excel->getActiveSheet()->getColumnDimension('Q')->setWidth(70); // Set width kolom NAMA
	$excel->getActiveSheet()->getColumnDimension('R')->setWidth(20); // Set width kolom KDBANK
	$excel->getActiveSheet()->getColumnDimension('S')->setWidth(100); // Set width kolom BANK

	// Set orientasi kertas jadi LANDSCAPE
	$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

	// Set judul file excel nya
	$excel->getActiveSheet(0)->setTitle("Laporan Data Transaksi");
	$excel->setActiveSheetIndex(0);

	// Proses file excel
	if($_POST['typefile']=='Excel'){
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Master Pegawai.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
	}else{
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Master Pegawai.csv"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'CSV');
		// Export to CSV file.
		//$write->setSheetIndex(1);   // Select which sheet.
		//$write->setDelimiter(';');  // Define delimiter
		$write->save('php://output');
	}
	
	echo "<b>Export data Success</b><br>";
	echo "<input button type='Button' class='btn btn-danger' value='Back' onClick='history.back()'/>";

?>