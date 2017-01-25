<?php

/**
 * Created by PhpStorm.
 * User: Leopoldo
 * Date: 25/01/2017
 * Time: 19:08
 */
class PagoSeguro_Widget extends WP_Widget
{
    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        $widget_ops = array(
            'classname' => 'my_widget',
            'description' => 'My Widget is awesome',
        );
        parent::__construct( 'my_widget', 'My Widget', $widget_ops );
    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        // outputs the content of the widget
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     * @return string|void
     */
    public function form( $instance ) {
        // outputs the options form on admin
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     * @return array|void
     */
    public function update( $new_instance, $old_instance ) {
        // processes widget options to be saved
    }
}