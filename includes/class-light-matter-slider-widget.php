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
                <li>
                    <img src="<?php echo $instance['image_uri']; ?>">
                </li>
                <li>
                    <img src="<?php echo plugin_dir_url(__DIR__); ?>assets/img/moon.jpg">
                </li>
                <li>
                    <img src="<?php echo plugin_dir_url(__DIR__); ?>assets/img/astronaut.jpg">
                </li>
                <li>
                    <img src="<?php echo plugin_dir_url(__DIR__); ?>assets/img/nebula.jpg">
                </li>
            </ul>
        </div>
    <?php
        echo $args['after_widget'];
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'text_domain' );
        $image_uri = ! empty( $instance['image_uri'] ) ? $instance['image_uri'] : __( '', 'text_domain' );

        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <input type="text" class=" img" name="<?php echo $this->get_field_name('image_uri'); ?>" id="<?php echo $this->get_field_id('image_uri'); ?>" value="<?php echo esc_attr($image_uri); ?>" />
            <a class="button button-hero choose-image-button">Choose an Image</a>

        </p>

    <?php }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['image_uri'] = ( ! empty( $new_instance['image_uri'] ) ) ? strip_tags( $new_instance['image_uri'] ) : '';

        return $instance;
    }
}