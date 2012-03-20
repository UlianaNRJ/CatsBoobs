{if $type == 'new'}
	<h1>Новые</h1>
	<a href="{baseurl()}admin/dashboard/list-posts/all">Смотреть все</a>
{else}
	<h1>Все</h1>
	<a href="{baseurl()}admin/dashboard/list-posts/new">Смотреть новые</a>
{/if}

{include file="errors.tpl"}

<form action="/admin/dashboard/mass-post/" method="post">
	<table class="wide list">
		<tr>
			<th><input type="checkbox" name="all"/></th>
			<th class="al-center">#</th>
			<th>Добавлена</th>
			<th>Картинка</th>
		</tr>
	{foreach from=$postList item=post name=latest}
		<tr class="{if $smarty.foreach.latest.index % 2}even{else}odd{/if}">
			<td><input type="checkbox" name="mass[{$post->getId()}]" /></td>
			<td><a href="{baseurl()}admin/dashboard/view-post/{$post->getId()}">{$post->getId()}</a></td>
			<td>{$post->getDateCreated()|date_format:$smarty.const.DATE_FORMAT}</td>
			<td><img src="{baseurl()}content/{$post->getUniqid()}.png" width="100" height="50" alt=""/></td>
		</tr>
	{/foreach}
		<tr>
			<th colspan="4">
			{$paging}
			</th>
		</tr>
	</table>
	С выделеными
	<input class="button" type="submit" name="delete" value="Удалить">
	<input class="button" type="submit" name="accept" value="Утвердить">
	<input class="button" type="submit" name="pending" value="В очередь">
</form>