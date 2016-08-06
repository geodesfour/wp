(function($) {

var options = {
    'zoom' : 16,
    'center_lat' : '0',
    'center_lng' : '0'
};

// make it global to close it from everywhere
var infowindow = new google.maps.InfoWindow({content     : ''});

/*
*  render_map
*
*  This function will render a Google Map onto the selected jQuery element
*
*  @type    function
*  @date    8/11/2013
*  @since   4.3.0
*
*  @param   $el (jQuery element)
*  @return  n/a
*/
function render_map( $el ) {

    // var
    var $markers = $el.find('.marker');

    // vars
    var args = {
        zoom                        : options.zoom,
        center                      : new google.maps.LatLng(options.center_lat, options.center_lng),
        mapTypeId                   : google.maps.MapTypeId.ROADMAP,
        scrollwheel                 : false,

        mapTypeControl              : true,
        // mapTypeControlOptions: {
        //     style                   : google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
        //     position                : google.maps.ControlPosition.TOP_LEFT
        // },
        zoomControl                 : true,
        // zoomControlOptions: {
        //     style                   : google.maps.ZoomControlStyle.SMALL,
        //     position                : google.maps.ControlPosition.LEFT_CENTER
        // }
    };

    // create map               
    var map = new google.maps.Map( $el[0], args);

    // add a markers reference
    map.markers = [];
    map.kml = [];

    // add markers
    $markers.each(function(){

        add_marker( $(this), map );

    });

    // @TODO a better way would be to create a plugin with an instance
    $('#view a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        google.maps.event.trigger(map, "resize");
        center_map( map );
    });

    // center map
    center_map( map );
}



/*
*  add_marker
*
*  This function will add a marker to the selected Google Map
*
*  @type    function
*  @date    8/11/2013
*  @since   4.3.0
*
*  @param   $marker (jQuery element)
*  @param   map (Google Map object)
*  @return  n/a
*/
function add_marker( $marker, map ) {

    // var
    var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );

    if($marker.attr('data-icon-marker')){
         var $listImage = $marker.attr('data-icon-marker');
    }else {
        $listImage = '';
    }
   
    
    if($marker.attr('data-kml')){
      var layer = new google.maps.KmlLayer({
        url : $marker.attr('data-kml'),
        clickable: false,
        preserveViewport: true,
      });
      layer.setMap(map);
    }
    else{

    
    // create marker
    var marker = new google.maps.Marker({
        position    : latlng,
        map         : map,
        icon        : $listImage
    });

    // add to array
    map.markers.push( marker );

    // if marker contains HTML, add it to an infoWindow
    if( $marker.html() )
    {

        google.maps.event.addListener(marker, 'click', function() {
            //swap content of that singular infowindow
            infowindow.setContent($marker.html());
            infowindow.open(map, marker);
            map.setCenter( latlng );
        });

        // close info window when map is clicked
        google.maps.event.addListener(map, 'click', function(event) {
            if (infowindow) {
                infowindow.close(); }
        });

    }
    }

}

/*
*  center_map
*
*  This function will center the map, showing all markers attached to this map
*
*  @type    function
*  @date    8/11/2013
*  @since   4.3.0
*
*  @param   map (Google Map object)
*  @return  n/a
*/
function center_map( map ) {

    // vars
    var bounds = new google.maps.LatLngBounds();

    // loop through all markers and create bounds
    $.each( map.markers, function( i, marker ){

        var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );

        bounds.extend( latlng );

    });

    // only 1 marker?
    if( map.markers.length == 1 )
    {
        // set center of map
        map.setCenter( bounds.getCenter() );
        map.setZoom( options.zoom );
    }
    else
    {
        // fit to bounds
        map.fitBounds( bounds );
    }

}

/*
*  document ready
*
*  This function will render each map when the document is ready (page has loaded)
*
*  @type    function
*  @date    8/11/2013
*  @since   5.0.0
*
*  @param   n/a
*  @return  n/a
*/
$(document).ready(function(){

    $('.google-map').each(function(){

        render_map( $(this) );

    });

});

})(jQuery);