/**
 * Theme Customizer Shift Key Click
 */
(function($, _, wp, api) {

    $(_panelIds).each(function(key, object_value) {
        if (object_value) {
            $(object_value).each(function(key, value) {
                if (value.selector != '') {
                    $(document).on('click', value.selector, function(event) {
                        //if (event.shiftKey) {
                            api.preview.send('responsi-focus-panel', value.settings);
                        //}
                    });
                }
            });
        }
    });

    $(_sectionIds).each(function(key, object_value) {
        if (object_value) {
            $(object_value).each(function(key, value) {
                if (value.selector != '') {
                    $(document).on('click', value.selector, function(event) {
                        //if (event.shiftKey) {
                            api.preview.send('responsi-focus-section', value.settings);
                        //}
                    });
                }
            });
        }
    });

    $(_controlIds).each(function(key, object_value) {
        if (object_value) {
            $(object_value).each(function(key, value) {
                if (value.selector != '') {
                    $(document).on('click', value.selector, function(event) {
                        //if (event.shiftKey) {
                            api.preview.send('responsi-focus-control', value.settings);
                        //}
                    });
                }
            });
        }
    });

}(jQuery, _, wp, wp.customize));