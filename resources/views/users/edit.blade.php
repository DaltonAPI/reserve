<x-sidbar :filteredUsers="$filteredUsers"/>
<x-layout :filteredUsers="$filteredUsers">
    <section  class="">
        <div class="flex flex-col items-center justify-center px-6 mx-auto  ">
            <div class="w-full bg-white rounded-lg shadow  sm:max-w-md ">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                        Create an account
                    </h1>
                    <form id="myForm" class="space-y-4 md:space-y-6" method="POST" action="/profile/{{$user->id}}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="account_type" class="block mb-2 text-sm font-medium text-gray-900">Account Type  <span class="text-red-500">*</span></label>
                            <select name="account_type" id="industry_category" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required="">
                                @if(old('account_type', $user->account_type) === 'Business')
                                    <option value="Business" @if(old('account_type', $user->account_type) === 'Business') selected @endif>Business</option>
                                @elseif(old('account_type', $user->account_type) === 'Client')
                                    <option value="Client" @if(old('account_type', $user->account_type) === 'Client') selected @endif>Client</option>
                                @endif


                            </select>
                            @error('account_type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4" id="client-name-container">
                            <label for="client-name" class="block mb-2 text-sm font-medium text-gray-900">Client Name<span class="text-red-500">*</span></label>
                            <input type="text" name="client-name" id="client-name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" value="{{ old('client-name', $user['client-name']) }}">
                            @error('client-name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="mb-4">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="name@company.com" value="{{ old('email', $user->email) }}">
                            @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>




                        <div>
                            <label for="contact_info" class="block  text-sm font-medium text-gray-900 mb-2">Contact Number<span class="text-red-500">*</span></label>
                            <div class="flex">
                                <select id="country_code_select">
                                    <option value="+1">+1 (USA)</option>
                                    <option value="+44">+44 (UK)</option>
                                    <option value="+91">+91 (India)</option>
                                </select>
                                <input type="text" name="contact_info" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600  w-full p-2.5" value="{{ old('contact_info', $user->contact_info) }}">
                            </div>
                            @error('contact_info')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>



                        <div class="mb-6">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Business Logo <span class="text-red-500">*</span></label>
                            <input type="file" class="border border-gray-200 rounded p-2 w-full" name="photos" />

                            <div class="mt-4">
                                @if ($user->photos)
                                    <img class="w-48" src="{{ asset('storage/' . $user->photos) }}" alt="Company Logo" />
                                @else
                                    <img class="w-48 mt-4" src="{{ asset('/images/no-image.png') }}" alt="No Image" />
                                @endif

                                @error('photos')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>





                        <div class="business">
                            <div class="mb-4">
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900"> Name <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" value="{{ old('name', $user->name) }}">
                                @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="bio" class="block mb-2 text-sm font-medium text-gray-900">Bio(optional)</label>
                                <textarea name="bio" id="bio" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">{{ old('bio', $user->bio) }}</textarea>
                                @error('bio')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            @php
                                $socialMediaOptions = [
                                    'Facebook' => 'Facebook',
                                    'Instagram' => 'Instagram',
                                    'Twitter' => 'Twitter',
                                    'TikTok' => 'TikTok', // Add TikTok to the social media options
                                    'YouTube' => 'YouTube', // Add YouTube to the social media options
                                ];
                            @endphp

                            <div class="mb-4">
                                <label for="social_media" class="block text-sm font-medium text-gray-900">Social Media Profiles (optional)</label>
                                <p style="font-size: x-small">Copy the link from any of your social media profiles and paste it in the input field (optional)</p>
                                <div>
                                    @if(!empty($socialMediaOptions))
                                        @foreach($socialMediaOptions as $value => $option)
                                            <div class="flex items-center mb-2">
                                                @php
                                                    $isChecked = in_array($value, json_decode($user->social_media, true) ?? []);
                                                    $linkValue = $user->{$value.'_links'} ?? '';
                                                @endphp
                                                <input type="checkbox" name="social_media[]" value="{{ $value }}" id="{{ $value }}_checkbox" class="mr-2 social-media-checkbox" {{ $isChecked ? 'checked' : '' }}>
                                                <label for="{{ $value }}_checkbox" class="text-sm text-gray-900">{{ $option }}</label>
                                            </div>
                                            <div class="mb-4" id="{{ $value }}_links" style="display: {{ $isChecked ? 'block' : 'none' }};">
                                                <label class="block mb-2 text-sm font-medium text-gray-900">{{ $option }} Link(s)</label>
                                                <input type="text" name="{{ $value }}_links" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" value="{{ $linkValue }}">
                                                @error($value.'_links')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        @endforeach

                                        <script>
                                            document.addEventListener('DOMContentLoaded', function () {
                                                // Get all the checkboxes with the social-media-checkbox class
                                                const checkboxes = document.querySelectorAll('.social-media-checkbox');

                                                checkboxes.forEach(checkbox => {
                                                    // Get the corresponding input field using the checkbox's value
                                                    const value = checkbox.value;
                                                    const inputField = document.querySelector(`input[name="${value}_links"]`);

                                                    // Check the checkbox if the corresponding input field has a value
                                                    checkbox.checked = inputField.value.trim() !== '';

                                                    // Show/hide the input field based on the checkbox state
                                                    if (checkbox.checked) {
                                                        document.getElementById(`${value}_links`).style.display = 'block';
                                                    } else {
                                                        document.getElementById(`${value}_links`).style.display = 'none';
                                                    }

                                                    // Add event listener to toggle the input field visibility when the checkbox state changes
                                                    checkbox.addEventListener('change', function () {
                                                        if (this.checked) {
                                                            document.getElementById(`${value}_links`).style.display = 'block';
                                                        } else {
                                                            document.getElementById(`${value}_links`).style.display = 'none';
                                                        }
                                                    });
                                                });
                                            });
                                        </script>

                                    @else
                                        <p>No social media options available.</p>
                                    @endif
                                </div>
                                @error('social_media')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>




                        @if($user->serviceList)

                                <div class="mb-4">

                                    <div class="mb-2">
                                        <label for="durationSelect" class="block text-sm font-medium text-gray-900">Choose Service Duration </label>
                                        <select name="durationSelect" id="durationSelect" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                            <option value="30">30 minutes</option>
                                            <option value="60">1 hour</option>
                                            <option value="90">1 hour 30 minutes</option>
                                            <option value="120">2 hours</option>
                                            <option value="150">2 hours 30 minutes</option>
                                            <option value="180">3 hours</option>
                                            <option value="210">3 hours 30 minutes</option>
                                            <option value="240">4 hours</option>
                                            <option value="270">4 hours 30 minutes</option>
                                            <option value="300">5 hours</option>
                                            <option value="330">5 hours 30 minutes</option>
                                            <option value="360">6 hours</option>
                                            <option value="390">6 hours 30 minutes</option>
                                            <option value="420">7 hours</option>
                                            <option value="450">7 hours 30 minutes</option>
                                            <option value="480">8 hours</option>
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label for="serviceInput" class="block  text-sm font-medium text-gray-900">Services Offered<span class="text-red-500">*</span></label>
                                        <p style="font-size: x-small;">Type your service in the input field and click "Add Service" to add, and click "X" to remove service.</p>
                                    </div>
                                    <input type="text" name="serviceList" id="serviceInput" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="eg. repair, house cleaning, lawn cutting">
                                    @error('serviceList')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                    <ul id="serviceList" class="mt-2">
                                    </ul>
                                    <input type="hidden" name="serviceList" id="hiddenServiceInput" value="{{ $user->serviceList}}">
                                    <button onclick="addService(event)" type="button" class=" bg-pink-500 hover:bg-pink-600 text-white font-medium py-2 px-4 rounded">
                                        <icon class="fa fa-plus"></icon>
                                    </button>
                                </div>









                            @endif
                            <div class="mb-4">
                                <label for="location" class="block mb-2 text-sm font-medium text-gray-900">Location <span class="text-red-500">*</span></label>
                                <input type="text" id="location-input" name="location" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" value="{{ old('location', $user->location) }}">
                                @error('location')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div id="map" style="height: 400px;"></div>
                                <?php
                                $googleMapsApiKey = 'AIzaSyDDl24sRJEmh8Tkdr9d3JlLQG-MFgjCKSs';
                                ?>
                            @push('scripts')

                                <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $googleMapsApiKey; ?>&libraries=places&callback=initMap" async defer></script>
                            @endpush
                            @stack('scripts')

                        </div>
                        <script src="{{ asset('script/script.js') }}"></script>
                        <div class="mt-6">
                            <button onclick="submitForm(event)" type="button" class="w-full text-gray-900 bg-pink-500 hover:bg-pink-300 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5">Create an account</button>
                        </div>
                        <p class="text-sm font-light text-gray-500">
                            Already have an account? <a href="#" class="font-medium text-pink-600 hover:underline">Login here</a>
                        </p>

                    </form>
                </div>
            </div>
        </div>
    </section>
</x-layout>



<script>
    // Initialize an empty array to store the services
    var services = {!! $user->serviceList !!};;

    // Function to add a service to the array
    function addService(event) {
        event.preventDefault();

        var input = document.getElementById("serviceInput");
        var service = input.value.trim();

        if (service !== "") {
            var durationSelect = document.getElementById("durationSelect");
            var selectedDuration = parseInt(durationSelect.value);

            if (!isNaN(selectedDuration) && selectedDuration > 0) {
                var hours = Math.floor(selectedDuration / 60);
                var minutes = selectedDuration % 60;
                var formattedDuration = hours + ":" + (minutes < 10 ? "0" : "") + minutes;

                services.push({
                    name: service,
                    duration: formattedDuration
                });

                input.value = "";
                renderServiceList();
                saveServicesToLocalStorage();
            } else {
                alert("Invalid duration. Please select a valid duration.");
            }
        }
    }

    // Function to remove the last service from the array
    function removeService(event) {
        event.preventDefault();

        // Remove the last service from the array
        if (services.length > 0) {
            services.pop();
            renderServiceList(); // Update the displayed service list
        }
        saveServicesToLocalStorage();
    }

    // Function to render the service list on the page
    function renderServiceList() {
        var serviceList = document.getElementById("serviceList");
        serviceList.innerHTML = ""; // Clear the list

        // Add each service as a list item
        services.forEach(function (service, index) {
            var listItem = document.createElement("li");
            listItem.textContent = service.name;

            listItem.className = "inline-flex items-center bg-gray-100 text-gray-800 rounded-full px-3 py-1 mr-2 mb-2";

            // Display service duration and breaks
            var infoSpan = document.createElement("span");
            infoSpan.textContent = `(${service.duration})`;
            infoSpan.className = "ml-2 text-xs text-gray-500";

            // Create a span element for the "x" and add a click event to remove the item
            var removeButton = document.createElement("span");
            removeButton.textContent = "x";
            removeButton.className = "text-red-500 hover:text-red-700 ml-2 remove-item-button";
            removeButton.setAttribute("data-index", index);
            removeButton.onclick = removeItem;

            // Append the elements to the listItem
            listItem.appendChild(infoSpan);
            listItem.appendChild(removeButton);

            // Append the listItem to the serviceList
            serviceList.appendChild(listItem);
        });
    }

    // Function to remove a specific item from the services array
    function removeItem(event) {
        var indexToRemove = event.target.getAttribute("data-index");
        if (indexToRemove !== null) {
            services.splice(indexToRemove, 1);
            renderServiceList(); // Update the displayed service list
        }
        saveServicesToLocalStorage();
    }
    function saveServicesToLocalStorage() {
        localStorage.setItem("services", JSON.stringify(services));
    }


    function loadServicesFromLocalStorage() {
        var storedServices = localStorage.getItem("services");
        services = storedServices ? JSON.parse(storedServices) : [];
        renderServiceList(); // Update the displayed service list
    }

    // Add an event listener to execute the loadServicesFromLocalStorage function when the DOM content is loaded
    document.addEventListener("DOMContentLoaded", function() {
        loadServicesFromLocalStorage(); // Load services array from localStorage
    });




    function submitForm(event) {
        event.preventDefault();

        // Update the hidden input value with the JSON string of services
        var hiddenInput = document.getElementById("hiddenServiceInput");
        hiddenInput.value = JSON.stringify(services);

        // Submit the form
        var form = document.getElementById("myForm");
        form.submit();

        // Clear the input field and service list after submitting the form
        input.value = "";
    }


</script>



