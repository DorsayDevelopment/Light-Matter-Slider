jQuery(document).ready(function($) {
    $(".choose-image-button").click(function(e) {
        var button = this;

        e.preventDefault();

        var custom_uploader = wp.media({
            title: 'Select an image for the slider',
            button: {  text: 'Choose image' },
            library: { type: 'image' },
            multiple: false  // Set this to true to allow multiple files to be selected
        }).on('select', function() {
            var image = custom_uploader.state().get('selection').first().toJSON();
            $(button).prev().val(image.url);
        }).open();
    });
});