<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
/**
* Page functions
*
* @author codeBOX
* @project lifterLMS
*/


/**
 * Get url for when user cancels payment
 * @return string [url to redirect user to on form post]
 */
function llms_cancel_payment_url() {

	$cancel_payment_url = esc_url( get_permalink( llms_get_page_id( 'checkout' ) ) );
	return apply_filters( 'lifterlms_checkout_confirm_payment_url', $cancel_payment_url );

}


/**
 * Get url for redirect when user confirms payment
 * @return string [url to redirect user to on form post]
 */
function llms_confirm_payment_url( $order_key = null ) {

	$confirm_payment_url = llms_get_endpoint_url( 'confirm-payment', '', get_permalink( llms_get_page_id( 'checkout' ) ) );

	$confirm_payment_url = add_query_arg( 'order', $order_key, $confirm_payment_url );

	return apply_filters( 'lifterlms_checkout_confirm_payment_url', $confirm_payment_url );

}


/**
 * Get endpoint URL
 *
 * @param string $page
 *
 * @return string
 */
function llms_get_endpoint_url( $endpoint, $value = '', $permalink = '' ) {
	if ( ! $permalink ) {
		$permalink = get_permalink(); }

	// Map endpoint to options
	$endpoint = isset( LLMS()->query->query_vars[ $endpoint ] ) ? LLMS()->query->query_vars[ $endpoint ] : $endpoint;

	if ( get_option( 'permalink_structure' ) ) {
		if ( strstr( $permalink, '?' ) ) {
			$query_string = '?' . parse_url( $permalink, PHP_URL_QUERY );
			$permalink    = current( explode( '?', $permalink ) );

		} else {
			$query_string = '';
		}
		$url = trailingslashit( $permalink ) . $endpoint . '/' . $value . $query_string;
	} else {
		$url = add_query_arg( $endpoint, $value, $permalink );
	}

	return apply_filters( 'lifterlms_get_endpoint_url', $url );
}


/**
 * Retrieve the WordPress Page ID of a LifterLMS Page
 * EG: 'checkout', 'memberships', etc...
 * @param  string $page name of the page
 * @return int
 */
function llms_get_page_id( $page ) {

	// normalize some pages to make more sense without having to migrate options
	if ( 'courses' === $page ) {
		$page = 'shop';
	}

	$page = apply_filters( 'lifterlms_get_' . $page . '_page_id', get_option( 'lifterlms_' . $page . '_page_id' ) );
	return $page ? absint( $page ) : -1;
}


/**
 * Retrive the URL for a LifterLMS Page
 * EG: 'checkout', 'memberships', etc...
 * @param  string $page name of the page
 * @param  array  $args optional array of query arguments that can be passed to add_query_arg()
 * @return string
 * @since  3.0.0
 */
function llms_get_page_url( $page, $args = array() ) {
	$url = add_query_arg( $args, get_permalink( llms_get_page_id( $page ) ) );
	return $url ? $url : '';
}


/**
 * Returns the url to the lost password endpoint url
 *
 * @param string $url
 *
 * @return string
 */
function llms_lostpassword_url() {
	return llms_get_endpoint_url( 'lost-password', '', get_permalink( llms_get_page_id( 'myaccount' ) ) );
}
add_filter( 'lostpassword_url',  'llms_lostpassword_url', 10, 0 );

