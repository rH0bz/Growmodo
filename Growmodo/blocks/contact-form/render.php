<?php
/**
 * Contact Form — Growmodo SOT: Sections/Contact Form.md. A real lead form:
 * posts to admin-post.php (inc/lead-form-handler.php), no JS framework.
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
				<input type="hidden" name="form_source" value="Contact Form" />
				<?php wp_nonce_field( 'growmodo_lead_form', 'growmodo_lead_nonce' ); ?>

				<div class="grid md:grid-cols-3 gap-4">
					<div>
						<label class="field-label" for="cf-first-name"><?php esc_html_e( 'First Name', 'growmodo' ); ?></label>
						<input class="field" type="text" id="cf-first-name" name="first_name" placeholder="<?php esc_attr_e( 'Enter First Name', 'growmodo' ); ?>" required />
					</div>
					<div>
						<label class="field-label" for="cf-last-name"><?php esc_html_e( 'Last Name', 'growmodo' ); ?></label>
						<input class="field" type="text" id="cf-last-name" name="last_name" placeholder="<?php esc_attr_e( 'Enter Last Name', 'growmodo' ); ?>" />
					</div>
					<div>
						<label class="field-label" for="cf-email"><?php esc_html_e( 'Email', 'growmodo' ); ?></label>
						<input class="field" type="email" id="cf-email" name="email" placeholder="<?php esc_attr_e( 'Enter your Email', 'growmodo' ); ?>" required />
					</div>
					<div>
						<label class="field-label" for="cf-phone"><?php esc_html_e( 'Phone', 'growmodo' ); ?></label>
						<input class="field" type="tel" id="cf-phone" name="phone" placeholder="<?php esc_attr_e( 'Enter Phone Number', 'growmodo' ); ?>" />
					</div>
					<div>
						<label class="field-label" for="cf-inquiry-type"><?php esc_html_e( 'Inquiry Type', 'growmodo' ); ?></label>
						<select class="field" id="cf-inquiry-type" name="inquiry_type">
							<option value=""><?php esc_html_e( 'Select Inquiry Type', 'growmodo' ); ?></option>
							<option><?php esc_html_e( 'Buying', 'growmodo' ); ?></option>
							<option><?php esc_html_e( 'Selling', 'growmodo' ); ?></option>
							<option><?php esc_html_e( 'General', 'growmodo' ); ?></option>
						</select>
					</div>
					<div>
						<label class="field-label" for="cf-referral"><?php esc_html_e( 'How Did You Hear About Us?', 'growmodo' ); ?></label>
						<select class="field" id="cf-referral" name="referral_source">
							<option value=""><?php esc_html_e( 'Select', 'growmodo' ); ?></option>
							<option><?php esc_html_e( 'Search Engine', 'growmodo' ); ?></option>
							<option><?php esc_html_e( 'Social Media', 'growmodo' ); ?></option>
							<option><?php esc_html_e( 'Referral', 'growmodo' ); ?></option>
						</select>
					</div>
				</div>
				<div class="mt-4">
					<label class="field-label" for="cf-message"><?php esc_html_e( 'Message', 'growmodo' ); ?></label>
					<textarea class="field" id="cf-message" name="message" rows="4" placeholder="<?php esc_attr_e( 'Enter your Message here..', 'growmodo' ); ?>"></textarea>
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
