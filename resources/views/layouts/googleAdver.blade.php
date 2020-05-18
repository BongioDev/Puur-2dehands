
{{-- javascript code for google maps api autocompleet cities--}}

{{-- api sleutels: search places, en nearby search --}}
<script src="https://maps.google.com/maps/api/js?key=AIzaSyDkZ4PP_qS1NDJ9Lcyv7SYf9kLhaIn_DD0&libraries=places&callback=initAutocomplete" type="text/javascript"></script>

<script>

//hieronder functie voor regio + afstanden

    function initializePlacesSearch() {
        var options = {
            types: ['(cities)'],
            componentRestrictions: {country: ["be", "nl"]}
           };
        var input = document.getElementById('autocomplete');

        var autocomplete = new google.maps.places.Autocomplete(input, options);

        // geen idee wat dit doet
        // autocomplete.addListener('place_changed', function() {
        //     var place = autocomplete.getPlace();
        //     $('#latitude').val(place.geometry['location'].lat());
        //     $('#longitude').val(place.geometry['location'].lng());

        //  // --------- show lat and long ---------------
        //     $("#lat_area").removeClass("d-none");
        //     $("#long_area").removeClass("d-none");
        // });
    }

    // uitvoeren places search
    google.maps.event.addDomListener(window, 'load', initializePlacesSearch);

    // // uitvoeren nearby search?
    google.maps.event.addDomListener(window, 'load', initializeNearbySearch);

 </script>