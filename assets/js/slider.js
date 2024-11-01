jQuery( document ).ready(function() {

    jQuery.each(  woo_product_variation_range_slider_object_name.woo_product_variation_range_slider_data, function( key, value ) {
		var data = Object.values(value.data_value);
		var selected = value.selected_index;
		var id_selector = value.id_selector;
		var arr = Object.values(data);
		jQuery("#"+id_selector).ionRangeSlider({
		grid: true,
		from: selected,
		values: data,
		onFinish: function (data) {
        woo_product_variation_range_slider_message();
        },

		});
    });
    
});
