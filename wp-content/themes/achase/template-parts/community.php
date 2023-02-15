<?php // Template Name: Community ?>
<?php get_header(); ?>
			
<!-- Content Start -->
<div id="content" class="push top-spacing">
    <?php
        /* Inner Banner */
        echo Fn_service_inner_banner(get_the_ID());
    ?>
    <section>
        <div>
            <div class="custom_container">
                <div class="our_services_text buying_services_text">
                <?php
                    if(get_field("scrolling_title",get_the_ID()))
                    {
                        echo '<div class="vertical-title wow fadeInDown">';
                            echo '<div class="sideline"></div>';
                            echo '<span>'.get_field("scrolling_title",get_the_ID()).'</span>';
                        echo '</div>';
                    }
                ?>
                    <div class="inner_text">
                        <?php echo get_the_content(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $grid_blocks = get_field( 'grid_blocks' ); 
    if( !empty($grid_blocks) ) :
?>
    <section class="icon-text-block">
        <div class="custom_container">
            <div class="wrap">
                <div class="grid">

                    <?php 
                    foreach ($grid_blocks as $key => $g) {
                        echo '<div class="text-col">';
                            echo '<div class="img">';
                                echo '<img src="'.$g['image'].'">';
                            echo '</div>';
                            echo '<h3>'.$g['title'].'</h3>';
                            echo $g['content'];
                            $button = $g['button'];
                            $target = (!empty($button['target'])) ? 'target="_blank"' : '';
                            echo '<div class="bottom-btn">';
                                echo '<a '.$target.' href="'.$button['url'].'" class="btn btn-large btn-primary">'.$button['title'].'</a>';
                            echo '</div>';
                        echo '</div>';
                    } ?>
                    
                </div>
            </div>
        </div>
    </section>

<?php endif; ?>
</div>
    
<?php get_footer(); ?>