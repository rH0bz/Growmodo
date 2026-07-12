import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody, RangeControl } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

export default function Edit( { attributes, setAttributes } ) {
	const { heading, body, count } = attributes;
	const blockProps = useBlockProps();

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Featured Properties', 'growmodo' ) }>
					<RangeControl label={ __( 'Number of properties', 'growmodo' ) } value={ count } onChange={ ( v ) => setAttributes( { count: v } ) } min={ 1 } max={ 12 } />
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<div className="section-header mb-6">
					<div>
						<RichText tagName="h2" className="h2" value={ heading } onChange={ ( v ) => setAttributes( { heading: v } ) } />
						<RichText tagName="p" className="lead mt-2 max-w-xl" value={ body } onChange={ ( v ) => setAttributes( { body: v } ) } />
					</div>
				</div>
				<ServerSideRender block="growmodo/featured-properties" attributes={ attributes } />
			</div>
		</>
	);
}
