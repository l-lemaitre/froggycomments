{*
 *  @author    Ludovic Lemaître <contact@llemaitre.com>
 *  @copyright 2021 Ludovic Lemaître
 *  @license   https://github.com/l-lemaitre/froggycomments  Exemple
*}

<h1>{l s='Comments on product' mod='froggycomments'} "{$product->name|escape:'htmlall':'UTF-8'}"</h1>
<div class="rte">
	{foreach from=$comments item=comment}
        <div class="froggycomments-comment">
        	<img src="http://www.gravatar.com/avatar/{$comment.email|escape:'htmlall':'UTF-8'|trim|strtolower|md5}?s=45" class="pull-left img-thumbnail froggycomments-avatar" />
            <div>{$comment.firstname|escape:'htmlall':'UTF-8'} {$comment.lastname|escape:'htmlall':'UTF-8'|substr:0:1}. <small>{dateFormat date=$comment.date_add full=false}</small></div>
            <div class="star-rating"><i class="glyphicon glyphicon-star"></i> <strong>{l s='Grade' mod='froggycomments'} :</strong></div><input type="number" class="rating" value="{$comment.grade|escape:'htmlall':'UTF-8'}" min="0" max="5" step="1" data-size="xs" />
            {* if $comment.comment *}
            	<div><i class="glyphicon glyphicon-comment"></i> <strong>{l s='Comment' mod='froggycomments'} #{$comment.id_froggy_comment|escape:'htmlall':'UTF-8'} :</strong> {$comment.comment|escape:'htmlall':'UTF-8'}</div>
            {* /if *}
        </div>
        <hr />
	{/foreach}
</div>
<ul class="pagination">
    {for $count=1 to $nb_pages}{assign var=params value=[
        'module_action' => 'list',
        'product_rewrite' => $product->link_rewrite,
        'id_product' => $smarty.get.id_product,
        'page' => $count
    ]}
        {if $page ne $count}
            <li>
                <a href="{$link->getModuleLink('froggycomments', 'comments', $params)|escape:'htmlall':'UTF-8'}"><span>{$count|escape:'htmlall':'UTF-8'}</span></a>
        {else}
            <li class="active current">
                <span>{$count|escape:'htmlall':'UTF-8'}</span>
            </li>
        {/if}
    {/for}
</ul>