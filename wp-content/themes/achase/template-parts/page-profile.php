<?php // Template Name: Profile ?>
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
   if(get_user_meta($user_data->data->ID,"user_telphone",true) != '')
   {
      $user_telphone = get_user_meta($user_data->data->ID,"user_telphone",true);   
   }else
   {
      $user_telphone = '';
   }

   
  
   if(get_user_meta($user_data->data->ID,"user_country",true) != '')
   {
      $user_country = get_user_meta($user_data->data->ID,"user_country",true);   
   }else
   {
      $user_country = '';
   }

   if(get_user_meta($user_data->data->ID,"user_postcode",true) != '')
   {
      $user_postcode = get_user_meta($user_data->data->ID,"user_postcode",true);   
   }else
   {
      $user_postcode = '';
   }
   if(get_user_meta($user_data->data->ID,"user_newsletter",true) != '')
   {
      $newsletter = get_user_meta($user_data->data->ID,"user_newsletter",true);   
   }else
   {
      $newsletter = '';
   }
   
 

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
               <li class="active"><a href="<?php echo get_field("global_login_redirect","option");?>">My profile</a></li>
               <li><a href="<?php echo get_permalink(27328);?>">Change Password</a></li>
               <li><a href="<?php echo wp_logout_url(get_field("global_logout_redirect","option"));?>">LOGOUT</a></li>
            </ul>
         </div>
         <div class="profile_module">
            <div class="headings text-center">
               <h3>Account Details</h3>
            </div>
            <div id="profile_alert" class="alert"></div>
            <form name="myprofile" id="myprofile" class="myprofile" method="post">
               <div class="myprofile-form">
                  <div class="row">
                     <div class="col-sm-4">
                        <div class="form-group">
                           <label>Your Name</label>
                           <input type="text" class="form-control" id="uname" name="uname" value="<?php echo $first_name; ?>" >
                        </div>
                     </div>
                     <div class="col-sm-4">
                        <div class="form-group">
                           <label>Email</label>
                           <input type="email" class="form-control" id="emailid" name="emailid" value="<?php echo $user_data->data->user_email; ?>" >
                        </div>
                     </div>
                     <div class="col-sm-4">
                        <div class="form-group">
                           <label>Telephone</label>
                           <input type="tel"  minlength="10" maxlength="15" class="form-control" id="telphone" name="telphone" value="<?php echo $user_telphone; ?>" >
                        </div>
                     </div>
                     <div class="col-sm-8">
                        <div class="form-group">
                           <div class="checkbox-col">
                              <input type="checkbox" name="newsletter" id="newsletter" value="<?php echo $newsletter; ?>" checked>
                              <label class="label" for="newsletter"><?php echo get_field( 'lbl_newsletter_checkbox','option' );?>
                              </label>
                           </div>
                        </div>
                     </div>

                  </div>
                  
               </div>
               <div class="headings text-center address-title">
                  <h3>Your Address</h3>
               </div>
               <div class="myprofile-form">
                     <div class="row">
                        <div class="col-sm-6">
                           <div class="form-group">
                              <label>Country</label>
                              <input type="text" class="form-control" id="country" name="country" value="<?php echo $user_country; ?>" >
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group">
                              <label>Postcode</label>
                              <input type="text" maxlength="8" class="form-control" id="postcode" name="postcode" value="<?php echo $user_postcode; ?>" >
                           </div>
                        </div>
                        <div class="col-sm-12">
                           <div class="form-group text-center">
                              <input type="hidden" name="user_id" value="<?php echo $user_data->data->ID; ?>" />
                               <input type="hidden" name="profile-nonce" id="profile-nonce" value="<?php echo wp_create_nonce('profile-nonce');?>" />
                              <button type="submit" class="submit-btn">Update</button>
                           </div>
                        </div>
                     </div>
               </div>
            </form>
         </div>
      </div>
   </div>

</div>
<?php get_footer(); ?>