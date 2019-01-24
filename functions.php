<?php

function theme_enqueue_styles() {
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'avada-stylesheet' ) );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function avada_lang_setup() {
	$lang = get_stylesheet_directory() . '/languages';
	load_child_theme_textdomain( 'Avada', $lang );
}
add_action( 'after_setup_theme', 'avada_lang_setup' );

add_action( 'plugins_loaded', 'teccc_load_options_class', 20 );
function teccc_load_options_class() {
	if ( class_exists( '\\Fragen\\Category_Colors\\Main' ) && class_exists( 'Tribe__Events__Main' ) ) {
		new Category_Colors_Options();
	}
}
class Category_Colors_Options {
	public function __construct() {
		teccc_add_text_color( 'Red', '#f00' );
		//teccc_ignore_slug( 'just-show-up', 'conference' );
		teccc_add_legend_view( 'list' );
		//teccc_add_legend_view( 'upcoming' );
		teccc_add_legend_view( 'photo' );
		teccc_add_legend_view( 'week' );
		//teccc_reposition_legend( 'tribe_events_before_footer' );
		//teccc_remove_default_legend();
		add_filter( 'teccc_legend_html', array( $this, 'add_legend_explanation' ) );
		add_action( 'teccc_add_legend_css', array( $this, 'my_legend_css' ) );
	}
	public function add_legend_explanation( $html ) {
		echo '<div class="legend-explanation"> To focus on events from only one of these categories, just click on the relevant label. </div>' . $html;
	}
	public function my_legend_css() {
		echo '#legend li { font-variant: small-caps; }';
	}
}

function redirect_to_specific_page() {
   global $post;
   $postid = get_the_ID();
   $postslug = esc_url( Tribe__Events__Main::instance()->getLink() );
   global $wp;
$wat = home_url( $wp->request )."/";


   if ($postslug == $wat)  {
   wp_redirect( get_site_url().'/ajankohtaista-ohjaamossa/ohjaamossa-tapahtuu', 302 ); 
      exit;
   }
}
add_action( 'template_redirect', 'redirect_to_specific_page' );


function show_template() {
	if( is_super_admin() ){
		 global $template;
		 print_r($template);
	} 
}
add_action('wp_footer', 'show_template');