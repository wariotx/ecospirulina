<?php
function espirulina_remove_scripts() {
    wp_dequeue_style( 'storefront-style' );
    wp_deregister_style( 'storefront-style' );

    wp_dequeue_style( 'storefront-woocommerce-style' );
    wp_deregister_style( 'storefront-woocommerce-style' );

    // Get the theme data
    $the_theme = wp_get_theme();
    wp_enqueue_style( 'espire-styles', get_stylesheet_directory_uri() . '/assets/sass/woocommerce/woocommerce.css', array(), $the_theme->get( 'Version' ) );
//    wp_dequeue_script( 'understrap-scripts' );
//    wp_deregister_script( 'understrap-scripts' );

    // Removes the parent themes stylesheet and scripts from inc/enqueue.php
}
add_action( 'wp_enqueue_scripts', 'espirulina_remove_scripts', 25 );

//add_action( 'wp_enqueue_scripts', 'espirulina_enqueue_styles', 25 );
function espirulina_enqueue_styles() {

    // Get the theme data
    $the_theme = wp_get_theme();

    wp_enqueue_style( 'espire-styles', get_stylesheet_directory_uri() . '/style.css', array(), $the_theme->get( 'Version' ) );
//    wp_enqueue_style( 'espire-styles', get_stylesheet_directory_uri() . '/css/espire.min.css', array(), $the_theme->get( 'Version' ) );
//    wp_enqueue_script( 'espire-scripts', get_stylesheet_directory_uri() . '/js/espire.min.js', array(), $the_theme->get( 'Version' ), true );
}
// Remove each style one by one
//add_filter( 'woocommerce_enqueue_styles', 'espirulina_dequeue_styles' );
function espirulina_dequeue_styles( $enqueue_styles ) {
    unset( $enqueue_styles['woocommerce-general'] );	// Remove the gloss
//    unset( $enqueue_styles['woocommerce-layout'] );		// Remove the layout
//    unset( $enqueue_styles['woocommerce-smallscreen'] );	// Remove the smallscreen optimisation
    return $enqueue_styles;
}