var markers = [];
const lat = -0.127758;
const lng = 51.507351;
const zoomMap = 13;

var locations;

var transitLayer;

var map;
var mapCenter;
var markerCluster;
var markerClusterOptions = new Array();
var markerClusterHeight = 40;
var markerClusterWidth = 40;
var markerClusterMaxZoom = 4;
var markerClusterImagePath;
var is_first = true;
var first_count = 0;

function function_init() {

	//console.log("In Init");

	setMarkerClusterOptions();
	mapCenter = new google.maps.LatLng(0, 0);
	// Creating a new map
	map = new google.maps.Map(document.getElementById("map"), {
        center: mapCenter,
		zoom: zoomMap,
		minZoom: 2.5,
		scrollwheel: !0,
		zoomControlOptions: {
        position: google.maps.ControlPosition.RIGHT_TOP,
      },
		mapTypeId: google.maps.MapTypeId.ROADMAP,//HYBRID,ROADMAP
		//mapTypeId: "roadmap",
		styles: [
			{ featureType: "administrative", elementType: "all", stylers: [{ visibility: "on" }, { saturation: -100 }, { lightness: 20 }] },
			{ featureType: "road", elementType: "all", stylers: [{ visibility: "on" }, { saturation: -100 }, { lightness: 40 }] },
			{ featureType: "water", elementType: "all", stylers: [{ visibility: "on" }, { saturation: -100 }, { lightness: 60 }] },
			{ featureType: "landscape.man_made", elementType: "all", stylers: [{ visibility: "on" }, { saturation: -60 }, { lightness: 10 }] },
			{ featureType: "poi", elementType: "all", stylers: [{ visibility: "on" }] },
			{ featureType: "landscape.natural", elementType: "all", stylers: [{ visibility: "on" }, { saturation: -60 }, { lightness: 60 }] },
		],
    });

	transitLayer = new google.maps.TransitLayer().setMap(map);
	//transitLayer.setMap(map);

	google.maps.event.addListener( map, 'idle', function() {
		resetSidebarPropertyOnZoomBoundChange();
	});

}

function function_load_data( data ){

	/*** Remove Old Markers ***/
	if( markers.length > 0 ){
		for (let i = 0; i < markers.length; i++) {
			markers[i].setContent(null);
			markers[i].setMap(null);
		}
		markers = [];
		markerCluster.setMap(null);
	}
	
	/*** Add New Markers ***/
	data.forEach(function(item,i){
		if (null != item.latitude || "" != item.latitude) {
			var l = item;
			var n = getAllIndexes(data, '"longitude":"' + item.longitude + '","latitude":"' + item.latitude + '"');
			if( i === n[0] ){

				var marker = new RichMarker({
					position: new google.maps.LatLng(item.latitude, item.longitude),
					map: map,
					draggable: !1,
					content: '<div><div class="marker" data-id="'+i+'" data-multi="'+ JSON.stringify(n) +'"><div class="title">'+item.title+'</div><div class="marker-wrapper"><div class="pin"><div class="image" style="background-image: url('+item.thumbnailImageWithExt+');"></div></div></div></div></div>',
					flat: !0,
					onClick: function(marker) {
                        alert("Clicked");
                    }
				});
				markers.push(marker);
			}
		}
	});
	//alert(data[0].longitude);
	if(data[0] != undefined){
		map.setCenter( new google.maps.LatLng(data[0].latitude,data[0].longitude));
	}
	
	markerCluster = new MarkerClusterer(map, markers, {minimumClusterSize: 2, imagePath: markerClusterImagePath });
	markerCluster.setIgnoreHidden(true);
	
	google.maps.event.addListener(markerCluster, 'clusterclick', function(cluster) {
		setTimeout(() => {
			resetSidebarPropertyOnZoomBoundChange();
		}, 1000);
	});
	
}

function getAllIndexes (e, t) {
	var a = [];
	return (
		jQuery.each(e, function (ele, r) {
			-1 !== JSON.stringify(r).indexOf(t) && a.push(ele);
		}),
		a
	);
}

function resetSidebarPropertyOnZoomBoundChange(){
	var mp_markers = [];
	var zoom_locations = [];
	for(var i=0; i<markers.length; i++) { 
		if ( markers[i].getMap() != null || is_first ) {
			if( map.getBounds().contains(markers[i].getPosition()) ) {
				mp_markers.push(markers[i]);

				var lat1 = markers[i].getPosition().lat();
				var lan1 = markers[i].getPosition().lng();
				
				for( var k = 0; k< locations.length; k++ ) {

					if(( rd_map(locations[k].latitude) == rd_map(lat1) && rd_map(locations[k].longitude) == rd_map(lan1) )) {
							var tmp_location = locations[k];
							tmp_location['data_id'] = k;
							zoom_locations.push(tmp_location);
					}
				}
			}
		}
	}
	first_count += 1;
	is_first = first_count == 2 ? false : true;
	arrangelocation_rightsidebar_filter(zoom_locations);
}

function arrangelocation_rightsidebar_filter(locations_filter){
	if( locations_filter.length > 0 ){
		var result_html = "";
		var s=1;
		
		for( var i=0; i<locations_filter.length; i++ ) {
			result_html += '<div class="col-sm-6 col-xs-12 map-list" data-id="'+locations_filter[i].data_id+'">';
				result_html += '<div class="savedproperties-col">';
					result_html += '<div class="properties-image">';
					if(locations_filter[i].available == 1 && locations_filter[i].status == "Under offer - Available")
					{
						result_html += '<a href="'+locations_filter[i].property_url+'" class="under_order">Under Offer</a>';
					}else if(locations_filter[i].status == "Arranging Tenancy - Unavailable")
					{
						result_html += '<a href="'+locations_filter[i].property_url+'" class="under_order">Under Offer</a>';						
					}
					if(locations_filter[i].available == 0 && (locations_filter[i].status == "Completed" || locations_filter[i].status == "Exchanged" || locations_filter[i].status == "Sold"))
					{
						result_html += '<a href="'+locations_filter[i].property_url+'" class="sold">Sold</a>';
						
					}	
						result_html += '<div class="closely_slider">';
							for (var m = 0; m < locations_filter[i].ImageSlides.length; m++) {
							result_html += '<div class="">';
								result_html += '<div class="savedproperties-col '+locations_filter[i].faved_cls+'">';
									result_html +='<a href="javascript:void(0);" class="heart '+locations_filter[i].saved_cls+'" date-attr="'+locations_filter[i].pid+'" data-id="'+locations_filter[i].user_id+'" ><i class="fa fa-heart-o" aria-hidden="true"></i></a>';									
									result_html += '<div class="properties-image">';
										result_html += '<a href="'+locations_filter[i].property_url+'"><img src="'+locations_filter[i].ImageSlides[m]+'" alt=""></a>';
									result_html += '</div>';
								result_html += '</div>';
							result_html += '</div>';
							}
						result_html += '</div>';
					result_html += '</div>';							
					result_html += '<div class="properties-content">';
						result_html += '<div class="address">';
							result_html += '<p><a href="'+locations_filter[i].property_url+'">'+locations_filter[i].title+'</a></p>';
						result_html += '</div>';
						result_html += '<div class="price">';
							result_html += '<a class="status" href="'+locations_filter[i].property_url+'">'+locations_filter[i].tenure+'</a>';
							result_html += '<a class="p-price" href="'+locations_filter[i].property_url+'">'+locations_filter[i].property_price+'</a>';
						result_html += '</div>';
					result_html += '</div>';
					
				result_html += '</div>';
			result_html += '</div>';
			if(s%6 == 0)
			{
			  if(s == 6 || s== 18 || s == 30 || s == 42 || s == 54)
			  {
			  	var static_data = locations_filter[i].static_block_one;
			  }else{
			  	var static_data = locations_filter[i].static_block_two;
			  }
			  result_html += '</div>';
				result_html += '</div>';
				result_html += '<div class="row">';
					result_html += '<div class="col-sm-12 col-xs-12">';
						result_html += '<div class="middle-text-block">';
							result_html += static_data;
						result_html += '</div>';
					result_html += '</div>';
				result_html += '</div>';
			}
			s++;
		}

		jQuery('.properties-row.map-record').fadeIn("slow").html(result_html);
		jQuery('.loaddata').fadeOut("slow");
		
	}else{
		jQuery('.properties-row.map-record').fadeIn("slow").html('<div class="map-note"><p>Please zoom in or click on one of the areas to view the properties.</p></div>');
	}

	slidercal();
	var map_height = jQuery("#map").outerHeight();
	jQuery(".properties-row.map-record").css("height",map_height + "px");
}

function slidercal()
{
	
		  		jQuery('.closely_slider').slick({
			          dots: false,
			          infinite: true,
			          arrows: true,
			          centerMode: true,        
			          centerPadding: '0px',
			          speed: 300,
			          slidesToShow: 1,
			          slidesToScroll: 1,
			          responsive: [            
			              {
			                breakpoint:767,
			                settings: {
			                 dots: true,
			                }
			              }
			            ],                
			      });
		  		jQuery('.properties-content').matchHeight({
			        property: 'height'
			      });
		  		
}
function rd_map(num) {
    return +(Math.round(num + "e+7")  + "e-7");
  }

function setMarkerClusterOptions(){
	markerClusterImagePath = ast_var.template_directory_uri+'/assets/images/m';
	
}

function myClick(id){
	google.maps.event.trigger(markers[id], 'click');
}
jQuery(function(){

	function_init();
	

	var search_url = window.location.href;
	cur_user_id
	var cur_conveter    = jQuery("input[type='hidden'][name='current_currency_price']").val();
	var cur_user_id    = jQuery("input[type='hidden'][name='cur_user_id']").val();
	var datas = 'search_url='+search_url+'&cur_user_id='+cur_user_id+'&cur_conveter='+cur_conveter+'&action=fn_Get_All_Properties'+'&map_search_nonce='+ast_var.map_search_nonce;

	jQuery.ajax({
	    type    : 'post',
		url     : ast_var.admin_ajax,
		data    : datas,
		dataType  : 'json',
		success   : function( response ) {

			var data = response.res_data;
			locations = data;
			function_load_data(data);
			jQuery("body")
			.off("mouseenter", ".map-record .map-list")
			.on("mouseenter", ".map-record .map-list", function (e) { 
				var t = jQuery(this).attr("data-id");
				0 === jQuery(".map .marker[data-id=" + t + "]").addClass("hover-state").length &&
					jQuery.each(jQuery(".map .marker"), function (e, a) { 
						var r = JSON.parse(jQuery(a).attr("data-multi")) || [];
						0 !==
							jQuery.grep(r, function (e) {
								return e == t;
							}).length && jQuery(this).addClass("hover-state");
					});
			});
			jQuery("body")
			.off("mouseleave", ".map-record .map-list")
			.on("mouseleave", ".map-record .map-list", function (e) {
				jQuery.each(jQuery(".map .marker"), function (e, t) {
					jQuery(this).removeClass("hover-state");
				});
			});
			jQuery("body")
			.off("click", ".map .marker")
			.on("click", ".map .marker", function (e) {

				var item_id = jQuery(this).data("id");

				var container = jQuery(".ms-listing");
				var active_item = jQuery('.map-list[data-id="' + item_id + '"]');
                if (active_item.length > 0) {

                	var active_item_class = jQuery(active_item).attr("class").split(' ')[0];
                    var parent_container = jQuery(active_item).closest(container);

                	jQuery('.' + active_item_class, jQuery(parent_container)).removeClass('active_property');
                	// active_item.addClass('active_property');
                    var position = active_item.offset().top - container.offset().top + container.scrollTop() - 30;
                    container.animate({
                        scrollTop: position
                    }, 4000);
                }
                var item_id_array = jQuery(this).data("multi");
				for(var i=0; i<item_id_array.length; i++) {
					jQuery('.map-list[data-id="' + item_id_array[i] + '"]',).addClass('active_property');	
				}
			});
		}
	});
	return false;
	
});