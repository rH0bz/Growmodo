import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody } from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
	const { heading, body, features } = attributes;
	const blockProps = useBlockProps();
	const themeUri = typeof window !== 'undefined' && window.growmodoThemeUri ? window.growmodoThemeUri : '';

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Services Overview', 'growmodo' ) }>
					<p>{ __( 'Edit items in the Code Editor / attributes.', 'growmodo' ) }</p>
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<section className="section bg-surface">
					<div className="container-page">
						<RichText tagName="h1" className="h-display" value={ heading } onChange={ ( v ) => setAttributes( { heading: v } ) } />
						<RichText tagName="p" className="lead mt-4 max-w-xl" value={ body } onChange={ ( v ) => setAttributes( { body: v } ) } />
						<div className="grid grid-cols-2 md:grid-cols-4 gap-4 rounded-lg bg-surface border border-surface-line p-5 mt-8 shadow-glow">
							{ ( features || [] ).map( ( f, i ) => (
								<div key={ i } className="flex items-center gap-3">
									<span className="icon-badge">{ themeUri && f.icon && <img src={ `${ themeUri }/assets/icons/${ f.icon }` } alt="" className="w-5 h-5" /> }</span>
									<span className="text-heading text-sm font-medium">{ f.label }</span>
								</div>
							) ) }
						</div>
					</div>
				</section>
			</div>
		</>
	);
}
