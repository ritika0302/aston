<?php //Template Name: Thank You ?>
<?php get_header(); ?>

<div class="thankyou-banner wow fadeIn" style="background-image: url(<?php echo get_the_post_thumbnail_url(); ?>);">
	<div class="container">
    	<div class="banner-text wow fadeIn">
       		<h1><?php the_title(); ?></h1>
       		<p><?php the_content(); ?></p>
       		<?php if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']!=''){ ?>
       			<a href="<?php echo $_SERVER['HTTP_REFERER'];?>" class="back-btn">Back</a>
       		<?php }else { ?>
       			<a href="<?php echo home_url();?>" class="back-btn">Back</a>
       		<?php } ?>
    	</div>
 	</div>
</div>

<?php get_footer(); ?>
