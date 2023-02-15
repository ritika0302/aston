<?php
/**
 * The template for displaying the footer
 *
 * Contains the opening of the #site-footer div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

?>	
	<!-- =========================================
		Footer Section
		========================================== -->
		<footer class="footer">
			<div class="footer-top">
				<div class="container-fluid">
					<div class="footer-left">
						<div class="row">
							<div class="col-sm-12 col-md-6">
								<?php 
									if(get_field('footer_menu','option'))
									{
										echo '<div class="footer-menu wow fadeInUp " data-wow-delay="0.2s">';
											echo '<ul>';
												while (has_sub_field('footer_menu','option')) {
												$custom_or_page_link = 	get_sub_field('custom_or_page_link','option');
												if($custom_or_page_link == "page")
												{
													echo '<li><a href="'.get_sub_field('fot_menu_link','option').'">'.get_sub_field('fot_menu_name','option').'</a></li>';
												}else
												{
													echo '<li><a href="'.get_sub_field('fot_menu_cus_link','option').'">'.get_sub_field('fot_menu_name','option').'</a></li>';	
												}
												}
											echo '</ul>';
										echo '</div>';
									}
								?>
							</div>
							<div class="col-sm-12 col-md-6">
								<?php 
									$prime_logo = get_field("prime_logo","option");
									if(get_field("footer_office_address","option"))
									{
										echo '<div class="footer_address wow fadeInUp" data-wow-delay="0.5s">';
											echo get_field("footer_office_address","option");
										echo '</div>';
									}
								?>
								
										<?php 
											if(get_field('social_icons','option'))
											{
												echo '<div class="social-icon">';
												while (has_sub_field('social_icons','option')) {
													echo '<a href="'.get_sub_field('soc_icon_link','option').'" target="_blank"><i class="fa fa-'.get_sub_field('soc_icon_name','option').'" aria-hidden="true"></i></a>';
												}
												echo '</div>';
											}
										?>
								
							</div>
						</div>
					</div>
					<div class="footer-right wow fadeInUp " data-wow-delay="0.9s">
						<div class="footer-slider">
							<div class="row">								
								<div class="col-sm-12 col-xs-12">
									<div class="reviews">
										<div class="right">
											
											<div class="footer_review_slider">
												
														<?php echo do_shortcode("[google_review_slider]"); ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="newsletter-reviews">
							<div class="row">
								<div class="col-sm-6 col-xs-12">
									<div class="newsletter">
										<?php 
											if(get_field('footer_news_let_main_heading','option'))
											{
												echo '<h4>'.get_field('footer_news_let_main_heading','option').'</h4>';
											}
											if(get_field('footer_news_let_sub_heading','option'))
											{
												echo '<p>'.get_field('footer_news_let_sub_heading','option').'</p>';
											}
										?>
									
										<form class="js-cm-form" id="subForm" class="js-cm-form" action="https://www.createsend.com/t/subscribeerror?description=" method="post" data-id="5B5E7037DA78A748374AD499497E309E5D59BFDAE32062AAA3EE2178FA159C673A1C70B2554A4E5554E7E04298AE9332F8A77DCC0E52FCB1BBEC0E00CDA50289">
											<div class="input-group">
												<input autoComplete="Email" aria-label="Email" id="fieldEmail" maxLength="200" name="cm-otubc-otubc" required type="email" class="form-control js-cm-email-input qa-input-email sc-iwsKbI iMsgpL" placeholder="Enter your email" />
												<input type="submit" value="Subscribe" class="btn btn-large btn-primary" />
											</div>
										</form>
										<!-- <script type="text/javascript" src="https://email.cmsadmin.eu/h/r/6CA55CF9D58A269E2540EF23F30FEDED/744E8355BF82DF2E/popup.js"></script> -->
									</div>
									<script type="text/javascript" src="https://js.createsend1.com/javascript/copypastesubscribeformlogic.js"></script>
								</div>
								<div class="col-sm-6 col-xs-12">
									
									<?php 
										$prime_logo = get_field("prime_logo","option");
										if(!empty($prime_logo) && $prime_logo['url'] != '')
										{
											echo '<div class="prime-logo wow fadeInUp" data-wow-delay="0.5s">';
												echo '<img src="'.$prime_logo['url'].'" alt="'.$prime_logo['alt'].'">';		
											echo '</div>';
										}										
									?>
									
								</div>
							</div>
						</div>
					</div>
				</div>	
			</div>
			<div class="footer-bottom wow fadeInUp ">
				<div class="container-fluid">
					<div class="row">
						<div class="col-sm-6 col-xs-12 hidden-xs">
							<?php echo get_field("about_site_info","option"); ?>
						</div>
						<div class="col-xs-12 text-center hidden-sm hidden-md hidden-lg">
							<?php
								$footer_logo = get_field("footer_logo","option");
								if(!empty($footer_logo) && $footer_logo['url'] != '')
								{
									echo '<div class="footer-logo">';
										echo '<a href="'.home_url().'" ><img src="'.$footer_logo['url'].'" alt="'.$footer_logo['alt'].'"></a>';		
									echo '</div>';
								}
							?>
						</div>
						<div class="col-sm-6 col-xs-12">
							<div class="right-text">
								<?php echo get_field("copyright_text","option"); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<div class="site-overlay"></div>
	</div>
	
<script type="text/javascript">
	var terms_page 		= "<?php echo get_permalink(152);?>";
	var cokie_page 		= "<?php echo get_permalink(154);?>";
	var privacy_page  = "<?php echo get_permalink(3);?>";
jQuery( document ).ready(function() {

	 jQuery(".privacypolicy .wpcf7-list-item-label").html('I agree to the <a href="'+terms_page+'" target="_blank" >Terms and Conditions</a>, <a href="'+privacy_page+'" target="_blank">Privacy Policy</a> &amp; <a href="'+cokie_page+'" target="_blank" >Cookie Policy</a> *');
		jQuery(".privacypolicy .wpcf7-list-item-label").wrapAll("<label class=label' for='privacy_policy'></label>");

		jQuery(".newsletters .wpcf7-list-item-label").html(' I agree to receiving property updates, important Aston Chase announcements and the occasional newsletter in accordance with the <a href="'+privacy_page+'" target="_blank">Privacy Policy</a>');
		jQuery(".newsletters .wpcf7-list-item-label").wrapAll("<label class=label' for='newsletter'></label>");

  jQuery(".privacy_policy .wpcf7-list-item-label").html('I agree to the <a href="'+terms_page+'" target="_blank" >Terms and Conditions</a>, <a href="'+privacy_page+'" target="_blank">Privacy Policy</a> &amp; <a href="'+cokie_page+'" target="_blank" >Cookie Policy</a> *');
	jQuery(".privacy_policy .wpcf7-list-item-label").wrapAll("<label class=label' for='privacy_policy'></label>");

	jQuery(".newsletter .wpcf7-list-item-label").html(' I agree to receiving property updates, important Aston Chase announcements and the occasional newsletter in accordance with the <a href="'+privacy_page+'" target="_blank">Privacy Policy</a>');
	jQuery(".newsletter .wpcf7-list-item-label").wrapAll("<label class=label' for='newsletter'></label>");
	
})
</script>
<script type="text/javascript">
	document.addEventListener( 'wpcf7mailsent', function( event ) {
    location = "<?php echo get_permalink(360);?>";
   
}, false );
</script>
<?php if(is_singular('property' )) { ?>		
<script type="text/javascript">
function toggleFullscreen(elem) {
  elem = elem || document.documentElement;
  if (!document.fullscreenElement && !document.mozFullScreenElement &&
    !document.webkitFullscreenElement && !document.msFullscreenElement) {
    if (elem.requestFullscreen) {
      elem.requestFullscreen();
    } else if (elem.msRequestFullscreen) {
      elem.msRequestFullscreen();
    } else if (elem.mozRequestFullScreen) {
      elem.mozRequestFullScreen();
    } else if (elem.webkitRequestFullscreen) {
      elem.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
    }
  } else {
    if (document.exitFullscreen) {
      document.exitFullscreen();
    } else if (document.msExitFullscreen) {
      document.msExitFullscreen();
    } else if (document.mozCancelFullScreen) {
      document.mozCancelFullScreen();
    } else if (document.webkitExitFullscreen) {
      document.webkitExitFullscreen();
    }
  }
}

document.getElementById('btnFullscreen').addEventListener('click', function() {
  toggleFullscreen();
});

function closeFullscreen() {
  if (document.exitFullscreen) {
    document.exitFullscreen();
  } else if (document.webkitExitFullscreen) { /* Safari */
    document.webkitExitFullscreen();
  } else if (document.msExitFullscreen) { /* IE11 */
    document.msExitFullscreen();
  }
}

</script>
<?php } ?>

	<?php wp_footer(); ?>

	</body>
</html>
