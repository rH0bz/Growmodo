import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody } from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
	const { heading, body, tabs, offices } = attributes;
	const blockProps = useBlockProps();

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Office Locations', 'growmodo' ) }>
					<p>{ __( 'Edit offices in the Code Editor / attributes.', 'growmodo' ) }</p>
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<section className="section bg-surface">
					<div className="container-page">
						<RichText tagName="h2" className="h2" value={ heading } onChange={ ( v ) => setAttributes( { heading: v } ) } />
						<RichText tagName="p" className="lead mt-2 max-w-xl" value={ body } onChange={ ( v ) => setAttributes( { body: v } ) } />
						<div className="flex gap-2 mt-6">
							{ ( tabs || [] ).map( ( t, i ) => (
								<span key={ i } className={ i === 0 ? 'btn-primary text-sm' : 'btn-secondary text-sm' }>{ t }</span>
							) ) }
						</div>
						<div className="grid md:grid-cols-2 gap-6 mt-6">
							{ ( offices || [] ).map( ( o, i ) => (
								<div key={ i } className="card p-8">
									<div className="text-ink text-sm">{ o.label }</div>
									<div className="h3 !text-lg">{ o.address }</div>
									<p className="lead text-sm mt-2">{ o.body }</p>
								</div>
							) ) }
						</div>
					</div>
				</section>
			</div>
		</>
	);
}
