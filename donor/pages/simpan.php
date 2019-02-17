<?php
	require_once('../db.php');
	$f=fopen('h.txt','r');
	$v = fgets($f);
	fclose($f);
	$v=="BOLEH DONOR"?$v="Y":$v="T";
	
	// simpan
	$simpan = mysql_query('
		INSERT INTO tb_status SET 
					st_usia		= "'.$_POST['data'][0].'",
					st_bb		= "'.$_POST['data'][1].'",
					st_jk		= "'.$_POST['data'][2].'",
					st_hb		= "'.$_POST['data'][3].'",
					st_sistolik		= "'.$_POST['data'][4].'",
					st_distolik		= "'.$_POST['data'][5].'",
					st_status		= "'.$v.'"
	');
	
	if($simpan){
		print 'Data berhasil disimpan...';	
	}
	else{
		print 'Data gagal disimpan...';	
	}
?>