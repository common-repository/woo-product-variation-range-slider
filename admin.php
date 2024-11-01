<?php
class WC_Settings_Tab_Demo
{
    /**
     * Bootstraps the class and hooks required actions & filters.
     *
     */
    public static function init()
    {
        add_filter('woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50);
        add_action('woocommerce_settings_tabs_woo-product-variation-range-slider-tab', __CLASS__ . '::settings_tab');
        add_action('woocommerce_update_options_woo-product-variation-range-slider-tab', __CLASS__ . '::update_settings');
    }
    
    
    /**
     * Add a new settings tab to the WooCommerce settings tabs array.
     *
     * @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Subscription tab.
     * @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Subscription tab.
     */
    public static function add_settings_tab($settings_tabs)
    {
        $settings_tabs['woo-product-variation-range-slider-tab'] = __('Range Slider', 'woo-product-variation-range-slider-tab');
        return $settings_tabs;
    }
    /**
     * Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
     *
     * @uses woocommerce_admin_fields()
     * @uses self::get_settings()
     */
    public static function settings_tab()
    {
        woocommerce_admin_fields(self::get_settings());
    }
    /**
     * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
     *
     * @uses woocommerce_update_options()
     * @uses self::get_settings()
     */
    public static function update_settings()
    {
        woocommerce_update_options(self::get_settings());
    }
    /**
     * Get all the settings for this plugin for @see woocommerce_admin_fields() function.
     *
     * @return array Array of settings for @see woocommerce_admin_fields() function.
     */
    public static function get_settings()
    {
        $settings = array(
            'section_title' => array(
                'name' => __('Woo Product Variation Range Slider', 'woo-product-variation-range-slider-tab'),
                'type' => 'title',
                'desc' => '',
                'id' => ''
            ),
            'title' => array(
                'name' => __('Title'),
                'type' => 'checkbox',
                'desc' => __('Use Woo Product Variation Range Slider', 'woo-product-variation-range-slider-tab'),
                'id' => 'woo-product-variation-range-slider'
            ),
            'section_end' => array(
                'type' => 'sectionend',
                'id' => 'wc_woo-product-variation-range-slider-tab_section_end'
            )
        );
        return apply_filters('wc_woo-product-variation-range-slider-tab_settings', $settings);
    }
}
WC_Settings_Tab_Demo::init();

?>