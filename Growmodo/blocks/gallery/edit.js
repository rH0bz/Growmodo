import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { PanelBody, Button } from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
	const { heading, body, images, largeImageUrl, largeImageAlt } = attributes;
	const blockProps = useBlockProps();
	const themeUri = typeof window !== 'undefined' && window.growmodoThemeUri ? window.growmodoThemeUri : '';
	const largeUrl = largeImageUrl || ( themeUri ? `${ themeUri }/assets/img/gallery-feature.png` : '' );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Gallery', 'growmodo' ) }>
					<MediaUploadCheck>
						<MediaUpload
							multiple
							onSelect={ ( media ) => setAttributes( { images: media.map( ( m ) => ( { url: m.url, alt: m.alt || '' } ) ) } ) }
							allowedTypes={ [ 'image' ] }
							render={ ( { open } ) => <Button variant="secondary" onClick={ open }>{ __( 'Select images', 'growmodo' ) }</Button> }
						/>
					</MediaUploadCheck>
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<section className="section bg-surface">
					<div className="container-page">
						<div className="panel relative overflow-hidden p-8 grid md:grid-cols-2 gap-6 items-center">
							{ themeUri && <img src={ `${ themeUri }/assets/icons/gallery-ring.svg` } alt="" className="hidden lg:block absolute inset-0 w-full h-full object-cover opacity-30 -z-10 pointer-events-none" /> }
							<div className="grid grid-cols-2 gap-2">
								{ ( images || [] ).map( ( img, i ) => {
									const imgUrl = img.url || ( themeUri && img.file ? `${ themeUri }/assets/img/${ img.file }` : '' );
									return imgUrl
										? <img key={ i } src={ imgUrl } alt={ img.alt } className="rounded w-full h-40 object-cover" />
										: <div key={ i } className="rounded w-full h-40 bg-surface-alt" />;
								} ) }
							</div>
							<div>
								<RichText tagName="h2" className="h2" value={ heading } onChange={ ( v ) => setAttributes( { heading: v } ) } />
								<RichText tagName="p" className="lead mt-2" value={ body } onChange={ ( v ) => setAttributes( { body: v } ) } />
								{ largeUrl && <img src={ largeUrl } alt={ largeImageAlt } className="rounded-lg w-full h-[280px] object-cover mt-6" /> }
							</div>
						</div>
					</div>
				</section>
			</div>
		</>
	);
}
