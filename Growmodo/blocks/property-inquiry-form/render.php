<?php
/**
 * Property Inquiry Form — Growmodo SOT: Sections/Property Inquiry Form.md.
 * Pre-fills "Selected Property" from the current post (title + address);
 * real submission via the shared inc/lead-form-handler.php.
 *
 * @var array $attributes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$submit_label = $attributes['submitLabel'] ?? '';

$post_id       = get_the_ID();
$address       = get_post_meta( $post_id, '_property_address', true );
$property_name = get_the_title();
$selected      = $address ? sprintf( '%s, %s', $property_name, $address ) : $property_name;

$wrapper_attributes = get_block_wrapper_attributes();
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
	<section class="section bg-surface">
		<div class="container-page max-w-3xl">
			<h2 class="h2">
				<?php
				printf(
					/* translators: %s: property title */
					esc_html__( 'Inquire About %s', 'growmodo' ),
					esc_html( $property_name )
				);
				?>
			</h2>
			<p class="lead mt-2"><?php esc_html_e( 'Interested in this property? Fill out the form below, and our real estate experts will get back to you with more details, including scheduling a viewing and answering any questions you may have.', 'growmodo' ); ?></p>

			<?php growmodo_lead_form_notice(); ?>

			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="mt-8">
				<input type="hidden" name="action" value="growmodo_lead_form" />
				<input type="hidden" name="form_source" value="Property Inquiry Form" />
				<input type="hidden" name="property_id" value="<?php echo esc_attr( $post_id ); ?>" />
				<?php wp_nonce_field( 'growmodo_lead_form', 'growmodo_lead_nonce' ); ?>

				<div class="grid md:grid-cols-2 gap-4">
					<div><label class="field-label" for="pif-fn"><?php esc_html_e( 'First Name', 'growmodo' ); ?></label><input class="field" type="text" id="pif-fn" name="first_name" required /></div>
					<div><label class="field-label" for="pif-ln"><?php esc_html_e( 'Last Name', 'growmodo' ); ?></label><input class="field" type="text" id="pif-ln" name="last_name" /></div>
					<div><label class="field-label" for="pif-email"><?php esc_html_e( 'Email', 'growmodo' ); ?></label><input class="field" type="email" id="pif-email" name="email" required /></div>
					<div><label class="field-label" for="pif-phone"><?php esc_html_e( 'Phone', 'growmodo' ); ?></label><input class="field" type="tel" id="pif-phone" name="phone" /></div>
				</div>
				<div class="mt-4">
					<label class="field-label" for="pif-selected"><?php esc_html_e( 'Selected Property', 'growmodo' ); ?></label>
					<input class="field bg-surface-alt" type="text" id="pif-selected" name="selected_property" value="<?php echo esc_attr( $selected ); ?>" readonly />
				</div>
				<div class="mt-4">
					<label class="field-label" for="pif-message"><?php esc_html_e( 'Message', 'growmodo' ); ?></label>
					<textarea class="field" id="pif-message" name="message" rows="4" placeholder="<?php esc_attr_e( 'Enter your Message here..', 'growmodo' ); ?>"></textarea>
				</div>
				<div class="flex items-center justify-between flex-wrap gap-4 mt-6">
					<label class="flex items-center gap-2 text-ink text-sm">
						<input type="checkbox" required />
						<?php esc_html_e( 'I agree with Terms of Use and Privacy Policy', 'growmodo' ); ?>
					</label>
					<button type="submit" class="btn-primary"><?php echo esc_html( $submit_label ); ?></button>
				</div>
			</form>
		</div>
	</section>
</div>
