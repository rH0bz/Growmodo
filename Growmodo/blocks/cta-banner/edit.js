import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
	const { heading, body, ctaLabel } = attributes;
	const blockProps = useBlockProps();
	const themeUri = typeof window !== 'undefined' && window.growmodoThemeUri ? window.growmodoThemeUri : '';

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'CTA Banner', 'growmodo' ) }>
					<TextControl label={ __( 'Button label', 'growmodo' ) } value={ ctaLabel } onChange={ ( v ) => setAttributes( { ctaLabel: v } ) } />
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<section className="section bg-surface-alt border-y border-surface-line relative overflow-hidden">
					{ themeUri && <img src={ `${ themeUri }/assets/icons/cta-decor-1.svg` } alt="" className="hidden md:block absolute -right-24 -bottom-16 w-72 h-auto opacity-40 pointer-events-none" /> }
					{ themeUri && <img src={ `${ themeUri }/assets/icons/cta-decor-2.svg` } alt="" className="hidden md:block absolute -left-10 bottom-0 w-56 h-auto opacity-40 pointer-events-none" /> }
					<div className="container-page flex flex-col md:flex-row md:items-center gap-8 md:gap-24">
						<div className="flex-1">
							<RichText tagName="h2" className="h2" value={ heading } onChange={ ( v ) => setAttributes( { heading: v } ) } />
							<RichText tagName="p" className="lead mt-4" value={ body } onChange={ ( v ) => setAttributes( { body: v } ) } />
						</div>
						<span className="btn-primary shrink-0">{ ctaLabel }</span>
					</div>
				</section>
			</div>
		</>
	);
}
