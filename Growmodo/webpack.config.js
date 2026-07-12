const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const path = require( 'path' );
const glob = require( 'glob' );

/**
 * One entry per block (blocks/<name>/index.js -> build/blocks/<name>/index.js),
 * discovered dynamically so new blocks never require a webpack edit.
 * glob needs forward slashes even on Windows — path.resolve()'s backslashes
 * are treated as escape characters and silently match nothing.
 */
const blockEntries = {};
const blockGlobPattern = path.resolve( __dirname, 'blocks/*/index.js' ).split( path.sep ).join( '/' );
glob.sync( blockGlobPattern ).forEach( ( file ) => {
	const blockName = path.basename( path.dirname( file ) );
	blockEntries[ `blocks/${ blockName }/index` ] = file;
} );

module.exports = {
	...defaultConfig,
	entry: {
		...blockEntries,
		frontend: path.resolve( __dirname, 'assets/src/css/main.css' ),
		editor: path.resolve( __dirname, 'assets/src/css/editor.css' ),
	},
	output: {
		...defaultConfig.output,
		path: path.resolve( __dirname, 'build' ),
	},
};
