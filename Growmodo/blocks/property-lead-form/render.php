<?php
/**
 * Property Lead Form — Growmodo SOT: Sections/Property Lead Form.md. Cousin
 * of Contact Form / Property Inquiry Form (shared Form Field shell, different
 * field set); real submission via the shared inc/lead-form-handler.php.
 *
 * @var array $attributes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading      = $attributes['heading'] ?? '';
$body         = $attributes['body'] ?? '';
$submit_label = $attributes['submitLabel'] ?? '';

$wrapper_attributes = get_block_wrapper_attributes();
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
	<section class="section bg-surface">
		<div class="container-page max-w-3xl">
			<h2 class="h2"><?php echo esc_html( $heading ); ?></h2>
			<p class="lead mt-2"><?php echo esc_html( $body ); ?></p>

			<?php growmodo_lead_form_notice(); ?>

			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="mt-8">
				<input type="hidden" name="action" value="growmodo_lead_form" />
				<input type="hidden" name="form_source" value="Property Lead Form" />
				<?php wp_nonce_field( 'growmodo_lead_form', 'growmodo_lead_nonce' ); ?>

				<div class="grid md:grid-cols-4 gap-4">
					<div><label class="field-label" for="plf-fn"><?php esc_html_e( 'First Name', 'growmodo' ); ?></label><input class="field" type="text" id="plf-fn" name="first_name" required /></div>
					<div><label class="field-label" for="plf-ln"><?php esc_html_e( 'Last Name', 'growmodo' ); ?></label><input class="field" type="text" id="plf-ln" name="last_name" /></div>
					<div><label class="field-label" for="plf-email"><?php esc_html_e( 'Email', 'growmodo' ); ?></label><input class="field" type="email" id="plf-email" name="email" required /></div>
					<div><label class="field-label" for="plf-phone"><?php esc_html_e( 'Phone', 'growmodo' ); ?></label><input class="field" type="tel" id="plf-phone" name="phone" /></div>
					<div><label class="field-label" for="plf-loc"><?php esc_html_e( 'Preferred Location', 'growmodo' ); ?></label><input class="field" type="text" id="plf-loc" name="preferred_location" /></div>
					<div><label class="field-label" for="plf-type"><?php esc_html_e( 'Property Type', 'growmodo' ); ?></label><input class="field" type="text" id="plf-type" name="preferred_property_type" /></div>
					<div><label class="field-label" for="plf-bath"><?php esc_html_e( 'No. of Bathrooms', 'growmodo' ); ?></label><input class="field" type="number" id="plf-bath" name="preferred_bathrooms" min="0" /></div>
					<div><label class="field-label" for="plf-bed"><?php esc_html_e( 'No. of Bedrooms', 'growmodo' ); ?></label><input class="field" type="number" id="plf-bed" name="preferred_bedrooms" min="0" /></div>
					<div class="md:col-span-2"><label class="field-label" for="plf-budget"><?php esc_html_e( 'Budget', 'growmodo' ); ?></label><input class="field" type="text" id="plf-budget" name="budget" /></div>
					<div class="md:col-span-2">
						<span class="field-label"><?php esc_html_e( 'Preferred Contact Method', 'growmodo' ); ?></span>
						<div class="flex gap-4 text-ink text-sm">
							<label class="flex items-center gap-2"><input type="radio" name="preferred_contact_method" value="Phone" checked /><?php esc_html_e( 'Phone', 'growmodo' ); ?></label>
							<label class="flex items-center gap-2"><input type="radio" name="preferred_contact_method" value="Email" /><?php esc_html_e( 'Email', 'growmodo' ); ?></label>
						</div>
					</div>
				</div>
				<div class="mt-4">
					<label class="field-label" for="plf-message"><?php esc_html_e( 'Message', 'growmodo' ); ?></label>
					<textarea class="field" id="plf-message" name="message" rows="4" placeholder="<?php esc_attr_e( 'Enter your Message here..', 'growmodo' ); ?>"></textarea>
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
