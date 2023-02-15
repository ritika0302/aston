<?php // Template Name: Login ?>
<?php 
   if(is_user_logged_in())
   {
      $myaccount = get_field("global_login_redirect","option");
      wp_redirect($myaccount);die();
   }
?>
<?php get_header(); ?>
<div id="content" class="top-spacing">

	<div class="login-section">
            <div class="container">
               <div class="headings">
                 	<?php the_content();?>
               </div>
               <div class="login-col" style="background-image: url(<?php echo get_the_post_thumbnail_url(); ?>);">
                  <div class="form-col">
                     <?php echo do_shortcode("[login_form]");?>
                  </div>
               </div>
               <div class="bottom-row">
                  <?php 
                  	if(get_field("enable_forgot_password_link_on_login_form","option"))
            		{
            			echo '<div class="forget-link">';
            				echo '<a href="'.get_permalink(13786).'">Forgot password</a>';
            			echo '</div>';		
            		}

            		echo '<div class="register-link">';
        				echo 'NO ACCOUNT YET? REGISTER <a href="'.get_permalink(7).'">HERE</a>';
        			echo '</div>';	
                  ?>
               </div>
            </div>
	</div>

</div>
<?php get_footer(); ?>