{**
* Prestashop module : Manualinvoicemanagement
*
* @author Progressio
* @copyright  Progressio
* @license Tous droits réservés / Le droit d'auteur s'applique (All rights reserved / French copyright law applies)
*}

{* <div class="panel">
    <h3 class="panel-heading">
        {l s='Manual Invoice information' mod='manualinvoicemanagement'}
    </h3>
    <div class="information_content">
        <span> {l s="Reference"}:  {$manualinvoice->reference|escape:'htmlall':'UTF-8'}</span>
        <span> {l s="Date"}:  {$manualinvoice->date_add|escape:'htmlall':'UTF-8'}</span>
        <span> {l s="Total"}: {Tools::displayPrice($manualinvoice->total)}</span>
    </div>
    <form class="form_info_client" action="{$hrefInfo|escape:'htmlall':'UTF-8'}" method="post"
          enctype="multipart/form-data">
        <div class="information_client"><label for=""> {l s="Customer details (name, surname, address)" mod='manualinvoicemanagement'} :</label></div>
        <input type="hidden" name="id_manualinvoice" value="{$manualinvoice->id_manualinvoicemanagement}">
        <textarea name="infoCustomer" id="infoCustomer" cols="50" rows="10" class="rte autoload_rte"
                  aria-hidden="true"> {if (!empty($manualinvoice->infoCustomer))}{$manualinvoice->infoCustomer}{/if}</textarea>
        <div class="panel-footer">
            <button id="manualinvoicemanagementBtnSubmitInfoClient" type="submit"
                    name="manualinvoicemanagementBtnSubmitInfoClient"
                    class="btn btn-default pull-right"><i class="process-icon-save"></i> {l s="Save"}</button>
        </div>
    </form>
</div>
{if (isset($manualinvoicemanagement_content) && $manualinvoicemanagement_content)}
    <div class="panel ">
        <h3 class="panel-heading">
            <i class="icon-list-alt"></i>
            {l s='Manual Invoice Content List' mod='manualinvoicemanagement'}
        </h3>
        <table class="table manualinvoicemanagement_content_table " id="panel-content">
            <thead>
            <tr class="nodrag nodrop">
                <th class=" center">
                    <span class="title_box">{l s="Designation" mod='manualinvoicemanagement'}</span>
                </th>
                <th class="center">
                    <span class="title_box">{l s="Description" mod='manualinvoicemanagement'}</span>
                </th>
                <th class="center">
                    <span class="title_box">{l s="Price unit" mod='manualinvoicemanagement'}</span>
                </th>
                <th class="center">
                    <span class="title_box">{l s="Quantity" mod='manualinvoicemanagement'}</span>
                </th>
                <th class="center">
                    <span class="title_box">{l s="Unit" mod='manualinvoicemanagement'}</span>
                </th>
                <th class="center">
                    <span class="title_box">{l s="Total" mod='manualinvoicemanagement'}</span>
                </th>
                <th class="center">
                    <span class="title_box">{l s="Action" mod='manualinvoicemanagement'}</span>
                </th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$manualinvoicemanagement_content item="manualinvoice_content" name="manualinvoice_content"}
                <tr>
                    <td class="pointer center">
                        <span class="title_box">{$manualinvoice_content["designation"]}</span>
                    </td>
                    <td class="pointer center">
                        <span class="title_box">{$manualinvoice_content["description"] nofilter}</span>
                    </td>
                    <td class="pointer center">
                        <span class="title_box">{Tools::displayPrice($manualinvoice_content["price_unit"])}</span>
                    </td>
                    <td class="pointer center">
                        <span class="title_box">{$manualinvoice_content["quantity"]}</span>
                    </td>
                    <td class="pointer center">
                        <span class="title_box">{$manualinvoice_content["unit"]}</span>
                    </td>
                    <td class="pointer center">
                        <span class="title_box">{Tools::displayPrice($manualinvoice_content["total"])}</span>
                    </td>
                    <td class="pointer center">
                        <a href="javascript:void(0)"
                           onclick="editInvoiceContent('{$manualinvoice_content['id_manualinvoicemanagement_content']}','{$manualinvoice_content['id_manualinvoicemanagement']}','{$manualinvoice_content['designation']}',
                                   '{$manualinvoice_content["description"]}','{$manualinvoice_content['price_unit']}','{$manualinvoice_content['quantity']}','{$manualinvoice_content['unit']}','{$manualinvoice_content['total']}')">
                            <i class="icon-pencil"></i>
                        </a>
                        <a href="{$href_delete|escape:'htmlall':'UTF-8'}&delete_manualinvoicecontent={$manualinvoice_content['id_manualinvoicemanagement_content']}&id_manualinvoice={$manualinvoice_content['id_manualinvoicemanagement']}">
                            <i class="icon-trash"></i>
                        </a>

                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>

    </div>
{/if}

<div class="panel">
    <h3 class="panel-heading">
        {l s='Manual Invoice Content Form' mod='manualinvoicemanagement'}
    </h3>
    <div class="info_manualinvoice">
        <span>{l s='Please fill the field to add content for this manual invoice!' mod='manualinvoicemanagement'}</span>
    </div>
    <form action="{$href|escape:'htmlall':'UTF-8'}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_manualinvoice" value="{$manualinvoice->id_manualinvoicemanagement}">
        <input type="hidden" name="edit_content" value="0" id="edit_content">
        <input type="hidden" name="id_content" value="0" id="id_content">
        <fieldset class="panel-form" id="parent_form">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-lg-3">
                        {l s='Designation :' mod='manualinvoicemanagement'}
                    </label>
                    <div class="col-lg-6">
                        <input type="text" value="" name="designation" id="designation" required/>
                    </div>
                </div>
            </div>
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-lg-3">
                        {l s='Description :' mod='manualinvoicemanagement'}
                    </label>
                    <div class="col-lg-6">
                        <textarea class="autoload_rte description" id="description" name="description"></textarea>
                    </div>
                </div>
            </div>
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-lg-3">
                        {l s='Unit :' mod='manualinvoicemanagement'}
                    </label>
                    <div class="col-lg-6">
                        <input type="text" value="" id="unit" name="unit"/>
                        <p class="help-block"> {l s='Unit like Box,Kg,Pack,...' mod='manualinvoicemanagement'}</p>
                    </div>
                </div>
            </div>
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-lg-3">
                        {l s='Price Unit :' mod='manualinvoicemanagement'}
                    </label>
                    <div class="col-lg-6">
                        <input type="number" id="price" step=".0001" name="price" required/>
                    </div>
                </div>
            </div>
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-lg-3">
                        {l s='Quantity :' mod='manualinvoicemanagement'}
                    </label>
                    <div class="col-lg-6">
                        <input type="number" id="quantity" step="1" name="quantity"/>

                    </div>
                </div>
            </div>

            <div class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-lg-3">
                        {l s='Total :' mod='manualinvoicemanagement'}
                    </label>
                    <div class="col-lg-6">
                        <input type="number" id="total" step=".0001" name="total" required/>
                    </div>
                </div>
            </div>
        </fieldset>
        <div class="panel-footer">
            <a href="javascript:void(0)" onclick="reset_form()"
               class="btn btn-default">
                <i class="process-icon-cancel"></i>
                {l s="Cancel" mod='manualinvoicemanagement'}
            </a>

            <a id="home-list-button"
               href="index.php?controller=AdminManualInvoice&amp;token=e7d3ea1b99beba1351e21f50525456e6"
               class="btn btn-default">
                {l s="Go to Manual Invoice List" mod='manualinvoicemanagement'}
            </a>
            <button id="manualinvoicemanagementBtnSubmit" type="submit" name="submitAddManualinvoicemanagementContent"
                    class="btn btn-default pull-right"><i class="process-icon-save"></i> {l s="Save"}</button>
        </div>
    </form>
</div>


{strip}
    {addJsDef ajaxUrl=$ajax_url}
    {addJsDef url=$href|escape:'htmlall':'UTF-8'}
    {addJsDef token=$token|escape:'htmlall':'UTF-8'}
    {addJsDef currency_sign=$currency_sign}
    {addJsDefL name=qty_text}{l s='quantity' js=1 mod='manualinvoicemanagement'}{/addJsDefL}
{/strip}

<script type="text/javascript">
    $(document).ready(function () {
        $('#price').change(function () {
            let unit_price = $(this).val();
            let quantity = $("#quantity").val();
            if ((quantity != '' && unit_price != '') && (!isNaN(quantity) && !isNaN(unit_price))) {
                if (quantity == 0) {
                    quantity = 1;
                    $("#quantity").val(1);
                }
                let total = quantity * unit_price;
                $("#total").val(total);
            } else if ((quantity != '' && unit_price != '') && (isNaN(quantity) && !isNaN(unit_price))) {
                $("#total").val(unit_price);
                $("#quantity").val(1);
            } else if ((quantity != '' && unit_price != '') && (!isNaN(quantity) && isNaN(unit_price))) {
                $(this).val(0);
                $("#total").val(0);
            } else if ((unit_price != '') && (!isNaN(unit_price))) {
                $("#quantity").val(1);
                $("#total").val(unit_price);
            } else $("#total").val('');
        });

        $('#quantity').change(function () {
            let quantity = $(this).val();
            let unit_price = $("#price").val();
            if ((quantity != '' && unit_price != '') && (!isNaN(quantity) && !isNaN(unit_price))) {
                if (quantity == 0) {
                    quantity = 1;
                    $("#quantity").val(1);
                }
                let total = quantity * unit_price;
                $("#total").val(total);

            } else if ((quantity != '' && unit_price != '') && (isNaN(quantity) && !isNaN(unit_price))) {
                $("#quantity").val(1);
                $("#total").val(unit_price);
            } else if ((quantity != '' && unit_price != '') && (!isNaN(quantity) && isNaN(unit_price))) {
                $('#price').val(0);
                $("#total").val(0);
            } else if ((unit_price != '') && (!isNaN(unit_price))) {
                $(this).val(1);
                $("#total").val(unit_price);
            } else $("#total").val('');
        });

    });

    function reset_form() {
        $('#designation').val('');
        $('#description').val('');
        $('#price').val('');
        $('#quantity').val('');
        $('#unit').val('');
        $('#total').val('');
        $("#edit_content").val(0);
        $("#id_content").val(0);
    }

    function editInvoiceContent(id_manualinvoicemanagement_content, id_manualinvoicemanagement, designation, description, price_unit, quantity, unit, total) {
        $('#designation').val(designation);
        $('#description').val(description);
        $('#price').val(price_unit);
        $('#quantity').val(quantity);
        $('#unit').val(unit);
        $('#total').val(total);
        $("#edit_content").val(1);
        $("#id_content").val(id_manualinvoicemanagement_content);
    }

</script>
{literal}
    <script type="text/javascript">
        var iso = 'fr';
        var pathCSS = '/themes/cerame/css/';
        var ad = '/admbv';
        var id_language = 2;
        $(document).ready(function () {
            tinySetup({
                editor_selector :"autoload_rte"
            });
        });


    </script>
{/literal} *}