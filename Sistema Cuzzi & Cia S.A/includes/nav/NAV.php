<?php
/*
	Copyright (c) InterAKT Online 2000-2006. All rights reserved.
*/

	$KT_NAV_uploadErrorMsg = '<strong>File not found:</strong> <br />%s<br /><strong>Please upload the includes/ folder to the testing server.</strong> <br /><a href="http://www.interaktonline.com/error/?error=upload_includes" onclick="return confirm(\'Some data will be submitted to InterAKT. Do you want to continue?\');" target="KTDebugger_0">Online troubleshooter</a>';
	$KT_NAV_uploadFileList = array(
		'../common/KT_common.php',
		'../common/lib/resources/KT_Resources.php',
		'../common/lib/db/KT_Db.php',
		'NAV_functions.inc.php',
		'NAV_Regular.class.php',
		'NAV_AZ.class.php',
		'NAV_Category.class.php',
		'NAV_Page_Navigation.class.php');

	for ($KT_NAV_i=0;$KT_NAV_i<sizeof($KT_NAV_uploadFileList);$KT_NAV_i++) {
		$KT_NAV_uploadFileName = dirname(realpath(__FILE__)). '/' . $KT_NAV_uploadFileList[$KT_NAV_i];
		if (file_exists($KT_NAV_uploadFileName)) {
			require_once($KT_NAV_uploadFileName);
		} else {
			die(sprintf($KT_NAV_uploadErrorMsg,$KT_NAV_uploadFileList[$KT_NAV_i]));
		}
	}
?>
