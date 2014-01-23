<?php
class MX_Menu2 {

  var $menuName;
  var $menuOutput;
	//$DBItems[$fk][$order]['property']
	//$property = name, url, target, title, id
  var $DBItems;
  
  var $menuSkin;
  var $menuLayout;
  var $menuShowTimeout;
  var $menuHideTimeout;
	var $menuExitTimeout;
  var $menuImgReplace;
  var $menuImgDir;
  var $menuImgNames;

  var $query;
  var $menuPK;
  var $menuFK;
  var $menuNameField;
  var $menuTitleField;
  var $menuLink;
  var $menuURLParameter;
  var $menuTarget;
  var $menuLinkField;
  var $menuTargetField;
  var $menuLevel;
  var $menuHighlight;

  var $isStatic;
	var $useCache;
	var $menuHighlightImg;
	var $menuHoverImg;
	var $menuImgHeight;
	var $menuImgWidth;
	var $menuZoom;
	var $menuOffset;
	var $menuPersistentTab;

  function MX_Menu2($menuName, $menuDepthSeparator = ' ') {
    $this->menuName = $menuName;
    $this->menuDepthSeparator = $menuDepthSeparator;
    $this->menuItems = array();
    $this->DBItems = array();
    $this->previousItemLevel = -1;
    $this->menuLevel = -1; // -1 means menuLevel is not taken into account
    $this->menuHighlight = false;

    $this->menuImgReplace = false;
    $this->menuImgDir = '';
    $this->menuImgNames = '';

    $this->menuOutput = '';
    $this->fkInitialValue = 0;
		$this->useCache = 0;
		$this->menuHighlightImg = '';
		$this->menuHoverImg = '';
		$this->menuImgHeight = 0;
  	$this->menuImgWidth = 0;
		$this->menuZoom = '';
		$this->setSubMenuOffset(0,0,0,0);
		$this->menuPersistentTab = false;
		$this->menuShowTimeout=0;
		$this->menuExitTimeout=0;
		$this->menuHideTimeout=0;
	}

  /*
  * Common setters (menu styling & behavior)
  */

	function setImgHover($mh = ''){
		$this->menuHoverImg = $mh;
	}

	function setImgHighlight($mh = ''){
			$this->menuHighlightImg = $mh;
	}

	function setSkin ($menuSkin) {
    $this->menuSkin = trim($menuSkin);
  }

  function setLayout ($menuLayout) {
    $this->menuLayout = trim($menuLayout);
    if (strtolower($this->menuLayout) == 'tab') {
      $this->menuLevel = 2; // force limit the number of the output levels for tab layout (see _renderStatic)
    }
  }

  function setShowTimeout ($menuShowTimeout) {
    $menuShowTimeout = is_numeric(trim($menuShowTimeout))?trim($menuShowTimeout):40;
    $this->menuShowTimeout = $menuShowTimeout;
  }

  function setHideTimeout ($menuHideTimeout) {
    $menuHideTimeout = is_numeric(trim($menuHideTimeout))?trim($menuHideTimeout):40;
    $this->menuHideTimeout = $menuHideTimeout;
  }
  function setExitTimeout ($menuExitTimeout = 40){
			$menuExitTimeout = is_numeric(trim($menuExitTimeout))?trim($menuExitTimeout):40;
			$this->menuExitTimeout = $menuExitTimeout;
	}

  function setImgReplace ($menuImgReplace = false) {
    $menuImgReplace = ($menuImgReplace === true)?true:false;
    $this->menuImgReplace = $menuImgReplace;
  }

  function setImgDir ($menuImgDir) {
    $this->menuImgDir = rawurlencode(trim($menuImgDir));
		if (substr($this->menuImgDir, strlen($this->menuImgDir)-3) != '%2F'){
				$this->menuImgDir .= '%2F';
		}
		$this->menuImgDir = str_replace('%2F', '/', $this->menuImgDir);
  }

  function setImgNames ($menuImgNames) {
    $this->menuImgNames = rawurlencode(trim($menuImgNames));
  }

  /*
  * Database fields setters
  */

  function setQuery(&$query) {
    $this->query = &$query;
    $this->isStatic = false;
    $this->isStaticURL = true;
  }

  function setPK ($menuPK) {
    $this->menuPK = trim($menuPK);
  }

  function setFK ($menuFK) {
    $this->menuFK = trim($menuFK);
  }

  function setNameField ($menuNameField) {
    $this->menuNameField = trim($menuNameField);
  }

  function setTitleField ($menuTitleField) {
    $this->menuTitleField = trim($menuTitleField);
  }

  function setLink ($menuLink) {
    $this->menuLink = trim($menuLink);
  }

  function setURLParameter ($menuURLParameter) {
    $this->menuURLParameter = trim($menuURLParameter);
  }

  function setTarget($menuTarget) {
    $this->menuTarget = trim($menuTarget);
  }

  function setLinkField ($menuLinkField) {
    $this->isStaticURL = false;
    $this->menuLinkField = trim($menuLinkField);
  }

  function setTargetField ($menuTargetField) {
    $this->menuTargetField = trim($menuTargetField);
  }

  function setLevel ($menuLevel = 3) {
    $this->menuLevel = $menuLevel;
  }

	function setCache ($cache = 1){
		$this->useCache = $cache;
	}

	function setImgHeight($height = 0){
			if (!empty($height)){
					$this->menuImgHeight = intval($height);
			}
	}

	function setImgWidth($width = 0){
			if (!empty($width)){
					$this->menuImgWidth = intval($width);
			}
	}
	function setAnimation($anim = ''){
			if (in_array($anim, array('zoom', 'fade', 'slide')) !== false){
					$this->menuZoom = $anim;
			}
	}
	function setSubMenuOffset($x1=0, $y1=0, $x2=0, $y2=0){
		  $this->menuOffset['x1'] = intval($x1);
		  $this->menuOffset['y1'] = intval($y1);
		  $this->menuOffset['x2'] = intval($x2);
		  $this->menuOffset['y2'] = intval($y2);
	}
	function setPersistentTab($persist = false){
			$this->menuPersistentTab = !empty($persist);
	}
  function highlightCurrent($highlight = false) {
    $this->menuHighlight = ($highlight === true)?true:false;
  }
	
	/** 
	*   render()
	* 	The method called to start rendering the menu. Supports basic caching.
	* 	
	* 	parameters: none
	* 	return: the HTML
	*/ 

  function render() {
		$has_cache = file_exists(realpath(dirname(__FILE__)).'/menuCache.php');
		if (!empty($this->useCache) && $has_cache){
				 @include(realpath(dirname(__FILE__)).'/menuCache.php');
				 $this->menuOutput = @$menuCached;
		}
    if (empty($this->menuOutput)) {
 			   $this->_getUnformatedData();
    		 $this->menuOutput = $this->_renderRecursive();
    }
		if (!empty($this->useCache) && !$has_cache){
				 $f = @fopen(realpath(dirname(__FILE__)).'/menuCache.php', 'w+');
			 	 @fwrite($f, '<?php $menuCached = '.var_export($this->menuOutput, true).'; ?>');
				 @fclose($f);
		}
    return $this->menuOutput;
  }
	/** 
	*   getTabs()
	* 	For source formatting each depth level should be alligned with a number of tabs
	* 	
	* 	parameters: 
	* 				j - the depth
	* 	return: - a string with j tabs
	*/ 
	function getTabs($j){
			if (empty($this->tabs[$j])){
					$tabs = '';
					for ($i=0; $i < $j; $i++){
							$tabs .= "\t";
					}
					$this->tabs[$j] = $tabs;
			}
			return $this->tabs[$j];
	}
	/** 
	*   _renderRecursive()
	* 	Transform the data recursivelly from the internal array format into the output HTML
	* 	
	* 	parameters: 
	* 				id - the id of the parent node
	* 				level - the level of the childrens
	* 	return: - the output HTML
	*/ 
 
  function _renderRecursive($id = null, $level = 0) {
		$src = '';
		$t = $this->getTabs($level);
		// start tag
		if (empty($id)){
			$id='parent';
			if (empty($this->DBItems['parent']) || (!(sizeof($this->DBItems['parent']) > 0))){
				return 'No data to render.';
			}
			$src .='<div id="'.$this->menuName.'" class="'.$this->menuLayout.'">'."\n".'<ul class="'.$this->menuSkin.'">'."\n";
		}else{
			if (!empty($this->DBItems[$id])){
					$src .= $t.'<ul>'."\n";
			}else{
					// no childs
					return;
			}
		}

		foreach($this->DBItems[$id] as $key=>$val){
				//if lev1 with images
				$li_class = '';
				if ($id == 'parent' && $this->menuImgReplace){
					$val['name'] = '<img src="'.$this->menuImgDir.str_replace(rawurlencode('{name}'), rawurlencode($val['name']), $this->menuImgNames).'" alt="'.$val['title'].'"'.(!empty($this->menuImgWidth)?' width="'.$this->menuImgWidth.'"':'').(!empty($this->menuImgHeight)?' height="'.$this->menuImgHeight.'"':'').'/>';
					$li_class = ' class="hasImg"';
				}
				//the efective row
				$src .= $t."\t".'<li'.$li_class.'><a href="'.$val['url'].'"'.
								(!empty($val['target'])?(' target="'.$val['target'].'"'):'').''.
								(!empty($val['title'])?(' title="'.$val['title'].'"'):'').''.
								'>'.$val['name'].'</a>'."\n";
				// stop at level
				if ($this->menuLevel < 0 || $this->menuLevel > $level+1){
						// the childrens
						$src .= $this->_renderRecursive($val['id'], $level+1);
				}
				$src .= $t."\t".'</li>'."\n";
		}
		$src .= $t.'</ul>'."\n";

		// end tag
		if ($id == 'parent'){
			$src .= '<br />';
			// the final js
			$src .= $this->getTabs(1).'<script type="text/javascript">'."\n".$this->getTabs(2).'var obj_'.$this->menuName.' = new CSSMenu("'.$this->menuName.'");'."\n".$this->getTabs(2).'obj_'.$this->menuName.'.setTimeouts('.$this->menuShowTimeout.', '.$this->menuHideTimeout.', '.$this->menuExitTimeout.');';
			$src .= "\n".$this->getTabs(2).'obj_'.$this->menuName.'.setImageHoverPattern("'.$this->menuHoverImg.'");'."\n".$this->getTabs(2).'obj_'.$this->menuName.'.setHighliteCurrent('.($this->menuHighlight?'true':'false').($this->menuHighlight?', "'.$this->menuHighlightImg.'"':'').');';
			if (!empty($this->menuZoom)){
					$src .= "\n".$this->getTabs(2).'obj_'.$this->menuName.'.setAnimation("'.$this->menuZoom.'");';
			}
			$src .= "\n".$this->getTabs(2).'obj_'.$this->menuName.'.setSubMenuOffset('.$this->menuOffset['x1'].', '.$this->menuOffset['y1'].', '.$this->menuOffset['x2'].', '.$this->menuOffset['y2'].');';
			if ($this->menuLayout == 'tab'){
					$src .= "\n".$this->getTabs(2).'obj_'.$this->menuName.'.setPersistentTab('.(!empty($this->menuPersistentTab)?'true':'false').');';
			}
			$src .= "\n".$this->getTabs(2).'obj_'.$this->menuName.'.show();'."\n".$this->getTabs(1).'</script>';
			$src .= '</div>'."\n";
		}
		return $src;
  }

	/** 
	*  _getUnformatedData()
	* 	Transform the data from the database into an internal format
	* 	parameters: none
	* 	return: nothing;
	*/ 
  function _getUnformatedData() {
    $this->DBItems = array();
    $PKvalues = array();
    $FKvalues = array();
    if (is_resource($this->query)) {
      include_once(dirname(realpath(__FILE__)).'/MX_Menu2_recordset.class.php');
      $rs = new MX_Menu2_recordset($this->query);
    } else {
      $rs = &$this->query;
      $rs->MoveFirst();
    }
		$order=0;
		while (!$rs->EOF){
				$order++;

				$pk = $rs->Fields($this->menuPK);
				$fk = $rs->Fields($this->menuFK);
				if (empty($fk)){
						$fk = 'parent';
				}
				$this->DBItems[$fk][$order]['id'] = $pk;
				$this->DBItems[$fk][$order]['name'] = htmlentities(stripslashes(trim($rs->Fields($this->menuNameField))));
				
				$target = '';
				if ($this->isStaticURL) {
  			      $url = $this->menuLink . $rs->Fields($this->menuURLParameter);
        			$target = $this->menuTarget;
      	} else {
							$url = $rs->Fields($this->menuLinkField);
        			if (!empty($this->menuTargetField)) {
          				$target = $rs->Fields($this->menuTargetField);
			        }
				}
				$this->DBItems[$fk][$order]['url'] = $url;
				$this->DBItems[$fk][$order]['target'] = $target;
	    	if (!empty($this->menuTitleField)) {
  		      $title = htmlentities(stripslashes(trim($rs->Fields($this->menuTitleField))));
 						$this->DBItems[$fk][$order]['title'] = $title;
				}
				else {
						$this->DBItems[$fk][$order]['title'] = '';
				}

				$rs->MoveNext();
		}
		//reset so user may reuse the recordset
		$rs->MoveFirst();
   	return; 
  }
}
?>