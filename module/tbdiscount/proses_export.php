<?php
	include "../../inc/config.php";
	$data = mysqli_query($connect,"select kode,nama from tbdiscount");
	
	if($_POST['typefile']=='Excel'){
		//Excel
		$filename = "Tabel Discount.xls";
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=\"$filename\"");
		$isPrintHeader = false;
		if (! empty($data)) {
			foreach ($data as $row) {
				if (! $isPrintHeader) {
					echo implode("\t", array_keys($row)) . "\n";
					$isPrintHeader = true;
				}
				echo implode("\t", array_values($row)) . "\n";
			}
		}
		exit();
	}elseif ($_POST['typefile']=='CSV'){
		//CVS
		$filename = "Tabel Discount.csv";
		$number_of_fields = mysqli_num_fields($data);
		$headers = array();
		for ($i = 0; $i < $number_of_fields; $i++) {
			$headers[] = mysqli_field_name($data , $i);
		}
		$fp = fopen('php://output', 'w');
		if ($fp && $data) {
			header('Content-Type: text/csv');
			header("Content-Disposition: attachment; filename=\"$filename\"");
			header('Pragma: no-cache');
			header('Expires: 0');
			fputcsv($fp, $headers);
			while ($row = $data->fetch_array(MYSQLI_NUM)) {
				fputcsv($fp, array_values($row));
			}
			die;
		}
		exit();
	}else{
		//echo "<a href='../../report/pdf_tbdiscount.php' target='_blank'>Cetak</a><br><br>";
		//header("location:../../report/pdf_tbdiscount.php");
		?>
		<script type="text/javascript" language="Javascript">window.open('../../report/pdf_tbdiscount.php');</script>
		<?php
	}

	function mysqli_field_name($data, $field_offset)
	{
		$properties = mysqli_fetch_field_direct($data, $field_offset);
		return is_object($properties) ? $properties->name : null;
	}
	
	//echo "<b>Export data Success</b><br>";
	echo "<input button type='Button' class='btn btn-danger' value='Back' onClick='history.back()'/>";

?>