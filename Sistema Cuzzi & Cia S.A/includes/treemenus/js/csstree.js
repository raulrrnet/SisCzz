$KT_CSSTREE_DEFAULTS = {
	classname: 'ktcsstree'
}


/* binding */
KT_csstrees = [];
CssTree = function(id, marker) {
	this.id = id;
	this.div = utility.dom.getElem(id);
	this.error = false;
	var tmpul = utility.dom.getChildrenByTagName(this.div, 'UL');
	if (tmpul.length == 0) {
		this.error = true;
		return;
	}
	var tmplis = utility.dom.getChildrenByTagName(tmpul[0], 'LI');
	if (tmplis.length == 0) {
		this.error = true;
		return;
	}

	if (!this.can_attach()) {
		this.error = true;
		return false;
	}
	if (!this.extract_options()) {
		this.error = true;
		return false;
	}

	if (typeof(marker) == 'undefined') marker = this.div.id;
	this.marker = marker;

	this.current_path = '';

	csstree_attach(this, this.div);
}
CssTree.prototype.can_attach = function() {
	return true;
}
CssTree.prototype.extract_options = function() {
	this.options = {};
	return true;
}

CssTree.prototype.remove_node_class = function(li, cn) {
	if (typeof cn == 'undefined') cn = "current";
	//trace(li.kt_path, 'red')
	utility.dom.classNameRemove(li, cn);
	utility.dom.classNameRemove(li, "lev" + li.kt_lev + "_" + cn);
	utility.dom.classNameRemove(
		utility.dom.getChildrenByTagName(utility.dom.getChildrenByTagName(li, 'DIV')[0], 'A')[0], 
		cn
	);
	utility.dom.classNameRemove(
		utility.dom.getChildrenByTagName(utility.dom.getChildrenByTagName(li, 'DIV')[0], 'A')[0], 
		"lev" + li.kt_lev + "_" + cn
	);
}

CssTree.prototype.add_node_class = function(li, cn) {
	if (typeof cn == 'undefined') cn = "current";
	//trace(li.kt_path, 'blue')
	utility.dom.classNameAdd(li, cn + " lev" + li.kt_lev + "_" + cn);
	utility.dom.classNameAdd(
		utility.dom.getChildrenByTagName(utility.dom.getChildrenByTagName(li, 'DIV')[0], 'A')[0], 
		cn + " lev" + li.kt_lev + "_" + cn
	);
}


////////////////////////////////////////////////////////////////////////////////


function csstree_click(e) {
	var o = utility.dom.setEventVars(e);
	var li = this.parentNode.parentNode;
	var menu = KT_csstrees[li.kt_marker];

	var uls = utility.dom.getChildrenByTagName(li, 'UL');
	if (Array_indexOf(utility.dom.getClassNames(li), 'current') == -1) {
		menu.add_node_class(li, 'current');
		if (uls.length) {
			utility.dom.showElem(uls[0]);
			utility.dom.classNameRemove(utility.dom.getChildrenByTagName(this.parentNode, 'SPAN')[0], "plus");
			utility.dom.classNameAdd(utility.dom.getChildrenByTagName(this.parentNode, 'SPAN')[0], "minus");
		}
	} else {
		if (uls.length) {
			utility.dom.hideElem(uls[0]);
			utility.dom.classNameRemove(utility.dom.getChildrenByTagName(this.parentNode, 'SPAN')[0], "minus");
			utility.dom.classNameAdd(utility.dom.getChildrenByTagName(this.parentNode, 'SPAN')[0], "plus");
		}
		menu.remove_node_class(li, 'current');
	}

	return utility.dom.stopEvent(o.e);
}

function csstree_attach(menu, parentObj, path, lev) {
	if (typeof(lev) == 'undefined') lev = 0;
	if (!path) path = '';

	lev++;
	var uls = utility.dom.getChildrenByTagName(parentObj, 'UL');
	var lis = [];

	if (uls.length == 0) {
		return;
	}
	var ul = uls[0];
	if (uls.length == 1 && lev > 1) {
		utility.dom.classNameAdd(ul, 'lev' + lev);
	}
	lis = utility.dom.getChildrenByTagName(ul, 'LI');

	// init box calculator based on type of menu
	Array_each(lis, function(li, i) {
		////////////////////////////////////////
		// add class names
		////////////////////////////////////////
		var addclass, img, a, div, state = ''; // possible states  are: off, plus, minus
		addclass = 'lev' + lev + 
			' pos' + (i+1) + 
			' lev' + lev + '_pos' + (i+1);
		if (i == 0) 
			addclass += ' first lev' + lev + '_first';
		if (i == (lis.length - 1)) 
			addclass += ' last lev' + lev + '_last';

		if (utility.dom.getChildrenByTagName(li, 'UL').length) {
			addclass += ' haschildren lev' + lev + '_haschildren';
			state = "plus";
		}
		
		var issel = false;
		if (
			Array_indexOf(utility.dom.getClassNames(li), 'selected') != -1 || 
			utility.dom.getElementsByClassName(li, 'selected', 'LI').length
		) {
			issel = true;
			addclass += ' current lev' + lev + '_current';
			
			if (state == "plus") {
				state = "minus";
			}
		}
		if (Array_indexOf(utility.dom.getClassNames(li), 'selected') != -1) {
			addclass += ' selected lev' + lev + '_selected';
		}
		
		utility.dom.classNameAdd(li, addclass);
		utility.dom.classNameAdd(utility.dom.getChildrenByTagName(li, 'A')[0], addclass);

		////////////////////////////////////////
		// add makers and events
		////////////////////////////////////////
		li.kt_marker = menu.marker;
		li.kt_lev = lev;
		li.kt_pos = (i+1);
		li.kt_path = path + '_' + (i+1);

		var sign = document.createElement('SPAN');
		
		utility.dom.classNameAdd(sign, state);
		sign.innerHTML = "&#160;";
		
		a = utility.dom.getChildrenByTagName(li, 'A')[0];
		div = utility.dom.getChildrenByTagName(li, 'DIV')[0];

		div = document.createElement('DIV');
		li.insertBefore(div, li.firstChild);

		a = utility.dom.getChildrenByTagName(li, 'A')[0];
		div = utility.dom.getChildrenByTagName(li, 'DIV')[0];

		div.appendChild(sign);
		div.appendChild(a);
		
		utility.dom.attachEvent(sign, 'onclick', csstree_click);
		Array_each(['ondblclick','onselect','onselectstart','ondragstart'], function(ev){
			utility.dom.attachEvent(sign, ev, function(e){
				var o = utility.dom.setEventVars(e);
				return utility.dom.stopEvent(o.e);
			});
		});
		if (Array_indexOf(['', '#', window.location.href, window.location + '#'], a.href) != -1) {
			utility.dom.attachEvent(a, 'onclick', csstree_click);
		}

		// open selected items and its parents
		var uls = utility.dom.getChildrenByTagName(li, 'UL');
		var ul = null;
		if (uls.length == 1) {
			ul = uls[0];
			if (issel) {
				ul.style.display = "block";
			}
		}

		////////////////////////////////////////
		// recurse add and fix visibility, display trick
		////////////////////////////////////////
		csstree_attach(menu, li, path + '_' + (i+1), lev);

		// make the selected ul visible in a horizontal2 menu
	});
}

////////////////////////////////////////////////////////////////
// binding
////////////////////////////////////////////////////////////////
function csstree_bind(id, marker) {
	var newmenu = null;
	if (typeof KT_csstrees[id] == 'undefined') {
		newmenu = new CssTree(id)
		if (!newmenu.error) {
			KT_csstrees[id] = newmenu;
		} else {
			//alert('Cannot attach menu: ' + id)
		}
	}
}
function csstree_bind_all() {
	var uidgen = new UIDGenerator();
	Array_each(utility.dom.getElementsByClassName(document, $KT_CSSTREE_DEFAULTS.classname, 'div'), function(div, i){
		if (typeof(div.id) == 'undefined' || !div.id) {
			div.id = uidgen.generate();
		}
		csstree_bind(div.id);
	});
}
utility.dom.attachEvent2(window, 'onload', csstree_bind_all);

