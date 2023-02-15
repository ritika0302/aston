<?php // Template Name: Change Password ?>
<?php 
   if(!is_user_logged_in())
   {
      wp_redirect(home_url());die();
   }
?>
<?php get_header(); ?>
<?php 
   $user_data = wp_get_current_user();
   $first_name = get_user_meta($user_data->data->ID,"first_name",true);
   
?>
<div id="content" class="top-spacing">
   <div class="savedproperties-section my-profile">
      <div class="container">
         <div class="headings">
            <h2>Welcome back <?php echo ucwords(str_replace("-"," ",$user_data->data->display_name));?>.</h2>
         </div>
         <div class="linklist-row">
            <?php ?>
            <div class="dropdown-btn">Favourite PROPERTIES</div>
            <ul class="dropdown-list">
               <li><a href="<?php echo get_permalink(13792);?>">Favourite PROPERTIES</a></li>
               <li><a href="<?php echo get_permalink(13797);?>">Saved Searches</a></li>
               <li><a href="<?php echo get_field("global_login_redirect","option");?>">My profile</a></li>
               <li class="active"><a href="<?php echo get_permalink(31116);?>">Change Password</a></li>
               <li><a href="<?php echo wp_logout_url(get_field("global_logout_redirect","option"));?>">LOGOUT</a></li>
            </ul>
         </div>
         <div class="reset_module">
            <div class="headings text-center">
               <h3>Change Password</h3>
            </div>
            <div id="reset_pwd_frm_alert" class="alert"></div>
            <form name="resetpassform" id="reset_pwd_frm" class="reset_pwd_frm" method="post">
                <div class="myprofile-form">
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label>New Password</label>
                           <input type="password" class="form-control" id="password" name="password" >
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label>Confirm New Password</label>
                           <input type="password" class="form-control" id="cpassword" name="cpassword" value="" >
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-12">
                     <div class="form-group text-center">
                        <input type="hidden" name="user_id" value="<?php echo $user_data->data->ID; ?>" />
                        <input type="hidden" name="login_redirect" value="<?php echo get_permalink(5);?>" id="login_redirect">
                         <input type="hidden" name="reset-nonce" id="reset-nonce" value="<?php echo wp_create_nonce('reset-nonce');?>" />
                        <button type="submit" class="submit-btn">Update</button>
                     </div>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>

</div>
<?php get_footer(); ?>