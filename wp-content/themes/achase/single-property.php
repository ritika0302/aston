<?php
/**
 * The Template for displaying a single property.
 *
 * Override this template by copying it to yourtheme/propertyhive/single-property.php
 *
 * @author      PropertyHive
 * @package     PropertyHive/Templates
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'propertyhive' ); ?>
<?php 
$property              = new PH_Property( get_the_ID());
$bannerSlides          = $property->get_gallery_attachment_ids();

$_department           = get_post_meta(get_the_ID(),'_department',true); 
$_currency             = get_post_meta(get_the_ID(),'_currency',true);
$_price_qualifier      = get_post_meta(get_the_ID(),'_price_qualifier',true);
$floorplan             = get_post_meta(get_the_ID(),"_floorplans",true);
$_brochures            = get_post_meta(get_the_ID(),"_brochures",true);
$_room_description     = get_post_meta(get_the_ID(),"_room_description",true);


if(get_current_user_id() != '')
{
    $logged_user_id = get_current_user_id();
}else
{
    $logged_user_id = '';
}
$_saved_prperty = get_post_meta(get_the_ID(),'saved_prperty',true);

$_areas_res = '';

if(get_post_meta(get_the_ID(),"_address_two",true) != '')
{
   $_address_two = str_replace("&#039;","'",get_post_meta(get_the_ID(),"_address_two",true));
   $_areas_res            = get_page_by_title($_address_two, OBJECT,"areas"); 
   
   if(get_post_meta(get_the_ID(),"_address_three",true) != '' && $_areas_res == '' )
    {

    if(get_post_meta(get_the_ID(),"_address_three",true) == "Palgrave Gardens")
    {
        $_address_three        = "Regents Park";
    }else if(get_post_meta(get_the_ID(),"_address_three",true) == "Swiss Cottage, London" || get_post_meta(get_the_ID(),"_address_three",true) == "London")
    {
        $_address_three        = "North West & Central London";
    }else if(get_post_meta(get_the_ID(),"_address_three",true) == "West Hampstead")
    {
        $_address_three        = "Hampstead";
    }else if(get_post_meta(get_the_ID(),"_address_three",true) == "St Johns Wood")
    {
        $_address_three        = "St John&#039;s Wood";
    }else
    {
        $_address_three        = get_post_meta(get_the_ID(),"_address_three",true);
    }

    $_address_three = str_replace("&#039;","'",$_address_three);
    //$_address_three            = htmlentities($_address_three, ENT_QUOTES);
    $_areas_res                = get_page_by_title($_address_three, OBJECT,"areas"); 
    //print_r($_areas_res);
    }
}else if (get_post_meta(get_the_ID(),"_address_three",true) != '')
{
    
    if(get_post_meta(get_the_ID(),"_address_three",true) == "Palgrave Gardens")
    {
        $_address_three        = "Regents Park";
    }else if(get_post_meta(get_the_ID(),"_address_three",true) == "Swiss Cottage, London" || get_post_meta(get_the_ID(),"_address_three",true) == "London" || get_post_meta(get_the_ID(),"_address_three",true) == "Brondesbury Park, London")
    {
        $_address_three        = "North West & Central London";
    }else if(get_post_meta(get_the_ID(),"_address_three",true) == "West Hampstead")
    {
        $_address_three        = "Hampstead";
    }else if(get_post_meta(get_the_ID(),"_address_three",true) == "St Johns Wood")
    {
        $_address_three        = "St John&#039;s Wood";
    }else
    {
        $_address_three        = get_post_meta(get_the_ID(),"_address_three",true);
    }

    $_address_three = str_replace("&#039;","'",$_address_three);
    $_areas_res                = get_page_by_title($_address_three, OBJECT,"areas"); 
}

$_property_EPC         = get_post_meta(get_the_ID(),"_property_EPC",true);



$_team_res            = get_page_by_title(trim(get_post_meta(get_the_ID(),"_negotiator_name",true)), OBJECT,"team");
if(!empty($_team_res))
{
$_team_profile        = get_the_post_thumbnail_url($_team_res->ID,'full'); 
$_team_profile_id     = get_post_thumbnail_id($_team_res->ID);
$_team_profile_alt    = get_post_meta($_team_profile_id , '_wp_attachment_image_alt', true);
}else
{
    $_team_profile        = get_template_directory_uri()."/assets/images/user-img.jpg";
    $_team_profile_alt    = "user-img.jpg";
}
if(get_post_meta(get_the_ID(),"_negotiator_telephone",true) != '')
{
    $team_phone = get_post_meta(get_the_ID(),"_negotiator_telephone",true);
}else
{
    $team_phone = get_post_meta(get_the_ID(),"_negotiator_mobile",true);
}


$_property_video = '';
$_property_video_img = '';
$_property_video_url = '';
$_property_videos_img = '';
$_property_videos_url = '';
$video_flag = false;
if(get_post_meta(get_the_ID(),"_property_video",true) != '' && get_post_meta(get_the_ID(),"_property_video",true) != 'PROPERTY VIDEO')
{
    
   $_property_video_id = GetYouTubeId(get_post_meta(get_the_ID(),"_property_video",true));
   if($_property_video_id != '')
   {
        $_property_video_img   = "https://img.youtube.com/vi/".$_property_video_id."/hqdefault.jpg";
        $_property_video_url = "https://www.youtube.com/embed/".$_property_video_id;
        $video_flag = true;
    }
}

function videoType() {
    $url = get_post_meta(get_the_ID(),"_property_video",true);
    $flag = 0;
    if (strpos($url, 'youtube') > 0) {
        $flag = 1;
    } 

    if (strpos($url, 'vimeo') > 0) {
        $flag = 2;
    } 
    return $flag;
}

if (videoType() == 2) {
     $vimeo_url = get_post_meta(get_the_ID(),"_property_video",true);
     $_property_video_id = (int) substr(parse_url($vimeo_url, PHP_URL_PATH), 1);
     $vim_thumb = unserialize(file_get_contents("http://vimeo.com/api/v2/video/".$_property_video_id.".php"));
     $_property_video_img = $vim_thumb[0]['thumbnail_large'];
     
     $video_flag = true;
}

if(get_post_meta(get_the_ID(),"_property_videos",true) != '')
{
    
   $_property_videos_id = GetYouTubeId(get_post_meta(get_the_ID(),"_property_videos",true));
   if($_property_videos_id != '')
   {
        $_property_videos_img   = "https://img.youtube.com/vi/".$_property_videos_id."/hqdefault.jpg";
        $_property_videos_url = "https://www.youtube.com/embed/".$_property_videos_id;
        
    }
    else
    {
        $_property_videos_url = get_post_meta(get_the_ID(),"_property_videos",true);
    }
}


$price_qulifer = '';
if($_price_qualifier == "AP")
{
    $price_qulifer = "ASKING PRICE";
}else if($_price_qualifier == "GP")
{
    $price_qulifer = "Guide price";
}else if($_price_qualifier == "PA")
{
    $price_qulifer = "PRICE ON APPLICATION";
}else if($_price_qualifier == "OR")
{
    $price_qulifer = "PRICE FROM";
}else if($_price_qualifier == '')
{
    $price_qulifer = "PRICE PER WEEK";
}

if($_currency == "GBP")
{
    $currency = '£';
}
if($_department == "residential-sales")
{
    $property_price = $property->get_formatted_price();
}else if($_department == "residential-lettings")
{
    $_rent_frequency    = get_post_meta(get_the_ID(),'_rent_frequency',true);
    $_rent_price        = str_replace("&#163;","",get_post_meta(get_the_ID(), '_rent',true));
    $_rent_frequency    = get_post_meta(get_the_ID(),'_rent_frequency',true);
    $_rent_price        = str_replace("&#163;","",get_post_meta(get_the_ID(), '_rent',true));
    
    $property_price     = $currency.number_format($_rent_price);
}
?>
<?php while ( have_posts() ) : the_post(); ?>
<div id="content" class="top-spacing">
    <section class="propertie-banner">
        <div class="banner_img" style="background-image: url(<?php echo wp_get_attachment_url($bannerSlides[0]);?>);">
            <div class="skip-banner"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
        </div>
        <ul class="banner_list list-inline">
            <?php if($video_flag){ ?>
                <li class="videoBtn"><a href="javascript:void(0);" class="sliderBtn"><img src="<?php echo get_template_directory_uri();?>/assets/images/play_icon.svg">Video</a></li>
            <?php } ?>
           <?php if($_property_videos_url != ''){ ?>
                <li class="vturBtn"><a href="<?php echo $_property_videos_url;?>" class="vtur_sliderBtn" target="_blank" ><img src="<?php echo get_template_directory_uri();?>/assets/images/vtour.svg">virtual tour</a></li>
            <?php } ?>
            <li class="imgBtn"><a href="javascript:void(0);" class="sliderBtn"><img src="<?php echo get_template_directory_uri();?>/assets/images/gallary_icon.svg"><?php echo count($bannerSlides);?> photos</a></li>
        </ul>
    </section>

<section class="address_details wow fadeIn animated" data-wow-delay="0.2s">
    <div class="container">                 
        <div class="row">
            <div class="col-md-12">                     
                <h1 class="section_title"><?php the_title();?></h1>
            </div>                      
            <div class="col-lg-7 col-md-7">                     
                <div class="row">
                    <div class="col-md-12">                     
                        <ul class="bedroom_details list-inline">
                            <li class="price"><?php echo $price_qulifer;?><span><?php echo $property_price;?> </span></li>
                            <?php if(get_post_meta(get_the_ID(),'_bedrooms',true) != ''){ ?>
                                <li>BEDROOMS<span><?php echo get_post_meta(get_the_ID(),'_bedrooms',true);?> </span></li>
                            <?php } ?>
                            <?php if(get_post_meta(get_the_ID(),'_bathrooms',true) != ''){ ?>
                                <li>BATHROOMS<span><?php echo get_post_meta(get_the_ID(),'_bathrooms',true);?> </span></li>
                            <?php } ?>
                            <?php if(get_post_meta(get_the_ID(),'_reception_rooms',true) != ''){ ?>
                                <li>Receptions<span><?php echo get_post_meta(get_the_ID(),'_reception_rooms',true);?> </span></li>
                            <?php } ?>
                            <?php if(get_post_meta(get_the_ID(),'_size',true) != ''){ ?>
                                <li>INTERIOR<span><?php echo  number_format(get_post_meta(get_the_ID(),"_size",true)).' sq ft';?> </span></li>
                            <?php } ?>
                        </ul>
                        <ul class="share_list list-inline">
                            <?php  if(!isset($_saved_prperty) || $_saved_prperty == 0) { ?>
                                <li><a href="javascript:void(0);" date-attr="<?php echo $pid;?>" data-id="<?php echo $logged_user_id;?>" class="heart" >
                                <img src="<?php echo get_template_directory_uri();?>/assets/images/save-grey.svg" class="default_img" >
                                <img src="<?php echo get_template_directory_uri();?>/assets/images/unsave-orange.svg" class="hover_img">
                                <img src="<?php echo get_template_directory_uri();?>/assets/images/save-orange.svg" class="saved_img" > 
                                
                                save</a></li>
                            <?php } else { ?>
                                <li><a href="javascript:void(0);" date-attr="<?php echo $pid;?>" data-id="<?php echo $logged_user_id;?>" class="heart active" >

                                <img src="<?php echo get_template_directory_uri();?>/assets/images/save-grey.svg" class="default_img" >
                                <img src="<?php echo get_template_directory_uri();?>/assets/images/unsave-orange.svg" class="hover_img" >
                                <img src="<?php echo get_template_directory_uri();?>/assets/images/save-orange.svg" class="saved_img" >     
                                 save</a></li>
                            <?php } ?>
                                <li>
                                <a class="share-icon" href="javascript:void(0)">
                                <img src="<?php echo get_template_directory_uri();?>/assets/images/share-grey.svg" class="default_img">
                                <img src="<?php echo get_template_directory_uri();?>/assets/images/share-orange.svg" class="hover_img"> 

                                Share</a>
                                <div class="share-toggle">
                                     <ul>
                                        <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink(get_the_ID())); ?>&quote=<?php echo get_the_title();?>" target="_blank" >Facebook</a></li>
                                        <li><a href="https://twitter.com/intent/tweet?text=<?php echo get_the_title();?>&amp;url=<?php echo urlencode(get_permalink(get_the_ID())); ?>" target="_blank" >Twitter</a></li>
                                        
                                        <li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode(get_permalink(get_the_ID())); ?>&amp;title=<?php echo get_the_title();?>&amp;summary=&amp;source=<?php bloginfo('name'); ?>" target="_blank" >LinkedIn</a></li>
                                     </ul>
                                      <div class="copy_url">
                                          <input type="button" value="Copy Url" onclick="Copy();" />
                                          <input type="text" name="url" id="url">
                                         
                                     </div>
                                     <a class="share-close" href="javascript:void(0)">
                                        <img src="<?php echo get_template_directory_uri();?>/assets/images/close-icon2.svg" alt="">
                                     </a>
                                </div>
                            </li>
                            <?php if(!empty($_brochures)){ ?>
                                <li><a href="<?php echo  wp_get_attachment_url($_brochures[0]);?>"  target="_blank" >
                                    <img src="<?php echo get_template_directory_uri();?>/assets/images/brochur-grey.svg" class="default_img">
                                    <img src="<?php echo get_template_directory_uri();?>/assets/images/brochur-orange.svg" class="hover_img">
                                brochure</a></li>
                            <?php } ?>
                               <?php if(!empty($floorplan)){ ?>
                                <li>
                                    <a href="javascript:void(0);" class="floor-btn">
                                        <img src="<?php echo get_template_directory_uri();?>/assets/images/floorplan_icon.svg" class="default_img">
                                        <img src="<?php echo get_template_directory_uri();?>/assets/images/floorplan_icon_orange.svg" class="hover_img">FLOORPLAN
                                    </a>
                                    <div class="floorplan-view">
                                        <div class="view-slide"><a  href="<?php echo  wp_get_attachment_url($floorplan[0]);?>" data-fancybox="imgfloorplan">view</a></div>
                                        <div class="view-slide"><a href="<?php echo  wp_get_attachment_url($floorplan[0]);?>" download >Download</a></div>
                                    </div>
                                </li>
                            <?php } ?>
                            <?php if(!empty($_property_EPC))  {?>
                                <li><a href="<?php echo $_property_EPC[0]->Filepath;?>" data-lightbox="imgepc">
                                    <img src="<?php echo get_template_directory_uri();?>/assets/images/epc_icon.svg" class="default_img">
                                    <img src="<?php echo get_template_directory_uri();?>/assets/images/epc_icon_orange.svg" class="hover_img">
                                EPC</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-5 col-md-5">
                <div class="arrange_contact">
                    <div class="img_content">
                        <div class="wrap">
                            <img src="<?php echo $_team_profile;?>" alt="<?php echo $_team_profile_alt;?>" title="<?php echo $_team_res->post_title;?>">
                            <div class="right">
                                <?php  if(get_post_meta(get_the_ID(),"_negotiator_name",true)){ ?>
                                    <?php if(isset($_team_res->ID) && $_team_res->ID != '') { ?>
                                    <p>Hi, I’m <a href="<?php echo get_permalink(264);?>?mid=<?php echo $_team_res->ID;?>"><?php echo trim(get_post_meta(get_the_ID(),"_negotiator_name",true));?></a>. <br>
                                Call me on <a href="tel:<?php echo $team_phone;?>"><?php echo $team_phone;?></a> or <a href="mailto:<?php echo get_post_meta(get_the_ID(),"_negotiator_email_id",true);?>">email</a><br>
                                me to view this property.</p>
                                <?php } else { ?>
                                    <p>Hi, I’m <a href="javascript:void(0);"><?php echo trim(get_post_meta(get_the_ID(),"_negotiator_name",true));?></a>. <br>
                                Call me on <a href="tel:<?php echo $team_phone;?>"><?php echo $team_phone;?></a> or <a href="mailto:<?php echo get_post_meta(get_the_ID(),"_negotiator_email_id",true);?>">email</a><br>
                                me to view this property.</p>
                                <?php } ?>
                                <?php } ?>
                            
                            </div>
                        </div>
                        <a href="#form-show" class="a_btn">Arrange a Viewing</a>
                        <?php if($_department == "residential-sales"){ 
                            //  echo '<a href="javascript.void(0);" data-toggle="modal" data-target="#makeoffer" class="a_btn">Make an Offer</a>';   
                        } else if($_department == "residential-lettings") {
                            // echo '<a href="'.get_permalink(81).'#ct-frm" class="a_btn">Contact Us</a>';
                        } ?>
                    </div>
                </div>      
            </div>
        </div>
    </div>
</section>
<section class="video_gallary wow fadeIn animated" data-wow-delay="0.2s">
    <div class="container">                 
        <div class="row">                                           
            <div class="col-lg-7 col-md-7">                     
                <div class="row">                               
                    <div class="col-md-12">                     
                        <div class="video">
                           <?php if($video_flag){ ?>
                                <img src="<?php echo $_property_video_img;?>" alt="video-img" id="1" >         
                                <button class="video_btn"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/play_icon.svg"> play video</button>
                            <?php }else { ?>
                                <img src="<?php echo wp_get_attachment_url($bannerSlides[1]);?>" id="2" >
                                 <button class="rightImg-details"><img src="<?php echo get_template_directory_uri();?>/assets/images/fullscreen-icon.svg" alt="img"></button>           
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-md-11 col-md-offset-1">                     
                        <div class="video_content">
                            <?php  $content = apply_filters( 'the_content', get_the_excerpt() );
                             $first_parg = substr( $content, 0, strpos( $content, '</p>' ) + 4 );
                                 

                                echo '<h3 class="video_title">'.strip_tags($first_parg).'</h3>'; 
                                echo str_replace($first_parg,"",$content);
                             ?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-5 col-md-5">
                <?php if($video_flag){ ?>
                <div class="gallary_list">
                    <div class="gallary">                               
                        <img src="<?php echo wp_get_attachment_url($bannerSlides[1]);?>" id="3" alt="img" title="img">
                        <button class="rightImg-details"><img src="<?php echo get_template_directory_uri();?>/assets/images/fullscreen-icon.svg" alt="img"></button>   
                    </div>
                    <div class="gallary">                               
                        <img src="<?php echo wp_get_attachment_url($bannerSlides[2]);?>" id="4" alt="img" title="img">
                        <button class="rightImg-details"><img src="<?php echo get_template_directory_uri();?>/assets/images/fullscreen-icon.svg" alt="img"></button>   
                    </div>          
                </div>
                <?php } else { ?>
                    <div class="gallary_list">
                    <div class="gallary">                               
                        <img src="<?php echo wp_get_attachment_url($bannerSlides[2]);?>" id="3" alt="img" title="img">
                        <button class="rightImg-details"><img src="<?php echo get_template_directory_uri();?>/assets/images/fullscreen-icon.svg" alt="img"></button>   
                    </div>
                    <div class="gallary">                               
                        <img src="<?php echo wp_get_attachment_url($bannerSlides[3]);?>" id="4" alt="img" title="img">
                        <button class="rightImg-details"><img src="<?php echo get_template_directory_uri();?>/assets/images/fullscreen-icon.svg" alt="img"></button>   
                    </div>          
                </div>
                 
                <?php } ?>

                <div class="gallary_list_c">
                    <h3 class="section_title">Accommodation</h3>
                    <?php 
                        if($_room_description !='' && isset($_room_description))
                        {
                            echo '<p>'.$_room_description.'<p>';
                        }
                    ?>
                </div>

                <div class="gallary_list_c">
                    <h3 class="section_title">Amenities</h3>
                    <?php 
                    $_amty_arr = array();
                        if(!empty(get_post_meta(get_the_ID(),'_property_amenities',true)))
                        {
                            $_property_amenities = implode(", ",get_post_meta(get_the_ID(),'_property_amenities',true));
                            array_push($_amty_arr, $_property_amenities);
                        }
                        
                        if(!empty(get_post_meta(get_the_ID(),'_property_situation',true)))
                        {
                            $_property_situation = get_post_meta(get_the_ID(),'_property_situation',true);
                            array_push($_amty_arr, $_property_situation);
                        }
                        if(!empty(get_post_meta(get_the_ID(),'_property_parking',true)))
                        
                        {
                           $_property_parking  = implode(", ",get_post_meta(get_the_ID(),'_property_parking',true));
                           array_push($_amty_arr, $_property_parking);
                        }
                        if(!empty(get_post_meta(get_the_ID(),'_amity_keywords',true)))
                        
                        {
                           $_amity_keywords  = implode(", ",get_post_meta(get_the_ID(),'_amity_keywords',true));
                           array_push($_amty_arr, $_amity_keywords);
                        }
                        echo implode(", ",$_amty_arr);
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="map_section propertie_map_section wow fadeIn animated" data-wow-delay="0.2s">
    <div class="container">                 
        <div class="row">                                           
            <div class="col-lg-7 col-md-7"> 
                <h2 class="section_title">map</h2>
                <div class="map">

                     <?php 
                     if(get_post_meta(get_the_ID(),"_latitude",true) != '' &&  get_post_meta(get_the_ID(),"_longitude",true) != '')
                    {
                        echo do_shortcode("[locrating_all_in_one_map]");
                    }
                    ?>  
                </div>
            </div>
            <div class="col-lg-4 col-md-5 col-lg-offset-1">
                <?php if(!empty($_areas_res)) { ?>
                    <div class="gallary_list_c">
                        <h3 class="section_title">AREA GUIDE</h3>
                        <p><?php echo strip_tags($_areas_res->post_content);?>…. <a href="<?php echo get_permalink($_areas_res->ID);?>">Read More</a></p>
                    </div>
                <?php } ?>
                <?php if($_department == "residential-sales") { ?>
                <div class="gallary_list_c">
                    <h3 class="section_title">Stamp Duty Calculator</h3>
                    <?php echo get_field("stamp_duty_short_description","option");?>
                    <?php echo do_shortcode("[stamp_duty_calculator_scotland]");?>  
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<!-- <?php 
echo do_shortcode("[similar_properties property_id=" . get_the_ID() . " per_page='4' bedroom_bounds='1' ]");
?> -->
<?php echo do_shortcode("[single_similar_properties property_id=" . get_the_ID() . " per_page='4' bedroom_bounds='1' ]");?>


<section class="viewing-form wow fadeIn animated" data-wow-delay="0.2s" id="form-show">
    <div class="container">
        <div class="wrap">
            <div class="heading text-center">
                <h3>Arrange a viewing</h3>
                <p><?php echo strtoupper(get_the_title());?></p>
            </div>
             <?php if($_department == "residential-sales") 
				   {
						echo do_shortcode('[contact-form-7 id="28869" title="Arrange a viewing - SALE"]');
				   }else{
						echo do_shortcode('[contact-form-7 id="6664" title="Arrange a viewing - RENT"]');
					}
			?>
        </div>
    </div>
</section>
</div>
<div class="light_box" id="light_box">
    <div class="icon_list">
        <button type="button" onclick="closeFullscreen()" class="close_lightbox_btn"><img src="<?php echo get_template_directory_uri();?>/assets/images/close-icon.svg" alt="img"></button>
        <button type="button" class="grid_list"><img src="<?php echo get_template_directory_uri();?>/assets/images/grid_icon.svg" alt=""></button>
        <button type="button" class="fullscreen_btn" id="btnFullscreen"><img src="<?php echo get_template_directory_uri();?>/assets/images/fullscreen_icon.svg" alt=""></button>
    </div>
    
    <div class="lightbox_main">
        
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="slider_container" id="fullscreen_slider">
                        <div class="lightbox_slider properties-row">  
                            <?php if($video_flag ){  ?>
                           <div class="slide_img">
                                <div class="video_wrap">
                                    <?php
                                        if(videoType() == 2){
                                            echo '<iframe src="https://player.vimeo.com/video/'.$_property_video_id.'"  frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>';
                                        }else{
                                            echo '<iframe src="'.$_property_video_url.'"></iframe>';
                                        }
                                    ?>
                                </div>
                            </div>
                            <?php } ?>
                            <?php 
                                
                                foreach ($bannerSlides as $_ban_img) {
                                    echo '<div class="slide_img">';
                                        echo '<img src="'.wp_get_attachment_url($_ban_img).'" alt="banner_img">';    
                                    echo '</div>';
                               
                                }
                            ?>
                        </div>
                        <span class="slidercounter"></span>
                    </div>
                </div>
            </div>
        </div>  

        <div class="lightbox_gallary">      
            <div class="container">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-4 col-sm-8 col-sm-offset-4">
                            <?php if($video_flag){  ?>
                            <div class="row">
                                <div class="col-md-12"> 
                                    <div class="video video-block">
                                        <h2>Video</h2>
                                        <ul>
                                            <li>
                                                <img src="<?php echo $_property_video_img;?>" alt="video-img"> 
                                                <span class="play_btn"><img src="<?php echo get_template_directory_uri();?>/assets/images/play_icon.svg" alt="img"></span>
                                            </li>
                                        </ul>
                                    </div>                                              
                                </div>
                            </div>
                            <?php } ?>
                            <div class="row">
                                <div class="col-md-12"> 
                                    <div class="video photos-block">
                                        <h2>Photos (<?php echo count($bannerSlides);?>)</h2>             
                                           <ul>
                                            <?php 
                                                if($video_flag){
                                                    $b=2;
                                                }else
                                                {
                                                    $b=1;
                                                }
                                                foreach ($bannerSlides as $_ban_img) {
                                                    echo '<li>';
                                                        echo '<img src="'.wp_get_attachment_url($_ban_img).'" id="'.$b.'" alt="">';    
                                                    echo '</li>';
                                                $b++;
                                                }
                                            ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
   
</div>

<!-- Modal -->
<div id="makeoffer" class="modal fade home-modal makeoffer-modal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          <img src="<?php echo get_template_directory_uri();?>/assets/images/close-icon.svg" alt="close">
        </button>
        <h4 class="modal-title"><?php echo strtoupper(get_field("make_ofr_popup_heading","option")); ?></h4>
      </div>
      <div class="modal-body">
         <?php echo do_shortcode('[contact-form-7 id="6665" title="Make A Offer"]'); ?>
      </div>
    </div>

  </div>
</div>

<?php endwhile; // end of the loop. ?>
<script type="text/javascript">
jQuery(document).ready(function(){
        jQuery('[data-fancybox]').fancybox({
        protect: true,
        buttons : [
          'close',
        ]
      });
  
});
</script>
    
<?php get_footer( 'propertyhive' ); ?>