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
                <th>{l s='Product' mod='froggycomments'}</th>
                <th>{l s='Grade' mod='froggycomments'}</th>
                <th>{l s='Comment' mod='froggycomments'}</th>
                <th>{l s='Date' mod='froggycomments'}</th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$comments item=comment}
                <tr>
                    <td>#{$comment.id_froggy_comment|escape:'htmlall':'UTF-8'}</td>
                    <td>{$comment.firstname|escape:'htmlall':'UTF-8'} {$comment.lastname|escape:'htmlall':'UTF-8'}</td>
                    <td>{$comment.email|escape:'htmlall':'UTF-8'}</td>
                    <td>{$comment.product_name|escape:'htmlall':'UTF-8'} (<a href="{$admin_product_link|escape:'htmlall':'UTF-8'}&id_product={$comment.id_product|escape:'htmlall':'UTF-8'}&updateproduct&key_tab=ModuleFroggycomments"> #{$comment.id_product|escape:'htmlall':'UTF-8'}</a>)</td>
                    <td>{$comment.grade|escape:'htmlall':'UTF-8'}/5</td>
                    <td>{$comment.comment|escape:'htmlall':'UTF-8'}</td>
                    <td>{$comment.date_add|escape:'htmlall':'UTF-8'}</td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
</div>