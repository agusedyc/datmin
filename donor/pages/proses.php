<fieldset class="tampil">
    <legend>Formulir Cek Status Donor Darah</legend>
    
    <form method="post" action="" id="fcek">
    <table class="fo">
        <tr valign="top">
            <th>Usia (Thn)</th>
            <td>
                <input type="text" autofocus value="25" name="data[]" size="3" required />
            </td>
        </tr>
        <tr valign="top">
            <th>Berat Badan (Kg)</th>
            <td>
                <input type="text" name="data[]" value="70" size="5" required />
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
                <input type="text" value="15" name="data[]" size="5" required />
            </td>
        </tr>
        <tr valign="top">
            <th>Tekanan Darah (mmHg) Sistolik</th>
            <td>
                <input type="text" value="120" name="data[]" size="5" required />
            </td>
        </tr>
        <tr valign="top">
            <th>Tekanan Darah (mmHg) Distolik</th>
            <td>
                <input type="text" value="80" name="data[]" size="5" required />
            </td>
        </tr>
        <tr valign="top">
            <th>Status Donor</th>
            <td>
                <input type="text" disabled id="txtstatus" value="" size="19" />
            </td>
        </tr>
        <tr>
            <th></th>
            <td></td>
        </tr>
        <tr>
            <th></th>
            <td>
                <button type="submit" name="simpan"><?php print fs_icon('kembali')?> Proses selanjutnya</button>
                <img src="img/ajax-loader.gif" class="loader" />
                <button type="button" id="btnsimpan"><?php print fs_icon('simpan')?> Simpan data</button>
            </td>
        </tr>
    </table>
    </form>
</fieldset>	

<div id="hasil"></div>

<script>
	$("#btnsimpan").click(function(e) {
        e.preventDefault();
		$.ajax({
			url:'pages/simpan.php',
			dataType:"html",
			type:"POST",
			data:$("#fcek").serialize(),
			success: function(data){
				alert(data);
				$("#btnsimpan").css('display','none');
			}	
		});
    });
	$("#fcek").submit(function(e) {
        e.preventDefault();
		$("#hasil").html("");
		$(".loader").fadeIn(-1000);
		
		$.ajax({
			url:'pages/proses1.php',
			dataType:"html",
			type:"POST",
			data:$(this).serialize(),
			success: function(data){
				$(".loader").hide('fast');
				$("#hasil").html(data);
				$("body").scrollTop(30);
				$.get('pages/ambil.php',function(data){
					$("#txtstatus").val(data);
					$("#btnsimpan").css('display','inline-block');	
				});
			}	
		});
    });
</script>