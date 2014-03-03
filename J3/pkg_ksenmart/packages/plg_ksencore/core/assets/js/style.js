jQuery(document).ready(function() {
	var params = { 
			changedEl: ".sel", 
		} 
	cuSel(params);
    
	jQuery('body').on('click', '.cb-enable', function(){
        var value  = jQuery(this).data().value;
        var parent = jQuery(this).parents('.switch');
        
        jQuery('.cb-disable', parent).removeClass('selected');
        jQuery(this).addClass('selected');
        parent.parent().children('input[type="hidden"]').val(value);
    });
    
    jQuery('body').on('click', '.cb-disable', function(){
        var value  = jQuery(this).data().value;
        var parent = jQuery(this).parents('.switch');
        
        jQuery('.cb-enable',parent).removeClass('selected');
        jQuery(this).addClass('selected');
        parent.parent().children('input[type="hidden"]').val(value);
    });
    
	jQuery('#add-alg').on('click', function() {
		jQuery('#popup-window2').fadeIn(400);
	});
	jQuery('.popup-window .close').on('click', function() {
		jQuery(this).parents('.popup-window').fadeOut(400);
	});
	jQuery('.set .add').on('click', function() {
		jQuery('#popup-window1').fadeIn(400);
	});
	jQuery('#add-country').on('click', function() {
		jQuery('#popup-window3').fadeIn(400);
	});
	jQuery('#add-city').on('click', function() {
		jQuery('#popup-window4').fadeIn(400);
	});
	jQuery('#add-action').on('click', function() {
		jQuery('#popup-window5').fadeIn(400);
	});	
});

/* -------------------------------------

	cusel version 2.5
	last update: 31.10.11
	смена обычного селект на стильный
	autor: Evgen Ryzhkov
	updates by:
		- Alexey Choporov
		- Roman Omelkovitch
	using libs:
		- jScrollPane
		- mousewheel
	www.xiper.net
----------------------------------------	
*/
function cuselScrollToCurent(a){var b=null;if(a.find(".cuselOptHover").eq(0).is("span"))b=a.find(".cuselOptHover").eq(0);else if(a.find(".cuselActive").eq(0).is("span"))b=a.find(".cuselActive").eq(0);if(a.find(".jScrollPaneTrack").eq(0).is("div")&&b){var c=b.position(),d=a.find(".cusel-scroll-pane").eq(0).attr("id");jQuery("#"+d)[0].scrollTo(c.top)}}function cuselShowList(a){var b=a.parent(".cusel");if(a.css("display")=="none"){$(".cusel-scroll-wrap").css("display","none");$(".cuselOpen").removeClass("cuselOpen");b.addClass("cuselOpen");a.css("display","block");var c=false;if(b.prop("class").indexOf("cuselScrollArrows")!=-1)c=true;if(!a.find(".jScrollPaneContainer").eq(0).is("div")){a.find("div").eq(0).jScrollPaneCusel({showArrows:c})}cuselScrollToCurent(a)}else{a.css("display","none");b.removeClass("cuselOpen")}}function cuSelRefresh(a){var b=a.refreshEl.split(","),c=b.length,d;for(d=0;d<c;d++){var e=jQuery(b[d]).parents(".cusel").find(".cusel-scroll-wrap").eq(0);e.find(".cusel-scroll-pane").jScrollPaneRemoveCusel();e.css({visibility:"hidden",display:"block"});var f=e.find("span"),g=f.eq(0).outerHeight();if(f.length>a.visRows){e.css({height:g*a.visRows+"px",display:"none",visibility:"visible"}).children(".cusel-scroll-pane").css("height",g*a.visRows+"px")}else{e.css({display:"none",visibility:"visible"})}}}function cuSel(a){function b(){jQuery("html").unbind("click");jQuery("html").on('click', function(a){var b=jQuery(a.target),c=b.attr("id"),d=b.prop("class");if((d.indexOf("cuselText")!=-1||d.indexOf("cuselFrameRight")!=-1)&&b.parent().prop("class").indexOf("classDisCusel")==-1){var e=b.parent().find(".cusel-scroll-wrap").eq(0);cuselShowList(e)}else if(d.indexOf("cusel")!=-1&&d.indexOf("classDisCusel")==-1&&b.is("div")){var e=b.find(".cusel-scroll-wrap").eq(0);cuselShowList(e)}else if(b.is(".cusel-scroll-wrap span")&&d.indexOf("cuselActive")==-1){var f;b.attr("val")==undefined?f=b.text():f=b.attr("val");b.parents(".cusel-scroll-wrap").find(".cuselActive").eq(0).removeClass("cuselActive").end().parents(".cusel-scroll-wrap").next().val(f).end().prev().text(b.text()).end().css("display","none").parent(".cusel").removeClass("cuselOpen");b.addClass("cuselActive");b.parents(".cusel-scroll-wrap").find(".cuselOptHover").removeClass("cuselOptHover");if(d.indexOf("cuselActive")==-1)b.parents(".cusel").find(".cusel-scroll-wrap").eq(0).next("input").change()}else if(b.parents(".cusel-scroll-wrap").is("div")){return}else{jQuery(".cusel-scroll-wrap").css("display","none").parent(".cusel").removeClass("cuselOpen")}});jQuery(".cusel").unbind("keydown");jQuery(".cusel").keydown(function(a){var b,c;if(window.event)b=window.event.keyCode;else if(a)b=a.which;if(b==null||b==0||b==9)return true;if(jQuery(this).prop("class").indexOf("classDisCusel")!=-1)return false;if(b==40){var d=jQuery(this).find(".cuselOptHover").eq(0);if(!d.is("span"))var e=jQuery(this).find(".cuselActive").eq(0);else var e=d;var f=e.next();if(f.is("span")){jQuery(this).find(".cuselText").eq(0).text(f.text());e.removeClass("cuselOptHover");f.addClass("cuselOptHover");$(this).find("input").eq(0).val(f.attr("val"));cuselScrollToCurent($(this).find(".cusel-scroll-wrap").eq(0));return false}else return false}if(b==38){var d=$(this).find(".cuselOptHover").eq(0);if(!d.is("span"))var e=$(this).find(".cuselActive").eq(0);else var e=d;cuselActivePrev=e.prev();if(cuselActivePrev.is("span")){$(this).find(".cuselText").eq(0).text(cuselActivePrev.text());e.removeClass("cuselOptHover");cuselActivePrev.addClass("cuselOptHover");$(this).find("input").eq(0).val(cuselActivePrev.attr("val"));cuselScrollToCurent($(this).find(".cusel-scroll-wrap").eq(0));return false}else return false}if(b==27){var g=$(this).find(".cuselActive").eq(0).text();$(this).removeClass("cuselOpen").find(".cusel-scroll-wrap").eq(0).css("display","none").end().find(".cuselOptHover").eq(0).removeClass("cuselOptHover");$(this).find(".cuselText").eq(0).text(g)}if(b==13){var h=$(this).find(".cuselOptHover").eq(0);if(h.is("span")){$(this).find(".cuselActive").removeClass("cuselActive");h.addClass("cuselActive")}else var i=$(this).find(".cuselActive").attr("val");$(this).removeClass("cuselOpen").find(".cusel-scroll-wrap").eq(0).css("display","none").end().find(".cuselOptHover").eq(0).removeClass("cuselOptHover");$(this).find("input").eq(0).change()}if(b==32&&$.browser.opera){var j=$(this).find(".cusel-scroll-wrap").eq(0);cuselShowList(j)}if($.browser.opera)return false});var a=[];jQuery(".cusel").keypress(function(b){function g(){var b=[];for(var c in a){if(window.event)b[c]=a[c].keyCode;else if(a[c])b[c]=a[c].which;b[c]=String.fromCharCode(b[c]).toUpperCase()}var d=jQuery(e).find("span"),f=d.length,g,h;for(g=0;g<f;g++){var i=true;for(var j in a){h=d.eq(g).text().charAt(j).toUpperCase();if(h!=b[j]){i=false}}if(i){jQuery(e).find(".cuselOptHover").removeClass("cuselOptHover").end().find("span").eq(g).addClass("cuselOptHover").end().end().find(".cuselText").eq(0).text(d.eq(g).text());cuselScrollToCurent($(e).find(".cusel-scroll-wrap").eq(0));a=a.splice;a=[];break;return true}}a=a.splice;a=[]}var c,d;if(window.event)c=window.event.keyCode;else if(b)c=b.which;if(c==null||c==0||c==9)return true;if(jQuery(this).prop("class").indexOf("classDisCusel")!=-1)return false;var e=this;a.push(b);clearTimeout(jQuery.data(this,"timer"));var f=setTimeout(function(){g()},500);jQuery(this).data("timer",f);if(jQuery.browser.opera&&window.event.keyCode!=9)return false})}jQuery(a.changedEl).each(function(c){var d=jQuery(this),e=d.outerWidth(),f=d.prop("class"),g=d.prop("id")?d.prop("id"):"cuSel-"+c,h=d.prop("name"),j=d.val(),k=d.find("option[value='"+j+"']").eq(0),l=k.text(),m=d.prop("disabled"),n=a.scrollArrows,o=d.prop("onchange"),p=d.prop("tabindex"),q=d.prop("multiple");if(!g||q)return false;var r=d.data("events"),s=[];if(r&&r["change"]){$.each(r["change"],function(a,b){s[s.length]=b})}if(!m){classDisCuselText="",classDisCusel=""}else{classDisCuselText="classDisCuselLabel";classDisCusel="classDisCusel"}if(n){classDisCusel+=" cuselScrollArrows"}k.addClass("cuselActive");var t=d.html(),u=t.replace(/option/ig,"span").replace(/value=/ig,"val=");if($.browser.msie&&parseInt($.browser.version)<9){var v=/(val=)(.*?)(>)/g;u=u.replace(v,"$1'$2'$3")}var w='<div class="cusel '+f+" "+classDisCusel+'"'+" id=cuselFrame-"+g+' style="width:'+e+'px"'+' tabindex="'+p+'"'+">"+'<div class="cuselFrameRight"></div>'+'<div class="cuselText">'+l+"</div>"+'<div class="cusel-scroll-wrap"><div class="cusel-scroll-pane" id="cusel-scroll-'+g+'">'+u+"</div></div>"+'<input type="hidden" id="'+g+'" name="'+h+'" value="'+j+'" />'+"</div>";d.replaceWith(w);if(o)jQuery("#"+g).bind("change",o);if(s.length){$.each(s,function(a,b){$("#"+g).bind("change",b)})}var x=jQuery("#cuselFrame-"+g),y=x.find("span"),z;if(!y.eq(0).text()){z=y.eq(1).innerHeight();y.eq(0).css("height",y.eq(1).height())}else{z=y.eq(0).innerHeight()}if(y.length>a.visRows){x.find(".cusel-scroll-wrap").eq(0).css({height:z*a.visRows+"px",display:"none",visibility:"visible"}).children(".cusel-scroll-pane").css("height",z*a.visRows+"px")}else{x.find(".cusel-scroll-wrap").eq(0).css({display:"none",visibility:"visible"})}var A=jQuery("#cusel-scroll-"+g).find("span[addTags]"),B=A.length;for(i=0;i<B;i++)A.eq(i).append(A.eq(i).attr("addTags")).removeAttr("addTags");b()});jQuery(".cusel").focus(function(){jQuery(this).addClass("cuselFocus")});jQuery(".cusel").blur(function(){jQuery(this).removeClass("cuselFocus")});jQuery(".cusel").hover(function(){jQuery(this).addClass("cuselFocus")},function(){jQuery(this).removeClass("cuselFocus")})}(function(a){a.jScrollPaneCusel={active:[]};a.fn.jScrollPaneCusel=function(b){b=a.extend({},a.fn.jScrollPaneCusel.defaults,b);var c=function(){return false};return this.each(function(){var d=a(this);var e=this.parentNode.offsetWidth;d.css("overflow","hidden");var f=this;if(a(this).parent().is(".jScrollPaneContainer")){var g=b.maintainPosition?d.position().top:0;var h=a(this).parent();var i=e;var j=h.outerHeight();var k=j;a(">.jScrollPaneTrack, >.jScrollArrowUp, >.jScrollArrowDown",h).remove();d.css({top:0})}else{var g=0;this.originalPadding=d.css("paddingTop")+" "+d.css("paddingRight")+" "+d.css("paddingBottom")+" "+d.css("paddingLeft");this.originalSidePaddingTotal=(parseInt(d.css("paddingLeft"))||0)+(parseInt(d.css("paddingRight"))||0);var i=e;var j=d.innerHeight();var k=j;d.wrap("<div class='jScrollPaneContainer'></div>").parent().css({height:j+"px",width:i+"px"});if(!window.navigator.userProfile){var l=parseInt(a(this).parent().css("border-left-width"))+parseInt(a(this).parent().css("border-right-width"));i-=l;a(this).css("width",i+"px").parent().css("width",i+"px")}a(document).bind("emchange",function(a,c,e){d.jScrollPaneCusel(b)})}if(b.reinitialiseOnImageLoad){var m=a.data(f,"jScrollPaneImagesToLoad")||a("img",d);var n=[];if(m.length){m.each(function(c,e){a(this).bind("load",function(){if(a.inArray(c,n)==-1){n.push(e);m=a.grep(m,function(a,b){return a!=e});a.data(f,"jScrollPaneImagesToLoad",m);b.reinitialiseOnImageLoad=false;d.jScrollPaneCusel(b)}}).each(function(a,b){if(this.complete||this.complete===undefined){this.src=this.src}})})}}var o=this.originalSidePaddingTotal;var p={height:"auto",width:i-b.scrollbarWidth-b.scrollbarMargin-o+"px"};if(b.scrollbarOnLeft){p.paddingLeft=b.scrollbarMargin+b.scrollbarWidth+"px"}else{p.paddingRight=b.scrollbarMargin+"px"}d.css(p);var q=d.outerHeight();var r=j/q;if(r<.99){var s=d.parent();s.append(a('<div class="jScrollPaneTrack"></div>').css({width:b.scrollbarWidth+"px"}).append(a('<div class="jScrollPaneDrag"></div>').css({width:b.scrollbarWidth+"px"}).append(a('<div class="jScrollPaneDragTop"></div>').css({width:b.scrollbarWidth+"px"}),a('<div class="jScrollPaneDragBottom"></div>').css({width:b.scrollbarWidth+"px"}))));var t=a(">.jScrollPaneTrack",s);var u=a(">.jScrollPaneTrack .jScrollPaneDrag",s);if(b.showArrows){var v;var w;var x;var y;var z=function(){if(y>4||y%4==0){Q(J+w*I)}y++};var A=function(b){a("html").unbind("mouseup",A);v.removeClass("jScrollActiveArrowButton");clearInterval(x)};var B=function(){a("html").bind("mouseup",A);v.addClass("jScrollActiveArrowButton");y=0;z();x=setInterval(z,100)};s.append(a("<div></div>").attr({"class":"jScrollArrowUp"}).css({width:b.scrollbarWidth+"px"}).bind("mousedown",function(){v=a(this);w=-1;B();this.blur();return false}).bind("click",c),a("<div></div>").attr({"class":"jScrollArrowDown"}).css({width:b.scrollbarWidth+"px"}).bind("mousedown",function(){v=a(this);w=1;B();this.blur();return false}).bind("click",c));var C=a(">.jScrollArrowUp",s);var D=a(">.jScrollArrowDown",s);if(b.arrowSize){k=j-b.arrowSize-b.arrowSize;t.css({height:k+"px",top:b.arrowSize+"px"})}else{var E=C.height();b.arrowSize=E;k=j-E-D.height();t.css({height:k+"px",top:E+"px"})}}var F=a(this).css({position:"absolute",overflow:"visible"});var G;var H;var I;var J=0;var K=r*j/2;var L=function(a,b){var c=b=="X"?"Left":"Top";return a["page"+b]||a["client"+b]+(document.documentElement["scroll"+c]||document.body["scroll"+c])||0};var M=function(){return false};var N=function(){bc();G=u.offset(false);G.top-=J;H=k-u[0].offsetHeight;I=2*b.wheelSpeed*H/q};var O=function(b){N();K=L(b,"Y")-J-G.top;a("html").bind("mouseup",P).bind("mousemove",R);if(a.browser.msie){a("html").bind("dragstart",M).bind("selectstart",M)}return false};var P=function(){a("html").unbind("mouseup",P).unbind("mousemove",R);K=r*j/2;if(a.browser.msie){a("html").unbind("dragstart",M).unbind("selectstart",M)}};var Q=function(a){a=a<0?0:a>H?H:a;J=a;u.css({top:a+"px"});var c=a/H;F.css({top:(j-q)*c+"px"});d.trigger("scroll");if(b.showArrows){C[a==0?"addClass":"removeClass"]("disabled");D[a==H?"addClass":"removeClass"]("disabled")}};var R=function(a){Q(L(a,"Y")-G.top-K)};var S=Math.max(Math.min(r*(j-b.arrowSize*2),b.dragMaxHeight),b.dragMinHeight);u.css({height:S+"px"}).bind("mousedown",O);var T;var U;var V;var W=function(){if(U>8||U%4==0){Q(J-(J-V)/2)}U++};var X=function(){clearInterval(T);a("html").unbind("mouseup",X).unbind("mousemove",Y)};var Y=function(a){V=L(a,"Y")-G.top-K};var Z=function(b){N();Y(b);U=0;a("html").bind("mouseup",X).bind("mousemove",Y);T=setInterval(W,100);W()};t.bind("mousedown",Z);s.bind("mousewheel",function(a,b){N();bc();var c=J;Q(J-b*I);var d=c!=J;return false});var _;var ba;function bb(){var a=(_-J)/b.animateStep;if(a>1||a<-1){Q(J+a)}else{Q(_);bc()}}var bc=function(){if(ba){clearInterval(ba);delete _}};var bd=function(c,e){if(typeof c=="string"){$e=a(c,d);if(!$e.length)return;c=$e.offset().top-d.offset().top}s.scrollTop(0);bc();var f=-c/(j-q)*H;if(e||!b.animateTo){Q(f)}else{_=f;ba=setInterval(bb,b.animateInterval)}};d[0].scrollTo=bd;d[0].scrollBy=function(a){var b=-parseInt(F.css("top"))||0;bd(b+a)};N();bd(-g,true);a("*",this).bind("focus",function(c){var e=a(this);var f=0;while(e[0]!=d[0]){f+=e.position().top;e=e.offsetParent()}var g=-parseInt(F.css("top"))||0;var h=g+j;var i=f>g&&f<h;if(!i){var k=f-b.scrollbarMargin;if(f>g){k+=a(this).height()+15+b.scrollbarMargin-j}bd(k)}});if(location.hash){bd(location.hash)}a(document).bind("click",function(b){$target=a(b.target);if($target.is("a")){var c=$target.attr("href");if(c.substr(0,1)=="#"){bd(c)}}});a.jScrollPaneCusel.active.push(d[0])}else{d.css({height:j+"px",width:i-this.originalSidePaddingTotal+"px",padding:this.originalPadding});d.parent().unbind("mousewheel")}})};a.fn.jScrollPaneRemoveCusel=function(){a(this).each(function(){$this=a(this);var b=$this.parent();if(b.is(".jScrollPaneContainer")){$this.css({top:"",height:"",width:"",padding:"",overflow:"",position:""});$this.attr("style",$this.data("originalStyleTag"));b.after($this).remove()}})};a.fn.jScrollPaneCusel.defaults={scrollbarWidth:10,scrollbarMargin:5,wheelSpeed:18,showArrows:false,arrowSize:0,animateTo:false,dragMinHeight:1,dragMaxHeight:99999,animateInterval:100,animateStep:3,maintainPosition:true,scrollbarOnLeft:false,reinitialiseOnImageLoad:false};a(window).bind("unload",function(){var b=a.jScrollPaneCusel.active;for(var c=0;c<b.length;c++){b[c].scrollTo=b[c].scrollBy=null}})})(jQuery);(function(a){a.event.special.mousewheel={setup:function(){var b=a.event.special.mousewheel.handler;if(a.browser.mozilla)a(this).bind("mousemove.mousewheel",function(b){a.data(this,"mwcursorposdata",{pageX:b.pageX,pageY:b.pageY,clientX:b.clientX,clientY:b.clientY})});if(this.addEventListener)this.addEventListener(a.browser.mozilla?"DOMMouseScroll":"mousewheel",b,false);else this.onmousewheel=b},teardown:function(){var b=a.event.special.mousewheel.handler;a(this).unbind("mousemove.mousewheel");if(this.removeEventListener)this.removeEventListener(a.browser.mozilla?"DOMMouseScroll":"mousewheel",b,false);else this.onmousewheel=function(){};a.removeData(this,"mwcursorposdata")},handler:function(b){var c=Array.prototype.slice.call(arguments,1);b=a.event.fix(b||window.event);a.extend(b,a.data(this,"mwcursorposdata")||{});var d=0,e=true;if(b.wheelDelta)d=b.wheelDelta/120;if(b.detail)d=-b.detail/3;b.data=b.data||{};b.type="mousewheel";c.unshift(d);c.unshift(b);return a.event.handle.apply(this,c)}};a.fn.extend({mousewheel:function(a){return a?this.bind("mousewheel",a):this.trigger("mousewheel")},unmousewheel:function(a){return this.unbind("mousewheel",a)}})})(jQuery);