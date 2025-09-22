<?php 
/**
 * Template name: 标签云
 * Description:   A tags page
 */

get_header();

?>

<div class="container">
    <div class="row">
        <main class="site-main">

            <article id="post-<?php the_ID(); ?>" <?php post_class( 'post tags' ); ?>>

              <div class="container">
               <div class="tagslist">
					<ul>
						<?php 
							$tags_count = 60;
							
							///////////S CACHE ////////////////
							if (CaoCache::is()) {
								$_the_cache_key = 'ripro_tags_page_tagslist_' . $tags_count;
								$_the_cache_data = CaoCache::get($_the_cache_key);
								if(false === $_the_cache_data ){
									$tagslist = get_tags('orderby=count&order=DESC&number='.$tags_count);
									CaoCache::set($_the_cache_key, $tagslist, 3600); // 1小时缓存
								}
								$tagslist = $_the_cache_data;
							}else{
								$tagslist = get_tags('orderby=count&order=DESC&number='.$tags_count);
							}
							///////////S CACHE ////////////////
							foreach($tagslist as $tag) {
								echo '<li><a class="name" href="'.get_tag_link($tag).'">'. $tag->name .'</a><small>&times;'. $tag->count .'</small>';
								///////////S CACHE ////////////////
								if (CaoCache::is()) {
									$_the_cache_key = 'ripro_tags_page_posts_' . $tag->term_id;
									$_the_cache_data = CaoCache::get($_the_cache_key);
									if(false === $_the_cache_data ){
										$posts = get_posts( "tag_id=". $tag->term_id ."&numberposts=1" );
										CaoCache::set($_the_cache_key, $posts, 1800); // 30分钟缓存
									}
									$posts = $_the_cache_data;
								}else{
									$posts = get_posts( "tag_id=". $tag->term_id ."&numberposts=1" );
								}
								///////////S CACHE ////////////////
								foreach( $posts as $post ) {
									setup_postdata( $post );
									echo '<p><a class="tit" href="'.get_permalink().'">'.get_the_title().'</a></p>';
								}
								echo '</li>';
							} 
						?>
					</ul>
				</div>
              </div>
            </article>

        </main>
    </div>
</div>

<?php get_footer(); ?>


