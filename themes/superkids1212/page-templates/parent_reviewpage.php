<?php
/**
* Template Name: Parent Review Page
*
*/
get_header(); ?>
<style>
.rating input { display: none; } 
.rating label:before { 
  /* margin: 5px; */
  font-size: 1.25em;
  font-family: FontAwesome;
  display: inline-block;
  content: "\2605";
}

.rating label {color: grey;}
.green {color: green !important;} 
.rev_list li {
	margin-bottom: 10px;
	margin-top:10px;
	margin-left: 10px;
}
.rev_list li {
	margin-bottom: 0;
	margin-top: 10px;
	margin-left: 10px;
	padding: 5px 30px;
	margin-right: 10px;
	float: left;
	width: 98%;
	border-bottom: 1px solid #eee !important;
}
.hm_blk3 {	background: white;}
.wp-avatar-wrap {
	width: 100%;
	float: left;
}
.wp-avatar {
	width: auto;
	float: left;
	margin-right: 10px;
	border-radius: 50%;
}
.wp-avatar-wrap h4 {
	padding-top: 4px;
}

.comments p {
	margin-bottom: 20px;
}

.wp-rw .wp-rating-inner {
	color: green !important;
	font-size: 32px !important;
	font-weight: 700 !important;
	font-family: Arial !important;
	margin: 0 15px 0 0 !important;
	vertical-align: middle !important;
	float: left;
	padding: 0 0 20px 40px;
}
.wp-rw .rating {
	float: left;
	margin: 5px 0 0 0;
}
.avg_rating.wp-rw {
	float: left;
	width: 80%;
}
.wp-avg-rating{width: 100%; border-bottom: 1px solid #eee;float: left;}
.wp-btn{ padding: 10px;float: right;margin: 0 20px 0 0;box-shadow: 0 2px 5px 0 rgba(0,0,0,.26) !important;background: rgb(253, 199, 13) none repeat scroll 0% 0% !important; color: rgb(255, 255, 255) !important;}
@media screen and (max-width:767px) {
	.wp-addbtn {width: 100%;text-align: center;margin: 0;padding: 0;}
	.wp-btn {width: 100%;float: none;margin: 0;}
	.avg_rating.wp-rw {border-bottom: 1px solid #eee;float: left;width: 100%;margin-top: 30px;}
}
</style>
<div class="innercnt">
	<div class="mtp">
		<?php 
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
			get_template_part( 'content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		// End the loop.
		endwhile;
		
		?>
<div class="hm_blk3">
	<div class="wp-avg-rating">
		<div class="wp-addbtn">
			<a href= "/write-a-review/" class="wp-btn"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="14" height="14" viewBox="0 0 1792 1792"><path d="M491 1536l91-91-235-235-91 91v107h128v128h107zm523-928q0-22-22-22-10 0-17 7l-542 542q-7 7-7 17 0 22 22 22 10 0 17-7l542-542q7-7 7-17zm-54-192l416 416-832 832h-416v-416zm683 96q0 53-37 90l-166 166-416-416 166-165q36-38 90-38 53 0 91 38l235 234q37 39 37 91z" fill="#666"></path></svg> Post review</a>
		</div>
		<?php 
		$wp_review = $wpdb->prefix . "review";
		$sum_rating = $wpdb->get_results("SELECT sum(rating) as total_rate, count(rating) as total_user FROM $wp_review where status= 1 ORDER BY id DESC");
		if ( $wpdb->num_rows > 0 ){ ?>
			<div class="avg_rating wp-rw">
				<span class="wp-rating-inner">
				<?php $avg_rate = $sum_rating[0]->total_rate/$sum_rating[0]->total_user; 
				echo number_format((float)$avg_rate, 2, '.', '');
				?>
				</span>
				<div class="rating">
					<div>
						<span class="ratingSelector">
						<?php for($i=1;$i<=5; $i++){ ?>
							<input type="radio" name="ratings[1]" id="Degelijkheid-1-5" value="<?php echo $i;?>" class="radio">
							<label <?php if($i <= $avg_rate){ ?>class="full green" <?php } else { ?> class="full" <?php } ?>  for="Degelijkheid-<?php echo $i;?>-5"></label>
						<?php } ?>

						</span>
					</div>					
				</div>
			</div>
		<?php } ?>
	</div>
	<div class="review_video">
		<ul>
			<li><iframe width="280" height="180" src="https://www.youtube.com/embed/yklYSxQ0Qvo" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></li>
			<li><iframe width="280" height="180" src="https://www.youtube.com/embed/rnN97EuhTRo" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></li>
			<li><iframe width="280" height="180" src="https://www.youtube.com/embed/N4CzfoFGPkQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></li>
		</ul>
	</div>
	<?php 
	$data = $wpdb->get_results("SELECT * FROM $wp_review where status= 1 ORDER BY id  DESC");
	if ( $wpdb->num_rows > 0 ) :  
	?>
	<ul  class="rev_list" >
		<?php  foreach ($data as $data) { ?>		
		<li>
			<div class="wp-avatar-wrap">
			<img src="<?php echo get_template_directory_uri(); ?>/images/avatar.png" class="wp-avatar">
			<h4><?php echo $data->customer_name;?></h4>
			<span><?php echo $data->city != "" ? $data->city : "";  ?></span>
			</div>
			<div class="comments">
				<div class="rating">
					<div>
						<span class="ratingSelector">
						<?php for($i=1;$i<=5; $i++){ ?>
							<input type="radio" name="ratings[1]" id="Degelijkheid-1-5" value="<?php echo $i;?>" class="radio">
							<label <?php if($i<=$data->rating){ ?>class="full green" <?php } else { ?> class="full" <?php } ?>  for="Degelijkheid-<?php echo $i;?>-5"></label>
						<?php } ?>

						</span>
					</div>					
				</div>
				<p><?php echo stripcslashes($data->message); ?></p>
			</div>
		</li>		
	<?php } ?>
  </ul>
<?php endif; ?>
</div>
	</div>
<div class="clear"></div>
</div>
<?php get_footer(); ?>