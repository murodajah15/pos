<?php
// fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");

// membuat nama file ekspor "export-to-excel.xls"
date_default_timezone_set('Asia/Jakarta');
$filename = 'dfthutang-' . date('d-m-Y H:i:s') . '.xls';
header("Content-Disposition: attachment; filename=$filename");

// tambahkan table
include 'rhutang_data.php';
