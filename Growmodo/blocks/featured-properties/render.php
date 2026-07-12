<?php
/**
 * Featured Properties — dynamic grid over the real `property` CPT (not static
 * demo content), so Home always reflects the live catalog. Growmodo SOT:
 * Sections/Featured Properties.md, Modules/Property Card.md.
 *
 * @var array $attributes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading       = $attributes['heading'] ?? '';
$body          = $attributes['body'] ?? '';
$view_all      = $attributes['viewAllLabel'] ?? '';
$count         = isset( $attributes['count'] ) ? (int) $attributes['count'] : 3;

$query = new WP_Query(
	array(
		'post_type'      => 'property',
		'posts_per_page' => $count,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'no_found_rows'  => false,
	)
);

$total    = (int) $query->found_posts;
$wrapper_attributes = get_block_wrapper_attributes();
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
	<section class="section bg-surface">
		<div class="container-page">
			<div class="section-header mb-10">
				<div>
					<h2 class="h2"><?php echo esc_html( $heading ); ?></h2>
					<p class="lead mt-2 max-w-xl"><?php echo esc_html( $body ); ?></p>
				</div>
				<a class="btn-secondary shrink-0" href="<?php echo esc_url( get_post_type_archive_link( 'property' ) ); ?>"><?php echo esc_html( $view_all ); ?></a>
			</div>

			<?php if ( $query->have_posts() ) : ?>
				<div class="grid md:grid-cols-3 gap-6">
					<?php
					while ( $query->have_posts() ) :
						$query->the_post();
						$post_id     = get_the_ID();
						$price       = get_post_meta( $post_id, '_property_price', true );
						$bedrooms    = get_post_meta( $post_id, '_property_bedrooms', true );
						$bathrooms   = get_post_meta( $post_id, '_property_bathrooms', true );
						$types       = get_the_terms( $post_id, 'property_type' );
						$type_label  = ( $types && ! is_wp_error( $types ) ) ? $types[0]->name : '';
						?>
						<div class="card card-hover overflow-hidden">
							<?php if ( has_post_thumbnail() ) : ?>
								<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'medium_large', array( 'class' => 'w-full h-52 object-cover', 'alt' => get_the_title(), 'loading' => 'lazy' ) ); ?></a>
							<?php else : ?>
								<div class="w-full h-52 bg-surface-alt"></div>
							<?php endif; ?>
							<div class="p-6">
								<h3 class="h3"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<p class="lead text-sm mt-2 line-clamp-2"><?php echo esc_html( get_the_excerpt() ); ?></p>
								<div class="flex flex-wrap items-center gap-4 mt-4">
									<?php if ( $bedrooms ) : ?><span class="facts-pill"><?php echo growmodo_icon( 'bed.svg' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php echo esc_html( $bedrooms ); ?>-Bedroom</span><?php endif; ?>
									<?php if ( $bathrooms ) : ?><span class="facts-pill"><?php echo growmodo_icon( 'bath.svg' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php echo esc_html( $bathrooms ); ?>-Bathroom</span><?php endif; ?>
									<?php if ( $type_label ) : ?><span class="facts-pill"><?php echo growmodo_icon( 'villa-type.svg' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php echo esc_html( $type_label ); ?></span><?php endif; ?>
								</div>
								<div class="flex items-center justify-between gap-4 mt-6 pt-6 border-t border-surface-line">
									<div>
										<div class="text-ink text-xs"><?php esc_html_e( 'Price', 'growmodo' ); ?></div>
										<div class="text-heading font-semibold"><?php echo $price ? '$' . esc_html( number_format_i18n( (float) $price ) ) : esc_html__( 'Contact for price', 'growmodo' ); ?></div>
									</div>
									<a class="btn-primary" href="<?php the_permalink(); ?>"><?php esc_html_e( 'View Property Details', 'growmodo' ); ?></a>
								</div>
							</div>
						</div>
					<?php endwhile; ?>
				</div>
				<div class="pager">
					<span class="pager-count"><strong>01</strong> of <?php echo esc_html( $total ); ?></span>
				</div>
				<?php wp_reset_postdata(); ?>
			<?php else : ?>
				<div class="card p-10 text-center text-ink">
					<?php esc_html_e( 'No properties published yet — add your first one from Properties in wp-admin.', 'growmodo' ); ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
</div>
