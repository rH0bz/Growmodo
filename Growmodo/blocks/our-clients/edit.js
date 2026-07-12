import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody } from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
	const { heading, body, items } = attributes;
	const blockProps = useBlockProps();

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Our Clients', 'growmodo' ) }>
					<p>{ __( 'Edit clients in the Code Editor / attributes.', 'growmodo' ) }</p>
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<section className="section bg-surface">
					<div className="container-page">
						<RichText tagName="h2" className="h2" value={ heading } onChange={ ( v ) => setAttributes( { heading: v } ) } />
						<RichText tagName="p" className="lead mt-2 max-w-xl" value={ body } onChange={ ( v ) => setAttributes( { body: v } ) } />
						<div className="grid md:grid-cols-2 gap-6 mt-10">
							{ ( items || [] ).map( ( item, i ) => (
								<div key={ i } className="card p-8 shadow-glow-sm">
									<div className="flex items-center justify-between">
										<div>
											<div className="text-ink text-xs">{ item.since }</div>
											<div className="h3 !text-lg">{ item.name }</div>
										</div>
										<span className="btn-secondary text-sm">Visit Website</span>
									</div>
									<div className="flex gap-6 mt-4 pt-4 border-t border-surface-line text-sm">
										<div><span className="text-ink">Domain</span><div className="text-heading">{ item.domain }</div></div>
										<div><span className="text-ink">Category</span><div className="text-heading">{ item.category }</div></div>
									</div>
									<p className="lead text-sm mt-4">{ item.quote }</p>
								</div>
							) ) }
						</div>
					</div>
				</section>
			</div>
		</>
	);
}
