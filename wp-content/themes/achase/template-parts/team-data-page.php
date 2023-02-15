<?php // Template Name: team-data-page ?>

<?php 

	$nonce = $_REQUEST['_wpnonce'];
	if ( wp_verify_nonce( $nonce, 'team-id' ) ) {
	     
		if(isset($_GET['post_id'])) {

			/* Team Ajax Load Data Template Start */

				$post_id = sanitize_text_field($_GET['post_id']);
				$member = get_post( $post_id ); 
				
				$member_id = $member->ID;
				$member_name = $member->post_title;
				$member_acf_data = get_field('team_member_information', $member_id );
				$member_position = $member_acf_data['position'];
				$member_email = $member_acf_data['e-mail'];
				$member_phone = $member_acf_data['phone'];
				$member_business_card = $member_acf_data['business_card'];
				$member_tel_phone = $member_acf_data['phone'];
				$member_description = $member_acf_data['description'];
				$member_profile_image = $member_acf_data['team_upload_image'];
				if(!empty($member_profile_image))
				{
					$member_profile_image_url = $member_profile_image['url'];
				}else
				{
					$member_profile_image_url = get_template_directory_uri()."/assets/images/team-user-img.png";
				}
						
				$category = get_the_terms( $member_id, 'team-category' );
				$temp = '';
				if(!empty($category))
                {
					foreach ( $category as $cat){
						$member_category_slug = array();     
					   	$member_category_name = $cat->name;
					   	$member_category_slug = $cat->slug;
					   	$temp .= $member_category_slug.' ';
					} 
			    }?>

				<div class="team_section">
					<div class="container">
						<div class="row">
							<div class="col-md-4">
								<img src="<?php echo $member_profile_image_url ; ?>" alt="img">
							</div>
							<div class="col-md-8">
								<div class="team_content">
									<h3><?php echo $member_name; ?><span><?php echo $member_position; ?></span></h3>
									<p><?php echo $member_description; ?></p>

									<ul class="list-inline">
										<li><a href="tel:<?php echo $member_tel_phone; ?>">T: <?php echo $member_tel_phone; ?></a></li>
										<li><a href="mailto:<?php echo $member_email ; ?>">Email me</a></li>
										<li><a href="<?php echo $member_business_card; ?>" download="">Download Business Card</a></li>
										
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div> <?php

			/* End */

		}

	}else{

		get_template_part( 404 );

	}

?>