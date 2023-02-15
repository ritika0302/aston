<?php
/**
 * The template for displaying single posts and pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header();
?>

<div id="content" class="top-spacing">
   <?php echo Fn_cms_inner_banner(get_the_ID());?>
	<?php if(is_single()) { ?>
   <div class="thejournal-detailsection">
		<div class="container">
			<div class="small-container content-cols">
				<?php

				if ( have_posts() ) {

					while ( have_posts() ) {
						the_post();

						//get_template_part( 'template-parts/content', get_post_type() );
						echo '<div class="headings wow fadeInUp" data-wow-delay="0.2s">';
							echo '<p>'.get_field("journal_sub_heading",get_the_ID()).'</p>';
						echo '</div>';
						the_content();
					}
				}

				?>
				 <div class="bottom-linkrow wow fadeInUp" data-wow-delay="0.2s">
                     <a href="<?php echo get_permalink(67);?>"><i class="fa fa-reply"></i> Back to journal</a>
                     <?php $pinterestimage = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' ); ?>
                     <div class="print-col">
                        <ul>
                           <li>
                              <a class="share-icon" href="javascript:void(0)"><i class="fa fa-share-alt"></i> Share</a>
                              <div class="share-toggle">
                                 <ul>
                                    <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink(get_the_ID())); ?>&quote=<?php echo get_the_title();?>" target="_blank" >Facebook</a></li>
                                    <li><a href="https://twitter.com/intent/tweet?text=<?php echo get_the_title();?>&amp;url=<?php echo urlencode(get_permalink(get_the_ID())); ?>" target="_blank" >Twitter</a></li>
                                    <li><a href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink(get_the_ID())); ?>&media=<?php echo $pinterestimage[0]; ?>&description=<?php echo get_the_title();?>" target="_blank" >Pinterest</a></li>
                                    <li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode(get_permalink(get_the_ID())); ?>&amp;title=<?php echo get_the_title();?>&amp;summary=&amp;source=<?php bloginfo('name'); ?>" target="_blank" >LinkedIn</a></li>
                                 </ul>
                                 <a class="share-close" href="javascript:void(0)">
                                    <img src="<?php echo get_template_directory_uri();?>/assets/images/close-icon2.svg" alt="close-icon2.svg">
                                 </a>
                              </div>
                           </li>
                           <li><?php if( function_exists( 'pf_show_link' ) ){ echo pf_show_link(); } ?></li>
                        </ul>
                     </div>
                  </div>
			</div>
		</div>
	</div>
   <?php if(get_field("jou_static_block",get_the_ID())) { ?>
   	<div class="property-worthsection wow fadeInUp" data-wow-delay="0.2s">
        <div class="container">
           <div class="property-worthcol">
              <?php echo get_field("jou_static_block",get_the_ID());?>
           </div>
        </div>
      </div>
   <?php } ?>
 <?php } else { ?>
   <div class="content-headings wow fadeIn animated" data-wow-delay="0.2s">
      <div class="container">
         <div class="headings">
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
 <?php } ?>
</div>


<?php get_footer(); ?>
