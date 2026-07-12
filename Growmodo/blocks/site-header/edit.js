import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
	const { brand, bannerText, ctaLabel, navItems } = attributes;
	const blockProps = useBlockProps();
	const themeUri = typeof window !== 'undefined' && window.growmodoThemeUri ? window.growmodoThemeUri : '';

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Header', 'growmodo' ) }>
					<TextControl label={ __( 'Banner text', 'growmodo' ) } value={ bannerText } onChange={ ( v ) => setAttributes( { bannerText: v } ) } />
					<TextControl label={ __( 'CTA label', 'growmodo' ) } value={ ctaLabel } onChange={ ( v ) => setAttributes( { ctaLabel: v } ) } />
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<header className="w-full bg-surface-alt border-b border-surface-line">
					<div className="relative overflow-hidden bg-surface-alt border-b border-surface-line py-3">
						{ themeUri && (
							<div
								className="absolute inset-0 pointer-events-none bg-center bg-cover opacity-40"
								style={ { backgroundImage: `url('${ themeUri }/assets/icons/banner-bg.svg')`, mixBlendMode: 'color-dodge' } }
							/>
						) }
						<div className="container-page relative text-center text-heading text-sm">{ bannerText }</div>
					</div>
					<div className="container-page flex items-center justify-between h-16">
						<span className="flex items-center gap-2">
							{ themeUri && <img src={ `${ themeUri }/assets/icons/logo-mark.svg` } alt="" className="h-8 w-8" /> }
							{ themeUri && <img src={ `${ themeUri }/assets/icons/logo-wordmark.svg` } alt={ brand } className="h-4 w-auto" /> }
						</span>
						<nav className="hidden md:flex items-center gap-6">
							{ ( navItems || [] ).map( ( item, i ) => (
								<span key={ i } className="nav-link">{ item.label }</span>
							) ) }
						</nav>
						<span className="nav-pill">{ __( 'Contact Us', 'growmodo' ) }</span>
					</div>
				</header>
			</div>
		</>
	);
}
