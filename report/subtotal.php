<?php
function format_ribuan ($nilai){
	return number_format ($nilai, 0, ',', '.');
}

// Ubah hasil query menjadi associative array dan simpan kedalam variabel result
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<table>
		<thead>
			<tr>
				<th>TAHUN</th>
				<th>ID PELANGGAN</th>
				<th>ID PRODUK</th>
				<th>TOTAL</th>
			</tr>
		</thead>
		<tbody>';
		
$subtotal_plg = $subtotal_thn = $total = 0;
foreach ($result as $key => $row)
{
	$subtotal_plg += $row['jml_byr'];
	$subtotal_thn += $row['jml_byr'];
	echo '<tr>
			<td>'.$row['thn_byr'].'</td>
			<td>'.$row['id_pelanggan'].'</td>
			<td>'.$row['id_produk'].'</td>
			<td class="right">'.format_ribuan($row['jml_byr']).'</td>
		</tr>';
	
	// SUB TOTAL per id_pelanggan
	if (@$result[$key+1]['id_pelanggan'] != $row['id_pelanggan']) {
		echo '<tr class="subtotal">
			<td></td>
			<td>SUB TOTAL</td>
			<td></td>
			<td class="right">'.format_ribuan($subtotal_plg).'</td>
		</tr>';
		$subtotal_plg = 0;
	}
	
	// SUB TOTAL per thn_byr
	if (@$result[$key+1]['thn_byr'] != $row['thn_byr']) {
		echo '<tr class="subtotal">
			<td></td>
			<td>SUB TOTAL ' . $row['thn_byr'] . '</td>
			<td></td>
			<td class="right">'.format_ribuan($subtotal_thn).'</td>
		</tr>';
		$subtotal_thn = 0;
	} 
	$total += $row['jml_byr'];
}

// GRAND TOTAL
echo '<tr class="total">
		<td></td>
		<td>GRAND TOTAL</td>
		<td></td>
		<td class="right"> ' . format_ribuan($total) . '</td>
	</tr>
	</tbody>
</table>
</body>
</html>';

//Metode Rollup
//https://jagowebdev.com/menghitung-total-dan-subtotal-pada-mysql/
// SELECT thn_byr, id_pelanggan, id_produk, SUM(jml_byr) AS jml_byr 
// FROM `sales` 
// GROUP BY thn_byr, id_pelanggan, id_produk WITH ROLLUP

// SELECT COALESCE(thn_byr, 'TOTAL') AS thn_byr, 
		// COALESCE(id_pelanggan, 'SUB TOTAL') AS id_pelanggan,
		// COALESCE(id_produk, 'SUB TOTAL') AS id_produk,
		// SUM(jml_byr) AS jml_byr 
// FROM `sales` 
// GROUP BY thn_byr, id_pelanggan, id_produk WITH ROLLUP

--------+--------------+-----------+-----------+
| thn_byr | id_pelanggan | id_produk | jml_byr   |
+---------+--------------+-----------+-----------+
| 2015    | 1            | 100       |  13660000 |
| 2015    | 1            | 101       |  19885000 |
| 2015    | 1            | SUB TOTAL |  33545000 |
| 2015    | 2            | 100       |  15145000 |
| 2015    | 2            | 101       |  19595000 |
| 2015    | 2            | SUB TOTAL |  34740000 |
| 2015    | SUB TOTAL    | SUB TOTAL |  68285000 |
| 2016    | 1            | 100       |  15225000 |
| 2016    | 1            | 101       |  18340000 |
| 2016    | 1            | SUB TOTAL |  33565000 |
| 2016    | 2            | 100       |  10710000 |
| 2016    | 2            | 101       |  21700000 |
| 2016    | 2            | SUB TOTAL |  32410000 |
| 2016    | SUB TOTAL    | SUB TOTAL |  65975000 |
| TOTAL   | SUB TOTAL    | SUB TOTAL | 134260000 |
+---------+--------------+-----------+-----------+