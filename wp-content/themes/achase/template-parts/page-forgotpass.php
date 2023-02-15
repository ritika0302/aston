<?php // Template Name: Forgot Password ?>
<?php 
   if(is_user_logged_in())
   {
      $myaccount = get_field("global_login_redirect","option");
      wp_redirect($myaccount);die();
   }
?>
<?php get_header(); ?>
<div id="content" class="top-spacing">
   <div class="login-section forgotpassword-section">
      <div class="container">
         <div class="headings">
            <?php the_content(); ?>
         </div>
         <div class="login-col" style="background-image: url(<?php echo get_the_post_thumbnail_url(); ?>);">
            <div class="form-col">
               <?php echo do_shortcode("[forgot_password_form]");?>
            </div>
         </div>
         <div class="bottom-row">
            <div class="register-link">
               NO ACCOUNT YET? REGISTER <a href="<?php echo get_permalink(7);?>">HERE</a>
            </div>
         </div>
      </div>
   </div>

</div>
<?php get_footer(); ?>