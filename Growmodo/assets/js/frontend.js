/**
 * Growmodo — frontend behaviors (progressive enhancement).
 * - Mobile nav: hamburger -> off-canvas panel + backdrop (standardized
 *   pattern, see `LLM wiki/wiki/concepts/FSE Global Sections.md`). Body-scroll
 *   lock, Escape/backdrop/close-button to close, focus management.
 * Kept dependency-free; enqueued in the footer.
 */
( function () {
	'use strict';

	function els() {
		return {
			toggle: document.querySelector( '[data-nav-toggle]' ),
			close: document.querySelector( '[data-nav-close]' ),
			backdrop: document.querySelector( '[data-nav-backdrop]' ),
			panel: document.querySelector( '[data-nav-panel]' ),
			iconOpen: document.querySelector( '[data-nav-icon-open]' ),
			iconClose: document.querySelector( '[data-nav-icon-close]' ),
		};
	}

	function setOpen( open ) {
		var e = els();
		if ( ! e.panel ) {
			return;
		}
		e.panel.classList.toggle( 'translate-x-0', open );
		e.panel.classList.toggle( 'translate-x-full', ! open );
		e.backdrop && e.backdrop.classList.toggle( 'hidden', ! open );
		document.documentElement.classList.toggle( 'overflow-hidden', open );
		e.toggle && e.toggle.setAttribute( 'aria-expanded', String( open ) );
		e.toggle && e.toggle.setAttribute( 'aria-label', open ? 'Close menu' : 'Open menu' );
		e.iconOpen && e.iconOpen.classList.toggle( 'hidden', open );
		e.iconClose && e.iconClose.classList.toggle( 'hidden', ! open );
		if ( open ) {
			e.close && e.close.focus();
		} else {
			e.toggle && e.toggle.focus();
		}
	}

	document.addEventListener( 'click', function ( ev ) {
		if ( ev.target.closest( '[data-nav-toggle]' ) ) {
			setOpen( true );
		} else if ( ev.target.closest( '[data-nav-close]' ) || ev.target.closest( '[data-nav-backdrop]' ) ) {
			setOpen( false );
		}
	} );

	document.addEventListener( 'keydown', function ( ev ) {
		if ( ev.key === 'Escape' ) {
			setOpen( false );
		}
	} );
} )();
