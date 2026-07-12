import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
	const { heading, body, submitLabel } = attributes;
	const blockProps = useBlockProps();
	const fields = [ 'First Name', 'Last Name', 'Email', 'Phone', 'Preferred Location', 'Property Type', 'No. of Bathrooms', 'No. of Bedrooms', 'Budget', 'Preferred Contact Method' ];

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Property Lead Form', 'growmodo' ) }>
					<TextControl label={ __( 'Submit label', 'growmodo' ) } value={ submitLabel } onChange={ ( v ) => setAttributes( { submitLabel: v } ) } />
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<section className="section bg-surface">
					<div className="container-page max-w-3xl">
						<RichText tagName="h2" className="h2" value={ heading } onChange={ ( v ) => setAttributes( { heading: v } ) } />
						<RichText tagName="p" className="lead mt-2" value={ body } onChange={ ( v ) => setAttributes( { body: v } ) } />
						<div className="grid md:grid-cols-3 gap-4 mt-8">
							{ fields.map( ( f, i ) => (
								<div key={ i }>
									<div className="field-label">{ f }</div>
									<div className="field text-ink">{ f }</div>
								</div>
							) ) }
						</div>
						<span className="btn-primary mt-6 inline-flex">{ submitLabel }</span>
					</div>
				</section>
			</div>
		</>
	);
}
