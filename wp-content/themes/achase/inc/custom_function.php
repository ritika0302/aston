<?php 
// Adding Theme  Options to Custom Fields Options
function aston_acf_options_page_settings($settings) {
    $settings['title'] = __('Aston Option','acf');
    $settings['menu'] = __('Aston Option','acf');
    $settings['pages'] = array('General Setting','WP Register Login Settings','Properties Settings');

    return $settings;
}
add_filter('acf/options_page/settings', 'aston_acf_options_page_settings');

function generateRandomString($length = 20) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
class Sublevel_Walker extends Walker_Nav_Menu
{
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class='dropdownMenu'><ul>\n";
    }
    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul></div>\n";
    }
}

function revcon_change_post_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Journal';
    $submenu['edit.php'][5][0] = 'Journal';
    $submenu['edit.php'][10][0] = 'Add Journal';
    $submenu['edit.php'][16][0] = 'Journal Tags';
}
function revcon_change_post_object() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'Journal';
    $labels->singular_name = 'Journal';
    $labels->add_new = 'Add Journal';
    $labels->add_new_item = 'Add Journal';
    $labels->edit_item = 'Edit Journal';
    $labels->new_item = 'Journal';
    $labels->view_item = 'View Journal';
    $labels->search_items = 'Search Journal';
    $labels->not_found = 'No Journal found';
    $labels->not_found_in_trash = 'No Journal found in Trash';
    $labels->all_items = 'All Journal';
    $labels->menu_name = 'Journal';
    $labels->name_admin_bar = 'Journal';
}
 
add_action( 'admin_menu', 'revcon_change_post_label' );
add_action( 'init', 'revcon_change_post_object' );
/**
 * Front-end Login and Registration Function.
 */
require get_template_directory() . '/inc/front_login_registration/registerform.php';
/**
 * Properties Functions.
 */
require get_template_directory() . '/inc/properties/properties_feed.php';
require get_template_directory() . '/inc/properties/properties_filter.php';
require get_template_directory() . '/inc/properties/notification_cron.php';
add_filter( 'auto_update_plugin', '__return_false' );
add_filter( 'auto_update_theme', '__return_false' );
/*
* Custom ACF Group Data Get Function 
*/
function the_acf_group_fields( $parent_field_name , $fields_name ){
   $data = '';
   if( have_rows($parent_field_name) ):
      while ( have_rows($parent_field_name) ) : the_row();
         $data = get_sub_field($fields_name);
      endwhile;
   else :
      // no rows found
   endif;
   return $data;
}


add_filter( 'body_class', 'custom_class' );
function custom_class( $classes ) {
    if ( is_404()) {
        $classes[] = 'page404';
    }
    return $classes;
}
 function GetYouTubeId($url)
 {
    
    $youtube_id = '';   
    if (strpos($url, 'youtu.be') !== false) {
        $video_arr = explode("/",$url);
        $youtube_id = $video_arr[3];
    }elseif (strpos($url, 'www.youtube.com') !== false)
    {
        parse_str( parse_url( $url, PHP_URL_QUERY ), $video_arr );
        $youtube_id = $video_arr['v'];           
    }
 
    return $youtube_id;
 }
/* Inner Banner*/
function Fn_service_inner_banner($postid)
{
    if(get_field("inn_banner_img",$postid))
    {
    echo '<section class="our_services_banner cmn_bg_img" style="background-image: url('.get_field("inn_banner_img",$postid).');">';
        echo '<div class="custom_container medium_custom_container">';
            echo '<div class="services_banner_content">';
                echo get_field("inn_banner_content",$postid);
                echo '<div class="skip-banner"><i class="fa fa-angle-down" aria-hidden="true"></i></div>';
            echo '</div>';
        echo '</div>';
    echo '</section>';
    }
}

/* CMS Inner Banner*/
function Fn_cms_inner_banner($postid)
{
    if(get_field("inn_banner_img",$postid))
    {
    echo '<section class="news_contect_banner" style="background-image: url('.get_field("inn_banner_img",$postid).');">';
        echo '<div class="custom_container">';
            echo '<div class="services_banner_content">';
                echo '<h1>'.get_the_title().'</h1>';
                echo get_field("inn_banner_content",$postid);
                echo '<div class="skip-banner"><i class="fa fa-angle-down" aria-hidden="true"></i></div>';
            echo '</div>';
        echo '</div>';
    echo '</section>';
    }
}

/* Google Review Shortcode */
add_shortcode( 'google_review_slider', 'Fn_google_review' );
function Fn_google_review()
{
    global $wpdb;
    $tbl_review = $wpdb->prefix."google_reviews";
    $review_data = $wpdb->get_results("select * from $tbl_review limit 5");
    $slider_html = '';
    if(!empty($review_data))
    {
   
       foreach ($review_data as $review_key => $_reviews) {
            $slider_html .= '<div class="">';
                $slider_html .= '<div class="review-slide">';
                    $slider_html .= '<p>'.$_reviews->review_text.'</p>';
                                  
                    $slider_html .= '<ul class="list-inline">';
                        for ($i=0; $i < $_reviews->rating ; $i++) { 
                            $slider_html .= '<li><img src="'.get_template_directory_uri().'/assets/images/review_star.svg"></li>';        
                        }
                    $slider_html .= '</ul>'; 
                    $slider_html .= '<p class="review-auther-data">'.$_reviews->author_name.'<span>'.$_reviews->review_date_ago.'</span></p>'; 
                                   
                $slider_html .= '</div>';
            $slider_html .= '</div>';
        } 
 
    }
    return $slider_html;
}

function get_time_ago( $time )
{
    $time_difference = time() - $time;

    if( $time_difference < 1 ) { return 'less than 1 second ago'; }
    $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $time_difference / $secs;

        if( $d >= 1 )
        {
            $t = round( $d );
            return $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
        }
    }
}


function get_site_secret_key_from_cf7(){
    $keys = [];
    $sitekey = $secret = '';

    $arr_keys = WPCF7::get_option( 'recaptcha' );

    if( !empty( $arr_keys ) ){
        $sitekeys = array_keys( $arr_keys );
        $sitekey = $sitekeys[0];

        $sitekeys_arr = (array) $arr_keys;

        if ( isset( $sitekeys_arr[$sitekey] ) ) {
            $secret = $sitekeys_arr[$sitekey];
        }
    }

    $keys['sitekey'] = $sitekey;
    $keys['secret'] = $secret;

    return $keys;
}
$recaptcha = get_site_secret_key_from_cf7();
define( 'RECAPTCHA_SITEKEY', $recaptcha['sitekey'] );
define( 'RECAPTCHA_SECRETKEY', $recaptcha['secret'] );

add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {
      show_admin_bar(false);
    }
}
add_filter( 'auto_update_plugin', '__return_false' );
add_filter( 'auto_update_theme', '__return_false' );

add_action( 'wpcf7_before_send_mail', 'wpcf7_change_email_id' );
function wpcf7_change_email_id($contact_form)
{
   if($contact_form->id() == 355)
   {

        $mail = $contact_form->prop( 'mail' ); // returns array    
        if($_POST['categories'] == "Marketing - services or collaborations")
        {
            $mail['recipient'] = get_field("marketing_email","option");
            $contact_form->set_properties( array( 'mail' => $mail ) );
        }else if ($_POST['categories'] == "Property search help (SALES)"){
            $mail['recipient'] = get_field("property_search_help_sales_email","option");
            $contact_form->set_properties( array( 'mail' => $mail ) );
        }else if ($_POST['categories'] == "Property search help (LETTINGS)"){
            $mail['recipient'] = get_field("property_search_help_lettings_email","option");
            $contact_form->set_properties( array( 'mail' => $mail ) );
        }else if ($_POST['categories'] == "I want to sell or rent my property"){
            $mail['recipient'] = get_field("i_want_to_sell_or_rent_my_property_email","option");
            $contact_form->set_properties( array( 'mail' => $mail ) );
        }else if ($_POST['categories'] == "Service provider"){
            $mail['recipient'] = get_field("service_provider_email","option");
            $contact_form->set_properties( array( 'mail' => $mail ) );
        }else if ($_POST['categories'] == "Career enquiry"){
            $mail['recipient'] = get_field("career_enquiry_email","option");
            $contact_form->set_properties( array( 'mail' => $mail ) );
        }else if ($_POST['categories'] == "Customer relations/complaints"){
            $mail['recipient'] = get_field("customer_relationscomplaints_email","option");
            $contact_form->set_properties( array( 'mail' => $mail ) );
        }else if($_POST['categories'] == "Other/general enquiry")
        {
            $mail['recipient'] = get_field("othergeneral_enquiry_email","option");
            $contact_form->set_properties( array( 'mail' => $mail ) );
        }
  }
  if($contact_form->id() == 354){
    $mail = $contact_form->prop( 'mail' );
    if($_POST['property_style'] == "SELL"){
        $mail['recipient'] = get_field("sell_email_id","option");
        $contact_form->set_properties( array( 'mail' => $mail ) );
    }
    if($_POST['property_style'] == "LET"){
        $mail['recipient'] = get_field("let_email_id","option");
        $contact_form->set_properties( array( 'mail' => $mail ) );
    }
    if($_POST['property_style'] == "BOTH"){
        $mail['recipient'] = get_field("both_email_id","option");
        $contact_form->set_properties( array( 'mail' => $mail ) );
    }
  }
}

function ac_add_slug_body_class( $classes ) {
    global $post;
    if ( isset( $post ) ) {
    $classes[] = $post->post_type . '-' . $post->post_name;
    }
    return $classes;
    }
add_filter( 'body_class', 'ac_add_slug_body_class' );

?>