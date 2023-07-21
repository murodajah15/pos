<?php
$table = 'tbbarang';
$primaryKey = 'kode';

$columns = array(
    array('db' => 'kode', 'dt' => 0),
    array('db' => 'nama', 'dt' => 1),
    array(
        'db' => 'stock', 'dt' => 2,
        'formatter' => function ($d, $row) {
            return '<p style="text-align:right">' . number_format($d) . '</p>';
        }
    ),
    array(
        'db' => 'harga_jual', 'dt' => 3,
        'formatter' => function ($d, $row) {
            return '<p style="text-align:right">' . number_format($d) . '</p>';
        }
    ),
    array(
        'db' => 'harga_beli', 'dt' => 4,
        'formatter' => function ($d, $row) {
            return '<p style="text-align:right">' . number_format($d) . '</p>';
        }
    ),
    array('db' => 'id', 'dt' => 5)
);

// $sql_details = array(
//     'user' => 'root',
//     'pass' => '',
//     'db'   => 'pos',
//     'host' => 'localhost'
// );

include './inc/sql_array.php';

require('ssp.class.php');
echo json_encode(
    SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
);
