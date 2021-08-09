<fieldset>
	<div class="panel">
		<div class="panel-heading">
			<legend><i class="icon-info"></i> {l s='Comment on the product' mod='froggycomments'} {$froggycomment->product_name}</legend>
		</div>
		<div class="form-group clearfix">
			<label class="col-lg-3">{l s='ID' mod='froggycomments'} :</label>
			<div class="col-lg-9">{$froggycomment->id}</div>
		</div>
		<div class="form-group clearfix">
			<label class="col-lg-3">{l s='Firstname' mod='froggycomments'} :</label>
			<div class="col-lg-9">{$froggycomment->firstname}</div>
		</div>
		<div class="form-group clearfix">
			<label class="col-lg-3">{l s='Lastname' mod='froggycomments'} :</label>
			<div class="col-lg-9">{$froggycomment->lastname}</div>
		</div>
		<div class="form-group clearfix">
			<label class="col-lg-3">{l s='E-mail' mod='froggycomments'} :</label>
            <div class="col-lg-9">{if $admin_customer_link ne ''}<a href="{$admin_customer_link}">{/if}{$froggycomment->email}{if $admin_customer_link ne ''}</a>{/if}</div>
		</div>
		<div class="form-group clearfix">
			<label class="col-lg-3">{l s='Product' mod='froggycomments'} :</label>
            <div class="col-lg-9">{$froggycomment->product_name} (<a href="{$admin_product_link}">#{$froggycomment->id_product}</a>)</div>
		</div>
		<div class="form-group clearfix">
			<label class="col-lg-3">{l s='Grade' mod='froggycomments'} :</label>
			<div class="col-lg-9">{$froggycomment->grade}/5</div>
		</div>
		<div class="form-group clearfix">
			<label class="col-lg-3">{l s='Comment' mod='froggycomments'} :</label>
			<div class="col-lg-9">{$froggycomment->comment|nl2br}</div>
		</div>
	</div>
</fieldset>