/**
 * Block editor document panel: legacy custom-fields init + sync edits so Save enables;
 * re-inits when the panel DOM is remounted (collapse/expand).
 */
( function ( wp ) {
	if ( ! wp || ! wp.plugins || ! wp.data || ! wp.apiFetch ) {
		return;
	}

	var registerPlugin = wp.plugins.registerPlugin;
	var PluginDocumentSettingPanel = wp.editPost.PluginDocumentSettingPanel;
	var el = wp.element.createElement;
	var Fragment = wp.element.Fragment;
	var useEffect = wp.element.useEffect;
	var useLayoutEffect = wp.element.useLayoutEffect;
	var useState = wp.element.useState;
	var useRef = wp.element.useRef;
	var useCallback = wp.element.useCallback;
	var apiFetch = wp.apiFetch;
	var useSelect = wp.data.useSelect;

	function runResponsiMetaboxLegacyDocumentReadySequence() {
		if ( ! window.jQuery || ! window.responsiCustomFields ) {
			return;
		}
		var r = responsiCustomFields;

		r.adjust_form_encoding();
		r.setup_wordcounters();
		r.setup_image_selectors();
		r.setup_meta_image_selectors_click();
		r.setup_upload_titletest();
		try {
			r.setup_field_tabber();
		} catch ( err ) {}
		r.setup_rand_slider();
	}

	function refreshSlidersInRoot( root ) {
		if ( ! root || ! window.jQuery || ! window.responsiCustomFields ) {
			return;
		}
		var $ = window.jQuery;
		$( '.responsi-range-slider', root ).each( function () {
			var $wrap = $( this );
			$wrap.removeClass( 'applied_slider' );
			var $slide = $wrap.find( '.ui-slide' );
			if ( $slide.length && $slide.data( 'ui-slider' ) ) {
				try {
					$slide.slider( 'destroy' );
				} catch ( err ) {}
			}
		} );
		responsiCustomFields.setup_rand_slider();
	}

	function collectFieldsFromRoot( root ) {
		var data = {};
		if ( ! root || ! root.querySelectorAll ) {
			return data;
		}
		var inputs = root.querySelectorAll( 'input[name], select[name], textarea[name]' );
		for ( var i = 0; i < inputs.length; i++ ) {
			var input = inputs[ i ];
			var name = input.name;
			if ( ! name || name === 'responsi-metabox-custom-fields-nonce' ) {
				continue;
			}
			var type = ( input.type || '' ).toLowerCase();
			if ( type === 'radio' ) {
				if ( input.checked ) {
					data[ name ] = input.value;
				}
			} else if ( type === 'checkbox' ) {
				data[ name ] = input.checked ? 'true' : 'false';
			} else {
				data[ name ] = input.value;
			}
		}
		return data;
	}

	function pushFrameworkEditsToEditor() {
		var root = document.getElementById( 'responsi-framework-be-root-inner' );
		if ( ! root || ! wp.data ) {
			return;
		}
		var fields = collectFieldsFromRoot( root );
		if ( ! Object.keys( fields ).length ) {
			return;
		}
		try {
			var select = wp.data.select( 'core/editor' );
			var dispatch = wp.data.dispatch( 'core/editor' );
			var prevMeta = select.getEditedPostAttribute( 'meta' );
			var metaBase =
				prevMeta && typeof prevMeta === 'object' && ! Array.isArray( prevMeta )
					? Object.assign( {}, prevMeta )
					: {};
			metaBase.responsi_mb_touch = String( Date.now() );
			dispatch.editPost( {
				responsi_framework_fields: fields,
				meta: metaBase,
			} );
		} catch ( err ) {}
	}

	function normalizeApiPath( path ) {
		if ( ! path || typeof path !== 'string' ) {
			return '';
		}
		return path.indexOf( '/' ) === 0 ? path : '/' + path;
	}

	apiFetch.use( function ( options, next ) {
		var method = ( options.method || 'GET' ).toUpperCase();
		if ( method !== 'POST' && method !== 'PUT' && method !== 'PATCH' ) {
			return next( options );
		}
		if ( ! options.data || typeof options.data !== 'object' ) {
			return next( options );
		}
		var path = normalizeApiPath( options.path || '' );
		var pathNoQuery = path.split( '?' )[ 0 ];
		var updateMatch = pathNoQuery.match( /^\/wp\/v2\/[^/]+\/(\d+)$/ );
		var postIdFromPath = updateMatch ? parseInt( updateMatch[ 1 ], 10 ) : null;
		var parts = pathNoQuery.replace( /^\/+/, '' ).split( '/' ).filter( Boolean );
		var isCreatePost =
			method === 'POST' &&
			parts.length === 3 &&
			parts[ 0 ] === 'wp' &&
			parts[ 1 ] === 'v2' &&
			parts[ 2 ] !== 'settings' &&
			parts[ 2 ] !== 'block-renderer' &&
			parts[ 2 ] !== 'menu-items' &&
			parts[ 2 ] !== 'templates';

		var currentId;
		try {
			currentId = wp.data.select( 'core/editor' ).getCurrentPostId();
		} catch ( err ) {
			return next( options );
		}

		var allowInject = false;
		if ( postIdFromPath ) {
			allowInject = currentId && postIdFromPath === currentId;
		} else if ( isCreatePost ) {
			allowInject = ! currentId;
		}

		if ( ! allowInject ) {
			return next( options );
		}
		if ( typeof window.responsiFrameworkCollectFields !== 'function' ) {
			return next( options );
		}
		var fields = window.responsiFrameworkCollectFields();
		if ( fields && Object.keys( fields ).length ) {
			options.data.responsi_framework_fields = fields;
		}
		return next( options );
	} );

	function FrameworkPanel() {
		var postId = useSelect( function ( select ) {
			return select( 'core/editor' ).getCurrentPostId();
		}, [] );

		var htmlState = useState( '' );
		var html = htmlState[ 0 ];
		var setHtml = htmlState[ 1 ];
		var errState = useState( null );
		var err = errState[ 0 ];
		var setErr = errState[ 1 ];

		var rootNodeRef = useRef( null );
		var syncTimerRef = useRef( null );

		var syncEditsDebounced = useCallback( function () {
			if ( syncTimerRef.current ) {
				window.clearTimeout( syncTimerRef.current );
			}
			syncTimerRef.current = window.setTimeout( function () {
				syncTimerRef.current = null;
				pushFrameworkEditsToEditor();
			}, 120 );
		}, [] );

		var teardownRoot = useCallback( function ( containerEl ) {
			if ( ! containerEl || ! containerEl._responsiFieldListener ) {
				return;
			}
			var handler = containerEl._responsiFieldListener;
			containerEl.removeEventListener( 'input', handler, true );
			containerEl.removeEventListener( 'change', handler, true );
			containerEl.removeEventListener( 'keyup', handler, true );
			containerEl.removeEventListener( 'click', handler, true );
			delete containerEl._responsiFieldListener;
		}, [] );

		var attachFieldListeners = useCallback(
			function ( containerEl ) {
				if ( ! containerEl || containerEl._responsiFieldListener ) {
					return;
				}
				var handler = function () {
					syncEditsDebounced();
				};
				containerEl._responsiFieldListener = handler;
				containerEl.addEventListener( 'input', handler, true );
				containerEl.addEventListener( 'change', handler, true );
				containerEl.addEventListener( 'keyup', handler, true );
				containerEl.addEventListener( 'click', handler, true );
			},
			[ syncEditsDebounced ]
		);

		var runInitOnContainer = useCallback( function ( containerEl ) {
			if ( ! containerEl ) {
				return;
			}
			window.requestAnimationFrame( function () {
				runResponsiMetaboxLegacyDocumentReadySequence();
				window.setTimeout( function () {
					refreshSlidersInRoot( containerEl );
				}, 280 );
			} );
		}, [] );

		var setRootRef = useCallback(
			function ( containerEl ) {
				var prev = rootNodeRef.current;
				if ( prev && prev !== containerEl ) {
					teardownRoot( prev );
				}
				rootNodeRef.current = containerEl;
				if ( containerEl ) {
					attachFieldListeners( containerEl );
					runInitOnContainer( containerEl );
				} else if ( ! containerEl && prev ) {
					teardownRoot( prev );
				}
			},
			[ teardownRoot, attachFieldListeners, runInitOnContainer ]
		);

		useEffect(
			function () {
				if ( ! postId ) {
					return;
				}
				setErr( null );
				var path = 'responsi/v1/framework-metabox/' + postId;
				apiFetch( { path: path } )
					.then( function ( res ) {
						setHtml( res && res.html ? res.html : '' );
					} )
					.catch( function ( e ) {
						setHtml( '' );
						setErr( e && e.message ? e.message : 'Error' );
					} );
			},
			[ postId ]
		);

		useLayoutEffect(
			function () {
				if ( ! html ) {
					return;
				}
				var node = rootNodeRef.current;
				if ( node ) {
					runInitOnContainer( node );
				}
			},
			[ html, runInitOnContainer ]
		);

		useEffect( function () {
			window.responsiFrameworkCollectFields = function () {
				var root = document.getElementById( 'responsi-framework-be-root-inner' );
				return collectFieldsFromRoot( root );
			};
			return function () {
				if ( syncTimerRef.current ) {
					window.clearTimeout( syncTimerRef.current );
				}
				if ( window.responsiFrameworkCollectFields ) {
					delete window.responsiFrameworkCollectFields;
				}
				var n = rootNodeRef.current;
				if ( n ) {
					teardownRoot( n );
				}
			};
		}, [ teardownRoot ] );

		var title =
			window.responsiFrameworkMetaboxEditor && responsiFrameworkMetaboxEditor.title
				? responsiFrameworkMetaboxEditor.title
				: 'Framework';

		return el(
			PluginDocumentSettingPanel,
			{
				name: 'responsi-framework-panel',
				title: title,
				className: 'responsi-framework-document-panel',
			},
			err
				? el( 'p', { className: 'responsi-framework-be-error' }, err )
				: null,
			el( 'div', {
				ref: setRootRef,
				id: 'responsi-framework-be-root-inner',
				className: 'responsi-framework-be-root-inner',
				dangerouslySetInnerHTML: { __html: html },
			} )
		);
	}

	registerPlugin( 'responsi-framework-metabox', {
		icon: 'layout',
		render: function () {
			return el( Fragment, null, el( FrameworkPanel, null ) );
		},
	} );
} )( window.wp );
