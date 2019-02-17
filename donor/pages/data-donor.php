<?php
	$PAGE = '?page=data-donor';
	$AKSI = $_GET['aksi'];
	
	function fs_tampil($PAGE){
		?>
        <fieldset>
        	<legend>Tabel Data Status Donor Darah</legend>
            <a href="<?php print $PAGE?>&aksi=tambah"><button type="button"><?php print fs_icon('tambah')?> Tambah data baru</button></a>
            
            <table class="detil">
            	<tr>
                	<th width="30" rowspan="2">No</th>
                    <th width="100" colspan="2" rowspan="2">Pilihan</th>
                    <th align="center" width="90" rowspan="2">Usia (Thn)</th>
                    <th align="center" width="90" rowspan="2">Berat Badan (Kg)</th>
                    <th align="center" width="90" rowspan="2">Gender</th>
                    <th align="center" width="90" rowspan="2">Kasar HB (g/dl)</th>
                    <th align="center" width="" colspan="2">Tekanan Darah (mmHg)</th>
                    <th align="center" width="*" rowspan="2">Status Pendonor Darah</th>
                </tr>
                <tr>
                	<th align="center">Sistolik</th>
                    <th align="center">Distolik</th>
                </tr>
                
                <?php
				$no =1;
				$sql=mysql_query('SELECT * FROM tb_status ORDER BY st_id ASC');
				$total=0;
				while($d=mysql_fetch_object($sql)){
					?>
                    <tr valign="top">
                    	<td align="center"><?php print $no?></td>
                        <td align="center" width="25">
                        	<a href="<?php print $PAGE.'&aksi=hapus&id='.$d->st_id?>" onClick="return confirm('Yakin ingin dihapus?')"><?php print fs_icon('hapus')?></a>
                        </td>
                        <td align="center" width="25">
                        	<a href="<?php print $PAGE.'&aksi=ubah&id='.$d->st_id?>"><?php print fs_icon('ubah')?></a>
                        </td>
                        <td align="center"><?php print $d->st_usia?></td>
                        <td align="center"><?php print $d->st_bb?></td>
                        <td align="center"><?php print $d->st_jk?></td>
                        <td align="center"><?php print $d->st_hb?></td>
                        <td align="center"><?php print $d->st_sistolik?></td>
                        <td align="center"><?php print $d->st_distolik?></td>
                        <td align="center"><?php print $d->st_status=='T'?'Tidak Boleh Donor':'Boleh Donor'?></td>
                    </tr>
                    <?php
					$no++;	
				}
				?>
            </table>
        </fieldset>
        <?php
	}
	
	function fs_tambah($PAGE){
		if(isset($_POST['simpan'])){
			$sql = mysql_query('
				INSERT INTO tb_status SET 
					st_usia		= "'.$_POST['data'][0].'",
					st_bb		= "'.$_POST['data'][1].'",
					st_jk		= "'.$_POST['data'][2].'",
					st_hb		= "'.$_POST['data'][3].'",
					st_sistolik		= "'.$_POST['data'][4].'",
					st_distolik		= "'.$_POST['data'][5].'",
					st_status		= "'.$_POST['data'][6].'"
			');
			if($sql){
				pesan('Data berhasil disimpan');	
			}
			else{
				pesan('Data gagal disimpan');
			}
			exit('<meta http-equiv="refresh" content="0;URL='.$PAGE.'" />');
		}
		?>
        <fieldset class="tampil">
        	<legend>Formulir Tambah Status Donor Darah</legend>
            
            <form method="post" action="">
            <table class="fo">
            	<tr valign="top">
                	<th>Usia (Thn)</th>
                    <td>
                    	<input type="text" autofocus name="data[]" size="3" required />
                    </td>
                </tr>
            	<tr valign="top">
                	<th>Berat Badan (Kg)</th>
                    <td>
                    	<input type="text" name="data[]" size="5" required />
                    </td>
                </tr>
            	<tr valign="top">
                	<th>Gender</th>
                    <td>
                    	<select name="data[]">
                        	<option value="L" selected="selected">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </td>
                </tr>
            	<tr valign="top">
                	<th>Kadar HB (g/dl)</th>
                    <td>
                    	<input type="text" name="data[]" size="5" required />
                    </td>
                </tr>
            	<tr valign="top">
                	<th>Tekanan Darah (mmHg) Sistolik</th>
                    <td>
                    	<input type="text" name="data[]" size="5" required />
                    </td>
                </tr>
            	<tr valign="top">
                	<th>Tekanan Darah (mmHg) Distolik</th>
                    <td>
                    	<input type="text" name="data[]" size="5" required />
                    </td>
                </tr>
            	<tr valign="top">
                	<th>Status Pendonor Darah</th>
                    <td>
                    	<select name="data[]">
                        	<option value="T" selected="selected">Tidak Boleh Donor</option>
                            <option value="Y">Boleh Donor</option>
                        </select>
                    </td>
                </tr>
                <tr>
                	<th></th>
                    <td></td>
                </tr>
                <tr>
                	<th></th>
                    <td>
                    	<button type="submit" name="simpan"><?php print fs_icon('simpan')?> Simpan</button>
                        <a href="<?php print $PAGE?>"><button type="button"><?php print fs_icon('kembali')?> Tutup</button></a>
                    </td>
                </tr>
            </table>
            </form>
        </fieldset>	
        <?php	
	}
	
	function fs_ubah($PAGE){
		if(isset($_POST['simpan'])){
			$sql = mysql_query('
				UPDATE tb_status SET 
					st_usia		= "'.$_POST['data'][0].'",
					st_bb		= "'.$_POST['data'][1].'",
					st_jk		= "'.$_POST['data'][2].'",
					st_hb		= "'.$_POST['data'][3].'",
					st_sistolik		= "'.$_POST['data'][4].'",
					st_distolik		= "'.$_POST['data'][5].'",
					st_status		= "'.$_POST['data'][6].'"
				WHERE 
					st_id		= "'.$_GET['id'].'"
			');
			if($sql){
				pesan('Data berhasil disimpan');	
			}
			else{
				pesan('Data gagal disimpan');
			}
			exit('<meta http-equiv="refresh" content="0;URL='.$PAGE.'" />');
		}
		$sql = mysql_query('SELECT * FROM tb_status WHERE st_id='.$_GET['id']);
		$d=mysql_fetch_object($sql);
		?>
        <fieldset class="tampil">
        	<legend>Formulir Ubah Status Donor Darah</legend>
            
            <form method="post" action="">
            <table class="fo">
            	<tr valign="top">
                	<th>Usia (Thn)</th>
                    <td>
                    	<input type="text" autofocus value="<?php print $d->st_usia?>" name="data[]" size="3" required />
                    </td>
                </tr>
            	<tr valign="top">
                	<th>Berat Badan (Kg)</th>
                    <td>
                    	<input type="text" name="data[]" value="<?php print $d->st_bb?>" size="5" required />
                    </td>
                </tr>
            	<tr valign="top">
                	<th>Gender</th>
                    <td>
                    	<select name="data[]">
                        	<option value="L" selected="selected">Laki-laki</option>
                            <option value="P" <?php print $d->st_jk=='P'?'selected':''?>>Perempuan</option>
                        </select>
                    </td>
                </tr>
            	<tr valign="top">
                	<th>Kadar HB (g/dl)</th>
                    <td>
                    	<input type="text" value="<?php print $d->st_hb?>" name="data[]" size="5" required />
                    </td>
                </tr>
            	<tr valign="top">
                	<th>Tekanan Darah (mmHg) Sistolik</th>
                    <td>
                    	<input type="text" value="<?php print $d->st_sistolik?>" name="data[]" size="0" required />
                    </td>
                </tr>
            	<tr valign="top">
                	<th>Tekanan Darah (mmHg) Distolik</th>
                    <td>
                    	<input type="text" value="<?php print $d->st_distolik?>" name="data[]" size="5" required />
                    </td>
                </tr>
            	<tr valign="top">
                	<th>Status Pendonor Darah</th>
                    <td>
                    	<select name="data[]">
                        	<option value="T" selected="selected">Tidak Boleh Donor</option>
                            <option value="Y" <?php print $d->st_status=='Y'?'selected':''?>>Boleh Donor</option>
                        </select>
                    </td>
                </tr>
                <tr>
                	<th></th>
                    <td></td>
                </tr>
                <tr>
                	<th></th>
                    <td>
                    	<input type="hidden" value="<?php print $d->st_id?>" name="id" />
                    	<button type="submit" name="simpan"><?php print fs_icon('simpan')?> Simpan perubahan</button>
                        <a href="<?php print $PAGE?>"><button type="button"><?php print fs_icon('kembali')?> Tutup</button></a>
                    </td>
                </tr>
            </table>
            </form>
        </fieldset>	
        <?php	
	}
	
	function fs_hapus($PAGE){
		$id = (int)$_GET['id'];
		
		$SQL=mysql_query('DELETE FROM tb_status WHERE st_id='.$id);
		if($SQL){
			pesan('Data BERHASIL dihapus');	
		}	
		else{
			pesan('Data GAGAL dihapus');	
		}
		
		print '<meta http-equiv="refresh" content="0;url='.$PAGE.'" />';	
	}

	switch($AKSI){
		default:
			fs_tampil($PAGE);
		break;
		case 'tambah':
			fs_tambah($PAGE);
		break;
		case 'ubah':
			fs_ubah($PAGE);
		break;
		case 'hapus':
			fs_hapus($PAGE);
		break;	
	}
?>