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
				<PanelBody title={ __( 'Contact Info Bar', 'growmodo' ) }>
					<p>{ __( 'Edit chips in the Code Editor / attributes.', 'growmodo' ) }</p>
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<section className="section bg-surface">
					<div className="container-page">
						<RichText tagName="h1" className="h-display" value={ heading } onChange={ ( v ) => setAttributes( { heading: v } ) } />
						<RichText tagName="p" className="lead mt-4 max-w-xl" value={ body } onChange={ ( v ) => setAttributes( { body: v } ) } />
						<div className="grid sm:grid-cols-2 md:grid-cols-4 gap-4 mt-8">
							{ ( items || [] ).map( ( item, i ) => (
								<div key={ i } className="card flex items-center gap-3 p-4">
									<span className="icon-badge">{ themeUri && item.icon && <img src={ `${ themeUri }/assets/icons/${ item.icon }` } alt="" className="w-4 h-4" /> }</span>
									<span className="text-heading text-sm">{ item.label }</span>
								</div>
							) ) }
						</div>
					</div>
				</section>
			</div>
		</>
	);
}
