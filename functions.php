<?php
add_action( 'after_setup_theme', 'crb_loads' );
function crb_loads() {
    require_once( 'vendor/autoload.php' );
    \Carbon_Fields\Carbon_Fields::boot();
    if ( class_exists( 'App\\Init' ) ) :
        App\Init::register_services();
    endif;
}