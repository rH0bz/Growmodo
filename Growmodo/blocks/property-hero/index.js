import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor';
import metadata from './block.json';

registerBlockType( metadata.name, {
	edit: () => {
		const blockProps = useBlockProps();
		return (
			<div { ...blockProps }>
				<div className="card p-6 text-ink text-sm">Property Hero — renders the current property's title, location, price and gallery on the frontend.</div>
			</div>
		);
	},
	save: () => null,
} );
