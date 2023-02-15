<?php // Template Name: Master Property ?>
<?php get_header(); ?>
<?php 
$pid 				   = intval($_GET['pid']);
$property              = new PH_Property($pid);
$bannerSlides          = $property->get_gallery_attachment_ids();

$_department           = get_post_meta($pid,'_department',true); 
$_currency             = get_post_meta($pid,'_currency',true);
$_price_qualifier      = get_post_meta($pid,'_price_qualifier',true);
$floorplan             = get_post_meta($pid,"_floorplans",true);
$_brochures            = get_post_meta($pid,"_brochures",true);
$_room_description     = get_post_meta($pid,"_room_description",true);
if(get_current_user_id() != '')
{
    $logged_user_id = get_current_user_id();
}else
{
    $logged_user_id = '';
}
$_saved_prperty = get_post_meta($pid,'saved_prperty',true);

$_areas_res = '';

if(get_post_meta($pid,"_address_two",true) != '')
{
   $_address_two = str_replace("&#039;","'",get_post_meta($pid,"_address_two",true));
   $_areas_res            = get_page_by_title($_address_two, OBJECT,"areas"); 
   
   if(get_post_meta($pid,"_address_three",true) != '' && $_areas_res == '' )
    {

    if(get_post_meta($pid,"_address_three",true) == "Palgrave Gardens")
    {
        $_address_three        = "Regents Park";
    }else if(get_post_meta($pid,"_address_three",true) == "Swiss Cottage, London" || get_post_meta($pid,"_address_three",true) == "London")
    {
        $_address_three        = "North West & Central London";
    }else if(get_post_meta($pid,"_address_three",true) == "West Hampstead")
    {
        $_address_three        = "Hampstead";
    }else if(get_post_meta($pid,"_address_three",true) == "St Johns Wood")
    {
        $_address_three        = "St John&#039;s Wood";
    }else
    {
        $_address_three        = get_post_meta($pid,"_address_three",true);
    }

    $_address_three = str_replace("&#039;","'",$_address_three);
    $_areas_res                = get_page_by_title($_address_three, OBJECT,"areas"); 
    }
}else if (get_post_meta($pid,"_address_three",true) != '')
{
    
    if(get_post_meta($pid,"_address_three",true) == "Palgrave Gardens")
    {
        $_address_three        = "Regents Park";
    }else if(get_post_meta($pid,"_address_three",true) == "Swiss Cottage, London" || get_post_meta($pid,"_address_three",true) == "London" || get_post_meta($pid,"_address_three",true) == "Brondesbury Park, London")
    {
        $_address_three        = "North West & Central London";
    }else if(get_post_meta($pid,"_address_three",true) == "West Hampstead")
    {
        $_address_three        = "Hampstead";
    }else if(get_post_meta($pid,"_address_three",true) == "St Johns Wood")
    {
        $_address_three        = "St John&#039;s Wood";
    }else
    {
        $_address_three        = get_post_meta($pid,"_address_three",true);
    }

    $_address_three = str_replace("&#039;","'",$_address_three);
    $_areas_res                = get_page_by_title($_address_three, OBJECT,"areas"); 
}

$_property_EPC         = get_post_meta($pid,"_property_EPC",true);
$_team_res            = get_page_by_title(trim(get_post_meta($pid,"_negotiator_name",true)), OBJECT,"team");
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
if(get_post_meta($pid,"_negotiator_telephone",true) != '')
{
    $team_phone = get_post_meta($pid,"_negotiator_telephone",true);
}else
{
    $team_phone = get_post_meta($pid,"_negotiator_mobile",true);
}
$_property_video = '';
$_property_video_img = '';
$_property_video_url = '';
$_property_videos_img = '';
$_property_videos_url = '';
$video_flag = false;

if(get_post_meta($pid,"_property_video",true) != '' && get_post_meta($pid,"_property_video",true) != 'PROPERTY VIDEO')
{
    
   $_property_video_id = GetYouTubeId(get_post_meta($pid,"_property_video",true));
   if($_property_video_id != '')
   {
        $_property_video_img   = "https://img.youtube.com/vi/".$_property_video_id."/hqdefault.jpg";
        $_property_video_url = "https://www.youtube.com/embed/".$_property_video_id;
        $video_flag = true;
    }
}

function videoType() {
    $pid 				   = intval($_GET['pid']);
    $url = get_post_meta($pid,"_property_video",true);
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
     $vimeo_url = get_post_meta($pid,"_property_video",true);
     $_property_video_id = (int) substr(parse_url($vimeo_url, PHP_URL_PATH), 1);
     $vim_thumb = unserialize(file_get_contents("http://vimeo.com/api/v2/video/".$_property_video_id.".php"));
     $_property_video_img = $vim_thumb[0]['thumbnail_large'];
     
     $video_flag = true;
}

if(get_post_meta($pid,"_property_videos",true) != '')
{
    
   $_property_videos_id = GetYouTubeId(get_post_meta($pid,"_property_videos",true));
   if($_property_videos_id != '')
   {
        $_property_videos_img   = "https://img.youtube.com/vi/".$_property_videos_id."/hqdefault.jpg";
        $_property_videos_url = "https://www.youtube.com/embed/".$_property_videos_id;
        
    }
    else
    {
        $_property_videos_url = get_post_meta($pid,"_property_videos",true);
    }
}


?>

<?php //while ( have_posts() ) : the_post(); ?>
<div id="content" class="top-spacing">
    <section class="propertie-banner wow fadeIn animated">
        <div class="banner_img" style="background-image: url(<?php echo wp_get_attachment_url($bannerSlides[0]);?>);"></div>
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

<section class="address_details address_details_master wow fadeIn animated" data-wow-delay="0.2s">
    <div class="container">                 
        <div class="row">
            <div class="col-md-12">                     
                <div class="property-heading">
                <h1 class="section_title"><?php echo get_post_meta($pid,'_address_street',true);?></h1>
                <h2><?php echo get_post_meta($pid,'_address_two',true).", ".get_post_meta($pid,'_address_three',true).", ".get_post_meta($pid,'_address_postcode',true);?></h2>
                </div>
            </div>                      
            <div class="col-lg-7 col-md-7">                     
                <div class="row">
                    <div class="col-md-12">                     
                        
                        <ul class="share_list list-inline">
                            <li><a href="javascript:void(0);" id="overview">
                            <img src="<?php echo get_template_directory_uri();?>/assets/images/overview-grey.svg" class="default_img">
                            <img src="<?php echo get_template_directory_uri();?>/assets/images/overview-orange.svg" class="hover_img">    
                            Overview</a></li>
                            <li><a href="javascript:void(0);" id="availability">
                            <img src="<?php echo get_template_directory_uri();?>/assets/images/availability-grey.svg" class="default_img">
                            <img src="<?php echo get_template_directory_uri();?>/assets/images/availability-orange.svg" class="hover_img">    
                            availability</a></li>
                        	<?php 
                        	if(!empty($_brochures)){ ?>
                                <li>
                                    <a href="<?php echo  wp_get_attachment_url($_brochures[0]);?>"  target="_blank" id="brochures">
                                    <img src="<?php echo get_template_directory_uri();?>/assets/images/brochur-grey.svg" class="default_img">
                                    <img src="<?php echo get_template_directory_uri();?>/assets/images/brochur-orange.svg" class="hover_img">
                                 brochure   
                                    </a>
                                </li>
                            <?php } ?>
                            <li>
                                <a class="share-icon" href="javascript:void(0)">
                                <img src="<?php echo get_template_directory_uri();?>/assets/images/share-grey.svg" class="default_img">
                                <img src="<?php echo get_template_directory_uri();?>/assets/images/share-orange.svg" class="hover_img">    
                                Share</a>
                                <div class="share-toggle">
                                     <ul>
                                        <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink($pid)); ?>&quote=<?php echo get_the_title();?>" target="_blank" >Facebook</a></li>
                                        <li><a href="https://twitter.com/intent/tweet?text=<?php echo get_the_title();?>&amp;url=<?php echo urlencode(get_permalink($pid)); ?>" target="_blank" >Twitter</a></li>
                                        
                                        <li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode(get_permalink($pid)); ?>&amp;title=<?php echo get_the_title();?>&amp;summary=&amp;source=<?php bloginfo('name'); ?>" target="_blank" >LinkedIn</a></li>
                                     </ul>
                                      <div class="copy_url">
                                          <input type="button" value="Copy Url" onclick="Copy();" />
                                          <input type="text" name="url" id="url">
                                         
                                     </div>
                                     <a class="share-close" href="javascript:void(0)">
                                        <img src="<?php echo get_template_directory_uri();?>/assets/images/close-icon2.svg">
                                        
                                     </a>
                                </div>
                            </li>
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
                        </ul>
                        <div class="overview_description share_list_description">
                                <?php 
                                    echo apply_filters('the_content',get_the_excerpt($pid));
                                ?>
                        </div>

                        <div class="availability_description share_list_description">
                            <?php   

                            $pstus = '';
                            $subplot = array(
                                        'relation' => 'OR',
                                        array(
                                            'key' => '_IsSubPlot',
                                            'value' => 1,
                                            'compare' => '==',
                                        ) ,
                                        array(
                                            'key' => '_SubPlots',
                                            'compare' => 'NOT EXISTS',
                                        ) ,
                                    );
                            $pstus = array(
                                            'key'       => '_InternalSaleStatus',
                                            'value'     => array('For Sale - Unavailable','Completed - Available','Exchanged - Available'),
                                            'compare'   => 'NOT IN',
                                            );
                            $c_home = array();

                            $c_home = explode(",",get_the_title($pid));
                            $p_ser = str_replace("\'", "&#039;", ucwords($c_home[0]));
                            $parea = array(
                                'relation' => 'OR',
                                 array(
                                    'key' => '_address_street',
                                    'value' => $p_ser,
                                    'compare' => 'Like',
                                ) ,
                                array(
                                    'key' => '_address_two',
                                    'value' => $p_ser,
                                    'compare' => 'Like',
                                ) ,
                                array(
                                    'key' => '_address_three',
                                    'value' => $p_ser,
                                    'compare' => 'Like',
                                ) ,
                                array(
                                    'key' => '_address_postcode',
                                    'value' => $p_ser,
                                    'compare' => 'Like',
                                )
                            );

                            $child_data = new WP_Query(
                                array(
                                  'post_type'       => 'property',
                                  'posts_per_page'  => -1,
                                  'post_status'     => 'publish',
                                  'meta_query'      =>array(
                                    'relation'  => 'AND',
                                            array(
                                                'key'       => '_department',
                                                'value'     => 'residential-sales',
                                                'compare'   => '==',
                                                ),
                                                $pstus,
                                                $subplot,
                                                $parea,
                                            ),
                                        )
                                    );
                            
                                if ( $child_data->have_posts() ) {
                                    echo '<table>';
                                        echo '<tr>';
                                            echo '<th>Type</th>';
                                            echo '<th>Beds</th>';
                                            echo '<th>Baths</th>';
                                            echo '<th>SqFt</th>';
                                            echo '<th>Price</th>';
                                            echo '<th>Status</th>';
                                            echo '<th>Details</th>';
                                            echo '<th>Brochure</th>';
                                        echo '</tr>';
                                    while ( $child_data->have_posts() ) { $child_data->the_post();
                                        $p_style    =  get_post_meta(get_the_ID(),"_property_style",true);
                                        $_baths     = get_post_meta(get_the_ID() , '_bathrooms', true);
                                        $_beds      = get_post_meta(get_the_ID() , '_bedrooms', true);
                                        $sqft       = get_post_meta(get_the_ID(),"_size",true);
                                        $_child_price_qual      = get_post_meta(get_the_ID(),'_price_qualifier',true);
                                        $_child_currency             = get_post_meta(get_the_ID(),'_currency',true);
                                        $_child_brochures            = get_post_meta(get_the_ID(),"_brochures",true);
                                        $property_price = $property->get_formatted_price(get_the_ID());

                                        $price_qulifer = '';
                                        if($_child_price_qual == "AP")
                                        {
                                            $price_qulifer = "Asking price"." ".$property_price;
                                        }else if($_child_price_qual == "GP")
                                        {
                                            $price_qulifer = "Guide price"." ".$property_price;
                                        }else if($_child_price_qual == "PA")
                                        {
                                            $price_qulifer = "Price on Application";
                                        }else if($_child_price_qual == "OR")
                                        {
                                            $price_qulifer = "Price from"." ".$property_price;
                                        }else if($_child_price_qual == '')
                                        {
                                            $price_qulifer = "Price Per week"." ".$property_price;
                                        }
                                        $_SaleStatus = get_post_meta(get_the_ID() , '_InternalSaleStatus', true);

                                        echo '<tr>';
                                            echo '<td>'.$p_style[0].'</td>';
                                            echo '<td>'.$_beds.'</td>';
                                            echo '<td>'.$_baths.'</td>';
                                            echo '<td>'.$sqft.'</td>';
                                            echo '<td>'.$price_qulifer.'</td>';
                                            echo '<td>'.$_SaleStatus.'</td>';
                                            echo '<td><a href="'.get_permalink(get_the_ID()).'">View Property</a></td>';
                                            if(!empty($_child_brochures))
                                            {
                                                echo '<td><a href="'.wp_get_attachment_url($_child_brochures[0]).'" target="_blank">Download</a></td>';
                                            }else
                                            {
                                                echo '<td></td>';
                                            }
                                        echo '</tr>';
                                       
                                    }
                                     echo '</table>';
                             
                                }wp_reset_postdata();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-5 col-md-5">
                
                <?php if($video_flag){ ?>
                    <div class="video">
                        <div class="video-block">
                            <img src="<?php echo $_property_video_img;?>" alt="video-img" id="1" >         
                            <button class="video_btn"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/play_icon.svg"> play video</button>
                        </div>
                    </div>
                <?php }else { ?>
                    <div class="img-block gallary_list">
                        <div class="gallary">
                        <img src="<?php echo wp_get_attachment_url($bannerSlides[1]);?>" id="2" >
                         <button class="rightImg-details"><img src="<?php echo get_template_directory_uri();?>/assets/images/fullscreen-icon.svg" alt="img"></button>           
                         </div>
                    </div>
                <?php } ?> 
                  
            </div>
        </div>
    </div>
</section>

<section class="master_sels_team">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="buying_services_text">
                    <div class="get_gouch_contact">
                       <img src="<?php echo $_team_profile;?>" alt="<?php echo $_team_profile_alt;?>" title="<?php echo $_team_res->post_title;?>">
                        <div class="text">
                            <h5>Discuss our newly built homes with our sales team on
                                <a href="tel:<?php echo $team_phone;?>"><?php echo $team_phone;?></a>
                            </h5>
                        </div>
                    </div>
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
                     if(get_post_meta($pid,"_latitude",true) != '' &&  get_post_meta($pid,"_longitude",true) != '')
                    { 
                        //echo '<div class="property-map" id="map"></div>';
						 echo do_shortcode("[locrating_all_in_one_map]");
                    }
                    ?>  
                </div>
            </div>
            <div class="col-lg-4 col-md-5 col-lg-offset-1">
                <div class="gallary_list_c">
                    <h3 class="section_title">AREA GUIDE</h3>
                    <p><?php echo strip_tags($_areas_res->post_content);?>…. <a href="<?php echo get_permalink($_areas_res->ID);?>">Read More</a></p>
                </div>
                <div class="gallary_list_c">
                    <h3 class="section_title">Stamp Duty Calculator</h3>
                    <?php echo get_field("stamp_duty_short_description","option");?>
                    <?php echo do_shortcode("[stamp_duty_calculator_scotland]");?>  
                </div>
            </div>
        </div>
    </div>
</section>
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
	                                <iframe src="<?php echo $_property_videos_url;?>"></iframe>  
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
<?php //endwhile; // end of the loop. ?>

<script type='text/javascript' src="https://maps.googleapis.com/maps/api/js?key=AIzaSyApIp2M7IlMuKoYe4DfY891V5iZs51K8WM&libraries=places"></script>
<script>
var map;
function initMap() {

var latitude            = <?php echo get_post_meta($pid,"_latitude",true); ?>;
var longitude           = <?php echo get_post_meta($pid,"_longitude",true); ?>;
var myCenter            = new google.maps.LatLng(latitude,longitude);
var zoom_level          = 13;
var mouse_scroll1       = 1;
var zoom_control1       = 1;
if( mouse_scroll1 == 1 ) {
    var mouse_scroll = true;
} else {
    var mouse_scroll = false;
}

if( zoom_control1 == 1 ) {
    var zoom_control = true;
} else {
    var zoom_control = false;
}
//document.getElementById
var map = new google.maps.Map(document.getElementById('map'), {
  center: {lat: latitude, lng: longitude},
  zoom: zoom_level,
  scrollwheel: mouse_scroll,
  zoomControl: zoom_control,
  disableDefaultUI: true,
});

var image = '<?php echo get_template_directory_uri() .'/assets/images/Home.svg'; ?>';
var marker = new google.maps.Marker({
    position: {lat: latitude, lng: longitude},
    map: map,
    icon: image,
});
}
function initMap1() {

var latitude            = <?php echo get_post_meta($pid,"_latitude",true); ?>;
var longitude           = <?php echo get_post_meta($pid,"_longitude",true); ?>;
var myCenter            = new google.maps.LatLng(latitude,longitude);
var zoom_level          = 13;
var mouse_scroll1       = 1;
var zoom_control1       = 1;
if( mouse_scroll1 == 1 ) {
    var mouse_scroll = true;
} else {
    var mouse_scroll = false;
}

if( zoom_control1 == 1 ) {
    var zoom_control = true;
} else {
    var zoom_control = false;
}
//document.getElementById
var map = new google.maps.Map(document.getElementById('map1'), {
  center: {lat: latitude, lng: longitude},
  zoom: zoom_level,
  scrollwheel: mouse_scroll,
  zoomControl: zoom_control,
  disableDefaultUI: true,
});

var image = '<?php echo get_template_directory_uri() .'/assets/images/Home.svg'; ?>';
var marker = new google.maps.Marker({
    position: {lat: latitude, lng: longitude},
    map: map,
    icon: image
});

    var service = new google.maps.places.PlacesService(map);
    service.nearbySearch({
      location: {lat: latitude, lng: longitude},
      radius: 1000, // radius takes a simple integer, representing the circle's radius in meters
      type: ['train_station']
    }, callback);
    
}

google.maps.event.addDomListener(window, 'load', initMap);
google.maps.event.addDomListener(window, 'load', initMap1);
</script>
<?php get_footer(); ?>