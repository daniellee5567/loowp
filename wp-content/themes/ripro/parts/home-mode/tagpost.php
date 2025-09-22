<?php

$mode_tagpost = _cao('mode_tagpost');



foreach ($mode_tagpost['tagcms'] as $key => $cms) { 

	$args = array(
	    'tag'            => $cms['tag'],
	    'ignore_sticky_posts' => true,
	    'post_status'         => 'publish',
	    'posts_per_page'      => $cms['count'],
	    'orderby'      => $cms['orderby'],
	);

	///////////S CACHE ////////////////
	if (CaoCache::is()) {
	     $clean_string = preg_replace('/[^A-Z]/i', '', $args['tag']);
	    $_the_cache_key = 'ripro_home_tagpost_posts_'.$clean_string;
	    $_the_cache_data = CaoCache::get($_the_cache_key);
	    if(false === $_the_cache_data ){
	        $_the_cache_data = new WP_Query($args); //缓存数据
	        CaoCache::set($_the_cache_key,$_the_cache_data);
	    }
	    $data = $_the_cache_data;
	}else{
	    $data = new WP_Query($args); //原始输出
	}
	///////////S CACHE ////////////////
	$tag = get_tag( $cms['tag'] ); ?>
	<div class="section pb-0">
	  <div class="container">
	  	<h3 class="section-title">
	  		<span><i class="fa fa-th"></i> <?php echo $cms['wholename']; ?></span>
	  	</h3>
	  	<?php _the_cao_ads('ad_list_header', 'list-header');?>
		<div class="row cat-posts-wrapper">
		    <?php while ( $data->have_posts() ) : $data->the_post();
		      get_template_part( 'parts/template-parts/content',$cms['latest_layout'] );
		    endwhile; ?>
		</div>
		<?php _the_cao_ads('ad_list_footer', 'list-footer');?>
	  </div>
	</div>

	<?php 
	wp_reset_postdata();
}
?>