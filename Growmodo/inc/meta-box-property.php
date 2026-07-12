<?php
/**
 * "Property Details" admin meta box for the `property` CPT — native fields,
 * no ACF/plugin dependency (user-confirmed decision, see
 * inc/post-type-property.php's header comment for the storage design).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function growmodo_add_property_meta_box() {
	add_meta_box(
		'growmodo_property_details',
		__( 'Property Details', 'growmodo' ),
		'growmodo_render_property_meta_box',
		'property',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'growmodo_add_property_meta_box' );

function growmodo_render_property_meta_box( $post ) {
	wp_nonce_field( 'growmodo_save_property_meta', 'growmodo_property_meta_nonce' );

	$price        = get_post_meta( $post->ID, '_property_price', true );
	$bedrooms     = get_post_meta( $post->ID, '_property_bedrooms', true );
	$bathrooms    = get_post_meta( $post->ID, '_property_bathrooms', true );
	$area_sqft    = get_post_meta( $post->ID, '_property_area_sqft', true );
	$build_year   = get_post_meta( $post->ID, '_property_build_year', true );
	$address      = get_post_meta( $post->ID, '_property_address', true );
	$key_features = get_post_meta( $post->ID, '_property_key_features', true );
	$fees         = get_post_meta( $post->ID, '_property_fees', true );
	$gallery_ids  = get_post_meta( $post->ID, '_property_gallery_ids', true );

	wp_enqueue_media();
	?>
	<style>
		.growmodo-meta-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; margin-bottom: 16px; }
		.growmodo-meta-grid label, .growmodo-meta-field label { display: block; font-weight: 600; margin-bottom: 4px; }
		.growmodo-meta-grid input, .growmodo-meta-field textarea, .growmodo-meta-field input[type="text"] { width: 100%; }
		.growmodo-meta-field { margin-bottom: 16px; }
		.growmodo-meta-field p.description { margin-top: 4px; }
		#growmodo-gallery-preview img { width: 80px; height: 60px; object-fit: cover; margin: 0 8px 8px 0; border: 1px solid #ccd0d4; border-radius: 4px; }
	</style>

	<div class="growmodo-meta-grid">
		<div>
			<label for="growmodo_price"><?php esc_html_e( 'Price (USD, numeric)', 'growmodo' ); ?></label>
			<input type="number" step="0.01" id="growmodo_price" name="growmodo_price" value="<?php echo esc_attr( $price ); ?>" />
		</div>
		<div>
			<label for="growmodo_build_year"><?php esc_html_e( 'Build Year', 'growmodo' ); ?></label>
			<input type="number" step="1" id="growmodo_build_year" name="growmodo_build_year" value="<?php echo esc_attr( $build_year ); ?>" />
		</div>
		<div>
			<label for="growmodo_bedrooms"><?php esc_html_e( 'Bedrooms', 'growmodo' ); ?></label>
			<input type="number" step="1" id="growmodo_bedrooms" name="growmodo_bedrooms" value="<?php echo esc_attr( $bedrooms ); ?>" />
		</div>
		<div>
			<label for="growmodo_bathrooms"><?php esc_html_e( 'Bathrooms', 'growmodo' ); ?></label>
			<input type="number" step="0.5" id="growmodo_bathrooms" name="growmodo_bathrooms" value="<?php echo esc_attr( $bathrooms ); ?>" />
		</div>
		<div>
			<label for="growmodo_area_sqft"><?php esc_html_e( 'Area (square feet)', 'growmodo' ); ?></label>
			<input type="number" step="1" id="growmodo_area_sqft" name="growmodo_area_sqft" value="<?php echo esc_attr( $area_sqft ); ?>" />
		</div>
		<div>
			<label for="growmodo_address"><?php esc_html_e( 'Address / location line', 'growmodo' ); ?></label>
			<input type="text" id="growmodo_address" name="growmodo_address" value="<?php echo esc_attr( $address ); ?>" placeholder="Malibu, California" />
		</div>
	</div>

	<div class="growmodo-meta-field">
		<label for="growmodo_key_features"><?php esc_html_e( 'Key Features and Amenities (one per line)', 'growmodo' ); ?></label>
		<textarea id="growmodo_key_features" name="growmodo_key_features" rows="6"><?php echo esc_textarea( $key_features ); ?></textarea>
	</div>

	<div class="growmodo-meta-field">
		<label for="growmodo_fees"><?php esc_html_e( 'Pricing Details — one line per fee: Group | Label | Amount | Note', 'growmodo' ); ?></label>
		<textarea id="growmodo_fees" name="growmodo_fees" rows="10" placeholder="Additional Fees | Property Transfer Tax | $25,000 | Based on the sale price and local regulations"><?php echo esc_textarea( $fees ); ?></textarea>
		<p class="description"><?php esc_html_e( 'Suggested groups (matches the reference build): Additional Fees, Monthly Costs, Total Initial Costs, Monthly Expenses.', 'growmodo' ); ?></p>
	</div>

	<div class="growmodo-meta-field">
		<label><?php esc_html_e( 'Gallery (in addition to the Primary Photo above)', 'growmodo' ); ?></label>
		<div id="growmodo-gallery-preview">
			<?php foreach ( growmodo_parse_property_gallery( $gallery_ids ) as $id ) : ?>
				<?php echo wp_get_attachment_image( $id, 'thumbnail' ); ?>
			<?php endforeach; ?>
		</div>
		<input type="hidden" id="growmodo_gallery_ids" name="growmodo_gallery_ids" value="<?php echo esc_attr( $gallery_ids ); ?>" />
		<button type="button" class="button" id="growmodo-gallery-select"><?php esc_html_e( 'Select Gallery Images', 'growmodo' ); ?></button>
		<button type="button" class="button" id="growmodo-gallery-clear"><?php esc_html_e( 'Clear', 'growmodo' ); ?></button>
	</div>

	<script>
	( function ( $ ) {
		var frame;
		$( '#growmodo-gallery-select' ).on( 'click', function ( e ) {
			e.preventDefault();
			if ( frame ) {
				frame.open();
				return;
			}
			frame = wp.media( {
				title: '<?php echo esc_js( __( 'Select Gallery Images', 'growmodo' ) ); ?>',
				button: { text: '<?php echo esc_js( __( 'Use these images', 'growmodo' ) ); ?>' },
				multiple: true,
			} );
			frame.on( 'select', function () {
				var selection = frame.state().get( 'selection' );
				var ids = [];
				var $preview = $( '#growmodo-gallery-preview' ).empty();
				selection.each( function ( attachment ) {
					attachment = attachment.toJSON();
					ids.push( attachment.id );
					var thumb = ( attachment.sizes && attachment.sizes.thumbnail ) ? attachment.sizes.thumbnail.url : attachment.url;
					$preview.append( '<img src="' + thumb + '" />' );
				} );
				$( '#growmodo_gallery_ids' ).val( ids.join( ',' ) );
			} );
			frame.open();
		} );
		$( '#growmodo-gallery-clear' ).on( 'click', function ( e ) {
			e.preventDefault();
			$( '#growmodo_gallery_ids' ).val( '' );
			$( '#growmodo-gallery-preview' ).empty();
		} );
	} )( jQuery );
	</script>
	<?php
}

function growmodo_save_property_meta( $post_id ) {
	if ( ! isset( $_POST['growmodo_property_meta_nonce'] ) || ! wp_verify_nonce( $_POST['growmodo_property_meta_nonce'], 'growmodo_save_property_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$number_fields = array(
		'growmodo_price'      => '_property_price',
		'growmodo_bedrooms'   => '_property_bedrooms',
		'growmodo_bathrooms'  => '_property_bathrooms',
		'growmodo_area_sqft'  => '_property_area_sqft',
		'growmodo_build_year' => '_property_build_year',
	);
	foreach ( $number_fields as $field => $meta_key ) {
		if ( isset( $_POST[ $field ] ) && '' !== $_POST[ $field ] ) {
			update_post_meta( $post_id, $meta_key, (float) $_POST[ $field ] );
		} else {
			delete_post_meta( $post_id, $meta_key );
		}
	}

	if ( isset( $_POST['growmodo_address'] ) ) {
		update_post_meta( $post_id, '_property_address', sanitize_text_field( wp_unslash( $_POST['growmodo_address'] ) ) );
	}
	if ( isset( $_POST['growmodo_key_features'] ) ) {
		update_post_meta( $post_id, '_property_key_features', sanitize_textarea_field( wp_unslash( $_POST['growmodo_key_features'] ) ) );
	}
	if ( isset( $_POST['growmodo_fees'] ) ) {
		update_post_meta( $post_id, '_property_fees', sanitize_textarea_field( wp_unslash( $_POST['growmodo_fees'] ) ) );
	}
	if ( isset( $_POST['growmodo_gallery_ids'] ) ) {
		$ids = array_filter( array_map( 'intval', explode( ',', $_POST['growmodo_gallery_ids'] ) ) );
		update_post_meta( $post_id, '_property_gallery_ids', implode( ',', $ids ) );
	}
}
add_action( 'save_post_property', 'growmodo_save_property_meta' );
