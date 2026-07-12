import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
	const { submitLabel } = attributes;
	const blockProps = useBlockProps();
	const fields = [ 'First Name', 'Last Name', 'Email', 'Phone' ];

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Property Inquiry Form', 'growmodo' ) }>
					<TextControl label={ __( 'Submit label', 'growmodo' ) } value={ submitLabel } onChange={ ( v ) => setAttributes( { submitLabel: v } ) } />
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<section className="section bg-surface">
					<div className="container-page max-w-3xl">
						<h2 className="h2">{ __( 'Inquire About This Property', 'growmodo' ) }</h2>
						<p className="lead mt-2">{ __( 'Interested in this property? Fill out the form below, and our real estate experts will get back to you.', 'growmodo' ) }</p>
						<div className="grid md:grid-cols-2 gap-4 mt-8">
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
