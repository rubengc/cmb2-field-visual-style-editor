(function($){
    $('body').on('click', '.cmb2-visual-style-editor-field-switch .button', function(e) {
        e.preventDefault();

        var container = $(this).closest('.cmb2-visual-style-editor-container');

        // Reset all values on change mode
        container.find('> .cmb2-visual-style-editor-field input').val('');

        if( container.hasClass('cmb2-visual-style-editor-multiple') ) {
            container.removeClass('cmb2-visual-style-editor-multiple').addClass('cmb2-visual-style-editor-single');
        } else {
            container.removeClass('cmb2-visual-style-editor-single').addClass('cmb2-visual-style-editor-multiple');
        }
    });

    $('body').on('click', '.cmb2-visual-style-editor-field-switch-all .button', function(e) {
        $(this).closest('.cmb2-visual-style-editor').find('.cmb2-visual-style-editor-field-switch .button').trigger('click');
    });

    $('.cmb2-visual-style-editor-field .cmb2-visual-style-editor-color-picker').wpColorPicker();
})(jQuery);