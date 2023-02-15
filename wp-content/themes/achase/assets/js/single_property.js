jQuery(document).ready(function(){
	


	jQuery(".close_lightbox_btn").click(function(){
	  jQuery("html").removeClass("lightbox_show lightbox_left");
	});


	jQuery(".grid_list").click(function(){			
	  jQuery("html").toggleClass("lightbox_left");
	});

	jQuery(".slider_container").click(function(){
	  jQuery("html").removeClass("lightbox_left");
	});

	jQuery(".play_btn").click(function(){
	  jQuery(".video_front").addClass("remove_frontimg");
	});

	jQuery(".play_btn").click(function(event){
	    jQuery('video').trigger('play');
	});


	var $status = jQuery('.slidercounter');
	var $slickElement = jQuery('.lightbox_slider');

	$slickElement.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
	  //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
	  var i = (currentSlide ? currentSlide : 0) + 1;
	  
		 $status.html("<span class='first'>" + i+"</span> <b>/</b> <span class='last'>"+slick.slideCount+ "</span>" );

	  // $('#counter').html("<strong class='first'>" + item+"</strong> <b>/</b> <strong class='last'>"+items+ "</strong>" );

	});

	var gallary_slider = jQuery('.lightbox_slider')

		gallary_slider.slick({
	    dots: false,
	    infinite: true,
	    arrows: true,
	    centerMode: true,        
	    centerPadding: '0px',
	    speed: 300,
	    slidesToShow: 1,
	    slidesToScroll: 1,	        
	})
		jQuery(".video-block ul li").click(function(){
			var active_index = jQuery(this).index();					
			gallary_slider.slick('slickGoTo', active_index);
			jQuery("html").removeClass("lightbox_left");
		});

		jQuery(".photos-block ul li").click(function(){
			var active_index = jQuery(this).index();
			active_index = active_index + jQuery(".video-block ul li").length;
			gallary_slider.slick('slickGoTo', active_index);
			jQuery("html").removeClass("lightbox_left");
			
		});
		jQuery(".sliderBtn").click(function(){	
			if (jQuery(this).parent("li").hasClass("videoBtn"))
			{
				jQuery("html").toggleClass("lightbox_show");
				gallary_slider.slick('slickGoTo', "0");
			}
			else
			{
				jQuery("html").toggleClass("lightbox_show");
				var img_index = jQuery(".video-block ul li").length;
				gallary_slider.slick('slickGoTo', img_index);
			}
		});
		jQuery(".video .video_btn").click(function(){	
				jQuery("html").toggleClass("lightbox_show");
				gallary_slider.slick('slickGoTo', "0");
		});
		jQuery(".gallary .rightImg-details, .video_gallary .rightImg-details").click(function(){	
				var img_indexGallary = jQuery(this).prev("img").attr("id");
				img_indexGallary = img_indexGallary - 1;
				jQuery("html").toggleClass("lightbox_show");
				gallary_slider.slick('slickGoTo', img_indexGallary);
		});
		
		
});

 