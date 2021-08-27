{*
 *  @author    Ludovic Lemaître <contact@llemaitre.com>
 *  @copyright 2021 Ludovic Lemaître
 *  @license   https://github.com/l-lemaitre/froggycomments  Exemple
*}

<fieldset>
	<div class="panel">
		<div class="panel-heading">
			<legend><i class="icon-info"></i> {l s='Comment on the product' mod='froggycomments'} {$froggycomment->product_name|escape:'htmlall':'UTF-8'}</legend>
		</div>
		<div class="form-group clearfix">
			<label class="col-lg-3">{l s='ID' mod='froggycomments'} :</label>
			<div class="col-lg-9">{$froggycomment->id|escape:'htmlall':'UTF-8'}</div>
		</div>
		<div class="form-group clearfix">
			<label class="col-lg-3">{l s='Firstname' mod='froggycomments'} :</label>
			<div class="col-lg-9">{$froggycomment->firstname|escape:'htmlall':'UTF-8'}</div>
		</div>
		<div class="form-group clearfix">
			<label class="col-lg-3">{l s='Lastname' mod='froggycomments'} :</label>
			<div class="col-lg-9">{$froggycomment->lastname|escape:'htmlall':'UTF-8'}</div>
		</div>
		<div class="form-group clearfix">
			<label class="col-lg-3">{l s='E-mail' mod='froggycomments'} :</label>
            <div class="col-lg-9">{if $admin_customer_link ne ''}<a href="{$admin_customer_link|escape:'htmlall':'UTF-8'}">{/if}{$froggycomment->email|escape:'htmlall':'UTF-8'}{if $admin_customer_link ne ''}</a>{/if}</div>
		</div>
		<div class="form-group clearfix">
			<label class="col-lg-3">{l s='Product' mod='froggycomments'} :</label>
            <div class="col-lg-9">{$froggycomment->product_name|escape:'htmlall':'UTF-8'}
            	(<a href="{$admin_product_link|escape:'htmlall':'UTF-8'}">#{$froggycomment->id_product|escape:'htmlall':'UTF-8'}</a>)</div>
		</div>
		<div class="form-group clearfix">
			<label class="col-lg-3">{l s='Grade' mod='froggycomments'} :</label>
			<div class="col-lg-9">{$froggycomment->grade|escape:'htmlall':'UTF-8'}/5</div>
		</div>
		<div class="form-group clearfix">
			<label class="col-lg-3">{l s='Comment' mod='froggycomments'} :</label>
			<div class="col-lg-9">{$froggycomment->comment|escape:'htmlall':'UTF-8'|nl2br}</div>
		</div>
	</div>
</fieldset>