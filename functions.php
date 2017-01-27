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
        if (is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag()) {
            remove_action('storefront_sidebar', 'storefront_get_sidebar');
        }
        if (is_product()) {
            remove_action('storefront_sidebar', 'storefront_get_sidebar');
        }
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
    remove_action('woocommerce_after_shop_loop', 'woocommerce_result_count', 20);
    remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
    remove_action('woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10);
    remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10);
    if ( function_exists('yoast_breadcrumb') ) {
        remove_action( 'storefront_content_top',   'woocommerce_breadcrumb',   10 );
        add_action( 'storefront_content_top',   function() {
            yoast_breadcrumb('<p id="breadcrumbs" class="woocommerce-breadcrumb">','</p>');
        },   10 );
    }
    add_action( 'woocommerce_login_form_end', function () {
        echo <<<JS
		<script type="text/javascript">
			var checkbox = document.getElementById('rememberme');
			if ( null != checkbox )
				checkbox.checked = true;
		</script>
JS;
    });
    // Change number or products per row to 3
    add_filter('loop_shop_columns', function() {
            return 4; // 3 products per row
    });
    add_action( 'wp_footer', function (){
?><style type="text/css">@media (min-width:768px) {.site-main ul.products li.product {width: 20.58823529% !important;}}</style><?php
    });
    add_action( 'storefront_header', function () {
?><div class='account_lnk'><?php if ( is_user_logged_in() ) { ?>
<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('My Account','woocommerce'); ?>"><?php _e('My Account','woocommerce'); ?></a>
<?php } else { ?>
<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('Login','woocommerce');echo " / ";_e('Register','woocommerce'); ?>"><?php _e('Login','woocommerce');echo " / ";_e('Register','woocommerce');?></a>
<?php } ?></div>
<?php
    }, 61);
    add_action( 'storefront_header', function () {
        echo "<div class='sticky-bg'></div>";
        echo "<style type='text/css'>
.sticky-nav .sticky-bg {
    display: none;
}
.sticky-nav.is_stuck .sticky-bg {
display: block;
position: absolute;
top: 0;
background: #fff;
height: 100%;
width: 112%;
margin-left: -6%;
z-index: -1;
box-shadow: 0 0 2px 1px rgba(0,0,0,.5);}</style>";
    }, 65);
    add_action('espirulina_home_page', 'storefront_page_content',           20);
    add_action('espirulina_home_page', 'storefront_init_structured_data',   30);
});
if ( ! function_exists( 'espirulina_homepage_content' ) ) {
    /**
     * Display homepage content
     * Hooked into the `homepage` action in the homepage template
     *
     * @since  1.0.0
     * @return  void
     */
    function espirulina_homepage_content() {
        while ( have_posts() ) {
            the_post();

            get_template_part( 'content', 'home' );

        } // end of the loop.
    }
}