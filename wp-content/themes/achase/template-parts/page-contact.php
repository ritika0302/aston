<?php // Template Name: Contact-us ?>
<?php get_header(); ?>

<div id="content" class="top-spacing">
   <?php echo Fn_cms_inner_banner(get_the_ID());?>
   <?php if(get_the_post_thumbnail_url() == '') { ?>
   <div class="contact-section wow fadeInUp no-bg-img" data-wow-delay="0.2s">
   <?php } else { ?>
   <div class="contact-section wow fadeInUp" data-wow-delay="0.2s">
   <?php } ?>
        <div class="container">
           <div class="headings">
              <?php the_content(); ?>
           </div>
           <?php if(get_the_post_thumbnail_url() != '') { ?>
           <div class="contact-largeimage" style="background-image: url(<?php echo get_the_post_thumbnail_url(); ?>);"></div>
               <div class="vertical-title wow fadeInDown">
                  <div class="sideline"></div>
                  <span><?php the_title();?></span>
               </div>
           <?php } ?>
        </div>        
   </div>

   <div class="contactinfo-section new-contact-section wow fadeInUp" id="nc-section" data-wow-delay="0.2s">
        <div class="container">
            <?php if(get_the_post_thumbnail_url() != '')  { ?>
            <div class="vertical-title wow fadeIn">
               <div class="sideline"></div>
               <span><?php the_title(); ?></span>
            </div>
            <?php } ?>
            <?php if(the_field('contact_us_extra_text_') != '') { ?>
            <div class="headings">
               <p><?php echo the_field('contact_us_extra_text_'); ?></p>
            </div>
            <?php } ?>
            <div class="towcol-row">
               <div class="row">
                  <div class="col-sm-6 leftcol">
                     <div class="contactinfo-col" id="contactinfo-col">
                        <?php 
                           $email_section_data = the_acf_group_fields('contact_information','email_section');
                           $phone_section_data = the_acf_group_fields('contact_information','phone_section');
                           $address_section_data = the_acf_group_fields('contact_information','address_section');
                          $whatsapp_section_data = the_acf_group_fields('contact_information','whatsapp_section');
                         ?>
                           <div class="contactinfo-row">
                              <h3><?php echo $email_section_data['heading']; ?></h3>
                              <p>
                                 <?php echo $email_section_data['text']; ?>
                              </p>
                           </div>
                           <div class="contactinfo-row">
                              <h3><?php echo $phone_section_data['heading']; ?></h3>
                              <p>   
                                 <?php echo $phone_section_data['text']; ?>
                              </p>
                           </div>
                           <div class="contactinfo-row">
                              <h3><?php echo $address_section_data['heading']; ?></h3>
                              <p>
                                 <?php echo $address_section_data['text']; ?>
                              </p>
                           </div>
                     </div>
                  </div>
                  <div class="col-sm-6 rightimage">
                     <div class="image-col">
                           <img src="<?php echo the_field('contact_us_section_image'); ?>">
                     </div>
                  </div>
               </div>
            </div>
        </div>
   </div>

   <div class="contactform-section" id="ct-frm">
        <div class="container">
               <div class="vertical-title wow fadeInDown">
                  <div class="sideline"></div>
                  <span><?php the_title();?></span>
               </div>
            
            <div class="contactform-row">
               <h3><?php echo the_field('contact_form_title'); ?></h3>
               <div class="contactform-col">
                  <div class="contactform">
                  <?php 
                     $cfrm = get_field('contact_form');
                     echo do_shortcode($cfrm); 
                    ?>
                  </div>
               </div>
            </div>
        </div>
    </div>

</div>

<?php get_footer(); ?>