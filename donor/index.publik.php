<?php
if(isset($_GET['page'])){
	die('<meta http-equiv="refresh" content="0;url=index.php" />');
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>P M I - Palang Merah Indonesia</title>
<style media="all">
	body{
		margin:0;
		padding:0;
		font-weight:normal;
		font-size:12px;
		font-family:Tahoma, Geneva, sans-serif;
		background-image:url(img/b1.jpg);
		background-size:contain;
	}
	#main{
		opacity:0.9;
		background:#FFF;
		margin:0.5% auto;
		width:700px;
		border:1px solid #999;	
		border-radius:1px;
	}
	#menu{
		border-bottom:1px solid #999;
		border-top:1px solid #999;
		height:28px;
		font-size:14px;
	}
	#menu li{
		padding:0;
		list-style:none;
		float:left;
		border-right:1px solid #333;	
	}
	#menu li a{
		display:block;
		padding:5px;
		padding-left:25px;
		padding-right:25px;
		text-decoration:none;
		color:green;	
	}
	#menu li a:hover,#menu li a.aktif{
		color:#fff;	
		background:green;
	}
	h2{
		font-weight:normal;
		font-size:1.5em;
		margin:0px;
		padding:5px;
		padding-left:0;
		border-bottom:1px dotted #ccc;	
	}
	#body{
		min-height:450px;
		padding:8px;	
	}
	#body{
		text-align:justify;	
		font-size:14px;
		line-height:20px;
	}
	#kaki{
		text-align:center;
		border-top:1px solid #ccc;
		padding:15px;	
	}
	.detil {
		font-family:Tahoma, Geneva, sans-serif;
		font-size:12px;
	width: 100%;
	border-spacing: 2px;
	margin: 0;
	margin-top: 10px;
	padding: 0;
	}
	.detil tr {
		vertical-align: top;
	}
	.detil th {
		background: #D3DCE3;
		background:#4CAF50;
		padding: 5px;
		height: 25px;
		font-weight:normal;
		color:white;
		vertical-align: middle;
		padding-left: 3px;
		text-transform:capitalize;
	}
	.detil td {
		padding: 4px;
		background: lavender;
		text-transform: uppercase;
	}
	.detil tr:nth-child(odd) td {
		background: #f5f5f5;
		color: green;
	}
	.detil tr:hover td {
		background: #CFC;
	}
	#kepala{
		height:80px;	
		background:#fff;
		background-image:url(img/kepala.png);
		background-size:contain;
	}
</style>
<script src="js/jquery-1.9.0.min.js"></script>
<script>
	$('body').ready(function(e) {
		$("a.mn").click(function(e) {
			e.preventDefault();
			if($(this).attr('href')=='login'){
				document.location='login.php';	
			}
			$('.mn').removeClass('aktif');
			$(this).addClass('aktif');
			$('#body').load('publik/'+$(this).attr('href')+'.php',function(data){});
			
		});
	});
</script>
</head>

<body>
	<div id="main">
    	<div id="kepala">
        	
        </div>
    	<div id="menu">
        	<li><a href="home" class="mn aktif"><img src="img/b_home.png" /> Home</a></li>
        	<li><a href="visi" class="mn"><img src="img/b_docs.png" /> Visi Misi</a></li>
        	<li><a href="donor" class="mn"><img src="img/b_dbstatistics.png" /> Data Donor Darah</a></li>
        	<li><a href="login" class="mn" style="display:none;"><img src="img/s_loggoff.png" /> Login</a></li>
        </div>
        <div id="body">
        	<?php include('publik/home.php')?>
        </div>
        <div id="kaki">
        	Copyright &copy; 2017. All right reserved.
        </div>
    </div>
</body>
</html>