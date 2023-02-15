<?php // Template Name: Award ?>
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
                            <?php if( !empty(get_field('logo'))): ?>
                                <div class="content_logo">
                                    <img src="<?php echo get_field('logo'); ?>">
                                </div>
                            <?php endif; 
                                echo get_field('middle_content');
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php if(!empty(get_field('gray_box_content'))): ?>
            <section class="left-bg-text-col">
                <div class="custom_container">
                    <div class="text-block">
                        <?php echo get_field('gray_box_content'); ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <section class="awards-slider">
            <div class="custom_container">
                <?php 
                if(!empty(get_field('award_title'))) : 
                echo '<div class="title">';
                    echo '<h3>'.get_field('award_title').'</h3>';
                echo '</div>';
                endif;
                
                $awards = get_field('awards');
                if(!empty($awards)) :
                    echo '<div class="list">';
                        foreach ( $awards as $key => $a) {
                            echo '<div class="item">';
                                echo '<img src="'.$a['logo'].'" alt="awards">';
                            echo '</div>';
                        } 
                    echo '</div>';
                endif;
            ?>
            </div>
        </section>
    </div>
    <script>
        $(document).ready(function() {
            var right_value = $(".content-section .custom_container").offset().left;
            right_value = right_value + 30;
            $(".content-fullcolumn").css("margin-left", "-" + right_value + "px");
            $(".content-fullcolumn").css("padding-left", right_value + "px");
            var right_values = $(".content-section .custom_container").offset().left;
            right_values = right_values + 45;
            $(".image-col").css("margin-right", "-" + right_values + "px");
        });
        $(window).resize(function() {
            var right_value = $(".content-section .custom_container").offset().left;
            right_value = right_value + 30;
            $(".content-fullcolumn").css("margin-left", "-" + right_value + "px");
            $(".content-fullcolumn").css("padding-left", right_value + "px");
            var right_values = $(".content-section .custom_container").offset().left;
            right_values = right_values + 45;
            $(".image-col").css("margin-right", "-" + right_values + "px");
        });
        jQuery(window).scroll(function() {
            if (jQuery(window).width() > 767) {
                var scroll_value = jQuery(window).scrollTop();
                var bg_offset_value1 = jQuery(".content-section").offset().top;
                if (jQuery(".content-section .whitebg-row .rightimage").length > 0) {
                    var translate_value = (bg_offset_value1 - scroll_value) / jQuery(window).height() * 20
                    jQuery(".content-section .whitebg-row .rightimage").css({
                        transform: 'translateY(' + (translate_value) + '%)' + 'translateZ(0px)'
                    });
                }
            }
        });
        var $status = $('.pagingInfo');
        var $slickElement = $('.list_properties_slider');
        $slickElement.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
            //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
            var i = (currentSlide ? currentSlide : 0) + 1;
            
            $status.html("<span class='first'>" + i+"</span> <b>/</b> <span class='last'>"+slick.slideCount+ "</span>" );
            // $('#counter').html("<strong class='first'>" + item+"</strong> <b>/</b> <strong class='last'>"+items+ "</strong>" );
        });
	</script>
<?php get_footer(); ?>