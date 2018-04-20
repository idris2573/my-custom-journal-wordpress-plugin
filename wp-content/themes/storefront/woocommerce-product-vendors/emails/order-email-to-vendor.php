<?php
/**
 * Order email to vendor.
 *
 * @version 2.1.0
 * @since 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( version_compare( WC_VERSION, '3.0.0', '>=' ) ) {
	$order_date = $order->get_date_created();
} else {
	$order_date = $order->order_date;
}
?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<p><?php echo 'You have received an order'; ?></p>

<h2><?php printf( esc_html__( 'Order #%s', 'woocommerce-product-vendors' ), $order->get_order_number() ); ?> (<?php printf( '<time datetime="%s">%s</time>', date_i18n( 'c', strtotime( $order_date ) ), date_i18n( wc_date_format(), strtotime( $order_date ) ) ); ?>)</h2>

<?php $email->render_order_details_table( $order, $sent_to_admin, $plain_text, $email, $this_vendor ); ?>

<?php do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email ); ?>

<?php do_action( 'wc_product_vendors_email_order_meta', $order, $sent_to_admin, $plain_text, $email ); ?>

<?php do_action( 'woocommerce_email_footer', $email ); ?>
