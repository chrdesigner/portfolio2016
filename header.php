<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till #main div
 *
 * @package Odin
 * @since 2.2.0
 */
?><!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/html5.js"></script>
	<![endif]-->
	
	<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/icon/32.png" sizes="32x32" />
	<link rel="apple-touch-icon-precomposed" href="<?php echo get_template_directory_uri(); ?>/assets/images/icon/180.png">
	<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/icon/192.png" sizes="192x192" />
	<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/assets/images/icon/270.png">
	
	<link href='https://fonts.googleapis.com/css?family=Architects+Daughter|Strait' rel='stylesheet' type='text/css'>
	
	<script src="<?php echo get_template_directory_uri(); ?>/assets/preloader/modernizr-2.6.2.min.js"></script>

	<?php
		wp_head();

		$odin_general_opts = get_option( 'info_geral' );

		$logo_id = $odin_general_opts['logo_default'];
		$get_url_logo = wp_get_attachment_image_src( $logo_id, 'full' );

		if ( is_admin_bar_showing() ) { ?>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				var wpadminbar = $('#wpadminbar'); $('#header').css('top', wpadminbar.innerHeight());
			});
		</script>
		<?php }; 

		if( is_front_page() ){ ?>
		<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.isotope.min.js"></script>
		<script type="text/javascript">
			jQuery(document).ready(function($) {

			    $.fn.parallax = function(options) {
			        var windowHeight = $(window).height();
			        var settings = $.extend({
			            speed        : 0.15
			        }, options);
			        return this.each( function() {
				        var $this = $(this);
				        $(document).scroll(function(){
				    		var scrollTop = $(window).scrollTop();
				            var offset = $this.offset().top;
				            var height = $this.outerHeight();
						    if (offset + height <= scrollTop || offset >= scrollTop + windowHeight) {
								return;
							}
							var yBgPosition = Math.round((offset - scrollTop) * settings.speed);
				        	$this.css('background-position', 'center ' + yBgPosition + 'px');        
				    	});
			        });
			    };

			    $('.parallax-section-home').parallax({
					speed : 0.15
				});

				$('.parallax-section-partner').parallax({
					speed : 0.25
				});

				$('.parallax-section-contact-me').parallax({
					speed : 0.30
				});

			});
		</script>
		<?php };
	?>
</head>

<body <?php body_class(); ?>>

	<div id="loader-wrapper">
		<div id="loader"></div>
		<div class="loader-section section-left"></div>
	    <div class="loader-section section-right"></div>
	</div>

	<div class="menu-filter-type">
	   <nav>
	       <div class="x-filter close-menu">
	           <span></span>
	           <span></span>
	       </div>
	       <?php
				wp_nav_menu(
					array(
						'theme_location' => 'main-menu',
						'depth'          => 2,
						'container'      => false,
						'menu_class'     => '',
						'fallback_cb'    => 'Odin_Bootstrap_Nav_Walker::fallback',
						'walker'         => new Odin_Bootstrap_Nav_Walker()
					)
				);
			?>
			<div class="x-filter close-menu">
	           <span></span>
	           <span></span>
	       </div>
	   </nav>
	</div>

	<header id="header" role="banner" class="sticky">
		<div class="container">
			<div class="page-header">
				<?php if ( is_front_page() ) : ?>
					<h1 class="site-title">
						<img src="<?php echo $get_url_logo[0];?>" alt="<?php echo get_bloginfo( 'name' ) . ' | ' . get_bloginfo( 'description' ); ?>" title="<?php echo get_bloginfo( 'name' ) . ' | ' . get_bloginfo( 'description' ); ?>" class="img-responsive aligncenter" />
					</h1>
				<?php else : ?>
					<div class="site-title h1">
						<a href="<?php if( is_singular( 'post' ) ){ echo get_permalink(get_page_by_path( 'blog' )); }else{ echo esc_url( home_url( '/' ) ); }; ?>" title="<?php echo get_bloginfo( 'name' ) . ' | ' . get_bloginfo( 'description' ); ?>" rel="home">
							<img src="<?php echo $get_url_logo[0];?>" alt="<?php echo get_bloginfo( 'name' ) . ' | ' . get_bloginfo( 'description' ); ?>" title="<?php echo get_bloginfo( 'name' ) . ' | ' . get_bloginfo( 'description' ); ?>" class="img-responsive aligncenter" />
						</a>
					</div>
				<?php endif ?>
				<div class="navbar-header">
					 <button type="button" class="toggle-nav btn-nav navbar-toggle alignright open-menu filter-type-menu">
						<i class="btn-hamburger alignleft"><span></span></i>
						<i class="alignleft text-uppercase text-menu">Menu</i>
					</button>
				</div>
			</div><!-- .site-header-->
		</div><!-- .container-->
	</header><!-- #header -->
	<div id="container-main">