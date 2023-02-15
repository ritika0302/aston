<?php // Template Name: Terms & Condition ?>
<?php get_header(); ?>
<div id="content" class="top-spacing">
	<?php echo Fn_cms_inner_banner(get_the_ID());?>
	<div class="content-headings wow fadeIn animated" data-wow-delay="0.2s">
        <div class="container">
        	<div class="row">
        		<div class="col-md-5">
	               	<div class="headings">
	                   <?php the_content();?>
	               	</div>
               	</div>
           	</div>
        </div>
	</div>

 	<div class="content_t_c wow fadeIn animated" data-wow-delay="0.2s">
 		<?php 
 		$feat_image = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
 		$alt = get_post_meta ( get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true );
 		if(isset($feat_image))
 		{
 			echo '<img src="'.$feat_image.'" alt="'.$alt.'">';	
 		}
 		?>
 		
 		<div class="container">
     		<div class="row">
     			<div class="col-md-5">
     				<?php 
 					if(get_field("terms_download_files",get_the_ID()))
 					{
 						while (has_sub_field("terms_download_files",get_the_ID())) {
 							
 							echo '<div class="inner_content">';
								echo get_sub_field("terms_block_content",get_the_ID());
							echo '</div>'; 											
 						}	
 					}

     				?>
     			</div>
     		</div>
     	</div>         		
 	</div>

 <div class="property-worthsection">
    <div class="container">
       <div class="property-worthcol">
           <?php echo get_field("appointment_block",get_the_ID()); ?>
       </div>
    </div>
 </div>
 
</div>
<?php get_footer(); ?>