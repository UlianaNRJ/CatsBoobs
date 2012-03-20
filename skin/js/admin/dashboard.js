jQuery(document).ready(function($){

	"use strict";

	$("input[name=all]").click(function(){
		var self = $(this),
		list = $("td input", "table.list");
		if (self.attr("checked")){
			list.attr({checked:"checked"});
		}else{
			list.removeAttr("checked");
		}
	})

});