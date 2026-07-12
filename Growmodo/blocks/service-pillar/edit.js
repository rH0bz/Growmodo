import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody, SelectControl } from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
	const { heading, body, features, ctaHeading, ctaLabel, ctaPosition } = attributes;
	const blockProps = useBlockProps();
	const themeUri = typeof window !== 'undefined' && window.growmodoThemeUri ? window.growmodoThemeUri : '';

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Service Pillar', 'growmodo' ) }>
					<SelectControl
						label={ __( 'CTA layout', 'growmodo' ) }
						value={ ctaPosition }
						options={ [
							{ label: __( 'As grid cell (pillars 1 & 2)', 'growmodo' ), value: 'grid' },
							{ label: __( 'Standalone aside (pillar 3)', 'growmodo' ), value: 'aside' },
						] }
						onChange={ ( v ) => setAttributes( { ctaPosition: v } ) }
					/>
					<p>{ __( 'Edit feature list in the Code Editor / attributes.', 'growmodo' ) }</p>
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<section className="section bg-surface">
					<div className="container-page">
						<RichText tagName="h2" className="h2" value={ heading } onChange={ ( v ) => setAttributes( { heading: v } ) } />
						<RichText tagName="p" className="lead mt-2 max-w-xl" value={ body } onChange={ ( v ) => setAttributes( { body: v } ) } />
						<div className="grid md:grid-cols-2 gap-6 mt-8">
							{ ( features || [] ).map( ( f, i ) => (
								<div key={ i } className="card p-6">
									<div className="flex items-center gap-3 mb-2">
										<span className="icon-badge">{ themeUri && f.icon && <img src={ `${ themeUri }/assets/icons/${ f.icon }` } alt="" className="w-4 h-4" /> }</span>
										<div className="h3 !text-lg">{ f.title }</div>
									</div>
									<p className="lead text-sm">{ f.body }</p>
								</div>
							) ) }
							<div className="card p-6 bg-accent/10 border-accent/40">
								<div className="h3 !text-lg">{ ctaHeading }</div>
								<span className="btn-primary text-sm mt-3 inline-flex">{ ctaLabel }</span>
							</div>
						</div>
					</div>
				</section>
			</div>
		</>
	);
}
