import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { PanelBody, Button } from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
	const { heading, body, imageUrl, imageAlt, stats } = attributes;
	const blockProps = useBlockProps();
	const themeUri = typeof window !== 'undefined' && window.growmodoThemeUri ? window.growmodoThemeUri : '';
	const storyImageUrl = imageUrl || ( themeUri ? `${ themeUri }/assets/img/about-story.png` : '' );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Our Story', 'growmodo' ) }>
					<MediaUploadCheck>
						<MediaUpload
							onSelect={ ( media ) => setAttributes( { imageUrl: media.url } ) }
							allowedTypes={ [ 'image' ] }
							render={ ( { open } ) => <Button variant="secondary" onClick={ open }>{ __( 'Select image', 'growmodo' ) }</Button> }
						/>
					</MediaUploadCheck>
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<section className="section bg-surface">
					<div className="container-page grid md:grid-cols-2 gap-10 items-center">
						<div>
							<RichText tagName="h2" className="h2" value={ heading } onChange={ ( v ) => setAttributes( { heading: v } ) } />
							<RichText tagName="p" className="lead mt-4" value={ body } onChange={ ( v ) => setAttributes( { body: v } ) } />
							<div className="flex gap-8 mt-8">
								{ ( stats || [] ).map( ( s, i ) => (
									<div key={ i }>
										<div className="stat-number">{ s.number }</div>
										<div className="lead text-sm">{ s.label }</div>
									</div>
								) ) }
							</div>
						</div>
						<div className="relative">
							{ themeUri && (
								<div className="hidden lg:block absolute -inset-12 -z-10 opacity-50 pointer-events-none">
									<img src={ `${ themeUri }/assets/icons/story-ring.svg` } alt="" className="w-full h-full object-contain" />
								</div>
							) }
							{ storyImageUrl ? <img src={ storyImageUrl } alt={ imageAlt } className="rounded-lg w-full h-[280px] md:h-[420px] lg:h-[546px] object-cover" /> : <div className="rounded-lg w-full h-[280px] md:h-[420px] lg:h-[546px] bg-surface-alt" /> }
						</div>
					</div>
				</section>
			</div>
		</>
	);
}
