<?php require_once('../db.php')?>
<h2>Data Donor Darah</h2>
<table class="detil">
	<tr>
      <th width="30" rowspan="2" align="center">No</th>
      <th align="center" width="50" rowspan="2">Usia (Thn)</th>
      <th align="center" width="80" rowspan="2">Berat Badan (Kg)</th>
      <th align="center" width="40" rowspan="2">Gender</th>
      <th align="center" width="60" rowspan="2">Kasar HB (g/dl)</th>
      <th align="center" width="" colspan="2">Tekanan Darah (mmHg)</th>
      <th align="center" width="*" rowspan="2">Status Pendonor Darah</th>
  </tr>
  <tr>
      <th align="center" width="45">Sistolik</th>
      <th align="center" width="45">Distolik</th>
  </tr>
  
  <?php
  $no =1;
  $sql=mysql_query('SELECT * FROM tb_status ORDER BY st_id ASC');
  $total=0;
  while($d=mysql_fetch_object($sql)){
      ?>
      <tr valign="top">
          <td align="center"><?php print $no?></td>
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
</table>