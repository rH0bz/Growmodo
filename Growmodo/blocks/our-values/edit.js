import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody } from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
	const { heading, body, items } = attributes;
	const blockProps = useBlockProps();
	const themeUri = typeof window !== 'undefined' && window.growmodoThemeUri ? window.growmodoThemeUri : '';

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Our Values', 'growmodo' ) }>
					<p>{ __( 'Edit items in the Code Editor / attributes.', 'growmodo' ) }</p>
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<section className="section bg-surface">
					<div className="container-page">
						<RichText tagName="h2" className="h2" value={ heading } onChange={ ( v ) => setAttributes( { heading: v } ) } />
						<RichText tagName="p" className="lead mt-2 max-w-xl" value={ body } onChange={ ( v ) => setAttributes( { body: v } ) } />
						<div className="grid md:grid-cols-2 gap-8 mt-10">
							{ ( items || [] ).map( ( item, i ) => (
								<div key={ i } className="flex gap-4">
									<span className="icon-badge shrink-0">{ themeUri && item.icon && <img src={ `${ themeUri }/assets/icons/${ item.icon }` } alt="" className="w-4 h-4" /> }</span>
									<div>
										<div className="h3">{ item.title }</div>
										<p className="lead text-sm mt-1">{ item.body }</p>
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
