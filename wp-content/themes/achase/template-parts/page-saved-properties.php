<?php // Template Name: Saved Properties ?>
<?php 
   if(!is_user_logged_in())
   {
      wp_redirect(home_url());die();
   }
?>
<?php get_header(); ?>
<?php
$user_data = wp_get_current_user();

?>
<div id="content" class="top-spacing">

   <div class="savedproperties-section">
      <div class="container">
         <div class="headings">
             <h2>Welcome back <?php echo ucwords(str_replace("-"," ",$user_data->data->display_name));?>.</h2>
         </div>
         <div class="linklist-row">
            <div class="dropdown-btn">Favourite PROPERTIES</div>
            <ul class="dropdown-list">
               <li class="active"><a href="<?php echo get_permalink();?>">Favourite PROPERTIES</a></li>
               <li><a href="<?php echo get_permalink(13797);?>">Saved Searches</a></li>
               <li><a href="<?php echo get_field("global_login_redirect","option");?>">My profile</a></li>
			   <li><a href="<?php echo get_permalink(27328);?>">Change Password</a></li>
               <li><a href="<?php echo wp_logout_url(get_field("global_logout_redirect","option"));?>">LOGOUT</a></li>
            </ul>
         </div>
         <div class="headings">
            <h3><?php the_title();?></h3>
            <?php the_content();?>
         </div>
         <div class="properties-row">
            <div class="row">
               <div class="submit-loder"><img src="<?php echo get_template_directory_uri();?>/assets/images/ajax-loader.gif"></div>
               <div class="saved-alert"></div>
               <?php 
                  $_args = array(
                        'post_type'       => 'property',
                        'posts_per_page'    => -1,
                        'meta_query'     => array(
                           'relation'       => 'AND',
                             array(
                                 'key'       => 'saved_prperty',
                                 'value'     => 1,
                                 'compare'   => '==',
                             ),
                             array(
                                 'key'       => 'prperty_user_id',
                                 'value'     => $user_data->ID,
                                 'compare'   => '==',
                             ),
                          ),
                        );      
                  $saved_proty = new WP_Query($_args);
                  if ($saved_proty->have_posts() ) { 
                     while ( $saved_proty->have_posts() ) { $saved_proty->the_post();
                        $property              = new PH_Property( get_the_ID());
                        $ImageSlides   = $property->get_gallery_attachment_ids();
                        echo '<div class="col-sm-4">';      
                           echo '<div class="savedproperties-col">';
                              echo '<a href="javascript:void(0);" id="'.get_the_ID().'" data-id ="'.$user_data->ID.'" class="remove"><i class="fa fa-minus-circle"></i></a>';
                              echo '<div class="properties-image">';
                                 echo '<a href="'.get_permalink().'"><img src="'. wp_get_attachment_image_url($ImageSlides[0],'medium').'" alt="'.get_the_title().'"></a>';
                              echo '</div>';
                              echo '<div class="properties-content saved-content">';
                                 echo '<div class="address">';
                                    echo '<p>'.get_the_title().'</p>';
                                 echo '</div>';
                                 echo '<div class="price">';
                                    echo strtoupper($property->tenure) .'<span>'.$property->get_formatted_price().'</span>';
                                 echo '</div>';   
                              echo '</div>';
                           echo '</div>';
                        echo '</div>';

                     }
                     wp_reset_postdata();
                  }else
                  {
                     echo '<div class="col-md-12">';  
                        echo "<div class='no-proty'>You do not currently have any saved properties.</div>";
                     echo '</div>';   
                  }
                ?>
               
            </div>
         </div>
      </div>
   </div>

</div>

<?php get_footer(); ?>