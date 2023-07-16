
<x-layout>
    <section  class="">
        <div class="flex flex-col items-center justify-center px-6  mx-auto  ">
            <div class="w-full bg-white rounded-lg shadow  sm:max-w-md ">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                        Create an account
                    </h1>
                    <form id="myForm" class="space-y-4 md:space-y-6" method="POST" action="/users" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="account_type" class="block mb-2 text-sm font-medium text-gray-900">Account Type  <span class="text-red-500">*</span></label>
                            <select name="account_type" id="industry_category" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required="">
                                <option value="Business" @if(old('account_type') === 'Business') selected @endif>Business</option>
                                <option value="Client"  @if(old('account_type') === 'Client') selected @endif>Client</option>
                            </select>
                            @error('account_type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4" id="client-name-container" style="display: none;">
                            <label for="client-name" class="block mb-2 text-sm font-medium text-gray-900">Client Name<span class="text-red-500">*</span></label>
                            <input type="text" name="client-name" id="client-name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" value="{{ old('client-name') }}" ">
                            @error('client-name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="mb-4">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Your email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="name@company.com" value="{{ old('email') }}" required="">
                            @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password <span class="text-red-500">*</span></label>
                            <input type="password" value="{{ old('password') }}" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"  required="">
                            @error('password')
                            <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                            @enderror
                        </div>
{{--                        <div class="mb-4">--}}
{{--                            <label for="confirm-password" class="block mb-2 text-sm font-medium text-gray-900">Confirm password<span class="text-red-500">*</span></label>--}}
{{--                            <input type="password" name="password_confirmation" id="confirm-password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required="">--}}
{{--                            @error('password_confirmation')--}}
{{--                            <p class="text-red-500 text-xs mt-1">{{$message}}</p>--}}
{{--                            @enderror--}}
{{--                        </div>--}}



                        <div>
                            <label for="contact_info" class="block  text-sm font-medium text-gray-900 mb-2">Contact Number<span class="text-red-500">*</span></label>
                            <div class="flex">
                                <select id="country_code_select">
                                    <option value="+1">+1 (USA)</option>
                                    <option value="+44">+44 (UK)</option>
                                    <option value="+91">+91 (India)</option>

                                </select>
                                <input type="text" name="contact_info" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600  w-full p-2.5" value="{{ old('contact_info') }}" >
                            </div>
                            @error('contact_info')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror

                        </div>





                        <div class="mb-6">
                            <label for="photos" class="block mb-2 text-sm font-medium text-gray-900"> Logo(optional)</label>
                            <input type="file" class="border border-gray-200 rounded p-2 w-full" name="photos" value="{{ old('photos') }}" />

                            @error('photos')
                            <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                            @enderror
                        </div>

                        <div class="business">
                            <div class="mb-4">
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Business Name<span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" value="{{ old('name') }}" >
                                @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="bio" class="block mb-2 text-sm font-medium text-gray-900">Bio(optional)</label>
                                <textarea name="bio" id="bio" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" >{{ old('bio') }}</textarea>
                                @error('bio')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            @php
                                $socialMediaOptions = [
                                    'Facebook' => 'Facebook',
                                    'Instagram' => 'Instagram',
                                    'Twitter' => 'Twitter',
                                ];
                            @endphp

                            <div class="mb-4">
                                <label for="social_media" class="block  text-sm font-medium text-gray-900">Social Media Profiles (optional)</label>
                                <p style="font-size: x-small">Copy link from any of your social my profile and paste it in the input file(optional)</p>
                                <div>
                                    @if(!empty($socialMediaOptions))
                                        @foreach($socialMediaOptions as $value => $option)
                                            <div class="flex items-center mb-2">
                                                <input type="checkbox" name="social_media[]" value="{{ $value }}" id="{{ $value }}_checkbox" class="mr-2" {{ old('social_media') && in_array($value, old('social_media')) ? 'checked' : '' }}>
                                                <label for="{{ $value }}_checkbox" class="text-sm text-gray-900">{{ $option }}</label>
                                            </div>
                                        @endforeach
                                    @else
                                        <p>No social media options available.</p>
                                    @endif
                                </div>
                                @error('social_media')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>



                            <div id="social_media_links">

                                @foreach($socialMediaOptions as $value => $option)
                                    <div class="mb-4" id="{{ $value }}_links" style="display: none;">
                                        <label class="block mb-2 text-sm font-medium text-gray-900">{{ $option }} Link(s)</label>
                                        <input type="text" name="{{ $value }}_links" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" value="{{ old($value.'_links') ? old($value.'_links') : '' }}">
                                    </div>
                                @endforeach
                            </div>
                            @php
                                // Validation Rules
                                $validationRules = [
                                    // Existing validation rules
                                    // ...
                                    'Facebook_links' => 'nullable|url',
                                    'Instagram_links' => 'nullable|url',
                                    'Twitter_links' => 'nullable|url',
                                ];
                            @endphp

                            @error('social_media')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror

                            @foreach($socialMediaOptions as $value => $option)
                                @error($value.'_links')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            @endforeach
                                <div class="mb-4">
                                    <label for="serviceInput" class="block  text-sm font-medium text-gray-900">Services Offered<span class="text-red-500">*</span></label>
                                    <p style="font-size: x-small;">Type your service in the input field and click "Add Service" to add, and click "Remove Service" to remove service.</p>
                                    <input type="text" name="serviceList" id="serviceInput" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="eg. repair, house cleaning, lawn cutting">
                                    @error('serviceList')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                    <ul id="serviceList" class="mt-2">
                                        @if(old('serviceList'))
                                            @php
                                                $services = json_decode(old('serviceList'));
                                            @endphp
                                            @foreach($services as $service)
                                                <li>{{ $service }}</li>
                                            @endforeach
                                        @endif
                                    </ul>
                                    <input type="hidden" name="serviceList" id="hiddenServiceInput" value="{{ old('serviceList') }}">
                                    <button onclick="addService(event)" type="button" class="mt-3 bg-pink-500 hover:bg-pink-600 text-white font-medium py-2 px-4 rounded">
                                        Add Service
                                    </button>
                                    <button onclick="removeService(event)" type="button" class="mt-3 bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded">
                                        Remove Last Service
                                    </button>

                                </div>


{{--                                                        <div class="mb-4">--}}
{{--                                <label for="industry_category" class="block mb-2 text-sm font-medium text-gray-900">Industry/Category</label>--}}
{{--                                <select name="industry_category" id="industry_category" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">--}}
{{--                                    <option value="" disabled selected>Select industry/category</option>--}}
{{--                                    <option value="Salon">Salon</option>--}}
{{--                                    <option value="Repair">Repair</option>--}}
{{--                                </select>--}}
{{--                                @error('industry_category')--}}
{{--                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
                            <div class="mb-4">
                                <label for="location" class="block mb-2 text-sm font-medium text-gray-900">Location <span class="text-red-500">*</span></label>
                                <input type="text" id="location-input" name="location"  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" value="{{ old('location') }}">
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






<!-- Add the following script after the HTML content -->
<script>
    // Initialize an empty array to store the services
    var services = {!! old('serviceList', '[]') !!};;

    // Function to add a service to the array
    function addService(event) {
        event.preventDefault();

        // Get the input field value
        var input = document.getElementById("serviceInput");
        var service = input.value.trim();

        // Add the service to the array if it's not empty
        if (service !== "") {
            services.push(service);
            input.value = ""; // Clear the input field
            renderServiceList(); // Update the displayed service list
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
    }

    // Function to render the service list on the page
    function renderServiceList() {
        var serviceList = document.getElementById("serviceList");
        serviceList.innerHTML = ""; // Clear the list

        // Add each service as a list item
        services.forEach(function (service) {
            var listItem = document.createElement("li");
            listItem.textContent = service;
            serviceList.appendChild(listItem);
        });
    }

    // Function to submit the form
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
        services = [];
        renderServiceList();
    }
</script>
