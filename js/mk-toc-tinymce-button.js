/**
 * Created by mkanzler on 02.08.17.
 */
(function() {
    tinymce.PluginManager.add('mk_toc', function(editor, url) {

        // Add a button that opens a window
        editor.addButton('mk_toc_sc_button_key', {
            text: 'TOC',
            icon: false,
            onclick: function() {
                editor.windowManager.open({
                    title: 'Example plugin',
                    body: [{
                        type: 'textbox',
                        name: 'title',
                        label: 'Title'
                    }],
                    onsubmit: function(e) {
                        editor.insertContent('[toc title="' + e.data.title + '"]');
                    }

                });
            }
        });

    });

})();