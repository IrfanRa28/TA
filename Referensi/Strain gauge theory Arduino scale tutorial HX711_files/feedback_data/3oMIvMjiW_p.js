if (self.CavalryLogger) { CavalryLogger.start_js(["2rZG6"]); }

__d("XReferer",["Base64","Cookie","FBJSON","URI","setTimeoutAcrossTransitions"],(function(a,b,c,d,e,f){var g,h={update:function(a,c,d){if(!d){b("Cookie").set("x-referer","");return}a!=null&&(a=h.truncatePath(a));c!=null&&(c=h.truncatePath(c));var e=window.location.pathname+window.location.search;d=(g||(g=b("URI"))).getRequestURI();var f=d.getSubdomain();c!=null&&h._setCookie(c,e,f);a!=null&&b("setTimeoutAcrossTransitions")(function(){a!=null&&h._setCookie(a,e,f)},0)},_setCookie:function(a,c,d){a={r:a,h:c,s:d};c=b("Base64").encode(b("FBJSON").stringify(a));b("Cookie").set("x-referer",c)},truncatePath:function(a){var b=1024;a&&a.length>b&&(a=a.substring(0,b)+"...");return a}};e.exports=h}),null);
__d("goOrReplace",["Env","URI","isFacebookURI"],(function(a,b,c,d,e,f){var g,h;function a(a,c,d){c=new(g||(g=b("URI")))(c);(h||(h=b("Env"))).isCQuick&&b("isFacebookURI")(c)&&c.addQueryData({cquick:(h||(h=b("Env"))).iframeKey,cquick_token:h.iframeToken,ctarget:h.iframeTarget});c=c.toString();d?a.replace(c):a.href==c?a.reload():a.href=c}e.exports=a}),null);
__d("HistoryManager",["Env","Event","SprinkleConfig","URI","UserAgent_DEPRECATED","XReferer","emptyFunction","gkx","goOrReplace","isInIframe","setIntervalAcrossTransitions"],(function(a,b,c,d,e,f){var g,h,i={history:null,current:0,fragment:null,isInitialized:function(){return!!i._initialized},init:function(){if(!(g||(g=b("Env"))).ALLOW_TRANSITION_IN_IFRAME&&b("isInIframe")())return;if(i._initialized)return i;var a=new(h||(h=b("URI")))(window.location.href),c=a.getFragment()||"";c.charAt(0)==="!"&&(c=c.substr(1),a.setFragment(c));Object.assign(i,{_initialized:!0,fragment:c,orig_fragment:c,history:[a],callbacks:[],lastChanged:Date.now(),canonical:new h("#"),user:0,enabled:!0,debug:b("emptyFunction")});if(window.history&&window.history.pushState){this.lastURI=document.URL;c=new(h||(h=b("URI")))(this.lastURI);a=c.getQueryData();a.__md__=void 0;a.__xts__=void 0;a.fb_dtsg_ag=void 0;a[b("SprinkleConfig").param_name]=void 0;this.lastURI=c.setQueryData(a).toString();try{window.history.state&&b("gkx")("819236")?window.history.replaceState(window.history.state,null,this.lastURI):window.history.replaceState(this.lastURI,null,this.lastURI)}catch(a){if(!(a.number===-2147467259))throw a}b("Event").listen(window,"popstate",function(a){var c=a&&a.state&&typeof a.state==="string";c&&i.lastURI!=a.state&&(i.lastURI=document.URL,i.lastChanged=Date.now(),i.notify(new(h||(h=b("URI")))(a.state).getUnqualifiedURI().toString()))}.bind(i));(b("UserAgent_DEPRECATED").webkit()<534||b("UserAgent_DEPRECATED").chrome()<=13)&&(b("setIntervalAcrossTransitions")(i.checkURI,42),i._updateRefererURI(this.lastURI));return i}i._updateRefererURI(h.getRequestURI(!1));if(b("UserAgent_DEPRECATED").webkit()<500||b("UserAgent_DEPRECATED").firefox()<2){i.enabled=!1;return i}"onhashchange"in window?b("Event").listen(window,"hashchange",function(){window.setTimeout(i.checkURI.bind(i),0)}):b("setIntervalAcrossTransitions")(i.checkURI,42);return i},registerURIHandler:function(a){i.callbacks.push(a);return i},setCanonicalLocation:function(a){i.canonical=new(h||(h=b("URI")))(a);return i},notify:function(a){a==i.orig_fragment&&(a=i.canonical.getFragment());for(var b=0;b<i.callbacks.length;b++)try{if(i.callbacks[b](a))return!0}catch(a){}return!1},checkURI:function(){if(Date.now()-i.lastChanged<400)return;if(window.history&&window.history.pushState){var a=new(h||(h=b("URI")))(document.URL).removeQueryData("ref").toString(),c=new h(i.lastURI).removeQueryData("ref").toString();a!=c&&(i.lastChanged=Date.now(),i.lastURI=a,b("UserAgent_DEPRECATED").webkit()<534&&i._updateRefererURI(a),i.notify(new(h||(h=b("URI")))(a).getUnqualifiedURI().toString()));return}if(b("UserAgent_DEPRECATED").webkit()&&window.history.length==200){i.warned||(i.warned=!0);return}c=new(h||(h=b("URI")))(window.location.href).getFragment();c.charAt(0)=="!"&&(c=c.substr(1));c=c.replace(/%23/g,"#");if(c!=i.fragment.replace(/%23/g,"#")){i.debug([c," vs ",i.fragment,"whl: ",window.history.length,"QHL: ",i.history.length].join(" "));for(var a=i.history.length-1;a>=0;--a)if(i.history[a].getFragment().replace(/%23/g,"#")==c)break;++i.user;a>=0?i.go(a-i.current):i.go("#"+c);--i.user}},_updateRefererURI:function(a){a instanceof(h||(h=b("URI")))&&(a=a.toString()),b("XReferer").update(a,null,!0)},go:function(a,c,d){if(window.history&&window.history.pushState){c||typeof a==="number";var e=new(h||(h=b("URI")))(a).removeQueryData(["ref","messaging_source","ajaxpipe_fetch_stream","fb_dtsg_ag",b("SprinkleConfig").param_name]).toString();i.lastChanged=Date.now();this.lastURI=e;d?window.history.replaceState(a,null,e):window.history.pushState(a,null,e);b("UserAgent_DEPRECATED").webkit()<534&&i._updateRefererURI(a);return!1}i.debug("go: "+a);c===void 0&&(c=!0);if(!i.enabled&&!c)return!1;if(typeof a==="number"){if(!a)return!1;e=a+i.current;var f=Math.max(0,Math.min(i.history.length-1,e));i.current=f;e=i.history[f].getFragment()||i.orig_fragment;e=new(h||(h=b("URI")))(e).removeQueryData("ref").getUnqualifiedURI().toString();i.fragment=e;i.lastChanged=Date.now();i.user||b("goOrReplace")(window.location,window.location.href.split("#")[0]+"#!"+e,d);c&&i.notify(e);i._updateRefererURI(e);return!1}a=new(h||(h=b("URI")))(a);a.getDomain()==new(h||(h=b("URI")))(window.location.href).getDomain()&&(a=new(h||(h=b("URI")))("#"+a.getUnqualifiedURI()));f=i.history[i.current].getFragment();e=a.getFragment();if(e==f||f==i.orig_fragment&&e==i.canonical.getFragment()){c&&i.notify(e);i._updateRefererURI(e);return!1}d&&i.current--;f=i.history.length-i.current-1;i.history.splice(i.current+1,f);i.history.push(new h(a));return i.go(1,c,d)},getCurrentFragment:function(){var a=(h||(h=b("URI"))).getRequestURI(!1).getFragment();return a==i.orig_fragment?i.canonical.getFragment():a}};e.exports=i}),null);
__d("PageHooks",["Arbiter","ErrorUtils","InitialJSLoader","PageEvents"],(function(a,b,c,d,e,f){var g;f={DOMREADY_HOOK:"domreadyhooks",ONLOAD_HOOK:"onloadhooks"};function h(){var c=a.CavalryLogger;!window.domready&&c&&c.getInstance().setTimeStamp("t_prehooks");k(l.DOMREADY_HOOK);!window.domready&&c&&c.getInstance().setTimeStamp("t_hooks");window.domready=!0;b("Arbiter").inform("uipage_onload",!0,"state")}function i(){k(l.ONLOAD_HOOK),window.loaded=!0}function j(a,c){return(g||(g=b("ErrorUtils"))).applyWithGuard(a,null,null,function(a){a.event_type=c,a.category="runhook"},"PageHooks:"+c)}function k(a){var b=a=="onbeforeleavehooks"||a=="onbeforeunloadhooks";do{var c=window[a];if(!c)break;b||(window[a]=null);for(var d=0;d<c.length;d++){var e=j(c[d],a);if(b&&e)return e}}while(!b&&window[a])}function c(){window.domready||(window.domready=!0,k("onloadhooks")),window.loaded||(window.loaded=!0,k("onafterloadhooks"))}function d(){var a,c;(a=b("Arbiter")).registerCallback(h,[(c=b("PageEvents")).BIGPIPE_DOMREADY,b("InitialJSLoader").INITIAL_JS_READY]);a.registerCallback(i,[c.BIGPIPE_DOMREADY,c.BIGPIPE_ONLOAD,b("InitialJSLoader").INITIAL_JS_READY]);a.subscribe(c.NATIVE_ONBEFOREUNLOAD,function(a,b){b.warn=k("onbeforeleavehooks")||k("onbeforeunloadhooks"),b.warn||(window.domready=!1,window.loaded=!1)},"new");a.subscribe(c.NATIVE_ONUNLOAD,function(a,b){k("onunloadhooks"),k("onafterunloadhooks")},"new")}var l=babelHelpers["extends"]({_domreadyHook:h,_onloadHook:i,runHook:j,runHooks:k,keepWindowSetAsLoaded:c},f);d();a.PageHooks=e.exports=l}),null);
__d("PageTransitions",["requireCond","cr:917439"],(function(a,b,c,d,e,f){e.exports=b("cr:917439")}),null);
__d("escapeJSQuotes",[],(function(a,b,c,d,e,f){function a(a){return typeof a==="undefined"||a==null||!a.valueOf()?"":a.toString().replace(/\\/g,"\\\\").replace(/\n/g,"\\n").replace(/\r/g,"\\r").replace(/\"/g,"\\x22").replace(/\'/g,"\\'").replace(/</g,"\\x3c").replace(/>/g,"\\x3e").replace(/&/g,"\\x26")}e.exports=a}),null);
__d("PageTransitionsBlue",["fbt","invariant","Arbiter","BlueCompatBroker","BlueCompatRouter","Bootloader","DOMQuery","DOMScroll","Env","ErrorGuard","Event","FbtResultBase","HistoryManager","LayerHideOnEscape","PageHooks","PageTransitionsConfig","PageTransitionsRegistrar","React","ScriptPath","URI","Vector","areEqual","clickRefAction","escapeJSQuotes","ge","goOrReplace","isFacebookURI","isInIframe","setTimeout"],(function(a,b,c,d,e,f,g,h){var i,j,k,l,m=b("React"),n=["cquick","ctarget","cquick_token","mh_","killabyte","tfc_","tfi_"],o={};function p(a,b){a&&(o[a.getUnqualifiedURI().toString()]=b)}function q(a){return o[a.getUnqualifiedURI().toString()]}function r(a){delete o[a.getUnqualifiedURI().toString()]}function s(){var a={};window.location.search.slice(1).split("&").forEach(function(b){b=b.split("=");var c=b[0];b=b[1];b=b===void 0?null:b;n.some(function(a){return c.startsWith(a)})&&(a[c]=b)});return a}var t=null,u=!1,v=new(i||(i=b("URI")))(""),w=null,x=new i(),y=null,z=!1,A=!1,B=!1,C={isInitialized:function(){return u},init:function(){C._init()},_init:function(){if(b("isInIframe")())return!1;if(u)return!0;var a=b("PageTransitionsRegistrar").getMostRecentURI();t=a;v=a;w=null;x=a;var c=(j||(j=b("ErrorGuard"))).applyWithGuard(function(a){return(i||(i=b("URI"))).tryParseURI(a)},null,[document.referrer]);y=document.referrer&&c&&b("isFacebookURI")(c)?c:null;u=!0;c=(i||(i=b("URI"))).getRequestURI(!1);c.getFragment().startsWith("/")?c=c.getFragment():c=a.toString();b("HistoryManager").init().setCanonicalLocation("#"+c).registerURIHandler(C._historyManagerHandler);b("Event").listen(window,"scroll",function(){z||p(t,b("Vector").getScrollPosition())});return!0},registerHandler:b("PageTransitionsRegistrar").registerHandler,removeHandler:b("PageTransitionsRegistrar").removeHandler,getCurrentURI:function(a){a===void 0&&(a=!1);this._init();return!t&&!a?new(i||(i=b("URI")))(v):new(i||(i=b("URI")))(t)},isTransitioning:function(){this._init();return!t},getNextURI:function(){this._init();return x},getNextReferrerURI:function(){this._init();return w},getReferrerURI:function(){this._init();return y},getMostRecentURI:function(){this._init();return new(i||(i=b("URI")))(v)},go:function(a,c){c===void 0&&(c=!1);if(b("BlueCompatRouter").goFragment(a)){var d=new(i||(i=b("URI")))(a);if(C.restoreScrollPosition(d)){t=v=d;return}}if(b("BlueCompatRouter").go(a,c))return;this.goBase(a,c)},goBase:function(a,c){c===void 0&&(c=!1);this._init();var d=s(),e=new(i||(i=b("URI")))(a).removeQueryData("quickling").addQueryData(d).getQualifiedURI();r(e);c||b("clickRefAction")("uri",{href:e.toString()},null,"INDIRECT");C._loadPage(e,function(a){a?b("HistoryManager").go(e.toString(),!1,c):b("goOrReplace")(window.location,e,c)})},_historyManagerHandler:function(a){if(a.charAt(0)!="/")return!1;b("clickRefAction")("h",{href:a});b("ScriptPath").getClickPointInfo()||b("ScriptPath").setClickPointInfo({click:"back"});C._loadPage(new(i||(i=b("URI")))(a),function(c){c||b("goOrReplace")(window.location,a,!0)});return!0},_loadPage:function(a,c){if(new(i||(i=b("URI")))(a).getFragment()&&(k||(k=b("areEqual")))(new(i||(i=b("URI")))(a).setFragment("").getQualifiedURI(),new(i||(i=b("URI")))(t).setFragment("").getQualifiedURI())){b("Arbiter").inform("pre_page_fragment_transition",{from:new(i||(i=b("URI")))(t).getFragment(),to:new i(a).getFragment()});if(C.restoreScrollPosition(a)){t=v=a;b("Arbiter").inform("page_fragment_transition",{fragment:new(i||(i=b("URI")))(a).getFragment()});return}}var d;t&&(d=q(t));var e=function(){d&&t&&p(t,d);w=C.getMostRecentURI();t=null;x=a;d&&b("DOMScroll").scrollTo(d,!1);z=!0;var e=C._handleTransition(a);c&&(e===b("PageTransitionsRegistrar").DELAY_HISTORY?b("setTimeout")(function(){return c&&c(e)},0):c(e))},f=x;x=a;var g=b("PageHooks").runHooks("onbeforeleavehooks");x=f;g?C._warnBeforeLeaving(g,e):e()},_handleTransition:function(c){window.onbeforeleavehooks=void 0;if(A||!c.isSameOrigin())return!1;var d=b("PageTransitionsConfig").reloadOnBootloadError&&this._hasBootloadErrors();if(d)return!1;var e;d=a.AsyncRequest;d&&(e=d.getLastID());b("Arbiter").inform("pre_page_transition",{from:C.getMostRecentURI(),to:c});d=b("PageTransitionsRegistrar")._getTransitionHandlers();for(var f=d.length-1;f>=0;--f){var g=d[f];if(!g)continue;for(var h=g.length-1;h>=0;--h){var i=g[h](c);if(i===!0||i===b("PageTransitionsRegistrar").DELAY_HISTORY){var j={sender:this,uri:c,id:e};try{b("Arbiter").inform("page_transition",j)}catch(a){}return i}else g.splice(h,1)}}return!1},disableTransitions:function(){A=!0},disableScrollAnimation:function(){B=!0},_hasBootloadErrors:function(){return b("Bootloader").getErrorCount()>0},unifyURI:function(){this._init(),t=v=x,y=w},transitionComplete:function(a){a===void 0&&(a=!1);this._init();z=!1;C._executeCompletionCallbacks();C.unifyURI();a||t&&C.restoreScrollPosition(t);try{document.activeElement&&document.activeElement.nodeName==="A"&&document.activeElement.blur()}catch(a){}},_executeCompletionCallbacks:function(){var a=b("PageTransitionsRegistrar")._getCompletionCallbacks();a.length>0&&(b("PageTransitionsRegistrar")._resetCompletionCallbacks(),a.forEach(function(a){return a()}))},registerCompletionCallback:b("PageTransitionsRegistrar").registerCompletionCallback,rewriteCurrentURI:function(a,c){this._init();var d=b("PageTransitionsRegistrar")._getTransitionHandlers(),e=d.length||1,f=!1;b("PageTransitionsRegistrar").registerHandler(function(){if(a&&a.toString()==C.getMostRecentURI().getUnqualifiedURI().toString()){C.transitionComplete();return!0}f=!0},e);C.go(c,!0);d.length===e+1&&d[e].length===(f?0:1)||h(0,1302);d.length=e},_warnBeforeLeaving:function(a,c){b("Bootloader").loadModules(["DialogX","XUIDialogTitle.react","XUIDialogBody.react","XUIDialogButton.react","XUIDialogFooter.react","XUIGrayText.react"],function(d,e,f,h,i,j){var k=typeof a==="string"||a instanceof String||a instanceof b("FbtResultBase")?{body:a,highlightStay:!1,leaveButtonText:g._("Leave This Page"),showCloseButton:!1,stayButtonText:g._("Stay on This Page"),title:g._("Leave Page?")}:a;e=m.jsx(e,{showCloseButton:k.showCloseButton,children:k.title});h=k.highlightStay?[m.jsx(h,{action:"confirm",label:k.leaveButtonText},"confirm"),m.jsx(h,{action:"cancel",use:"confirm",label:k.stayButtonText,className:"autofocus"},"cancel")]:[m.jsx(h,{action:"cancel",label:k.stayButtonText},"cancel"),m.jsx(h,{action:"confirm",use:"confirm",label:k.leaveButtonText,className:"autofocus"},"confirm")];var l=new d({width:450,addedBehaviors:[b("LayerHideOnEscape")]},m.jsxs("div",{children:[e,m.jsx(f,{children:m.jsx(j,{shade:"medium",size:"medium",children:k.body})}),m.jsx(i,{children:h})]}));l.subscribe("confirm",function(){l.hide(),c()});l.show()},"PageTransitionsBlue")},restoreScrollPosition:function(a){var c=q(a);if(c){b("DOMScroll").scrollTo(c,!1);return!0}function d(a){if(!a)return null;var c="a[name='"+b("escapeJSQuotes")(a)+"']";return b("DOMQuery").scry(document.body,c)[0]||b("ge")(a)}c=d(new(i||(i=b("URI")))(a).getFragment());if(c){d=!B;b("DOMScroll").scrollTo(c,d);return!0}return!1}};(l||(l=b("Env"))).isCQuick&&(b("BlueCompatBroker").init(),b("BlueCompatBroker").register("transitionpage",function(c){c=new(i||(i=b("URI")))(b("BlueCompatBroker").getMessageEventString(c,"uri"));var d=new i(window.location.href);c.removeQueryData("ctarget");d.removeQueryData("ctarget");if(d.toString()===c.toString())return;d=a.AsyncRequest;d&&d.ignoreUpdate();C.goBase(c,!1)}));e.exports=C;a.PageTransitions=C}),null);
__d("PluginDOMEventListener",["DOMEventListener","Log","UserAgent","promiseDone"],(function(a,b,c,d,e,f){var g=!b("UserAgent").isBrowser("Safari < 12")&&typeof document.hasStorageAccess==="function",h=!g,i=!1;!h&&g&&b("promiseDone")(document.hasStorageAccess(),function(a){b("Log").debug("hasStorageAccess=%s",a),h=a},function(a){return b("Log").warn("Storage access check failed: %s",a)});a={add:function(a,c,d,e){e===void 0&&(e=!1);if(!g||h||i)return b("DOMEventListener").add.apply(this,arguments);else{var f=function(){for(var a=arguments.length,c=new Array(a),e=0;e<a;e++)c[e]=arguments[e];if(h||i)return d.apply(this,c);else{var f=document.requestStorageAccess().then(function(a){b("Log").debug("Storage access request granted.");h=!0;return d.apply(this,c)}.bind(this),function(a){b("Log").warn("Storage access request denied.");i=!0;return d.apply(this,c)}.bind(this));b("promiseDone")(f)}};return b("DOMEventListener").add.call(this,a,c,f,e)}},remove:b("DOMEventListener").remove};e.exports=a}),null);
__d("PluginITP",["PluginDOMEventListener","promiseDone"],(function(a,b,c,d,e,f){a={init:function(){if(!("hasStorageAccess"in document))return;b("promiseDone")(document.hasStorageAccess(),function(a){document.body&&!a&&b("PluginDOMEventListener").add(document.body,"click",function(){location.reload()})})}};e.exports=a}),null);
__d("SecurePostMessage",["invariant"],(function(a,b,c,d,e,f,g){"use strict";var h="*";a={sendMessageToSpecificOrigin:function(a,b,c,d){c!==h||g(0,21157),a.postMessage(b,c,d)},sendMessageForCurrentOrigin:function(a,b){a.postMessage(b)},sendMessageAllowAnyOrigin_UNSAFE:function(a,b,c){a.postMessage(b,h,c)}};e.exports=a}),null);
__d("PluginXDReady",["Arbiter","Log","SecurePostMessage","UnverifiedXD"],(function(a,b,c,d,e,f){c={handleMessage:function(a){b("Log").debug("PluginXDReady at "+window.name+" handleMessage "+JSON.stringify(a));if(!a.method)return;try{b("Arbiter").inform("Connect.Unsafe."+a.method,JSON.parse(a.params),"persistent")}catch(a){}}};window.addEventListener("message",function(a){b("Log").debug("PluginXDReady at "+window.name+" received message "+JSON.stringify(a.data.message));if(a.data.xdArbiterSyn)b("SecurePostMessage").sendMessageAllowAnyOrigin_UNSAFE(a.source,{xdArbiterAck:!0});else if(a.data.xdArbiterHandleMessage){if(!a.data.message.method)return;try{b("Arbiter").inform("Connect.Unsafe."+a.data.message.method,JSON.parse(a.data.message.params),"persistent")}catch(a){}}},!1);a.XdArbiter=c;b("UnverifiedXD").send({xd_action:"plugin_ready",name:window.name});e.exports=null}),null);
__d("Animation",["BrowserSupport","CSS","DataStore","DOM","Style","clearInterval","clearTimeout","getVendorPrefixedName","requestAnimationFrame","setIntervalAcrossTransitions","setTimeoutAcrossTransitions","shield"],(function(a,b,c,d,e,f){var g=b("requestAnimationFrame"),h=[],i;function j(b){if(a==this)return new j(b);else this.obj=b,this._reset_state(),this.queue=[],this.last_attr=null,this.unit="px",this.behaviorOverrides={ignoreUserScroll:!1}}function k(a){if(b("BrowserSupport").hasCSS3DTransforms())return n(a);else return m(a)}function l(a){return a.toFixed(8)}function m(a){a=[a[0],a[4],a[1],a[5],a[12],a[13]];return"matrix("+a.map(l).join(",")+")"}function n(a){return"matrix3d("+a.map(l).join(",")+")"}function o(a,b){a||(a=[1,0,0,0,0,1,0,0,0,0,1,0,0,0,0,1]);var c=[];for(var d=0;d<4;d++)for(var e=0;e<4;e++){var f=0;for(var g=0;g<4;g++)f+=a[d*4+g]*b[g*4+e];c[d*4+e]=f}return c}var p=0;j.prototype._reset_state=function(){this.state={attrs:{},duration:500}};j.prototype.stop=function(){this._reset_state();this.queue=[];return this};j.prototype._build_container=function(){if(this.container_div){this._refresh_container();return}if(this.obj.firstChild&&this.obj.firstChild.__animation_refs){this.container_div=this.obj.firstChild;this.container_div.__animation_refs++;this._refresh_container();return}var a=document.createElement("div");a.style.padding="0px";a.style.margin="0px";a.style.border="0px";a.__animation_refs=1;var b=this.obj.childNodes;while(b.length)a.appendChild(b[0]);this.obj.appendChild(a);this._orig_overflow=this.obj.style.overflow;this.obj.style.overflow="hidden";this.container_div=a;this._refresh_container()};j.prototype._refresh_container=function(){this.container_div.style.height="auto",this.container_div.style.width="auto",this.container_div.style.height=this.container_div.offsetHeight+this.unit,this.container_div.style.width=this.container_div.offsetWidth+this.unit};j.prototype._destroy_container=function(){if(!this.container_div)return;if(!--this.container_div.__animation_refs){var a=this.container_div.childNodes;while(a.length)this.obj.appendChild(a[0]);this.obj.removeChild(this.container_div)}this.container_div=null;this.obj.style.overflow=this._orig_overflow};var q=1,r=2,s=3;j.prototype._attr=function(a,b,c){a=a.replace(/-[a-z]/gi,function(a){return a.substring(1).toUpperCase()});var d=!1;switch(a){case"background":this._attr("backgroundColor",b,c);return this;case"backgroundColor":case"borderColor":case"color":b=w(b);break;case"opacity":b=parseFloat(b,10);break;case"height":case"width":b=="auto"?d=!0:b=parseInt(b,10);break;case"borderWidth":case"lineHeight":case"fontSize":case"margin":case"marginBottom":case"marginLeft":case"marginRight":case"marginTop":case"padding":case"paddingBottom":case"paddingLeft":case"paddingRight":case"paddingTop":case"bottom":case"left":case"right":case"top":case"scrollTop":case"scrollLeft":b=parseInt(b,10);break;case"rotateX":case"rotateY":case"rotateZ":b=parseInt(b,10)*Math.PI/180;break;case"translateX":case"translateY":case"translateZ":case"scaleX":case"scaleY":case"scaleZ":b=parseFloat(b,10);break;case"rotate3d":this._attr("rotateX",b[0],c);this._attr("rotateY",b[1],c);this._attr("rotateZ",b[2],c);return this;case"rotate":this._attr("rotateZ",b,c);return this;case"scale3d":this._attr("scaleZ",b[2],c);case"scale":this._attr("scaleX",b[0],c);this._attr("scaleY",b[1],c);return this;case"translate3d":this._attr("translateZ",b[2],c);case"translate":this._attr("translateX",b[0],c);this._attr("translateY",b[1],c);return this;default:throw new Error(a+" is not a supported attribute!")}this.state.attrs[a]===void 0&&(this.state.attrs[a]={});d&&(this.state.attrs[a].auto=!0);switch(c){case s:this.state.attrs[a].start=b;break;case r:this.state.attrs[a].by=!0;case q:this.state.attrs[a].value=b;break}};function t(a){var c,d=parseInt((c=b("Style")).get(a,"paddingLeft"),10),e=parseInt(c.get(a,"paddingRight"),10),f=parseInt(c.get(a,"borderLeftWidth"),10);c=parseInt(c.get(a,"borderRightWidth"),10);return a.offsetWidth-(d?d:0)-(e?e:0)-(f?f:0)-(c?c:0)}function u(a){var c,d=parseInt((c=b("Style")).get(a,"paddingTop"),10),e=parseInt(c.get(a,"paddingBottom"),10),f=parseInt(c.get(a,"borderTopWidth"),10);c=parseInt(c.get(a,"borderBottomWidth"),10);return a.offsetHeight-(d?d:0)-(e?e:0)-(f?f:0)-(c?c:0)}j.prototype.setUnit=function(a){this.unit=a;return this};j.prototype.to=function(a,b){b===void 0?this._attr(this.last_attr,a,q):(this._attr(a,b,q),this.last_attr=a);return this};j.prototype.by=function(a,b){b===void 0?this._attr(this.last_attr,a,r):(this._attr(a,b,r),this.last_attr=a);return this};j.prototype.from=function(a,b){b===void 0?this._attr(this.last_attr,a,s):(this._attr(a,b,s),this.last_attr=a);return this};j.prototype.duration=function(a){this.state.duration=a?a:0;return this};j.prototype.checkpoint=function(a,b){a===void 0&&(a=1);this.state.checkpoint=a;this.queue.push(this.state);this._reset_state();this.state.checkpointcb=b;return this};j.prototype.blind=function(){this.state.blind=!0;return this};j.prototype.hide=function(){this.state.hide=!0;return this};j.prototype.show=function(){this.state.show=!0;return this};j.prototype.ease=function(a){this.state.ease=a;return this};j.prototype.CSSAnimation=function(a){var b={duration:this.state.duration};this.state.ondone&&(b.callback=this.state.ondone);a(this.obj,b)};j.prototype.go=function(){var a=Date.now();this.queue.push(this.state);for(var b=0;b<this.queue.length;b++)this.queue[b].start=a-p,this.queue[b].checkpoint&&(a+=this.queue[b].checkpoint*this.queue[b].duration);x(this);return this};j.prototype._show=function(){b("CSS").show(this.obj)};j.prototype._hide=function(){b("CSS").hide(this.obj)};j.prototype.overrideBehavior=function(a){this.behaviorOverrides=babelHelpers["extends"]({},this.behaviorOverrides,a);return this};j.prototype._frame=function(c){var d=!0,e=!1,f;function g(a){return document.documentElement[a]||document.body[a]}function h(a,b){return a===document.body?g(b):a[b]}function i(a,b){return b.lastScrollTop!==void 0&&b.lastScrollTop!==h(a.obj,"scrollTop")||b.lastScrollLeft!==void 0&&b.lastScrollLeft!==h(a.obj,"scrollLeft")}function j(a,b){b.lastScrollTop=h(a.obj,"scrollTop"),b.lastScrollLeft=h(a.obj,"scrollLeft")}for(var l=0;l<this.queue.length;l++){var m=this.queue[l];if(m.start>c){d=!1;continue}m.checkpointcb&&(this._callback(m.checkpointcb,c-m.start),m.checkpointcb=null);if(m.started===void 0){m.show&&this._show();for(var n in m.attrs){if(m.attrs[n].start!==void 0)continue;switch(n){case"backgroundColor":case"borderColor":case"color":f=w(b("Style").get(this.obj,n=="borderColor"?"borderLeftColor":n));m.attrs[n].by&&(m.attrs[n].value[0]=Math.min(255,Math.max(0,m.attrs[n].value[0]+f[0])),m.attrs[n].value[1]=Math.min(255,Math.max(0,m.attrs[n].value[1]+f[1])),m.attrs[n].value[2]=Math.min(255,Math.max(0,m.attrs[n].value[2]+f[2])));break;case"opacity":f=b("Style").getOpacity(this.obj);m.attrs[n].by&&(m.attrs[n].value=Math.min(1,Math.max(0,m.attrs[n].value+f)));break;case"height":f=u(this.obj);m.attrs[n].by&&(m.attrs[n].value+=f);break;case"width":f=t(this.obj);m.attrs[n].by&&(m.attrs[n].value+=f);break;case"scrollLeft":case"scrollTop":f=h(this.obj,n);m.attrs[n].by&&(m.attrs[n].value+=f);j(this,m);break;case"rotateX":case"rotateY":case"rotateZ":case"translateX":case"translateY":case"translateZ":f=b("DataStore").get(this.obj,n,0);m.attrs[n].by&&(m.attrs[n].value+=f);break;case"scaleX":case"scaleY":case"scaleZ":f=b("DataStore").get(this.obj,n,1);m.attrs[n].by&&(m.attrs[n].value+=f);break;default:f=parseInt(b("Style").get(this.obj,n),10)||0;m.attrs[n].by&&(m.attrs[n].value+=f);break}m.attrs[n].start=f}if(m.attrs.height&&m.attrs.height.auto||m.attrs.width&&m.attrs.width.auto){this._destroy_container();for(var n in{height:1,width:1,fontSize:1,borderLeftWidth:1,borderRightWidth:1,borderTopWidth:1,borderBottomWidth:1,paddingLeft:1,paddingRight:1,paddingTop:1,paddingBottom:1})m.attrs[n]&&(this.obj.style[n]=m.attrs[n].value+(typeof m.attrs[n].value==="number"?this.unit:""));m.attrs.height&&m.attrs.height.auto&&(m.attrs.height.value=u(this.obj));m.attrs.width&&m.attrs.width.auto&&(m.attrs.width.value=t(this.obj))}m.started=!0;m.blind&&this._build_container()}var p=(c-m.start)/m.duration;p>=1?(p=1,m.hide&&this._hide()):d=!1;var q=m.ease?m.ease(p):p;!e&&p!=1&&m.blind&&(e=!0);for(var n in m.attrs)switch(n){case"backgroundColor":case"borderColor":case"color":m.attrs[n].start[3]!=m.attrs[n].value[3]?this.obj.style[n]="rgba("+v(q,m.attrs[n].start[0],m.attrs[n].value[0],!0)+","+v(q,m.attrs[n].start[1],m.attrs[n].value[1],!0)+","+v(q,m.attrs[n].start[2],m.attrs[n].value[2],!0)+","+v(q,m.attrs[n].start[3],m.attrs[n].value[3],!1)+")":this.obj.style[n]="rgb("+v(q,m.attrs[n].start[0],m.attrs[n].value[0],!0)+","+v(q,m.attrs[n].start[1],m.attrs[n].value[1],!0)+","+v(q,m.attrs[n].start[2],m.attrs[n].value[2],!0)+")";break;case"opacity":b("Style").set(this.obj,"opacity",v(q,m.attrs[n].start,m.attrs[n].value));break;case"height":case"width":this.obj.style[n]=q==1&&m.attrs[n].auto?"auto":v(q,m.attrs[n].start,m.attrs[n].value,!0)+this.unit;break;case"scrollLeft":case"scrollTop":var r=this.obj===document.body;if(!this.behaviorOverrides.ignoreUserScroll&&i(this,m))delete m.attrs.scrollTop,delete m.attrs.scrollLeft;else{var s=v(q,m.attrs[n].start,m.attrs[n].value,!0);!r?this.obj[n]=s:n=="scrollLeft"?a.scrollTo(s,g("scrollTop")):a.scrollTo(g("scrollLeft"),s);j(this,m)}break;case"translateX":case"translateY":case"translateZ":case"rotateX":case"rotateY":case"rotateZ":case"scaleX":case"scaleY":case"scaleZ":b("DataStore").set(this.obj,n,v(q,m.attrs[n].start,m.attrs[n].value,!1));break;default:this.obj.style[n]=v(q,m.attrs[n].start,m.attrs[n].value,!0)+this.unit;break}r=null;s=b("DataStore").get(this.obj,"translateX",0);q=b("DataStore").get(this.obj,"translateY",0);var x=b("DataStore").get(this.obj,"translateZ",0);(s||q||x)&&(r=o(r,[1,0,0,0,0,1,0,0,0,0,1,0,s,q,x,1]));s=b("DataStore").get(this.obj,"scaleX",1);q=b("DataStore").get(this.obj,"scaleY",1);x=b("DataStore").get(this.obj,"scaleZ",1);(s-1||q-1||x-1)&&(r=o(r,[s,0,0,0,0,q,0,0,0,0,x,0,0,0,0,1]));s=b("DataStore").get(this.obj,"rotateX",0);s&&(r=o(r,[1,0,0,0,0,Math.cos(s),Math.sin(-s),0,0,Math.sin(s),Math.cos(s),0,0,0,0,1]));q=b("DataStore").get(this.obj,"rotateY",0);q&&(r=o(r,[Math.cos(q),0,Math.sin(q),0,0,1,0,0,Math.sin(-q),0,Math.cos(q),0,0,0,0,1]));x=b("DataStore").get(this.obj,"rotateZ",0);x&&(r=o(r,[Math.cos(x),Math.sin(-x),0,0,Math.sin(x),Math.cos(x),0,0,0,0,1,0,0,0,0,1]));s=b("getVendorPrefixedName")("transform");if(s)if(r){q=k(r);b("Style").set(this.obj,s,q)}else d&&b("Style").set(this.obj,s,null);p==1&&(this.queue.splice(l--,1),this._callback(m.ondone,c-m.start-m.duration))}!e&&this.container_div&&this._destroy_container();return!d};j.prototype.ondone=function(a){this.state.ondone=a;return this};j.prototype._callback=function(a,b){a&&(p=b,a.call(this),p=0)};function v(a,b,c,d){return(d?parseInt:parseFloat)((c-b)*a+b,10)}function w(a){var b=/^#([a-f0-9]{1,2})([a-f0-9]{1,2})([a-f0-9]{1,2})$/i.exec(a);if(b)return[parseInt(b[1].length==1?b[1]+b[1]:b[1],16),parseInt(b[2].length==1?b[2]+b[2]:b[2],16),parseInt(b[3].length==1?b[3]+b[3]:b[3],16),1];else{b=/^rgba? *\(([0-9]+), *([0-9]+), *([0-9]+)(?:, *([0-9\.]+))?\)$/.exec(a);if(b)return[parseInt(b[1],10),parseInt(b[2],10),parseInt(b[3],10),b[4]?parseFloat(b[4]):1];else if(a=="transparent")return[255,255,255,0];else throw new Error("Named color attributes are not supported.")}}function x(a){h.push(a),h.length===1&&(g?g(z):i=b("setIntervalAcrossTransitions")(z,20)),g&&y(),z(Date.now(),!0)}function y(){if(!g)throw new Error("Ending timer only valid with requestAnimationFrame");var a=0;for(var c=0;c<h.length;c++){var d=h[c];for(var e=0;e<d.queue.length;e++){var f=d.queue[e].start+d.queue[e].duration;f>a&&(a=f)}}i&&(b("clearTimeout")(i),i=null);f=Date.now();a>f&&(i=b("setTimeoutAcrossTransitions")(b("shield")(z),a-f))}function z(a,c){a=Date.now();for(var c=c===!0?h.length-1:0;c<h.length;c++)try{h[c]._frame(a)||h.splice(c--,1)}catch(a){h.splice(c--,1)}h.length===0?i&&(g?b("clearTimeout")(i):b("clearInterval")(i),i=null):g&&g(z)}j.ease={};j.ease.begin=function(a){return Math.sin(Math.PI/2*(a-1))+1};j.ease.end=function(a){return Math.sin(.5*Math.PI*a)};j.ease.both=function(a){return.5*Math.sin(Math.PI*(a-.5))+.5};j.prependInsert=function(a,c){j.insert(a,c,b("DOM").prependContent)};j.appendInsert=function(a,c){j.insert(a,c,b("DOM").appendContent)};j.insert=function(a,c,d){b("Style").set(c,"opacity",0),d(a,c),new j(c).from("opacity",0).to("opacity",1).duration(400).go()};e.exports=j}),null);