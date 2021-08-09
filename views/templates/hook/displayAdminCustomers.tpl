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
                    <td>#{$comment.id_froggy_comment}</td>
                    <td>{$comment.firstname} {$comment.lastname}</td>
                    <td>{$comment.email}</td>
                    <td>{$comment.product_name} (<a href="{$admin_product_link}&id_product={$comment.id_product}&updateproduct&key_tab=ModuleFroggycomments"> #{$comment.id_product}</a>)</td>
                    <td>{$comment.grade}/5</td>
                    <td>{$comment.comment}</td>
                    <td>{$comment.date_add}</td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
</div>