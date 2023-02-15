<?php // Template Name: Cookie ?>
<?php get_header(); ?>

<div id="content" class="top-spacing">
   <?php echo Fn_cms_inner_banner(get_the_ID());?>
   <div class="content-headings wow fadeIn animated" data-wow-delay="0.2s">
      <div class="container">
         <div class="headings">
            <?php echo get_field("cookie_short_desc",get_the_ID());?>
            <?php 
                  $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full');  
                  $fea_alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
               if(isset($featured_img_url) && $featured_img_url != '')
               {
                  echo '<div class="img">';
                     echo '<img src="'.$featured_img_url.'" alt="'.$fea_alt.'">';
                  echo '</div>';      
               }
            ?>
         </div>
      </div>
   </div>
   <div class="policy-text wow fadeIn animated" data-wow-delay="0.2s">
      <div class="container">
         <div class="text-block">
            <?php the_content();?>
         </div>
      </div>
   </div>

</div>
<?php get_footer(); ?>