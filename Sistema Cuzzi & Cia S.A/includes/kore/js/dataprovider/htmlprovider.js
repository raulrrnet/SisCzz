
if(!Kore){var Kore={};}
Kore.HtmlProvider=Class.create();Kore.HtmlProvider.prototype=Object.extend(new Kore.DataProvider(),{container:null,processor:null,beforeLoadEvent:null,finalizeEvent:null,scriptSources:new Array(),styleSources:new Array(),initialize:function(_1,_2,_3){this.URL=_1?_1:null;this.container=_2;this.setOptions(_3);this.updateEvent=new YAHOO.util.CustomEvent("update",this);this.startEvent=new YAHOO.util.CustomEvent("start",this);this.finalizeEvent=new YAHOO.util.CustomEvent("finalize",this);},onComplete:function(){this.processor=new Kore.HtmlProcessor(this.container,this.content);this.processor.addFinalizeListener(this.onFinalize,this);this.processor.process();},onFinalize:function(){this.finalizeEvent.fire();}});