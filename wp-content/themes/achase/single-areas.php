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
<?php if ( have_posts() ) { 
while ( have_posts() ) {   the_post(); ?>
<div id="content" class="top-spacing">
 <?php 
 if(get_field("inn_banner_img",get_the_ID()))
 {
    echo '<section class="news_contect_banner" style="background-image: url('.get_field("inn_banner_img",get_the_ID()).');">';
        echo '<div class="custom_container">';
            echo '<div class="services_banner_content">';
                echo '<h1>'.get_the_title().'</h1>';
                echo get_field("inn_banner_content",get_the_ID());
                echo '<div class="skip-banner"><i class="fa fa-angle-down" aria-hidden="true"></i></div>';
            echo '</div>';
        echo '</div>';
    echo '</section>';
}
 ?>  
<section class="news_content_details single-area-detail">
   <div class="custom_container">
      <div class="news_content_details_text">
         <?php the_content(); ?>
      </div>
   </div>
   <?php if(get_field("scrolling_title",get_the_ID())) { ?>
   <div class="vertical-title wow fadeInDown">
      <div class="sideline"></div>
      <span><?php echo get_field("scrolling_title",get_the_ID());?></span>
   </div>
   <?php } ?>
</section>
<section class="content-section news_content_section single-area-section">
       <div class="custom_container">
          <div class="towcolumn-row">
             <div class="row">
                <div class="col-sm-7 leftcol">
                   <div class="normal-content">
                       <?php echo get_field("white_content_section",get_the_ID());?>
                   </div>
                   <div class="content-fullcolumn">
                      <div class="content-column">
                        <?php echo get_field("gray_content_section",get_the_ID());?>
                      </div>
                   </div>
                </div>
                <div class="col-sm-5 rightimage">
                   <div class="image-col">
                    <?php 
                    $gray_upload_image = get_field("gray_upload_image",get_the_ID());
                    ?>
                     
                      <div class="image">
                         <?php 
                           if(!empty($gray_upload_image))
                           {
                              echo '<img src="'.$gray_upload_image['url'].'" alt="'.$gray_upload_image['alt'].'">';
                           }

                        ?>
                      </div>
                      <div class="vertical-title wow fadeInDown">
                         <div class="sideline"></div>
                         <span>ASTON CHASE</span>
                      </div>
                   </div>
                </div>
             </div>
          </div>
         <div class="towcolumn-row whitebg-row">
             <div class="row">
                <div class="col-sm-6 leftcol">
                   <div class="content-fullcolumn">
                      <div class="content-column">
                        <?php echo get_field("history_content",get_the_ID());?>
                      </div>
                   </div>
                </div>
                <div class="col-sm-6 rightimage">
                   <div class="image-column">
                       <?php $white_upload_image = get_field("white_upload_image",get_the_ID());
                        if(!empty($white_upload_image))
                        {
                           echo '<img src="'.$white_upload_image['url'].'" alt="'.$white_upload_image['alt'].'">';
                        }

                       ?>
                      
                   </div>
                </div>                
             </div>
         </div> 
         <div class="inner-towcolumn-row">
            <?php echo get_field("history_content_bm",get_the_ID());?>
         </div>

       </div>
</section>
<section class="multi_news_list">
   <div class="custom_container">
      <div class="top_news_list_content">
         <?php 
            if(get_field("property_sub_content",get_the_ID()))
            {
               echo '<div class="news_list_content">';
                  echo get_field("property_sub_content",get_the_ID());
               echo '</div>';
            }

            if(get_field("shopping_sub_content",get_the_ID()))
            {
               echo '<div class="news_list_content">';
                  echo get_field("shopping_sub_content",get_the_ID());
               echo '</div>';
            }

            if(get_field("eating_sub_content",get_the_ID()))
            {
               echo '<div class="news_list_content">';
                  echo get_field("eating_sub_content",get_the_ID());
               echo '</div>';
            }

            if(get_field("park_sub_content",get_the_ID()))
            {
               echo '<div class="news_list_content">';
                  echo get_field("park_sub_content",get_the_ID());
               echo '</div>';
            }

            if(get_field("transport_sub_content",get_the_ID()))
            {
               echo '<div class="news_list_content">';
                  echo get_field("transport_sub_content",get_the_ID());
               echo '</div>';
            }
            if(get_field("school_sub_content",get_the_ID()))
            {
               echo '<div class="news_list_content">';
                  echo get_field("school_sub_content",get_the_ID());
               echo '</div>';
            }
         ?>
      </div>
      <?php  
         if(get_field("add_image",get_the_ID()))
         {
            echo '<div class="row">';
               echo '<div class="col-md-12">';
                  echo '<div class="multi_news_gallary">';
                   
                        while(has_sub_field("add_image",get_the_ID()))
                        {
                           $_img = get_sub_field("upload_image",get_the_ID());
                           echo '<div class="items">';
                              echo '<div class="item">';
                              echo '<img src="'.$_img['url'].'" alt="'.$_img['alt'].'">';
                              echo '</div>';
                           echo '</div>';
                        }
                   
                  echo '</div>';
               echo '</div>';
            echo '</div>';
         }
      ?>   
   </div>
</section>
<section class="council_tax">
   <div class="custom_container">
      <div class="row">
         <div class="col-md-6">
            <div class="council_tax_left">
               <?php echo get_field("map_description",get_the_ID());?>
               <div class="band">
                  <?php echo get_field("band_data",get_the_ID());?>
               </div>
            </div>
         </div>
         <?php if(get_field("map_image",get_the_ID())){ 
              $map_image = get_field("map_image",get_the_ID());
         ?>
         <div class="col-md-6 map_column">
            <div class="map">
               <img src="<?php echo $map_image['url'];?>" alt="<?php echo $map_image['alt'];?>">
            </div>
         </div>
         <?php } ?>
      </div>
   </div>
</section>
<?php if(get_field("area_property_content",get_the_ID())) { ?>
<section class="buy_rent">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <div class="inner_buy_rent">
               <?php echo get_field("area_property_content",get_the_ID());?>
               <div class="btn_grp">
                  <?php 
                     if(get_field("buy_btn_title",get_the_ID()))
                     {
                        echo '<a href="'.get_field("buy_btn_link",get_the_ID()).'">'.get_field("buy_btn_title",get_the_ID()).'</a>';

                        echo '<a href="'.get_field("rent_btn_link",get_the_ID()).'">'.get_field("rent_btn_title",get_the_ID()).'</a>';
                     }

                  ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<?php } ?>
</div>
<?php } } ?>

<?php get_footer(); ?>
<script>
         jQuery(document).ready(function($) {
             var right_value = $(".content-section .custom_container").offset().left;
             right_value = right_value + 30;
             $(".content-fullcolumn").css("margin-left", "-" + right_value + "px");
             $(".content-fullcolumn").css("padding-left", right_value + "px");
             var right_values = $(".content-section .custom_container").offset().left;
             right_values = right_values + 45;
             $(".image-col").css("margin-right", "-" + right_values + "px");
         });
         jQuery(window).resize(function($) {
             var right_value = $(".content-section .custom_container").offset().left;
             right_value = right_value + 30;
             $(".content-fullcolumn").css("margin-left", "-" + right_value + "px");
             $(".content-fullcolumn").css("padding-left", right_value + "px");
             var right_values = $(".content-section .custom_container").offset().left;
             right_values = right_values + 45;
             $(".image-col").css("margin-right", "-" + right_values + "px");
         });
         jQuery(window).scroll(function() {
             if (jQuery(window).width() > 767) {
                 var scroll_value = jQuery(window).scrollTop();
                 var bg_offset_value1 = jQuery(".content-section").offset().top;
                 if (jQuery(".content-section .whitebg-row .rightimage").length > 0) {
                     var translate_value = (bg_offset_value1 - scroll_value) / jQuery(window).height() * 20
                     jQuery(".content-section .whitebg-row .rightimage").css({
                         transform: 'translateY(' + (translate_value) + '%)' + 'translateZ(0px)'
                     });
                 }
             }
         });       
      </script>
