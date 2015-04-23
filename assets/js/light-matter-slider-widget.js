jQuery(document).ready(function($) {
    $(document).on("click", ".choose-image-button", function(e) {
        e.preventDefault();
        var custom_uploader = wp.media({
            title: 'Select an image for the slider',
            button: {
                text: 'Choose image'
            },
            multiple: false  // Set this to true to allow multiple files to be selected
        }).open();
    });
});