<?php
	require_once('../db.php');
	$data = $_POST['data'];
	$datax	= $_POST['data'];
	
	// cek dulu, apakah data sudah ada di database.
	// kalo udah, langsung tampilkan aja statusnya
	// kalo belum, baru hitung pake metode naive bayes
	$sql=mysql_query('
		SELECT * FROM tb_status WHERE 
			st_usia		= "'.$data[0].'" AND 
			st_bb		= "'.$data[1].'" AND 
			st_jk		= "'.$data[2].'" AND 
			st_hb		= "'.$data[3].'" AND 
			st_sistolik		= "'.$data[4].'" AND 
			st_distolik		= "'.$data[5].'"
	');
	
	if(mysql_num_rows($sql)>0){
		// udah ada,
		$d=mysql_fetch_object($sql);
		// tampilkan statusnya
		$hasil=$d->st_status=='Y'?'Boleh Donor':'Tidak Boleh Donor';	
		$f=fopen('h.txt','w');
		fwrite($f,$hasil);
		fclose($f);
		die('<br/><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Data sudah ada didalam database, tidak dilakukan perhitungan lagi...</strong><br/><br/>');
	}
	else{
		// belum ada, hitung
		$v_meanUSIA	= array();
		$v_stdUSIA	= array();
		
		$v_meanBB	= array();
		$v_stdBB	= array();
		
		$v_meanHB	= array();
		$v_stdHB	= array();
		
		$v_meanSIS	= array();
		$v_stdSIS	= array();
		
		$v_meanDIS	= array();
		$v_stdUDIS	= array();
		
		$v_probJK	= array();
		
		$v_probStatus	= array();
		
		// ambil data dari database yang udah ada
		
		$jumlah =0;
		$count =0;
		$data = array();
		
		$jumlah2 =0;
		$count2 =0;
		$data2 = array();
		
		$dataBB=array();
		$dataHB=array();
		
		$x=0;
		$y=0;
		$sql=mysql_query('SELECT * FROM tb_status ORDER BY st_id ASC');
		while($d=mysql_fetch_object($sql)){
			if($d->st_status=="Y"){
				$jumlah+= $d->st_usia;
				$count++;
				array_push($data,$d->st_usia);
			}
			else{
				$jumlah2+= $d->st_usia;
				$count2++;
				array_push($data2,$d->st_usia);
			}
			//-----------------------------------
			
			if($d->st_status=="Y"){
				// BB
				$dataBB[0][$x]=$d->st_bb;
				// HB
				$dataHB[0][$x]=$d->st_hb;
				// SIS
				$dataSIS[0][$x]=$d->st_sistolik;
				// DIS
				$dataDIS[0][$x]=$d->st_distolik;
				// GENDER
				if($d->st_jk=='L'){
					$jumlahGDBoleh[0]++;
				}
				else{
					$jumlahGDBoleh[1]++;
				}
				
				$x++;
			}
			else{
				// BB
				$dataBB[1][$y]=$d->st_bb;
				// HB
				$dataHB[1][$y]=$d->st_hb;
				// SIS
				$dataSIS[1][$y]=$d->st_sistolik;
				// DIS
				$dataDIS[1][$y]=$d->st_distolik;
				// GENDER
				if($d->st_jk=='L'){
					$jumlahGDTidakBoleh[0]++;
				}
				else{
					$jumlahGDTidakBoleh[1]++;
				}
				
				$y++;
			}
		}
		
		$mean = number_format($jumlah/$count,3);
		$std = fs_std($data,$mean);
		
		$mean2 = number_format($jumlah2/$count2,3);
		$std2 = fs_std($data2,$mean2);
		
		
		// Status donor => Ya
		$v_meanUSIA[0] = $mean;
		$v_stdUSIA[0] = $std;
		// Status donor => Tidak
		$v_meanUSIA[1] = $mean2;
		$v_stdUSIA[1] = $std2;
		
		
		// BB
		$v_meanBB[0] = number_format(array_sum($dataBB[0])/count($dataBB[0]),3);
		$v_stdBB[0] = fs_std($dataBB[0],$v_meanBB[0]);
		$v_meanBB[1] = number_format(array_sum($dataBB[1])/count($dataBB[1]),3);
		$v_stdBB[1] = fs_std($dataBB[1],$v_meanBB[1]);
		
		// HB
		$v_meanHB[0] = number_format(array_sum($dataHB[0])/count($dataHB[0]),3);
		$v_stdHB[0] = fs_std($dataHB[0],$v_meanHB[0]);
		$v_meanHB[1] = number_format(array_sum($dataHB[1])/count($dataHB[1]),3);
		$v_stdHB[1] = fs_std($dataHB[1],$v_meanHB[1]);
		
		// SISTOLIK
		$v_meanSIS[0] = number_format(array_sum($dataSIS[0])/count($dataSIS[0]),3);
		$v_stdSIS[0] = fs_std($dataSIS[0],$v_meanSIS[0]);
		$v_meanSIS[1] = number_format(array_sum($dataSIS[1])/count($dataSIS[1]),3);
		$v_stdSIS[1] = fs_std($dataSIS[1],$v_meanSIS[1]);
		
		// DSISTOLIK
		$v_meanDIS[0] = number_format(array_sum($dataDIS[0])/count($dataDIS[0]),3);
		$v_stdDIS[0] = fs_std($dataDIS[0],$v_meanDIS[0]);
		$v_meanDIS[1] = number_format(array_sum($dataDIS[1])/count($dataDIS[1]),3);
		$v_stdDIS[1] = fs_std($dataDIS[1],$v_meanDIS[1]);
		
		// PROBABI...
		$sumBolehGD = $jumlahGDBoleh[0]+$jumlahGDBoleh[1];
		$sumTidakBolehGD = $jumlahGDTidakBoleh[0]+$jumlahGDTidakBoleh[1];
		
		$v_probBolehGD[0] = $jumlahGDBoleh[0]/$sumBolehGD;
		$v_probBolehGD[1] = $jumlahGDBoleh[1]/$sumBolehGD;
		$v_probTidakBolehGD[0] = $jumlahGDTidakBoleh[0]/$sumTidakBolehGD;
		$v_probTidakBolehGD[1] = $jumlahGDTidakBoleh[1]/$sumTidakBolehGD;
	}
	
?>
<br>
<br>
<br>
<fieldset class="tampil">
<legend>Detil Cek Status Donor Darah</legend>

<div id="opsi">
	<li><a href="std" class="lihat aktif">Standar Deviasi dan Probabilitas</a></li>
	<li><a href="gaus" class="lihat">Densitas Gauss</a></li>
	<li><a href="hood" class="lihat">Likelihood dan Probabilitas</a></li>
</div>
<div class="isi std">
<fieldset class="tampil">
	<legend>Standar Deviasi</legend>
    <table class="detil s" style="float:left">
    	<tr>
        	<th colspan="3">Usia (Thn)</th>
        </tr>
    	<tr>
        	<th width="50">Data Ke</th>
            <th width="120">Boleh Donor</th>
            <th width="120">Tidak Boleh Donor</th>
        </tr>
        <?php
		$b = count($data2);
		if(count($data)>count($data2)){
			$b = count($data);	
		}
		for($i=0;$i<$b;$i++){
			?>
            <tr valign="top">
            	<td align="center"><?php print ($i+1)?></td>
                <td align="center"><?php print $data[$i]?></td>
                <td align="center"><?php print $data2[$i]?></td>
            </tr>
            <?php
		}
		?>
        <tr valign="top">
        	<td align="center"><strong>Mean</strong></td>
            <td align="center"><strong><?php print $v_meanUSIA[0]?></strong></td>
            <td align="center"><strong><?php print $v_meanUSIA[1]?></strong></td>
        </tr>
        <tr valign="top">
        	<td align="center"><strong>STD</strong></td>
            <td align="center"><strong><?php print $v_stdUSIA[0]?></strong></td>
            <td align="center"><strong><?php print $v_stdUSIA[1]?></strong></td>
        </tr>
    </table>
    
    <table class="detil s" style="float:left">
    	<tr>
        	<th colspan="3">Berat Badan (Kg)</th>
        </tr>
    	<tr>
        	<th width="50">Data Ke</th>
            <th width="120">Boleh Donor</th>
            <th width="120">Tidak Boleh Donor</th>
        </tr>
        <?php
		$b = count($dataBB[1]);
		if(count($dataBB[0])>count($dataBB[1])){
			$b = count($dataBB[0]);	
		}
		for($i=0;$i<$b;$i++){
			?>
            <tr valign="top">
            	<td align="center"><?php print ($i+1)?></td>
                <td align="center"><?php print $dataBB[0][$i]?></td>
                <td align="center"><?php print $dataBB[1][$i]?></td>
            </tr>
            <?php
		}
		?>
        <tr valign="top">
        	<td align="center"><strong>Mean</strong></td>
            <td align="center"><strong><?php print $v_meanBB[0]?></strong></td>
            <td align="center"><strong><?php print $v_meanBB[1]?></strong></td>
        </tr>
        <tr valign="top">
        	<td align="center"><strong>STD</strong></td>
            <td align="center"><strong><?php print $v_stdBB[0]?></strong></td>
            <td align="center"><strong><?php print $v_stdBB[1]?></strong></td>
        </tr>
    </table>
    
    <table class="detil s" style="float:left">
    	<tr>
        	<th colspan="3">Kadar HB</th>
        </tr>
    	<tr>
        	<th width="50">Data Ke</th>
            <th width="120">Boleh Donor</th>
            <th width="120">Tidak Boleh Donor</th>
        </tr>
        <?php
		$b = count($dataBB[1]);
		if(count($dataBB[0])>count($dataBB[1])){
			$b = count($dataBB[0]);	
		}
		for($i=0;$i<$b;$i++){
			?>
            <tr valign="top">
            	<td align="center"><?php print ($i+1)?></td>
                <td align="center"><?php print $dataHB[0][$i]?></td>
                <td align="center"><?php print $dataHB[1][$i]?></td>
            </tr>
            <?php
		}
		?>
        <tr valign="top">
        	<td align="center"><strong>Mean</strong></td>
            <td align="center"><strong><?php print $v_meanHB[0]?></strong></td>
            <td align="center"><strong><?php print $v_meanHB[1]?></strong></td>
        </tr>
        <tr valign="top">
        	<td align="center"><strong>STD</strong></td>
            <td align="center"><strong><?php print $v_stdHB[0]?></strong></td>
            <td align="center"><strong><?php print $v_stdHB[1]?></strong></td>
        </tr>
    </table>
    <br>
    <table class="detil s" style="float:left">
    	<tr>
        	<th colspan="3">Sistolik</th>
        </tr>
    	<tr>
        	<th width="50">Data Ke</th>
            <th width="120">Boleh Donor</th>
            <th width="120">Tidak Boleh Donor</th>
        </tr>
        <?php
		$b = count($dataBB[1]);
		if(count($dataBB[0])>count($dataBB[1])){
			$b = count($dataBB[0]);	
		}
		for($i=0;$i<$b;$i++){
			?>
            <tr valign="top">
            	<td align="center"><?php print ($i+1)?></td>
                <td align="center"><?php print $dataSIS[0][$i]?></td>
                <td align="center"><?php print $dataSIS[1][$i]?></td>
            </tr>
            <?php
		}
		?>
        <tr valign="top">
        	<td align="center"><strong>Mean</strong></td>
            <td align="center"><strong><?php print $v_meanSIS[0]?></strong></td>
            <td align="center"><strong><?php print $v_meanSIS[1]?></strong></td>
        </tr>
        <tr valign="top">
        	<td align="center"><strong>STD</strong></td>
            <td align="center"><strong><?php print $v_stdSIS[0]?></strong></td>
            <td align="center"><strong><?php print $v_stdSIS[1]?></strong></td>
        </tr>
    </table>
    
    <table class="detil s" style="float:left">
    	<tr>
        	<th colspan="3">Distolik</th>
        </tr>
    	<tr>
        	<th width="50">Data Ke</th>
            <th width="120">Boleh Donor</th>
            <th width="120">Tidak Boleh Donor</th>
        </tr>
        <?php
		$b = count($dataBB[1]);
		if(count($dataBB[0])>count($dataBB[1])){
			$b = count($dataBB[0]);	
		}
		for($i=0;$i<$b;$i++){
			?>
            <tr valign="top">
            	<td align="center"><?php print ($i+1)?></td>
                <td align="center"><?php print $dataDIS[0][$i]?></td>
                <td align="center"><?php print $dataDIS[1][$i]?></td>
            </tr>
            <?php
		}
		?>
        <tr valign="top">
        	<td align="center"><strong>Mean</strong></td>
            <td align="center"><strong><?php print $v_meanDIS[0]?></strong></td>
            <td align="center"><strong><?php print $v_meanDIS[1]?></strong></td>
        </tr>
        <tr valign="top">
        	<td align="center"><strong>STD</strong></td>
            <td align="center"><strong><?php print $v_stdDIS[0]?></strong></td>
            <td align="center"><strong><?php print $v_stdDIS[1]?></strong></td>
        </tr>
    </table>
</fieldset>

<fieldset class="tampil">
	<legend>Probabilitas</legend>
    <table class="detil s" style="float:left">
    	<tr>
        	<th colspan="5">Jenis Kelamin</th>
        </tr>
        <tr>
        	<th rowspan="2">Gender</th>
            <th colspan="2">Jumlah</th>
            <th colspan="2">Probabilitas</th>
        </tr>
        <tr>
        	<th width="120">Boleh</th>
        	<th width="120">Tidak Boleh</th>
        	<th width="120">Boleh</th>
        	<th width="120">Tidak Boleh</th>
        </tr>
        <tr>
        	<td align="center">L</td>
            <td align="center"><?php print $jumlahGDBoleh[0]?></td>
            <td align="center"><?php print $jumlahGDTidakBoleh[0]?></td>
            <td align="center"><?php print $v_probBolehGD[0]?></td>
            <td align="center"><?php print $v_probTidakBolehGD[0]?></td>
        </tr>
        <tr>
        	<td align="center">P</td>
            <td align="center"><?php print $jumlahGDBoleh[1]?></td>
            <td align="center"><?php print $jumlahGDTidakBoleh[1]?></td>
            <td align="center"><?php print $v_probBolehGD[1]?></td>
            <td align="center"><?php print $v_probTidakBolehGD[1]?></td>
        </tr>
        <tr>
        	<td align="center"><strong>Jumlah</strong></td>
            <td align="center"><?php print $sumBolehGD?></td>
            <td align="center"><?php print $sumTidakBolehGD?></td>
            <td align="center"><?php print $v_probBolehGD[0]+$v_probBolehGD[1]?></td>
            <td align="center"><?php print $v_probTidakBolehGD[0]+$v_probTidakBolehGD[1]?></td>
        </tr>
    </table>
    
    <?php
	$v_probBolehSD = $sumBolehGD/(count($dataBB[0])+count($dataBB[1]));
	$v_probTidakBolehSD = $sumTidakBolehGD/(count($dataBB[0])+count($dataBB[1]));
	?>
    
    <table class="detil s" style="float:left">
    	<tr>
        	<th colspan="5">Status Donor</th>
        </tr>
        <tr>
        	<th rowspan="2">#</th>
            <th colspan="2">Jumlah</th>
            <th colspan="2">Probabilitas</th>
        </tr>
        <tr>
        	<th width="120">Boleh</th>
        	<th width="120">Tidak Boleh</th>
        	<th width="120">Boleh</th>
        	<th width="120">Tidak Boleh</th>
        </tr>
        <tr>
        	<td align="center"><strong>Jumlah</strong></td>
            <td align="center"><?php print $sumBolehGD?></td>
            <td align="center"><?php print $sumTidakBolehGD?></td>
            <td align="center"><?php print $v_probBolehSD?></td>
            <td align="center"><?php print $v_probTidakBolehSD?></td>
        </tr>
    </table>
</fieldset>
</div>

<?php
	$datax	= $_POST['data'];
	function fs_gauss($std,$x,$mean){
		$a = number_format(1/(sqrt(2*number_format(pi(),9))*$std),6);
		$b = number_format(exp(number_format(-pow(($x-$mean),2)/(2*pow($std,2)),6)),7);
		$c = number_format($a*$b,6);
		return $c;
	}
	
	$gaus_usia[0]=fs_gauss($v_stdUSIA[0],$datax[0],$v_meanUSIA[0]);
	$gaus_usia[1]=fs_gauss($v_stdUSIA[1],$datax[0],$v_meanUSIA[1]);
	
	$gaus_bb[0]=fs_gauss($v_stdBB[0],$datax[1],$v_meanBB[0]);
	$gaus_bb[1]=fs_gauss($v_stdBB[1],$datax[1],$v_meanBB[1]);
	
	$gaus_hb[0]=fs_gauss($v_stdHB[0],$datax[3],$v_meanHB[0]);
	$gaus_hb[1]=fs_gauss($v_stdHB[1],$datax[3],$v_meanHB[1]);
	
	$gaus_sis[0]=fs_gauss($v_stdSIS[0],$datax[4],$v_meanSIS[0]);
	$gaus_sis[1]=fs_gauss($v_stdSIS[1],$datax[4],$v_meanSIS[1]);
	
	$gaus_dis[0]=fs_gauss($v_stdDIS[0],$datax[5],$v_meanDIS[0]);
	$gaus_dis[1]=fs_gauss($v_stdDIS[1],$datax[5],$v_meanDIS[1]);
	
	$likehood[0] = $gaus_usia[0]*$gaus_bb[0]*$gaus_hb[0]*$gaus_sis[0]*$gaus_dis[0]*$v_probBolehGD[0]*$v_probBolehSD;
	$likehood[1] = $gaus_usia[1]*$gaus_bb[1]*$gaus_hb[1]*$gaus_sis[1]*$gaus_dis[1]*$v_probBolehGD[1]*$v_probTidakBolehSD;
	
	$prob[0] = $likehood[0]/$likehood[0]+$likehood[1];
	$prob[1] = $likehood[1]/$likehood[0]+$likehood[1];
	
	$hasil = 'TIDAK BOLEH DONOR';
	if($prob[0]>$prob[1]){
		$hasil = 'BOLEH DONOR';	
	}
	
	$f=fopen('h.txt','w');
	fwrite($f,$hasil);
	fclose($f);
?>
<div class="isi gaus">
	<fieldset class="tampil">
    	<legend>Densitas Gauss</legend>
        <table class="detil">
        	<tr>
            	<th rowspan="2" width="30">#</th>
            	<th align="left" width="*" rowspan="2">Parameter</th>
                <th align="center" width="90" rowspan="2">X</th>
                <th align="center" colspan="2">Mean</th>
                <th align="center" colspan="2">Standar Deviasi</th>
                <th align="center" colspan="2">Densitas Gauss</th>
            </tr>
            <tr>
            	<th>Boleh</th>
                <th>Tidak Boleh</th>
            	<th>Boleh</th>
                <th>Tidak Boleh</th>
            	<th>Boleh</th>
                <th>Tidak Boleh</th>
            </tr>
            <tr>
            	<td align="center">1</td>
            	<td align="left">Usia (Thn)</td>
                <td align="center"><?php print $datax[0]?></td>
                <td align="center"><?php print $v_meanUSIA[0]?></td>
                <td align="center"><?php print $v_meanUSIA[1]?></td>
                <td align="center"><?php print $v_stdUSIA[0]?></td>
                <td align="center"><?php print $v_stdUSIA[1]?></td>
                <td align="center"><?php print $gaus_usia[0]?></td>
                <td align="center"><?php print $gaus_usia[1]?></td>
            </tr>
            <tr>
            	<td align="center">2</td>
            	<td align="left">Berat Badan (Kg)</td>
                <td align="center"><?php print $datax[1]?></td>
                <td align="center"><?php print $v_meanBB[0]?></td>
                <td align="center"><?php print $v_meanBB[1]?></td>
                <td align="center"><?php print $v_stdBB[0]?></td>
                <td align="center"><?php print $v_stdBB[1]?></td>
                <td align="center"><?php print $gaus_bb[0]?></td>
                <td align="center"><?php print $gaus_bb[1]?></td>
            </tr>
            <tr>
            	<td align="center">3</td>
            	<td align="left">Kadar HB (g/dl)</td>
                <td align="center"><?php print $datax[3]?></td>
                <td align="center"><?php print $v_meanHB[0]?></td>
                <td align="center"><?php print $v_meanHB[1]?></td>
                <td align="center"><?php print $v_stdHB[0]?></td>
                <td align="center"><?php print $v_stdHB[1]?></td>
                <td align="center"><?php print $gaus_hb[0]?></td>
                <td align="center"><?php print $gaus_hb[1]?></td>
            </tr>
            <tr>
            	<td align="center">4</td>
            	<td align="left">Tekanan Darah Sistolik (mmHg)</td>
                <td align="center"><?php print $datax[4]?></td>
                <td align="center"><?php print $v_meanSIS[0]?></td>
                <td align="center"><?php print $v_meanSIS[1]?></td>
                <td align="center"><?php print $v_stdSIS[0]?></td>
                <td align="center"><?php print $v_stdSIS[1]?></td>
                <td align="center"><?php print $gaus_sis[0]?></td>
                <td align="center"><?php print $gaus_sis[1]?></td>
            </tr>
            <tr>
            	<td align="center">5</td>
            	<td align="left">Tekanan Darah Distolik (mmHg)</td>
                <td align="center" width="45"><?php print $datax[5]?></td>
                <td align="center" width="45"><?php print $v_meanDIS[0]?></td>
                <td align="center" width="45"><?php print $v_meanDIS[1]?></td>
                <td align="center" width="45"><?php print $v_stdDIS[0]?></td>
                <td align="center" width="45"><?php print $v_stdDIS[1]?></td>
                <td align="center"><?php print $gaus_dis[0]?></td>
                <td align="center"><?php print $gaus_dis[1]?></td>
            </tr>
        </table>
    </fieldset>
</div>


<div class="isi hood">
	<fieldset class="tampil">
    	<legend>Likelihood dan Probabilitas</legend>
        <table class="detil">
        	<tr>
            	<th align="left">#</th>
                <th align="center" width="140">Boleh</th>
                <th align="center" width="140">Tidak Boleh</th>
            </tr>
        	<tr>
            	<td align="left" width="*">Likelihood</td>
                <td align="center"><?php print $likehood[0]?></td>
                <td align="center"><?php print $likehood[1]?></td>
            </tr>
        	<tr>
            	<td align="left" width="*">Probabilitas</td>
                <td align="center"><?php print $prob[0]?></td>
                <td align="center"><?php print $prob[1]?></td>
            </tr>
        </table>
    </fieldset>
</div>
</fieldset>

<script>
	$('.std').fadeIn('fast');
	$("a.lihat").click(function(e) {
        e.preventDefault();
		var cl = "."+$(this).attr('href');
		$('.isi').slideUp('fast');
		$(cl).slideDown('fast');
		$('a.lihat').removeClass('aktif');
		$(this).addClass('aktif');
    });
</script>