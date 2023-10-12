<div class="d-flex">
    <div class="col-md-6 block_product_admin">
        <div class="equiment_product">
            <h4>{l s='choosing the equipments' mod='prestaimmo'}</h4>
            <table>
                {foreach $equipments as $equipment}
                    <tr>
                        <td>{$equipment.title}</td>
                        <td><input type="checkbox" id="{$equipment.title}" name="{$equipment.title}"
                                value="{$equipment.id_equipment}">
                        <td>
                    </tr>
                {/foreach}
            </table>
            <input type="hidden" class="equipment_by_product" name="equipment_by_product">
        </div>
        <div class="service_product">
            <h4>{l s='choosing the services' mod='prestaimmo'}</h4>
            <table>
                {foreach $services as $service}
                    <tr>
                        <td>{$service.title}</td>
                        <td><input type="checkbox" id="{$service.title}" name="{$service.title}"
                                value="{$service.id_equipment}">
                        <td>
                    </tr>
                {/foreach}
            </table>
            <input type="hidden" class="service_by_product" name="service_by_product">
        </div>
    </div>

    <div class="col-md-6 block_product_admin week">
        <div class="week available">
            <h4>{l s='week available' mod='prestaimmo'}</h4>
            {$semaine}
        </div>
    </div>
</div>