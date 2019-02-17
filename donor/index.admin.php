<?php require_once('db.php');
session_start();

if(!isset($_SESSION['u'])){
//	die('<meta http-equiv="refresh" content="0;url=login.php" />');	
}

if(!isset($_GET['page'])){
	die('<meta http-equiv="refresh" content="0;url=?page=data-donor" />');	
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Aplikasi Donor Darah</title>
<link rel="stylesheet" media="all" href="style.css" />
<style>
/* navigation style */
#nav{
	height: 39px;
	font: 12px Geneva, Arial, Helvetica, sans-serif;
	background: #3AB3A9;
	border: 1px solid #30A097;	
	border-radius: 0px;
	border-bottom-right-radius: 3px;
	border-bottom-left-radius: 3px;
	min-width:500px;
	margin-left: 0px;
	padding-left: 0px;
	margin-top:0px;
	background:#4CAF50;
}	

#nav li{
	list-style: none;
	display: block;
	float: left;
	height: 40px;
	position: relative;
	border-right: 0px solid #52BDB5;
	border-right:0px solid #FFF;
}

#nav li a{
	padding: 0px 10px 0px 30px;
	margin: 0px 0;
	line-height: 40px;
	text-decoration: none;
	border-right: 1px solid #389E96;
	border-right:1px solid #FFF;
	height: 40px;
	color: #FFF;
	text-shadow: 1px 1px 1px #66696B;
}

#nav ul{
	background: #f2f5f6; 
	padding: 0px;
	border-bottom: 1px solid #DDDDDD;
	border-right: 1px solid #DDDDDD;
	border-left:1px solid #DDDDDD;
	border-radius: 0px 0px 3px 3px;
	box-shadow: 2px 2px 3px #ECECEC;
	-webkit-box-shadow: 2px 2px 3px #ECECEC;
    -moz-box-shadow:2px 2px 3px #ECECEC;
	width:170px;
}
#nav .site-name,#nav .site-name:hover{
	padding-left: 10px;
	padding-right: 10px;
	color: #FFF;
	text-shadow: 1px 1px 1px #66696B;
	font: italic 20px/38px Georgia, "Times New Roman", Times, serif;
	background: url(img/lg.png) no-repeat 10px 5px;
	width: 190px;
	border-right: 1px solid #52BDB5;
}
#nav .site-name a{
	width: 160px;
	overflow:hidden;
}
#nav li.facebook{
	background: url(images/facebook.png) no-repeat 9px 12px;
}
#nav li.facebook:hover  {
	background: url(images/facebook.png) no-repeat 9px 12px #3BA39B;
}
#nav li.yahoo{
	background: url(images/yahoo.png) no-repeat 9px 12px;
}
#nav li.yahoo:hover  {
	background: url(images/yahoo.png) no-repeat 9px 12px #3BA39B;
}
#nav li.google{
	background: url(images/google.png) no-repeat 9px 12px;
}
#nav li.google:hover  {
	background: url(images/google.png) no-repeat 9px 12px #3BA39B;
}
#nav li.twitter{
	background: url(images/twitter.png) no-repeat 9px 12px;
}
#nav li.twitter:hover  {
	background: url(images/twitter.png) no-repeat 9px 12px #3BA39B;
}

#nav li:hover{
	background: #3BA39B;
}
#nav li a{
	display: block;
}
#nav ul li {
	border-right:none;
	border-bottom:1px solid #DDDDDD;
	height:39px;
	width:169px;
}
#nav ul li a {
	border-right: none;
	color:#6791AD;
	text-shadow: 1px 1px 1px #FFF;
	border-bottom:1px solid #FFFFFF;
}
#nav ul li:hover{background:#DFEEF0;}
#nav ul li:last-child { border-bottom: none;}
#nav ul li:last-child a{ border-bottom: none;}
/* Sub menus */
#nav ul{
	display: none;
	visibility:hidden;
	position: absolute;
	top: 40px;
}

/* Third-level menus */
#nav ul ul{
	top: 0px;
	left:170px;
	display: none;
	visibility:hidden;
	border: 1px solid #DDDDDD;
}
/* Fourth-level menus */
#nav ul ul ul{
	top: 0px;
	left:170px;
	display: none;
	visibility:hidden;
	border: 1px solid #DDDDDD;
}

#nav ul li{
	display: block;
	visibility:visible;
}
#nav li:hover > ul{
	display: block;
	visibility:visible;
}
#main{
	border:1px solid #ccc;
	padding:6px;
	margin:auto;
	border-radius:5px;	
	background:#fff;
}
body{
	background:#efefef;
}
#main h2{
	margin-top:0px;	
	border-bottom:1px dotted #ccc;
	padding:3px;
	padding-left:0;
}
</style>
<!--[if IE 7]>
<style>
#nav{
	margin-left:0px
}
#nav ul{
	left:-40px;
}
#nav ul ul{
	left:130px;
}
#nav ul ul ul{
	left:130px;
}
</style>
<![endif]-->
<script type="text/javascript" src="js/jquery-1.9.0.min.js"></script>
<script>
$(document).ready(function(){
	$("#nav li").hover(
	function(){
		$(this).children('ul').hide();
		$(this).children('ul').slideDown('fast');
	},
	function () {
		$('ul', this).slideUp('fast');            
	});
});
</script>

</head>

<body>
<ul id="nav">
<li class="site-name"><a href="#">&nbsp;</a></li>
    <li class="yahoo"><a href="#">Master</a>
        <ul>
        <li><a href="?page=data-donor">Status Pendonor Darah</a></li>
        </ul>
    </li> 
    <li class="facebook"><a href="#">Proses</a>
        <ul>
        <li><a href="?page=proses">Cek Status Pendonor</a></li>
        </ul>
    </li>
    <li class="google"><a href="#">Sistem</a>
        <ul>
        <li><a href="?page=keluar">Logout (keluar)</a></li>
        </ul>
    </li>
</ul>

<div id="main">
	<h2><?php print $web['judul']?></h2>
	<?php 
		include('pages/'.$_GET['page'].'.php');
	?>    
</div>

</body>
</html>
