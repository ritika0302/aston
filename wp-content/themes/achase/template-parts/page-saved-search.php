<?php // Template Name: Saved Search ?>
<?php 
   if(!is_user_logged_in())
   {
      wp_redirect(home_url());die();
   }
?>
<?php get_header(); ?>
<?php
$user_data = wp_get_current_user();

?>
<div id="content" class="top-spacing">
   <div class="savedproperties-section property-alerts">
      <div class="container">
         <div class="headings">
             <h2>Welcome back <?php echo ucwords(str_replace("-"," ",$user_data->data->display_name));?>.</h2>
         </div>
         <div class="linklist-row">
            <div class="dropdown-btn">Favourite PROPERTIES</div>
           <ul class="dropdown-list">
               <li><a href="<?php echo get_permalink(13792);?>">Favourite PROPERTIES</a></li>
               <li  class="active"><a href="<?php echo get_permalink();?>">Saved Searches</a></li>
               <li><a href="<?php echo get_field("global_login_redirect","option");?>">My profile</a></li>
			   <li><a href="<?php echo get_permalink(27328);?>">Change Password</a></li>
               <li><a href="<?php echo wp_logout_url(get_field("global_logout_redirect","option"));?>">LOGOUT</a></li>
            </ul>
         </div>
         <?php 

         global $wpdb;
         $tbl_search = $wpdb->prefix."saved_properties";  
         $search_res = $wpdb->get_results("select * from $tbl_search where user_id=".$user_data->data->ID);
         echo '<div class="search-creatia-block">';  
            echo '<div class="headings text-center">';
               echo '<h3>'.count($search_res).' Saved Searches</h3>';
            echo '</div>';          
            echo '<input type="hidden" value="'.$user_data->data->ID.'" id="user_id">'; 
            echo '<div class="submit-loder"><img src="'.get_template_directory_uri().'/assets/images/ajax-loader.gif"></div>'; 
            echo '<div class="saved-alert"></div>';
            $i=1;
            $search_title = '';
            foreach ($search_res as $_res) {

               if (strpos($_res->save_search_url, 'dpt=sale') !== false || strpos($_res->save_search_url, 'dpt=new_home') !== false) { 
                   $search_title = $i.') Residential Properties to Buy';
               }else if (strpos($_res->save_search_url, 'dpt=letting') !== false) {
                   $search_title = $i.') Residential Properties to Rent';
               }
              
               echo '<div class="savelist-col">';
                  echo '<div class="savelist-row">';
                     echo '<h4>'.$search_title.'</h4>';   
                     echo '<ul class="savelist-links">';                        
                        echo '<li><a href="'.$_res->save_search_url.'" target="_blank" ><em class="fa fa-street-view"></em>View Results</a></li>';
                        if($_res->email_alert == 1)
                        {
                            echo '<li><a href="javascript:void(0);" class="alert_status" id="'.$_res->id.'" data-id="1" ><em class="fa fa-envelope-o"></em><span>Stop Email Alerts</span></a></li>';    
                        }else
                        {
                            echo '<li><a href="javascript:void(0);" class="alert_status" id="'.$_res->id.'" data-id="0"><em class="fa fa-envelope-o"></em><span>Start Email Alerts</span></a></li>';
                        }
                       
                        echo '<li><a href="javascript:void(0);" class="delete_alert" id="'.$_res->id.'" ><em class="fa fa-trash-o"></em>Delete Search</a></li>';   
                     echo '</ul>';   
                  echo '</div>';   
               echo '</div>';
               $i++;
            }
         echo '</div>';   
         ?>
      </div>
   </div>
</div>
<?php get_footer(); ?>