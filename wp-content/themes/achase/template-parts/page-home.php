<?php
/*
  ** Template Name:Home
*/
?>
<?php get_header(); ?>
<?php while ( have_posts() ) :  the_post();

$banner = get_field( 'home_add_banner' );
if( is_array( $banner ) ) {
  $banner_data = array_rand( $banner );
    $_banner_type = $banner[$banner_data]['display_image_or_video'];
    if($_banner_type == "video")
    {
      $_banner_val = $banner[$banner_data]['home_upload_video'];
    }else if($_banner_type == "image")
    {
      $_banner_val = $banner[$banner_data]['home_upload_image'];  
    }
    $_banner_content = $banner[$banner_data]['home_banner_content'];
    
}
?>
<?php if($_banner_type == "video") { ?>
<section class="home-banner push banner hb-slider wow fadeIn animated" >
       <video id="bannerVideo" autoplay="" muted="" playsinline="" loop="" preload="none" >
          <source src="<?php echo $_banner_val;?>" type="video/webm">
        </video>
      <div class="banner-text wow fadeIn" data-wow-delay="1s">
          <?php echo $_banner_content;?>
      </div>
      <div class="skip-banner"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
</section>
<?php } else if($_banner_type == "image") { ?>
<section class="home-banner push banner hb-slider wow fadeIn animated" >
      <div class="banner_img slider-img" style="background-image: url(<?php echo $_banner_val;?>); visibility: visible;
      animation-name: sliderImg; "></div>
      <div class="banner-text wow fadeIn" data-wow-delay="1s">
          <?php echo $_banner_content;?>
      </div>
      <div class="skip-banner"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
</section>
<?php } ?>

    <!-- Content Start -->
    <div id="content" class="push">

      <!--  Property Type Block Section -->
      <?php
          if(get_field("add_property_type_data",get_the_ID()))
          {
              echo '<section class="property-experts wow fadeIn">';
                echo '<div class="container">';
                  echo '<h2>'.get_field("home_propty_main_headig",get_the_ID()).'</h2>';
                  echo '<div class="row">';
                    while(has_sub_field("add_property_type_data",get_the_ID()))
                    {
                      $property_banner_image = get_sub_field("property_banner_image",get_the_ID());
                      echo '<div class="col-sm-4 ">';
                        echo '<div class="property-box">';
                          echo '<div class="property-blocks">';
                            echo '<img src="'.$property_banner_image['url'].'" alt="'.$property_banner_image['alt'].'">';
                             echo '<a href="'.get_sub_field("home_property_link",get_the_ID()).'" class="hover-content">';
                            //   echo '<div class="content">';
                            //     echo 'VIEW PROPERTIES';
                            //     echo '</div>';
                            echo '</a>';    
                          echo '</div>';    
                          echo '<a href="'.get_sub_field("home_property_link",get_the_ID()).'"><h3>'.get_sub_field("home_property_type",get_the_ID()).'</h3></a>';
                        echo '</div>';  
                      echo '</div>';
                    }
                  echo '</div>';
                echo '</div>';
              echo '</section>';
          }

      ?>

      <!--  Featured Section -->
      <section class="featured-properties wow fadeIn">
        <?php
            global $property;
            if(get_field("home_featu_main_heading",get_the_ID()))
            {
                echo '<div class="container">';               
                  echo '<h2>'.get_field("home_featu_main_heading",get_the_ID()).'</h2>';
                echo '</div>';
            }
            
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
         
            $featu_propty_qry = new WP_Query(
            array(
              'post_type' => 'property',
              'posts_per_page' => -1,
              'post_status' => 'publish',
              'meta_query'     => 
               array(
                    'relation'   => 'AND',
                      array(
                          'key'       => '_featured',
                          'value'     => 'yes',
                          'compare'   => '==',
                      ),
                      $subplot,
                  ),
              ) 
          );
            if ( $featu_propty_qry->have_posts() ) {
              echo '<div class="properties-slider">';
              while ( $featu_propty_qry->have_posts() ) { $featu_propty_qry->the_post();
                $bannerSlides       = $property->get_gallery_attachment_ids();
                $_propty_short_desc = get_the_excerpt();
                $_size_string       = get_post_meta(get_the_ID(),'_size_string',true);
                $_bathrooms         = get_post_meta(get_the_ID(),'_bathrooms',true);
                $_bedrooms          = get_post_meta(get_the_ID(),'_bedrooms',true);
                
                $dep = get_post_meta(get_the_ID(), '_department',true);
                if($dep == "residential-lettings")
                { 
                    $_rent_frequency      = get_post_meta(get_the_ID(),'_rent_frequency',true);
                    $_rent_price = str_replace("&#163;","",get_post_meta(get_the_ID(), '_rent',true));
                    
                    if($_rent_frequency == "pd")
                    {
                      $r_frequency = "per day";
                    }else if($_rent_frequency == "pw")
                    {
                      $r_frequency = "per week";
                    }else if($_rent_frequency == "pq")
                    {
                      $r_frequency = "per quarter";
                    }else if($_rent_frequency == "pa")
                    {
                      $r_frequency = "per annum";
                    }
                    $cur_sybol = '£';
                    $property_price = $cur_sybol.number_format($_rent_price,2, get_option('propertyhive_price_decimal_separator', '.'), get_option('propertyhive_price_thousand_separator', ','))." ".$r_frequency;
                    
                }else
                {
                    $property_price     = $property->get_formatted_price();
                }

                echo '<div class="">'; 
                    echo '<div class="container-fluid">';
                      echo '<div class="row">';
                        
                        echo '<div class="col-sm-6 col-md-7 matchHeight">';
                          echo '<a href="'.get_permalink().'" class="properties-big-img matchHeight" style="background-image: url('.wp_get_attachment_url($bannerSlides[0]).'); " ></a>';
                        echo '</div>'; 
                        echo '<div class="col-sm-6 col-md-5 matchHeight">';
                          echo '<a href="'.get_permalink().'" class="properties-small-img wow fadeInUp " data-wow-delay="0.2s" style="background-image: url('.wp_get_attachment_url($bannerSlides[1]).'); "></a>';
                          echo '<div class="properties-content wow fadeInUp " data-wow-delay="0.2s">';
                            echo '<h3>'.get_the_title().'</h3>';
                            echo '<ul>';
                              if(isset($_size_string) && $_size_string != '')
                              { 
                                echo '<li><img src="'.get_template_directory_uri().'/assets/images/sq-ft.png" alt="sq-ft.png">'.$_size_string.'</li>';
                              }
                              if(isset($_bedrooms) && $_bedrooms != '')
                              {
                                echo '<li><img src="'.get_template_directory_uri().'/assets/images/bathrooms2.png" alt="bathrooms2.png">'.$_bedrooms.' Bedrooms</li>';
                              }
                              if(isset($_bathrooms) && $_bathrooms != '')
                              {
                                echo '<li><img src="'.get_template_directory_uri().'/assets/images/bathrooms.png" alt="bathrooms.png">'.$_bathrooms.' Bathrooms</li>';
                              }
                            echo '</ul>';
                            echo '<p>'.substr($_propty_short_desc, 0, 360).'...</p>';
                            echo '<div class="price">'.$property_price.' <p class="sub-tenure">'.strtoupper($property->tenure).'</p></div>';
                            echo '<div class="view-listing"><a href="'.get_permalink().'" >VIEW LISTING</a></div>'; 
                          echo '</div>';
                        echo '</div>';
                      echo '</div>';
                    echo '</div>';
              echo '</div>';
              }
              echo '</div>';
            }wp_reset_postdata();
             
        ?>
      </section>
      <section class="market_property wow fadeInUp">
        <div class="container">
          <div class="col-md-8 mx-auto">
            <?php the_content();?>
          </div>
        </div>
      </section>
      <!--  Blog Section -->
      <section class="the-journal">
        <div class="container">
          <h2><?php echo get_field("home_journal_main_heading",get_the_ID());?></h2>
          <div class=" view-all">
            <a href="<?php echo get_field("home_journal_page_link",get_the_ID());?>">VIEW ALL</a>
          </div>
          <?php
            $journal_qry = new WP_Query(
                   array(
                      'post_type' => 'post',
                      'posts_per_page' => '6',
                      'post_status' => 'publish',
                      )
            );
            if ( $journal_qry->have_posts() ) {
                echo '<div class="row">';
                while ( $journal_qry->have_posts() ) {
                    $journal_qry->the_post();
                    $fea_url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
                    $fea_alt = get_post_meta ( get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true );

                    echo '<div class="col-sm-6 col-md-4 col-xs-12">';  
                      echo '<div class="journal-block">';
                        echo '<div class="img">';
                          echo '<img src="'.$fea_url.'" alt="'.$fea_alt.'">';
                          echo '<div class="hover-content">';
                            echo '<div class="content">';
                              echo '<p>'.get_the_excerpt().'</p>';
                              echo '<a href="'.get_permalink().'" class="read-more">READ MORE</a>';
                            echo '</div>';
                          echo '</div>';   
                        echo '</div>';
                        echo '<h3>'.get_the_title().'</h3>';  
                      echo '</div>';
                    echo '</div>';
                }
                echo '</div>';
            }wp_reset_postdata();
          ?>
          
        </div>
      </section>

      <!--  Our Story Section -->
      <section class="wow fadeIn">
        <div class="container-fluid">
          <?php $home_story_banner_img = get_field("home_story_banner_image",get_the_ID()); ?>
          <div class="our-story" style="background-image: url(<?php echo $home_story_banner_img['url'];?>);">
            <div class="row">
              <div class="col-sm-8 col-xs-12 col-md-7 col-lg-4">
                <h2><?php echo get_field("home_story_main_heading",get_the_ID());?></h2>
                <?php echo get_field("home_story_content",get_the_ID());?>
                <div class="read-more">
                  <a href="<?php echo get_field("home_story_page_link",get_the_ID());?>">LEARN MORE</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
<?php endwhile; ?>
<?php if(get_field("show_popup","option")){ ?>
<div id="cookie_bar" class="modal saved-search-modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          <img src="<?php echo get_template_directory_uri();?>/assets/images/close-icon.svg" alt="close">
        </button>
        <h5 class="modal-title"><?php echo strtoupper(get_field("popup_heading","option")); ?></h5>
      </div>
      <div class="modal-body">
        <p><?php echo get_field("popup_content","option"); ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary cookie-btn"><?php echo get_field("cook_button_name","option"); ?></button>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<?php get_footer(); ?>

