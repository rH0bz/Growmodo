import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody } from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
	const { heading, body, steps } = attributes;
	const blockProps = useBlockProps();

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Our Process', 'growmodo' ) }>
					<p>{ __( 'Edit steps in the Code Editor / attributes.', 'growmodo' ) }</p>
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<section className="section bg-surface">
					<div className="container-page">
						<RichText tagName="h2" className="h2" value={ heading } onChange={ ( v ) => setAttributes( { heading: v } ) } />
						<RichText tagName="p" className="lead mt-2 max-w-xl" value={ body } onChange={ ( v ) => setAttributes( { body: v } ) } />
						<div className="grid md:grid-cols-3 gap-8 mt-10">
							{ ( steps || [] ).map( ( step, i ) => (
								<div key={ i } className="flex gap-4">
									<span className="text-ink text-sm font-semibold shrink-0">{ step.number }</span>
									<div>
										<div className="h3 !text-lg">{ step.title }</div>
										<p className="lead text-sm mt-1">{ step.body }</p>
									</div>
								</div>
							) ) }
						</div>
					</div>
				</section>
			</div>
		</>
	);
}
