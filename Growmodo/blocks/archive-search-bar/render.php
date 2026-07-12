<?php
/**
 * Archive Search Bar — Growmodo SOT: Sections/Archive Search Bar.md,
 * Components/Filter Facet.md, Behaviors/Property Filter.md.
 *
 * Real functionality (user-confirmed decision): submits via GET to the
 * property archive URL; growmodo/archive-grid reads these same params and
 * builds a filtered WP_Query. Facets are exactly the 5 the export ships —
 * bedrooms/bathrooms are deliberately NOT filters here (see the SOT's Design
 * decision note on Properties Archive).
 *
 * @var array $attributes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading      = $attributes['heading'] ?? '';
$body         = $attributes['body'] ?? '';
$search_label = $attributes['searchLabel'] ?? '';
$find_label   = $attributes['findLabel'] ?? '';

$current_search   = isset( $_GET['s'] ) ? sanitize_text_field( wp_unslash( $_GET['s'] ) ) : '';
$current_location = isset( $_GET['location'] ) ? sanitize_text_field( wp_unslash( $_GET['location'] ) ) : '';
$current_type     = isset( $_GET['property_type'] ) ? sanitize_text_field( wp_unslash( $_GET['property_type'] ) ) : '';
$current_price    = isset( $_GET['price_range'] ) ? sanitize_text_field( wp_unslash( $_GET['price_range'] ) ) : '';
$current_size     = isset( $_GET['size_range'] ) ? sanitize_text_field( wp_unslash( $_GET['size_range'] ) ) : '';
$current_year     = isset( $_GET['build_year'] ) ? sanitize_text_field( wp_unslash( $_GET['build_year'] ) ) : '';

$locations = get_terms( array( 'taxonomy' => 'property_location', 'hide_empty' => false ) );
$types     = get_terms( array( 'taxonomy' => 'property_type', 'hide_empty' => false ) );

$price_buckets = array(
	''               => __( 'Any Price', 'growmodo' ),
	'0-300000'       => __( 'Under $300,000', 'growmodo' ),
	'300000-600000'  => __( '$300,000 – $600,000', 'growmodo' ),
	'600000-1000000' => __( '$600,000 – $1,000,000', 'growmodo' ),
	'1000000-'       => __( '$1,000,000+', 'growmodo' ),
);
$size_buckets = array(
	''          => __( 'Any Size', 'growmodo' ),
	'0-1000'    => __( 'Under 1,000 sq ft', 'growmodo' ),
	'1000-2000' => __( '1,000 – 2,000 sq ft', 'growmodo' ),
	'2000-3500' => __( '2,000 – 3,500 sq ft', 'growmodo' ),
	'3500-'     => __( '3,500+ sq ft', 'growmodo' ),
);
$year_buckets = array(
	''     => __( 'Any Year', 'growmodo' ),
	'2020' => __( '2020 or newer', 'growmodo' ),
	'2015' => __( '2015 or newer', 'growmodo' ),
	'2010' => __( '2010 or newer', 'growmodo' ),
	'2000' => __( '2000 or newer', 'growmodo' ),
);

$wrapper_attributes = get_block_wrapper_attributes();
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
	<section class="section bg-surface-alt">
		<div class="container-page">
			<h1 class="h-display"><?php echo esc_html( $heading ); ?></h1>
			<p class="lead mt-4 max-w-2xl"><?php echo esc_html( $body ); ?></p>

			<form method="get" action="<?php echo esc_url( get_post_type_archive_link( 'property' ) ); ?>" class="mt-8 rounded-lg overflow-hidden border border-surface-line shadow-glow">
				<div class="bg-surface p-4 flex flex-col sm:flex-row items-center gap-3">
					<label class="sr-only" for="archive-search"><?php echo esc_html( $search_label ); ?></label>
					<input class="field flex-1" type="text" id="archive-search" name="s" value="<?php echo esc_attr( $current_search ); ?>" placeholder="<?php echo esc_attr( $search_label ); ?>" />
					<button type="submit" class="btn-primary shrink-0 w-full sm:w-auto"><?php echo esc_html( $find_label ); ?></button>
				</div>
				<div class="bg-surface-alt p-4 flex flex-wrap gap-4">
					<select class="field-select text-sm" name="location">
						<option value=""><?php esc_html_e( 'Location', 'growmodo' ); ?></option>
						<?php foreach ( $locations as $term ) : ?>
							<option value="<?php echo esc_attr( $term->slug ); ?>" <?php selected( $current_location, $term->slug ); ?>><?php echo esc_html( $term->name ); ?></option>
						<?php endforeach; ?>
					</select>
					<select class="field-select text-sm" name="property_type">
						<option value=""><?php esc_html_e( 'Property Type', 'growmodo' ); ?></option>
						<?php foreach ( $types as $term ) : ?>
							<option value="<?php echo esc_attr( $term->slug ); ?>" <?php selected( $current_type, $term->slug ); ?>><?php echo esc_html( $term->name ); ?></option>
						<?php endforeach; ?>
					</select>
					<select class="field-select text-sm" name="price_range">
						<?php foreach ( $price_buckets as $value => $label ) : ?>
							<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $current_price, $value ); ?>><?php echo esc_html( $label ); ?></option>
						<?php endforeach; ?>
					</select>
					<select class="field-select text-sm" name="size_range">
						<?php foreach ( $size_buckets as $value => $label ) : ?>
							<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $current_size, $value ); ?>><?php echo esc_html( $label ); ?></option>
						<?php endforeach; ?>
					</select>
					<select class="field-select text-sm" name="build_year">
						<?php foreach ( $year_buckets as $value => $label ) : ?>
							<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $current_year, $value ); ?>><?php echo esc_html( $label ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</form>
		</div>
	</section>
</div>
