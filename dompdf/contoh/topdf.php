<?php

$nama = str_replace(" ", "_", strtolower($_POST['nama']));
$alamat = $_POST['alamat'];

require_once("dompdf/dompdf_config.inc.php");

$html =
  '<html><body>'.
  '<h1>Halo, '.$nama.' berikut alamat Anda : </h1>'.
  '<p>Alamat lengkap Anda adalah : '.$alamat.'</p>'.
  '</body></html>';

$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('laporan_'.$nama.'.pdf');

?>