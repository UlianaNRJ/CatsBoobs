<a href="/about/" class="about"></a>
<select id="sorting">
	<option value="random">Случайные</option>
	<option value="date_desc">Новые</option>
	<option value="date_asc">Старые</option>
</select>
<div class="upload"></div>


<div class="main">
	<div class="images">
		<div class="holder left">
			<a class="ib arrow" href="#"></a>
		</div>
		<img src="{if $postModel}{baseurl()}content/{$postModel->getUniqid()}.png"{/if}" id="catsboobs" width="900" height="450" alt="Сиськи и котики - семейный развлекательный портал"/>
		<div class="holder right">
			<a class="ib arrow" href="#"></a>
		</div>
	</div>
	<div class="c social">
		<div class="ib" style="width: 110px; font-size: 14px; font-weight: bold; line-height: 35px;">
			Поделиться:
		</div>
		<div class="ib share_button btn_fb">

		</div>
		<div class="ib share_button btn_tw">

		</div>
		<div class="ib share_button btn_vk">

		</div>
		<div class="ib share_button btn_ok">
			<a class="odkl-klass" href="#">Класс!</a>
		</div>
		<div class="ib" style="padding: 3px 0;width: 130px;">

		</div>
		<div class="ib ">
            <a href="#" id="show_comments"></a>
		</div>
	</div>
    <div id="disqus_thread">

    </div>
    <div class="bottom">

    </div>
</div>

{include file="public/upload.tpl"}

<script id="fbLike" type="text/x-jquery-tmpl">
	<fb:like
			send="false"
			width="450"
			show_faces="false"
			href="{baseurl()}#!{literal}${id}{/literal}"
			layout="button_count"
	></fb:like>
</script>
<script id="twLike" type="text/x-jquery-tmpl">
    <a href="{baseurl()}#!{literal}${id}{/literal}"
       class="twitter-share-button"
       data-url="{baseurl()}#!{literal}${id}{/literal}"
       data-counturl="{baseurl()}#!{literal}${id}{/literal}"
       data-text="Мне нравятся котосиськи"
       data-lang="ru"
       data-via="CatsBoobs"
       data-hashtags="cats,boobs"
       rel="canonical"
    >Tweet</a>
</script>

<script>
	{literal}
	var social = {
		fb: "//connect.facebook.net/ru_RU/all.js#xfbml=1",
		tw: "//platform.twitter.com/widgets.js",
		vk: "//vk.com/js/api/share.js",
		//dq: "//catsboobs.disqus.com/embed.js",
		ok: "//stg.odnoklassniki.ru/share/odkl_share.js"
	};
	for(var i in social){
		var head = document.getElementsByTagName("head")[0],
		js = document.createElement("script");
		js.type = "text/javascript";
		js.async = true;
		js.src = social[i];
		head.appendChild(js);
	}
	{/literal}
</script>

<script src="http://catsboobs.disqus.com/embed.js" type="text/javascript"></script>

