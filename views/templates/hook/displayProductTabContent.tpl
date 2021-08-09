<h3 id="froggycomments-content-tab" class="page-product-heading" {if isset($new_comment_posted)}data-scroll="true"{/if}>{l s='Product Comments' mod='froggycomments'}</h3>
<div class="rte">
	{foreach from=$comments item=comment}
        <div class="froggycomments-comment">
        	<img src="http://www.gravatar.com/avatar/{$comment.email|trim|strtolower|md5}?s=45" class="pull-left img-thumbnail froggycomments-avatar" />
			<div>{$comment.firstname} {$comment.lastname|substr:0:1}. <small>{dateFormat date=$comment.date_add full=false}</small></div>
            <div class="star-rating"><i class="glyphicon glyphicon-star"></i> <strong>{l s='Grade' mod='froggycomments'} :</strong></div><input type="number" class="rating" value="{$comment.grade}" min="0" max="5" step="1" data-size="xs" />
            {* if $comment.comment *}
            	<div><i class="glyphicon glyphicon-comment"></i> <strong>{l s='Comment' mod='froggycomments'} #{$comment.id_froggy_comment} :</strong> {$comment.comment}</div>
            {* /if *}
        </div>
        <hr />
	{/foreach}
	<div class="rte">
		{assign var=params value=[
			'module_action' => 'list',
			'product_rewrite' => $product->link_rewrite,
			'id_product'=> $smarty.get.id_product,
			'page' => 1
		]}
		<p align="center"><a href="{$link->getModuleLink('froggycomments', 'comments', $params)}">{l s='See all comments' mod='froggycomments'}</a></p>
	</div>
	{if $enable_grades eq 1 OR $enable_comments eq 1}
		{if isset($new_comment_posted) && $new_comment_posted eq 'error'}
			<div class="alert alert-danger">
				<p>{l s='Some fields of the form seems wrong, please check them before submitting your comment.' mod='froggycomments'}</p>
			</div>
		{/if}
		<form id="comment-form" method="POST" action="">
			<div class="form-group">
				<label for="firstname">{l s='Firstname' mod='froggycomments'} :</label>
				<div class="row">
					<div class="col-xs-4">
						<input type="text" id="firstname" class="form-control" name="firstname" required />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="lastname">{l s='Lastname' mod='froggycomments'} :</label>
				<div class="row">
					<div class="col-xs-4">
						<input type="text" id="lastname" class="form-control" name="lastname" required />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="email">{l s='Email:' mod='froggycomments'} :</label>
				<div class="row">
					<div class="col-xs-4">
						<input type="email" id="email" class="form-control" name="email" required />
					</div>
				</div>
			</div>
			{if $enable_grades eq 1}
				<div class="form-group">
					<label for="grade">{l s='Grade' mod='froggycomments'} :</label>
					<div class="row">
						<div class="col-xs-4" id="grade-tab">
							<input type="number" id="grade" class="rating" name="grade" value="0" min="0" max="5" step="1" data-size="sm" />
						</div>
					</div>
				</div>
			{/if}
			{if $enable_comments eq 1}
				<div class="form-group">
					<label for="comment">{l s='Comment' mod='froggycomments'} :</label>
					<textarea id="comment" class="form-control" name="comment" required></textarea>
				</div>
			{/if}
			<div class="submit">
				<button type="submit" class="button btw btn-default button-medium" name="froggy_pc_submit_comment">
					<span>{l s='Send' mod='froggycomments'}<i class="icon-chevron-right right"></i></span>
				</button>
			</div>
		</form>
	{/if}
</div>