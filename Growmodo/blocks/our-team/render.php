<?php
/**
 * Our Team — Growmodo SOT: Sections/Our Team.md, Modules/Team Card.md.
 *
 * @var array $attributes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading = $attributes['heading'] ?? '';
$body    = $attributes['body'] ?? '';
$members = ( isset( $attributes['members'] ) && is_array( $attributes['members'] ) ) ? $attributes['members'] : array();

$wrapper_attributes = get_block_wrapper_attributes();
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
	<section class="section bg-surface">
		<div class="container-page">
			<h2 class="h2"><?php echo esc_html( $heading ); ?></h2>
			<p class="lead mt-2 max-w-xl"><?php echo esc_html( $body ); ?></p>
			<?php if ( $members ) : ?>
				<div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-10">
					<?php foreach ( $members as $member ) : ?>
						<?php
						$photo_url = ! empty( $member['photoUrl'] )
							? $member['photoUrl']
							: ( ! empty( $member['photoFile'] ) ? get_template_directory_uri() . '/assets/img/' . $member['photoFile'] : '' );
						?>
						<div class="card p-6">
							<?php if ( $photo_url ) : ?>
								<img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $member['name'] ?? '' ); ?>" class="rounded-lg w-full h-[200px] md:h-[253px] object-cover mb-4" loading="lazy" />
							<?php else : ?>
								<div class="rounded-lg w-full h-[200px] md:h-[253px] bg-surface-alt mb-4"></div>
							<?php endif; ?>
							<div class="text-heading font-semibold"><?php echo esc_html( $member['name'] ?? '' ); ?></div>
							<div class="text-ink text-sm"><?php echo esc_html( $member['role'] ?? '' ); ?></div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
</div>
