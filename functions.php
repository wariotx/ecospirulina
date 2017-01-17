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
    //Sticky Header
    wp_enqueue_script( 'sticky-kit', get_stylesheet_directory_uri() . '/assets/js/sticky-kit.min.js', array( 'jquery' ), '1.0.0' );
    wp_enqueue_script( 'espire-sticky-navigation', get_stylesheet_directory_uri() . '/assets/js/sticky-navigation.js', array( 'jquery', 'sticky-kit' ), $the_theme->get( 'Version' ) );
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
add_filter( 'storefront_credit_link', '__return_false' );
add_action( 'wp', 'espirulina_wc_tweaks', 999 );
function espirulina_wc_tweaks() {
    if (class_exists('WooCommerce')) {
        if(is_woocommerce()){
            add_filter( 'body_class', function ( $classes ) {
                if( isset($classes['left-sidebar']) ) {
                    unset($classes['left-sidebar']);
                }
                if( isset($classes['right-sidebar']) ) {
                    unset($classes['right-sidebar']);
                }
                $key = array_search( 'storefront-full-width-content', $classes );
                if ( false === $key ) {
                    $classes[] = 'storefront-full-width-content';
                }
                return $classes;
            });
        }
    }
}
add_filter( 'wpseo_hide_version', '__return_true' );
add_filter( 'storefront_header_styles', function( $styles ) {
    if( isset($styles['background-image']) ) {
        unset($styles['background-image']);
    };
    return $styles;
});
add_action('init', function (){
    if (class_exists('WooCommerce')) {
        if (is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag()) {
            remove_action('storefront_sidebar', 'storefront_get_sidebar');
        }
        if (is_product()) {
            remove_action('storefront_sidebar', 'storefront_get_sidebar');
        }
    }
    remove_action('woocommerce_after_shop_loop', 'woocommerce_result_count', 20);
    remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
    remove_action('woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10);
    remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10);
});