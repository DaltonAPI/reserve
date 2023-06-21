// script.js



function hideBusinessFields() {
    var businessDiv = document.querySelector('.business');
    businessDiv.style.display = 'none';
}

function showBusinessFields() {
    var businessDiv = document.querySelector('.business');
    businessDiv.style.display = 'block';
}

function hideClientName() {
    var clientNameContainer = document.getElementById('client-name-container');
    clientNameContainer.style.display = 'none';
}

function showClientName() {
    var clientNameContainer = document.getElementById('client-name-container');
    clientNameContainer.style.display = 'block';
}

function handleAccountTypeChange() {
    var accountTypeSelect = document.getElementById('industry_category');
    var selectedOption = accountTypeSelect.options[accountTypeSelect.selectedIndex].value;

    if (selectedOption === 'Business') {
        hideClientName();
        showBusinessFields();
    } else if (selectedOption === 'Client') {
        showClientName();
        hideBusinessFields();
    }
}

// Attach event listener to the select element
var accountTypeSelectElement = document.getElementById('industry_category');
accountTypeSelectElement.addEventListener('change', handleAccountTypeChange);

// Call the handler initially to handle the default value
handleAccountTypeChange();

//Google Maps
function initMap() {
    var initialLocation = { lat: 37.7749, lng: -122.4194 };
    var map = new google.maps.Map(document.getElementById('map'), {
        center: initialLocation,
        zoom: 13
    });
    var input = document.getElementById('location-input');
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);
    autocomplete.addListener('place_changed', function() {
        var place = autocomplete.getPlace();
        if (place.geometry) {
            map.setCenter(place.geometry.location);
            map.setZoom(15);
        }
    });
}

//Social Media icon
var socialMediaCheckboxes = document.querySelectorAll('input[name="social_media[]"]');
var socialMediaLinks = document.getElementById('social_media_links');

// Add event listeners to checkboxes
socialMediaCheckboxes.forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        var linksDiv = document.getElementById(this.value + '_links');
        if (linksDiv) {
            linksDiv.style.display = this.checked ? 'block' : 'none';
        }
    });

    // Show the corresponding input fields if checkbox is checked on page load
    if (checkbox.checked) {
        var linksDiv = document.getElementById(checkbox.value + '_links');
        if (linksDiv) {
            linksDiv.style.display = 'block';
        }
    }
});

// document.addEventListener('DOMContentLoaded', function() {
//     // Define an empty array to store the values
//     var propertyArray = [];
//
//     // Get the input field, push button, and values container
//     var inputField = document.getElementById('propertyInput');
//     var pushButton = document.getElementById('pushButton');
//     var valuesContainer = document.getElementById('valuesContainer');
//
//     // Add click event listener to the push button
//     pushButton.addEventListener('click', function() {
//         // Get the value from the input field
//         var value = inputField.value;
//
//         // Push the value into the array
//         propertyArray.push(value);
//
//         // Clear the input field
//         inputField.value = '';
//
//         // Update the values container with the updated values
//         valuesContainer.textContent = propertyArray.join(', ');
//
//         // Log the updated array for testing purposes
//         console.log(propertyArray);
//     });
// });

//Phone
// let isUserTyping = false;

function validatePhoneNumber(input) {
    const phoneNumber = input.value;

    // Regular expression pattern to match a phone number
    const phonePattern = /^\d{10}$/;

    const errorSpan = document.getElementById('contact_info_error');

    if (!isUserTyping) {
        isUserTyping = true;
    } else {
        if (!phonePattern.test(phoneNumber)) {
            errorSpan.textContent = 'Invalid phone number. Please enter a 10-digit number.';
        } else {
            errorSpan.textContent = '';
        }
    }
}



