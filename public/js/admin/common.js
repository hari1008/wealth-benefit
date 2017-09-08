
/* Read Image */
function readURL(input, id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#' + id).show();
            $('#' + id).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
function showError(error)
{
    switch (error.code)
    {
        case error.PERMISSION_DENIED:
            alert("Please enable your location services.");
            break;
        case error.POSITION_UNAVAILABLE:
            alert("Location information is unavailable.");
            break;
        case error.TIMEOUT:
            alert("The request to get user location timed out.")
            break;
        case error.UNKNOWN_ERROR:
            alert("An unknown error occurred to access your current location");
            break;
    }
}
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            current_lat = position.coords.latitude;
            current_lng = position.coords.longitude;
        }, showError);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function initMap() {
    var current_lat = '25.2048', current_lng = '55.2708';
    var old_lat = $('.location_group #lat').val();
    var old_lng = $('.location_group #lng').val();
    var lat = old_lat ? old_lat : (current_lat ? current_lat : '-33.8688');
    var lng = old_lng ? old_lng : (current_lng ? current_lng : '151.2195');
   
    var edit_address = $('.location_group #location').val();
    var latlng = new google.maps.LatLng(lat, lng);

    $('#modal_lat').val(current_lat);
    $('#modal_lng').val(current_lng);
    var map = new google.maps.Map(document.getElementById('map'), {
        center: latlng,
        zoom: 17,
        displayMarker: true
    });
    var input = (document.getElementById('pac-input'));
    var geocoder = new google.maps.Geocoder();
    if (edit_address) {
        $('#pac-input').val(edit_address);
    } else {
        geocoder.geocode({
            latLng: latlng
        }, function (responses) {
            if (responses && responses.length > 0) {
                var address = responses[0].formatted_address;
                $('#pac-input').val(address);
            }
        });
    }

    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);

    var marker = new google.maps.Marker({
        map: map,
        draggable: true,
        position: latlng
    });

    autocomplete.addListener('place_changed', function () {
        marker.setVisible(false);
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            window.alert("Autocomplete's returned place contains no geometry");
            return;
        }

        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17); // Why 17? Because it looks good.
        }
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);
        $('#modal_lat').val(place.geometry.location.lat());
        $('#modal_lng').val(place.geometry.location.lng());
    });

    // Listen for the dragend event
    google.maps.event.addListener(marker, 'dragend', function () {
        var position = this.position;
        var x = position.lat();
        var y = position.lng();
        $('#modal_lat').val(x);
        $('#modal_lng').val(y);
        map.setCenter(position);
        map.setZoom(17);
        geocoder.geocode({
            latLng: position
        }, function (responses) {
            if (responses && responses.length > 0) {
                var address = responses[0].formatted_address;
                $('#pac-input').val(address);
            }
        });
    });
}

    
/* End Read Image */
$(document).ready(function () {
    
   
    /* Additional Validation Methods */
    jQuery.validator.addMethod("required_image", function(value, element) {
        var upload_image = value;
        var src_image = $('.savedImage').attr('src');
        if(upload_image){
            return true;
        } else if(src_image) {
            return true;
        } else {
            return false;
        }
    }, 'Image is required.');
}); 

