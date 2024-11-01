<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$nt_option_data = array();

$attribute_keys = array_keys( $attributes );

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo htmlspecialchars( wp_json_encode( $available_variations ) ) ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); 

	?>

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>
	<?php else : ?>
		<table class="variations" cellspacing="0">
			<tbody>
				<?php foreach ( $attributes as $attribute_name => $options ) : 

					if ( empty( $_POST ) )
						$selected_value = ( isset( $selected_attributes[ sanitize_title( $attribute_name ) ] ) ) ? $selected_attributes[ sanitize_title( $attribute_name ) ] : '';
					else
						$selected_value = isset( $_POST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? $_POST[ 'attribute_' . sanitize_title( $attribute_name ) ] : '';

						$new_option  = array_values($options);
						$selected_value =  array_search($selected_value,$new_option);
					if(empty($selected_value)){
						$selected_value = 0;
					}

					$data_val = $options;

					$nt_option_data[] = array("data_value"=>$data_val,"selected_index"=>$selected_value,"id_selector"=>"attribute_".$attribute_name);	

				?>

					<tr>
						<td class="label"><label for="<?php echo sanitize_title( $attribute_name ); ?>"><?php echo wc_attribute_label( $attribute_name ); ?></label>
						    <input type="text" calss="slider_change" id="<?php echo "attribute_".$attribute_name  ?>" data-attribute_name="<?php echo "attribute_".$attribute_name  ?>" name="<?php echo "attribute_".$attribute_name  ?>" value="" />
						</td>
					</tr>
			
				<?php endforeach;?>
				<?php 

		//Register the script
		wp_register_script( 'woo_product_variation_range_slider_handle', WOO_PRODUCT_VARIATION_RANGE_SLIDER_PLUGIN_ULR .'assets/js/slider.js'); 

		// Localize the script with new data
		$translation_array = array(
		'woo_product_variation_range_slider_data' => $nt_option_data,
		
		);
		wp_localize_script( 'woo_product_variation_range_slider_handle', 'woo_product_variation_range_slider_object_name', $translation_array );

		// Enqueued script with localized data.
		wp_enqueue_script( 'woo_product_variation_range_slider_handle' );
				?>
			</tbody>
		</table>

		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<div class="single_variation_wrap">
			<?php
				/**
				 * woocommerce_before_single_variation Hook.
				 */
				do_action( 'woocommerce_before_single_variation' );

				/**
				 * woocommerce_single_variation hook. Used to output the cart button and placeholder for variation data.
				 * @since 2.4.0
				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
				 */
				do_action( 'woocommerce_single_variation' );

				/**
				 * woocommerce_after_single_variation Hook.
				 */
				do_action( 'woocommerce_after_single_variation' );
			?>
		</div>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>



<?php
do_action( 'woocommerce_after_add_to_cart_form' );
