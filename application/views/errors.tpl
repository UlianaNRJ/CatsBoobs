{assign var=errorMessages value=$CI->messages->get('error')}
{if !empty($errorMessages) && is_array($errorMessages)}
	<ul class="error-message">
	{foreach from=$errorMessages item=message}
	   <li>{$message}</li>
	{/foreach}
	</ul>
{/if}

{assign var=successMessages value=$CI->messages->get('success')}
{if !empty($successMessages) && is_array($successMessages)}
<ul class="success-message">
	{foreach from=$successMessages item=message}
	   <li>{$message}</li>
	{/foreach}
</ul>
{/if}