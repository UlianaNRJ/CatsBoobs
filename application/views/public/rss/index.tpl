<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:dc="http://purl.org/dc/elements/1.1/">
{config_load file="{$lang|substr:0:3}common.conf" section="layout"}
{config_load file="{$lang|substr:0:3}common.conf" section="rss"}
	<channel>
		<title>{#name#}</title>
		<link>{base_url()}/rss</link>
		<description><![CDATA[{#description#}]]></description>
		<language>{$lang}</language>
		<generator>catsboobs.com</generator>
	{foreach from=$postList item=post}
		<item>
			<title>{#post#} #{$post->getId()}</title>
			<guid isPermaLink="true">{baseurl()}?_escaped_fragment_={$post->getUniqid()}</guid>
			<link>{baseurl()}#!{$post->getUniqid()}</link>
			<author>anonymous</author>
			<description><![CDATA[
				<img src="{baseurl()}content/{$post->getUniqid()}.png" height="450" width="900">
				]]></description>
			<pubDate>{$post->getDateCreated()|date_format:"D, d M Y H:i:s O"}</pubDate>
			<category><![CDATA[main]]></category>
		</item>
	{/foreach}
	</channel>
</rss>
