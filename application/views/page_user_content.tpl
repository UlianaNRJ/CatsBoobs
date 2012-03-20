{* this should be one-line code *}
{assign var=account value=$this->ci()->getAuth()->getAccount()}
{if $account}
	{if $account|is_a:'\CatsBoobs\Models\Customer\AccountModel'}
		<a class="ib name" href="{$this->getSecureWebUrl('customer/account')}">{$account->getFullName()}</a>
		{if $this|is_a:'Bloodwork' || $this|is_a:'Nutrition' || $this|is_a:'Food'}
			<a class="ib help" href="#">Help</a>
		{/if}
		{if $account->getActivationState() == Customer_Account_Activation_State::PROFILE || $account->getActivationState() == Customer_Account_Activation_State::ACTIVE}
			<a class="ib" href="{$this->getSecureWebUrl('customer/settings')}">Settings</a>
		{/if}
	{/if}
	<a class="ib" href="{$this->getSecureWebUrl($directory|cat:'/logout')}">Log Out</a>
{else}
	{if !$this|is_a:'Login'}
		<a class="ib" href="{$this->getSecureWebUrl($directory|cat:'/login')}">Log In</a>
	{/if}
{/if}