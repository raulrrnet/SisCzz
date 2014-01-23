
if(typeof Widgets=="undefined"){Widgets={};}
Widgets.Gallery=Class.create();Widgets.gallery_default_options={"thumbnails":{"width":60,"height":40},"width":500,"height":300,"show_loading_indicator":true,"play_timeout":5000};Widgets.Gallery.prototype={photos:[],scroll_left_timeout:null,scroll_right_timeout:null,play_timeout:null,currentImage:null,RETRY:function(_1){window.setTimeout(function(){this[_1]();}.bind(this),10);return false;},initialize:function(id,_3){this.photos=[];this.id=id;this.options=Object.extend(Object.copy(Widgets.gallery_default_options),_3);var _4=new Kore.JSLoader();_4.addFile("includes/yui/yahoo/yahoo.js");_4.addFile("includes/yui/dom/dom.js");_4.addFile("includes/yui/event/event.js");_4.addFile("includes/yui/animation/animation.js");_4.addFile("includes/yui/connection/connection.js");_4.addFile("includes/kore/js/error.js");_4.addFile("includes/kore/js/browser/browser.js");_4.addFile("includes/kore/js/dataprovider/transporter.js");_4.addFile("includes/kore/js/dataprovider/dataprovider.js");_4.addFile("includes/kore/js/dataprovider/jsonprovider.js");_4.addFile("includes/kore/js/dataprovider/xmlprovider.js");_4.addFile("includes/kore/js/dataprovider/htmlprocessor.js");_4.addFile("includes/jaxon/widgets/tooltip/js/tooltip.js");_4.loadFiles(function(){if(!Kore.isOkForAjax()){return false;}
if(Kore.is.ie&&(Kore.is.version==6)){try{document.execCommand("BackgroundImageCache",false,true);}
catch(e){}}
Kore.addUnloadListener(this.unload,this);if(Kore.container!=null&&Kore.container.objects!=null){Kore.container.objects.push(this);}
Kore.getIncludesBase(this.getPhotos.bind(this),this);delete _4;}.bind(this));},setCurrentImage:function(_5){this.currentImage=_5;this.showCurrentImage();},showCurrentImage:function(){if(this.currentImage!==null){var _6=YAHOO.util.Dom.get(this.id+"_content");if(!_6){return;}
var _7=_6.getElementsByTagName("img");if(_7&&_7.length>0){_7=_7[0];_7.removeAttribute("width");_7.removeAttribute("height");_7.src=this.options.photo_folder+encodeURIComponent(this.currentImage);}}},unload:function(){delete this.tooltip;delete this.meta_xml;},getPhotos:function(_8){this.includesBase=_8;var _9=YAHOO.util.Dom.get(this.id+"_content");if(!_9){return;}
_9.style.width=this.options.width+"px";_9.style.height=this.options.height+"px";var _a=document.createElement("img");_a.src=this.includesBase+"includes/jaxon/widgets/gallery/css/blank.jpg";_a.width=this.options.width;_a.height=this.options.height;_9.appendChild(_a);this.showCurrentImage();var _b=Kore.Url.getParamsFromCurrentUrl().parseQuery();var _c={"gallery_id":this.id,"ServiceMethod":"getPhotoList"};Object.extend(_b,_c);_b=$H(_b).toQueryString();var DS=new Kore.JsonProvider();DS.URL=_8+"includes/jaxon/widgets/gallery/gallery.service.php"+"?"+_b;DS.updateEvent.subscribe(function(_e,_f){var _10=_f[0];if(_10.error){_10.error.show("Error no: %s has occured: \"%s"+"\" while executing query to URL: \""+_10.URL+"\".");}else{if(_10.content.error){Kore.Log.info(_10.content.error);}else{this.photos=_10.content;this.render();}}},this,true);DS.getContent();delete DS;},getMetas:function(url){if(this.options.meta_source){var L=window.location;var _13=L.protocol+"//"+L.host+L.pathname;_13=_13.replace(/\/([^\/])*$/,"/");var XS=new Kore.XmlProvider();var tmp=this.options.meta_source;if(!tmp.match(/^(https?\:\/\/|\/)/)){tmp=_13+tmp;}
XS.URL=tmp;XS.updateEvent.subscribe(function(_16,_17){var _18=_17[0];if(_18.error){_18.error.show("Error no: %s has occured: \"%s"+"\" while executing query to URL: \""+_18.URL+"\".");}else{this.meta_xml=_18.content;this.metas={};if(typeof this.options.root_node=="undefined"){var tmp=this.meta_xml.getElementsByTagName(this.options.picture_node);if(tmp.length>0){if(typeof tmp!="undefined"&&typeof tmp[0]!="undefined"){tmp=tmp[0].parentNode;this.options.root_node=tmp.nodeName;}}}
var n=this.meta_xml.getElementsByTagName(this.options.root_node);if(n.length==0){Kore.Log.info("Error has occured: "+"could not find any photos in your XML File."+"\n"+"Please check to see if the xml file is empty / the nodes are incorrect.");}
var _1b=[];for(var i=0;i<n.length;i++){var _1d=n[i].getElementsByTagName(this.options.picture_node)[0];var _1e="";if(_1d.childNodes.length>0){_1e=n[i].getElementsByTagName(this.options.picture_node)[0].childNodes[0].nodeValue;}
var _1f=n[i].getElementsByTagName(this.options.description_node)[0];var _20="";if(_1f.childNodes.length>0){_20=n[i].getElementsByTagName(this.options.description_node)[0].childNodes[0].nodeValue;}
this.metas[_1e]=_20;for(var j=0;j<this.photos.length;j++){if(this.photos[j].name==_1e){_1b.push(this.photos[j]);}}}
this.photos=_1b;}
this.draw();},this,true);XS.getContent();delete XS;}else{this.draw();}
var _22=YAHOO.util.Dom.get(this.id+"_content");if(!_22){return;}
var _23=_22.getElementsByTagName("img")[0];_23.id="_gal_img_"+Math.random().toString().replace(/\./,"");this.tooltip=new Widgets.Tooltip(_23.id);this.tooltip.contentCallback=function(){return this.findTextForTooltip();}.bind(this);},findTextForTooltip:function(idx){idx=idx||this.indexes.viewing;var ph=this.photos[idx];var _26="";if(typeof this.metas!="undefined"&&typeof this.metas[ph.name]!="undefined"&&this.metas[ph.name]!=""){_26=this.metas[ph.name];}else{_26=ph.name;}
return _26;},scrollWithOffset:function(_27,_28){if(this.tweening){return;}
var _29=YAHOO.util.Dom.get(this.id+"_thumbs");var _2a=parseInt(_29.scrollLeft,10);_27+=_2a;_27=Math.max(0,_27);var _2b=this.getMaximalRulerLeft();_27=Math.min(_27,_2b);if((_27==0||_27==_2b)&&_27==_2a){return;}
var _2c=new YAHOO.util.Scroll(_29,{scroll:{from:[_2a,0],to:[_27,0]}},this.speed);_2c.onStart.subscribe(function(){this.tweening=true;},this,true);_2c.onComplete.subscribe(function(){this.updateVisibleIndexes();this.loadAnyEmptyThumbnails();this.tweening=false;if(typeof _28!="undefined"){_28();}},this,true);_2c.animate();},getOffsetToScroll:function(_2d){return this.options.thumbnails.width*_2d;},getMinimalRulerLeft:function(){return 0;},getMaximalRulerLeft:function(){var _2e=YAHOO.util.Dom.get(this.id+"_thumbs");if(!_2e||!_2e.firstChild){return 0;}
return(_2e.firstChild.offsetWidth);},startScrollingRight:function(){if(this.scroll_right_timeout!=null){this.scrollToTheRight(1,this.startScrollingRight.bind(this));}},scrollToTheRight:function(_2f,_30){this.scrollWithOffset(-this.getOffsetToScroll(_2f),_30);},startScrollingLeft:function(){if(this.scroll_left_timeout!=null){this.scrollToTheLeft(1,this.startScrollingLeft.bind(this));}},scrollToTheLeft:function(_31,_32){this.scrollWithOffset(this.getOffsetToScroll(_31),_32);},getFullFileName:function(_33){return this.options.photo_folder+encodeURIComponent(this.photos[_33].name);},getAltValue:function(_34){return this.photos[_34].name.replace(/\.\w+$/,"");},showAndScrollImage:function(_35){this.showAndScroll(parseInt(_35.id.replace(new RegExp("^"+this.id+"_thumb_"),"")));},boxResize:function(_36,_37){if(_36.width<_37.width&&_36.height<_37.height){return _36;}
var _38=_36.width/_37.width;var _39=_36.height/_37.height;if(_38<_39){var _3a=_36.width/_39;var _3b=_37.height;}else{var _3a=_37.width;var _3b=_36.height/_38;}
return{"width":Math.round(_3a),"height":Math.round(_3b)};},showAndScroll:function(i){if(this.indexes.viewing==i){return true;}
if(this.indexes.viewing==-1){this.indexes.viewing=0;}
YAHOO.util.Dom.removeClass(this.id+"_thumb_"+this.indexes.viewing,"viewing");YAHOO.util.Dom.addClass(this.id+"_thumb_"+i,"viewing");var _3d=YAHOO.util.Dom.get(this.id+"_content");if(!_3d){return false;}
var _3e=_3d.getElementsByTagName("img")[0];if(this.options.show_loading_indicator){YAHOO.util.Dom.addClass(_3d,"big_image_loading");}
_3e.style.display="none";var _3f=this.boxResize({"width":this.photos[i].width,"height":this.photos[i].height},{"width":this.options.width,"height":this.options.height});_3e.style.marginTop=Math.floor((this.options.height-_3f.height)/2)+"px";_3e.width=_3f.width;_3e.height=_3f.height;_3e.onload=function(){YAHOO.util.Dom.removeClass(_3d,"big_image_loading");_3e.style.display="";};var _40=_3e.src.toString();var _41=this.getFullFileName(i);if(_40.indexOf(_41)==-1){_3e.src=_41;}else{_3e.onload();}
var tmp=YAHOO.util.Dom.get(this.id+"_description");if(tmp){tmp.innerHTML=this.findTextForTooltip(i);}
this.indexes.viewing=i;var _43=this.indexes.viewing-this.indexes.left;this.speed=0.5;this.scrollWithOffset(this.getOffsetToScroll(_43-parseInt((this.indexes.right-this.indexes.left)/2)));return true;},createThumbnail:function(i,_45){var _46=Kore.Url.getParamsFromCurrentUrl().parseQuery();var _47={"gallery_id":this.id,"ServiceMethod":"createThumbnail","params[name]":this.photos[i].name};Object.extend(_46,_47);_46=$H(_46).toQueryString();var DS=new Kore.JsonProvider();DS.URL=this.includesBase+"includes/jaxon/widgets/gallery/gallery.service.php"+"?"+_46;DS.updateEvent.subscribe(function(_49,_4a){var _4b=_4a[0];if(_4b.error){_4b.error.show("Error no: %s has occured: \"%s"+"\" while executing query to URL: \""+_4b.URL+"\".");}else{var _4c=_4b.content;if(_4c.error){Kore.Log.info(this.photos[i].name+": "+_4c.error);}else{Object.extend(this.photos[i],_4c);_45.call(this,i);}}},this,true);DS.getContent();delete DS;},loadAnyEmptyThumbnails:function(){if(this.all_loaded){return;}
for(var i=this.indexes.left;i<(this.indexes.right+this.getScreen()+1);i++){var div=YAHOO.util.Dom.get(this.id+"_thumb_"+i);if(!div){return;}
var img=div.getElementsByTagName("img")[0];if(!img){div.innerHTML="<img id=\""+this.id+"_thimg_"+i+"\" height=\"1\" "+"src=\"includes/jaxon/widgets/gallery/css/blank.jpg\" "+"width=\"1\" not_loaded=\"1\">";var img=div.getElementsByTagName("img")[0];var _50=new Widgets.Tooltip(this.id+"_thimg_"+i);_50.contentCallback=function(_51){return this.findTextForTooltip(_51.replace(/.*_/,""));}.bind(this);}
if(img.getAttribute("not_loaded")){if(this.photos[i].thumbnail!=null){img.src=this.options.photo_folder+(this.photos[i].thumbnail.name).replace(/^([\w\W]*?)(\/|\\)([^\/\\]*)$/,"$1")+"/"+encodeURIComponent((this.photos[i].thumbnail.name).replace(/([\w\W]*?)(\\|\/)([^\/\\]*)$/,"$3"));img.width=this.photos[i].thumbnail.width;img.height=this.photos[i].thumbnail.height;img.removeAttribute("not_loaded");this.loaded_thumbnails++;}else{if(this.options.show_loading_indicator){img.src=this.includesBase+"includes/jaxon/widgets/gallery/img/indicator.gif";img.width=16;img.height=16;}
this.createThumbnail(i,function(i){if(typeof this.photos[i].thumbnail.name!="undefined"){var img=YAHOO.util.Dom.get(this.id+"_thumb_"+i).getElementsByTagName("img")[0];YAHOO.util.Event.addListener(img,"load",function(){img.width=this.photos[i].thumbnail.width;img.height=this.photos[i].thumbnail.height;img.removeAttribute("not_loaded");},this,true);img.src=this.options.photo_folder+(this.photos[i].thumbnail.name).replace(/^([\w\W]*?)(\/|\\)([^\/\\]*)$/,"$1")+"/"+encodeURIComponent((this.photos[i].thumbnail.name).replace(/([\w\W]*?)(\\|\/)([^\/\\]*)$/,"$3"));}});}}}
if(this.loaded_thumbnails==this.photos.length){this.all_loaded=true;}},updateVisibleIndexes:function(){var _54=YAHOO.util.Dom.get(this.id+"_thumbs");if(!_54){return;}
var _55=parseInt(_54.scrollLeft,10);var t=YAHOO.util.Region.getRegion(_54);var _57=t.right-t.left;var _58=[];for(var i=0;i<this.photos.length;i++){var el=YAHOO.util.Dom.get(this.id+"_thumb_"+i).parentNode;var _5b=el.offsetLeft;var _5c=el.offsetLeft+el.offsetWidth;if((_5c>_55)&&(_5b<(_57+_55))){_58.push(i);}}
this.indexes.left=_58[0];this.indexes.all=this.photos.length;this.indexes.right=_58.last();return _58;},render:function(){if(this.photos.length==0){return false;}
var _el=YAHOO.util.Dom.get(this.id);var _5e=_el&&_el.offsetHeight;if(!_5e){return this.RETRY("render");}
this.getMetas(this.includesBase);},preRenderThumbs:function(){var _5f=YAHOO.util.Dom.get(this.id+"_thumbs");if(!_5f){return;}
var _60="<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tr>";for(var i=0;i<this.photos.length;i++){_60+="<td>"+"<div id=\""+this.id+"_thumb_"+i+"\">"+"</div>"+"</td>";}
_60+="</tr></table>";_5f.innerHTML=_60;},draw:function(){this.preRenderThumbs();var _62=YAHOO.util.Dom.get(this.id+"_thumb_0");var _63=YAHOO.util.Dom.get(this.id+"_thumb_1");if(this.photos.length>2&&(!_62||!_63)){return this.RETRY("draw");}
if(this.photos.length==1&&!_62){return this.RETRY("draw");}
var _64=this;var _65=0;for(var i=0;i<this.photos.length;i++){var div=YAHOO.util.Dom.get(this.id+"_thumb_"+i);YAHOO.util.Event.addListener(div,"mouseover",function(ev){YAHOO.util.Dom.addClass(this,"hover");},div,true);YAHOO.util.Event.addListener(div,"mouseout",function(ev){YAHOO.util.Dom.removeClass(this,"hover");},div,true);YAHOO.util.Event.addListener(div,"click",function(e){_64.stopPlay();_64.showAndScrollImage(this);},div,true);if(this.currentImage==this.photos[i].name){_65=i;}}
this.options.thumbnails.width=_62.parentNode.offsetWidth;this.initIndexes();this.updateVisibleIndexes();this.loadAnyEmptyThumbnails();this.showAndScroll(_65);var _6b=YAHOO.util.Dom.getElementsByClassName("gleft","div",this.id)[0];var a=_6b.getElementsByTagName("a")[0];a.hideFocus=true;YAHOO.util.Event.addListener(_6b,"mouseover",function(ev){if(this.play_timeout==null){if(this.scroll_right_timeout==null){this.speed=1;this.scroll_right_timeout=window.setTimeout(this.startScrollingRight.bind(this),1000);}}
YAHOO.util.Event.stopEvent(ev);},this,true);YAHOO.util.Event.addListener(_6b,"mouseout",function(ev){window.clearTimeout(this.scroll_right_timeout);this.scroll_right_timeout=null;YAHOO.util.Event.stopEvent(ev);},this,true);YAHOO.util.Event.addListener(a,"click",function(ev){if(this.scroll_right_timeout!=null){try{window.clearTimeout(this.scroll_right_timeout);}
catch(e){}
this.scroll_right_timeout=null;}
this.stopPlay();this.speed=0.5;this.scrollToTheRight(this.getScreen());YAHOO.util.Event.stopEvent(ev);},this,true);var _70=YAHOO.util.Dom.getElementsByClassName("gright","div",this.id)[0];var a=_70.getElementsByTagName("a")[0];a.hideFocus=true;YAHOO.util.Event.addListener(_70,"mouseover",function(ev){if(this.play_timeout==null){if(this.scroll_left_timeout==null){this.speed=1;this.scroll_left_timeout=window.setTimeout(this.startScrollingLeft.bind(this),1000);}}
YAHOO.util.Event.stopEvent(ev);},this,true);YAHOO.util.Event.addListener(_70,"mouseout",function(ev){window.clearTimeout(this.scroll_left_timeout);this.scroll_left_timeout=null;YAHOO.util.Event.stopEvent(ev);},this,true);YAHOO.util.Event.addListener(a,"click",function(ev){if(this.scroll_left_timeout!=null){try{window.clearTimeout(this.scroll_left_timeout);}
catch(e){}
this.scroll_left_timeout=null;}
this.stopPlay();this.speed=0.5;this.scrollToTheLeft(this.getScreen());YAHOO.util.Event.stopEvent(ev);},this,true);},getScreen:function(){return Math.max(1,(this.indexes.right-this.indexes.left));},initIndexes:function(){this.indexes={"left":-1,"all":-1,"right":-1,"viewing":-1};this.loaded_thumbnails=0;},togglePlay:function(_74){if(_74!=null){this.options.play_timeout=_74;}
if(this.play_timeout==null){this.play_timeout=window.setTimeout(this.play.bind(this),1);if(this.scroll_left_timeout!=null){window.clearTimeout(this.scroll_left_timeout);this.scroll_left_timeout=null;}
if(this.scroll_right_timeout!=null){window.clearTimeout(this.scroll_right_timeout);this.scroll_right_timeout=null;}
return true;}else{this.stopPlay();return false;}},play:function(){if(!this.indexes){return;}
if(this.indexes.viewing+1<this.indexes.all){if(this.showAndScroll(this.indexes.viewing+1)){this.play_timeout=window.setTimeout(this.play.bind(this),this.options.play_timeout);}else{this.play_timeout=null;}}else{this.play_timeout=null;}},stopPlay:function(){if(this.play_timeout!=null){window.clearTimeout(this.play_timeout);this.play_timeout=null;}},first:function(){if(!this.indexes){return;}
this.stopPlay();this.showAndScroll(0);},prev:function(){if(!this.indexes){return;}
this.stopPlay();if(this.indexes.viewing-1>=0){this.showAndScroll(this.indexes.viewing-1);}},next:function(){if(!this.indexes){return;}
this.stopPlay();if(this.indexes.viewing+1<this.indexes.all){this.showAndScroll(this.indexes.viewing+1);}},last:function(){if(!this.indexes){return;}
this.stopPlay();this.showAndScroll(this.indexes.all-1);}};