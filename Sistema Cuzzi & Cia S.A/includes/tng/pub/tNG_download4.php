<?php
/*
	Copyright (c) InterAKT Online 2000-2006. All rights reserved.
*/
// Load the tNG classes
require_once(dirname(realpath(__FILE__)) . '/../tNG.inc.php');

$reference = null;
foreach ($_GET as $key => $val) {
	if (preg_match("/^KT_download(.*)/is", $key)) {
		$reference = $key;
		$downloadID = $val;
		break;
	}
}
$ret = null;
$backUri = '#';
if ($reference !== null) {
	$dwnldObj1 = new tNG_Download("../../../", $reference);
	$ret = $dwnldObj1->Execute();
	$backUri = $dwnldObj1->backUri;
	
}
if ($ret === null) {
	exit;
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Download File</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link href="../../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
<div id="KT_tngerror"><label><?php echo KT_getResource('ERROR_LABEL','tNG')?></label><div><?php echo $ret->details;?></div></div>
<a href="<?php echo $backUri;?>">Back</a>
</body>
</html>
