/**
 * Growmodo — Tailwind config.
 * Color / typography / radius tokens are transcribed from the Growmodo SOT
 * (AI Website Architecture Wiki > Sites > Growmodo > Design System), extracted
 * directly from each page's exported style.css (vars.css supplied the color
 * scale; Fonts/Effects sections were empty, so type sizes came from style.css).
 * Never hand-edit a token here without updating the SOT first.
 *
 * Palette: dark theme by default — near-black greys + one purple accent.
 * We only EXTEND custom semantic tokens — Tailwind's own scales (incl. neutral,
 * per the standing "never override neutral as a flat value" lesson) stay intact.
 */
module.exports = {
	content: [
		'./blocks/**/*.php',
		'./blocks/**/*.js',
		'./parts/**/*.html',
		'./templates/**/*.html',
	],
	safelist: [
		{
			pattern:
				/^(bg|text|border|from|via|to)-(surface|surface-alt|surface-line|ink|heading|on-dark|accent|accent-hover)(\/(5|10|20|30|40|50|60|70|80|90))?$/,
		},
		// The off-canvas mobile nav panel (site-header) toggles this class purely
		// from assets/js/frontend.js, outside the `content` globs above.
		'translate-x-0',
	],
	theme: {
		extend: {
			colors: {
				surface: '#141414', // --grey-08: deepest surface — page bg, card fill
				'surface-alt': '#1a1a1a', // --grey-10: header/nav bands, secondary surface
				'surface-line': '#262626', // --grey-15: hairline borders, used almost everywhere
				ink: '#999999', // --grey-60: muted body text on dark surfaces
				heading: '#ffffff', // --absolute-white: headings, labels, nav links
				'on-dark': '#ffffff',
				accent: '#703bf7', // --purple-60: the one accent — primary CTAs, active states
				'accent-hover': '#8254f8', // --purple-65
				purple: {
					60: '#703bf7',
					65: '#8254f8',
					70: '#946cf9',
					75: '#a685fa',
					90: '#dbcefd',
					95: '#ede7fe',
					97: '#f4f0fe',
					99: '#fbfaff',
				},
			},
			fontFamily: {
				sans: [ 'Urbanist', 'ui-sans-serif', 'system-ui', 'sans-serif' ],
				display: [ 'Urbanist', 'ui-sans-serif', 'sans-serif' ],
			},
			fontSize: {
				display: [ '60px', { lineHeight: '1.2', fontWeight: '600' } ], // .heading4 — hero H1
				stat: [ '40px', { lineHeight: '1.5', fontWeight: '700' } ], // .heading5 — stat numbers
				'h2-size': [ '48px', { lineHeight: '1.5', fontWeight: '600' } ], // .heading — section H2
				'h3-size': [ '24px', { lineHeight: '1.5', fontWeight: '600' } ], // .heading2 — card H3
				body: [ '18px', { lineHeight: '1.5', fontWeight: '500' } ], // .paragraph / .text3
			},
			borderRadius: {
				DEFAULT: '10px', // buttons
				lg: '12px', // cards, panels
				pill: '100px', // pill badges / icon rings
			},
			maxWidth: {
				// Fixed 2026-07-12 (was 1440px, an invented value — see log). The raw CSS's
				// content width is not a build-time approximation: every content section on
				// every one of the 6 pages (Home .container/.container5/.container8, About,
				// Services, Property Single) is width:1596px; left:162px on the 1920px canvas,
				// and every nav bar is padding:20px 162px. 1920 - 162*2 = 1596 exactly — this
				// is the real, consistent, measured sitewide content width.
				container: '1596px',
			},
			boxShadow: {
				// The recurring "outer glow" frame device (Hero feature strip, FAQ Item,
				// Client Card, Archive Search Bar): box-shadow: 0 0 0 Npx rgba(25,25,25,1).
				glow: '0 0 0 10px rgba(25,25,25,1)',
				'glow-sm': '0 0 0 8px rgba(25,25,25,1)',
			},
		},
	},
	plugins: [],
};
