<!DOCTYPE HTML>
<html xmlns:og="http://ogp.me/ns#"
      xmlns:fb="http://ogp.me/ns/fb#">
	<head>
		<title>Сиськи и котики - семейный развлекательный портал</title>

		<meta name="keywords" content="">
		<meta name="description" content="Это не только квинтэссенция всего приятного в интернете, но и действительно полезный для общества проект, призванный решить самые острые социальные проблемы =) ">
		<meta name="generator" content="Microsoft FrontPage 1.0">

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta http-equiv="expires" content="0">
		<meta http-equiv="cache-control" content="no-cache">
		<meta http-equiv="pragma" content="no-cache">

		<meta property="og:title" content="Семейный развлекательный портал «Сиськи и котики»"/>
		<meta property="og:type" content="article"/>
		<meta property="og:image" content="{baseurl()}{if isset($postModel)}content/{$postModel->getUniqid()}{else}skin/img/fb_share{/if}.png"/>
		<meta property="og:url" content="{baseurl()}{if isset($postModel)}#!{$postModel->getId()}{/if}"/>
		<meta property="og:site_name" content="CatsBoobs"/>
		<meta property="og:locale" content="ru_RU"/>
		<meta property="fb:app_id" content="325899637437977"/>

		<link rel="icon" href="{baseurl()}/favicon.ico" type="image/x-icon">
		<link rel="alternate" type="application/rss+xml" title="RSS 2.0 - все картинки" href="{baseurl()}rss" />

		{foreach from=$this->getCssList() item=css}
		<link rel="stylesheet" type="text/css" media="{$css->media}" href="{$css->url}">
		{/foreach}
		
		<!--[if lt IE 9]>
		<script src="{$this->getUrl('skin/js/html5.js')}" type="text/javascript"></script>
		<![endif]-->

		{foreach from=$this->getJsList() item=js}
		<script type="text/javascript" src="{$js->url}"></script>
		{/foreach}
	</head>
	<body class="{$directory}">
		<div class="c background">
			<div class="ib pink">
				<div class="top">
					<img src="{$this->getImgUrl('background-header-left.png')}" height="44" width="244"/>
				</div>
				<div class="bottom">
				</div>
			</div>
			<div class="ib black">
				<div class="top">
					<img src="{$this->getImgUrl('background-header-right.png')}" height="42" width="249"/>
				</div>
				<div class="bottom">
				</div>
			</div>
		</div>

		<header>
			<div class="c wrapper">
				<a href="{baseurl()}">
					<img src="{$this->getImgUrl('logo.png')}" height="38" width="300" id="logo"/>
					<img src="{$this->getImgUrl('banner.png')}" height="55" width="427" id="banner"/>
				</a>
			</div>
		</header>

		<noscript><p class="wrapper">Javascript should be enabled in order to work with website</p></noscript>

		<article class="wrapper content {$class} {$method}">
			{"debug"|log_message:"Renderering $directory/$class/$method.tpl"}
			{include file="$directory/$class/$method.tpl"}
		</article>

		<footer>
			<div class="c wrapper">
				<div class="ib bottom">
					<!--LiveInternet counter--><script type="text/javascript"><!--
					{literal}
					document.write("<a href='http://www.liveinternet.ru/click' "+
							"target=_blank><img src='//counter.yadro.ru/hit?t26.8;r"+
							escape(document.referrer)+((typeof(screen)=="undefined")?"":
							";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
							screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
							";"+Math.random()+
							"' alt='' title='LiveInternet: показано число посетителей за"+
							" сегодня' "+
							"border='0' width='88' height='15' style='margin-top: 25px;'><\/a>");
					{/literal}
					//--></script><!--/LiveInternet-->
					<div class="note" style="padding-right: 10px; margin-top: 15px;">CatsBoobs.com - квинтэссенция всего приятного в Интернете: сиськи, котики, груди, киски, буфера, девушки, коты и кошки - только лучшие фотографии на одном портале!</div>
				</div>
				<div class="ib bottom">
					<ul class="c social4">
						<li class="ib"><a href="mailto:catsboobs@gmail.com" class="email"></a></li>
						<li class="ib"><a href="http://vk.com/catsboobs" class="vkontakte"></a></li>
						<li class="ib"><a href="http://www.facebook.com/CatsBoobs" class="facebook"></a></li>
						<li class="ib"><a href="https://twitter.com/#!/catsboobs" class="twitter"></a></li>
					</ul>
					<a class="maxim" href="http://www.facebook.com/yumaxi"></a>
					<a class="copy" href="http://digity.com.ua/"></a>
					<div class="note" style="padding-left: 10px;">"Сайт не несет ответственности за содержание материалов, размещаемых пользователями. Все картинки являются собственностью их правообладателей. Для урегулирования спорных вопросов, свяжитесь с редакцией, и спорный контент будет удален"</div>
				</div>
			</div>
		</footer>

		<div id="fb-root"></div>
		<script src="{$this->getUrl('skin/js/social.js')}" type="text/javascript"></script>
		<script type="text/javascript">
		{literal}
		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true; ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(ga, s);
		})();
		{/literal}
		</script>

		<!-- Yandex.Metrika counter -->
		<div style="display:none;">
			<script type="text/javascript">
				{literal}
				(function(w,c){(w[c]=w[c]||[]).push(function(){try{w.yaCounter13079503=new Ya.Metrika({id:13079503,enableAll:true});}catch(e){}});})(window, "yandex_metrika_callbacks");
				{/literal}
			</script>
		</div>
		<script src="//mc.yandex.ru/metrika/watch.js" type="text/javascript" defer="defer"></script>
		<noscript><div><img src="//mc.yandex.ru/watch/13079503" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
		<!-- /Yandex.Metrika counter -->
	</body>
</html>