$.fn.ajaxSubmit.debug = true;

jQuery(document).ready(function($){

	"use strict";

	var current = {};

	var getPost = window.getPost = function getPost(id){
        if (id == current.id){
            return;
        }
		$.ajax({
			url: "/common/index-ajax-post/",
			data:{
				sort: $("#sorting").val(),
                id: id
			},
			success: function(data){
				if (!data) return; // {"id":1,"status":"1","dateCreated":"2012-02-25 08:08:23","uniqid":"4f487ad65fc2b","next":null,"prev":"4f4c7e13d7276"}
                current = data;
				location.hash = "#!" + data.id;

                // treat buttons
				$(".left .arrow, .right .arrow").show();
				if (!data.next){
                    $(".left .arrow").hide();
                }else {
                    $(".left .arrow").attr({href:"#!" + data.next});
                }
				if (!data.prev) {
                    $(".right .arrow").hide();
                }else {
                    $(".right .arrow").attr({href:"#!" + data.prev});
                }

                $("#show_comments").attr({href:"#!" + data.id + "/comments"});

                // set image
				$("#catsboobs").attr({src:"/content/" + data.uniqid + ".png"});

				try{
	                // FB share
	                $("meta[property='og:image']").attr({content:location.protocol + "//" + location.hostname + "/content/" + data.uniqid + ".png"});
	                $("meta[property='og:url']").attr({content:location.protocol + "//" + location.hostname + "/#!" + data.id});
	                $(".btn_fb").html($("#fbLike").tmpl(data));
	                window.FB.XFBML.parse();
				} catch (e){
					console.log("problems with FB");
				}

				try{
	                // Twitter share
	                $(".btn_tw").html($("#twLike").tmpl(data));
	                window.twttr.widgets.load();
				} catch (e){
					console.log("problems with TW");
				}

				try{
	                // VKontakte
	                $(".btn_vk").html(window.VK.Share.button({
	                    url: location.protocol + "//" + location.hostname + "/#!" + data.id,
	                    title: 'Семейный развлекательный портал «Сиськи и котики»',
	                    description: 'Это не только квинтэссенция всего приятного в интернете, но и действительно полезный для общества проект, призванный решить самые острые социальные проблемы!',
	                    image: location.protocol + "//" + location.hostname + "/content/" + data.uniqid + ".png",
	                    noparse: true
	                },{type: "round", text: "Мне нравится"}));
				} catch (e){
					console.log("problems with VK");
				}

				try{
	                // odnokassniki
	                $(".btn_ok a").attr({href:location.protocol + "//" + location.hostname + "/#!" + data.id});
				} catch (e){
					console.log("problems with VK");
				}

				try{
	                // DISQUS
	                window.DISQUS.reset({
	                    reload: true,
	                    config: function () {
	                        this.page.identifier = data.id;
	                        this.page.url = location.protocol + "//" + location.hostname + "/#!" + data.id;
	                        //this.page.url = "http://catsboobs.com/#!299";
	                    }
	                });
				} catch (e){
					console.log("problems with DQ");
				}
			}
		});
	};

	$(window).hashchange(function(){
        var commands = location.hash.substring(2).split("/");
		getPost(commands[0]);
		if (commands[1] == 'comments'){
			$("#show_comments").trigger("click");
		}
	}).hashchange();

	$("#show_comments").click(function(){
		$("#disqus_thread").toggle();
		_gaq.push(['_trackEvent', 'Comments', 'Open']);
		return false;
	});

	$(document).keydown(function(e){
		if (e.keyCode == 37){
			getPost(current.next);
		} else if (e.keyCode == 39) {
			getPost(current.prev);
		}
	});

	$("#catsboobs").click(function(){
		getPost(current.next);
	});

	$("#sorting").selectmenu("option", {select: function(event, ui){
		getPost();
	}});

	//window.ODKL.init();
	$(".btn_ok a").click(function(){
		window.ODKL.Share(this);
		return false;
	});

	window.disqus_callback = function() {
		window.DISQUS.dtpl.actions.register("comments.send", function(){
			_gaq.push(['_trackEvent', 'Comments', 'Leave_comment']);
			return true;
		});

		window.DISQUS.dtpl.actions.register("thread.vote", function(direction){
			_gaq.push(['_trackEvent', 'Disqus', direction>0?'Like':'Dislike']);
			return true;
		});
	}

});
