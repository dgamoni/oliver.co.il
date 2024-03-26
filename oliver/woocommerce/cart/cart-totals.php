<?php
/**
 * Cart totals
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="cart_totals <?php if ( WC()->customer->has_calculated_shipping() ) echo 'calculated_shipping'; ?>">

	<?php do_action( 'woocommerce_before_cart_totals' ); ?>

	<h2><?php _e( 'Cart Totals', 'woocommerce' ); ?></h2>

	<table cellspacing="0" class="shop_table shop_table_responsive">

		<tr class="cart-subtotal">
			<th><?php _e( 'Subtotal', 'woocommerce' ); ?></th>
			<td data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>"><?php wc_cart_totals_subtotal_html(); ?></td>
		</tr>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
				<td data-title="<?php echo esc_attr( wc_cart_totals_coupon_label( $coupon, false ) ); ?>"><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>
			
			<?php 
			 // rules for delivery
			 // is longer then 70cm in cart, this method not available 
			// LV state
			$customer_state = WC()->customer->shipping_country;
			var_dump($customer_state);
			$rules_for_delivery = false;
			$rules_for_delivery2 = false;
			$rules_for_delivery3 = false;
			$size = 70;
			$size2 = 60;
			$size3 = 90;
			foreach ( WC()->cart->get_cart() as $key=>$product_cart ) {
		  		$product_cart_id[$key]	=	$product_cart['product_id'];
		  		$res = get_post_meta($product_cart_id[$key]);
		        //var_dump( $res );
				// var_dump( $res['_width'][0] );
				// var_dump( $res['_length'][0] );
				// var_dump( $res['_height'][0] );
				if ( ( intval($res['_width'][0])>=$size ) || ( intval($res['_length'][0])>=$size ) || ( intval($res['_height'][0])>=$size ) ) {
					//echo ' size1 ';
					$rules_for_delivery = true;
				} else {
					//echo ' nosize1 ';

				}
				if ( ( intval($res['_width'][0])>=$size2 ) || ( intval($res['_length'][0])>=$size2 ) || ( intval($res['_height'][0])>=$size2 ) ) {
					//echo ' size2 ';
					$rules_for_delivery2 = true;
				} else {
					//echo ' nosize2 ';

				}
				if ( ( intval($res['_width'][0])>=$size3 ) || ( intval($res['_length'][0])>=$size3 ) || ( intval($res['_height'][0])>=$size3 ) ) {
					//echo ' size3 ';
					$rules_for_delivery3 = true;
				} else {
					//echo ' nosize3 ';

				}

			} //end foreach

			 if ( $rules_for_delivery && $customer_state == 'LV' ) {
			 		//echo ' filter ';
			 		wc_cart_totals_shipping_html_plus_filter("free_shipping:8");
			 } else if ( $rules_for_delivery3 && $customer_state != 'LV' ) {
			 		//echo 'filter3';
			 		wc_cart_totals_shipping_html_plus_filter("flat_rate:11");
			 } else if ( $rules_for_delivery2 && $customer_state != 'LV' ) {
			 		//echo ' filter2 ';
			 		wc_cart_totals_shipping_html_plus_filter("flat_rate:10");
			 		//wc_cart_totals_shipping_html();
			 } else {
			 		//echo 'default';
			 		wc_cart_totals_shipping_html();
			 }

			 // end rules for delivery
			  ?> 

			<?php //wc_cart_totals_shipping_html(); ?>

			<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

		<?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>

			<tr class="shipping">
				<th><?php _e( 'Shipping', 'woocommerce' ); ?></th>
				<td data-title="<?php esc_attr_e( 'Shipping', 'woocommerce' ); ?>"><?php woocommerce_shipping_calculator(); ?></td>
			</tr>

		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<tr class="fee">
				<th><?php echo esc_html( $fee->name ); ?></th>
				<td data-title="<?php echo esc_attr( $fee->name ); ?>"><?php wc_cart_totals_fee_html( $fee ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( wc_tax_enabled() && 'excl' === WC()->cart->tax_display_cart ) :
			$taxable_address = WC()->customer->get_taxable_address();
			$estimated_text  = WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping()
					? sprintf( ' <small>(' . __( 'estimated for %s', 'woocommerce' ) . ')</small>', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] )
					: '';

			if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
					<tr class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
						<th><?php echo esc_html( $tax->label ) . $estimated_text; ?></th>
						<td data-title="<?php echo esc_attr( $tax->label ); ?>"><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr class="tax-total">
					<th><?php echo esc_html( WC()->countries->tax_or_vat() ) . $estimated_text; ?></th>
					<td data-title="<?php echo esc_attr( WC()->countries->tax_or_vat() ); ?>"><?php wc_cart_totals_taxes_total_html(); ?></td>
				</tr>
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

		<tr class="order-total">
			<th><?php _e( 'Total', 'woocommerce' ); ?></th>
			<td data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>"><?php wc_cart_totals_order_total_html(); ?></td>
		</tr>

		<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

	</table>

	<div class="wc-proceed-to-checkout">
		<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
	</div>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>
