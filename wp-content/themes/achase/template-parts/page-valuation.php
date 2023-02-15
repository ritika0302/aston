<?php // Template Name: valuation ?>
<?php get_header(); ?>
<div id="content" class="push top-spacing">
   <?php //echo Fn_cms_inner_banner(get_the_ID());?>
   <?php
        /* Inner Banner */
        echo Fn_service_inner_banner(get_the_ID());
    ?>
   <?php $grid_blocks = get_field( '3_grid_blocks' ); 
      if( !empty($grid_blocks) ) :
   ?>
      <section>
         <div>
            <div class="custom_container medium_custom_container">
               <div class="our_services_text buying_services_text sell-us-block">
               <?php
                     if(get_field("scrolling_title",get_the_ID()))
                     {
                        echo '<div class="vertical-title wow fadeInDown">';
                              echo '<div class="sideline"></div>';
                              echo '<span>'.get_field("scrolling_title",get_the_ID()).'</span>';
                        echo '</div>';
                     }
                  ?>
                  <div class="inner_text col-grid-block">
                     <h2><?php echo get_field('section_title'); ?></h2>
                     <div class="list">
                        
                        <?php foreach ( $grid_blocks as $key => $g ) {
                           echo '<div class="text-col">';
                              echo '<h3>'.$g['title'].'</h3>';
                              echo $g['content'];
                           echo '</div>';
                        } ?>
                        
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
   <?php endif; ?>

			<div class="valuation-section style2">
            <div class="valuation-fullrow">
               <div class="container">
                  <div class="row">
                     <div class="col-sm-6 left-col">
                        <div class="left-content">
                           <div class="mobile-rightimage">
                              <?php 
                                 $featured_img_alt_text = get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true);
                                 $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); 

                              ?>
                           	<img src="<?php echo $featured_img_url;?>" alt="<?php echo $featured_img_alt_text;?>">
                           </div>
                        </div>
                        <div class="valuation-formcol">
                           <div class="title">
                                 <h3>Find out how much your home is worth</h3>
                              </div>
                           <?php 
                              $valuform = get_field("valuform_shortcode",get_the_ID());
                              echo do_shortcode($valuform);
                           ?>
                        </div>
                     </div>
                     <div class="col-sm-6 right-image">
                        <div class="image-col">
                           <div class="image">
                              <?php 
                                 $featured_img_alt_text = get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true);
                                 $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); 

                              ?>
                              <img src="<?php echo $featured_img_url;?>" alt="<?php echo $featured_img_alt_text;?>">
                           </div>
						      </div>
                     </div>
                  </div>
               </div>
            </div>
			</div>
         <div class="valuation-section property_slider">
            <div class="valuation-fullrow">
               <div class="container">
                  <div class="row">
                     <?php 
                     $no_disply_status_sale_prt = array('Completed','Exchanged','Sold');
                    
                     if(get_current_user_id() != '')
                     {
                        $logged_user_id = get_current_user_id();
                     }else
                     {
                        $logged_user_id = '';
                     }
                     
                     $subplot = array(
                        'relation' => 'OR',
                        array(
                            'key' => '_IsSubPlot',
                            'value' => 1,
                            'compare' => '==',
                        ) ,
                        array(
                            'key' => '_SubPlots',
                            'compare' => 'NOT EXISTS',
                        ) ,
                    );

                     $featu_propty_qry = new WP_Query(
                           array(
                             'post_type' => 'property',
                             'posts_per_page' => 10,
                             'post_status' => 'publish',
                             'meta_query'     => 
                             array(
                             'relation'     => 'AND',
                              array(
                                    'key'       => '_InternalSaleStatus',
                                    'value'     => $no_disply_status_sale_prt,
                                    'compare'   => 'IN',
                              ),
                              array(
                                'key'       => '_available',
                                 'value'     => 0,
                                 'compare'   => '==',
                             ),
                              $subplot,
                           ),
                        )  
                     );
                     if ( $featu_propty_qry->have_posts() ) {
                        echo '<section class="list_featured_properties wow fadeInUp" data-wow-delay="0.2s">';
                           echo '<div class="container">';
                              echo '<div class="row">';
                              echo '<div class="col-md-12">';
                                 echo '<h2 class="text-center">RECENTLY SOLD PROPERTIES</h2>';
                              echo '</div>';
                                 echo '<div class="col-md-12">';   
                                 echo '<span class="pagingInfo"></span>';   
                                    echo '<div class="list_properties_slider properties-row">';
                                       while ( $featu_propty_qry->have_posts() ) { 
                                       $featu_propty_qry->the_post();
                                       $property = new PH_Property( get_the_ID());
                                         $bannerSlides       = $property->get_gallery_attachment_ids();
                                       $_department           = get_post_meta(get_the_ID(),'_department',true);
                                       $_currency              = get_post_meta(get_the_ID(),'_currency',true);
                                       if($_currency == "GBP")
                                       {
                                          $currency = '£';
                                       }
                                       if($_department == "residential-sales")
                                       {
                                           $property_price = $property->get_formatted_price();
                                            $_status = get_post_meta(get_the_ID() , '_InternalSaleStatus', true);
                                       }else if($_department == "residential-lettings")
                                       {
                                          $_rent_frequency        = get_post_meta(get_the_ID(),'_rent_frequency',true);
                                          $_rent_price = str_replace("&#163;","",get_post_meta(get_the_ID(), '_rent',true));
                                           if($_rent_frequency == "pd")
                                            {
                                              $r_frequency = "per day";
                                            }else if($_rent_frequency == "pw")
                                            {
                                              $r_frequency = "per week";
                                            }else if($_rent_frequency == "pq")
                                            {
                                              $r_frequency = "per quarter";
                                            }else if($_rent_frequency == "pa")
                                            {
                                              $r_frequency = "per annum";
                                            }
                                          $cur_sybol = '£';
                                          $property_price = $cur_sybol.number_format($_rent_price,2, get_option('propertyhive_price_decimal_separator', '.'), get_option('propertyhive_price_thousand_separator', ','))." ".$r_frequency;
                                          $_status = get_post_meta(get_the_ID() , '_InternalLettingStatus', true);
                                       }

                                       $_address_street    = get_post_meta(get_the_ID(),'_address_street',true);
                                       $_address_two       = get_post_meta(get_the_ID(),'_address_two',true);
                                       $_address_three     = get_post_meta(get_the_ID(),'_address_three',true);
                                       $postcode         = explode(" ",get_post_meta(get_the_ID(),'_address_postcode',true));
                                       $_saved_prperty = get_post_meta(get_the_ID(),'saved_prperty',true);
                                       $_prperty_user_id = get_post_meta(get_the_ID(),'prperty_user_id',true);
                                       $_available = get_post_meta(get_the_ID() , '_available', true);
                                       if((isset($_saved_prperty) && $_saved_prperty == 1) && ($_prperty_user_id == $logged_user_id)) 
                                       {
                                          $saved_cls = "active";
                                          $faved_cls = "faved";
                                       }else
                                       {
                                          $saved_cls = "";
                                          $faved_cls = "";
                                       }

                                       echo '<div class="">';
                                          echo '<div class="savedproperties-col">';
                                             echo '<div class="properties-image '.$faved_cls.'">';
                                             if ($_available == 1 && $_status == "Under offer - Available")
                                             {
                                                 echo '<a href="' . get_permalink() . '" class="under_order">Under Offer</a>';
                                             }
                                             else if ($_status == "Arranging Tenancy - Unavailable")
                                             {
                                                 echo '<a href="' . get_permalink() . '" class="under_order">Under Offer</a>';
                                             }
                                             if ($_available == 0 && ($_status == "Completed" || $_status == "Exchanged" || $_status == "Sold"))
                                             {
                                                echo '<a href="' . get_permalink() . '" class="sold_out">Sold</a>';
                                             }
                                             echo '<a href="javascript:void(0);" class="heart '.$saved_cls.'" date-attr="'.$property->id.'" data-id="'.$logged_user_id.'"><i class="fa fa-heart-o" aria-hidden="true"></i></a>';  
                                             echo '<a href="'.get_permalink().'"><img src="'. wp_get_attachment_image_url($bannerSlides[0],"medium").'" alt=""></a>'; 
                                          echo '</div>';
                                          echo '<div class="properties-content">';
                                                echo '<div class="address">';
                                                   echo '<p><a href="'.get_permalink().'">'.$_address_street.', <br> '.$_address_two.' <br>'.$_address_three.', '.$postcode[0].'</a></p>'; 
                                                echo '</div>';
                                                echo '<div class="price">';
                                                   echo '<a href="'.get_permalink().'">'.strtoupper($property->tenure).'<span>'.$property_price.'</span></a>';  
                                                echo '</div>';  
                                             echo '</div>';
                                          echo '</div>';
                                       echo '</div>';   
                                       }
                                    echo '</div>';
                                 echo '</div>';
                              echo '</div>';
                           echo '</div>';
                        echo '</section>';
                     }wp_reset_postdata();
                     ?>
                  </div>
               </div>
            </div>
         </div>

         <section class="property-worthsection">
            <div class="container">
               <div class="property-worthcol property-worthcol-100">
                  <?php echo get_field('static_block'); ?>
               </div>
            </div>
         </section>
		</div>
<script>
jQuery(document).ready(function() {
	console.log(Cookies.get('pr_data'));
	var cookie_data = Cookies.get('pr_data');
	var r_val = '';
	jQuery('.radio-col input').each(function(){
		r_val = jQuery(this).attr('value');
	    console.log(r_val);
		if(r_val == 'LET' && cookie_data == 'let_property'){
			jQuery(this).attr('checked','checked');
		}
	});
	
});
</script>
<?php get_footer(); ?>