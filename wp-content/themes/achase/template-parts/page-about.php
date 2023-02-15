<?php // Template Name: About-us ?>
<?php get_header(); ?>

<div id="content" class="top-spacing">
    <?php echo Fn_cms_inner_banner(get_the_ID());?>
  <?php if(the_acf_group_fields('about_main_section','description') != '' ||
        the_acf_group_fields('about_main_section','video') != '') { ?>	
    <div class="aboutus-section wow fadeInUp">
       	<div class="container">
          	<?php if(the_acf_group_fields('about_main_section','description') != '') { ?>
            <div class="headings">
             	<?php echo the_acf_group_fields('about_main_section','description'); ?>
          	</div>
            <?php } ?>
            <?php if(the_acf_group_fields('about_main_section','video') != '') { ?>
          	<div class="video-section">
             	<img src="<?php echo the_acf_group_fields('about_main_section','video'); ?>" alt="video-img">
          	</div>
           <?php }else{ ?>
            <div class="vertical-title wow fadeInDown">
                <div class="sideline"></div>
                <span><?php echo the_acf_group_fields('about_aston_chase_section','section_heading'); ?></span>
            </div>
           <?php } ?>
       	</div>
    </div>
    <?php } ?>
    <div class="aboutaston-section wow fadeInUp">
       	<div class="container">
          	<?php if(the_acf_group_fields('about_main_section','video') != '') { ?>
            <div class="vertical-title wow fadeInDown">
             	<div class="sideline"></div>
             	<span><?php echo the_acf_group_fields('about_aston_chase_section','section_heading'); ?></span>
          	</div>
            <?php } ?>
          	<div class="towcol-row">
             	<div class="row">
                	<div class="col-sm-6 leftcol">
                   		<div class="aboutaston-col">
                      		<div class="aboutaston-row">
                         		<h3><?php echo the_acf_group_fields('about_aston_chase_section','title'); ?></h3>
                         		<p><?php echo the_acf_group_fields('about_aston_chase_section','description'); ?></p>
                         		<?php if(the_acf_group_fields('about_aston_chase_section','button_link') != '' && the_acf_group_fields('about_aston_chase_section','button_text') != '') { ?>
                                    <a href="<?php echo the_acf_group_fields('about_aston_chase_section','button_link'); ?>" class="black-linkbtn"><?php echo the_acf_group_fields('about_aston_chase_section','button_text'); ?></a>
                                <?php } ?>
                      		</div>
                   		</div>
                	</div>
                	<div class="col-sm-6 rightimage">
                   		<div class="image-col">
                      		<img src="<?php echo the_acf_group_fields('about_aston_chase_section','side_image_'); ?>">
                   		</div>
                	</div>
             	</div>
          	</div>
       	</div>
    </div>

    <div class="aboutproperty-section wow fadeInUp">
       	<div class="container">
          	<div class="vertical-title wow fadeInDown">
             	<div class="sideline"></div>
             	<span><?php echo the_acf_group_fields('about_property_focused_section','section_heading'); ?></span>
          	</div>
          	<div class="towcol-row">
             	<div class="row">
                	<div class="col-sm-6 leftcol">
                   		<div class="right-content">
                      		<h3><?php echo the_acf_group_fields('about_property_focused_section','title'); ?></h3>
                   		</div>
	                   	<div class="mobile-image">
	                      	<img src="<?php echo the_acf_group_fields('about_property_focused_section','side_image'); ?>">
	                   	</div>
	                   	<div class="aboutproperty-col" style="margin-right: -30px; padding-right: 30px;">
	                      	<div class="aboutproperty-content">
	                         	<p>
	                            	<?php echo the_acf_group_fields('about_property_focused_section','description'); ?>
	                         	</p>
	                      	</div>
	                   	</div>
                	</div>
	                <div class="col-sm-6 rightimage">
	                   <div class="image-col">
	                      <img src="<?php echo the_acf_group_fields('about_property_focused_section','side_image'); ?>">
	                   </div>
	                </div>
             	</div>
          	</div>
       	</div>
    </div>
    <div class="meettheteam-section wow fadeInUp" id="team">
    	<div class="container">
	       	<div class="headings">
	                <h2>Meet the team</h2>
	                <div id="js-filters-lightbox-gallery1" class="cbp-l-filters-button cbp-l-filters-left button-group filters-button-group">

	                    <div data-filter="*" class="button cbp-filter-item-active cbp-filter-item">All</div>
	                    	
	                    <?php 

	                    $taxonomies = get_terms( array(
						    'taxonomy' => 'team-category',
						    'hide_empty' => false
						) );
						 
						if ( !empty($taxonomies) ) :

						    foreach( $taxonomies as $category ) {
						
						        if( $category->parent == 0 ) {

			                    	echo '<div 	data-filter=".'.$category->slug.'" 
			                    				class="button cbp-filter-item" >'. 
			                    				$category->name.' 
			                    		</div>';

						        }

						    }

						endif;

	                    ?>
	                </div>
	            </div>
	       	<div class="masonry">
	       		<div class="grid cbp" id="js-grid-lightbox-gallery">
	       			
	       			<?php 

	       				$args = array(
						  'numberposts' => -1,
						  'post_status'    => 'publish',
						  'post_type'   => 'team',
						  'orderby'          => 'date',
					        'order'            => 'ASC',
						);
						$team = get_posts( $args );
						 
						foreach ($team as $member) {
							$member_id = $member->ID;
							$member_name = $member->post_title;
							$member_acf_data = get_field('team_member_information', $member_id );
							$member_position = $member_acf_data['position'];
							$member_email = $member_acf_data['e-mail'];
							$member_phone = $member_acf_data['phone'];
							$member_business_card = $member_acf_data['business_card'];
							$member_profile_image_url = get_the_post_thumbnail_url($member_id, 'full');
							
							$category = get_the_terms( $member_id, 'team-category' );
							$temp = '';
							if(!empty($category))
                            {
                                foreach ( $category as $cat){
    							     $member_category_slug = array();     
    							     $member_category_name = $cat->name;
    							     $member_category_slug = $cat->slug;
    							     $temp .= $member_category_slug.' ';
    							}
                            }
                            $nonce = wp_create_nonce( 'team-id' ); ?>
			       			<div class="element-item cbp-item <?php echo $temp; ?>" data-category="<?php echo $member_category_slug; ?>">
                                <div class="team-block">
                                    <div class="img">
                                        <a id="<?php echo $member_id;?>" href="<?php echo home_url('/team-data-page').'?post_id='.$member_id.'&_wpnonce='.$nonce; ?>" class="cbp-caption cbp-singlePageInline" rel="nofollow">
                                            <img src="<?php echo $member_profile_image_url ; ?>" alt="">
                                        </a>
                                    </div>
                                    <div class="content">
                                        <div class="name"><a href="<?php echo home_url('/team-data-page').'?post_id='.$member_id.'&_wpnonce='.$nonce; ?>" class="cbp-caption cbp-singlePageInline" rel="nofollow"><?php echo $member_name; ?></a></div>
                                        <span><?php echo $member_position; ?></span>
                                        <p>
    			                            <a href="mailto:<?php echo $member_email ; ?>">Email me</a><br>
                                            <a href="<?php echo $member_business_card; ?>" download="">Download</a> Business Card 
    			                            
                                        </p>
                                    </div>
                                </div>
                            </div> <?php
						} 
                    ?>
	       		</div>
	       	</div>
       	</div>
    </div>
</div>
<input type="hidden" name="mid" class="mid" value="<?php echo @$_GET['mid'];?>">
<script type="text/javascript">
         jQuery(document).ready(function(){
            var right_value = jQuery(".aboutaston-section .container").offset().left;
             right_value = right_value + 30;
             jQuery(".aboutaston-col").css("margin-left","-"+ right_value +"px");
             jQuery(".aboutaston-col").css("padding-left", right_value + "px");
         
             var right_value = jQuery(".aboutproperty-section .container").offset().left;
             right_value = right_value + 30;
             jQuery(".aboutproperty-col").css("margin-right","-"+ right_value +"px");
             jQuery(".aboutproperty-col").css("padding-right", right_value + "px");
         	var mid = jQuery(".mid").val();
         	
         	if(mid != '')
         	{
         		jQuery("#"+mid).click();
         	}
         });
         
         jQuery(window).resize(function(){
            var right_value = jQuery(".aboutaston-section .container").offset().left;
             right_value = right_value + 30;
             jQuery(".aboutaston-col").css("margin-left","-"+ right_value +"px");
             jQuery(".aboutaston-col").css("padding-left", right_value + "px");
         
             var right_value = jQuery(".aboutproperty-section .container").offset().left;
             right_value = right_value + 30;
             jQuery(".aboutproperty-col").css("margin-right","-"+ right_value +"px");
             jQuery(".aboutproperty-col").css("padding-right", right_value + "px");
         });    
         
         jQuery(window).scroll(function() {
            if(jQuery(window).width() > 767){
               var scroll_value = jQuery(window).scrollTop();
               var bg_offset_value1 = jQuery(".aboutaston-section").offset().top;
               if( jQuery(".aboutaston-section .rightimage").length > 0){ 
                  var translate_value =  (bg_offset_value1 - scroll_value) / jQuery(window).height() * 20
                  jQuery(".aboutaston-section .rightimage").css({transform: 'translateY(' + (translate_value) +'%)' + 'translateZ(0px)'});
               }
            }
         });

          var $resizeTimer;
             jQuery(window).on("resize", function(e){  
               contentBg();
           });

         function contentBg(){
             var $teamWrap = jQuery(".container").width();
             var $windowWidth = jQuery(window).width();
             var $widthDiffer = $windowWidth - $teamWrap;
             var $halfWidth = $widthDiffer / 2;

             if(jQuery(".team_section").length){
               jQuery(".team_section").css({
                 'padding-left' : $halfWidth +'px',
                 'margin-left' : $halfWidth * -1 + 'px',
                 'padding-right' : $halfWidth +'px',
                 'margin-right' : $halfWidth * -1 + 'px'
               });
             

               jQuery(".cbp-media").children('img').each(function(e){
                 var $that = jQuery(this);
                 var $imgHeight = $that.height();
                 if(jQuery(window).width() < 768 && jQuery(window).width() > 639){
                   $that.parents(".cbp-user-left").css('height', $imgHeight +'px');
                 }else{
                   $that.parents(".cbp-user-left").css('height', 'auto');
                 }
               });
             }
           }


         (function($, window, document, undefined) {
             'use strict';

             // init cubeportfolio
             jQuery('#js-grid-lightbox-gallery').cubeportfolio({
                 filters: '#js-filters-lightbox-gallery1, #js-filters-lightbox-gallery2',
                 loadMore: '#js-loadMore-lightbox-gallery',
                 loadMoreAction: 'click',
                 layoutMode: 'grid',
                 
                  gapHorizontal: 0,
                  gapVertical: 0,
                  gridAdjustment: 'responsive',
                
                 // singlePageInline
                 singlePageInlineDelegate: '.cbp-singlePageInline',
                 singlePageInlinePosition: 'below',
                 singlePageInlineInFocus: true,
                 singlePageInlineCallback: function(url, element) {
                     
                     var t = this;

                     jQuery.ajax({
                             url: url,
                             type: 'GET',
                             dataType: 'html',
                             timeout: 30000
                         })
                         .done(function(result) {

                             t.updateSinglePageInline(result);
                             contentBg();

                         })
                         .fail(function() {
                             t.updateSinglePageInline('AJAX Error! Please refresh the page!');
                         });
                 },
             });
         })(jQuery, window, document);
      </script>

<?php get_footer(); ?>