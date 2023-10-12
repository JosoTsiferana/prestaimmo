{**
* Prestashop module : Manualinvoicemanagement
*
* @author Progressio
* @copyright  Progressio
* @license Tous droits réservés / Le droit d'auteur s'applique (All rights reserved / French copyright law applies)
*}

{* <div style="font-size: 8pt; color: #444">

    <div style="text-align:left; font-size:1em; padding-bottom:1rem; padding-top: 2em;">
        {$manualinvoice->infoCustomer nofilter}
    </div>
    <br/>
    <br/>
    {assign var="firstpage" value="true"}
    {assign var="totals"  value="0"}
    {assign var="odd"  value="0"}

    <table id="manualinvoice_content" width="100%" style="text-align:left;" cellpadding="3">
        <thead>
        {assign var='odd' value=0}
        <tr style="color:#FFFFFF; background-color: #4D4D4D;">
            <td class="center" style="font-weight: bold; text-align:left; width:25%">{l s='Designation' mod='manualinvoicemanagement'}</td>
            <td class="center" style="font-weight: bold; text-align:left; width:30%">{l s='Description' mod='manualinvoicemanagement'}</td>
            <td class="center" style="font-weight: bold; text-align:left; width:15%">{l s='Unit price' mod='manualinvoicemanagement'}</td>
            <td class="center" style="font-weight: bold; text-align:left; width:10%">{l s='Qty' mod='manualinvoicemanagement'}</td>
            <td class="center" style="font-weight: bold; text-align:left; width:10%">{l s='Unit' mod='manualinvoicemanagement'}</td>
            <td class="center" style="font-weight: bold; text-align:right; width:10%">{l s='Total' mod='manualinvoicemanagement'}</td>
        </tr>
        </thead>
        <tbody>
        {if (!empty($manualinvoice_contents) && count($manualinvoice_count))}

        {foreach from=$manualinvoice_contents item='manualinvoice_content'}
            {assign var='odd' value=($odd+1)%2}
            {if $firstpage == "true"}
                {assign var="modulo" value=$maxProdFirstPage}
            {else}
                {assign var="modulo" value=$maxProdPage}
            {/if}
            {if $manualinvoice_count != 1 && ($manualinvoice_count % $modulo == 1 || $modulo == 1)}
                {assign var="manualinvoice_count" value=1}
                {assign var="firstpage" value="false"}
                <br pagebreak="true"/>
            {/if}

            <tr style="background-color: #FFF">
                <td style="width:25%">
                    {$manualinvoice_content['designation']|escape:'htmlall':'UTF-8'}
                </td>
                <td style="text-align:left; width:30%">
                    {$manualinvoice_content['description'] nofilter}
                </td>
                <td style="text-align:left; width:15%">
                    {Tools::displayPrice($manualinvoice_content['price_unit'])}
                </td>
                <td style="text-align:left; width:10%">
                    {$manualinvoice_content['quantity']}
                </td>
                <td style="text-align:left; width:10%">
                    {$manualinvoice_content['unit']|escape:'htmlall':'UTF-8'}
                </td>
                <td style="text-align:right; width:10%">
                    <span id="total_product_price nocustom">
                        {Tools::displayPrice($manualinvoice_content['total'])}
                    </span>
                </td>
            </tr>
            {assign var="totals" value=$totals+$manualinvoice_content['total']}
        {/foreach}
        {/if}
        </tbody>
        <br/>
        <tfoot>
        <tr style="color:#FFFFFF; background-color: #4D4D4D; font-weight:bold; padding:2px;text-align:right; font-size:110%">
            <td colspan="4">
                {l s='Total' mod='manualinvoicemanagement'}
            </td>
            <td colspan="2" style="text-align:right;">
                <span id="total_price">{Tools::displayPrice($totals)}</span>
            </td>
        </tr>
        </tfoot>
    </table>

</div> *}