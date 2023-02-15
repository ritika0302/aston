<?php // Template Name: Journal ?>
<?php get_header(); ?>
<?php 
	echo '<div id="content" class="top-spacing">';
		echo Fn_cms_inner_banner(get_the_ID());
		echo '<div class="the-journal journallist-section">';
			echo '<div class="container">';
				echo '<div class="masonry">';
					echo '<div class="masonry-dropbtn">All</div>';
					echo '<div id="js-filters-lightbox-gallery1" class="button-group filters-button-group masonry-dropdown button-group filters-button-group">';
						if(isset($_GET['cid']) && $_GET['cid'] != '')
						{
							$all_cls = '';
							
						}else
						{
							$all_cls = 'is-checked';
							
						}
						echo '<a class="button '.$all_cls.' cbp-filter-item" href="'.get_permalink().'" ><span>All</span></a>';
						$categories = get_categories();
						foreach ($categories as $_cat) {
							if(isset($_GET['cid']) && $_cat->term_id == $_GET['cid'])
							{
								echo '<a class="button is-checked cbp-filter-item" href="'.get_permalink().'/?cid='.$_cat->term_id.'"><span>'.$_cat->name.'</span></a>';
							}else
							{
								echo '<a class="button cbp-filter-item" href="'.get_permalink().'/?cid='.$_cat->term_id.'"><span>'.$_cat->name.'</span></a>';
							}
						}
					echo '</div>';
					echo '<div class="grid cbp journal-list" id="js-grid-lightbox-gallery">';	
					$paged = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
					if(isset($_GET['cid']) && $_GET['cid'] != '')
					{
						$journal_qry = new WP_Query(
		                   array(
		                      'post_type' => 'post',
		                      'posts_per_page' => '21',
		                      'post_status' => 'publish',
		                      'paged' => $paged,
		                      'cat' => $_GET['cid'],
		                      )
		            	);
					}else
					{
						$journal_qry = new WP_Query(
		                   array(
		                      'post_type' => 'post',
		                      'posts_per_page' => '21',
		                      'post_status' => 'publish',
		                      'paged' => $paged,
		                      )
		            	);	
					}
					

		             if ( $journal_qry->have_posts() ) {
						  while ( $journal_qry->have_posts() ) {  $journal_qry->the_post();
							$featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full');
							$fea_alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); 
							$joun_cat = get_the_category();

							$_jcatname = array();
		            		foreach ($joun_cat as $_joun_cat) {
		            			$_jcatname[] = $_joun_cat->slug;
		            			
		            		}
		            		
							echo '<div class="element-item cbp-item '.implode(" ",$_jcatname).' " data-category="">';
								echo '<div class="journal-block">';
									echo '<div class="img">';
										echo '<img src="'.$featured_img_url.'" alt="'.$fea_alt.'">';
										echo '<div class="hover-content">';
											echo '<a href="'.get_permalink().'" class="content">';
												echo '<p>'.get_the_excerpt().'</p>';
												echo '<div class="read-more">READ MORE</div>';
											echo '</a>';	
										echo '</div>';
									echo '</div>';
									echo '<h3><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';
								echo '</div>';
							echo '</div>';
						}
					
					echo '</div>';
					echo '<div class="nextprev-btnrow">';
						echo '<div class="prev">'.get_previous_posts_link( __( 'Previous', 'twentytwenty' ) )."</div>";
						echo '<div class="next">'.get_next_posts_link( __( 'Next', 'twentytwenty' ), $journal_qry->max_num_pages ).'</div>';
						
					echo '</div>';
					}wp_reset_postdata();	
				echo '</div>';
			echo '</div>';
		echo '</div>';
	echo '</div>';
?>
<?php get_footer(); ?>