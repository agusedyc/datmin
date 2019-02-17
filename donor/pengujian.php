<?php
	if(isset($_GET["id"])){
		$kfold = $_GET["id"];

	// Koneksi ke Database
		require '../config/connect.php';
		// Fungsi Aktivasi Sigmoid Biner
		function f($var) {
			 $aktivasi = 1 / (1+exp(-1 * $var));
			 return $aktivasi;
		}
		// Inisialisasi Untuk Resilient Backpropagation
		$n = 8;
		$bias = 1;
		$x[0] = $bias;
		$z[0] = $bias;

		$l = 1;
		$query1 = mysqli_query($db,"SELECT * FROM pelatihan WHERE kfold = '$kfold'");
		while($row = $query1->fetch_object()){
			$id[$l] = $row->id_pelatihan;
			$set_kfold = $row->k;
			$p = $row->hidden_neuron;
			$l++;
		}

		// Ambil Dari Database
		$query2 = mysqli_query($db,"SELECT * FROM dataset ORDER BY id_dataset");

	    $i = 1;
	    while ($data = mysqli_fetch_array($query2, MYSQL_ASSOC)) {
	        $array_data[$i] = $data;
	        $i++;
	    }

	    // K-Vold Validation
	    $data_latih = array();
	    $data_uji = array();
	    $batas_bawah = 1;
	    $batas_atas = 100/$set_kfold;
	    $temp_batas_atas = $batas_atas;
	    for ($i=1; $i <= count($array_data)/$temp_batas_atas; $i++) { 
	        foreach ($array_data as $key => $value) {
	            if (($key >= $batas_bawah) and ($key <= $batas_atas)){
	                $data_uji[$i][] = $value;
	            }else{
	                $data_latih[$i][] = $value;
	            }
	        }
	        $batas_bawah = $batas_bawah + $temp_batas_atas;
	        $batas_atas = $batas_atas + $temp_batas_atas;
	    }

	    // Perulangan Untuk Setiap Fold
	    for ($iterasi=1; $iterasi <= $set_kfold; $iterasi++) {
	    	$data_uji_sesuai = 0;
			$data_latih_sesuai = 0;
			$id_pelatihan = $id[$iterasi];

			$TP =0;
			$TN =0;
			$FP =0;
			$FN =0;
			
			require "bobot/bobot_pelatihan-".$id_pelatihan.".php";

			foreach ($data_latih[$iterasi] as $data) {
				$iduji = $data['id_dataset'];

				// Langkah 3 : Tiap unit input menerima sinyal imput
				for ($i = 1; $i <= $n; $i++) {
					$x[$i] = $data['x'.$i];
					// Menampilkan Bobot vi1
					$t = $data['t'];
				}

				// Langkah 4 : Tiap lapisan hidden menjumlahkan bobot pada sinyal input
				for ($j = 1; $j <= $p; $j++) {
					$zin[$j]=$v[0][$j];
					for ($i = 1; $i <= $n; $i++) {
						$zin[$j]=$zin[$j] + ($x[$i]*$v[$i][$j]);
					}
					// Menampilkan Zin
				}
				
				// Menghitung Zj
				for ($j = 1; $j <= $p; $j++) {
					$z[$j]=f($zin[$j]);
					//Menampilkan Zj
				}
				
				// Langkah 5 : Tiap unit output menjumlahkan sinyal-sinyal yang masuk
				// Menghitung Yin
				$yin[1] = $w[0][1];
				for ($j = 1; $j <= $p; $j++) {
					$yin[1]=$yin[1] + ($z[$j]*$w[$j][1]);
				}

				// Menghitung sinyal output
				$y[1]=f($yin[1]);
				
				if ($y[1] >= 0.6) {
					$y[1] = 1;
				}
				else {
					$y[1] = 0;
				}
				
				if ($t == $y[1]) {
					$data_latih_sesuai = $data_latih_sesuai + 1;
				}
			}

			$file = "bobot/bobot_pelatihan-".$id_pelatihan.".php";
			$content = "<?php\n";
			file_put_contents($file, $content, FILE_APPEND | LOCK_EX);

			$jml_uji = count($data_uji[$iterasi]);

			$temp_msep = 0;
			$msep = 0;

			foreach ($data_uji[$iterasi] as $data) {	
				$iduji = $data['id_dataset'];

				// Langkah 3 : Tiap unit input menerima sinyal imput
				for ($i = 1; $i <= $n; $i++) {
					$x[$i] = $data['x'.$i];

					// Menampilkan Bobot vi1
					$t = $data['t'];
	
				}

				// Langkah 4 : Tiap lapisan hidden menjumlahkan bobot pada sinyal input
				for ($j = 1; $j <= $p; $j++) {
					$zin[$j]=$v[0][$j];
					for ($i = 1; $i <= $n; $i++) {
						$zin[$j]=$zin[$j] + ($x[$i]*$v[$i][$j]);

					}
					// Menampilkan Zin
				}
				
				// Menghitung Zj
				for ($j = 1; $j <= $p; $j++) {
					$z[$j]=f($zin[$j]);
					//Menampilkan Zj

				}
				
				// Langkah 5 : Tiap unit output menjumlahkan sinyal-sinyal yang masuk
				// Menghitung Yin
				$yin[1] = $w[0][1];
				for ($j = 1; $j <= $p; $j++) {
					$yin[1]=$yin[1] + ($z[$j]*$w[$j][1]);
				}
				
				// Menghitung sinyal output
				$y[1]=f($yin[1]);

				$temp_msep = $temp_msep + pow(($t - $y[1]),2);

				if ($y[1] >= 0.6) {
					$y[1] = 1;
				}
				else {
					$y[1] = 0;
				}

				$idnum = explode("-",$iduji);
				$idnumb = $idnum[1]+1-1;
				
				$content = "$"."tuji[".$idnumb."]['".$iduji."'] = ".$y[1].";\n";
				$content = "$"."tuji['".$iduji."'] = ".$y[1].";\n";
				
				file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
				
				

				if ($t == $y[1]) {
					$data_uji_sesuai = $data_uji_sesuai + 1;
				}

				//sensitivitas dan spesifisitas
				if(($t==0)AND($y[1]==0)){
					$TN = $TN + 1;
				}elseif(($t==0)AND($y[1]==1)){
					$FP = $FP + 1;
				}elseif (($t==1)AND($y[1]==0)) {
					$FN = $FN + 1;
				}elseif (($t==1)AND($y[1]==1)) {
					$TP = $TP + 1;
				}
			}

			$msep = $temp_msep/$jml_uji;

			$content = "?>";
			file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
			
			$akurasi = $data_uji_sesuai / $jml_uji * 100;
			$sensitivitas=$TP/($TP+$FN);
			$spesifisitas=$TN/($TN+$FP);

			// Mengambil Id Pengujian Dari Tabel Pengujian
			$query4 = "SELECT id_pengujian FROM pengujian ORDER BY id_pengujian DESC LIMIT 1";
			$query4a = $db->query($query4);
			while($row = $query4a->fetch_object()){
	          $lastid = $row->id_pengujian;
	        }
	        $idnum = explode("-",$lastid);
	        $id_uji = $idnum[1]+1;
	        $format = 'Uji-%1$03d';
	        $id_uji = sprintf($format,$id_uji);

			mysqli_query($db,"UPDATE pengujian SET jumlah_data_uji = '$jml_uji', data_uji_sesuai = '$data_uji_sesuai', mse_uji = '$msep', akurasi = '$akurasi', sensitivitas = '$sensitivitas'*100, spesifisitas = '$spesifisitas'*100 WHERE id_pelatihan='$id_pelatihan'");
			mysqli_query($db,"UPDATE pelatihan SET data_latih_sesuai = '$data_latih_sesuai' WHERE id_pelatihan='$id_pelatihan'");
	    }
	    	echo "<META HTTP-EQUIV='Refresh' Content='0; URL=data_pelatihan.php?id=$kfold'>"; 
	 
	 }else if(isset($_GET['idlatih'])){
		$belum_uji = $_GET['idlatih'];
		//echo $belum_uji;
		// Koneksi ke Database
		require '../config/connect.php';
		// Fungsi Aktivasi Sigmoid Biner
		function f($var) {
			 $aktivasi = 1 / (1+exp(-1 * $var));
			 return $aktivasi;
		}
		// Inisialisasi Untuk Resilient Backpropagation
		$n = 8;
		$bias = 1;
		$x[0] = $bias;
		$z[0] = $bias;

		$l = 1;
		$query1 = mysqli_query($db,"SELECT * FROM pelatihan WHERE id_pelatihan = '$belum_uji'");
		while($row = $query1->fetch_object()){
			$iterasi = $row->pelatihan_ke;
			$id[$l] = $row->id_pelatihan;
			$kfold = $row->kfold;
			$set_kfold = $row->k;
			$p = $row->hidden_neuron;
			$l++;
		}

		// Ambil Dari Database
		$query2 = mysqli_query($db,"SELECT * FROM dataset ORDER BY id_dataset");

	    $i = 1;
	    while ($data = mysqli_fetch_array($query2, MYSQL_ASSOC)) {
	        $array_data[$i] = $data;
	        $i++;
	    }

	    // K-Vold Validation
	    $data_latih = array();
	    $data_uji = array();
	    $batas_bawah = 1;
	    $batas_atas = 100/$set_kfold;
	    $temp_batas_atas = $batas_atas;
	    for ($i=1; $i <= count($array_data)/$temp_batas_atas; $i++) { 
	        foreach ($array_data as $key => $value) {
	            if (($key >= $batas_bawah) and ($key <= $batas_atas)){
	                $data_uji[$i][] = $value;
	            }else{
	                $data_latih[$i][] = $value;
	            }
	        }
	        $batas_bawah = $batas_bawah + $temp_batas_atas;
	        $batas_atas = $batas_atas + $temp_batas_atas;
	    }

	    	$data_uji_sesuai = 0;
			$data_latih_sesuai = 0;
			$id_pelatihan = $id[1];

			$TP =0;
			$TN =0;
			$FP =0;
			$FN =0;

			require "bobot/bobot_pelatihan-".$id_pelatihan.".php";

			$jml_uji = count($data_uji[$iterasi]);

			foreach ($data_latih[$iterasi] as $data) {
				$iduji = $data['id_dataset'];

				// Langkah 3 : Tiap unit input menerima sinyal imput
				for ($i = 1; $i <= $n; $i++) {
					$x[$i] = $data['x'.$i];
					// Menampilkan Bobot vi1
					$t = $data['t'];
				}

				// Langkah 4 : Tiap lapisan hidden menjumlahkan bobot pada sinyal input
				for ($j = 1; $j <= $p; $j++) {
					$zin[$j]=$v[0][$j];
					for ($i = 1; $i <= $n; $i++) {
						$zin[$j]=$zin[$j] + ($x[$i]*$v[$i][$j]);
					}
					// Menampilkan Zin
				}
				
				// Menghitung Zj
				for ($j = 1; $j <= $p; $j++) {
					$z[$j]=f($zin[$j]);
					//Menampilkan Zj
				}
				
				// Langkah 5 : Tiap unit output menjumlahkan sinyal-sinyal yang masuk
				// Menghitung Yin
				$yin[1] = $w[0][1];
				for ($j = 1; $j <= $p; $j++) {
					$yin[1]=$yin[1] + ($z[$j]*$w[$j][1]);
				}

				// Menghitung sinyal output
				$y[1]=f($yin[1]);
				
				if ($y[1] >= 0.6) {
					$y[1] = 1;
				}
				else {
					$y[1] = 0;
				}
				

				if ($t == $y[1]) {
					$data_latih_sesuai = $data_latih_sesuai + 1;
				}
			}

			$file = "bobot/bobot_pelatihan-".$id_pelatihan.".php";
			$content = "<?php\n";
			file_put_contents($file, $content, FILE_APPEND | LOCK_EX);

			$jml_uji = count($data_uji[$iterasi]);

			$temp_msep = 0;
			$msep = 0;

			foreach ($data_uji[$iterasi] as $data) {	
				$iduji = $data['id_dataset'];

				// Langkah 3 : Tiap unit input menerima sinyal imput
				for ($i = 1; $i <= $n; $i++) {
					$x[$i] = $data['x'.$i];

					// Menampilkan Bobot vi1
					$t = $data['t'];
				}

				// Langkah 4 : Tiap lapisan hidden menjumlahkan bobot pada sinyal input
				for ($j = 1; $j <= $p; $j++) {
					$zin[$j]=$v[0][$j];
					for ($i = 1; $i <= $n; $i++) {
						$zin[$j]=$zin[$j] + ($x[$i]*$v[$i][$j]);
					}
					// Menampilkan Zin
				}
				
				// Menghitung Zj
				for ($j = 1; $j <= $p; $j++) {
					$z[$j]=f($zin[$j]);
					//Menampilkan Zj
				}
				
				// Langkah 5 : Tiap unit output menjumlahkan sinyal-sinyal yang masuk
				// Menghitung Yin
				$yin[1] = $w[0][1];
				for ($j = 1; $j <= $p; $j++) {
					$yin[1]=$yin[1] + ($z[$j]*$w[$j][1]);
				}

				// Menghitung sinyal output
				$y[1]=f($yin[1]);

				$temp_msep = $temp_msep + pow(($t - $y[1]),2);
				
				if ($y[1] >= 0.6) {
					$y[1] = 1;
				}
				else {
					$y[1] = 0;
				}

				$idnum = explode("-",$iduji);
				$idnumb = $idnum[1]+1-1;
				
				$content = "$"."tuji[".$idnumb."]['".$iduji."'] = ".$y[1].";\n";
				$content = "$"."tuji['".$iduji."'] = ".$y[1].";\n";

				file_put_contents($file, $content, FILE_APPEND | LOCK_EX);

				if ($t == $y[1]) {
					$data_uji_sesuai = $data_uji_sesuai + 1;
				}
				//sensitivitas dan spesifisitas
				if(($t==0)AND($y[1]==0)){
					$TN = $TN + 1;
				}elseif(($t==0)AND($y[1]==1)){
					$FP = $FP + 1;
				}elseif (($t==1)AND($y[1]==0)) {
					$FN = $FN + 1;
				}elseif (($t==1)AND($y[1]==1)) {
					$TP = $TP + 1;
				}
			}

			$msep = $temp_msep/$jml_uji;

			$content = "?>";
			file_put_contents($file, $content, FILE_APPEND | LOCK_EX);

			$akurasi = $data_uji_sesuai / $jml_uji * 100;
			$sensitivitas=$TP/($TP+$FN);
			$spesifisitas=$TN/($TN+$FP);

			// Mengambil Id Pengujian Dari Tabel Pengujian
			$query4 = "SELECT id_pengujian FROM pengujian ORDER BY id_pengujian DESC LIMIT 1";
			$query4a = $db->query($query4);
			while($row = $query4a->fetch_object()){
	          $lastid = $row->id_pengujian;
	        }
	        $idnum = explode("-",$lastid);
	        $id_uji = $idnum[1]+1;
	        $format = 'Uji-%1$03d';
	        $id_uji = sprintf($format,$id_uji);

			mysqli_query($db,"UPDATE pengujian SET jumlah_data_uji = '$jml_uji', data_uji_sesuai = '$data_uji_sesuai', mse_uji = '$msep', akurasi = '$akurasi', sensitivitas = '$sensitivitas'*100, 	spesifisitas  = '$spesifisitas'*100 WHERE id_pelatihan='$belum_uji'");
			mysqli_query($db,"UPDATE pelatihan SET data_latih_sesuai = '$data_latih_sesuai' WHERE id_pelatihan='$id_pelatihan'");
	    	echo "<META HTTP-EQUIV='Refresh' Content='0; URL=data_pelatihan.php'>"; 

	}
?>