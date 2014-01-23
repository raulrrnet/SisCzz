
if(!Kore){var Kore={};}
Kore.Error=Class.create();Object.extend(Kore.Error,{ERR_TO:1,ERR_404:4,ERR_NOT_JSON:5,ERR_NOT_HTML:6,ERR_NOT_XML:7,ERR_NO_URL:10,ERR_JSERROR:100,ERR_SETDOM:150,ERR_REQUEST_URI_TOO_LONG:414});Kore.Error.prototype={code:"",message:"",initialize:function(_1,_2){this.code=_1;this.message=_2;},show:function(_3){if(typeof _3=="undefined"){return;}
var _4=_3.split(/%s/);var _5="";if(_4.length==1){_5=_3;}else{if(_4.length==2){_5=_4[0]+this.code+_4[1];}else{_5=_4[0]+this.code+_4[1]+this.message+_4[2];}}
Kore.Log.info(_5);}};