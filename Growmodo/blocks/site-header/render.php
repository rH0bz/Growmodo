<?php
/**
 * Site Header — global template-part block (Growmodo).
 * Reused verbatim on every template; the ACTIVE nav item is resolved from
 * page context at render time (never a stored attribute).
 *
 * Mobile navigation: hamburger -> off-canvas panel + backdrop, per the
 * standardized pattern (LLM wiki > FSE Global Sections).
 *
 * @var array $attributes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$brand       = $attributes['brand'] ?? 'Estatein';
$banner_text = $attributes['bannerText'] ?? '';
$banner_cta  = $attributes['bannerCta'] ?? 'Learn More';
$nav_items   = ( isset( $attributes['navItems'] ) && is_array( $attributes['navItems'] ) ) ? $attributes['navItems'] : array();
$cta_label   = $attributes['ctaLabel'] ?? 'Contact Us';
$cta_url     = $attributes['ctaUrl'] ?? '/contact/';

$current_path = isset( $_SERVER['REQUEST_URI'] ) ? trim( wp_parse_url( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ), PHP_URL_PATH ), '/' ) : '';
$is_archive   = is_post_type_archive( 'property' ) || is_singular( 'property' );

$wrapper_attributes = get_block_wrapper_attributes();
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
	<a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-2 focus:left-2 focus:z-[200] focus:rounded focus:bg-accent focus:text-on-dark focus:px-4 focus:py-2 focus:text-sm">
		<?php esc_html_e( 'Skip to content', 'growmodo' ); ?>
	</a>
	<header class="w-full sticky top-0 z-[100] overflow-hidden">
		<?php /* Announcement banner (SOT: Header .banner) — bg grey-10, bottom hairline, plus the
		export's decorative line-art background (group0.svg, mix-blend-mode: color-dodge),
		clipped to the banner strip the same way .header's own overflow:hidden clips it in the
		source (the graphic's native box is far taller than the banner). */ ?>
		<div class="relative overflow-hidden bg-surface-alt border-b border-surface-line">
			<div
				class="absolute inset-0 pointer-events-none bg-center bg-cover opacity-40"
				style="background-image: url('<?php echo esc_url( get_template_directory_uri() . '/assets/icons/banner-bg.svg' ); ?>'); mix-blend-mode: color-dodge;"
				aria-hidden="true"
			></div>
			<div class="container-page relative flex items-center justify-center gap-3 py-3 text-center">
				<span class="text-heading text-sm font-medium"><?php echo esc_html( $banner_text ); ?></span>
				<span class="text-heading text-sm font-medium underline underline-offset-4"><?php echo esc_html( $banner_cta ); ?></span>
			</div>
		</div>
		<?php /* Navigation bar (SOT: .navigation-bar) — logo left, centered pill nav, Contact Us CTA right. */ ?>
		<div class="bg-surface-alt">
			<div class="container-page relative flex items-center justify-between h-16 md:h-20">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="shrink-0 flex items-center gap-2">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/icons/logo-mark.svg' ); ?>" alt="" class="h-8 w-8 md:h-10 md:w-10" />
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/icons/logo-wordmark.svg' ); ?>" alt="<?php echo esc_attr( $brand ); ?>" class="h-4 md:h-[18px] w-auto" />
				</a>
				<nav aria-label="<?php esc_attr_e( 'Primary', 'growmodo' ); ?>" class="hidden md:flex items-center gap-2 absolute left-1/2 -translate-x-1/2">
					<?php
					foreach ( $nav_items as $item ) :
						$label     = $item['label'] ?? '';
						$url       = $item['url'] ?? '#';
						$item_path = trim( wp_parse_url( $url, PHP_URL_PATH ) ?? '', '/' );
						$is_active = ( 'properties' === $item_path && $is_archive ) || ( '' !== $item_path && $item_path === $current_path );
						?>
						<a class="nav-link px-4 py-3<?php echo $is_active ? ' rounded bg-surface border border-surface-line is-active' : ''; ?>" href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $label ); ?></a>
					<?php endforeach; ?>
				</nav>
				<a class="nav-pill hidden sm:inline-flex" href="<?php echo esc_url( $cta_url ); ?>"><?php echo esc_html( $cta_label ); ?></a>
				<button type="button" data-nav-toggle aria-expanded="false" aria-controls="mobile-nav-panel"
					aria-label="<?php esc_attr_e( 'Open menu', 'growmodo' ); ?>" class="md:hidden bg-transparent border-0 text-heading">
					<span class="icon-inline text-2xl" data-nav-icon-open>menu</span>
					<span class="icon-inline text-2xl hidden" data-nav-icon-close>close</span>
				</button>
			</div>
		</div>
	</header>

	<div data-nav-backdrop class="hidden fixed inset-0 bg-black/60 z-[110] md:hidden"></div>

	<aside id="mobile-nav-panel" data-nav-panel role="dialog" aria-modal="true"
		aria-label="<?php esc_attr_e( 'Site navigation', 'growmodo' ); ?>"
		class="fixed inset-y-0 right-0 z-[120] w-4/5 max-w-xs bg-surface-alt shadow-xl
			translate-x-full transition-transform duration-300 ease-in-out md:hidden flex flex-col">
		<div class="flex items-center justify-between p-4 border-b border-surface-line">
			<span class="font-semibold text-heading"><?php esc_html_e( 'Menu', 'growmodo' ); ?></span>
			<button type="button" data-nav-close aria-label="<?php esc_attr_e( 'Close menu', 'growmodo' ); ?>" class="bg-transparent border-0 text-heading">
				<span class="icon-inline text-2xl">close</span>
			</button>
		</div>
		<nav aria-label="<?php esc_attr_e( 'Mobile', 'growmodo' ); ?>" class="flex flex-col gap-1 p-4 overflow-y-auto">
			<?php foreach ( $nav_items as $item ) : ?>
				<a class="nav-link py-2" href="<?php echo esc_url( $item['url'] ?? '#' ); ?>"><?php echo esc_html( $item['label'] ?? '' ); ?></a>
			<?php endforeach; ?>
			<a class="nav-link py-2" href="<?php echo esc_url( $cta_url ); ?>"><?php echo esc_html( $cta_label ); ?></a>
		</nav>
	</aside>
</div>
