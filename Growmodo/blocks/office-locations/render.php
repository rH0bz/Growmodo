<?php
/**
 * Office Locations — Growmodo SOT: Sections/Office Locations.md,
 * Modules/Office Card.md, Behaviors/Office Tabs.md (static in the export).
 *
 * @var array $attributes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading = $attributes['heading'] ?? '';
$body    = $attributes['body'] ?? '';
$tabs    = ( isset( $attributes['tabs'] ) && is_array( $attributes['tabs'] ) ) ? $attributes['tabs'] : array();
$offices = ( isset( $attributes['offices'] ) && is_array( $attributes['offices'] ) ) ? $attributes['offices'] : array();

$wrapper_attributes = get_block_wrapper_attributes();
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
	<section class="section bg-surface">
		<div class="container-page">
			<h2 class="h2"><?php echo esc_html( $heading ); ?></h2>
			<p class="lead mt-2 max-w-xl"><?php echo esc_html( $body ); ?></p>

			<?php if ( $tabs ) : ?>
				<div class="flex gap-2 mt-6" role="tablist" aria-label="<?php esc_attr_e( 'Office regions', 'growmodo' ); ?>">
					<?php foreach ( $tabs as $i => $tab ) : ?>
						<span role="tab" aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>" class="<?php echo 0 === $i ? 'btn-primary text-sm' : 'btn-secondary text-sm'; ?>"><?php echo esc_html( $tab ); ?></span>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php if ( $offices ) : ?>
				<div class="grid md:grid-cols-2 gap-6 mt-6">
					<?php foreach ( $offices as $office ) : ?>
						<div class="card p-8">
							<div class="text-ink text-sm"><?php echo esc_html( $office['label'] ?? '' ); ?></div>
							<h3 class="h3 !text-lg mt-1"><?php echo esc_html( $office['address'] ?? '' ); ?></h3>
							<p class="lead text-sm mt-2"><?php echo esc_html( $office['body'] ?? '' ); ?></p>
							<div class="flex flex-wrap gap-4 mt-4 pt-4 border-t border-surface-line text-sm">
								<span class="facts-pill"><?php echo growmodo_icon( 'office-mail.svg' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php echo esc_html( $office['email'] ?? '' ); ?></span>
								<span class="facts-pill"><?php echo growmodo_icon( 'office-phone.svg' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php echo esc_html( $office['phone'] ?? '' ); ?></span>
								<span class="facts-pill"><?php echo growmodo_icon( 'office-location.svg' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php echo esc_html( $office['city'] ?? '' ); ?></span>
							</div>
							<span class="btn-secondary text-sm mt-4 inline-flex"><?php esc_html_e( 'Get Direction', 'growmodo' ); ?></span>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
</div>
