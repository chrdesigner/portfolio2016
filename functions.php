<?php
/**
 * Odin functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * For more information on hooks, actions, and filters,
 * see http://codex.wordpress.org/Plugin_API
 *
 * @package Odin
 * @since 2.2.0
 */

/**
 * Sets content width.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 600;
}

/**
 * Odin Classes.
 */
require_once get_template_directory() . '/core/classes/class-bootstrap-nav.php';
require_once get_template_directory() . '/core/classes/class-shortcodes.php';
require_once get_template_directory() . '/core/classes/class-thumbnail-resizer.php';
require_once get_template_directory() . '/core/classes/class-theme-options.php';
require_once get_template_directory() . '/core/classes/class-post-type.php';
require_once get_template_directory() . '/core/classes/class-metabox.php';
require_once get_template_directory() . '/core/classes/class-taxonomy.php';
// require_once get_template_directory() . '/core/classes/abstracts/abstract-front-end-form.php';
// require_once get_template_directory() . '/core/classes/class-contact-form.php';
//require_once get_template_directory() . '/core/classes/class-shortcodes-menu.php';
// require_once get_template_directory() . '/core/classes/class-options-helper.php';
// require_once get_template_directory() . '/core/classes/class-post-form.php';
// require_once get_template_directory() . '/core/classes/class-user-meta.php';
// require_once get_template_directory() . '/core/classes/class-post-status.php';
//require_once get_template_directory() . '/core/classes/class-term-meta.php';

/**
 * Odin Widgets.
 */
require_once get_template_directory() . '/core/classes/widgets/class-widget-like-box.php';

if ( ! function_exists( 'odin_setup_features' ) ) {

	/**
	 * Setup theme features.
	 *
	 * @since 2.2.0
	 */
	function odin_setup_features() {

		/**
		 * Add support for multiple languages.
		 */
		load_theme_textdomain( 'odin', get_template_directory() . '/languages' );

		/**
		 * Register nav menus.
		 */
		register_nav_menus(
			array(
				'main-menu' => __( 'Main Menu', 'odin' )
			)
		);

		/*
		 * Add post_thumbnails suport.
		 */
		add_theme_support( 'post-thumbnails' );

		/**
		 * Add feed link.
		 */
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Support Custom Header.
		 */
		$default = array(
			'width'         => 0,
			'height'        => 0,
			'flex-height'   => false,
			'flex-width'    => false,
			'header-text'   => false,
			'default-image' => '',
			'uploads'       => true,
		);

		add_theme_support( 'custom-header', $default );

		/**
		 * Support Custom Background.
		 */
		$defaults = array(
			'default-color' => '',
			'default-image' => '',
		);

		add_theme_support( 'custom-background', $defaults );

		/**
		 * Support Custom Editor Style.
		 */
		add_editor_style( 'assets/css/editor-style.css' );

		/**
		 * Add support for infinite scroll.
		 */
		add_theme_support(
			'infinite-scroll',
			array(
				'type'           => 'scroll',
				'footer_widgets' => false,
				'footer' 		 => false,
				'container'      => 'content',
				'wrapper'        => false,
				'render'         => false,
				'posts_per_page' => get_option( 'posts_per_page' )
			)
		);

		/**
		 * Add support for Post Formats.
		 */
		// add_theme_support( 'post-formats', array(
		//     'aside',
		//     'gallery',
		//     'link',
		//     'image',
		//     'quote',
		//     'status',
		//     'video',
		//     'audio',
		//     'chat'
		// ) );

		/**
		 * Support The Excerpt on pages.
		 */
		// add_post_type_support( 'page', 'excerpt' );

		/**
		 * Switch default core markup for search form, comment form, and comments to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption'
			)
		);

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );
	}
}

add_action( 'after_setup_theme', 'odin_setup_features' );

/**
 * Register widget areas.
 *
 * @since 2.2.0
 */
function odin_widgets_init() {
	register_sidebar(
		array(
			'name' => __( 'Main Sidebar', 'odin' ),
			'id' => 'main-sidebar',
			'description' => __( 'Site Main Sidebar', 'odin' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widgettitle widget-title">',
			'after_title' => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name' => __( 'Facebook Box', 'odin' ),
			'id' => 'footer-facebook',
			'description' => __( 'Site Facebook Box', 'odin' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '',
			'after_title' => '',
		)
	);
}

add_action( 'widgets_init', 'odin_widgets_init' );

/**
 * Flush Rewrite Rules for new CPTs and Taxonomies.
 *
 * @since 2.2.0
 */
function odin_flush_rewrite() {
	flush_rewrite_rules();
}

add_action( 'after_switch_theme', 'odin_flush_rewrite' );

/**
 * Load site scripts.
 *
 * @since 2.2.0
 */

define( 'ODIN_GRUNT_SUPPORT', true );

function odin_enqueue_scripts() {
	$template_url = get_template_directory_uri();

	// Loads Odin main stylesheet.
	wp_enqueue_style( 'odin-style', get_stylesheet_uri(), array(), null, 'all' );

	wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', array(), null, 'all' );

	// jQuery.
	wp_enqueue_script( 'jquery' );

	// General scripts.
	if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
		// Bootstrap.
		wp_enqueue_script( 'bootstrap', $template_url . '/assets/js/libs/bootstrap.min.js', array(), null, true );

		// FitVids.
		wp_enqueue_script( 'fitvids', $template_url . '/assets/js/libs/jquery.fitvids.js', array(), null, true );

		// Main jQuery.
		wp_enqueue_script( 'odin-main', $template_url . '/assets/js/main.js', array(), null, true );
	} else {
		// Grunt main file with Bootstrap, FitVids and others libs.
		wp_enqueue_script( 'odin-main-min', $template_url . '/assets/js/main.min.js', array(), null, true );
	}

	// Grunt watch livereload in the browser.
	// wp_enqueue_script( 'odin-livereload', 'http://localhost:35729/livereload.js?snipver=1', array(), null, true );

	wp_enqueue_script( 'hoverIntent', 'http://cherne.net/brian/resources/jquery.hoverIntent.minified.js', array(), null, true );

	wp_register_style( 'jquery-ui-styles','https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.css' );
	wp_enqueue_style( 'jquery-ui-styles' );

	wp_enqueue_script( 'jquery-ui-autocomplete' );

	wp_register_script( 'my-autocomplete', $template_url . '/assets/js/libs/my-autocomplete.js', array( 'jquery', 'jquery-ui-autocomplete' ), '1.0', false );
	wp_localize_script( 'my-autocomplete', 'MyAutocomplete', array( 'url' => admin_url( 'admin-ajax.php' ) ) );
	wp_enqueue_script( 'my-autocomplete' );

	// Load Thread comments WordPress script.
	if ( is_singular() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'odin_enqueue_scripts', 1 );

/**
 * Odin custom stylesheet URI.
 *
 * @since  2.2.0
 *
 * @param  string $uri Default URI.
 * @param  string $dir Stylesheet directory URI.
 *
 * @return string      New URI.
 */
function odin_stylesheet_uri( $uri, $dir ) {
	return $dir . '/assets/css/style.css';
}

add_filter( 'stylesheet_uri', 'odin_stylesheet_uri', 10, 2 );

/**
 * Query WooCommerce activation
 *
 * @since  2.2.6
 *
 * @return boolean
 */
if ( ! function_exists( 'is_woocommerce_activated' ) ) {
	function is_woocommerce_activated() {
		return class_exists( 'woocommerce' ) ? true : false;
	}
}

/**
 * Core Helpers.
 */
require_once get_template_directory() . '/core/helpers.php';

/**
 * WP Custom Admin.
 */
require_once get_template_directory() . '/inc/admin.php';

/**
 * Comments loop.
 */
require_once get_template_directory() . '/inc/comments-loop.php';

/**
 * WP optimize functions.
 */
require_once get_template_directory() . '/inc/optimize.php';

/**
 * Custom template tags.
 */
require_once get_template_directory() . '/inc/template-tags.php';

/**
 * WooCommerce compatibility files.
 */
if ( is_woocommerce_activated() ) {
	add_theme_support( 'woocommerce' );
	require get_template_directory() . '/inc/woocommerce/hooks.php';
	require get_template_directory() . '/inc/woocommerce/functions.php';
	require get_template_directory() . '/inc/woocommerce/template-tags.php';
}

function portfolio_set() {

	$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
	
	//Criando o Post Type - Portfolio
    $port_cpt = new Odin_Post_Type(
        'Portfolio',
        'portfolio'
    );
    
    $port_cpt->set_labels(
        array(
            'menu_name' => __( 'Portfolio', 'odin' )
        )
    );

    $port_cpt->set_arguments(
        array(
            'supports'  => array( 'title', 'editor', 'thumbnail' ),
            'menu_icon' => 'dashicons-admin-customizer',
        )
    );

    //Criando o Post Type - Parceiros
    $parc_cpt = new Odin_Post_Type(
        'Parceiro',
        'partner'
    );
    
    $parc_cpt->set_labels(
        array(
            'menu_name' => __( 'Parceiro', 'odin' )
        )
    );

    $parc_cpt->set_arguments(
        array(
            'supports'  		  => array( 'title', 'thumbnail' ),
            'menu_icon' 		  => 'dashicons-groups',
            'public'			  => false,
            'exclude_from_search' => true,
        )
    );

    //Criando as Metabox - Portfolio
    $port_metabox = new Odin_Metabox(
        'portfolio_mb',
        'Informações Extras',
        'portfolio',
        'normal',
        'high'
    );

    $port_metabox->set_fields(
	    array(
	        array(
	            'id'          => 'link_projeto',
	            'label'       => __( 'URL Projeto', 'odin' ),
	            'type'        => 'input', // Required
				'attributes'  => array( // Optional (html input elements)
                    'type' => 'url'
                )
	        ),
	        array(
	            'id'          => 'link_agencia',
	            'label'       => __( 'URL Agência', 'odin' ),
	            'type'        => 'input', // Required
	            'attributes'  => array( // Optional (html input elements)
                    'type' => 'url'
                )
	        )
	    )
	);

	//Criando as Metabox - Portfolio
    $port_dest_metabox = new Odin_Metabox(
        'portfolio_destaque_mb',
        'Aplicar Destaque',
        'portfolio',
        'side',
        'core'
    );

    $port_dest_metabox->set_fields(
	    array(
	        array(
                'id'      => 'sticky_portfolio', // Required
                'label'   => __( 'Destacar', 'odin' ), // Required
                'type'    => 'radio', // Required
                'default' => 'no',
                'options' => array(
                	'yes'	=> 'Sim',
                	'no'	=> 'Não'
                ),
            )
	    )
	);

	//Criando a Taxonomy - Classificacao
	$port_tax = new Odin_Taxonomy(
        'Classificação', // Nome (Singular) da nova Taxonomia.
        'classificacao', // Slug do Taxonomia.
        'portfolio' // Nome do tipo de conteúdo que a taxonomia irá fazer parte.
    );

    $port_tax->set_labels(
        array(
            'menu_name' => __( 'Classificação', 'odin' )
        )
    );

    $port_tax->set_arguments(
        array(
            'hierarchical' => true
        )
    );

	//Criando as Metabox - Parceiros
    $parc_metabox = new Odin_Metabox(
        'partner_mb',
        'Informações do Parceiro',
        'partner',
        'normal',
        'high'
    );

    $parc_metabox->set_fields(
	    array(
	        array(
	            'id'          => 'link_parceiro',
	            'label'       => __( 'URL do Parceiro', 'odin' ),
	            'type'        => 'input', // Required
				'attributes'  => array( // Optional (html input elements)
                    'type' => 'url'
                )
	        )
	    )
	);

	if ($post_id == '2'){

		//Criando as Metabox - Parceiros
	    $home_metabox = new Odin_Metabox(
	        'home_mb',
	        'Informações das Midias Sociais',
	        'page',
	        'normal',
	        'high'
	    );

	    $home_metabox->set_fields(
		    array(
		        array(
		            'id'          => 'link_facebook',
		            'label'       => __( 'Facebook', 'odin' ),
		            'type'        => 'input', // Required
					'attributes'  => array( // Optional (html input elements)
	                    'type' => 'url'
	                )
		        ),
		        array(
		            'id'          => 'link_gplus',
		            'label'       => __( 'Google Plus', 'odin' ),
		            'type'        => 'input', // Required
					'attributes'  => array( // Optional (html input elements)
	                    'type' => 'url'
	                )
		        ),
		        array(
		            'id'          => 'link_twitter',
		            'label'       => __( 'Twitter', 'odin' ),
		            'type'        => 'input', // Required
					'attributes'  => array( // Optional (html input elements)
	                    'type' => 'url'
	                )
		        ),
		        array(
		            'id'          => 'link_git',
		            'label'       => __( 'GitHub', 'odin' ),
		            'type'        => 'input', // Required
					'attributes'  => array( // Optional (html input elements)
	                    'type' => 'url'
	                )
		        ),
		        array(
		            'id'          => 'link_linkedin',
		            'label'       => __( 'LinkedIn', 'odin' ),
		            'type'        => 'input', // Required
					'attributes'  => array( // Optional (html input elements)
	                    'type' => 'url'
	                )
		        ),
		        array(
		            'id'          => 'link_wordpress',
		            'label'       => __( 'WordPress Profile', 'odin' ),
		            'type'        => 'input', // Required
					'attributes'  => array( // Optional (html input elements)
	                    'type' => 'url'
	                )
		        ),
		        array(
		            'id'          => 'link_email',
		            'label'       => __( 'Email', 'odin' ),
		            'type'        => 'input', // Required
					'attributes'  => array( // Optional (html input elements)
	                    'type' => 'url'
	                )
		        )
		    )
		);

	};

    // Criando Theme Options
    $settings = new Odin_Theme_Options(
        'chr-settings', // Slug/ID of the Settings Page (Required)
        'Gerenciar Tema', // Settings page name (Required)
        'manage_options' // Page capability (Optional) [default is manage_options]
    );

    $settings->set_tabs(
        array(
            array(
                'id' => 'info_geral', // Slug/ID of the Settings tab (Required)
                'title' => __( 'Informações Gerais', 'odin' ), // Settings tab title (Required)
            )
        )
    );

    $settings->set_fields(
        array(
            'info_geral_fields_section' => array( // Slug/ID of the section (Required)
                'tab'   => 'info_geral', // Tab ID/Slug (Required)
                'title' => __( 'Informações Basicas', 'odin' ), // Section title (Required)
                'fields' => array( // Section fields (Required)
                    array(
                        'id'          => 'logo_default', // Required
                        'label'       => __( 'Logo', 'odin' ), // Required
                        'type'        => 'image', // Required
                    ),
                    array(
                        'id'          => 'shortcode_form', // Required
                        'label'       => __( 'Shortcode Form', 'odin' ), // Required
                        'type'        => 'editor', // Required
                    ),
            	)
           	)
        )
    );

}

add_action( 'init', 'portfolio_set', 1 );

//Criando Coluna Portfolio
function add_post_columns_port($columns) {
    $new_columns['cb'] = '<input type="checkbox" />';
    $new_columns['featured'] = __('Image');
    $new_columns['title'] = _x('Title', 'column name');
 	$new_columns['taxonomy-classificacao'] = __('Classificações');
 	$new_columns['date'] = _x('Date', 'column name');
 	$new_columns['wpseo-score'] = _x('SEO', 'column name');

    return $new_columns;
}
add_filter('manage_portfolio_posts_columns', 'add_post_columns_port', 10);

// Add to admin_init function
function manage_post_columns_port($column_name, $id) {
    global $wpdb;
    switch ($column_name) {
    case 'featured':
        $odin_thumb = get_the_post_thumbnail(  $id, 'thumbnail' );       
        if ($odin_thumb){
        	$get_thumb = $odin_thumb;
        } else {
        	$get_thumb = '<img src="' . get_template_directory_uri() . '/assets/images/not-available.png" alt="'. get_the_title() .'" title="'. get_the_title() .'" width="150" height="150" />';
        };
        echo sprintf( '<a href="%1$s" title="%2$s" style="display: inline-block;">%3$s</a>', admin_url( 'post.php?post=' . $id . '&action=edit' ), get_the_title(), $get_thumb );
        break;
    default:
        break;
    }
}
add_action('manage_portfolio_posts_custom_column', 'manage_post_columns_port', 10, 2);

//Criando Coluna Parceiros
function add_post_columns_parc($columns) {
    $new_columns['cb'] = '<input type="checkbox" />';
    $new_columns['featured'] = __('Image');
    $new_columns['title'] = _x('Title', 'column name');
 	$new_columns['link-parceiro'] = _x('Link do Parceiro', 'column name');
 
    return $new_columns;
}
add_filter('manage_partner_posts_columns', 'add_post_columns_parc', 10);

// Add to admin_init function
function manage_post_columns_parc($column_name, $id) {
    global $wpdb;
    switch ($column_name) {
    case 'featured':
        $odin_thumb = get_the_post_thumbnail( $id, 'thumbnail' );       
        if ($odin_thumb){
        	$get_thumb = $odin_thumb;
        } else {
        	$get_thumb = '<img src="' . get_template_directory_uri() . '/assets/images/not-available.png" alt="'. get_the_title() .'" title="'. get_the_title() .'" width="150" height="150" />';
        };
        echo sprintf( '<a href="%1$s" title="%2$s" style="display: inline-block;">%3$s</a>', admin_url( 'post.php?post=' . $id . '&action=edit' ), get_the_title(), $get_thumb );
        break;
    case 'link-parceiro':
    	$link = get_post_meta( $id,'link_parceiro', true );
    	echo sprintf( '<a href="%1$s" title="%2$s" target="_blank">%3$s</a>', $link, get_the_title(), $link );
        break;
    default:
        break;
    }
}
add_action('manage_partner_posts_custom_column', 'manage_post_columns_parc', 10, 2);

function chr_redirect_post_type() {
    global $wp_query;
    if ( is_post_type_archive(array('portfolio', 'partner')) || is_singular(array('portfolio', 'partner')) ) :
        $url = get_bloginfo('url');
        wp_redirect( esc_url_raw( $url ), 301 );
        exit();
    endif;
}
add_action ( 'template_redirect', 'chr_redirect_post_type', 1);

//Get Genre Filters
function get_classificacao_filters()
{
    $terms = get_terms('classificacao');
    $filters_html = false;
 
    if( $terms ):
        $filters_html = '<ul>';
 		
 		$filters_html .= '<li><a href="#" class="selected" data-filter="*" title="All Jobs">All Jobs</a></li>';

        foreach( $terms as $term ) {
            
            $term_id = $term->term_id;
            $term_slug = $term->slug;
            $term_name = $term->name;
 
            $filters_html .= '<li><a href="#" data-filter=".'.$term_slug.'" title="'.$term_name.'">'.$term_name.'</a></li>';
        }

        $filters_html .= '</ul>';
 
        return $filters_html;
    endif;
}

function my_search() {
		$term = strtolower( $_GET['term'] );
		$suggestions = array();

		$args = array (
			'post_type'		=> array( 'post' ),
			'post_status'	=> array( 'publish' ),
			's'				=> $term,
		);
		
		$loop = new WP_Query( $args );
		
		while( $loop->have_posts() ) {
			$loop->the_post();
			$suggestion = array();
			$suggestion['label'] = get_the_title();
			//$suggestion['link'] = get_permalink();
			
			$suggestions[] = $suggestion;
		}
		
		wp_reset_query();
    	
    	$response = json_encode( $suggestions );
    	echo $response;
    	exit();

}

add_action( 'wp_ajax_my_search', 'my_search' );
add_action( 'wp_ajax_nopriv_my_search', 'my_search' );

function guwp_error_msgs() { 
    // insert how many msgs you want as an array item. it will be shown randomly 
    $custom_error_msgs = array(
        '<strong>YOU</strong> SHALL NOT PASS!',
        '<strong>HEY!</strong> GET OUT OF HERE!',
    );
    // get random array item to show
    return $custom_error_msgs[array_rand($custom_error_msgs)];;
}
add_filter( 'login_errors', 'guwp_error_msgs' );