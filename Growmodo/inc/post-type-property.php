<?php
/**
 * The `property` custom post type + its two taxonomies + scalar post meta.
 *
 * First CPT precedent in this codebase (see LLM wiki > wiki/playbooks/
 * "Build a WordPress Custom Block Theme.md" > Resolved on the reference
 * builds). Field set is derived directly from the Growmodo SOT's
 * `Property Single` template note (Architecture Wiki > Sites/Growmodo).
 *
 * Storage decision (user-confirmed, no ACF/plugin dependency):
 * - Scalar facts (price, bedrooms, bathrooms, area, build year, address) are
 *   individually `register_post_meta()`'d with sanitize callbacks.
 * - Property Type / Location are taxonomies (they're the archive's real
 *   filter facets — see `Properties Archive` SOT note) rather than meta, so
 *   `tax_query` can filter them natively.
 * - Key Features is a newline-delimited text meta (one feature per line) —
 *   deliberately not a JS repeater; a textarea is the simplest native-fields
 *   pattern that still captures a real list.
 * - The Fee Breakdown (~13 line items across 4 named groups, per `Property
 *   Pricing`) is a single structured text meta using one line per item:
 *   `Group | Label | Amount | Note` — parsed at render time. This avoids
 *   building a bespoke JS repeater UI for a field this deep while keeping it
 *   genuinely structured (not a single opaque blob).
 * - Gallery is a comma-separated list of attachment IDs, edited via the
 *   standard `wp.media` uploader (see inc/meta-box-property.php).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function growmodo_register_property_cpt() {
	register_post_type(
		'property',
		array(
			'labels'       => array(
				'name'               => __( 'Properties', 'growmodo' ),
				'singular_name'      => __( 'Property', 'growmodo' ),
				'add_new_item'       => __( 'Add New Property', 'growmodo' ),
				'edit_item'          => __( 'Edit Property', 'growmodo' ),
				'all_items'          => __( 'Properties', 'growmodo' ),
				'archives'           => __( 'Property Archives', 'growmodo' ),
				'search_items'       => __( 'Search Properties', 'growmodo' ),
				'not_found'          => __( 'No properties found', 'growmodo' ),
				'featured_image'     => __( 'Primary Photo', 'growmodo' ),
				'set_featured_image' => __( 'Set primary photo', 'growmodo' ),
			),
			'public'       => true,
			'show_in_rest' => true,
			'has_archive'  => true,
			'rewrite'      => array( 'slug' => 'properties', 'with_front' => false ),
			'menu_icon'    => 'dashicons-admin-home',
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'show_in_menu' => true,
			'menu_position' => 20,
		)
	);
}
add_action( 'init', 'growmodo_register_property_cpt' );

function growmodo_register_property_taxonomies() {
	// Property Type (Villa, Apartment, Cottage, ...) — non-hierarchical, tag-style.
	register_taxonomy(
		'property_type',
		'property',
		array(
			'labels'            => array(
				'name'          => __( 'Property Types', 'growmodo' ),
				'singular_name' => __( 'Property Type', 'growmodo' ),
			),
			'public'            => true,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'rewrite'           => array( 'slug' => 'property-type' ),
			'show_admin_column' => true,
		)
	);

	// Location (Malibu / California, ...) — non-hierarchical; drives the
	// archive's "Location" filter facet.
	register_taxonomy(
		'property_location',
		'property',
		array(
			'labels'            => array(
				'name'          => __( 'Locations', 'growmodo' ),
				'singular_name' => __( 'Location', 'growmodo' ),
			),
			'public'            => true,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'rewrite'           => array( 'slug' => 'property-location' ),
			'show_admin_column' => true,
		)
	);
}
add_action( 'init', 'growmodo_register_property_taxonomies' );

/**
 * Scalar post meta. Registered (not just used ad hoc) so the field set is
 * discoverable/self-documenting and each value is sanitized consistently.
 */
function growmodo_register_property_meta() {
	$string_field = array(
		'single'       => true,
		'type'         => 'string',
		'show_in_rest' => false,
		'sanitize_callback' => 'sanitize_text_field',
	);
	$number_field = array(
		'single'       => true,
		'type'         => 'number',
		'show_in_rest' => false,
	);

	register_post_meta( 'property', '_property_price', $number_field );
	register_post_meta( 'property', '_property_bedrooms', $number_field );
	register_post_meta( 'property', '_property_bathrooms', $number_field );
	register_post_meta( 'property', '_property_area_sqft', $number_field );
	register_post_meta( 'property', '_property_build_year', $number_field );
	register_post_meta( 'property', '_property_address', $string_field );

	// Newline-delimited list (Key Features and Amenities).
	register_post_meta(
		'property',
		'_property_key_features',
		array(
			'single'       => true,
			'type'         => 'string',
			'show_in_rest' => false,
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);

	// "Group | Label | Amount | Note" per line (Comprehensive Pricing Details).
	register_post_meta(
		'property',
		'_property_fees',
		array(
			'single'       => true,
			'type'         => 'string',
			'show_in_rest' => false,
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);

	// Comma-separated attachment IDs (Image Gallery, beyond the featured image).
	register_post_meta(
		'property',
		'_property_gallery_ids',
		array(
			'single'       => true,
			'type'         => 'string',
			'show_in_rest' => false,
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
}
add_action( 'init', 'growmodo_register_property_meta' );

/**
 * Parses the "Group | Label | Amount | Note" fee-breakdown text meta into a
 * grouped array: [ 'Additional Fees' => [ ['label'=>..,'amount'=>..,'note'=>..], ... ], ... ].
 * Blank/malformed lines are skipped rather than fatally erroring — admin-entered
 * content can't be trusted to always be well-formed.
 */
if ( ! function_exists( 'growmodo_parse_property_fees' ) ) {
	function growmodo_parse_property_fees( $raw ) {
		$groups = array();
		if ( ! $raw ) {
			return $groups;
		}
		foreach ( preg_split( '/\r\n|\r|\n/', $raw ) as $line ) {
			$line = trim( $line );
			if ( '' === $line ) {
				continue;
			}
			$parts = array_map( 'trim', explode( '|', $line ) );
			if ( count( $parts ) < 3 ) {
				continue;
			}
			list( $group, $label, $amount ) = array( $parts[0], $parts[1], $parts[2] );
			$note = $parts[3] ?? '';
			if ( ! isset( $groups[ $group ] ) ) {
				$groups[ $group ] = array();
			}
			$groups[ $group ][] = array(
				'label'  => $label,
				'amount' => $amount,
				'note'   => $note,
			);
		}
		return $groups;
	}
}

/**
 * Splits the newline-delimited Key Features meta into a clean array.
 */
if ( ! function_exists( 'growmodo_parse_property_features' ) ) {
	function growmodo_parse_property_features( $raw ) {
		if ( ! $raw ) {
			return array();
		}
		$lines = preg_split( '/\r\n|\r|\n/', $raw );
		$lines = array_map( 'trim', $lines );
		return array_values( array_filter( $lines ) );
	}
}

/**
 * Splits the comma-separated gallery attachment-ID meta into a clean int array.
 */
if ( ! function_exists( 'growmodo_parse_property_gallery' ) ) {
	function growmodo_parse_property_gallery( $raw ) {
		if ( ! $raw ) {
			return array();
		}
		$ids = array_map( 'trim', explode( ',', $raw ) );
		$ids = array_filter( $ids, 'is_numeric' );
		return array_values( array_map( 'intval', $ids ) );
	}
}
