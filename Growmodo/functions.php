<?php
/**
 * Growmodo theme bootstrap.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'GROWMODO_VERSION', '1.0.0' );
define( 'GROWMODO_DIR', get_template_directory() );
define( 'GROWMODO_URI', get_template_directory_uri() );

/**
 * Theme supports.
 */
function growmodo_setup() {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'responsive-embeds' );
	add_editor_style( 'build/editor.css' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
}
add_action( 'after_setup_theme', 'growmodo_setup' );

/**
 * Google Fonts (Urbanist — the real typeface used in the SOT, no substitution
 * needed) + Material Symbols Outlined for icons (the export ships one-off SVGs
 * per icon; an icon font is the build-time substitute — see Icon.md).
 * Shared by the frontend AND the editor canvas — without this in the editor,
 * headings fall back to system fonts and icons render as literal text.
 */
function growmodo_enqueue_fonts() {
	$fonts_url = 'https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700&display=swap';
	wp_enqueue_style( 'growmodo-google-fonts', $fonts_url, array(), null );

	$symbols_url = 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=block';
	wp_enqueue_style( 'growmodo-material-symbols', $symbols_url, array(), null );
}

/**
 * Frontend asset enqueue (built by @wordpress/scripts into /build/).
 */
function growmodo_enqueue_assets() {
	growmodo_enqueue_fonts();

	$frontend_css = GROWMODO_DIR . '/build/frontend.css';
	if ( file_exists( $frontend_css ) ) {
		wp_enqueue_style( 'growmodo-frontend', GROWMODO_URI . '/build/frontend.css', array(), filemtime( $frontend_css ) );
	}

	$frontend_js = GROWMODO_DIR . '/assets/js/frontend.js';
	if ( file_exists( $frontend_js ) ) {
		wp_enqueue_script( 'growmodo-frontend', GROWMODO_URI . '/assets/js/frontend.js', array(), filemtime( $frontend_js ), true );
	}
}
add_action( 'wp_enqueue_scripts', 'growmodo_enqueue_assets' );

/**
 * Editor canvas fonts. The editor stylesheet itself is registered via
 * add_editor_style() in growmodo_setup() — WordPress inlines that automatically
 * into the iframe, so it isn't re-enqueued here.
 */
function growmodo_enqueue_editor_assets() {
	growmodo_enqueue_fonts();
	// Exposes the theme's asset base URL to block editor JS (e.g. the Hero
	// block's bundled feature/badge icons) — render.php resolves the same
	// path server-side via get_template_directory_uri(), but edit.js has no
	// PHP equivalent, so it needs this global. Attached to 'wp-blocks', a
	// core handle always loaded in the block editor.
	wp_add_inline_script( 'wp-blocks', 'window.growmodoThemeUri = ' . wp_json_encode( GROWMODO_URI ) . ';', 'before' );
}
add_action( 'enqueue_block_editor_assets', 'growmodo_enqueue_editor_assets' );

/**
 * Register the custom block category so all Growmodo blocks group together in the inserter.
 */
function growmodo_block_category( $categories ) {
	return array_merge(
		array(
			array(
				'slug'  => 'growmodo-blocks',
				'title' => __( 'Growmodo Blocks', 'growmodo' ),
				'icon'  => 'block-default',
			),
		),
		$categories
	);
}
add_filter( 'block_categories_all', 'growmodo_block_category' );

/**
 * Auto-register every block found under /blocks/*.
 * Each block folder is a self-contained dynamic block: block.json + render.php.
 */
function growmodo_register_blocks() {
	$block_dirs = glob( GROWMODO_DIR . '/blocks/*', GLOB_ONLYDIR );
	if ( ! $block_dirs ) {
		return;
	}
	foreach ( $block_dirs as $block_dir ) {
		if ( file_exists( $block_dir . '/block.json' ) ) {
			register_block_type( $block_dir );
		}
	}
}
add_action( 'init', 'growmodo_register_blocks' );

/**
 * Best-effort intrinsic width/height for a theme-local image URL, used to set
 * <img width>/<img height> so the browser can reserve space before the image
 * loads (Core Web Vitals / CLS — SEO Technical Standards). Only resolves URLs
 * that live inside this theme; returns null when unresolvable so callers omit
 * the attributes rather than guess.
 */
function growmodo_image_size( $url ) {
	if ( ! $url || 0 !== strpos( $url, GROWMODO_URI ) ) {
		return null;
	}
	$path = GROWMODO_DIR . substr( $url, strlen( GROWMODO_URI ) );
	if ( ! file_exists( $path ) ) {
		return null;
	}
	$size = @getimagesize( $path ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged -- best-effort, falls back to null.
	if ( ! $size ) {
		return null;
	}
	return array(
		'width'  => $size[0],
		'height' => $size[1],
	);
}

/**
 * Echoes ready-to-use width="" height="" attributes for an <img>, or nothing
 * if the size couldn't be resolved (see growmodo_image_size()).
 */
function growmodo_image_dims_attr( $url ) {
	$size = growmodo_image_size( $url );
	if ( ! $size ) {
		return '';
	}
	return sprintf( ' width="%d" height="%d"', (int) $size['width'], (int) $size['height'] );
}

/**
 * Renders one <span> per character, evenly rotated around a circle. Backs the
 * Hero block's floating badge (Sections/Hero.md: the source export spells the
 * badge text out as 30 individually rotated letter-spans at fixed pixel
 * coordinates — reproduced generically here via even angular spacing rather
 * than copying fixed coordinates, so it stays correct if the text is edited).
 */
function growmodo_circular_text( $text, $radius = 58 ) {
	$chars = preg_split( '//u', trim( $text ), -1, PREG_SPLIT_NO_EMPTY );
	$total = $chars ? count( $chars ) : 0;
	if ( ! $total ) {
		return '';
	}
	$out = '';
	foreach ( $chars as $i => $char ) {
		$angle = ( $i / $total ) * 360;
		$out  .= sprintf(
			'<span class="hero-badge-char" style="transform: rotate(%.2fdeg) translate(0, -%dpx);">%s</span>',
			$angle,
			(int) $radius,
			esc_html( $char )
		);
	}
	return $out;
}

/**
 * Echoes a real bundled SVG icon (from assets/icons/) as an <img> — the
 * replacement for the ligature-icon-font pattern (`<span class="icon-inline">
 * word</span>`) wherever the raw export ships a real source icon to trace to.
 * `$file` is a filename only (no path); pass '' to render nothing (callers
 * decide whether an empty icon is acceptable for that spot).
 */
function growmodo_icon( $file, $class = 'w-4 h-4' ) {
	if ( ! $file ) {
		return '';
	}
	return sprintf(
		'<img src="%s" alt="" class="%s" />',
		esc_url( get_template_directory_uri() . '/assets/icons/' . $file ),
		esc_attr( $class )
	);
}

/**
 * Baseline meta output (no SEO plugin assumed) — SEO Technical Standards.
 * Guarded so it never fights a real SEO plugin if one is later activated.
 */
function growmodo_meta_tags() {
	if ( function_exists( 'wp_get_seo_title' ) || defined( 'WPSEO_VERSION' ) || class_exists( 'RankMath' ) ) {
		return; // A real SEO plugin is active — never emit duplicate tags.
	}
	$desc = wp_strip_all_tags( get_the_excerpt() ?: get_bloginfo( 'description' ) );
	if ( $desc ) {
		printf( '<meta name="description" content="%s" />' . "\n", esc_attr( $desc ) );
		printf( '<meta property="og:title" content="%s" />' . "\n", esc_attr( get_the_title() ?: get_bloginfo( 'name' ) ) );
		printf( '<meta property="og:description" content="%s" />' . "\n", esc_attr( $desc ) );
		printf( '<meta name="twitter:card" content="summary_large_image" />' . "\n" );
	}
}
add_action( 'wp_head', 'growmodo_meta_tags', 1 );

/**
 * The `property` custom post type — this theme's first CPT precedent in the
 * codebase. Split into inc/ for readability given the field/meta-box surface
 * area (registration, taxonomies, post meta, admin meta box + repeaters).
 */
require GROWMODO_DIR . '/inc/post-type-property.php';
require GROWMODO_DIR . '/inc/meta-box-property.php';
require GROWMODO_DIR . '/inc/lead-form-handler.php';
