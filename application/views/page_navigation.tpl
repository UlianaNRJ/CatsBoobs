{if $directory!='admin' || ($directory=='admin' && $this->getAuth()->isUserAuthenticated())}

{* this should be one-line code *}
{foreach from=$this->getNavigation()->getItems() item=item }<a class="ib {if $item->current}current{/if}" href="{$item->url}">{$item->title}</a>{/foreach}

{/if}
