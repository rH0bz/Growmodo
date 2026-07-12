<?php
/**
 * Archive Grid — Growmodo SOT: Sections/Archive Grid.md, Modules/Archive
 * Property Card.md, Behaviors/Property Filter.md.
 *
 * The theme's one genuinely query-driven, filterable block (user-confirmed
 * decision): reads the same $_GET params that growmodo/archive-search-bar
 * submits and turns them into a real WP_Query tax_query/meta_query, with
 * real pagination (not the static "01 of N" pager used elsewhere on the
 * site — see Carousel Pager.md for why those stay static).
 *
 * @var array $attributes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading  = $attributes['heading'] ?? '';
$body     = $attributes['body'] ?? '';
$per_page = isset( $attributes['perPage'] ) ? (int) $attributes['perPage'] : 3;

$paged = max( 1, (int) get_query_var( 'paged' ) ?: ( isset( $_GET['paged'] ) ? (int) $_GET['paged'] : 1 ) );

$tax_query  = array();
$meta_query = array();

if ( ! empty( $_GET['location'] ) ) {
	$tax_query[] = array(
		'taxonomy' => 'property_location',
		'field'    => 'slug',
		'terms'    => sanitize_text_field( wp_unslash( $_GET['location'] ) ),
	);
}
if ( ! empty( $_GET['property_type'] ) ) {
	$tax_query[] = array(
		'taxonomy' => 'property_type',
		'field'    => 'slug',
		'terms'    => sanitize_text_field( wp_unslash( $_GET['property_type'] ) ),
	);
}
if ( ! empty( $_GET['price_range'] ) ) {
	list( $min, $max ) = array_pad( explode( '-', sanitize_text_field( wp_unslash( $_GET['price_range'] ) ) ), 2, '' );
	$compare = ( '' !== $min && '' !== $max ) ? 'BETWEEN' : ( '' !== $min ? '>=' : '<=' );
	$meta_query[] = array(
		'key'     => '_property_price',
		'value'   => ( 'BETWEEN' === $compare ) ? array( (float) $min, (float) $max ) : (float) ( '' !== $min ? $min : $max ),
		'type'    => 'NUMERIC',
		'compare' => $compare,
	);
}
if ( ! empty( $_GET['size_range'] ) ) {
	list( $min, $max ) = array_pad( explode( '-', sanitize_text_field( wp_unslash( $_GET['size_range'] ) ) ), 2, '' );
	$compare = ( '' !== $min && '' !== $max ) ? 'BETWEEN' : ( '' !== $min ? '>=' : '<=' );
	$meta_query[] = array(
		'key'     => '_property_area_sqft',
		'value'   => ( 'BETWEEN' === $compare ) ? array( (float) $min, (float) $max ) : (float) ( '' !== $min ? $min : $max ),
		'type'    => 'NUMERIC',
		'compare' => $compare,
	);
}
if ( ! empty( $_GET['build_year'] ) ) {
	$meta_query[] = array(
		'key'     => '_property_build_year',
		'value'   => (int) sanitize_text_field( wp_unslash( $_GET['build_year'] ) ),
		'type'    => 'NUMERIC',
		'compare' => '>=',
	);
}

$query_args = array(
	'post_type'      => 'property',
	'posts_per_page' => $per_page,
	'paged'          => $paged,
	'orderby'        => 'date',
	'order'          => 'DESC',
);
if ( ! empty( $_GET['s'] ) ) {
	$query_args['s'] = sanitize_text_field( wp_unslash( $_GET['s'] ) );
}
if ( $tax_query ) {
	$query_args['tax_query'] = $tax_query; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query -- intentional, user-facing filter.
}
if ( $meta_query ) {
	$query_args['meta_query'] = $meta_query; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query -- intentional, user-facing filter.
}

$query = new WP_Query( $query_args );

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
			</div>

			<?php if ( $query->have_posts() ) : ?>
				<div class="grid md:grid-cols-3 gap-6">
					<?php
					while ( $query->have_posts() ) :
						$query->the_post();
						$post_id   = get_the_ID();
						$price     = get_post_meta( $post_id, '_property_price', true );
						$locations = get_the_terms( $post_id, 'property_location' );
						$loc_label = ( $locations && ! is_wp_error( $locations ) ) ? $locations[0]->name : '';
						?>
						<div class="card card-hover overflow-hidden">
							<?php if ( has_post_thumbnail() ) : ?>
								<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'medium_large', array( 'class' => 'w-full h-52 object-cover', 'alt' => get_the_title(), 'loading' => 'lazy' ) ); ?></a>
							<?php else : ?>
								<div class="w-full h-52 bg-surface-alt"></div>
							<?php endif; ?>
							<div class="p-6">
								<?php if ( $loc_label ) : ?><div class="tagline"><?php echo esc_html( $loc_label ); ?></div><?php endif; ?>
								<h3 class="h3 mt-1"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<p class="lead text-sm mt-2 line-clamp-2"><?php echo esc_html( get_the_excerpt() ); ?></p>
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

				<?php if ( $query->max_num_pages > 1 ) : ?>
					<nav class="pager" aria-label="<?php esc_attr_e( 'Properties pagination', 'growmodo' ); ?>">
						<span class="pager-count"><strong><?php echo esc_html( $paged ); ?></strong> of <?php echo esc_html( $query->max_num_pages ); ?></span>
						<div class="flex gap-2">
							<?php if ( $paged > 1 ) : ?>
								<a class="btn-icon" href="<?php echo esc_url( add_query_arg( 'paged', $paged - 1 ) ); ?>" aria-label="<?php esc_attr_e( 'Previous page', 'growmodo' ); ?>"><?php echo growmodo_icon( 'pager-prev.svg', 'w-4 h-4' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
							<?php endif; ?>
							<?php if ( $paged < $query->max_num_pages ) : ?>
								<a class="btn-icon" href="<?php echo esc_url( add_query_arg( 'paged', $paged + 1 ) ); ?>" aria-label="<?php esc_attr_e( 'Next page', 'growmodo' ); ?>"><?php echo growmodo_icon( 'pager-next.svg', 'w-4 h-4' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
							<?php endif; ?>
						</div>
					</nav>
				<?php endif; ?>
				<?php wp_reset_postdata(); ?>
			<?php else : ?>
				<div class="card p-10 text-center text-ink">
					<?php esc_html_e( 'No properties match your filters — try widening your search.', 'growmodo' ); ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
</div>
