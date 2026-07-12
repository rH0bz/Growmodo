import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody, RangeControl } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

export default function Edit( { attributes, setAttributes } ) {
	const { heading, body, perPage } = attributes;
	const blockProps = useBlockProps();

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Archive Grid', 'growmodo' ) }>
					<RangeControl label={ __( 'Properties per page', 'growmodo' ) } value={ perPage } onChange={ ( v ) => setAttributes( { perPage: v } ) } min={ 1 } max={ 24 } />
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<div className="section-header mb-6">
					<div>
						<RichText tagName="h2" className="h2" value={ heading } onChange={ ( v ) => setAttributes( { heading: v } ) } />
						<RichText tagName="p" className="lead mt-2 max-w-xl" value={ body } onChange={ ( v ) => setAttributes( { body: v } ) } />
					</div>
				</div>
				<ServerSideRender block="growmodo/archive-grid" attributes={ attributes } />
			</div>
		</>
	);
}
