<?php
/*
The file contain functions for Woocommerce.
*/

/* Shop Settings */
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

// Change columns count
add_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {
    function loop_columns() {
        return 4; // 4 products per row
    }
}

/* Product Page Design */
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 15);
add_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_rating', 20);
add_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 15);
add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_title', 15);
add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_price', 20 );


// WooCommerce Cart Functions in Menu
function thelawyer_cartcount() {
    global $woocommerce;
    if (class_exists('WC_Integration')) {
        $cart_url = wc_get_cart_url();
        $cart_contents_count = $woocommerce->cart->cart_contents_count;
        $cart_contents = sprintf(_n('%d item', '%d items', $cart_contents_count, 'the-lawyer'), $cart_contents_count);
        $cart_total = $woocommerce->cart->get_cart_total();

        echo '<li class="cart">';
        if ($cart_contents_count > 0) {
            echo '<span class="count">' . $cart_contents_count . '</span>';
        }
        echo '<a href="' . $cart_url . '"><span class="icon-shopping-cart"></span></a><div><h4>' . esc_attr__('Cart Totals', 'the-lawyer') . '</h4>
               <div>' . $cart_contents . '
               <strong>' . $cart_total . '</strong></div>
               <a href="' . $cart_url . '" class="btn btn-sm btn-primary">' . esc_attr__('View cart', 'the-lawyer') . '</a>
          </div></li>';
    }
}

// Cart icon in menu
function thelawyer_cart_menu() {
    global $secretlab;
    if (isset ($secretlab['shop_cart_menu'])) {
        $sl_shop_cart_menu = $secretlab['shop_cart_menu'];
        if ($sl_shop_cart_menu == 1) {
            thelawyer_cartcount();
        }
    }
}

// WooCommerce SHORT Cart Functions in Menu
function thelawyer_cartcount_short() {
    global $woocommerce;
    if (class_exists('WC_Integration')) {
        $cart_url = wc_get_cart_url();
        $cart_contents_count = $woocommerce->cart->cart_contents_count;
        echo '<li class="cart">';
        if ($cart_contents_count > 0) {
            echo '<span class="count">' . $cart_contents_count . '</span>';
        }
        echo '<a href="' . $cart_url . '"><span class="icon-shopping-cart"></span></a></li>';
    }
}

// SHORT Cart icon in menu
function thelawyer_cart_menu_short() {
    global $secretlab;
    if (isset ($secretlab['shop_cart_menu'])) {
        $sl_shop_cart_menu = $secretlab['shop_cart_menu'];
        if ($sl_shop_cart_menu == 1) {
            thelawyer_cartcount_short ();
        }
    }
}
?>
