$(document).ready(function () {
    var products = JSON.parse($('#getAllProdutByName').val());
	$('#product_name_location').autocomplete(products, {
		minChars: 1,
		matchContains: true
	});

    //$("#module_prestaimmo").parents().addClass("presta_immohhhhhhhhhhh");
    var $targetElements = $('#module_prestaimmo');

    // Add a class to their parent elements
    $targetElements.each(function() {
        $(this).parent().addClass('your-added-class');
    });
    console.log('bnnnnnnnnnnnnnnnn');
   // Select the button with the data-target attribute set to "module-prestaimmo"
   var $button = $('button[data-target="module-prestaimmo"]');

   // Attach a click event handler to the selected button
   $button.on('click', function() {
       // Your custom code to execute when the button is clicked
       // For example, trigger an alert
       alert('Button with data-target "module-prestaimmo" was clicked');
   });

   // Simulate a click event on the button (you can remove this if you want the click to be triggered by a user)
   $button.click();
});