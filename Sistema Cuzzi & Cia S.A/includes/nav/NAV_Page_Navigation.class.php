<?php
/*
	Copyright (c) InterAKT Online 2000-2006. All rights reserved.
*/

	class NAV_Page_Navigation extends NAV_Regular {
		var $noPagesToDisplay = 3;

		function NAV_Page_Navigation($navName, $rsName, $relPath, $currentPage, $maxRows, $noPagesToDisplay) {
			parent::NAV_Regular($navName, $rsName, $relPath, $currentPage, $maxRows);
			$this->noPagesToDisplay = $noPagesToDisplay;
		}
		function Prepare() {
			parent::Prepare();
			$GLOBALS['nav_noPagesToDisplay']     = $this->noPagesToDisplay;
		}
	}
?>
