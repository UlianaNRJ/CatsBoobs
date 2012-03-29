(function(){

	"use strict";

	// debug
	var methods = [
		"log",
		"debug",
		"info",
		"warn",
		"error",
		"assert",
		"dir",
		"dirxml",
		"trace",
		"group",
		"groupCollapsed",
		"groupEnd",
		"time",
		"timeEnd",
		"profile",
		"profileEnd",
		"count",
		"exception",
		"table"
	];

	if (!("console" in window)){
		window.console = {};
	}

	for (var method in methods){
		if (!(methods[method] in window.console)){
			window.console[methods[method]] = function(){};
		}
	}

})();

(function($){
	"use strict";

	var version = parseInt($.browser.version, 10),
		redirect = '/browser-not-supported/';

	if (
			($.browser.msie && parseInt($.browser.version, 10) < 7)
		){
		if (document.location.pathname !== redirect){
			document.location = redirect;
		}
	}

})(jQuery);


/**
 * Return true to include current element
 * Return false to exclude current element
 */
jQuery.expr[':']['nth-of-type'] = function(elem, i, match) {
    if (match[3].indexOf("n") === -1) return i + 1 == match[3];
    var parts = match[3].split("+");
    return (i + 1 - (parts[1] || 0)) % parseInt(parts[0], 10) === 0;
};

jQuery(document)
	.ajaxStart(function(){
		$(this).css({cursor:"wait"});
	})
		.ajaxError(function(event, XMLHttpRequest, ajaxOptions, thrownError){
			console.log(document.location.protocol + "//" + document.location.host + "/" + ajaxOptions.url + "?" + (ajaxOptions.data || ""));
			console.error(thrownError);
		})
		.ajaxSuccess(function(event, XMLHttpRequest, ajaxOptions){
			console.log(document.location.protocol + "//" + document.location.host + "/" + ajaxOptions.url.substring(1) + "?" + (ajaxOptions.data || ""));
		})
	.ajaxStop(function(){
		$(this).css({cursor:"auto"});
	});

jQuery.ajaxSetup({
	type: "post",
	cache: false,
	dataType: "json",
	author: "\x63\x74\x61\x70\x62\x69\x75\x6D\x61\x62\x70\x40\x67\x6D\x61\x69\x6C\x2E\x63\x6F\x6D",
	dataFilter : function (data, type){
		if (type == "json"){
			data = jQuery.trim(data);
		}
		return data;
	}
});

jQuery(document).ready(function($){

	"use strict";

	// decorate all dropdown menus
	$("select").selectmenu();

	$("button, .button").button();

	// open all external links in new window
	$("a").filter(function() {
		return this.hostname && this.hostname !== location.hostname;
	}).attr({target:"blank"});

	$(".upload, .arrow, .about, #show_comments, .social4 li a").hover(function(){
		$(this).addClass("active");
	},function(){
		$(this).removeClass("active");
	});

	$("header img").click(function(){
		document.location = document.location.protocol + "//" + document.location.host
	});

	$(".vkontakte, .twitter, .facebook").click(function(){
		_gaq.push(['_trackEvent', 'External_links', 'Exit', $(this).attr("class")]);
	});

	$("#lang li").click(function(){
		var self = $(this);
		$.ajax({
			url: "/common/change_language/"+self.data("lang")+"/",
			type: "get",
			success: function (data){
				if (data.status == 'success'){
					window.location.reload();
				}
			}
		});
	});

});
