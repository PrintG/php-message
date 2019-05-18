<?php
	// ./Identicon/index.phpstring=555&size=48
	require_once(dirname(__FILE__)."./Identicon/Identicon.php");
	
	$identicon = new Identicon();
	$string = 'default';
	$size = 50;
	if(isset($_GET['string']))
		$string = $_GET['string'];
	if(isset($_GET['size']))
		$size = $_GET['size'];
	
	$identicon->displayImage($string,$size);
	
	//data:image/gif;base64,
?>