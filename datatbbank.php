<?php
    $table = 'tbbank';
    $primaryKey = 'kode';
    
    $columns = array(
        array( 'db' => 'kode','dt' => 0 ),
        array( 'db' => 'nama','dt' => 1 ),
        array( 'db' => 'user','dt' => 2 ),
        array( 'db' => 'id', 'dt' => 3 )
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
        SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
    );
?>