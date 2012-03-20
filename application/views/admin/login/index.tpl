<h1>Authorization</h1>

{include file="errors.tpl"}

<form class="normal" action="{$this->getSecureWebUrl('admin/login/index-post')}" method="post">
	<label for="email">Email:</label>
	<input type="text" class="text ui-corner-all" id="email" name="admin[email]" value=""/>

	<label for="password">Password:</label>
	<input type="password" class="text ui-corner-all" id="password" name="admin[password]" value=""/>

	<input class="button small right ui-corner-all" name="submit" type="submit" value="Login"/>

	<input id="autologin" type="checkbox" {if $account->autologin}checked="checked"{/if} name="admin[autologin]" />
	<label class="input-checkbox" for="autologin">Remember me</label>
</form>

