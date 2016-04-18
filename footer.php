<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main div element.
 *
 * @package Odin
 * @since 2.2.0
 */

$odin_informacoes = get_option('info_geral');

?>
	</div>
	<footer id="footer" class="parallax-section-contact-me" role="contentinfo">
		<div id="contact-me">
			<div class="container form-contact">
				<h4>Get in touch</h4>
				<h6>If you have any question or a budget!!!<br />Contact me with form bellow.</h6>
				<?php echo wpautop( do_shortcode( $odin_informacoes['shortcode_form'] ) ); ?>
			</div>
		</div>
		<div id="info-footer" class="container-fluid">
			<?php
				wp_nav_menu(
					array(
						'theme_location' => 'main-menu',
						'depth'          => 2,
						'container'      => false,
						'menu_class'     => 'menu-rodape',
						'items_wrap'     => '<nav id="nav-footer"><ul id="%1$s" class="%2$s list-unstyled list-inline">%3$s</ul></nav>'
					)
				);
				// WP_Query arguments
				$args = array (
					'page_id'                => '2',
					'post_type'              => array( 'page' ),
					'post_status'            => array( 'publish' ),
				);
				// The Query
				$query_home = new WP_Query( $args );
				// The Loop
				if ( $query_home->have_posts() ) {
				echo '<dl class="midias">
						<dt>Found Me</dt>';
					while ( $query_home->have_posts() ) { $query_home->the_post();
						echo '<dd><a href="'. get_post_meta( $post->ID,'link_facebook', true ) .'" title="Facebook" class="fa fa-facebook-official" target="_blank"></a></dd>';
						echo '<dd><a href="'. get_post_meta( $post->ID,'link_gplus', true ) .'" title="Google Plus" class="fa fa-google-plus-square" target="_blank"></a></dd>';
						echo '<dd><a href="'. get_post_meta( $post->ID,'link_twitter', true ) .'" title="Twitter" class="fa fa-twitter-square" target="_blank"></a></dd>';
						echo '<dd><a href="'. get_post_meta( $post->ID,'link_git', true ) .'" title="GitHub" class="fa fa-github-square" target="_blank"></a></dd>';
						echo '<dd><a href="'. get_post_meta( $post->ID,'link_linkedin', true ) .'" title="LinkedIn" class="fa fa-linkedin-square" target="_blank"></a></dd>';
						echo '<dd><a href="'. get_post_meta( $post->ID,'link_wordpress', true ) .'" title="WordPress" class="fa fa-wordpress" target="_blank"></a></dd>';
						echo '<dd><a href="'. get_post_meta( $post->ID,'link_email', true ) .'" title="E-mail" class="fa fa-envelope" target="_blank"></a></dd>';
					}
				echo '</dl>';
				}
				// Restore original Post Data
				wp_reset_postdata();
			?>
			<div class="container box-facebook">
				<div id="fb-root"></div>
				<script type="text/javascript">
					(function(d, s, id) { var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=144439268968566"; fjs.parentNode.insertBefore(js, fjs); }(document, 'script', 'facebook-jssdk'));
					jQuery(document).ready(function($) {
						$(window).bind("load resize", function(){
							setTimeout(function() {
								var container_width = $('#contact-me').width();
								$('#facebook-footer').html('<div class="fb-page" ' + 'data-href="http://www.facebook.com/chrdesignerportfolio"' + ' data-width="' + container_width + '" data-height="250" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="http://www.facebook.com/IniciativaAutoMat"><a href="http://www.facebook.com/chrdesignerportfolio">CHR Designer</a></blockquote></div></div>');
							    FB.XFBML.parse();
						  	}, 169);
						});
					});
				</script>
				<div id="facebook-footer" style="width:100%;">
					<div class="fb-page" data-href="http://www.facebook.com/chrdesignerportfolio" data-height="250" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="http://www.facebook.com/chrdesignerportfolio"><a href="http://www.facebook.com/chrdesignerportfolio">CHR Designer</a></blockquote></div></div>
				</div>
			</div>
			<p class="assinatura">&copy; 2006 - <?php echo date( 'Y' ); ?> <a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a> - <?php _e( 'All rights reserved', 'odin' ); ?> | <?php echo sprintf( __( 'Powered by the <a href="%s" rel="nofollow" target="_blank">Odin</a> forces and <a href="%s" rel="nofollow" target="_blank">WordPress</a>.', 'odin' ), 'http://wpod.in/', 'http://wordpress.org/' ); ?></p>
		</div><!-- .container -->
	</footer><!-- #footer -->

	<?php wp_footer(); ?>

	</body>
</html>