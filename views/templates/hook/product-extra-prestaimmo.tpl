<div class="d-flex">
    <div class="col-md-6 block_product_admin">
        <div class="equiment_product">
            <h4>{l s='choosing the equipments' mod='prestaimmo'}</h4>
            <table>
                {if $equipments}
                    {foreach $equipments as $equipment}
                        <tr>
                            <td>{$equipment.title}</td>
                            <td><input type="checkbox" id="{$equipment.title}" name="{$equipment.title}"
                                    value="{$equipment.id_equipment}">
                            <td>
                        </tr>
                    {/foreach}
                {/if}
            </table>
            <input type="hidden" class="equipment_by_product" name="equipment_by_product">
        </div>
        <div class="service_product">
            <h4>{l s='choosing the services' mod='prestaimmo'}</h4>
            <table>
                {if $services}
                    {foreach $services as $service}
                        <tr>
                            <td>{$service.title}</td>
                            <td><input type="checkbox" id="{$service.title}" name="{$service.title}"
                                    value="{$service.id_service}">
                            <td>
                        </tr>
                    {/foreach}
                {/if}
            </table>
            <input type="hidden" class="service_by_product" name="service_by_product">
        </div>
    </div>

    <div class="col-md-6 block_product_admin week">
        <div class="week_available">
            <h4>{l s='week available' mod='prestaimmo'}</h4>
            {$semaine}
            <input type="hidden" class="week_available" name="week_available">
        </div>
    </div>

    <input type="hidden" class="url"
        value="{$link->getAdminLink('AdminPrestaImmoLocation')|escape:'htmlall':'UTF-8'}&id_product={$product->id|escape:'htmlall':'UTF-8'}&action=addlocation&ajax=1&configure=prestaimmo" />
</div>

<div class="col">
    <a href="javascript:void(0);" id="save_info_location" class="btn btn-primary" title="{l s='Save' mod='prestaimmo'}">
        <i class="icon-copy"></i>
        {l s='Save' mod='prestaimmo'}
    </a>
</div>
<script>

</script>