import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody } from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
	const { heading, body, items } = attributes;
	const blockProps = useBlockProps();

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Testimonials', 'growmodo' ) }>
					<p>{ __( 'Edit individual testimonials in the Code Editor / attributes for now — this block mirrors 3 fixed reviews from the SOT.', 'growmodo' ) }</p>
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<div className="section-header mb-6">
					<div>
						<RichText tagName="h2" className="h2" value={ heading } onChange={ ( v ) => setAttributes( { heading: v } ) } />
						<RichText tagName="p" className="lead mt-2 max-w-xl" value={ body } onChange={ ( v ) => setAttributes( { body: v } ) } />
					</div>
				</div>
				<div className="grid md:grid-cols-3 gap-6">
					{ ( items || [] ).map( ( item, i ) => (
						<div key={ i } className="card p-6">
							<div className="h3">{ item.heading }</div>
							<p className="lead text-sm mt-3">{ item.quote }</p>
							<div className="mt-4 font-semibold text-heading">{ item.name }</div>
							<div className="text-ink text-sm">{ item.location }</div>
						</div>
					) ) }
				</div>
			</div>
		</>
	);
}
