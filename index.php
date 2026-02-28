<!DOCTYPE html>
<html lang="en">
<?php require 'classes/Pin.class.php' ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            padding-top: 0px;
        }
    </style>

</head>

<body>
    <?php
    $id = 1;
    require 'inc/navbar.php';

    ?>
    <span class="clickable-span" onclick="showText()">Klikni za uputstvo :)</span>
    <p id="DescriptionText1" class="hidden-text">Pinove dodaj dvoklikom na željenu lokaciju. Opis možeš dodati dvoklikom na pin. Izmene će biti sačuvane klikom na zeleno dugme.</p>

    <script>
        function showText() {
            var textElement = document.getElementById('DescriptionText1');
            if (textElement.classList.contains('show-text')) {
                textElement.classList.remove('show-text');
                textElement.classList.add('hide-text');
            } else {
                textElement.classList.remove('hide-text');
                textElement.classList.add('show-text');
            }
        }
    </script>
    <div class="container" id="map-container">
        <div id="map"></div>
    </div>


    <div id="pin-form">
        <button id="close-pin-form" class="button-close" onclick="hidePinForm()">⨉</button>
        <form id="edit-pin-form">
            <h3>Edit Pin</h3>
            <input type="hidden" id="pin-id">
            <input type="text" id="pin-name" maxlength="50" placeholder="Enter new pin name...">
            <select name="" id="PinTypes">
                <!-- pin tupes go here -->
            </select>
            <input type="hidden" id="pin-latitude" name="pin-latitude" placeholder="Latitude" readonly>
            <input type="hidden" id="pin-longitude" name="pin-longitude" placeholder="Longitude" readonly>
            <!-- <div class="row"> -->
            <!-- <div class="col-md-4"> -->
            <button type="submit" class="button-save" onclick="savePin(event)">Save</button>
            <!-- </div> -->
            <!-- <div class="col-md-4"> -->
            <button type="button" class="button-delete" onclick="deletePin(0)">Delete</button>
            <!-- </div> -->
            <!-- <div class="col-md-4"> -->
            <button type="button" class="button-bottom" onclick="approvePin()">Approve</button>
            <!-- </div> -->
            <!-- </div> -->
        </form>
    </div>
    <div id="remove-pins">
        <button id="close-pin-form" class="button-close" onclick="hideRemoveForm()">⨉</button>
        <form id="remove-pins-form">
            <h3>Remove ALL Pins?</h3>
            <!-- <input type="hidden" id="pin-id2"> -->
            <input type="password" id="delete-pass" placeholder="Enter password...">
            </select>

            <button type="submit" class="button-bottom" onclick="deletePin(1)">Remove</button>

            <!-- <button type="button" class="button-bottom" onclick="deletePin()">Delete</button> -->

        </form>
    </div>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // var map = L.map('map').setView([44.80186334246842, 20.419771554112074], 14, doubleClickZoom: false); // Belgrade coordinates
        // Initialize the map without specifying a center
        var map = L.map('map', {
            doubleClickZoom: false // Disable double-click zoom
        });

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        // Define fallback coordinates
        var fallbackLat = 44.80186334246842; // Your provided latitude
        var fallbackLon = 20.419771554112074; // Your provided longitude
        var fallbackZoom = 12.5; // Your desired zoom level

        // Check if Geolocation is available
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    var lat = position.coords.latitude;
                    var lon = position.coords.longitude;

                    // Set the map's view to the user's location
                    map.setView([lat, lon], 12.5);

                    // Add a circle to indicate the user's location
                    L.circle([lat, lon], {
                            color: 'blue',
                            fillColor: '#blue',
                            fillOpacity: 0.5,
                            radius: 100 // Radius in meters
                        }).addTo(map)
                        .bindPopup("You are here!")
                        .openPopup();
                },
                function(error) {
                    console.error("Error getting location: " + error.message);
                    alert("Unable to retrieve your location. Showing fallback location.");

                    // Set the map's view to the fallback location
                    map.setView([fallbackLat, fallbackLon], fallbackZoom);

                    // Add a circle at the fallback location
                    L.circle([fallbackLat, fallbackLon], {
                            color: 'red',
                            fillColor: '#f03',
                            fillOpacity: 0.5,
                            radius: 200 // Radius in meters
                        }).addTo(map)
                        .bindPopup("Default Location")
                        .openPopup();
                }
            );
        } else {
            alert("Geolocation is not supported by your browser. Showing fallback location.");

            // Set the map's view to the fallback location
            map.setView([fallbackLat, fallbackLon], fallbackZoom);

            // Add a circle at the fallback location
            L.circle([fallbackLat, fallbackLon], {
                    color: 'red',
                    fillColor: '#f03',
                    fillOpacity: 0.5,
                    radius: 200 // Radius in meters
                }).addTo(map)
                .bindPopup("Default Location")
                .openPopup();
        }

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        var currentMarker = null;
        let allMarkers = [];

        var pinClick = 0;

        function attachPins(pinsData) {
            // Define custom icon
            pinsData.forEach(function(pin) {
                const mysqlDatetime = pin.last;
                const mysqlDate = new Date(mysqlDatetime);
                const currentDate = new Date();
                const timeDiff = currentDate - mysqlDate;

                function msToTime(duration) {
                    let milliseconds = parseInt((duration % 1000) / 100),
                        seconds = Math.floor((duration / 1000) % 60),
                        minutes = Math.floor((duration / (1000 * 60)) % 60),
                        hours = Math.floor((duration / (1000 * 60 * 60)) % 24),
                        days = Math.floor(duration / (1000 * 60 * 60 * 24));
                    let timePassed = '';
                    if (days > 0) {
                        timePassed += `${days} days, `;
                    }
                    if (hours > 0) {
                        timePassed += `${hours} hr, `;
                    }
                    timePassed += `${minutes} min`;
                    return timePassed.trim(); // trim to remove any trailing spaces
                }
                const timePassed = msToTime(timeDiff);
                var customIcon = L.icon({
                    iconUrl: 'pin_images' + pin.PinPath,
                    iconSize: [38, 38],
                    iconAnchor: [19, 38],
                    popupAnchor: [0, -38]
                });
                var marker = L.marker([pin.lat, pin.lng], {
                    id: pin.ID,
                    name: pin.name,
                    pinID: pin.PinType,
                    TimePassed: timePassed,
                    ConfirmCount: pin.ConfirmCount,
                    icon: customIcon
                }).addTo(map);
                marker.bindPopup(pin.name + '<br>Last Update<br>(' + timePassed + ') ago.<br>' + pin.ConfirmCount + " Confirms.");
                marker.on('dblclick', function(e) {
                    currentMarker = e.target;
                    showPinForm(marker, e.latlng);
                });
                var currentPopup = null;
                marker.on('click', function(e) {
                    var element = document.getElementById('pin-form');
                    var isVisible = window.getComputedStyle(element).display == 'block';
                    if (isVisible) {
                        showPinForm(marker, e.latlng);
                    }
                    currentMarker = e.target;
                    if (currentPopup) {
                        currentPopup.close();
                    }
                    currentPopup = e.target.getPopup();
                    currentPopup.openOn(map);
                });
                allMarkers.push(marker);

            });
            console.log(allMarkers);
        }

        function fetchPins(fetchPinID) {
            // Optionally hide the pin form if needed
            // hidePinForm();

            // Safely remove markers
            if (Array.isArray(allMarkers) && allMarkers.length > 0) {
                try {
                    removeAllMarkers();
                } catch (e) {
                    console.error('Error removing markers: ' + e);
                }
            }

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'ajx/get_pins.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 400) {
                    try {
                        var pinsData = JSON.parse(xhr.responseText);
                        attachPins(pinsData);
                    } catch (e) {
                        console.error('Error parsing JSON response: ' + e);
                    }
                } else {
                    console.error('Error fetching pins: ' + xhr.statusText);
                }
            };

            xhr.onerror = function() {
                console.error('Request failed');
            };

            var params = 'pin-id=' + encodeURIComponent(fetchPinID);
            xhr.send(params);
        }


        // AJAX request to fetch pins from database on page load
        document.addEventListener('DOMContentLoaded', function() {
            fetchPins(0);

            var selectBox = document.getElementById('PinTypes');
            $.ajax({
                url: 'ajx/get_pin_data.php', // Replace with your server-side script URL
                type: 'POST',
                success: function(response) {
                    $('#response').html(response); // Display response from server
                    var pinData = JSON.parse(response);
                    pinData.forEach(function(obj) {
                        var optionElement = document.createElement('option');
                        optionElement.value = obj.ID;
                        optionElement.textContent = obj.Name;

                        selectBox.appendChild(optionElement);

                        // Step 1: Get the element with id "container"
                        var container = document.getElementById('li-add');
                        if (!container) {
                            console.error('Container element not found');
                            return;
                        } else {
                            console.log('Container element found');
                        }

                        // Assuming obj is defined in your data, log obj and its properties to inspect them
                        console.log('Object (obj) received: ', obj);
                        console.log('obj.Name: ', obj.Name);
                        console.log('obj.Icon: ', obj.Icon);

                        // Now proceed with creating and appending elements

                        var anchor = document.createElement('a');

                        // Log anchor creation
                        console.log('Creating anchor element');

                        // Step 3: Set properties of the anchor
                        anchor.textContent = obj.Name; // Text for the link
                        anchor.href = '#';
                        anchor.onclick = function() {
                            fetchPins(obj.ID);
                            // Prevent the default action if needed
                            return false; // Stops navigation for '#'
                        };
                        anchor.id = 'myLink'; // Optional: Set an id for the link
                        anchor.className = 'dropdown-item'; // Optional: Add a class for styling

                        // Log anchor properties
                        console.log('Anchor properties set: ', anchor);

                        // Create the image element
                        var img = document.createElement('img');

                        // Log image creation
                        console.log('Creating image element');
                        img.src = 'pin_images' + obj.Icon; // Corrected image URL
                        img.alt = 'A description of the image'; // Alternative text
                        img.width = 20; // Set the width
                        img.height = 20; // Set the height

                        // Log image src
                        console.log('Image source set: ', img.src);

                        // Create a container div for the anchor and image
                        var wrapper = document.createElement('div');
                        wrapper.className = 'inline-item'; // Add a class for styling
                        wrapper.appendChild(anchor);
                        wrapper.appendChild(img);

                        // Log wrapper content
                        console.log('Wrapper created and populated: ', wrapper);

                        // Step 4: Append the wrapper to the container
                        container.appendChild(wrapper);
                        console.log('Wrapper appended to container');

                    });
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status, error);
                }
            });

        });

        function removeHTMLTags(str) {
            return str.replace(/<[^>]*>/g, '');
        }

        function savePin(event) {
            event.preventDefault(); // Prevent default form submission
            lastMarker = null;
            var pinID = document.getElementById('pin-id').value;
            //var pinID;
            var pinName = removeHTMLTags(document.getElementById('pin-name').value);
            var selectedPin = document.getElementById('PinTypes').value;
            var pinLatitude = document.getElementById('pin-latitude').value;
            var pinLongitude = document.getElementById('pin-longitude').value;
            // Validate inputs

            if (pinName.trim() === '' || pinName == "undefined") {
                alert("Please enter a pin name.");
                document.getElementById('pin-name').value = "";
                return;
            }
            // AJAX request to save pin data
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'ajx/save_pin.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 400) {
                    var response = JSON.parse(xhr.responseText);
                    var pinData2 = response[0];
                    //document.getElementById('pin-name').value = pinData2.Name;

                    currentMarker.options.name = pinData2.Name;
                    currentMarker.options.id = pinData2.ID;
                    currentMarker.options.ConfirmCount = pinData2.ApproveCount;

                    allMarkers.push(currentMarker)
                    document.getElementById('pin-id').value = pinData2.ID;
                    // alert(pinData2.Name);
                    // alert(currentMarker.options.ID);

                    var customIcon = L.icon({
                        //ID: pinsData.ID,
                        iconUrl: 'pin_images' + pinData2.Icon,
                        //iconUrl: 'speed_radar.png',
                        iconSize: [38, 38],
                        iconAnchor: [19, 38],
                        popupAnchor: [0, -38]
                    });
                    if (currentMarker && typeof currentMarker.options.TimePassed === 'undefined') {
                        // Initialize TimePassed property if it's undefined
                        currentMarker.options.TimePassed = '0 min';
                    }
                    currentMarker.bindPopup(pinData2.Name + '<br>Last Update<br>(' + currentMarker.options.TimePassed + ') ago.<br>' + currentMarker.options.ConfirmCount + ' Confirms');

                    currentMarker.setIcon(customIcon);
                    hidePinForm();
                } else {
                    // Error: Handle error response
                    console.error('Error saving pin: ' + xhr.statusText);
                }
            };
            xhr.onerror = function() {
                // Request failed
                console.error('Request failed');
            };
            // Prepare data to send
            var params = 'pin-id=' + encodeURIComponent(pinID) +
                '&pin-name=' + encodeURIComponent(pinName) +
                '&selected-pin=' + encodeURIComponent(selectedPin) +
                '&pin-latitude=' + encodeURIComponent(pinLatitude) +
                '&pin-longitude=' + encodeURIComponent(pinLongitude);
            // Send request
            xhr.send(params);
        }
        map.on('click', function(e) {
            hidePinForm();
        });
        // Initialize a variable to keep track of the last added marker
        var lastMarker = null;
        map.on('dblclick', function(e) {
            // Check if there's a lastMarker and remove it from the map
            if (lastMarker) {
                map.removeLayer(lastMarker);
            }

            // Add a new marker at the clicked position
            var newMarker = L.marker(e.latlng).addTo(map);
            newMarker.bindPopup("Double click to edit.");
            // newMarker.options.name = "double click to edit";
            newMarker.on('dblclick', function(e) {
                currentMarker = e.target;
                showPinForm(newMarker, e.latlng);


                if (typeof newMarker.options.name === 'undefined') {
                    document.getElementById('pin-name').value = 'New Marker';
                } else {
                    document.getElementById('pin-name').value = newMarker.options.name;
                }

                document.getElementById('PinTypes').value = 1;
            });
            // Update lastMarker to the newly added marker
            lastMarker = newMarker;
            currentMarker = newMarker;
        });

        function showEmptyForm() {
            var removeForm = document.getElementById('remove-pins');
            removeForm.style.display = 'block';
        }

        function hideRemoveForm() {
            document.getElementById('remove-pins').style.display = 'none';
        }

        function showPinForm(marker, latlng) {
            var pinForm = document.getElementById('pin-form');
            var editForm = document.getElementById('edit-pin-form');
            var pinID = document.getElementById('pin-id');
            var PinTypes = document.getElementById('PinTypes');
            var pinNameInput = document.getElementById('pin-name');
            var pinLatitudeInput = document.getElementById('pin-latitude');
            var pinLongitudeInput = document.getElementById('pin-longitude');
            // Show form
            pinForm.style.display = 'block';
            pinID.value = '';
            // Pre-fill pin name
            pinNameInput.value = '';
            pinNameInput.value = marker.options.name;
            pinID.value = marker.options.id;
            PinTypes.value = marker.options.pinID;
            pinLatitudeInput.value = latlng.lat;
            pinLongitudeInput.value = latlng.lng;
            // Update pin on form submit
            editForm.onsubmit = function(event) {
                event.preventDefault();
                var newName = pinNameInput.value;

                if (newName.trim() !== '') {
                    marker.bindTooltip(newName).openTooltip();
                }
                hidePinForm();
            };

        }

        function removeAllMarkers() {
            for (let i = 0; i < allMarkers.length; i++) {
                map.removeLayer(allMarkers[i]);
                //console.log(allMarkers.latlng);
            }
            map.removeLayer(currentMarker);
        }
        // Delete pin
        deletePin = function(type) {
            //marker = currentMarker;
            var pass = document.getElementById("delete-pass").value;


            hidePinForm();
            event.preventDefault(); // Prevent default form submission
            var pinID = document.getElementById('pin-id').value;
            // AJAX request to save pin data
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'ajx/delete_pin.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 400) {
                    hidePinForm();
                } else {
                    // Error: Handle error response
                    console.error('Error saving pin: ' + xhr.statusText);
                }
            };
            xhr.onerror = function() {
                // Request failed
                console.error('Request failed');
            };
            if (type == 0) {
                map.removeLayer(currentMarker);
                var params = 'pin-id=' + encodeURIComponent(pinID) +
                    '&deleteType=' + type;
            }
            if (type == 1) {
                hideRemoveForm();
                removeAllMarkers();
                var params = 'pin-id=0' +
                    '&deleteType=' + type +
                    '&pass=' + pass;
            }

            // Send request
            xhr.send(params);
        }

        function approvePin() {
            currentMarker.bindPopup('');
            var name = document.getElementById('pin-name').value;
            var value = document.getElementById('pin-id').value;
            // Perform AJAX request
            $.ajax({
                url: 'ajx/approve_pin.php', // Replace with your server-side script URL
                type: 'POST',
                data: {
                    value: value
                },
                success: function(response) {
                    $('#response').html(response); // Display response from server
                    currentMarker.bindPopup(name + '<br>Last Update<br>(0 min) ago.<br>' + response + ' Confirms.');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status, error);
                }
            });
            // var cc = parseInt(currentMarker.options.ConfirmCount);
            // cc++;
            //console.log(cc);
            //currentMarker.unbindPopup();

            hidePinForm();
        }

        function hidePinForm() {
            document.getElementById('pin-form').style.display = 'none';
        }
    </script>
</body>

</html>