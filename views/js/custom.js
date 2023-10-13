$(document).ready(function () {
    /*var products = JSON.parse($('#getAllProdutByName').val());
	$('#product_name_location').autocomplete(products, {
		minChars: 1,
		matchContains: true
	});
*/
    //$('.equiment_product')
    $('.equiment_product input[type="checkbox"]').on("change", function() {
        var str = "";
        $('.equiment_product input[type="checkbox"]:checked').each(function() {
            str += $(this).val() + ",";
        });
        $('.equipment_by_product').val(str.substring(0, str.length - 1));
    });

    $('.service_product input[type="checkbox"]').on("change", function() {
        var str = "";
        $('.service_product input[type="checkbox"]:checked').each(function() {
            str += $(this).val() + ",";
        });
        $('.service_by_product').val(str.substring(0, str.length - 1));
    });

    $('.week_available input[type="checkbox"]').on("change", function() {
        var str = "";
        $('.week_available input[type="checkbox"]:checked').each(function() {
            str += $(this).val() + ",";
        });
        $('.week_available').val(str.substring(0, str.length - 1));
    });

    var yourModuleAjaxUrl = $('.url').val();
    $('#save_info_location').click(function() {
        $.ajax({
            type: 'POST',
            url: yourModuleAjaxUrl, 
            // Define the URL to your custom controller method
            data: {
                ajax: true,
                controller: 'AdminPrestaImmoLocation',
                action: 'addLocation', // prestashop already set camel case before execute method
                token: token, // Include any data you want to send
                id_product: $('#form_id_product').val(),
                equipement: $('.equipment_by_product').val(),
                service: $('.service_by_product').val(),
                week: $('.week_available').val()
            },
            success: function(data) {
                // Handle the response from the server
                alert("send success full", data)
            }
        });
    });
});