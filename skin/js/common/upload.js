$.fn.ajaxSubmit.debug = true;

jQuery(document).ready(function($){

	"use strict";

	$("#upload_dialog").dialog({
		autoOpen: false,
		heght: 300,
		width: 500,
		modal: true,
		dialogClass: "uploader",
		resizable: false,
		close: function(){
			$(".error", "#upload_dialog").text("");
			$("#status").text("").removeClass("success error");
			$(".name, .size","#upload_dialog").text("");
			$("input[type=file]","#upload_dialog").val("")
		},
		buttons: [
			{
				text: "Ок",
				click: function(){
					//$(this).dialog("close");
					$(".error", "#upload_dialog").text("");
					$("#status").text("").removeClass("success error");
					$('#upload_form').submit();
				}
			},{
				text: "Закрыть",
				click: function(){
					$(this).dialog("close");
					_gaq.push(['_trackEvent', 'New_Photo', 'Close']);
				}
			}
		]
	});

	$(".upload").click(function(){
		$("#upload_dialog").dialog("open");
	});
	$("#upload_form button").click(function(){
		$(this).next().click();
		return false;
	});
	$("#upload_form input[type=file]").change(function(){
		var self = $(this);
		self.parent().find(".name").text("Имя:" + self.val().split("\\").pop().substring(0, 20)); // +"…"
		self.parent().find(".size").text("Размер:" + (this.files[0].size/1024).toFixed(2) + "Kb");
	});
	$('#upload_form').ajaxForm({
		dataType: "html",
		beforeSend: function(){
			$("#loading").show();
		},
		complete: function(){
			$("#loading").hide();
		},
		success: function(data){
			var errors = $.parseJSON(data);
			if ($.isEmptyObject(errors)){
				$("#status").text("Картинки успешно отправлены на модерацию").addClass("success");
				$("#upload_dialog")
					.find(".name, .size").text("").end()
					.find("input[type=file]").val("");
				_gaq.push(['_trackEvent', 'New_Photo', 'Add_success']);
			}else{
				$("#status").text("При загрузке картинок произошли ошибки").addClass("error");
				for(var i in errors){
					$(".error", "#"+i).text(errors[i]);
				}
				_gaq.push(['_trackEvent', 'New_Photo', 'Add_fail']);
			}
		},
		error: function(){
			_gaq.push(['_trackEvent', 'New_Photo', 'Add_fail']);
		}
	});
});