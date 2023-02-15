<?php
/**
 * Header file for the Twenty Twenty WordPress default theme.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

?><!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>

	<head>

		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
		<meta name = "format-detection" content = "telephone=no">
		<link rel="profile" href="https://gmpg.org/xfn/11">
        
		<?php wp_head(); ?>
		

		<!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-TQ4DBC5');</script>
        <!-- End Google Tag Manager -->
		
	</head>

	<body <?php body_class(); ?>>

		<!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TQ4DBC5"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
		
		<div id="wrapper">
	
		<!-- =========================================
		Header Section
		========================================== -->
		<?php
			$logo_img_white = get_field("logo_img_white","option"); 
			$logo_img_black = get_field("logo_img_black","option");
			$in_page_cls = ""; 
			if(is_front_page() || is_404()) 
			{
				$in_page_cls = ""; 
			} else
			{
				$in_page_cls = "header-inner"; 
			}
		?>
		<header class="navbar header fixed-top push <?php echo $in_page_cls;?>" >
			<div class="logo">
				<?php if(is_front_page() || is_404()) { ?>
					<?php if(!empty($logo_img_white) && $logo_img_white['url'] != '') { ?>
					<a class="navbar-brand white" href="<?php echo home_url();?>"><img src="<?php echo $logo_img_white['url'];?>" alt="<?php echo $logo_img_white['alt'];?>"></a>
					<?php } ?>
					<?php if(!empty($logo_img_black) && $logo_img_black['url'] != '') { ?>
					<a class="navbar-brand black" href="<?php echo home_url();?>"><img src="<?php echo $logo_img_black['url'];?>" alt="<?php echo $logo_img_black['alt'];?>"></a>
					<?php } ?>
				<?php } else{ ?>
					<a class="navbar-brand black" href="<?php echo home_url();?>"><img src="<?php echo $logo_img_black['url'];?>" alt="<?php echo $logo_img_black['alt'];?>"></a>
				<?php } ?>
			</div>
			<div class="main-menu">
				<div class="menu-icon" id="toggle">
					<span></span>
				</div>
			</div>
			<div class="search-box">
				<?php if(is_front_page() || is_404()) { ?>
				<div class="search-icon white"  data-toggle="modal" data-target="#searchModal">
					<i class="fa" aria-hidden="true"><img src="<?php echo get_template_directory_uri();?>/assets/images/search.svg" alt=""></i>
				</div>
				<div class="search-icon black"  data-toggle="modal" data-target="#searchModal">
					<i class="fa" aria-hidden="true"><img src="<?php echo get_template_directory_uri();?>/assets/images/search-black.svg" alt=""></i>
				</div>
				<?php } else{ ?>
					<div class="search-icon black"  data-toggle="modal" data-target="#searchModal">
					<i class="fa" aria-hidden="true"><img src="<?php echo get_template_directory_uri();?>/assets/images/search-black.svg" alt=""></i>
					</div>
				<?php } ?>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<img src="<?php echo get_template_directory_uri();?>/assets/images/close-icon.svg" alt="">
				</button>
			</div>
		</header>
		<!-- Search-Modal -->
		<div class="search-modal">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-body">
						<div class="navbar header fixed-top push" style="">
							<div class="logo">
								<?php if(!empty($logo_img_white) && $logo_img_white['url'] != '') { ?>
								<a class="navbar-brand white" href="<?php echo home_url();?>"><img src="<?php echo $logo_img_white['url'];?>" alt="<?php echo $logo_img_white['alt'];?>"></a>
								<?php } ?>
								<?php if(!empty($logo_img_black) && $logo_img_black['url'] != '') { ?>
								<a class="navbar-brand black" href="<?php echo home_url();?>"><img src="<?php echo $logo_img_black['url'];?>" alt="<?php echo $logo_img_black['alt'];?>"></a>
								<?php } ?>
							</div>
							<?php echo Property_Filter_Option();?>
							
							<button type="button" class="close close-desktop" data-dismiss="modal" aria-label="Close">
								<img src="<?php echo get_template_directory_uri();?>/assets/images/search-close.svg" alt="">
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="push-menu">
			<div class="menu-nav">
				<div class="close-menu">
					<img src="<?php echo get_template_directory_uri();?>/assets/images/close-icon.svg" alt="">
				</div>
				<?php if(!empty($logo_img_black) && $logo_img_black['url'] != '') { ?>
				<div class="manu-logo"><img src="<?php echo $logo_img_black['url'];?>" alt="<?php echo $logo_img_black['alt'];?>"></div>
				<?php } ?>
				<nav class="nav">
					<?php 
                	 wp_nav_menu(array(
                        
                        'menu_id' 		=> 'Main Nav Manu',
                        'container' 	=> '',
                        'menu_class'	=> 'mainMenu',
                        'walker'        => new Sublevel_Walker
                    ));
                ?>
				
				</nav>
				<div class="bottom-sticky">
					<div class="search-button">
						<a>Search For Properties</a>
					</div>
					<?php 
						if(get_field('social_icons','option'))
						{
							echo '<div class="header-social">';
							while (has_sub_field('social_icons','option')) {
								echo '<a href="'.get_sub_field('soc_icon_link','option').'"><i class="fa fa-'.get_sub_field('soc_icon_name','option').'" aria-hidden="true"></i></a>';
							}
							echo '</div>';
						}
					?>
				</div>
			</div>
			<div class="menu-featured">
				<div class="close-menu">
					<img src="<?php echo get_template_directory_uri();?>/assets/images/close-icon.svg" alt="">
				</div>
				<?php
		            $fea_jour_qry = new WP_Query(
		                   array(
		                      'post_type' => 'post',
		                      'posts_per_page' => '3',
		                      'post_status' => 'publish',
		                      )
		            );
		            if ( $fea_jour_qry->have_posts() ) {
		                echo '<div class="Journal-block">';
		                echo '<h2>Journal (News/PR)</h2>';
		                while ( $fea_jour_qry->have_posts() ) { $fea_jour_qry->the_post();
		                	$fea_url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
                    		$fea_alt = get_post_meta ( get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true );
		                	echo '<div class="featured-block">';
		                		echo '<div class="card-image">';
		                			echo '<img src="'.$fea_url.'" alt="'.$fea_alt.'">';
		                			echo '<div class="hover_text">';
		                				echo '<div class="content">';
		                					echo '<p>'.get_the_title().'</p>';
		                					echo '<a href="'.get_permalink().'" class="read_more">Read More</a>';
		                				echo '</div>';
		                			echo '</div>';
		                		echo '</div>';
		                		echo '<p><a href="'.get_permalink().'">'.get_the_excerpt().'</a></p>';
		                	echo '</div>';
		                }
		                echo '<a href="'.esc_url( get_page_link( 67 ) ).'" class="vm_journal">View More</a>';
		                echo '</div>';
		            }wp_reset_postdata();
                ?>
			</div>
		</div>
		<a id="back_to_top" class="scrollTop" href="javascript:void(0)"><i class="fa fa-angle-up" aria-hidden="true"></i></a> 