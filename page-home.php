<?php get_header(); ?>

	<main id="content" class="container-fluid" tabindex="-1" role="main">
		
		<?php
			if ( have_posts() ) : while ( have_posts() ) : the_post();
			//Get ID/Thumbnail
			$thumb_id = get_post_thumbnail_id();
			$url_img = odin_get_image_url($thumb_id);
		?>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$(window).resize(function() {
			        $('#box-about-me .container').height(
			        	$(window).height() - $('#box-about-me .container').offset().top
			        );
			    });
			    $(window).resize();
			});
		</script>
		<section id="box-about-me" class="row parallax-section-home" style="background-image: url('<?php echo $url_img;?>');">
			<a name="about-me" class="anchor-link"></a>
			<i></i>
			<div class="container">
				<div class="info-about"><?php the_content(); ?></div>
			</div>			
		</section>
		<?php endwhile; endif; 

		// WP_Query arguments
		$args = array (
			'post_type'      => array( 'portfolio' ),
			'post_status'    => array( 'publish' ),
			'posts_per_page' => '-1',
			'order'          => 'DESC',
			'orderby'        => 'rand'
		);

		// The Query
		$query_portfolio = new WP_Query( $args );

		// The Loop
		if ( $query_portfolio->have_posts() ) : ?>

		<section id="container-portfolio" class="row">
			<a name="jobs" class="anchor-link"></a>
			<header>
				<h5 class="glyphicon glyphicon-filter" aria-hidden="true" id="btn-classificacao-filter"></h5>
				<nav id="classificacao-filter" style="display: none;">
				    <?php echo get_classificacao_filters(); ?>
				</nav>
			</header>
			<script type="text/javascript">
				
				jQuery(document).ready(function($) {

					var loop_port = $('.loop-portfolio').width();

				    $('.loop-portfolio').css( 'height', loop_port - 60 );

				    var $container = $('.portfolio');
					$container.isotope({
					    filter: '*',
					    animationOptions: {
					        duration: 750,
					        easing: 'linear',
					        queue: false
					    }
					});

					$('nav#classificacao-filter ul a').click(function(){
					    var selector = $(this).attr('data-filter');
					    $container.isotope({
					        filter: selector,
					        animationOptions: {
					            duration: 750,
					            easing: 'linear',
					            queue: false
					        }
					    });
					  return false;
					});
					 
					var $optionSets = $('nav#classificacao-filter ul'),
				   	$optionLinks = $optionSets.find('a');

					$optionLinks.click(function(){
					      var $this = $(this);
					      if ( $this.hasClass('selected') ) {
					          return false;
					      }
					   var $optionSet = $this.parents('nav#classificacao-filter ul');
					   $optionSet.find('.selected').removeClass('selected');
					   $this.addClass('selected'); 
					});

					$('#btn-classificacao-filter').toggle(function() {
				        $(this).css('opacity', '0.6');
				    }, function() {
				        $(this).css('opacity', '1');
				    }).click(function(){
				        $('#classificacao-filter').slideToggle(300);
				    });

				});

			</script>
			<div class="portfolio">
			<?php
				while ( $query_portfolio->have_posts() ) : $query_portfolio->the_post();
				
				//Get ID/Thumbnail
				$thumb_id_port = get_post_thumbnail_id();
				$url_img_port = odin_get_image_url($thumb_id_port);

				$linh_projeto = get_post_meta( $post->ID,'link_projeto', true );
				$link_agencia = get_post_meta( $post->ID,'link_agencia', true );
			?>
				<article class="loop-portfolio col-xs-12 col-sm-6 col-md-4 col-lg-3 <?php $term_list = wp_get_post_terms($post->ID, 'classificacao', array("fields" => "all")); foreach($term_list as $term_single) { echo $term_single->slug . ' '; };?>">
					<figure style="background-image: url(<?php echo $url_img_port;?>);"></figure>
					<figcaption>
						<blockquote class="info-job text-center">
							<h4><?php the_title();?></h4>
							<?php the_content();?>
							<ol class="list-unstyled">
								<?php if( !empty($linh_projeto) ): ?>
								<li>
									<span>Project</span><br />
									<a href="<?php echo $linh_projeto;?>" title="Visit the Project - <?php echo $linh_projeto;?>" target="_blank"><?php echo $linh_projeto;?></a>
								</li>
								<?php endif; ?>
								<?php if( !empty($link_agencia) ): ?>
								<li>
									<span>Agency</span><br />
									<a href="<?php echo $link_agencia;?>" title="Visit the Agency - <?php echo $link_agencia;?>" target="_blank"><?php echo $link_agencia;?></a>
								</li>
								<?php endif; ?>
							</ol>
						</blockquote>
					</figcaption>
				</article>
				<?php endwhile; ?>
			</div>
		</section>
		<?php endif; wp_reset_postdata(); ?>

		<?php
		// WP_Query arguments
		$args = array (
			'post_type'              => array( 'partner' ),
			'post_status'            => array( 'publish' ),
			'posts_per_page'         => '-1',
			'order'                  => 'DESC',
			'orderby'                => 'rand',
		);

		// The Query
		$query_partner = new WP_Query( $args );

		// The Loop
		if ( $query_partner->have_posts() ) : ?>
		<section id="global-partner" class="parallax-section-partner row">
			<a name="partners" class="anchor-link"></a>
			<dl class="container text-center">
				<dt class="aligncenter">
					<h4 class="font-Architects-Daughter">Partners</h4>
				</dt>
				<?php while ( $query_partner->have_posts() ) : $query_partner->the_post(); $linh_partner = get_post_meta( $post->ID,'link_parceiro', true ); ?>
				<dd>
					<figure>
						<a href="<?php echo $linh_partner;?>" title="Visit the Partner - <?php the_title();?>" target="_blank">
							<?php echo odin_thumbnail($width, 80);?>
						</a>
					</figure>
				</dd>
				<?php endwhile; ?>
			</dl>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					
					var partner_w = $('#global-partner').width();
					var partner_h = $('#global-partner').height();
				    
				    $('<style type="text/css">#global-partner:before{width: ' + partner_w + 'px; height: ' + partner_h + 'px;}</style>').appendTo('#global-partner');

				});
			</script>
		</section>
		<?php endif; wp_reset_postdata(); ?>

		<section id="global-blog" class="container">
			<a name="blog" class="anchor-link"></a>
			<header class="text-left">
				<h4 class="font-Architects-Daughter">See my last Posts below...</h4>
			</header>
			<article id="main-loop-blog" class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<?php

				$args = array (
					'post_type'              => 'post',
					'post_status'            => 'publish',
					'posts_per_page'         => '1',
				);

				$loop_princ = new WP_Query( $args );

				if ( $loop_princ->have_posts() ) { while ( $loop_princ->have_posts() ) { $loop_princ->the_post(); ?>
				<figure>
					<a href="<?php the_permalink();?>" title="<?php the_title();?>">
						<?php echo odin_thumbnail(600, 200); ?>
					</a>
				</figure>
				<blockquote>
					<h3 class="text-uppercase"><a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php the_title();?></a></h3>
					<a href="<?php the_permalink();?>" title="Read More - <?php the_title();?>" class="read-more">Read More</a>
				</blockquote>
				<?php } 
				}
				wp_reset_postdata();
			?>
			</article>

			<article class="box-loop-blog col-xs-12 col-sm-6 col-md-6 col-lg-6">
			<?php
				$args = array (
					'post_type'              => 'post',
					'post_status'            => 'publish',
					'posts_per_page'         => '2',
					'offset'                 => '1',
				);
				$loop_seg = new WP_Query( $args );
				if ( $loop_seg->have_posts() ) { while ( $loop_seg->have_posts() ) { $loop_seg->the_post(); ?>
				<div class="loop-post-blog col-xs-12 col-sm-12 col-md-6 col-lg-6">
					<h4><a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php the_title();?></a></h4>
					<ol>
						<li class="glyphicon glyphicon-link"></li>
					<?php $getslugid = wp_get_post_terms( $post->ID, 'category' ); foreach( $getslugid as $thisslug ) {
					    echo '<li><a href="' . get_term_link($thisslug->slug, 'category') . '" title="' . $thisslug->name . '">' . $thisslug->name . '</a></li>';
					};?>
					</ol>
					<p><?php echo odin_excerpt('excerpt', 30); ?></p>
					<a href="<?php the_permalink();?>" title="Read More - <?php the_title();?>" class="read-more">Read More</a>
				</div>
				<?php 					
					}
				}
				wp_reset_postdata();
			?>
			</article>

			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				
				<form role="search" method="get" class="search-form row" action="<?php echo esc_url( home_url( ) ); ?>">
					<label>
						<span class="screen-reader-text">Search for:</span>
						<input type="search" class="search-field form-control" placeholder="Search …" value="" name="s" id="s" title="Search for:" />
					</label>
					<input type="submit" class="search-submit" id="search" value="Submit" />
				</form>
			
			</article>
			

			<button onclick="location.href='<?php bloginfo('url');?>/blog';" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Read More</button>
			
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					var loop_blog = $('#main-loop-blog').height();
				    $('.loop-post-blog').css( 'height', loop_blog );
				});
			</script>

		</section>

	</main><!-- #content -->

<?php get_footer(); ?>