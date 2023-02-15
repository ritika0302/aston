var locrating_schools_frame_id = 'propertyhive_locrating_schools_frame';
var locrating_schools_frame_src = '';
var locrating_amenities_frame_id = 'propertyhive_locrating_amenities_frame';
var locrating_amenities_frame_src = '';
var locrating_broadband_checker_frame_id = 'propertyhive_locrating_broadband_checker_frame';
var locrating_broadband_checker_frame_src = '';
var locrating_all_in_one_frame_id = 'propertyhive_locrating_all_in_one_frame';
var locrating_all_in_one_frame_src = '';

jQuery( function($){

    $('li.action-locrating-schools a').click(function() {
       	try{
       	  	var lat = $('#'+locrating_schools_frame_id).data('lat');
       	  	var lng = $('#'+locrating_schools_frame_id).data('lng');

       	  	jQuery('#' + locrating_schools_frame_id).width(jQuery(window).width() - 100).height(jQuery(window).height() - 200);

            if ( locrating_schools_frame_src != '' )
            {
                jQuery('#' + locrating_schools_frame_id).attr('src', locrating_schools_frame_src);
            }
            else
            {
                setLocratingIFrameProperties({'id': locrating_schools_frame_id, 'lat': lat, 'lng' : lng});
            }
       	} catch (err) { 
       	   	console.log(err); 
       	};

    });

    $('li.action-locrating-amenities a').click(function() {
        try{
            var lat = $('#'+locrating_amenities_frame_id).data('lat');
            var lng = $('#'+locrating_amenities_frame_id).data('lng');

            jQuery('#' + locrating_amenities_frame_id).width(jQuery(window).width() - 100).height(jQuery(window).height() - 200);

            if ( locrating_amenities_frame_src != '' )
            {
                jQuery('#' + locrating_amenities_frame_id).attr('src', locrating_amenities_frame_src);
            }
            else
            {
                setLocratingIFrameProperties({'id': locrating_amenities_frame_id, 'lat': lat, 'lng' : lng, 'type':'localinfo'});
            }
        } catch (err) { 
            console.log(err); 
        };

    });

    $('li.action-locrating-broadband-checker a').click(function() {
        try{
            var lat = $('#'+locrating_broadband_checker_frame_id).data('lat');
            var lng = $('#'+locrating_broadband_checker_frame_id).data('lng');

            jQuery('#' + locrating_broadband_checker_frame_id).width(jQuery(window).width() - 100).height(jQuery(window).height() - 200);

            if ( locrating_broadband_checker_frame_src != '' )
            {
                jQuery('#' + locrating_broadband_checker_frame_id).attr('src', locrating_broadband_checker_frame_src);
            }
            else
            {
                setLocratingIFrameProperties({'id': locrating_broadband_checker_frame_id, 'lat': lat, 'lng' : lng, 'type' : 'broadband', showmap : 'true'});
            }
        } catch (err) { 
            console.log(err); 
        };

    });

    $('li.action-locrating-all-in-one a').click(function() {
        try{
            var lat = $('#'+locrating_all_in_one_frame_id).data('lat');
            var lng = $('#'+locrating_all_in_one_frame_id).data('lng');

            jQuery('#' + locrating_all_in_one_frame_id).width(jQuery(window).width() - 100).height(jQuery(window).height() - 200);

            if ( locrating_all_in_one_frame_src != '' )
            {
                jQuery('#' + locrating_all_in_one_frame_id).attr('src', locrating_all_in_one_frame_src);
            }
            else
            {
                setLocratingIFrameProperties({'id': locrating_all_in_one_frame_id, 'lat': lat, 'lng' : lng, 'type':'all'});
            }
        } catch (err) { 
            console.log(err); 
        };

    });

    $(document).on('beforeClose.fb', function( e, instance, slide ) 
    {
        if ( typeof $('#'+locrating_schools_frame_id).attr('src') !== typeof undefined && $('#'+locrating_schools_frame_id).attr('src') !== false )
        {
            locrating_schools_frame_src = $('#'+locrating_schools_frame_id).attr('src');
        }
        $('#'+locrating_schools_frame_id).removeAttr('src');

        if ( typeof $('#'+locrating_amenities_frame_id).attr('src') !== typeof undefined && $('#'+locrating_amenities_frame_id).attr('src') !== false )
        {
            locrating_amenities_frame_src = $('#'+locrating_amenities_frame_id).attr('src');
        }
        $('#'+locrating_amenities_frame_id).removeAttr('src');

        if ( typeof $('#'+locrating_broadband_checker_frame_id).attr('src') !== typeof undefined && $('#'+locrating_broadband_checker_frame_id).attr('src') !== false )
        {
            locrating_broadband_checker_frame_src = $('#'+locrating_broadband_checker_frame_id).attr('src');
        }
        $('#'+locrating_broadband_checker_frame_id).removeAttr('src');

        if ( typeof $('#'+locrating_all_in_one_frame_id).attr('src') !== typeof undefined && $('#'+locrating_all_in_one_frame_id).attr('src') !== false )
        {
            locrating_all_in_one_frame_src = $('#'+locrating_all_in_one_frame_id).attr('src');
        }
        $('#'+locrating_all_in_one_frame_id).removeAttr('src');
    });
    
});

jQuery(window).on('load', function()
{
    if (  jQuery('.locrating-schools-shortcode #'+locrating_schools_frame_id).length > 0 )
    {
        var lat = jQuery('#'+locrating_schools_frame_id).data('lat');
        var lng = jQuery('#'+locrating_schools_frame_id).data('lng');

        setLocratingIFrameProperties({'id': locrating_schools_frame_id, 'lat': lat, 'lng' : lng});
    }

    if ( jQuery('.locrating-amenities-shortcode #'+locrating_amenities_frame_id).length > 0 )
    {
        var lat = jQuery('#'+locrating_amenities_frame_id).data('lat');
        var lng = jQuery('#'+locrating_amenities_frame_id).data('lng');

        setLocratingIFrameProperties({'id': locrating_amenities_frame_id, 'lat': lat, 'lng' : lng, 'type':'localinfo'});
    }

    if ( jQuery('.locrating-broadband-checker-shortcode #'+locrating_broadband_checker_frame_id).length > 0 )
    {
        var lat = jQuery('#'+locrating_broadband_checker_frame_id).data('lat');
        var lng = jQuery('#'+locrating_broadband_checker_frame_id).data('lng');

        setLocratingIFrameProperties({'id': locrating_broadband_checker_frame_id, 'lat': lat, 'lng' : lng, 'type' : 'broadband', showmap : 'true'});
    }

    if ( jQuery('.locrating-all-in-one-shortcode #'+locrating_all_in_one_frame_id).length > 0 )
    {
        var lat = jQuery('#'+locrating_all_in_one_frame_id).data('lat');
        var lng = jQuery('#'+locrating_all_in_one_frame_id).data('lng');

        setLocratingIFrameProperties({'id': locrating_all_in_one_frame_id, 'lat': lat, 'lng' : lng, 'type':'all'});
    }
});