import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { PanelBody, TextControl, Button } from '@wordpress/components';

function circularTextSpans( text, radius = 58 ) {
	return Array.from( text ).map( ( char, i, all ) => {
		const angle = ( i / all.length ) * 360;
		return (
			<span
				key={ i }
				className="hero-badge-char"
				style={ { transform: `rotate(${ angle }deg) translate(0, -${ radius }px)` } }
			>
				{ char }
			</span>
		);
	} );
}

export default function Edit( { attributes, setAttributes } ) {
	const { heading, body, primaryCta, secondaryCta, imageUrl, imageAlt, badgeText, stats, features } = attributes;
	const blockProps = useBlockProps();
	const themeUri = typeof window !== 'undefined' && window.growmodoThemeUri ? window.growmodoThemeUri : '';
	const heroImageUrl = imageUrl || ( themeUri ? `${ themeUri }/assets/img/hero-property.png` : '' );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Hero', 'growmodo' ) }>
					<TextControl label={ __( 'Primary CTA', 'growmodo' ) } value={ primaryCta } onChange={ ( v ) => setAttributes( { primaryCta: v } ) } />
					<TextControl label={ __( 'Secondary CTA', 'growmodo' ) } value={ secondaryCta } onChange={ ( v ) => setAttributes( { secondaryCta: v } ) } />
					<TextControl label={ __( 'Image alt text', 'growmodo' ) } value={ imageAlt } onChange={ ( v ) => setAttributes( { imageAlt: v } ) } />
					<MediaUploadCheck>
						<MediaUpload
							onSelect={ ( media ) => setAttributes( { imageUrl: media.url } ) }
							allowedTypes={ [ 'image' ] }
							render={ ( { open } ) => <Button variant="secondary" onClick={ open }>{ __( 'Select hero image', 'growmodo' ) }</Button> }
						/>
					</MediaUploadCheck>
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<section className="section bg-surface">
					<div className="container-page grid md:grid-cols-2 gap-10 items-center">
						<div>
							<RichText tagName="h1" className="h-display" value={ heading } onChange={ ( v ) => setAttributes( { heading: v } ) } />
							<RichText tagName="p" className="lead mt-4" value={ body } onChange={ ( v ) => setAttributes( { body: v } ) } />
							<div className="flex gap-4 mt-6">
								<span className="btn-secondary">{ secondaryCta }</span>
								<span className="btn-primary">{ primaryCta }</span>
							</div>
							<div className="flex gap-8 mt-8">
								{ ( stats || [] ).map( ( s, i ) => (
									<div key={ i }>
										<div className="stat-number">{ s.number }</div>
										<div className="lead text-sm">{ s.label }</div>
									</div>
								) ) }
							</div>
						</div>
						<div className="relative">
							{ themeUri && (
								<div className="hidden lg:block absolute -inset-16 -z-10 opacity-50 pointer-events-none" aria-hidden="true">
									<img src={ `${ themeUri }/assets/icons/hero-ring.svg` } alt="" className="w-full h-full object-contain" />
								</div>
							) }
							{ heroImageUrl ? (
								<div className="relative rounded-lg overflow-hidden w-full h-[320px] md:h-[560px] lg:h-[814px]">
									<img src={ heroImageUrl } alt={ imageAlt } className="w-full h-full object-cover" />
									<div className="absolute inset-0" style={ { background: 'linear-gradient(238deg, rgba(42,33,63,0.9) 8%, rgba(25,25,25,0) 55%)' } } />
								</div>
							) : (
								<div className="rounded-lg w-full h-[320px] md:h-[560px] lg:h-[814px] bg-surface-alt" />
							) }
							{ badgeText && (
								<div className="hero-badge" aria-hidden="true">
									<span className="hero-badge-ring">{ circularTextSpans( badgeText ) }</span>
									<span className="hero-badge-core">
										{ themeUri && <img src={ `${ themeUri }/assets/icons/badge-arrow.svg` } alt="" className="w-4 h-4" /> }
									</span>
								</div>
							) }
						</div>
					</div>
					{ features && features.length > 0 && (
						<div className="container-page mt-12">
							<div className="grid grid-cols-2 md:grid-cols-4 gap-4 rounded-lg bg-surface border border-surface-line p-5 shadow-glow">
								{ features.map( ( feature, i ) => (
									<div className="flex items-center gap-3" key={ i }>
										<span className="icon-badge">
											{ themeUri && <img src={ `${ themeUri }/assets/icons/${ feature.icon || 'feature-dream-home.svg' }` } alt="" className="w-5 h-5" /> }
										</span>
										<span className="text-heading text-sm font-medium">{ feature.label }</span>
									</div>
								) ) }
							</div>
						</div>
					) }
				</section>
			</div>
		</>
	);
}
