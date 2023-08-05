<x-sidbar :filteredUsers="$filteredUsers"></x-sidbar>
<x-layout :filteredUsers="$filteredUsers">
    <x-card class="p-10 max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">Create a Reservation</h2>
            <p class="mb-4">Reserve a seat for your clients</p>
        </header>

        <form method="POST" action="/listings" enctype="multipart/form-data">
            @csrf
            @if($user->serviceList)
            <div class="mb-6">
                <label for="title" class="inline-block text-lg mb-2">The Type of Service <span class="text-red-500">*</span></label>
                <select name="title" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">

                    @foreach(json_decode($user->serviceList) as $title)
                        <option value="{{ $title }}">{{ $title }}</option>
                    @endforeach

                </select>

                @error('title')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            @else
            <div class="mb-6">
                <label for="title" class="inline-block text-lg mb-2">Type of service</label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="title"
                       placeholder="Example: Senior Laravel Developer" value="{{ old('title') }}" />

                @error('title')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            @endif
            <div class="mb-6">
                <input type="hidden" name="client_id" value="{{ $clientId }}">
                <input type="hidden" name="business_id" value="{{ $businessId }}">
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
                <label for="time" class="inline-block text-lg mb-2">Time <span class="text-red-500">*</span></label>
                <input type="time" class="border border-gray-200 rounded p-2 w-full" name="time" value="{{ old('time') }}" />

                @error('time')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>


            <div class="mb-6">
                <label for="date" class="inline-block text-lg mb-2">
                    Date <span class="text-red-500">*</span>
                </label>
                <input type="date" class="border border-gray-200 rounded p-2 w-full" name="date" value="{{old('date')}}" />

                @error('date')
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
                <label for="logo" class="inline-block text-lg mb-2">Thumbnail</label>
                <div class="relative">
                    <label for="thumbnail-input" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 cursor-pointer">
                        <input type="file" class="hidden" name="logo" accept="image/*" id="thumbnail-input" onchange="previewImage(event)" />
                        <div class="flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 4a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V4zm2-1a1 1 0 00-1 1v2a1 1 0 001 1h10a1 1 0 001-1V4a1 1 0 00-1-1H5z" clip-rule="evenodd" />
                                <path d="M10 9a2 2 0 100-4 2 2 0 000 4z" />
                            </svg>
                        </div>
                        <span class="ml-3">Upload Thumbnail</span>
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
    // Retrieve the selected date parameter from the URL
    const urlParams = new URLSearchParams(window.location.search);
    const selectedDate = urlParams.get('selectedDate');

    // Set the value of the date input field if a selected date is available
    if (selectedDate) {
        const dateInput = document.querySelector('input[name="date"]');
        if (dateInput) {
            dateInput.value = selectedDate;
        }
    }
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
</script>
