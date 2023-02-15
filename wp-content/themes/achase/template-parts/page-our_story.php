<?php // Template Name: Our Story ?>
<?php get_header(); ?>

<div id="content" class="top-spacing">
   <?php echo Fn_cms_inner_banner(get_the_ID());?>
	<div class="viewhistory-section viewhistory-contact wow fadeInUp" data-wow-delay="0.2s">
    <div class="container">
       <div class="headings wow fadeInUp" data-wow-delay="0.2s">
          <?php the_content();?>
       </div>
       <?php  if(get_field("add_history_block",get_the_ID())) { ?>
       <div class="viewhistory-gallery">
          <div class="view-content">
            <?php while(has_sub_field("add_history_block",get_the_ID())) { ?> 
             <div class="views-row">
                <div class="history teaser">
                   <div class="date">
                      <div class="field"><?php echo get_sub_field("his_heading",get_the_ID()); ?></div>
                   </div>
                   <div class="item wow fadeInUp" data-wow-delay="0.2s"> 
                      <div class="fieldname-fieldimage">
                        <?php
                        	$his_img = get_sub_field("his_upload_image",get_the_ID());
                        	if(isset($his_img) && !empty($his_img))
                        	{
                        		echo '<div class="field-item">';
                        			echo '<img src="'.$his_img['url'].'" alt="'.$his_img['alt'].'">';
                        		echo '</div>';
                        	}
                         ?>
                      </div>
                      <div class="inner">
                    		<?php echo get_sub_field("his_content",get_the_ID()); ?>
                      </div>
                   </div>
                </div>
             </div>
             <?php } ?>
          </div>
       </div>
   		<?php } ?>
    </div>
	</div>

</div>
<?php get_footer(); ?>