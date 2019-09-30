<?php
/*
*
* Template Name: About US Page
*
*/
get_header(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="innercnt">
	<div class="mtp commonpages">
	<?php			
	
	while ( have_posts() ) : the_post();				
	
	get_template_part( 'content', 'page' );				
	
	if ( comments_open() || get_comments_number() ) :					
	comments_template();				endif;			
	endwhile;			
	?>					 
	<?php			 			 
	echo '<div class="mytyeam" ><div class="hentry"><h2> Our Team :</h2>';
	if( have_rows('teams') ){
		echo '<ul class="aboutlist">';
		while ( have_rows('teams') ) : the_row(); 		?> 
		<li>
			<div class="teamimg">
			<img src="<?php the_sub_field('image'); ?>" alt=""/>
			</div>
			<div class="teamcnt">
			<h4><?php the_sub_field('name'); ?></h4>
			<?php if(get_sub_field('social_media')){ ?><p> <?php echo html_entity_decode(get_sub_field('social_media')); ?></p>  <?php } ?>
			<p> <?php the_sub_field('descriptions'); ?></p>   
			</div>
		</li>	
		<?php   		
		endwhile;	
		echo '</ul></div></div>';	
		}	?>	
		</div>
		</div>
		<?php get_footer(); 
		