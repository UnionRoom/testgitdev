jQuery(document).ready(function ($) {

    $('.js-toggle-schema').on('click', function (e) {
        e.preventDefault();
        var schema_id = $(this).data('id');
        $('#schema-preview-' + schema_id).toggle();
        if($('#schema-preview-' + schema_id).css('display') == 'none' ){
            console.log('yes');
            $(this).html('Show scheme preview');
        } else {
            $(this).html('Hide scheme preview');
        }
    });


    //Button shortcode
    tinymce.PluginManager.add('button_shortcode', function (editor, url) {
        editor.addButton('button_shortcode', {
            icon: 'mce-button-icon',
            title: 'Button',
            text: '',
            onclick: function () {
                editor.windowManager.open({
                    title: 'Button',
                    body: [{
                        type: 'textbox',
                        name: 'buttontext',
                        label: 'Text',
                        value: ''
                    }, {
                        type: 'textbox',
                        name: 'buttonlink',
                        label: 'Link',
                        value: ''
                    }, {
                        type: 'textbox',
                        name: 'buttonstyle',
                        label: 'Class',
                        value: ''
                    }],
                    onsubmit: function (e) {
                        editor.insertContent(
                            '[button text=&quot;' +
                            e.data.buttontext +
                            '&quot; link=&quot;' +
                            e.data.buttonlink +
                            '&quot; class=&quot;' +
                            e.data.buttonstyle +
                            '&quot;]'
                        );
                    }
                });
            }
        });
    });
});
