<?php
get_header();
?>
<?php

function checkcats()
{
    $posts = get_posts( 'numberposts=-1');
    foreach($posts as $post)
    {
        $categories = get_the_category($post->ID);
        if(empty($categories)){
            wp_set_post_terms($post->ID,1, 'category' );
        }
    }
    
}

//checkcats();

function getdownlog($postid)
{

    global $wpdb;
    // 主页面PHP
    $perpage = 20;
    $params['perpage'] = $perpage; // 每页数量
    $params['paged']=isset($_GET['paged']) ?intval($_GET['paged']) :1;  //当前页
    $params['down_id'] = $postid; 
    $Reflog = new Reflog(0);
    //$total   = $Reflog->get_down_total();
    $result = $Reflog->get_downlog_by_postid($params);
    
    if($result) {
		foreach($result as $item){
		    $user_loginName = ($item->user_id > 0) ? get_user_by('id',$item->user_id)->user_login : '游客' ;
		    
			file_put_contents('downlog.txt',$user_loginName."\n",FILE_APPEND);
		}
	}
}

function myfunc()
{
    $id=get_category_by_slug('weiqing')->term_id;
    $posts = get_posts( 'numberposts=-1&category='.$id );
    //$posts = get_posts( 'numberposts=-1');
    $price = 0;
    
    foreach($posts as $post)
    {
        //update_post_meta($post->ID,'cao_download_url','');
        update_post_meta($post->ID, 'ludou_se_only', '0');
        update_post_meta($post->ID, 'cao_status', '0');
        
        $content = get_post_field('post_content', $post->ID)."<h2>正版购买地址</h2>https://s.w7.cc/";
        
        wp_update_post(array(
            'ID' => $post->ID,
            'post_content' => $content
        ));
        
        /*$price = get_post_meta($post->ID,'cao_price',true);
        if(intval($price) == 69){
            update_post_meta($post->ID,'cao_price',49);
        }
        if(intval($price) > 99 && intval($price) < 199){
            update_post_meta($post->ID,'cao_price',99);
        }*/
    } 
}
function myfunc2()
{
    //$posts = get_posts( 'numberposts=-1');
    $lines=file("/www/wwwroot/www.loowp.com/price.log");
    
    foreach($lines as $line)
    {
        $fields=explode(',',$line);
        $str = str_replace(PHP_EOL,'',$fields[0]);
        
        if(!empty(get_post_meta($str,'cao_price',true)))
        {
            //file_put_contents("/www/wwwroot/www.loowp.com/price2.log",$fields[0].','.str_replace(PHP_EOL,'',$fields[1])."\n",FILE_APPEND);
            update_post_meta($str,'cao_price',str_replace(PHP_EOL,'',$fields[1]));
        }
    } 
}

function myfunc3()
{
    //$id=get_category_by_slug('app')->term_id;
    //$posts = get_posts( 'numberposts=-1&category='.$id );
    $posts = get_posts( 'numberposts=-1');
    $new_price=0;

    
    foreach($posts as $post)
    {
        $price=intval(get_post_meta($post->ID,'cao_yuan_price',true));
        update_post_meta($post->ID,'cao_price',$price);
    } 
    
}
function myfunc4()
{
    $id=get_category_by_slug('webcode')->term_id;
    $posts = get_posts( 'numberposts=-1&category='.$id );
    //$posts = get_posts( 'numberposts=-1');
    
    foreach($posts as $post)
    {
        if(get_post_meta($post->ID,'cao_is_boosvip',true)){
            update_post_meta($post->ID,'cao_is_boosvip','0');
        }
    } 
    
}
function myfunc7()
{
    $id=get_category_by_slug('weiqing')->term_id;
    $posts = get_posts( 'numberposts=-1&category='.$id );
    //$posts = get_posts( 'numberposts=-1');
    
    foreach($posts as $post)
    {
        update_post_meta($post->ID,'black_vip_use_backup','1');
    } 
    
}

function myfunc5()
{
    $str="29240|28034|27941|27378|26972|26514|26250|25635|24817|22509|22440|22330|22168|13900|19244|18482|18852|16648|13881|13874|13024|12486|12233|12132|12070|12061|12056|12049|12048|12043|12032|12019|11992|11954|11952|11944|11942|11940|11938|11902|11883|11882|11840|11811|11776|11746|11740|11730|11716|11712|11544|11541|11522|11520|11514|11495|11492|11490|11488|11486|11327|11325|11323|11321|11319|11091|10966|10955|10952|10524|8179|7154|6486|5954|5876|5869|4344|3287|2124";
    $ids=explode("|",$str);
    
    foreach($ids as $id)
    {
        update_post_meta($id,'cao_is_boosvip','1');
        update_post_meta($id,'use_vip_blacklist','1');
    }     
}

function myfunc6()
{
    $id=get_category_by_slug('webcode')->term_id;
    $posts = get_posts( 'numberposts=-1&category='.$id );
    //$posts = get_posts( 'numberposts=-1');
    $price=299;

    
    foreach($posts as $post)
    {
        $price=intval(get_post_meta($post->ID,'cao_yuan_price',true));
        update_post_meta($post->ID,'cao_price',$price);
    } 
    
}

function myfunc9()
{
    //$id=get_category_by_slug('soft')->term_id;
    //$posts = get_posts( 'numberposts=-1&category='.$id );
    $posts = get_posts( 'numberposts=-1');

    
    foreach($posts as $post)
    {
        update_post_meta($post->ID,'erphp_down','4');
        delete_post_meta( $post->ID, 'start_down');
        delete_post_meta( $post->ID, 'start_down2');
        delete_post_meta( $post->ID, 'start_see');
        delete_post_meta( $post->ID, 'start_see2');
    }
}
function myfunc11()
{
    $id=get_category_by_slug('webcode')->term_id;
    $posts = get_posts( 'numberposts=-1&category='.$id );
    //$posts = get_posts( 'numberposts=-1');

    
    foreach($posts as $post)
    {
        $price=intval(get_post_meta($post->ID,'cao_yuan_price',true));
        //update_post_meta($post->ID,'cao_yuan_price',$price);
        
        $new_price=0;
       
        if($price == 39){
            $new_price=20;
        }else if($price == 49){
            $new_price=20;
        }else if($price == 59){
            $new_price=30;
        }else if($price == 69){
            $new_price=30;
        }else if($price == 99){
            $new_price=60;
        }else if($price == 199){
            $new_price=99;
        }else{
            $new_price=$price;
        }
        
        update_post_meta($post->ID,'cao_price',$new_price);
    }
}

function myfunc13()
{
    $id=get_category_by_slug('uncategorized')->term_id;
    $posts = get_posts( 'numberposts=-1&category='.$id );
    //$posts = get_posts( 'numberposts=-1');
    $price = 0;
    
    foreach($posts as $post)
    {
        $post_id = $post->ID; // 文章的ID
        $category_id = 615; // 分类的ID
        
        // 获取文章当前的分类
        //$categories = get_the_category($post_id);
        $current_categories = array();
        

        
        // 添加新的分类
        $current_categories[] = $category_id;
        
        // 更新文章的分类
        wp_set_post_categories($post_id, $current_categories);
    } 
}


//getdownlog(18552);
//myfunc9();
//myfunc5();
//myfunc6();
//myfunc13();


//WordPress实现自动记录死链地址
/*
if('is_404' && strpos($_SERVER['HTTP_USER_AGENT'],'Baiduspider') !== false){
$file = @file("badlink.txt");//badlink.txt
$check = true;
if(is_array($file) && !empty($file))
	foreach($file as &$f){
		if($f == home_url($_SERVER['REQUEST_URI'])."\n")
		$check = false;
	}
	if($check){
		$fp = fopen("badlink.txt","a");//badlink.txt就是在网站根目录的记录死链的文件
		flock ($fp, LOCK_EX) ;
		fwrite ($fp, home_url($_SERVER['REQUEST_URI'])."\n");
		flock ($fp, LOCK_UN);
		fclose ($fp);
	}
}
*/
?>
<div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="content-area">
          <main class="site-main">
            <?php if ( have_posts() ) : ?>
              <div class="row posts-wrapper">
                <?php while ( have_posts() ) : the_post();
                  get_template_part( 'parts/template-parts/content', _cao( 'latest_layout', 'grid' ) );
                endwhile; ?>
              </div>
              <?php get_template_part( 'parts/pagination' ); ?>
            <?php else : ?>
              <?php get_template_part( 'parts/template-parts/content', 'none' ); ?>
            <?php endif; ?>
          </main>
        </div>
      </div>
    </div>
</div>

<?php
wp_reset_postdata();
get_footer();
