{{-- jquery --}}
<script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>

{{-- javascript code for google maps api autocompleet cities--}}

    {{-- api sleutel: search places --}}
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyDkZ4PP_qS1NDJ9Lcyv7SYf9kLhaIn_DD0&libraries=places&callback=initAutocomplete" type="text/javascript"></script>
    
    <script>

    //hieronder functie voor regio + afstanden
    function initializeNearbySearch() {
    
        var origins = "{!! $regio !!}";
        var afstand = "{!! $afstand !!}";
        var advers = {!! json_encode($Advers->toArray()) !!};
        var length = Object.keys(advers).length;
        //juisteOrigins naar de controller zien te krijgen... ajax? zodat er querys naar de db kunne gaan
        var juisteOrigins = [];
        console.log(juisteOrigins);
        
        if(afstand == ""){
            return;
        } else {
        // hieronder de http call waar alle locaties van alle zoekertjes worden doorgegeven aan google
        for(i = 0; i < length; i++){
            var url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins="
            + origins + "&destinations=" + advers[i].location + "&key=AIzaSyDkZ4PP_qS1NDJ9Lcyv7SYf9kLhaIn_DD0";
            var xmlhttp = new XMLHttpRequest();
        
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            myArr = JSON.parse(this.responseText);
        
        //hieronder code voor het bijhouden(pushen) van de locaties die binnen de gekozen afstand zitten.
        if(afstand == ""){
            return;
        } else if (myArr.rows[0].elements[0].distance.value <= afstand){
            juisteOrigins.push(myArr.destination_addresses[0]);
        }
            }
        };
        xmlhttp.open("GET", url, true);
        xmlhttp.send();
        }
    }
    }

    function initializePlacesSearch() {
        var options = {
            types: ['(cities)'],
            componentRestrictions: {country: ["be", "nl"]}
           };
        var input = document.getElementById('autocomplete');

        var autocomplete = new google.maps.places.Autocomplete(input, options);
    }

    // uitvoeren places search
    google.maps.event.addDomListener(window, 'load', initializePlacesSearch);

    // uitvoeren nearby search?
    google.maps.event.addDomListener(window, 'load', initializeNearbySearch);

 </script>
 