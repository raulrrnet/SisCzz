<?php
/*
	Copyright (c) InterAKT Online 2000-2006. All rights reserved.
*/

	$KT_UPL_uploadErrorMsg = '<strong>File not found:</strong> <br />%s<br /><strong>Please upload the includes/ folder to the testing server.</strong> <br /><a href="http://www.interaktonline.com/error/?error=upload_includes" onclick="return confirm(\'Some data will be submitted to InterAKT. Do you want to continue?\');" target="KTDebugger_0">Online troubleshooter</a>';
	$KT_UPL_uploadFileList = array('KT_FileUpload.class.php', '../../KT_common.php', '../resources/KT_Resources.php', '../folder/KT_Folder.php');

	for ($KT_UPL_i=0;$KT_UPL_i<sizeof($KT_UPL_uploadFileList);$KT_UPL_i++) {
		$KT_UPL_uploadFileName = dirname(realpath(__FILE__)). '/' . $KT_UPL_uploadFileList[$KT_UPL_i];
		if (file_exists($KT_UPL_uploadFileName)) {
			require_once($KT_UPL_uploadFileName);
		} else {
			die(sprintf($KT_UPL_uploadErrorMsg,$KT_UPL_uploadFileList[$KT_UPL_i]));
		}
	}

?>
