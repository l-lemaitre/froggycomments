{*
 *  @author    Ludovic Lemaître <contact@llemaitre.com>
 *  @copyright 2021 Ludovic Lemaître
 *  @license   https://github.com/l-lemaitre/froggycomments  Exemple
*}

<div class="product-tab-content" id="product-tab-content-froggycomments">
    <div class="panel product-tab" id="product-froggycomments">
        <h3 class="tab"> <i class="icon-info"></i> {l s='Product Comments' mod='froggycomments'}</h3>
        <table style="width:100%">
            <thead>
            <tr>
                <th>{l s='ID' mod='froggycomments'}</th>
                <th>{l s='Author' mod='froggycomments'}</th>
                <th>{l s='E-mail' mod='froggycomments'}</th>
                <th>{l s='Grade' mod='froggycomments'}</th>
                <th>{l s='Comment' mod='froggycomments'}</th>
                <th>{l s='Date' mod='froggycomments'}</th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$comments item=comment name=table}
                <tr>
                    <td>#{$comment.id_froggy_comment|escape:'htmlall':'UTF-8'}</td>
                    <td>{$comment.firstname|escape:'htmlall':'UTF-8'} {$comment.lastname|escape:'htmlall':'UTF-8'}</td>
                    <td>{if $customersMail[$smarty.foreach.table.index] eq $comment.email}<a href="{$admin_customer_link[$smarty.foreach.table.index]|escape:'htmlall':'UTF-8'}">{/if}{$comment.email|escape:'htmlall':'UTF-8'}{if $customersMail[$smarty.foreach.table.index] eq $comment.email}</a>{/if}</td>
                    <td>{$comment.grade|escape:'htmlall':'UTF-8'}/5</td>
                    <td>{$comment.comment|escape:'htmlall':'UTF-8'}</td>
                    <td>{$comment.date_add|escape:'htmlall':'UTF-8'}</td>
                </tr>
            {/foreach}
            </tbody>
        </table>
        {if $nb_pages gt 1}
            <ul class="pagination">
                {for $count=1 to $nb_pages}
                    {if $page ne $count}
                        <li><a class="comments-pagination-link" href="{$ajax_action_url|escape:'htmlall':'UTF-8'}&configure=froggycomments&ajax_hook=displayAdminProductsExtra&id_product={$smarty.get.id_product|escape:'htmlall':'UTF-8'}&page={$count|escape:'htmlall':'UTF-8'}"><span>{$count|escape:'htmlall':'UTF-8'}</span></a></li>
                    {else}
                        <li class="active current"><span><span>{$count|escape:'htmlall':'UTF-8'}</span></span></li>
                    {/if}
                {/for}
            </ul>
            <script type="text/javascript" src="{$pc_base_dir|escape:'htmlall':'UTF-8'}views/js/froggycomments-backoffice-product.js"></script>
        {/if}
    </div>
</div>