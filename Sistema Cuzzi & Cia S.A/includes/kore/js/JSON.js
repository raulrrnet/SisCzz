
Array.prototype.______array="______array";JSON={org:"http://www.JSON.org",copyright:"(c)2005 JSON.org",license:"http://www.crockford.com/JSON/license.html",stringify:function(_1){var c,i,l,s="",v;switch(typeof _1){case"object":if(_1){if(_1.______array=="______array"){for(i=0;i<_1.length;++i){v=this.stringify(_1[i]);if(s){s+=",";}
s+=v;}
return"["+s+"]";}else{if(typeof _1.toString!="undefined"){for(i in _1){v=_1[i];if(typeof v!="undefined"&&typeof v!="function"){v=this.stringify(v);if(s){s+=",";}
s+=this.stringify(i)+":"+v;}}
return"{"+s+"}";}}}
return"null";case"number":return isFinite(_1)?String(_1):"null";case"string":l=_1.length;s="\"";for(i=0;i<l;i+=1){c=_1.charAt(i);if(c>=" "){if(c=="\\"||c=="\""){s+="\\";}
s+=c;}else{switch(c){case"\b":s+="\\b";break;case"\f":s+="\\f";break;case"\n":s+="\\n";break;case"\r":s+="\\r";break;case"\t":s+="\\t";break;default:c=c.charCodeAt();s+="\\u00"+Math.floor(c/16).toString(16)+(c%16).toString(16);}}}
return s+"\"";case"boolean":return String(_1);default:return"null";}},parse:function(_3){var at=0;var ch=" ";function error(m){throw{name:"JSONError",message:m,at:at-1,text:_3};}
function next(){ch=_3.charAt(at);at+=1;return ch;}
function white(){while(ch!=""&&ch<=" "){next();}}
function str(){var i,s="",t,u;if(ch=="\""){outer:while(next()){if(ch=="\""){next();return s;}else{if(ch=="\\"){switch(next()){case"b":s+="\b";break;case"f":s+="\f";break;case"n":s+="\n";break;case"r":s+="\r";break;case"t":s+="\t";break;case"u":u=0;for(i=0;i<4;i+=1){t=parseInt(next(),16);if(!isFinite(t)){break outer;}
u=u*16+t;}
s+=String.fromCharCode(u);break;default:s+=ch;}}else{s+=ch;}}}}
error("Bad string");}
function arr(){var a=[];if(ch=="["){next();white();if(ch=="]"){next();return a;}
while(ch){a.push(val());white();if(ch=="]"){next();return a;}else{if(ch!=","){break;}}
next();white();}}
error("Bad array");}
function obj(){var k,o={};if(ch=="{"){next();white();if(ch=="}"){next();return o;}
while(ch){k=str();white();if(ch!=":"){break;}
next();o[k]=val();white();if(ch=="}"){next();return o;}else{if(ch!=","){break;}}
next();white();}}
error("Bad object");}
function num(){var n="",v;if(ch=="-"){n="-";next();}
while(ch>="0"&&ch<="9"){n+=ch;next();}
if(ch=="."){n+=".";while(next()&&ch>="0"&&ch<="9"){n+=ch;}}
if(ch=="e"||ch=="E"){n+="e";next();if(ch=="-"||ch=="+"){n+=ch;next();}
while(ch>="0"&&ch<="9"){n+=ch;next();}}
v=+n;if(!isFinite(v)){error("Bad number");}else{return v;}}
function word(){switch(ch){case"t":if(next()=="r"&&next()=="u"&&next()=="e"){next();return true;}
break;case"f":if(next()=="a"&&next()=="l"&&next()=="s"&&next()=="e"){next();return false;}
break;case"n":if(next()=="u"&&next()=="l"&&next()=="l"){next();return null;}
break;}
error("Syntax error");}
function val(){white();switch(ch){case"{":return obj();case"[":return arr();case"\"":return str();case"-":return num();default:return ch>="0"&&ch<="9"?num():word();}}
return val();}};