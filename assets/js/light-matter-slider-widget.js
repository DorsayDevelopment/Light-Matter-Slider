jQuery(document).ready(function($) {
    $(document).on("click", ".choose-image-button", function(e) {
        e.preventDefault();
        var custom_uploader = wp.media({
            title: 'Custom Title',
            button: {
                text: 'Custom Button Text'
            },
            multiple: false  // Set this to true to allow multiple files to be selected
        }).open();
    });
});