<?php // Template Name: Service Detail ?>
<?php get_header(); ?>
<div id="content" class="push top-spacing">
<?php
	$content_cls = ''; 
	
	if(get_the_ID() == 27045)
	{
		$content_cls = "letting_content_section";
	}elseif(get_the_ID() == 27039)
	{
		$content_cls = "property_content_section";
	}

	
	/* Inner Banner */
	echo Fn_service_inner_banner(get_the_ID());

	/* Content Blocks*/

	
	if(get_field("ser_add_button",get_the_ID()))
	{
	echo '<section class="sticky_btn_content_section">';
		echo '<div class="sticky_btn_grp">';
			echo '<div class="custom_container medium_custom_container">';	
				echo '<div class="btn_grp">';
					echo '<ul>';
						while (has_sub_field("ser_add_button",get_the_ID())) {
							if(get_sub_field("cta_btn_link",get_the_ID()))
							{
								if( get_sub_field("cta_btn_link",get_the_ID()) == get_permalink( get_the_ID() ) ){
									$active = 'class="active"';
								} else {
									$active = '';
								}
								echo '<li '.$active.'><a href="'.get_sub_field("cta_btn_link",get_the_ID()).'">'.get_sub_field("cta_btn_title",get_the_ID()).'</a></li>';
							}
						}
					echo '</ul>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}else{
		echo '<section>';
	}

	echo '<div>';
		echo '<div class="custom_container medium_custom_container">';
		$class_name = "";
		if( $post->post_name == "sell-with-us" ){
			$class_name = "sell-us-block";
		}
			echo '<div class="our_services_text buying_services_text '.$class_name.'">';	
				if(get_field("scrolling_title",get_the_ID()))
				{
					echo '<div class="vertical-title wow fadeInDown">';
						echo '<div class="sideline"></div>';
						echo '<span>'.get_field("scrolling_title",get_the_ID()).'</span>';
					echo '</div>';
				}	

				if( !empty(get_field('3_grid_section')) ){
					echo '<div class="inner_text col-grid-block">';
					echo '<h2>'.get_field('sectiontitle').'</h2>';
						$grid_section = get_field('3_grid_section');
						echo '<div class="list">';
							foreach ( $grid_section as $key => $value) {
								echo '<div class="text-col">';
									echo '<h3>'.$value['title'].'</h3>';
									echo '<p>'.$value['content'].'</p>';
								echo '</div>';
							}
						echo '</div>';
				} else {
					echo '<div class="inner_text">';
						echo get_the_content();
				}

				if(get_field("ser_profile_desc",get_the_ID()) && !empty(get_field("ser_profile_image",get_the_ID())))
				{	
					$ser_prof_img = get_field("ser_profile_image",get_the_ID());
					echo '<div class="get_gouch_contact">';
						echo '<img src="'.$ser_prof_img['url'].'" alt="'.$ser_prof_img['url'].'">';
						echo '<div class="text">';
							echo get_field("ser_profile_desc",get_the_ID());
						echo '</div>';
					echo '</div>';
				}
				echo '</div>';
			echo '</div>';
		echo '</div>';
	echo '</div>';
	echo '</section>';

	/* Content Block End */

 /* New home Block */
if($post->ID == 27047)
{


$master_propty_qry = new WP_Query(
   	array(
      'post_type' => 'property',
      'posts_per_page' => -1,
      'post_status' => 'publish',
      'meta_query'     => 
			      array(
						array(
			            'key' => '_SubPlots',
			            'value' => 'yes',
			            'compare' => '==',
			    	),
				),
  )
);
if ( $master_propty_qry->have_posts() ) {
    echo '<section class="new_home_dev_sale closely_related ">';
	    echo '<div class="custom_container medium_custom_container">';
	   		echo '<h3 class="title">'.$master_propty_qry->found_posts.' NEW HOME DEVELOPMENTS FOR SALE</h3>';
	   		$pstus = '';
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
			$pstus = array(
					        'key'       => '_InternalSaleStatus',
				          	'value'     => array('For Sale - Unavailable','Completed - Available','Exchanged - Available'),
				          	'compare' 	=> 'NOT IN',
							);
			$c_home = array();
	   		 $i=1;
	   		 while ( $master_propty_qry->have_posts() ) { $master_propty_qry->the_post();
	   		 	$minsize = '';
				$maxsize = '';
				$minbed = '';
				$maxbed = '';
				$min_price = '';
				$max_price = '';
	   		 	$property = new PH_Property(get_the_ID());
                $ImageSlides = $property->get_gallery_attachment_ids();
                $c_home = explode(",",get_the_title());
                $_propty_short_desc = get_the_excerpt();
                
                $p_ser = str_replace("\'", "&#039;", ucwords($c_home[0]));
		        $parea = array(
		            'relation' => 'OR',
		             array(
		                'key' => '_address_street',
		                'value' => $p_ser,
		                'compare' => 'Like',
		            ) ,
		            array(
		                'key' => '_address_two',
		                'value' => $p_ser,
		                'compare' => 'Like',
		            ) ,
		            array(
		                'key' => '_address_three',
		                'value' => $p_ser,
		                'compare' => 'Like',
		            ) ,
		            array(
		                'key' => '_address_postcode',
		                'value' => $p_ser,
		                'compare' => 'Like',
		            )
		        );

		        $child_data = new WP_Query(
		           	array(
		              'post_type' 		=> 'property',
		              'posts_per_page' 	=> -1,
		              'post_status' 	=> 'publish',
		              'meta_query'      =>array(
		               	'relation'  => 'AND',
		               			array(
				                	'key'       => '_department',
					            	'value'     => 'residential-sales',
					            	'compare'   => '==',
			        				),
			        				$pstus,
			        				$subplot,
			        				$parea,
		 						),
		          			)
		        		);
		       		$_size = array();
		       		$_bed  = array();
		       		$_price  = array();
		       		$child_cnt_prt = '';
		        	if ( $child_data->have_posts() ) {
		        		$child_cnt_prt = $child_data->found_posts;
		  			    while ( $child_data->have_posts() ) {
		        			$child_data->the_post();
		        			$_size[]   = get_post_meta(get_the_ID(),"_size",true);
		        			$_bed[]    = get_post_meta(get_the_ID() , '_bedrooms', true);
		        			$_price[]  = get_post_meta(get_the_ID() , '_price', true);
		        		}
		        	}
		        	
		        	@$minsize = min($_size);
					@$maxsize = max($_size);
					@$minbed = min($_bed);
					@$maxbed = max($_bed);
					@$min_price = '£'.number_format(min($_price));
					@$max_price = '£'.number_format(max($_price));
					

	   		 	echo '<div class="new_home_dev_sale_item">';
		        	echo '<div class="inner_grid">';
		        		echo '<div class="row">';
		        			echo '<div class="col-md-5 padding_r">';
		        				echo '<div class="savedproperties-col">';
		        					echo '<div class="properties-image">';
		        						echo '<a href="'.get_permalink().'"><img src="' . wp_get_attachment_image_url(@$ImageSlides[0], "medium") . '" alt="property_img_'.$i.'"></a>';
		        					echo '</div>';
		        				echo '</div>';
		        			echo '</div>';
		        			echo '<div class="col-md-7 left padding_l">';
		        				echo '<div class="row">';
		        					echo '<div class="col-md-6 middle">';
		        						echo '<ul class="four_hous">';
		        							if (isset($ImageSlides[1]) && $ImageSlides[1] != '')
					                        {
					                            echo '<li><a href="' . get_permalink() . '"><img src="' . wp_get_attachment_image_url($ImageSlides[1], "medium") . '"></a></li>';
					                        }
					                        if (isset($ImageSlides[2]) && $ImageSlides[2] != '')
					                        {
					                            echo '<li><a href="' . get_permalink() . '"><img src="' . wp_get_attachment_image_url($ImageSlides[2], "medium") . '"></a></li>';
					                        }
					                        if (isset($ImageSlides[3]) && $ImageSlides[3] != '')
					                        {
					                            echo '<li><a href="' . get_permalink() . '"><img src="' . wp_get_attachment_image_url($ImageSlides[3], "medium") . '"></a></li>';
					                        }
					                        if (isset($ImageSlides[4]) && $ImageSlides[4] != '')
					                        {
					                            echo '<li><a href="' . get_permalink() . '"><img src="' . wp_get_attachment_image_url($ImageSlides[4], "medium") . '"></a></li>';
					                        }
		        						echo '</ul>';
		        					echo '</div>';
		        					echo '<div class="col-md-6 middle">';
		        						echo '<div class="inner_content">';
		        							echo '<h4>'.$c_home[0].'</h4>';
		        							echo '<h5>'.substr(strstr(get_the_title(),","), 1).'</h5>';
		        							echo '<p>' . substr($_propty_short_desc, 0, 180) . '…</p>';
		        							echo '<ul class="list-inline rooms_item">';
		        								if(count($_size)>1)
		        								{
		        									echo '<li><img src="' . get_template_directory_uri() . '/assets/images/sq-ft.png" alt="img">'.number_format($minsize).' sq ft  — '.number_format($maxsize).' sq ft</li>';
		        								}else
		        								{
		        									echo '<li><img src="' . get_template_directory_uri() . '/assets/images/sq-ft.png" alt="img">'.number_format($minsize).' sq ft</li>';
		        								}
		        								if(count($_bed)>1)
		        								{
		        									echo '<li><img src="' . get_template_directory_uri() . '/assets/images/bathrooms2.png" alt="img">'.$minbed.' — '.$maxbed.'</li>';
		        								}else
		        								{
		        									echo '<li><img src="' . get_template_directory_uri() . '/assets/images/bathrooms2.png" alt="img">'.$minbed.'</li>';
		        								}
		        							echo '</ul>';
		        							if(count($_price)>1)
		        							{
			        							echo '<ul class="hold_price">';
			        								echo '<li>'.$min_price.' — '.$max_price.' </li>';
			        							echo '</ul>';
		        							}else
		        							{
		        								echo '<ul class="hold_price">';
			        								echo '<li>'.$min_price.'</li>';
			        							echo '</ul>';
		        							}
		        						echo '</div>';
		        					echo '</div>';
		        				echo '</div>';
		        			echo '</div>';
			      		echo '</div>';
	        		echo '</div>';
	        		echo '<div class="available_row">';
	        			if($child_cnt_prt != '')
	        			{
		        			if($child_cnt_prt > 1)
		        			{
		        				echo '<h3>'.$child_cnt_prt.' new homes available for sale</h3>';
		        			}else
		        			{
		        				echo '<h3>'.$child_cnt_prt.' new home available for sale</h3>';
		        			}
	        			}else
	        			{
	        				echo '<h3>0 new home available for sale</h3>';
	        			}
	        			echo '<a href="'.get_permalink(27066).'?pid='.get_the_ID().'">Learn more</a>';
	        		echo '</div>';
	        	echo '</div>';
	        	wp_reset_postdata();
	    	 $i++;	
	    	}
	    	
    	echo '</div>';
    echo '</section>';
   

} wp_reset_postdata();	   
}  		
if( !empty(get_field("ser_top_description",get_the_ID())) ):
	echo '<section class="content-section buying_content_section">';
		echo '<div class="custom_container medium_custom_container">';	
			echo '<div class="towcolumn-row">';
				echo '<div class="row">';
					echo '<div class="col-sm-7 leftcol">';
						echo '<div class="content-fullcolumn">';
							echo '<div class="content-column">';
								echo get_field("ser_top_description",get_the_ID());
							echo '</div>';
						echo '</div>';
					echo '</div>';
					echo '<div class="col-sm-5 rightimage">';
						echo '<div class="image-col">';
							$ser_top_content_img_one = get_field("ser_top_content_img_one",get_the_ID());
							echo '<div class="image">';
								echo '<img src="'.$ser_top_content_img_one['url'].'" alt="'.$ser_top_content_img_one['alt'].'">';
							echo '</div>';
							if( $post->post_name != "investment" ) {
								echo '<div class="vertical-title wow fadeInDown">';
									echo '<div class="sideline"></div>';
									echo '<span>ASTON CHASE</span>';
								echo '</div>';
							}
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		
		if( !empty(get_field("ser_mid_full_column_content",get_the_ID())) || !empty( get_field("ser_top_content_img_two",get_the_ID()) ) ):
			echo '<div class="towcolumn-row whitebg-row">';
				echo '<div class="row">';
					if(get_field("ser_mid_content_layout",get_the_ID()) == "one_clou" && get_field("ser_mid_full_column_content",get_the_ID()))
					{
						echo '<div class="col-sm-6 leftcol">';
							echo '<div class="content-fullcolumn">';	
								echo '<div class="content-column">';
									echo get_field("ser_mid_full_column_content",get_the_ID());
								echo '</div>';
							echo '</div>';
						echo '</div>';	
					}
					echo '<div class="col-sm-6 rightimage">';
						$ser_top_content_img_two = get_field("ser_top_content_img_two",get_the_ID());
						echo '<div class="image-column">';
							echo '<img src="'.$ser_top_content_img_two['url'].'" alt="'.$ser_top_content_img_two['alt'].'" >';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		endif;

		echo '</div>';
	echo '</section>';
endif;
	if(get_field("ser_mid_content_layout",get_the_ID()) == "two_clou")
	{
		if(get_field("ser_mid_content_layout",get_the_ID()) || get_field("ser_mid_right_column_content",get_the_ID()))
		{
			echo '<section class="tenant_fees">';
				echo '<div class="custom_container medium_custom_container">';
					echo '<div class="row">';
						if(get_field("ser_mid_left_column_content",get_the_ID()))
						{
							echo '<div class="col-md-5">';
								echo get_field("ser_mid_left_column_content",get_the_ID());
							echo '</div>';
						}
						if(get_field("ser_mid_right_column_content",get_the_ID()))
						{
							echo '<div class="col-md-7">';
								echo '<div class="landlord_fees">';
									echo get_field("ser_mid_right_column_content",get_the_ID());
								echo '</div>';
								if(get_field("ser_proty_content",get_the_ID()))
								{
									echo '<div class="grey_box">';	
									echo '<div class="btn_logo">';	
										echo get_field("ser_proty_content",get_the_ID());
									echo '</div>';	
									echo '</div>';
								}	
							echo '</div>';
						}

					echo '</div>';
				echo '</div>';
			echo '</section>';
		}
	}

			

/* Slider Block*/
if(get_field("ser_show_slider",get_the_ID()))
{
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


	if(get_field("ser_slider_type",get_the_ID()) == "feau")
	{
		$no_disply_status_sale_prt = array(
	        'For Sale - Unavailable',
	        'Completed - Available',
	        'Exchanged - Available',
	        'Sold',
	        'Completed',
	        'Exchanged'
	    );

	    if(get_current_user_id() != '')
	    {
	        $logged_user_id = get_current_user_id();
	    }else
	    {
	        $logged_user_id = '';
	    }

		$featu_propty_qry = new WP_Query(
           	array(
              'post_type' => 'property',
              'posts_per_page' => -1,
              'post_status' => 'publish',
              'meta_query'     => 
               array(
				'	relation'		=> 'AND',
					array(
			            'key'       => '_department',
			            'value'     => 'residential-sales',
			            'compare' 	=> '==',
			        ),
			        array(
                        'key'       => '_InternalSaleStatus',
                        'value'     => $no_disply_status_sale_prt,
                        'compare'   => 'NOT IN',
                    ),
			        array(
			            'key'       => '_featured',
			            'value'     => 'yes',
			            'compare' 	=> '==',
			        ),
			        $subplot,
		    		),
              	)	
			); 


	}else if(get_field("ser_slider_type",get_the_ID()) == "sold")
	{
		$no_disply_status_sale_prt = array('Completed','Exchanged','Sold');

		if(get_current_user_id() != '')
	    {
	        $logged_user_id = get_current_user_id();
	    }else
	    {
	        $logged_user_id = '';
	    }
	   
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
			            'key'       => '_department',
			            'value'     => 'residential-sales',
			            'compare' 	=> '==',
			        ),
			        array(
			            'key' => '_SubPlots',
			            'value' => 'yes',
			            'compare' => '==',
			    	),
			        
               ),
            )  
         );
	}

	if ( $featu_propty_qry->have_posts() ) {
	echo '<section class="list_featured_properties buying_list_featured_properties wow fadeInUp" data-wow-delay="0.2s">';
		echo '<div class="container">';
			echo '<div class="row">';
				echo '<div class="col-md-12">';
					echo '<h2 class="text-center">'.get_field("ser_slid_main_heading",get_the_ID()).'</h2>';
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
	                       $_available = get_post_meta(get_the_ID() , '_available', true);
	                        $_status = get_post_meta(get_the_ID() , '_InternalSaleStatus', true);
	                       if($_currency == "GBP")
	                       {
	                          $currency = '£';
	                       }
	                       if($_department == "residential-sales")
	                       {
	                           $property_price = $property->get_formatted_price();
	                       }else if($_department == "residential-lettings")
	                       {
	                          $_rent_frequency        = get_post_meta(get_the_ID(),'_rent_frequency',true);
	                          $_rent_price = str_replace("&#163;","",get_post_meta(get_the_ID(), '_rent',true));
	                          
	                          $property_price = $property->get_formatted_price();
	                       }

	                       $_address_street    = get_post_meta(get_the_ID(),'_address_street',true);
	                       $_address_two       = get_post_meta(get_the_ID(),'_address_two',true);
	                       $_address_three     = get_post_meta(get_the_ID(),'_address_three',true);
	                       $postcode         = explode(" ",get_post_meta(get_the_ID(),'_address_postcode',true));
	                       $_saved_prperty = get_post_meta(get_the_ID(),'saved_prperty',true);
	                       $_prperty_user_id = get_post_meta(get_the_ID(),'prperty_user_id',true);
	                       $_PriceString = get_post_meta(get_the_ID(),'_price_qualifier',true);
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
                               	
                               	if ($_available == 0 && ($_status == "Completed" || $_status == "Exchanged" || $_status == "Sold"))
		                        {
		                            echo '<a href="' . get_permalink() . '" class="sold_out">Sold</a>';
		                        }
		                        if ($_available == 1 && $_status == "Under offer - Available")
	                            {
	                                 echo '<a href="' . get_permalink() . '" class="under_order">Under Offer</a>';
	                            }
	                             echo '<a href="javascript:void(0);" class="heart '.$saved_cls.'" date-attr="'.$property->id.'" data-id="'.$logged_user_id.'"><i class="fa fa-heart-o" aria-hidden="true"></i></a>';  
	                             echo '<a href="'.get_permalink().'"><img src="'. wp_get_attachment_image_url($bannerSlides[0],"medium").'" alt=""></a>'; 
	                          echo '</div>';
	                          echo '<div class="properties-content">';
	                                echo '<div class="address">';
	                                   echo '<p><a href="'.get_permalink().'">'.$_address_street.', <br> '.$_address_two.' <br>'.$_address_three.', '.$postcode[0].'</a></p>'; 
	                                echo '</div>';
	                                echo '<div class="price">';
	                                   if($_PriceString == "PA")
																		{
	                                    echo '<a href="'.get_permalink().'">'.strtoupper($property->tenure).'<span>Price on Application</span></a>';  
	                                  }else
	                                  {
	                                  	 echo '<a href="'.get_permalink().'">'.strtoupper($property->tenure).'<span>'.$property_price.'</span></a>';  
	                                  }
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
	} wp_reset_postdata();
}

/* Static Content Banner Block */
if(get_field("ser_static_block_content",get_the_ID()))
{
	echo '<section class="property-worthsection">';
		echo '<div class="container">';
			echo '<div class="property-worthcol property-worthcol-100">';
				echo get_field("ser_static_block_content",get_the_ID());			
			echo '</div>';
		echo '</section>';
	echo '</section>';
}

/* Service Block*/
if(get_field("add_service",get_the_ID()))
{
	echo '<section class="buying_gallary">';
		echo '<div class="buying_gallary_items">';
			while (has_sub_field("add_service",get_the_ID())) {
				echo '<div class="buying_gallary_item">';
					echo '<div class="inner_buying_gallary_item">';
						if(get_sub_field("ser_link",get_the_ID()))
						{
							echo '<a href="'.get_sub_field("ser_link",get_the_ID()).'" class="overlay"></a>';
						}
						$ser_ban_image = get_sub_field("ser_ban_image",get_the_ID());
						if(!empty($ser_ban_image))
						{
							echo '<img src="'.$ser_ban_image['url'].'" alt="'.$ser_ban_image['alt'].'">';
						}
						echo '<h4>'.get_sub_field("ser_title",get_the_ID()).'</h4>';
					echo '</div>';
				echo '</div>';
			}
		echo '</div>';
	echo '</section>';	
}

?>
</div>
<script type="text/javascript">
	
  /* Service Code */
  jQuery(window).scroll(function (event) {
  	var scrollStop = jQuery(".sticky_btn_content_section").offset().top;
      if(scrollStop < jQuery(window).scrollTop())
      {
        jQuery(".sticky_btn_grp").addClass("sticky-on");
      }
      else
      {
        jQuery(".sticky_btn_grp").removeClass("sticky-on");
      }
  });

  jQuery(document).ready(function() {

  	jQuery('.booknow-btn').click(function(){
	  var l_url = jQuery(this).attr("href");
	  var l_data = jQuery(this).attr("data-let");
	  var date = new Date();
      date.setTime(date.getTime() + (5 * 1000));
	  Cookies.set('pr_data', l_data, { expires: date });
	  console.log(Cookies.get('pr_data'));
  });

  var right_value = jQuery(".content-section .custom_container").offset().left;
  right_value = right_value + 30;
  jQuery(".content-fullcolumn").css("margin-left", "-" + right_value + "px");
  jQuery(".content-fullcolumn").css("padding-left", right_value + "px");
  var right_values = jQuery(".content-section .custom_container").offset().left;
  right_values = right_values + 45;
  jQuery(".image-col").css("margin-right", "-" + right_values + "px");
  });
  jQuery(window).resize(function() {
        var right_value = jQuery(".content-section .custom_container").offset().left;
        right_value = right_value + 30;
        jQuery(".content-fullcolumn").css("margin-left", "-" + right_value + "px");
        jQuery(".content-fullcolumn").css("padding-left", right_value + "px");
        var right_values = jQuery(".content-section .custom_container").offset().left;
        right_values = right_values + 45;
        jQuery(".image-col").css("margin-right", "-" + right_values + "px");
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
  /* End  */
</script>
<?php get_footer(); ?>