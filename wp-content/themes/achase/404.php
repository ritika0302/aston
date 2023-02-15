<?php
/**
 * The template for displaying the 404 template in the Twenty Twenty theme.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header();
?>
<?php

	$desk_img = get_field("not_found_banner_image_desk","option");
	$mb_img = get_field("not_found_banner_image_mb","option");
?>
<div class="error-banner wow fadeIn" style="background-image: url(<?php echo $desk_img['url'];?>);">

	<div class="mobile-bg-image">
		<img src="<?php echo $mb_img['url'];?>" alt="<?php echo $mb_img['alt'];?>" >
	</div>
	<div class="container">
        <div class="banner-text wow fadeIn">
           <div class="errorbanner-content">
  				<?php echo get_field("not_found_content","option"); ?>
            <a href="<?php echo home_url();?>" class="back-btn">Back to home page</a>           
           </div>
        </div>
 	</div>
</div>
<?php get_footer(); ?>
