<?php
/**
 * Plugin Name: Light Matter Slider Widget
 * Plugin URI: http://brycendorsay.com/projects/web/6
 * Description: A full screen slider widget
 * Version: 0.1
 * Author: Dorsay Development
 * Author URI: http://brycendorsay.com
 */

require_once('includes/class-light-matter-slider-widget.php');
// register Slider_Widget widget
function register_slider_widget() {
    register_widget( 'Light_Matter_Slider_Widget' );
}
add_action( 'widgets_init', 'register_slider_widget' );