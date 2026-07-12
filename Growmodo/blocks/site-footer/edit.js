import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
	const { brand, columns, copyright } = attributes;
	const blockProps = useBlockProps();
	const themeUri = typeof window !== 'undefined' && window.growmodoThemeUri ? window.growmodoThemeUri : '';

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Footer', 'growmodo' ) }>
					<TextControl label={ __( 'Copyright', 'growmodo' ) } value={ copyright } onChange={ ( v ) => setAttributes( { copyright: v } ) } />
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<footer className="bg-surface-alt border-t border-surface-line py-12">
					<div className="container-page">
						<div className="flex items-center gap-2 mb-6">
							{ themeUri && <img src={ `${ themeUri }/assets/icons/logo-mark.svg` } alt="" className="h-8 w-8" /> }
							{ themeUri && <img src={ `${ themeUri }/assets/icons/logo-wordmark.svg` } alt={ brand } className="h-4 w-auto" /> }
						</div>
						<div className="grid grid-cols-2 md:grid-cols-5 gap-6">
							{ ( columns || [] ).map( ( col, i ) => (
								<div key={ i }>
									<div className="text-heading font-semibold mb-2">{ col.title }</div>
									{ ( col.links || [] ).map( ( link, j ) => (
										<div key={ j } className="text-ink text-sm py-1">{ link }</div>
									) ) }
								</div>
							) ) }
						</div>
						<div className="text-ink text-sm mt-8">{ copyright }</div>
					</div>
				</footer>
			</div>
		</>
	);
}
