/**
 * Prestashop module : Manualinvoicemanagement
 *
 * @author Progressio
 * @copyright  Progressio
 * @license Tous droits réservés / Le droit d'auteur s'applique (All rights reserved / French copyright law applies)
 */

$(document).ready(function(){

     // initialize tinymce
    tinySetup({
        editor_selector : "autoload_rte",
        plugins : 'code advlist autolink link lists charmap print textcolor colorpicker style',
        forced_root_block : ""
    });



    $('#opart_devis_select_cart_rules').change(function(e) {
        e.preventDefault();

        $('#opartDevisCartRulesMsgError').hide('fast');

        if ($(this).val() == "-1") {
            return false;
        }

        if ($('#trCartRule_'+$(this).val()).length > 0) {
            $('#opartDevisCartRulesMsgError').html('This rule is already in cart');
            $('#opartDevisCartRulesMsgError').show('fast');

            return false;
        }

        var data = $('#opartDevisForm').serializeArray();

        data.push(
            {name: 'ajax', value: true},
            {name: 'action', value: 'AddCartRule'},
            {name: 'token', value: token},
            {name: 'id_cart_rule', value: $(this).val()}
        );

        $.ajax({
            type: 'POST',
            url: ajaxUrl,
            dataType: 'JSON',
            data: $.param(data),
            success: function(data) {
                if (!data.id) {
                    $('#opartDevisCartRulesMsgError').html(data);
                    $('#opartDevisCartRulesMsgError').show('fast');
                } else {
                    opartDevisAddRuleToQuotation(
                        data.id,
                        data.name[id_lang_default],
                        data.description,
                        data.code,
                        data.free_shipping,
                        data.reduction_percent,
                        data.reduction_amount,
                        '0',
                        data.gift_product
                    );
                }
            }, error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

        //opartDevisLoadCarrierList();
    });

});



function opartDevisDeleteUploadedFile(element){
    $.ajax({
        type: 'POST',
        url: ajaxUrl,
        data: {
            ajax: true,
            action: 'DeleteUploadedFile',
            token: token,
            upload_name: $(element).attr('data-name'),
            upload_id: $(element).attr('data-id')
        },
        success: function(data) {
            console.log(data);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });
}

