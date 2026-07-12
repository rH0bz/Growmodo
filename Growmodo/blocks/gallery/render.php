<?php
/**
 * Gallery — Growmodo SOT: Sections/Gallery.md. The only section on Contact
 * with its own bordered panel frame around the whole band.
 *
 * @var array $attributes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading    = $attributes['heading'] ?? '';
$body       = $attributes['body'] ?? '';
$images     = ( isset( $attributes['images'] ) && is_array( $attributes['images'] ) ) ? $attributes['images'] : array();
$large_url  = ! empty( $attributes['largeImageUrl'] ) ? $attributes['largeImageUrl'] : get_template_directory_uri() . '/assets/img/gallery-feature.png';
$large_alt  = $attributes['largeImageAlt'] ?? '';

$wrapper_attributes = get_block_wrapper_attributes();
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
	<section class="section bg-surface">
		<div class="container-page">
			<div class="panel relative overflow-hidden p-6 md:p-12 grid md:grid-cols-2 gap-8 items-center">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/icons/gallery-ring.svg' ); ?>" alt="" class="hidden lg:block absolute inset-0 w-full h-full object-cover opacity-30 -z-10 pointer-events-none" aria-hidden="true" />
				<div class="grid grid-cols-2 gap-3">
					<?php
					foreach ( $images as $img ) :
						$img_url = ! empty( $img['url'] )
							? $img['url']
							: ( ! empty( $img['file'] ) ? get_template_directory_uri() . '/assets/img/' . $img['file'] : '' );
						if ( $img_url ) :
							?>
							<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $img['alt'] ?? '' ); ?>" class="rounded w-full h-40 md:h-52 object-cover"<?php echo growmodo_image_dims_attr( $img_url ); // phpcs:ignore WordPress.Security.EscapeOutput ?> loading="lazy" />
							<?php
						else :
							?>
							<div class="rounded w-full h-40 md:h-52 bg-surface-alt"></div>
							<?php
						endif;
					endforeach;
					?>
				</div>
				<div>
					<h2 class="h2"><?php echo esc_html( $heading ); ?></h2>
					<p class="lead mt-2"><?php echo esc_html( $body ); ?></p>
					<img src="<?php echo esc_url( $large_url ); ?>" alt="<?php echo esc_attr( $large_alt ); ?>" class="rounded-lg w-full h-[280px] object-cover mt-6"<?php echo growmodo_image_dims_attr( $large_url ); // phpcs:ignore WordPress.Security.EscapeOutput ?> loading="lazy" />
				</div>
			</div>
		</div>
	</section>
</div>
