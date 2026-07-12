import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody } from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
	const { heading, body, members } = attributes;
	const blockProps = useBlockProps();
	const themeUri = typeof window !== 'undefined' && window.growmodoThemeUri ? window.growmodoThemeUri : '';

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Our Team', 'growmodo' ) }>
					<p>{ __( 'Edit members in the Code Editor / attributes.', 'growmodo' ) }</p>
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<section className="section bg-surface">
					<div className="container-page">
						<RichText tagName="h2" className="h2" value={ heading } onChange={ ( v ) => setAttributes( { heading: v } ) } />
						<RichText tagName="p" className="lead mt-2 max-w-xl" value={ body } onChange={ ( v ) => setAttributes( { body: v } ) } />
						<div className="grid grid-cols-2 md:grid-cols-4 gap-6 mt-10">
							{ ( members || [] ).map( ( m, i ) => {
								const photoUrl = m.photoUrl || ( themeUri && m.photoFile ? `${ themeUri }/assets/img/${ m.photoFile }` : '' );
								return (
								<div key={ i } className="card p-6">
									{ photoUrl ? <img src={ photoUrl } alt={ m.name } className="rounded-lg w-full h-[200px] md:h-[253px] object-cover mb-4" /> : <div className="rounded-lg w-full h-[200px] md:h-[253px] bg-surface-alt mb-4" /> }
									<div className="text-heading font-semibold">{ m.name }</div>
									<div className="text-ink text-sm">{ m.role }</div>
								</div>
								);
							} ) }
						</div>
					</div>
				</section>
			</div>
		</>
	);
}
