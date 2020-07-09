<form method="post" action="{{ route('location.store') }}" name="create_location_form" id="create_location_form" enctype="multipart/form-data">
 <div id="create_location_form_status"></div>
    <div class="row">

                    <div class="col-12">
                        <div class="card m-b-30" style="margin-bottom: 0">
                            <div class="card-body">
                                <input name="_token" type="hidden" value="{{ csrf_token() }}">


                                 <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Name</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" required="" type="text" value="{{ isset($location)?$location->name:'' }}" id="name" name="name" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Latitude</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" required="" type="text" value="{{ isset($location)?$location->latitude:'' }}" id="latitude" name="latitude" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-date-input" class="col-sm-3 col-form-label">Longitude</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" required="" type="text" value="{{ isset($location)?$location->longitude:'' }}" id="longitude" name="longitude" >
                                    </div>
                                </div>

                                <div class="form-group row" style="display:none">
                                        <div id="buttonbar" class="mine">
                                                <button id="btnlabels">hide/show labels</button>
                                                <button id="btnaddmarker">add marker</button>
                                                <button id="btnoffset">offset -100px</button>
                                                <input id="nptsearch" type="text" placeholder="autocomplete test (BRazil)" />
                                            </div>

                                            <div id="map_go" class="mine"></div>
                                </div>

                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>
 <input type="hidden" name="locationId" value="{{ isset($location)?$location->id:'' }}" />
 <input type="submit" id="formSubmitBtn" style="display: none;" />
</form>
<script1 src="http://maps.googleapis.com/maps/api/js?libraries=places&sensor=false&language=pt-BR&.js&key=<?php echo env('GOOGLE_API_KEY') ?>">
</script1>
<script>

$(document).ready(function() {

    setTimeout(function(){
        return;
    directionsService = new google.maps.DirectionsService();
directionsDisplay = new google.maps.DirectionsRenderer();

var UK = new google.maps.LatLng(53.409532, -2.010498);
var IT = new google.maps.LatLng(42.745334, 12.738430);

var noStreetNames = [{
    featureType: "road",
    elementType: "labels",
    stylers: [{
        visibility: "off"}]}];

hideLabels = new google.maps.StyledMapType(noStreetNames, {
    name: "hideLabels"
});


var myOptions = {
    zoom: 1,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    center: UK
}

var showPosition = function(position) {
    var userLatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

    var marker = new google.maps.Marker({
        position: userLatLng,
        title: 'Your Location',
        draggable: true,
        map: map
    });

    var infowindow = new google.maps.InfoWindow({
        content: '<div id="infodiv" style="width: 300px">300px wide infowindow!  if the mouse is not here, will close after 3 seconds</div>'
    });

    google.maps.event.addListener(marker, 'dragend', function() {
        infowindow.open(map, marker)
        map.setCenter(marker.getPosition())
    });

    google.maps.event.addListener(marker, 'mouseover', function() {
        infowindow.open(map, marker)
    });

    google.maps.event.addListener(marker, 'mouseout', function() {
        t = setTimeout(function() {
            infowindow.close()
        }, 3000);
    });

    google.maps.event.addListener(infowindow, 'domready', function() {
        $('#infodiv').on('mouseenter', function() {
            clearTimeout(t);
        }).on('mouseleave', function() {
            t = setTimeout(function() {
                infowindow.close()
            }, 1000);
        })
    });

    var input = document.getElementById('nptsearch');
    var autocomplete = new google.maps.places.Autocomplete(input);

    autocomplete.bindTo('bounds', map);

    google.maps.event.addListener(autocomplete, 'place_changed', function() {
        infowindow.close();
        var place = autocomplete.getPlace();
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(7);
        }

        var image = new google.maps.MarkerImage(
        place.icon, new google.maps.Size(71, 71), new google.maps.Point(0, 0), new google.maps.Point(17, 34), new google.maps.Size(35, 35));
        marker.setIcon(image);
        marker.setPosition(place.geometry.location);

        infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
        infowindow.open(map, marker);
    });

    map.setCenter(marker.getPosition());
}

navigator.geolocation.getCurrentPosition(showPosition);

map = new google.maps.Map(document.getElementById("map_go"), myOptions);
directionsDisplay.setMap(map);

map.mapTypes.set('hide_street_names', hideLabels);

function offsetCenter(latlng, offsetx, offsety) {
    var scale = Math.pow(2, map.getZoom());
    var nw = new google.maps.LatLng(
    map.getBounds().getNorthEast().lat(), map.getBounds().getSouthWest().lng());

    var worldCoordinateCenter = map.getProjection().fromLatLngToPoint(latlng);
    var pixelOffset = new google.maps.Point((offsetx / scale) || 0, (offsety / scale) || 0)

    var worldCoordinateNewCenter = new google.maps.Point(
    worldCoordinateCenter.x - pixelOffset.x, worldCoordinateCenter.y + pixelOffset.y);

    var newCenter = map.getProjection().fromPointToLatLng(worldCoordinateNewCenter);

    map.setCenter(newCenter);
}

function addmarker(latilongi) {
    var marker = new google.maps.Marker({
        position: latilongi,
        title: 'new marker',
        draggable: true,
        map: map
    });

    var infowindow = new google.maps.InfoWindow({
        content: '<div id="infodiv2">infowindow!</div>'
    });
    //map.setZoom(15);
    map.setCenter(marker.getPosition())
    //infowindow.open(map, marker)
}

$(window).on('resize', function() {
    var currCenter = map.getCenter();
    google.maps.event.trigger(map, 'resize');
    map.setCenter(currCenter);
})

$('#btnlabels').toggle(function() {
    map.setZoom(15);
    map.setMapTypeId('hide_street_names')
}, function() {
    map.setMapTypeId(google.maps.MapTypeId.ROADMAP)
})

$('#btnoffset').on('click', function() {
    offsetCenter(map.getCenter(), 0, -100)
})

$('#btnaddmarker').on('click', function() {
    addmarker(IT)
})
    },3000);
});
    </script>

