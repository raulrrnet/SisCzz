
Kore_DEVELOPMENT=false;Class={create:function(){return function(){this.initialize.apply(this,arguments);};}};Function.prototype.bind=function(){var _1=this;var _2=$A(arguments);var _3=_2.shift();return function(){return _1.apply(_3,_2.concat($A(arguments)));};};Function.prototype.bindAsEventListener=function(_4){var _5=this;return function(_6){return _5.call(_4,_6||window.event);};};Object.extend=function(_7,_8){for(var _9 in _8){_7[_9]=_8[_9];}
return _7;};Object.copy=function(_a){return Object.extend(new Object(),_a);};$A=Array.from=function(_b){if(!_b){return[];}
if(_b.toArray){return _b.toArray();}else{var _c=[];for(var i=0;i<_b.length;i++){_c.push(_b[i]);}
return _c;}};Enumerable={_break:{},_each:function(_e){for(var _f in this){var _10=this[_f];if(typeof _10=="function"){continue;}
var _11=[_f,_10];_11.key=_f;_11.value=_10;_e(_11);}},each:function(_12){var _13=0;try{this._each(function(_14){try{_12(_14,_13++);}
catch(e){throw e;}});}
catch(e){if(e!=Enumerable._break){throw e;}}},include:function(_15){var _16=false;this.each(function(_17){if(_17==_15){_16=true;throw Enumerable._break;}});return _16;},inject:function(_18,_19){this.each(function(_1a,_1b){_18=_19(_18,_1a,_1b);});return _18;},collect:function(_1c){var _1d=[];this.each(function(_1e,_1f){_1d.push(_1c(_1e,_1f));});return _1d;},findAll:function(_20){var _21=[];this.each(function(_22,_23){if(_20(_22,_23)){_21.push(_22);}});return _21;}};Object.extend(Enumerable,{map:Enumerable.collect});Object.extend(Array.prototype,Enumerable);Object.extend(Array.prototype,{_each:function(_24){for(var i=0;i<this.length;i++){_24(this[i]);}},last:function(){return this[this.length-1];}});Object.extend(String.prototype,{toQueryParams:function(){if(this.length!=0){var _26=this.match(/^\??(.*)$/)[1].split("&");return _26.inject({},function(_27,_28){var _29=_28.split("=");_27[_29[0]]=_29[1];return _27;});}else{return{};}},trim:function(){return this.replace(/^\s*/,"").replace(/\s*$/,"");},escape_entities:function(){return this.replace(/\&/g,"&amp;").replace(/"/g,"&quot;").replace(/</g,"&lt;").replace(/>/g,"&gt;");},unescape_entities:function(){return this.replace(/\&amp;/,"&").replace(/\&quot;/,"\"").replace(/\&lt;/,"<").replace(/\&gt;/g,">");}});String.prototype.parseQuery=String.prototype.toQueryParams;Hash={toQueryString:function(){var _2a=this.map(function(_2b){var _2c=((typeof _2b[0]=="string")||(typeof _2b[0]=="number"))&&((typeof _2b[1]=="string")||(typeof _2b[1]=="number"));return _2c?_2b.map(encodeURIComponent).join("="):null;});var _2d=_2a.findAll(function(_2e){return _2e!==null;});return _2d.join("&");}};function $H(_2f){var _30=Object.extend({},_2f||{});Object.extend(_30,Enumerable);Object.extend(_30,Hash);return _30;}
Form={};Form.serialize=function(frm){var _32=new Array();var _33=null;var _34="";var _35=null;var _36=null;for(var i=0;i<frm.elements.length;i++){_33=frm.elements[i];if(_33.disabled){continue;}
try{if(!_33.name){continue;}}
catch(err){continue;}
_34=_33.type?_33.type.toLowerCase():"";if(!_34){continue;}
_35=null;switch(_34){case"submit":case"hidden":case"password":case"text":case"textarea":_35=[_33.name,_33.value];break;case"checkbox":case"radio":if(_33.checked){_35=[_33.name,_33.value];}
break;case"select-one":var _38="";var opt;var _3a=_33.selectedIndex;if(_3a>=0){opt=_33.options[_3a];_38=opt.value||"";}
_35=[_33.name,_38];break;case"select-multiple":var _38=[];for(var j=0;j<_33.length;j++){var opt=_33.options[j];if(opt.selected){_38.push(opt.value||"");}}
_35=[_33.name,_38];break;}
if(_35!=null){var _3c=Kore.getDocumentCharset();var _3d=_3c.toLowerCase()=="iso-8859-1"?escape:encodeURIComponent;_36=_3d(_35[0])+"="+_3d(_35[1]);_32.push(_36);}}
return _32.join("&");};if(!Kore){var Kore={};}
Kore._empty=function(){};Kore.container=null;Kore.addLoadListener=function(_3e,_3f){if(typeof _3f=="undefined"||_3f==null){throw"Calling addLoadListener without a scope is not allowed.\n"+"Remove information must be stored.";}
if(Kore.container!=null){Kore.container.loadEvent.subscribe(_3e,_3f,true);}else{YAHOO.util.Event.addListener(window,"load",_3e,_3f,true);}};Kore.removeLoadListener=function(_40,_41){if(_41.loadContainer){_41.loadContainer.loadEvent.unsubscribe(_40,_41);}else{YAHOO.util.Event.removeListener(window,"load",_40,_41);}};Kore.addUnloadListener=function(_42,_43){if(typeof _43=="undefined"||_43==null){throw"Calling addUnloadListener without a scope is not allowed.\n"+"Remove information must be stored.";}
if(Kore.container!=null){Kore.container.unloadEvent.subscribe(_42,_43,true);_43.unloadContainer=Kore.container;}else{YAHOO.util.Event.addListener(window,"unload",_42,_43,true);}};Kore.removeUnloadListener=function(_44,_45){if(_45.unloadContainer){_45.unloadContainer.unloadEvent.unsubscribe(_44,_45);}else{YAHOO.util.Event.removeListener(window,"unload",_44,_45);}};Kore.getIncludesBase=function(_46,_47){var s=null;var _49=document.getElementsByTagName("script");for(var i=0;i<_49.length;i++){var url=_49[i].src;if(typeof url!=="undefined"){if(url.indexOf("includes/kore/kore.js")!=-1){s=_49[i];break;}}}
if(s==null){window.setTimeout(function(){Kore.getIncludesBase(_46);},10);return null;}
var url=s.src;url=url.replace(/includes\/kore\/kore\.js/,"");if(typeof _46=="function"){if(!_47){_47=window;}
_46.call(_47,url);}
return url;};Kore.getDegradableCall=function(){var url="";var L=top.location;url=L.protocol+"//"+L.host+L.pathname+L.search;if(typeof top.$ctrl!="undefined"){var _4e=top.location.hash.replace(/^#/,"");if(_4e){url=top.$app_path+"?"+_4e;}}
return url;};Kore._dependencies=null;Kore._pathToDependenciesFile="includes/kore/dependencies.js";Kore._loaderService="includes/kore/ldr/resProviderService";Kore._pathToLogging="includes/kore/log/loggingService";Kore.Cache=function(){this._cache={};this._callbacks={};};Kore.Cache=Object.extend(new Kore.Cache(),{add:function(key,_50){if(key.indexOf("includes/kore/kore.js")!=-1){this._cache[key]={"value":"","state":Kore.Cache.States.executed};return;}
this._cache[key]={"value":_50,"state":0};},setValue:function(key,_52){var _53=this._get(key);if(_53!=null){_53.value=_52;}},getValue:function(key){var _55=this._get(key);if(_55!=null){return _55.value;}},_get:function(key){var _57=this._cache[key];if(!_57){return null;}
return _57;},setState:function(key,_59){var _5a=this._get(key);if(_5a!=null&&_5a.state!=_59){_5a.state=_59;this._fireStateChange(key,_59);}},getState:function(key){var _5c=this._get(key);if(_5c!=null){return _5c.state;}},has:function(key){return(this._get(key)!=null);},_fireStateChange:function(key,_5f){var _60=this._callbacks[key];if(!_60){return;}
for(var i=0;i<_60.length;i++){var li=_60[i];if(li.state==_5f){(li.fn||Kore._empty)(key);}}},_addStateChangeListener:function(key,_64,fn){if(!this._callbacks[key]){this._callbacks[key]=[];}
this._callbacks[key].push({"fn":fn,"state":_64});if(this.getState(key)==_64){fn(key);}}});Kore.Cache.States={"loading":0,"loaded":1,"executed":4};Kore.getDependencies=function(_66){if(Kore._dependencies==null){var _67="";var _68=new Kore.Request(_66+Kore._pathToDependenciesFile,{method:"get",asynchronous:false});if(_68.transport.responseText){_67=_68.transport.responseText;}
try{Kore._dependencies=eval("("+_67+")");}
catch(err){Kore._dependencies={};}}
return Kore._dependencies;};Kore.Loader=Class.create();Kore.Loader.prototype={relPath:null,initialize:function(){},setRelPath:function(_69){this.relPath=_69;},setServerExtension:function(_6a){this.serverExtension=_6a;},addModule:function(_6b){if(!this.modulesToLoad.include(file)){this.modulesToLoad.push(file);}},loadModulesClientSide:function(_6c){if(this.modulesToLoad.length==0){return;}
var _6d=this.buildModulesFilesList(this.modulesToLoad);for(var i=0;i<_6d.files.length;i++){this.addFile(_6d.files[i][0]);}
var _6f=this;this.loadFiles(function(){_6f.modulesToLoad=new Array();(_6c||Kore._empty)();});},buildModulesFilesList:function(_70){var _71=Kore.getDependencies(this.relPath);var _72=[];var _73=",";var _74=[];var _75="";for(var i=0;i<_70.length;i++){_75=_70[i];if(_71[_75]){for(var j=0;j<_71[_75].includes.length;j++){var _78=_71[_75].includes[j];if((_73+",").indexOf(","+_78+",")!=-1){continue;}
_73+=","+_78;_74.push([_78,""]);}
_75+="_"+_71[_75].version;_72.push(_75);}}
return{modules:_72,files:_74};},setServerSide:function(val){this.serverSide=val;},load:function(_7a){if(this.modulesToLoad.length==0){(_7a||Kore._empty)();return;}
if(!this.serverSide){this.loadModulesClientSide(_7a);return;}
var _7b=this;var _7c=this.buildModulesFilesList(this.modulesToLoad);if(_7c.modules.length){var _7d=Kore._loaderService+"."+this.serverExtension+"?"+this.type+"module="+_7c.modules.join("|");if(!Kore.Cache.has(_7d)){Kore.Cache.add(_7d,"");Kore.Cache._addStateChangeListener(_7d,Kore.Cache.States.loaded,function(_7e){this.modulesToLoad=[];this.interpretFile(_7e);(_7a||Kore._empty)();}.bind(this));this.loadFile(_7d,true);}else{if(!this.isLoaded(_7d)){Kore.Cache._addStateChangeListener(_7d,Kore.Cache.States.loaded,function(_7f){this.modulesToLoad=[];(_7a||Kore._empty)();}.bind(this));}}}else{(_7a||Kore._empty)();}},isAbsolutePath:function(src){var _81=false;if(src.toString().match(/^(https?\:\/\/|\/)/)){_81=true;}
return _81;},loadFile:function(_82,_83){if(this.notFoundFiles[_82]){return;}
var _84=this;var _85=_82;if(!this.isAbsolutePath(_85)){_85=this.relPath+_82;}
var _86=new Kore.Request(_85,{method:"get",asynchronous:_83,onComplete:function(_87){if(_87.status==404){_84.notFoundFiles[_82]=true;Kore.Cache.setValue(_82,"");Kore.Cache.setState(_82,Kore.Cache.States.loaded);if(_82.indexOf(Kore._loaderService)!=-1){return;}}else{Kore.Cache.setValue(_82,_87.responseText);Kore.Cache.setState(_82,Kore.Cache.States.loaded);}},on404:function(_88){_84.notFoundFiles[_82]=true;if(_82.indexOf(Kore._loaderService)!=-1){_84.setServerSide(false);_84.loadModulesClientSide();}}});if(!_83){if(_86.transport.status==404){this.notFoundFiles[_82]=true;Kore.Cache.setValue(_82,"");}else{Kore.Cache.setValue(_82,_86.transport.responseText);}
Kore.Cache.setState(_82,Kore.Cache.States.loaded);}},loadFiles:function(_89){if(this.relPath==null){Kore.getIncludesBase(function(url){this.relPath=url;this._loadFiles(_89);},this);}else{this._loadFiles(_89);}},isLoaded:function(_8b){return(Kore.Cache.getState(_8b)==Kore.Cache.States.loaded||Kore.Cache.getState(_8b)==Kore.Cache.States.executed);},_loadFiles:function(_8c){if(this.filesToLoad.length==0){(_8c||Kore._empty)();return;}
var _8d=0;for(var i=0;i<this.filesToLoad.length;i++){var _8f=this.filesToLoad[i];if(_8f.indexOf("includes/kore/kore.js")!=-1){Kore.Cache.add(_8f,null);this.finalizeLoad(_8c);continue;}
if(!Kore.Cache.has(_8f)){Kore.Cache.add(_8f,null);Kore.Cache._addStateChangeListener(_8f,Kore.Cache.States.loaded,function(_90){this.loadedFiles[_90]=Kore.Cache.getValue(_90);this.finalizeLoad(_8c);}.bind(this));this.loadFile(_8f,true);}else{if(this.isLoaded(_8f)){this.finalizeLoad(_8c);}else{Kore.Cache._addStateChangeListener(_8f,Kore.Cache.States.loaded,function(_91){this.loadedFiles[_91]=Kore.Cache.getValue(_91);this.finalizeLoad(_8c);}.bind(this));}}}},finalizeLoad:function(_92){this.loadedCount++;if(this.filesToLoad.length==this.loadedCount){for(var j=0;j<this.filesToExecute.length;j++){this.interpretFile(this.filesToExecute[j]);}
(_92||Kore._empty)();}},interpretSource:function(_94){}};Kore.JSLoader=Class.create();Kore.JSLoader.prototype=Object.extend(new Kore.Loader(),{type:"js",initialize:function(_95){this.modulesToLoad=new Array();this.filesToLoad=new Array();this.filesToExecute=new Array();this.loadedFiles={};this.serverSide=true;this.relPath=Kore.getIncludesBase();this.serverExtension="";this.loadedCount=0;this.notFoundFiles={};if(typeof _95=="undefined"){_95=true;}
this.doEvaluation=_95;},interpretSource:function(_96){if(_96.trim()==""){return;}
try{if(window.execScript){_96=_96.replace(/^[\r\n\s]*<!--/i,"").replace(/\/\/-->[\r\n\s]*$/i,"");window.execScript(_96,"JavaScript");}else{if(navigator.userAgent.indexOf("Safari")>0){_96=_96.replace(/\r\nvar\s+([a-z0-9_\-\$]+)\s*\=/ig,"\r\nwindow['$1'] =");_96=_96.replace(/\r\nfunction\s+([a-z0-9_\-]+)\s*\(/ig,"\r\nwindow['my$1'] = my$1; function $1(){return my$1.apply(this, arguments);}; window['$1']=$1; function my$1(");}
window.eval(_96);}}
catch(err){Kore.Log.info("Error in Kore.JSLoader.interpretSource:\r\n["+err.message+"]\n\n"+_96);}},interpretFile:function(_97){if(!this.doEvaluation){return;}
if(Kore.Cache.getState(_97)!=Kore.Cache.States.executed){var src=Kore.Cache.getValue(_97);this.interpretSource(src);Kore.Cache.setState(_97,Kore.Cache.States.executed);}},loadJsFile:function(_99){if(this.isLoaded(_99)){this.interpretFile(_99);return;}
Kore.Cache._addStateChangeListener(_99,Kore.Cache.States.loaded,this.interpretFile.bind(this));this.loadFile(_99,false);},addFile:function(_9a){if(this.isLoaded(_9a)){this.interpretFile(_9a);return false;}
if(!this.filesToLoad.include(_9a)){this.filesToLoad.push(_9a);}
this.filesToExecute.push(_9a);}});Kore.CSSLoader=Class.create();Kore.CSSLoader.prototype=Object.extend(new Kore.Loader(),{type:"css",initialize:function(_9b){this.modulesToLoad=new Array();this.filesToLoad=new Array();this.filesToExecute=new Array();this.loadedCount=0;this.loadedFiles={};this.serverSide=true;this.relPath=Kore.getIncludesBase();this.serverExtension="";if(typeof _9b=="undefined"){_9b=true;}
this.doEvaluation=_9b;this.notFoundFiles={};},interpretFile:function(_9c){if(!this.doEvaluation){return;}
var src=Kore.Cache.getValue(_9c);if(Kore.Cache.getState(_9c)!=Kore.Cache.States.executed){if(document.createStyleSheet){var _9e=document.getElementsByTagName("HEAD")[0];var _9f=document.createElement("link");_9f.rel="stylesheet";_9f.type="text/css";_9f=(_9e||document.body).appendChild(_9f);_9f.href=_9c;}else{this.interpretSource("@import \""+_9c+"\";");}
Kore.Cache.setState(_9c,Kore.Cache.States.executed);}},interpretSource:function(css){var _a1=document.getElementsByTagName("head")[0];if(document.createStyleSheet){var _a2=document.createElement("style");_a2=(_a1||document.body).appendChild(_a2);if(_a2){_a2.styleSheet.cssText=css;}}else{var tmp=document.createElement("SPAN");tmp.innerHTML="<style>"+css+"</style>";try{(_a1||document.body).appendChild(tmp.firstChild);}
catch(err){Kore.Log.info("CssLoader interpret source error:"+err.message+"\r\n"+css);}}},loadCssFile:function(_a4){if(this.isLoaded(_a4)){return;}
Kore.Cache._addStateChangeListener(_a4,Kore.Cache.States.loaded,function(_a5){this.interpretFile(_a5);}.bind(this));this.loadFile(_a4,false);},addFile:function(_a6){if(this.isLoaded(_a6)){return false;}
if(!this.filesToLoad.include(_a6)){this.filesToLoad.push(_a6);}
this.filesToExecute.push(_a6);}});Kore.Log=function(){};Kore.Log.info=function(msg){if(Kore_DEVELOPMENT){alert(msg);}else{var _a8=new Kore.Log();_a8.send(msg);}};Kore.Log.prototype={serverExtension:"php",send:function(msg){var _aa=Kore.getIncludesBase();var _ab=_aa+Kore._pathToLogging+"."+this.serverExtension+"?"+"message="+msg;var _ac=new Kore.Request(_ab,{method:"get",asynchronous:true});}};Kore.Request=function(url,_ae){this.transport=this.getTransport();this.setOptions(_ae);this.request(url);};Kore.Request.Events=["Uninitialized","Loading","Loaded","Interactive","Complete"];Kore.Request.prototype={getTransport:function(){var ret=false;var _b0=["new XMLHttpRequest()","new ActiveXObject(\"Msxml2.XMLHTTP\")","new ActiveXObject(\"Microsoft.XMLHTTP\")"];for(var i=0;i<_b0.length;i++){try{ret=eval(_b0[i]);break;}
catch(err){ret=false;}}
return ret;},setOptions:function(_b2){this.options={method:"post",asynchronous:true,contentType:"application/x-www-form-urlencoded",parameters:""};Object.extend(this.options,_b2||{});},responseIsSuccess:function(){return this.transport.status==undefined||this.transport.status==0||(this.transport.status>=200&&this.transport.status<300);},responseIsFailure:function(){return!this.responseIsSuccess();},request:function(url){var _b4=this.options.parameters||"";if(_b4.length>0){_b4+="&_=";}
try{this.url=url;if(this.options.method=="get"&&_b4.length>0){this.url+=(this.url.match(/\?/)?"&":"?")+_b4;}
this.transport.open(this.options.method,this.url,this.options.asynchronous);if(this.options.asynchronous){var _b5=this;this.transport.onreadystatechange=function(){_b5.onStateChange();};setTimeout((function(){_b5.respondToReadyState(1);}),10);}
this.setRequestHeaders();var _b6=this.options.postBody?this.options.postBody:_b4;this.transport.send(this.options.method=="post"?_b6:null);}
catch(e){}},setRequestHeaders:function(){var _b7=["X-Requested-With","XMLHttpRequest","Accept","text/javascript, text/html, application/xml, text/xml, */*"];if(this.options.method=="post"){_b7.push("Content-type",this.options.contentType);if(this.transport.overrideMimeType){_b7.push("Connection","close");}}
if(this.options.requestHeaders){for(var i=0;i<this.options.requestHeaders.length;i++){_b7.push(this.options.requestHeaders[i]);}}
for(var i=0;i<_b7.length;i+=2){this.transport.setRequestHeader(_b7[i],_b7[i+1]);}},onStateChange:function(){var _b9=this.transport.readyState;if(_b9!=1){this.respondToReadyState(this.transport.readyState);}},respondToReadyState:function(_ba){if(typeof Kore=="undefined"){return;}
var _bb=Kore.Request.Events[_ba];var _bc=this.transport;if(_bb=="Complete"){try{(this.options["on"+this.transport.status]||this.options["on"+(this.responseIsSuccess()?"Success":"Failure")]||Kore._empty)(_bc);}
catch(e){}}
try{(this.options["on"+_bb]||Kore._empty)(_bc);}
catch(e){}
if(_bb=="Complete"){this.transport.onreadystatechange=Kore._empty;}}};Kore.getDocumentCharset=function(){if(typeof(Kore.charset)!="undefined"){return Kore.charset;}
var _bd="";if(/Opera[\/\s]\d/i.test(navigator.userAgent)){var _be=document.getElementsByTagName("META");var m=null;for(var i=0;i<_be.length;i++){if(_be[i].httpEquiv.toString().toLowerCase()=="content-type"){m=_be[i].content.match(/text\/html\s*;\s*charset\s*=\s*([^\s]*)/i);if(m){_bd=m[1];}}}}else{_bd=document.charset?document.charset:document.characterSet;}
if(typeof _bd=="undefined"){_bd="iso-8859-1";}
Kore.charset=_bd;return Kore.charset;};Kore.Url={};Kore.Url.getParamsFromCurrentUrl=function(_c1){var _c2;if(_c1){_c2=[$H(window.location.search.replace(/^\?/,"").parseQuery()).toQueryString(),$H(window.location.hash.replace(/^\#/,"").parseQuery()).toQueryString()];return _c2;}else{var _c3=window.location.href.toString();_c2=(/\?/.test(_c3))?_c3.replace(/^.*\?/,""):"";return $H(_c2.parseQuery()).toQueryString();}};Kore.isOkForAjax=function(){var _c4=false;if(Kore.is.ie&&Kore.is.version>=6){_c4=true;}
if(Kore.is.opera&&Kore.is.version>=9){_c4=true;}
if(Kore.is.mozilla&&Kore.is.version>=1.6){_c4=true;}
if(Kore.is.safari&&Kore.is.version>=1.4){_c4=true;}
return _c4;};