<?php
/**
 * Shared handler for the site's 3 lead-capture forms (Contact Form,
 * Property Lead Form, Property Inquiry Form — cousins per the SOT, all built
 * from the same Form Field component but with different field sets). One
 * handler keyed by a hidden `form_source` field, rather than 3 near-identical
 * handlers — real functionality (wp_mail to the site admin) without a CRM.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function growmodo_handle_lead_form() {
	if ( ! isset( $_POST['growmodo_lead_nonce'] ) || ! wp_verify_nonce( $_POST['growmodo_lead_nonce'], 'growmodo_lead_form' ) ) {
		wp_die( esc_html__( 'Security check failed. Please go back and try again.', 'growmodo' ) );
	}

	$source  = isset( $_POST['form_source'] ) ? sanitize_text_field( wp_unslash( $_POST['form_source'] ) ) : 'Contact Form';
	$skip    = array( 'growmodo_lead_nonce', 'form_source', '_wp_http_referer', 'action' );
	$lines   = array();
	foreach ( $_POST as $key => $value ) {
		if ( in_array( $key, $skip, true ) ) {
			continue;
		}
		$label   = ucwords( str_replace( '_', ' ', sanitize_key( $key ) ) );
		$lines[] = sprintf( '%s: %s', $label, sanitize_text_field( wp_unslash( is_array( $value ) ? implode( ', ', $value ) : $value ) ) );
	}

	$to      = get_option( 'admin_email' );
	$subject = sprintf( '[%s] New lead — %s', get_bloginfo( 'name' ), $source );
	$body    = implode( "\n", $lines );

	wp_mail( $to, $subject, $body );

	$redirect = wp_get_referer() ? wp_get_referer() : home_url( '/' );
	wp_safe_redirect( add_query_arg( 'growmodo_sent', '1', $redirect ) . '#lead-form-sent' );
	exit;
}
add_action( 'admin_post_growmodo_lead_form', 'growmodo_handle_lead_form' );
add_action( 'admin_post_nopriv_growmodo_lead_form', 'growmodo_handle_lead_form' );

/**
 * Renders the "message sent" confirmation banner when ?growmodo_sent=1 is
 * present — called from each lead-form block's render.php.
 */
if ( ! function_exists( 'growmodo_lead_form_notice' ) ) {
	function growmodo_lead_form_notice() {
		if ( empty( $_GET['growmodo_sent'] ) ) {
			return;
		}
		?>
		<div id="lead-form-sent" class="card p-4 mb-6 border-accent/50 text-heading text-sm">
			<?php esc_html_e( 'Thanks — your message has been sent. Our team will be in touch shortly.', 'growmodo' ); ?>
		</div>
		<?php
	}
}
