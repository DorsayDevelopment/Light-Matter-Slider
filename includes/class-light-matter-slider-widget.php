<?php
/**
 * Created by PhpStorm.
 * User: Brycen
 * Date: 2015-04-22
 * Time: 2:21 AM
 */


class Light_Matter_Slider_Widget extends WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        parent::__construct(
            'light_matter_slider_widget',
            'Light Matter Full Screen Slider',
            array('description' => 'Light Matter Slider')
        );

        add_action('admin_enqueue_scripts', array($this, 'plugin_admin_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'plugin_regular_scripts'));
        add_action('admin_enqueue_scripts', array($this, 'plugin_styles'));
        add_action('wp_enqueue_styles', array($this, 'plugin_styles'));
    }

    // Scripts for admin page
    public function plugin_admin_scripts() {
        wp_enqueue_media();
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_enqueue_script('light_matter_slider_widget', plugin_dir_url(__DIR__) . 'assets/js/light-matter-slider-widget.js', array('jquery'));
    }

    // Scripts for widget
    public function plugin_regular_scripts() {
        wp_deregister_script('jquery'); //Get rid of existing wordpress jquery 1.1.1
        wp_register_script('jquery', plugin_dir_url(__DIR__) . 'assets/jquery/jquery-2.1.3.min.js');
        wp_register_script('materialize', plugin_dir_url(__DIR__) . 'assets/materialize/js/materialize.min.js', array('jquery'), false, true);
        wp_enqueue_script('jquery');
        wp_enqueue_script('materialize');
    }

    public function plugin_styles()
    {
        wp_enqueue_style('thickbox');
        wp_enqueue_style('light_matter_slider_widget', plugin_dir_url(__DIR__) . 'assets/css/light-matter-slider-widget.css');
    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        echo $args['before_widget'];

        ?>
        <div class="slider fullscreen">
            <ul class="slides">
                <?php for($i = 0; $i < count($instance['image_uri']); $i++) { ?>
                    <li>
                        <img src="<?php echo $instance['image_uri'][$i]; ?>">
                    </li>
                <?php } ?>
            </ul>
        </div>
    <?php
        echo $args['after_widget'];
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     * @return string|void
     */
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $image_uri = isset($instance['image_uri']) ? $instance['image_uri'] : [];
        $image_num = count($image_uri);
        $image_uri[$image_num + 1] = '';
        $image_html = [];
        $image_counter = 0;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>

        <?php
        foreach($image_uri as $name => $value) {
            $image_html[] = sprintf(
                '<p><input type="text" class="widefat" name="%1$s[%2$s]" value="%3$s"/>
                <a class="button choose-image-button">Choose an Image</a>
                <a class="button remove-image-button widget-control-save">Remove</a>',
                $this->get_field_name('image_uri'),
                $image_counter,
                esc_attr($value)
            );
            $image_counter += 1;
        }

        print 'Images:' . join('<br />', $image_html);
        ?>


    <?php }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     * @return array
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['image_uri'] = [];

        if(isset($new_instance['image_uri'])) {
            foreach($new_instance['image_uri'] as $value) {
                if('' !== trim($value)) {
                    $instance['image_uri'][] = $value;
                }
            }
        }

        return $instance;
    }
}