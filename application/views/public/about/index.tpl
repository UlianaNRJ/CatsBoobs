{config_load file="{$lang|substr:0:3}about.conf"}
{config_load file="{$lang|substr:0:3}common.conf" section="index"}

<div class="upload">{#upload#}</div>

<div class="c text">
    <div class="ib left">
        <div class="padded">
            <h2>{#header_1#}</h2>

		    <p>{#p_1#}</p>

		    <p>{#p_1#}</p>

		    <p>{#p_3#}</p>

		    <ul>
			    <li>{#li_1_1#}</li>
			    <li>{#li_1_2#}</li>
			    <li>{#li_1_3#}</li>
			    <li>{#li_1_4#}</li>
			    <li>{#li_1_5#}</li>
		    </ul>

		    <p>{#p_5#}</p>
	        <p style="text-align: center;">
		        <img src="/skin/img/about_1.png" class="ib" height="133" width="200" alt="">
		        <img src="/skin/img/about_2.png" class="ib" height="133" width="200" alt="">
		        <img src="/skin/img/about_3.png" class="ib" height="133" width="200" alt="">
		        <img src="/skin/img/about_4.png" class="ib" height="133" width="200" alt="">
	        </p>

        </div>
    </div>
    <div class="ib right">
        <div class="padded">
	        <h2>{#header_2#}</h2>
	        <ul>
		        <li>{#li_2_1#}</li>
		        <li>{#li_2_2#}</li>
		        <li>{#li_2_3#}</li>
		        <li>{#li_2_4#}</li>
		        <li>{#li_2_5#}</li>
		        <li>{#li_2_6#}</li>
		        <li>{#li_2_7#}</li>
		        <li>{#li_2_8#}</li>
	        </ul>

		    <h2>{#header_3#}</h2>
	        <ul>
		        <li>{#li_3_1#}</li>
		        <li>{#li_3_2#}</li>
		        <li>{#li_3_3#}</li>
		        <li>{#li_3_4#}</li>
		        <li>{#li_3_5#}</li>
	        </ul>

	        <p>{#p_6#}
		        <a href="http://www.facebook.com/CatsBoobs" class="facebook">Facebook</a>,
	            <a href="https://twitter.com/#!/catsboobs" class="twitter">Twitter</a>,
		        <a href="http://vk.com/catsboobs" class="vkontakte">Vk.com</a>
	        </p>

		    <img src="/skin/img/about-cats.png" style="float: left;" class="ib" height="136" width="200" alt="">

	        <p style="line-height: 1.5em; margin-left: 220px; margin-top: 50px;">
	        {#p_7#}
	        <a href="mailto:catsboobs@gmail.com">cats@catsboobs.com</a></p>
        </div>
    </div>
</div>

{include file="public/upload.tpl"}