import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody } from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
	const { heading, body } = attributes;
	const blockProps = useBlockProps();

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Property Pricing', 'growmodo' ) }>
					<p>{ __( 'Fee line items come from the property’s "Pricing Details" meta box field — nothing to edit here.', 'growmodo' ) }</p>
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<section className="section bg-surface">
					<div className="container-page">
						<RichText tagName="h2" className="h2" value={ heading } onChange={ ( v ) => setAttributes( { heading: v } ) } />
						<RichText tagName="p" className="lead mt-2 max-w-xl" value={ body } onChange={ ( v ) => setAttributes( { body: v } ) } />
						<div className="card p-6 mt-6 text-ink text-sm">{ __( 'Grouped fee breakdown renders here on the frontend, parsed from the property’s Pricing Details field.', 'growmodo' ) }</div>
					</div>
				</section>
			</div>
		</>
	);
}
