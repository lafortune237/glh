google.maps.event.addDomListener(window, 'load', initialize);
address_station = null;

function updateAddress() {
    var  info_address = $("#info_address");

    if(info_address){

        info_address.html('Adresse saisie: '+ '<b>' +address_station + '</b>')
    }
}

function setError() {

    var  error_address = $("#error_address");

    if(error_address.hasClass('hide')){

        error_address.removeClass("hide");

    }
}

function removeError() {
    var  error_address = $("#error_address");
    if(error_address.hasClass('hide') === false){

        error_address.addClass("hide");

    }
}


function checkError(value) {

    if(address_station !== null){

        var old_address = address_station.toLowerCase().replace(/\s/g, '');

        value = value.toLowerCase().replace(/\s/g, '');

        if(old_address !== value){

            setError()
        }else {

            removeError()
        }

    }

}


function initialize() {
    $('form').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });
    const locationInputs = document.getElementsByClassName("map-input");

    const autocompletes = [];
    const geocoder = new google.maps.Geocoder;
    for (let i = 0; i < locationInputs.length; i++) {

        const input = locationInputs[i];
        const fieldKey = input.id.replace("-input", "");
        const isEdit = document.getElementById(fieldKey + "-latitude").value != '' && document.getElementById(fieldKey + "-longitude").value != '';

        // const latitude = parseFloat(document.getElementById(fieldKey + "-latitude").value) || 48.862725;
        // const longitude = parseFloat(document.getElementById(fieldKey + "-longitude").value) || 2.287592;
        const latitude = parseFloat(document.getElementById(fieldKey + "-latitude").value);
        const longitude = parseFloat(document.getElementById(fieldKey + "-longitude").value);

        $("#error_address").addClass("hide");

        $('#address-input').blur(function(){
            alert('bonjour');

            setTimeout(function(){

                var long = $("#address-longitude"), lat = $("#address-latitude");
                if($(this).val().length > 0 && (lat.val().length == 0 || long.val().length == 0)){
                    setError()
                }

                if($(this).val().length == 0 && lat.val().length > 0 && long.val().length > 0){

                    setError()
                }
            }, 3000);

        });


        $('#address-input').change(function(){


            var long = $("#address-longitude"), lat = $("#address-latitude");

            if($(this).val().length > 0 && lat.val().length > 0 && long.val().length > 0){
                checkError($(this).val());
                updateAddress();
            }

        });


        const map = new google.maps.Map(document.getElementById(fieldKey + '-map'), {
            center: {lat: latitude, lng: longitude},
            zoom: 13
        });

        const marker = new google.maps.Marker({
            map: map,
            position: {lat: latitude, lng: longitude},
        });

        marker.setVisible(isEdit);

        const autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.key = fieldKey;
        autocompletes.push({input: input, map: map, marker: marker, autocomplete: autocomplete});
    }

    for (let i = 0; i < autocompletes.length; i++) {
        const input = autocompletes[i].input;
        const autocomplete = autocompletes[i].autocomplete;
        const map = autocompletes[i].map;
        const marker = autocompletes[i].marker;

        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            marker.setVisible(false);
            const place = autocomplete.getPlace();

            geocoder.geocode({'placeId': place.place_id}, function (results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    const lat = results[0].geometry.location.lat();
                    const lng = results[0].geometry.location.lng();
                    setLocationCoordinates(autocomplete.key, lat, lng);
                }
            });

            if (!place.geometry) {
                window.alert("No details available for input: '" + place.name + "'");
                input.value = "";
                return;
            }

            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);
            }
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);

        });
    }
}
function setLocationCoordinates(key, lat, lng) {
    const latitudeField = document.getElementById(key + "-" + "latitude");
    const longitudeField = document.getElementById(key + "-" + "longitude");
    latitudeField.value = lat;
    longitudeField.value = lng;
    address_station = $('#address-input').val();

    updateAddress();

    if($("#address-map-container").hasClass('hide')){

        $("#address-map-container").removeClass("hide");

    }

    if($("#address-map").hasClass('hide')){

        $("#address-map").removeClass("hide");

    }

    removeError();

}
