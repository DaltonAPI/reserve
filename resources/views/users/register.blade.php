<x-layout>
    <section style="margin-top:450px" class="">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen py-10 ">
            <div class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                        Create an account
                    </h1>
                    <form class="space-y-4 md:space-y-6" method="POST" action="/users" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="account_type" class="block mb-2 text-sm font-medium text-gray-900">Account Type</label>
                            <select name="account_type" id="industry_category" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required="">
                                <option value="Business">Business</option>
                                <option value="Client">Client</option>
                            </select>
                            @error('account_type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4" id="client-name-container" style="display: none;">
                            <label for="client-name" class="block mb-2 text-sm font-medium text-gray-900">Client Name</label>
                            <input type="text" name="client-name" id="client-name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" value="{{ old('client-name') }}" ">
                            @error('client-name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="mb-4">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Your email</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="name@company.com" value="{{ old('email') }}" required="">
                            @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                            <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"  required="">
                            @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="confirm-password" class="block mb-2 text-sm font-medium text-gray-900">Confirm password</label>
                            <input type="password" name="password_confirmation" id="confirm-password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required="">
                            @error('password_confirmation')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="bio" class="block mb-2 text-sm font-medium text-gray-900">Bio</label>
                            <textarea name="bio" id="bio" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" >{{ old('bio') }}</textarea>
                            @error('bio')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="contact_info" class="block mb-2 text-sm font-medium text-gray-900">Contact Information</label>
                            <input type="text" name="contact_info" id="contact_info" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" value="{{ old('contact_info') }}" required oninput="validatePhoneNumber(this)">
                            <span id="contact_info_error" class="text-red-500 text-xs mt-1"></span>
                        </div>



                        @php
                            $socialMediaOptions = [
                                'Facebook' => 'Facebook',
                                'Instagram' => 'Instagram',
                                'Twitter' => 'Twitter',
                            ];
                        @endphp

                        <div class="mb-4">
                            <label for="social_media" class="block mb-2 text-sm font-medium text-gray-900">Social Media Profiles</label>
                            <div>
                                @foreach($socialMediaOptions as $value => $option)
                                    <div class="flex items-center mb-2">
                                        <input type="checkbox" name="social_media[]" value="{{ $value }}" id="{{ $value }}_checkbox" class="mr-2" {{ old('social_media') && in_array($value, old('social_media')) ? 'checked' : '' }}>
                                        <label for="{{ $value }}_checkbox" class="text-sm text-gray-900">{{ $option }}</label>
                                    </div>
                                @endforeach
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




                        <div class="mb-6">
                            <label for="photos" class="block mb-2 text-sm font-medium text-gray-900">Image</label>
                            <input type="file" class="border border-gray-200 rounded p-2 w-full" name="photos" value="{{ old('photos') }}" />

                            @error('photos')
                            <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                            @enderror
                        </div>

                        <div class="business">
                            <div class="mb-4">
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Business Name</label>
                                <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" value="{{ old('name') }}" >
                                @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="serviceInput" class="block mb-2 text-sm font-medium text-gray-900">Services Offered</label>
                                <input type="text" name="serviceInput" id="serviceInput" multiple class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="type your service and click the button to add" value="{{ old('serviceInput') }}">
                                @error('serviceInput')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                <ul id="serviceList" class="mt-2"></ul>
                                <button onclick="addService(event)" type="submit" class="mt-3 bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded">Add Service</button>
                            </div>


                            <div class="mb-4">
                                <label for="industry_category" class="block mb-2 text-sm font-medium text-gray-900">Industry/Category</label>
                                <select name="industry_category" id="industry_category" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                    <option value="" disabled selected>Select industry/category</option>
                                    <option value="Salon">Salon</option>
                                    <option value="Repair">Repair</option>
                                </select>
                                @error('industry_category')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="location" class="block mb-2 text-sm font-medium text-gray-900">Location</label>
                                <input type="text" id="location-input" name="location"  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
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
                            <button type="submit" onclick="enableSubmit()" class="w-full text-gray-900 bg-blue-500 hover:bg-blue-300 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5">Create an account</button>
                        </div>
                        <p class="text-sm font-light text-gray-500">
                            Already have an account? <a href="#" class="font-medium text-primary-600 hover:underline">Login here</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-layout>


<script>
        var servicesOffer = [];
        var submitEnabled = false;

        function addService(event) {
            event.preventDefault(); // Prevent form submission

            var serviceInput = document.getElementById("serviceInput");
            var serviceList = document.getElementById("serviceList");

            var services = serviceInput.value.split(","); // Split input by commas
            services.forEach(function (service) {
                service = service.trim(); // Remove leading/trailing spaces
                if (service !== "") {
                    servicesOffer.push(service);
                    var listItem = document.createElement("li");
                    listItem.appendChild(document.createTextNode(service));
                    serviceList.appendChild(listItem);
                }
            });

            serviceInput.value = ""; // Clear the input field
        }

        function enableSubmit() {
            submitEnabled = true;
        }

        document.querySelector('form').addEventListener('submit', function (event) {
            if (!submitEnabled) {
                event.preventDefault(); // Prevent form submission if submit is not enabled
                console.log("Form submission prevented.");
            } else {
                var hiddenInput = document.createElement("input");
                hiddenInput.setAttribute("type", "hidden");
                hiddenInput.setAttribute("name", "servicesOffer");
                hiddenInput.setAttribute("value", JSON.stringify(servicesOffer));
                this.appendChild(hiddenInput);
            }
        });
    </script>

