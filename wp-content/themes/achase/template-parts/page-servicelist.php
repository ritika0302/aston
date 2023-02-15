<?php // Template Name: Service List ?>
<?php get_header(); ?>
<div id="content" class="push top-spacing">
	<?php 
    /* Inner Banner */
	echo Fn_service_inner_banner(get_the_ID());

	/* Content Block*/
	echo '<section>';
		echo '<div class="custom_container">';
			echo '<div class="our_services_text">';
				if(get_field("scrolling_title",get_the_ID()))
				{
					echo '<div class="vertical-title wow fadeInDown">';
						echo '<div class="sideline"></div>';
						echo '<span>'.get_field("scrolling_title",get_the_ID()).'</span>';
					echo '</div>';
				}					
				echo '<div class="inner_text">';
					echo '<h2 class="default_title">'.get_field("ser_sub_heading",get_the_ID()).'</h2>';
					echo '<div class="small_content">'.get_field("ser_description",get_the_ID()).'</div>';
				echo '</div>';
				
			echo '</div>';
		echo '</div>';
	echo '</section>';

	if(get_field("award_winning_content",get_the_ID()))
	{
		echo '<section class="grey_box">';
			echo '<div class="custom_container">';
				echo '<div class="row">';
					echo '<div class="col-md-10 col-md-offset-2">';
						echo '<div class="inner_text">';
							echo get_field("award_winning_content",get_the_ID());
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';	
		echo '</section>';
	}

	/* Service List */
	if(get_field("select_service_pages",get_the_ID()))
	{
		echo '<section class="service_items">';
			while (has_sub_field("select_service_pages",get_the_ID())) {
				$ser_img = get_sub_field("ser_img",get_the_ID());
				echo '<div class="service_item">';
					echo '<a href="'.get_sub_field("ser_link",get_the_ID()).'" class="link_overlay"></a>';
					if (!empty($ser_img)) 
					{
						echo '<div class="overlay"><img src="'.$ser_img['url'].'" alt="'.$ser_img['alt'].'"></div>';		
					}
					echo '<div class="custom_container">';
						echo '<div class="service_item_text">';
							echo get_sub_field("ser_content",get_the_ID());
						echo '</div>';
					echo '</div>';			
				echo '</div>';

			}
		echo '</section>';	
	}
	?>
</div>
<?php get_footer(); ?>