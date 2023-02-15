<?php // Template Name: Google Review ?>
<?php get_header(); ?>
<div id="content" class="top-spacing">
   <?php echo Fn_cms_inner_banner(get_the_ID());?>
   <div class="content-headings">
      <div class="container">
         <div class="row">
            <div class="col-md-12">
               <div class="review-btns">
               <?php the_content();?>
               </div>
            </div>
         </div>
         <?php 
          
            function date_compare($a, $b)
            {
                $t1 = strtotime($a['review_date']);
                $t2 = strtotime($b['review_date']);
                return $t1 - $t2;
            }  
         
         global $wpdb;
         $tbl_review = $wpdb->prefix."google_reviews";
         $review_data = $wpdb->get_results("select * from $tbl_review");
         $my_date = array();
         
        //  $array =  (array) $review_data[0]->review_date;
        //  usort($review_data, 'date_compare');
        //  echo "<pre>";print_r($array);exit;
        
         foreach($review_data as $key => $review_data_list){
             $get_date = $review_data_list->review_date;
             $get_date =substr($get_date, 0, strrpos($get_date, ' '));
            //   $my_date[$key]['review_date'] = $get_date;
            //   $my_date[$key]['review_date'] = date('Y-m-d h:i:s',strtotime($get_date));
             
              
              $timestamp = strtotime($get_date);
              $new_date_format = date('Y-m-d H:i:s', $timestamp);
               $my_date[$key]['review_date'] = date('Y-m-d', $get_date); 

            //  $my_date[$key]['review_date'] = strtok($get_date, " ");
             $my_date[$key]['author_name'] = $review_data_list->author_name;
             $my_date[$key]['rating'] = $review_data_list->rating;
             $my_date[$key]['review_text'] = $review_data_list->review_text;
             
         }
  
        // usort($my_date, 'date_compare');
        
        // $ststand = array();
        // foreach($my_date as $geet => $val){
        //     // $dg = arsort($val['review_date']);
        //     $ststand[$geet] = $val;
        //     // arsort();
        // }
        
        
        // usort($my_date, 'date_compare');
        
        //  echo "<pre>";print_r($my_date);exit;
        //  $review_data1 = $wpdb->get_results("SELECT * FROM $tbl_review ORDER BY $my_date");
        
         
         /*
            global $wpdb;
            $tbl_review = $wpdb->prefix."grp_google_review";
            $review_data = $wpdb->get_results("select * from $tbl_review");
            
            if(!empty($review_data))
            {
               echo '<div class="google-review-blocks">';
                  echo '<div class="row">';         
                     foreach ($review_data as $review_key => $_reviews) {
                        echo '<div class="col-sm-4">';
                           echo '<div class="review_details">';
                              echo '<p>'.$_reviews->text.'</p>';   
                              echo '<ul class="list-inline">';
                                 for ($i=0; $i < $_reviews->rating ; $i++) { 
                                    echo '<li><img src="'.get_template_directory_uri().'/assets/images/review_star.svg"></li>';        
                                    }
                              echo '</ul>';
                              echo '<h4>'.$_reviews->author_name.'</h4>';
                           echo '</div>';
                        echo '</div>';
                     }
                  echo '</div>';
               echo '</div>';         
            } */
         ?>
         <?php 
            global $wpdb;
            $tbl_review = $wpdb->prefix."google_reviews";
            $review_data = $wpdb->get_results("select * from $tbl_review");
            
            if(!empty($review_data))
            {
               echo '<div class="google-review-blocks">';
                  echo '<div class="row">';         
                     foreach ($review_data as $review_key => $_reviews) {
                        echo '<div class="col-sm-4">';
                           echo '<div class="review_details">';
                              echo '<p>'.$_reviews->review_text.'</p>';   
                              echo '<ul class="list-inline">';
                                 for ($i=0; $i < $_reviews->rating ; $i++) { 
                                    echo '<li><img src="'.get_template_directory_uri().'/assets/images/review_star.svg"></li>';        
                                    }
                              echo '</ul>';
                              echo '<h4>'.$_reviews->author_name.'</h4>';
                           echo '</div>';
                        echo '</div>';
                     }
                  echo '</div>';
               echo '</div>';         
            }
         ?>
         <div class="row review_view_more">
            <div class="col-md-12">
               <a href="javascript:void(0);" class="review_btn">View more</a>
            </div>
         </div>                     
      </div>
      <div class="trust_pilot_section">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="headings">
                     <h2>Leave us a review</h2>                         
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <a href="<?php echo get_field("footer_google_review_link","option");?>" class="google-btn" target="_blank" >Google Review</a>
                  <a href="<?php echo get_field("footer_trustpilot_link","option");?>" class="google-btn" target="_blank">Trust Pilot Review</a>
               </div>
            </div>
         </div>
      </div>
   </div>

</div>
<?php get_footer(); ?>