<?php
include('db.php');
session_start();
if(isset($_POST['u'])){
	$u = $_POST['u'];
	$p = $_POST['p'];
	$sql=mysql_query('SELECT * FROM tb_akun WHERE a_id="'.$u.'" AND a_pass="'.$p.'"');
	if(mysql_num_rows($sql)>0){
		$_SESSION['u']=$u;
		die('<meta http-equiv="refresh" content="0;URL=index.php" />');
	}
	else{
		print '
			<script>
			alert("ERROR\nUsername atau password tidak valid!!!");
			</script>
		';	
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login Form</title>
<style media="all">
	body{
		font-family:"Lucida Sans Unicode", "Lucida Grande", sans-serif;
		font-size:1em;
		background:#CCC;	
		background:#4CAF50;
		background-image:url(img/b1.jpg);
		background-size:contain
	}
	th{
		width:100px;
		text-align:right;
		padding-right:10px;
		font-weight:normal;	
	}
	#box{
		border:1px solid #c60;
		margin:1% auto;	
		width:300px;
		padding:25px;
		padding-left:20px;
		padding-right:20px;
		border-top:15px solid #c60;
		border-bottom:12px solid #C60;
		border-radius:5px;
		background:#e5e5e5;
	}
	img.logo{
		width:190px;
		height:190px;
		margin:5% auto;
		border:0;
		display:block;	
	}
</style>
</head>

<body>
    	<img src="img/logo.png" class="logo" />
	<div id="box">
    	<form method="post" action="">
        	<table>
            	<tr valign="top">
                	<th>Username</th>
                    <td><input type="text" name="u" required="required" autofocus="autofocus" autocomplete="off" /></td>
                </tr>
                <tr valign="top">
                	<th>Password</th>
                    <td><input type="password" name="p" required="required" autocomplete="off" /></td>
                </tr>
                <tr valign="top">
                	<td></td>
                    <td>
                    	<hr />
                        <button type="submit" name="login">Login</button>
                        <a href="index.php"><button type="button">Kembali</button></a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>