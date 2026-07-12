import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody } from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
	const { heading, body, searchLabel, findLabel } = attributes;
	const blockProps = useBlockProps();
	const facets = [ 'Location', 'Property Type', 'Pricing Range', 'Property Size', 'Build Year' ];

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Archive Search Bar', 'growmodo' ) }>
					<p>{ __( 'Filter options are populated live from the property_location / property_type taxonomies on the frontend — this editor preview is illustrative only.', 'growmodo' ) }</p>
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<section className="section bg-surface-alt">
					<div className="container-page">
						<RichText tagName="h1" className="h-display" value={ heading } onChange={ ( v ) => setAttributes( { heading: v } ) } />
						<RichText tagName="p" className="lead mt-4 max-w-2xl" value={ body } onChange={ ( v ) => setAttributes( { body: v } ) } />
						<div className="mt-8 rounded-lg overflow-hidden border border-surface-line shadow-glow">
							<div className="bg-surface p-4 flex items-center justify-between gap-3">
								<span className="text-ink text-sm">{ searchLabel }</span>
								<span className="btn-primary text-sm">{ findLabel }</span>
							</div>
							<div className="bg-surface-alt p-4 flex flex-wrap gap-4">
								{ facets.map( ( f, i ) => <span key={ i } className="field-select text-sm w-40">{ f }</span> ) }
							</div>
						</div>
					</div>
				</section>
			</div>
		</>
	);
}
