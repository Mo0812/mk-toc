/**
 * Created by mkanzler on 02.08.17.
 */
(function() {
    tinymce.PluginManager.add('mk_toc', function(editor, url) {

        // Add a button that opens a window
        editor.addButton('mk_toc_sc_button_key', {
            tooltip: 'MK Table of Contents einfügen',
            //image: url + '/../assets/',
            icon: 'icon dashicons-text',
            onclick: function() {
                editor.windowManager.open({
                    title: 'MK Table of Contents Settings1',
                    body: [
                        {
                            type: 'textbox',
                            name: 'toc_title',
                            label: 'Header'
                        },
                        {
                            type: 'listbox',
                            values: [{text: '-', value: ''},{text: '2', value: '2'}, {text: '3', value: '3'},{text: '4', value: '4'},{text: '5', value: '5'}],
                            name: 'toc_level_begin',
                            label: 'Headline level to start with',
                            onPostRender: function() {
                                toc_level_begin = this;
                            }
                        },
                        {
                            type: 'listbox',
                            values: [{text: '-', value: ''},{text: '2', value: '2'}, {text: '3', value: '3'},{text: '4', value: '4'},{text: '5', value: '5'}],
                            name: 'toc_level_end',
                            label: 'Headline level to end with',
                            onPostRender: function() {
                                toc_level_end = this;
                            }
                        }
                    ],
                    width: 450,
                    height: 200,
                    onsubmit: function(e) {
                        var tt = ''; var tlb = ''; var tle = '';
                        if(e.data.toc_title != "") {
                            tt = ' title="' + e.data.toc_title + '"';
                        }
                        if(toc_level_begin.value() !== "") {
                            tlb = ' level_begin="' + toc_level_begin.value() + '"';
                        }
                        if(toc_level_end.value() != "") {
                            tle = ' level_end="' + toc_level_end.value() + '"';
                        }
                        editor.insertContent('[toc' + tt + tlb + tle + ']');
                    }

                });
            }
        });

    });

})();