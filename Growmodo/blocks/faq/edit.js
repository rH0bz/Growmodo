import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody } from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
	const { heading, body, items } = attributes;
	const blockProps = useBlockProps();

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'FAQ', 'growmodo' ) }>
					<p>{ __( 'Edit questions in the Code Editor / attributes.', 'growmodo' ) }</p>
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
						<div key={ i } className="card p-8">
							<div className="h3">{ item.question }</div>
							<p className="lead text-sm mt-3">{ item.answer }</p>
						</div>
					) ) }
				</div>
			</div>
		</>
	);
}
