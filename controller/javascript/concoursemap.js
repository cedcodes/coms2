let markers = [];

function initMap() {
    // The location
    var company_loc = {

        lat: 14.5555,
        lng: 121.0224
    };

    var map = new google.maps.Map(
        document.getElementById('map'), {
        zoom: 10,
        center: company_loc,
        scrollwheel: false,
        zoomControl: true,
        mapTypeControl: false,
        scaleControl: false,
        streetViewControl: false,
        rotateControl: false,
        fullscreenControl: false

    });
    const geocoder = new google.maps.Geocoder();
    /////////////////////////////////////////////////////////
    // Create the search box and link it to the UI element.
    const input = document.getElementById("searchloc");
    const searchBox = new google.maps.places.SearchBox(input);
    // Bias the SearchBox results towards current map's viewport.
    map.addListener("bounds_changed", () => {
        searchBox.setBounds(map.getBounds());
    });
    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener("places_changed", () => {
        const places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }
        const bounds = new google.maps.LatLngBounds();
        places.forEach((place) => {
            if (!place.geometry) {
                console.log("Returned place contains no geometry");
                return;
            }
            if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });
        map.fitBounds(bounds);
    });
    /////////////////////////////////////////////////////////
    setMarkers(map);
    // SideBarHighlight();

    if (document.getElementById("usertype").innerText == "Owner") {
        map.addListener("click", function (mapsMouseEvent) {
            var marker = new google.maps.Marker({
                position: mapsMouseEvent.latLng,
                //icon: icon,
                map: map
            });
            markers.push(marker);
            var clickloc = mapsMouseEvent.latLng.toString();
            clickloc = clickloc.replace("(", "");
            clickloc = clickloc.replace(")", "");
            clickloc = clickloc.split(", ");
            geocodeLatLng(geocoder, clickloc[0], clickloc[1]);
        });
    }

    
}

function ReloadMarker() {

    var company_loc = {
        lat: 14.5555,
        lng: 121.0224
    };

    var map = new google.maps.Map(
        document.getElementById('map'), {
        zoom: 10,
        center: company_loc,
        scrollwheel: false,
        zoomControl: true,
        mapTypeControl: false,
        scaleControl: false,
        streetViewControl: false,
        rotateControl: false,
        fullscreenControl: false

    });

    setMarkers(map);
}

function geocodeLatLng(geocoder, lat, long) {
    const latlng = {
        lat: parseFloat(lat),
        lng: parseFloat(long),
    };
    geocoder.geocode({ location: latlng }, (results, status) => {
        if (status === "OK") {
            if (results[0]) {
                document.getElementById("txtlat").innerHTML = parseFloat(lat);
                document.getElementById("txtlongt").innerHTML = parseFloat(long);
                document.getElementById("conAddress").value = results[0].formatted_address;
                $("#NewConcourseModal").modal({ backdrop: "static" });
            } else {
                window.alert("No results found");
            }
        } else {
            window.alert("Geocoder failed due to: " + status);
        }
    });
}

function setMapOnAll(map) {
    for (let i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
    }
}

function RemoveMark() {
    setMapOnAll(null);
}

function setMarkers(map) {
    $.ajax({
        url: "../controller/php/concoursecontroller.php",
        method: "POST",
        data: {
            "concourse": "retrieve_concourse"
            // "conLat": conLat,
        },
        success: function (data) {
            var response = data[0];
            var response_data = response.request_data;
            var response_status = response.request_status;

            if (response_data) {
                response_data.forEach(function (resp) {

                    var AreaInfo =
                        "Location Address: " + resp.con_address +
                        "\n" +
                        "Concourse Name: " + resp.con_name +
                        "\n" +
                        "Number of Spaces: " + resp.avl_space;

                    var iconBase = '../uploads/con_image/';
                    var icon = {
                        url: iconBase + resp.con_image, // url
                        scaledSize: new google.maps.Size(80, 80), // scaled size
                    };
                    var marker = new google.maps.Marker({
                        position: { lat: parseFloat(resp.con_lat), lng: parseFloat(resp.con_long) },
                        map: map,
                        icon: icon,
                        title: AreaInfo
                    });

                    marker.addListener("click", () => {
                        // map.setZoom(15);
                        map.setCenter(marker.getPosition());

                        let longLat = String(marker.position);
                        longLat = longLat.split(", ");
                        var latitude = longLat[0];
                        latitude = latitude.replace("(", "");
                        var longitude = longLat[1];
                        longitude = longitude.replace(")", "");

                        GetMarkerDetails(latitude, longitude);
                    });
                });
            }


        },
        error: function (data) {
            console.log(data);

            swal.fire({
                text: "Sorry, looks like there are some errors detected, please try again.",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                confirmButtonClass: "btn font-weight-bold btn-light"
            }).then(function () {
                KTUtil.scrollTop();
            });
        }
    })


}

function GetMarkerDetails(lat, long) {

    $.ajax({
        url: "../controller/php/concoursecontroller.php",
        method: "POST",
        data: {
            "concourse": "read_concourse",
            "latitude": lat,
            "longitude": long
        },
        success: function (data) {
            var response = data[0];
            var response_data = response.request_data;
            var response_status = response.request_status;

            response_status.forEach(function (status_result) {
                if (status_result.status_code == 200) {
                    if (response_data) {
                        response_data.forEach(function (result) {
                            location.href = "viewspaces.php?concourse=" + result.con_id;
                        });
                    }
                }
            });

        },
        error: function (data) {
            console.log(data);

            swal.fire({
                text: "Sorry, looks like there are some errors detected, please try again.",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                confirmButtonClass: "btn font-weight-bold btn-light"
            }).then(function () {
                KTUtil.scrollTop();
            });
        }
    });
}