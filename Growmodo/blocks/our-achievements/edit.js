import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody } from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
	const { heading, body, items } = attributes;
	const blockProps = useBlockProps();

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Our Achievements', 'growmodo' ) }>
					<p>{ __( 'Edit items in the Code Editor / attributes.', 'growmodo' ) }</p>
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<section className="section bg-surface">
					<div className="container-page">
						<RichText tagName="h2" className="h2" value={ heading } onChange={ ( v ) => setAttributes( { heading: v } ) } />
						<RichText tagName="p" className="lead mt-2 max-w-xl" value={ body } onChange={ ( v ) => setAttributes( { body: v } ) } />
						<div className="grid md:grid-cols-3 gap-6 mt-10">
							{ ( items || [] ).map( ( item, i ) => (
								<div key={ i } className="card p-8">
									<div className="h3">{ item.title }</div>
									<p className="lead text-sm mt-2">{ item.body }</p>
								</div>
							) ) }
						</div>
					</div>
				</section>
			</div>
		</>
	);
}
