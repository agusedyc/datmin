<?php
	error_reporting(0);
	date_default_timezone_set("Asia/Bangkok");
	
	$db_host	= 'localhost';
	$db_user	= 'root';
	$db_pass	= '';
	$db_name	= 'db_donor';
	
	$db_link 	= mysql_connect($db_host,$db_user,$db_pass) or die(mysql_error());
	@mysql_select_db($db_name,$db_link) or die(mysql_error());
	
	switch($_GET['page']){
		
		case 'data-donor':
		$web['judul'] = 'Data Status Donor Darah';
		break;
		
		case 'proses':
		$web['judul'] = 'Cek Status Donor Darah';
		break;
		
		case 'keluar':
		$web['judul'] = 'Keluar Aplikasi';
		break;
	}
	
	function fs_index(){
		$a = $_GET['page'];	
		$b = explode('-',$a);
		if($b[0]=='data'){return(0);}
		if($b[0]=='proses'){return(1);}
		if($b[0]=='keluar'){return(2);}
	}
	
	function fs_icon($ikon){
		switch($ikon){
			case 'tambah':
				print '<img src="img/b_usradd.png" class="ikon">';	
			break;
			case 'ubah':
				print '<img src="img/b_usredit.png" class="ikon">';	
			break;
			case 'hapus':
				print '<img src="img/b_usrdrop.png" class="ikon">';	
			break;
			case 'simpan':
				print '<img src="img/b_save.png" class="ikon">';	
			break;
			case 'cari':
				print '<img src="img/b_search.png" class="ikon">';	
			break;
			case 'kembali':
				print '<img src="img/b_view.png" class="ikon">';	
			break;
			case 'print':
				print '<img src="img/b_print.png" class="ikon">';	
			break;
		}
	}
	
	function pesan($pesan){
		print '
			<script>
				alert("'.$pesan.'");
			</script>
		';	
	}
	
	
	function fs_std($nilai,$mean){
		$jml = count($nilai);
		$jl=0.0;
		$std =0;
		foreach($nilai as $n){
			$jl+=pow($n-$mean,2);
		}
		
		$std = sqrt($jl/($jml-1));
		return number_format($std,3);
	}

?>