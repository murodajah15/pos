<?php
$table = 'kasir_keluarh';
$primaryKey = 'nokwitansi';

$columns = array(
  // array('db' => 'nokwitansi', 'dt' => 1),
  array(
    'db' => 'nokwitansi', 'dt' => 1,
    'formatter' => function ($d, $row) {
      // return '<a href="#" class="btn-default btn-xs dt-view">' . '<font size=2><b>' . $d . '</b></font></a>';
      return '<a href="#" onclick =lihat_detail("' . $d . '")>' . '<font size=2><b>' . $d . '</b></font></a>';
    }
  ),
  // array('db' => 'tgljual', 'dt' => 2),
  array(
    'db' => 'tglkwitansi', 'dt' => 2,
    'formatter' => function ($d, $row) {
      return '<p style="text-align:center">' . date("m/d/Y", strtotime($d)) . '</p>';
    }
  ),
  // date("m/d/Y", strtotime($k['tglterima']));
  array('db' => 'nmjnkeluar', 'dt' => 3),
  array('db' => 'carabayar', 'dt' => 4),

  array(
    'db' => 'total', 'dt' => 5,
    'formatter' => function ($d, $row) {
      return '<p style="text-align:right">' . number_format($d) . '</p>';
    }
  ),
  array(
    'db' => 'proses', 'dt' => 6,
    'formatter' => function ($d, $row) {
      return '<p style="text-align:center">' . $d . '</p>';
    }
  ),
  array(
    'db' => 'batal', 'dt' => 7,
    'formatter' => function ($d, $row) {
      // if ($d === 'Y') {
      //   return '<p style="text-align:center">' . $d . '</p>';
      // } else {
      //   return $d;
      // }
      return '<p style="text-align:center">' . $d . '</p>';
    }
  ),
  array('db' => 'proses', 'dt' => 8),
  array('db' => 'id', 'dt' => 9),
  array('db' => 'batal', 'dt' => 10),
);

// $sql_details = array(
//     'user' => 'root',
//     'pass' => '',
//     'db'   => 'terimas',
//     'host' => 'localhost'
// );

include './inc/sql_array.php';

require('ssp.class.php');
echo json_encode(
  SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
);
