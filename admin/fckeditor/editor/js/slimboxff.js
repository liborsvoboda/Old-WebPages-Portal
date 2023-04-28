/*
	Slimbox v1.58 - The ultimate lightweight Lightbox clone
	(c) 2007-2009 Christophe Beyls <http://www.digitalia.be>
	MIT-style license.
*/
var Slimbox=(function(){var G=window,v,h,H=-1,q,x,F,w,z,N,t,l=r.bindWithEvent(),f=window.opera&&(navigator.appVersion>="9.3"),p=document.documentElement,o={},u=new Image(),L=new Image(),J,b,i,K,e,I,c,B,M,y,j,d,D;G.addEvent("domready",function(){$(document.body).adopt($$(J=new Element("div",{id:"lbOverlay"}),b=new Element("div",{id:"lbCenter"}),I=new Element("div",{id:"lbBottomContainer"})).setStyle("display","none"));i=new Element("div",{id:"lbImage"}).injectInside(b).adopt(K=new Element("a",{id:"lbPrevLink",href:"#"}),e=new Element("a",{id:"lbNextLink",href:"#"}));K.onclick=C;e.onclick=g;var O;c=new Element("div",{id:"lbBottom"}).injectInside(I).adopt(O=new Element("a",{id:"lbCloseLink",href:"#"}),B=new Element("div",{id:"lbCaption"}),M=new Element("div",{id:"lbNumber"}),new Element("div",{styles:{clear:"both"}}));O.onclick=J.onclick=E});function A(){var P=G.getScrollLeft(),O=f?p.clientWidth:G.getWidth();$$(b,I).setStyle("left",P+(O/2));if(w){J.setStyles({left:P,top:G.getScrollTop(),width:O,height:G.getHeight()})}}function n(O){["object",G.ie6?"select":"embed"].forEach(function(Q){$each(document.getElementsByTagName(Q),function(R){if(O){R._slimbox=R.style.visibility}R.style.visibility=O?"hidden":R._slimbox})});J.style.display=O?"":"none";var P=O?"addEvent":"removeEvent";G[P]("scroll",A)[P]("resize",A);document[P]("keydown",l)}function r(P){var O=P.code;if(v.closeKeys.contains(O)){E()}else{if(v.nextKeys.contains(O)){g()}else{if(v.previousKeys.contains(O)){C()}}}P.stop()}function C(){return a(x)}function g(){return a(F)}function a(O){if(O>=0){H=O;q=h[O][0];x=(H||(v.loop?h.length:0))-1;F=((H+1)%h.length)||(v.loop?0:-1);s();b.className="lbLoading";o=new Image();o.onload=m;o.src=q}return false}function m(){b.className="";d.set(0);i.setStyles({width:o.width,backgroundImage:"url("+q+")",display:""});$$(i,K,e).setStyle("height",o.height);B.setHTML(h[H][1]||"");M.setHTML((((h.length>1)&&v.counterText)||"").replace(/{x}/,H+1).replace(/{y}/,h.length));if(x>=0){u.src=h[x][0]}if(F>=0){L.src=h[F][0]}N=i.offsetWidth;t=i.offsetHeight;var O=Math.max(0,z-(t/2));if(b.offsetHeight!=t){j.chain(j.start.pass({height:t,top:O},j))}if(b.offsetWidth!=N){j.chain(j.start.pass({width:N,marginLeft:-N/2},j))}j.chain(function(){I.setStyles({width:N,top:O+t,marginLeft:-N/2,visibility:"hidden",display:""});d.start(1)});j.callChain()}function k(){if(x>=0){K.style.display=""}if(F>=0){e.style.display=""}D.set(-c.offsetHeight).start(0);I.style.visibility=""}function s(){o.onload=Class.empty;o.src=u.src=L.src=q;j.clearChain();j.stop();d.stop();D.stop();$$(K,e,i,I).setStyle("display","none")}function E(){if(H>=0){s();H=x=F=-1;b.style.display="none";y.stop().chain(n).start(0)}return false}Element.extend({slimbox:function(O,P){$$(this).slimbox(O,P);return this}});Elements.extend({slimbox:function(O,R,Q){R=R||function(S){return[S.href,S.title]};Q=Q||function(){return true};var P=this;P.forEach(function(S){S.removeEvents("click").addEvent("click",function(T){var U=P.filter(Q,this);Slimbox.open(U.map(R),U.indexOf(this),O);T.stop()}.bindWithEvent(S))});return P}});return{open:function(Q,P,O){v=$extend({loop:false,overlayOpacity:0.8,overlayFadeDuration:400,resizeDuration:400,resizeTransition:false,initialWidth:250,initialHeight:250,imageFadeDuration:400,captionAnimationDuration:400,counterText:"Obrázek {x} z {y}",closeKeys:[27,88,67],previousKeys:[37,80],nextKeys:[39,78]},O||{});y=J.effect("opacity",{duration:v.overlayFadeDuration});j=b.effects($extend({duration:v.resizeDuration},v.resizeTransition?{transition:v.resizeTransition}:{}));d=i.effect("opacity",{duration:v.imageFadeDuration,onComplete:k});D=c.effect("margin-top",{duration:v.captionAnimationDuration});if(typeof Q=="string"){Q=[[Q,P]];P=0}z=G.getScrollTop()+((f?p.clientHeight:G.getHeight())/4);N=v.initialWidth;t=v.initialHeight;b.setStyles({top:Math.max(0,z-(t/2)),width:N,height:t,marginLeft:-N/2,display:""});w=G.ie6||(J.currentStyle&&(J.currentStyle.position!="fixed"));if(w){J.style.position="absolute"}y.set(0).start(v.overlayOpacity);A();n(1);h=Q;v.loop=v.loop&&(h.length>1);return a(P)}}})();

// AUTOLOAD CODE BLOCK (MAY BE CHANGED OR REMOVED)
Slimbox.scanPage = function() {
	$$($$("a").filter(function(el) {
		return el.rel && el.rel.test(/^lightbox/i);
	})).slimbox({/* Put custom options here */}, null, function(el) {
		return (this == el) || ((this.rel.length > 8) && (this.rel == el.rel));
	});
};
if (!/android|iphone|ipod|series60|symbian|windows ce|blackberry/i.test(navigator.userAgent)) {
	window.addEvent("domready", Slimbox.scanPage);
}
