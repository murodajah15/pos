<?php
$file = $_GET['nama_file'];
// echo $file;
// // nama file yang akan didownload
// header("Content-Disposition: attachment; filename=" . $file);
// // ukuran file yang akan didownload
// header("Content-length: " . $file);
// // jenis file yang akan didownload
// header("Content-type: " . $file);
// // proses membaca isi file yang akan didownload dari folder
// // $fp  = fopen("./backup/" . $file, 'r');
// $fp  = fopen($file, 'r');
// $content = fread($fp, filesize($file));
// fclose($fp);
// echo $content;
// exit;

if (file_exists($file)) {
  header('Content-Description: File Transfer');
  header('Content-Type: application/octet-stream');
  header('Content-Disposition: attachment; filename=' . basename($file));
  header('Content-Transfer-Encoding: binary');
  header('Expires: 0');
  header('Cache-Control: private');
  header('Pragma: private');
  header('Content-Length: ' . filesize($file));
  ob_clean();
  flush();
  readfile($file);
  exit;
} else {
?>
  <p align="center">Failed Download</p>
<?php
} ?>