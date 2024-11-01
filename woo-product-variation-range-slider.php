<?php
/**
Plugin Name: Woo Product Variation Range Slider
Description: Woo Product Variation Range Slider
Version: 2.0.0
Author: TheWPexperts 
Author URI: http://www.thewpexperts.com/ 
License: GPL 2.0
Text Domain: woocommerce
*/


define('WOO_PRODUCT_VARIATION_RANGE_SLIDER_VERSION', "1.0");
define('WOO_PRODUCT_VARIATION_RANGE_SLIDER_PLUGIN_PREFIX', "WOO_PRODUCT_VARIATION_RANGE_SLIDER");
define('WOO_PRODUCT_VARIATION_RANGE_SLIDER_PLUGIN_ULR', plugin_dir_url(__FILE__));
define('WOO_PRODUCT_VARIATION_RANGE_SLIDER_PLUGIN_DIR', plugin_dir_path(__FILE__));


add_filter('init', 'woo_product_variation_range_slider_init');
function woo_product_variation_range_slider_init()
{
    /* plugin active check */
    $woo_product_variation_range_slider_status = get_option("woo-product-variation-range-slider");
    if ($woo_product_variation_range_slider_status == 'yes') {
        add_filter('woocommerce_locate_template', 'woo_product_variation_range_slider_woocommerce_locate_template', 20, 3);
    }
}

if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    /*  WooCommerce settings tabs */
    require(WOO_PRODUCT_VARIATION_RANGE_SLIDER_PLUGIN_DIR . "admin.php");
    
    function wooradio_plugin_path()
    {
        // gets the absolute path to this plugin directory 
        return untrailingslashit(WOO_PRODUCT_VARIATION_RANGE_SLIDER_PLUGIN_DIR);
    }
    
    
    
    
    function woo_product_variation_range_slider_woocommerce_locate_template($template, $template_name, $template_path)
    {
        global $woocommerce;
        $_template = $template;
        if (!$template_path)
            $template_path = $woocommerce->template_url;
        $plugin_path = wooradio_plugin_path() . '/woocommerce/';
        // Look within passed path within the theme - this is priority 
        $template    = locate_template(array(
            $template_path . $template_name,
            $template_name
        ));
        // Modification: Get the template from this plugin, if it exists 
        if (!$template && file_exists($plugin_path . $template_name))
            $template = $plugin_path . $template_name;
        // Use default template 
        if (!$template)
            $template = $_template;
        // Return what we found 
        return $template;
    }
    
    
    function register_woo_product_variation_range_slider_scripts()
    {
        
        
        wp_dequeue_script('wc-add-to-cart-variation');
        wp_register_script('rangeSlider', WOO_PRODUCT_VARIATION_RANGE_SLIDER_PLUGIN_ULR . 'assets/js/ion.rangeSlider.min.js', array(
            'jquery'
        ), WOO_PRODUCT_VARIATION_RANGE_SLIDER_VERSION, true);

        wp_register_script('slider_validation', WOO_PRODUCT_VARIATION_RANGE_SLIDER_PLUGIN_ULR . 'assets/js/slider_validation.js', array(
            'jquery'
        ), WOO_PRODUCT_VARIATION_RANGE_SLIDER_VERSION, true);
        wp_register_style('rangeSlider_CSS', WOO_PRODUCT_VARIATION_RANGE_SLIDER_PLUGIN_ULR . 'assets/css/ion.rangeSlider.css');
        wp_register_style('rangeSlider_core', WOO_PRODUCT_VARIATION_RANGE_SLIDER_PLUGIN_ULR . 'assets/css/ion.rangeSlider.skinHTML5.css');
        wp_enqueue_style('rangeSlider_CSS');
        wp_enqueue_style('rangeSlider_core');
        wp_enqueue_script('rangeSlider');
        wp_enqueue_script('slider_validation');
    }
    add_action('wp_footer', 'register_woo_product_variation_range_slider_scripts');
    
}
