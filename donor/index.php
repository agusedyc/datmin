<?php
session_start();
if(!isset($_SESSION['u'])){
	require_once('index.publik.php');
}
else{
	require_once('index.admin.php');	
}

?>