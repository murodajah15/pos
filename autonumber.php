<?php
function autoNumberSO($connect, $id, $table)
{
	global $sort_num;
	$tampil = mysqli_query($connect, "select * from saplikasi where aktif='Y'");
	$k = mysqli_fetch_assoc($tampil);
	$bulan = $k['bulan'];
	if ($bulan < 10) {
		$bulan = '0' . $k['bulan'];
	}
	$tahun = $k['tahun'];
	$sort_num = $k['noso'];
	$sort_num++;
	//$query = 'SELECT MAX(RIGHT('.$id.', 4)) as max_id FROM '.$table.' ORDER BY '.$id;
	// date_default_timezone_set("Asia/Jakarta");  
	// $tgl = date('m-d-Y');
	// $year = date('Y');
	// $month = date('M');
	// $nmonth = date('m');
	// $yearmonth= $year.$nmonth;
	// mysqli_query($connect,'alter table '.$table.' AUTO_INCREMENT=0');
	// $query = 'select id as max_id from '.$table.' order by id desc';
	// $result = mysqli_query($connect,$query);
	// $data = mysqli_fetch_array($result);
	// $id_max = $data['max_id'];
	// $sort_num = $id_max ;//(int) substr($id_max, 1, 4);
	// $sort_num++;
	// $new_code = 'NBM/'.$year.'/'.$nmonth.'/'.sprintf("%05s", $sort_num);	$sort_num++;
	$new_code = 'SO' . $tahun . $bulan . sprintf("%05s", $sort_num);
	$ketemu = 1;
	$rec = mysqli_num_rows(mysqli_query($connect, "select id from " . $table));
	while ($ketemu <= $rec) {
		$tampil = mysqli_query($connect, "select * from " . $table . " where noso='$new_code'");
		$jum = mysqli_num_rows($tampil);
		if ($jum > 0) {
			$ketemu++;
			mysqli_query($connect, "update saplikasi set noso='$sort_num' where aktif='Y'");
			$sort_num++;
			$new_code = 'SO' . $tahun . $bulan . sprintf("%05s", $sort_num);
		} else {
			break;
		}
	}
	return $new_code;
}
function autoNumberJL($connect, $id, $table)
{
	global $sort_num;
	$tampil = mysqli_query($connect, "select * from saplikasi where aktif='Y'");
	$k = mysqli_fetch_assoc($tampil);
	$bulan = $k['bulan'];
	if ($bulan < 10) {
		$bulan = '0' . $k['bulan'];
	}
	$tahun = $k['tahun'];
	$sort_num = $k['nojual'];
	$kd_perusahaan = $k['kd_perusahaan'];
	$sort_num++;
	//$new_code = 'JL/'.$tahun.'/'.$bulan.'/'.sprintf("%04s", $sort_num);
	$new_code = 'JL' . $kd_perusahaan . $tahun . $bulan . sprintf("%04s", $sort_num);
	$ketemu = 1;
	$rec = mysqli_num_rows(mysqli_query($connect, "select id from " . $table));
	while ($ketemu <= $rec) {
		$ketemu++;
		$tampil = mysqli_query($connect, "select * from " . $table . " where nojual='$new_code'");
		$jum = mysqli_num_rows($tampil);
		if ($jum > 0) {
			mysqli_query($connect, "update saplikasi set nojual='$sort_num' where aktif='Y'");
			$sort_num++;
			//$new_code = 'JL/'.$tahun.'/'.$bulan.'/'.sprintf("%04s", $sort_num);
			$new_code = 'JL' . $kd_perusahaan . $tahun . $bulan . sprintf("%04s", $sort_num);
		} else {
			break;
		}
	}
	return $new_code;
}
function autoNumberPO($connect, $id, $table)
{
	global $sort_num;
	$tampil = mysqli_query($connect, "select * from saplikasi where aktif='Y'");
	$k = mysqli_fetch_assoc($tampil);
	$bulan = $k['bulan'];
	if ($bulan < 10) {
		$bulan = '0' . $k['bulan'];
	}
	$tahun = $k['tahun'];
	$sort_num = $k['nopo'];
	$sort_num++;
	$new_code = 'PO' . $tahun . $bulan . sprintf("%05s", $sort_num);
	$ketemu = 1;
	$rec = mysqli_num_rows(mysqli_query($connect, "select id from " . $table));
	while ($ketemu <= $rec) {
		$ketemu++;
		$tampil = mysqli_query($connect, "select * from " . $table . " where nopo='$new_code'");
		$jum = mysqli_num_rows($tampil);
		if ($jum > 0) {
			mysqli_query($connect, "update saplikasi set nopo='$sort_num' where aktif='Y'");
			$sort_num++;
			$new_code = 'PO' . $tahun . $bulan . sprintf("%05s", $sort_num);
		} else {
			break;
		}
	}
	return $new_code;
}
function autoNumberBE($connect, $id, $table)
{
	global $sort_num;
	$tampil = mysqli_query($connect, "select * from saplikasi where aktif='Y'");
	$k = mysqli_fetch_assoc($tampil);
	$bulan = $k['bulan'];
	if ($bulan < 10) {
		$bulan = '0' . $k['bulan'];
	}
	$tahun = $k['tahun'];
	$sort_num = $k['nobeli'];
	$sort_num++;
	$new_code = 'BE' . $tahun . $bulan . sprintf("%05s", $sort_num);
	$ketemu = 1;
	$rec = mysqli_num_rows(mysqli_query($connect, "select id from " . $table));
	while ($ketemu <= $rec) {
		$ketemu++;
		$tampil = mysqli_query($connect, "select * from " . $table . " where nobeli='$new_code'");
		$jum = mysqli_num_rows($tampil);
		if ($jum > 0) {
			mysqli_query($connect, "update saplikasi set nobeli='$sort_num' where aktif='Y'");
			$sort_num++;
			$new_code = 'BE' . $tahun . $bulan . sprintf("%05s", $sort_num);
		} else {
			break;
		}
	}
	return $new_code;
}
function autoNumberTB($connect, $id, $table)
{
	global $sort_num;
	$tampil = mysqli_query($connect, "select * from saplikasi where aktif='Y'");
	$k = mysqli_fetch_assoc($tampil);
	$bulan = $k['bulan'];
	if ($bulan < 10) {
		$bulan = '0' . $k['bulan'];
	}
	$tahun = $k['tahun'];
	$sort_num = $k['noterima'];
	$sort_num++;
	$new_code = 'TB' . $tahun . $bulan . sprintf("%05s", $sort_num);
	$ketemu = 1;
	$rec = mysqli_num_rows(mysqli_query($connect, "select id from " . $table));
	while ($ketemu <= 10000) {
		$ketemu++;
		$tampil = mysqli_query($connect, "select * from " . $table . " where noterima='$new_code'");
		$jum = mysqli_num_rows($tampil);
		if ($jum > 0) {
			mysqli_query($connect, "update saplikasi set noterima='$sort_num' where aktif='Y'");
			$sort_num++;
			$new_code = 'TB' . $tahun . $bulan . sprintf("%05s", $sort_num);
		} else {
			break;
		}
	}
	return $new_code;
}
function autoNumberKB($connect, $id, $table)
{
	global $sort_num;
	$tampil = mysqli_query($connect, "select * from saplikasi where aktif='Y'");
	$k = mysqli_fetch_assoc($tampil);
	$bulan = $k['bulan'];
	if ($bulan < 10) {
		$bulan = '0' . $k['bulan'];
	}
	$tahun = $k['tahun'];
	$sort_num = $k['nokeluar'];
	$sort_num++;
	$new_code = 'PB' . $tahun . $bulan . sprintf("%05s", $sort_num);
	$ketemu = 1;
	$rec = mysqli_num_rows(mysqli_query($connect, "select id from " . $table));
	while ($ketemu <= $rec) {
		$ketemu++;
		$tampil = mysqli_query($connect, "select * from " . $table . " where nokeluar='$new_code'");
		$jum = mysqli_num_rows($tampil);
		if ($jum > 0) {
			mysqli_query($connect, "update saplikasi set nokeluar='$sort_num' where aktif='Y'");
			$sort_num++;
			$new_code = 'PB' . $tahun . $bulan . sprintf("%05s", $sort_num);
		} else {
			break;
		}
	}
	return $new_code;
}
function autoNumberOP($connect, $id, $table)
{
	global $sort_num;
	$tampil = mysqli_query($connect, "select * from saplikasi where aktif='Y'");
	$k = mysqli_fetch_assoc($tampil);
	$bulan = $k['bulan'];
	if ($bulan < 10) {
		$bulan = '0' . $k['bulan'];
	}
	$tahun = $k['tahun'];
	$sort_num = $k['noopname'];
	$sort_num++;
	$new_code = 'OP' . $tahun . $bulan . sprintf("%05s", $sort_num);
	$ketemu = 1;
	$rec = mysqli_num_rows(mysqli_query($connect, "select id from " . $table));
	while ($ketemu <= $rec) {
		$ketemu++;
		$tampil = mysqli_query($connect, "select * from " . $table . " where noopname='$new_code'");
		$jum = mysqli_num_rows($tampil);
		if ($jum > 0) {
			mysqli_query($connect, "update saplikasi set noopname='$sort_num' where aktif='Y'");
			$sort_num++;
			$new_code = 'OP' . $tahun . $bulan . sprintf("%05s", $sort_num);
		} else {
			break;
		}
	}
	return $new_code;
}
function autoNumberAP($connect, $id, $table)
{
	global $sort_num;
	$tampil = mysqli_query($connect, "select * from saplikasi where aktif='Y'");
	$k = mysqli_fetch_assoc($tampil);
	$bulan = $k['bulan'];
	if ($bulan < 10) {
		$bulan = '0' . $k['bulan'];
	}
	$tahun = $k['tahun'];
	$sort_num = $k['noapprov'];
	$sort_num++;
	$new_code = 'AP' . $tahun . $bulan . sprintf("%05s", $sort_num);
	$ketemu = 1;
	$rec = mysqli_num_rows(mysqli_query($connect, "select id from " . $table));
	while ($ketemu <= $rec) {
		$ketemu++;
		$tampil = mysqli_query($connect, "select * from " . $table . " where noapprov='$new_code'");
		$jum = mysqli_num_rows($tampil);
		if ($jum > 0) {
			mysqli_query($connect, "update saplikasi set noapprov='$sort_num' where aktif='Y'");
			$sort_num++;
			$new_code = 'AP' . $tahun . $bulan . sprintf("%05s", $sort_num);
		} else {
			break;
		}
	}
	return $new_code;
}
function autoNumberKW($connect, $id, $table)
{
	global $sort_num;
	$tampil = mysqli_query($connect, "select * from saplikasi where aktif='Y'");
	$k = mysqli_fetch_assoc($tampil);
	$bulan = $k['bulan'];
	if ($bulan < 10) {
		$bulan = '0' . $k['bulan'];
	}
	$tahun = $k['tahun'];
	$sort_num = $k['nokwtunai'];
	$sort_num++;
	$new_code = 'KW' . $tahun . $bulan . sprintf("%05s", $sort_num);
	$ketemu = 1;
	$rec = mysqli_num_rows(mysqli_query($connect, "select id from " . $table));
	while ($ketemu <= $rec) {
		$ketemu++;
		$tampil = mysqli_query($connect, "select * from " . $table . " where nokwitansi='$new_code'");
		$jum = mysqli_num_rows($tampil);
		if ($jum > 0) {
			mysqli_query($connect, "update saplikasi set nokwtunai='$sort_num' where aktif='Y'");
			$sort_num++;
			$new_code = 'KW' . $tahun . $bulan . sprintf("%05s", $sort_num);
		} else {
			break;
		}
	}
	return $new_code;
}
function autoNumberKWT($connect, $id, $table)
{
	global $sort_num;
	$tampil = mysqli_query($connect, "select * from saplikasi where aktif='Y'");
	$k = mysqli_fetch_assoc($tampil);
	$bulan = $k['bulan'];
	if ($bulan < 10) {
		$bulan = '0' . $k['bulan'];
	}
	$tahun = $k['tahun'];
	$sort_num = $k['nokwtagihan'];
	$sort_num++;
	$new_code = 'KWT' . $tahun . $bulan . sprintf("%04s", $sort_num);
	$ketemu = 1;
	$rec = mysqli_num_rows(mysqli_query($connect, "select id from " . $table));
	while ($ketemu <= $rec) {
		$ketemu++;
		$tampil = mysqli_query($connect, "select * from " . $table . " where nokwitansi='$new_code'");
		$jum = mysqli_num_rows($tampil);
		if ($jum > 0) {
			mysqli_query($connect, "update saplikasi set nokwtagihan='$sort_num' where aktif='Y'");
			$sort_num++;
			$new_code = 'KWT' . $tahun . $bulan . sprintf("%04s", $sort_num);
		} else {
			break;
		}
	}
	return $new_code;
}
function autoNumberPK($connect, $id, $table)
{
	global $sort_num;
	$tampil = mysqli_query($connect, "select * from saplikasi where aktif='Y'");
	$k = mysqli_fetch_assoc($tampil);
	$bulan = $k['bulan'];
	if ($bulan < 10) {
		$bulan = '0' . $k['bulan'];
	}
	$tahun = $k['tahun'];
	$sort_num = $k['nomohon'];
	$sort_num++;
	$new_code = 'PK' . $tahun . $bulan . sprintf("%05s", $sort_num);
	$ketemu = 1;
	$rec = mysqli_num_rows(mysqli_query($connect, "select id from " . $table));
	while ($ketemu <= $rec) {
		$ketemu++;
		$tampil = mysqli_query($connect, "select * from " . $table . " where nomohon='$new_code'");
		$jum = mysqli_num_rows($tampil);
		if ($jum > 0) {
			mysqli_query($connect, "update saplikasi set nomohon='$sort_num' where aktif='Y'");
			$sort_num++;
			$new_code = 'PK' . $tahun . $bulan . sprintf("%05s", $sort_num);
		} else {
			break;
		}
	}
	return $new_code;
}
function autoNumberKK($connect, $id, $table)
{
	global $sort_num;
	$tampil = mysqli_query($connect, "select * from saplikasi where aktif='Y'");
	$k = mysqli_fetch_assoc($tampil);
	$bulan = $k['bulan'];
	if ($bulan < 10) {
		$bulan = '0' . $k['bulan'];
	}
	$tahun = $k['tahun'];
	$sort_num = $k['nokwkeluar'];
	$sort_num++;
	$new_code = 'KK' . $tahun . $bulan . sprintf("%05s", $sort_num);
	$ketemu = 1;
	$rec = mysqli_num_rows(mysqli_query($connect, "select id from " . $table));
	while ($ketemu <= $rec) {
		$ketemu++;
		$tampil = mysqli_query($connect, "select * from " . $table . " where nokwitansi='$new_code'");
		$jum = mysqli_num_rows($tampil);
		if ($rec > 0) {
			mysqli_query($connect, "update saplikasi set nokwkeluar='$sort_num' where aktif='Y'");
			$sort_num++;
			$new_code = 'KK' . $tahun . $bulan . sprintf("%05s", $sort_num);
		} else {
			break;
		}
	}
	return $new_code;
}
function autoNumberSJ($connect, $id, $table)
{
	global $sort_num;
	$tampil = mysqli_query($connect, "select * from saplikasi where aktif='Y'");
	$k = mysqli_fetch_assoc($tampil);
	$bulan = $k['bulan'];
	if ($bulan < 10) {
		$bulan = '0' . $k['bulan'];
	}
	$tahun = $k['tahun'];
	$sort_num = $k['nosrtjln'];
	$sort_num++;
	$new_code = 'SJ/' . $tahun . '/' . $bulan . '/' . sprintf("%04s", $sort_num);
	$ketemu = 1;
	$rec = mysqli_num_rows(mysqli_query($connect, "select id from " . $table));
	while ($ketemu <= $rec) {
		$ketemu++;
		$tampil = mysqli_query($connect, "select * from " . $table . " where nosrtjln='$new_code'");
		$jum = mysqli_num_rows($tampil);
		if ($jum > 0) {
			mysqli_query($connect, "update saplikasi set nosrtjln='$sort_num' where aktif='Y'");
			$sort_num++;
			$new_code = 'SJ/' . $tahun . '/' . $bulan . '/' . sprintf("%04s", $sort_num);
		} else {
			break;
		}
	}
	return $new_code;
}
