<x-sidbar :filteredUsers="$filteredUsers"></x-sidbar>
<x-layout :filteredUsers="$filteredUsers">
    <x-card class="p-10 max-w-lg mx-auto mt-5">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">Create a Reservation</h2>
            <p class="mb-4">Reserve a seat for your clients</p>
        </header>

        <form method="POST" action="/listings" enctype="multipart/form-data">
            @csrf

            <div class="mt-4">

                <div class="bg-white p-2 md:p-4 rounded-xl shadow-md flex flex-wrap  justify-between w-full">

                    <!-- Service Title with Icon -->
                    <div class="text-sm md:text-lg font-medium flex items-center space-x-1 md:space-x-2 ">
                        <i class="fas fa-cut text-gray-500 md:text-gray-600"></i>
                        <span class="truncate" id="displayServiceName">Flat iron service (natural hair)</span>
                    </div>

                    <!-- Service Price with Icon -->
                    <div class="text-sm md:text-lg text-gray-600 flex items-center mt-2 md:mt-0 ">
                        <i class="fas fa-dollar-sign text-gray-500 md:text-gray-600"></i>
                        <span class="font-semibold text-green-400 md:text-green-500" id="displayServicePrice"></span>
                        <span class="ml-1">and up</span>
                    </div>

                    <!-- Service Duration with Icon -->
                    <div class="text-sm md:text-lg text-gray-500 flex items-center mt-2 md:mt-0 ">
                        <i class="fas fa-clock text-gray-500 md:text-gray-600"></i>
                        <span class="font-medium ml-1" id="displayServiceDuration"></span>
                    </div>
                </div>
            </div>
            <input type="hidden" id="title" name="title" value="">
            <div class="mb-6">
                <input type="hidden" name="client_id" value="{{ $clientId }}">
                <input type="hidden" name="business_id" value="{{ $businessId }}">
            </div>
            <div class="flex space-x-8 p-4 bg-white shadow-md rounded-md justify-between mb-4">
                <!-- Time Display -->
                <div class="flex items-center space-x-2">
                    <i class="fas fa-clock text-teal-500 "></i>
                    <span id="displayTime" class="text-gray-800 text-lg"></span>
                    <input type="hidden" name="time" id="timeInput">
                </div>
                <!-- Date Display -->
                <div class="flex items-center space-x-2">
                    <i class="fas fa-calendar-alt text-teal-500"></i>
                    <span id="displayDate" class="text-gray-800 text-lg"></span>
                    <input type="hidden" name="date" id="dateInput">
                </div>



            </div>
            <div class="mb-6">
                <label for="customer_name" class="inline-block text-lg mb-2">
                    Customer Name <span class="text-red-500">*</span>
                </label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="customer_name" value="{{ $client['client-name'] ?? '' }}" />

                @error('customer_name')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="email" class="inline-block text-lg mb-2">
                    Customer Email
                </label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="email" value="{{$client->email ?? ''}}  " />

                @error('email')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="customer_phone" class="inline-block text-lg mb-2">
                    Customer Phone
                </label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="customer_phone" value="{{$client->contact_info ?? ''}}" />

                @error('customer_phone')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>










            <div class="mb-6">
                <label for="description" class="inline-block text-lg mb-2">
                    Additional Details
                </label>
                <textarea class="border border-gray-200 rounded p-2 w-full" name="description" rows="10"
                          placeholder="Provide additional details if needed">{{old('description')}}</textarea>

                @error('description')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">

                <div class="relative">
                    <label for="thumbnail-input" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 cursor-pointer">
                        <input type="file" class="hidden" name="logo" accept="image/*" id="thumbnail-input" onchange="previewImage(event)" />
                        <div class="flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 4a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V4zm2-1a1 1 0 00-1 1v2a1 1 0 001 1h10a1 1 0 001-1V4a1 1 0 00-1-1H5z" clip-rule="evenodd" />
                                <path d="M10 9a2 2 0 100-4 2 2 0 000 4z" />
                            </svg>
                        </div>
                        <span class="ml-3">Are reference to service expectation</span>
                    </label>
                </div>
                <div class="mt-2">
                    <img id="thumbnail-preview" class="w-40 h-40 object-cover rounded-lg border border-gray-300" src="" alt="Thumbnail Preview" style="display: none;" />
                </div>
                @error('logo')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="tags" class="inline-block text-lg mb-2">
                    Tags (Comma Separated)
                </label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="tags"
                       placeholder="Example: salon, hair, rebuild, etc" value="{{old('tags')}}" />

                @error('tags')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="status" class="inline-block text-lg mb-2">Status</label>
                <select name="status" class="border border-gray-200 rounded p-2 w-full">
                    <option value="pending" @if(old('status') === 'rescheduled') selected @endif>rescheduled</option>
                    <option value="confirmed" @if(old('status') === 'confirmed') selected @endif>Confirmed</option>
                    <option value="cancelled" @if(old('status') === 'cancelled') selected @endif>Cancelled</option>
                </select>

                @error('status')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-6">
                <button class="text-white rounded py-2 px-4 hover:bg-black bg-pink-500">
                    Reserve
                </button>
                <a href="/" class="text-black ml-4"> Back </a>
            </div>
        </form>
    </x-card>
</x-layout>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    const selectedDate = urlParams.get('selectedDate');
    const selectedTime = urlParams.get('selectedTime');
    const serviceName = urlParams.get('serviceName');
    const serviceDuration = urlParams.get('serviceDuration');
    const servicePrice = urlParams.get('servicePrice');
    const displayDateSpan = document.getElementById('displayDate');
    const displayTimeSpan = document.getElementById('displayTime');
    const dateInput = document.getElementById('dateInput');
    const timeInput = document.getElementById('timeInput');

    if (selectedDate) {
        const dateObj = new Date(selectedDate);
        const year = dateObj.getFullYear();
        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        const month = monthNames[dateObj.getMonth()];
        const day = dateObj.getDate();
        const formattedDateDisplay = `${month} ${day}, ${year}`;
        const formattedDateInput = `${year}-${String(dateObj.getMonth() + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

        if (displayDateSpan) {
            displayDateSpan.innerText = formattedDateDisplay;
        }

        if (dateInput) {
            dateInput.value = formattedDateInput; // Use the format suitable for input[type="date"]
        }
    }

    if (selectedTime) {
        const timeParts = selectedTime.split(' ');
        const timeWithoutAmPm = timeParts[0];
        const amPm = timeParts[1];
        let formattedTime = timeWithoutAmPm;

        if (amPm) {
            formattedTime += ` ${amPm}`;
        }

        if (displayTimeSpan) {
            displayTimeSpan.innerText = formattedTime;
        }

        if (timeInput) {
            timeInput.value = timeWithoutAmPm;  // Use the 24-hour format for input[type="time"]
        }
    }



    // Display serviceName
    const displayServiceNameElem = document.getElementById('displayServiceName');
    if (displayServiceNameElem && serviceName) {
        displayServiceNameElem.innerText = serviceName;
    }

    // Display serviceDuration
    const displayServiceDurationElem = document.getElementById('displayServiceDuration');
    if (displayServiceDurationElem && serviceDuration) {
        displayServiceDurationElem.innerText = serviceDuration;
    }

    // Display servicePrice
    const displayServicePriceElem = document.getElementById('displayServicePrice');
    if (displayServicePriceElem && servicePrice) {
        displayServicePriceElem.innerText = servicePrice;
    }

    function addHiddenInputForDisabled(el) {
        if (!document.getElementById(el.name + '_hidden')) {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = el.name;
            hiddenInput.value = el.value;
            hiddenInput.id = el.name + '_hidden';
            el.parentNode.appendChild(hiddenInput);
        } else {
            document.getElementById(el.name + '_hidden').value = el.value;
        }

        el.addEventListener('change', function() {
            document.getElementById(el.name + '_hidden').value = el.value;
        });
    }

    const serviceData = {
        name: serviceName,
        duration: serviceDuration,
        price: servicePrice
    };

    document.getElementById('title').value = JSON.stringify(serviceData);
    function previewImage(event) {
        var input = event.target;
        var preview = document.getElementById('thumbnail-preview');

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block'; // Show the preview image
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '';
            preview.style.display = 'none'; // Hide the preview image
        }
    }
    });
</script>

