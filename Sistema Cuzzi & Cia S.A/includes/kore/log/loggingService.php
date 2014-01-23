<?php

$message = '';
if (isset($_GET['message'])) {
	$message = $_GET['message'];
}

$myFile = ".log";

$size = filesize($myFile);
if($size && $size > 500000) {
	unlink(".old_log");
	rename($myFile, ".old_log");
}

$fh = fopen($myFile, 'ab+') or die("can't open file");
$message = "# ".date("D dS M,Y h:i a")."\r\n".$message."\r\n\r\n";
fwrite($fh, $message."\n");
fclose($fh);

?>