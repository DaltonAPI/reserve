<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Services</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    .grid {
        align-items: start;
    }
    .hidden {
        display: none !important;
    }
</style>
</head>

<body class="bg-black min-h-screen flex items-center justify-center">
<div class="w-full max-w-screen-xl p-6 bg-white rounded-lg shadow-xl flex flex-col md:flex-row">
    <div class="w-full md:w-1/2 pr-4 mb-4 md:mb-0">
        <a href="/createTimePicker" class="text-pink-500 font-bold  rounded transition duration-150 ease-in-out flex items-center">
            <span class="mr-2">Next</span>
            <i class="fas fa-arrow-right"></i>
        </a>

        <h1 class="text-2xl font-semibold mb-4">Add Service</h1>
        <form method="POST" action="/storeServices">
            @csrf <!-- Important: Add CSRF token for security -->

            <div class="mb-4">
                <label for="serviceName" class="block text-sm font-medium text-gray-900">Service Name</label>
                <input type="text" name="name" id="serviceName" value="{{ old('name') }}" class="w-full p-2 mt-1 border rounded-md focus:outline-none focus:ring focus:border-blue-300">
                @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-2 relative">
                <label for="durationSelect" class="block text-sm font-medium text-gray-900">Choose Service Duration</label>
                <select size="5" name="duration" id="durationSelect" class="bg-gray-50 border-0 border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                    @for ($i = 10; $i <= 480; $i+=10)
                        <option value="{{ sprintf('%02d:%02d', floor($i/60), $i%60) }}" {{ old('duration') == sprintf('%02d:%02d', floor($i/60), $i%60) ? 'selected' : '' }}>
                            @if ($i < 60)
                                {{ $i }} minutes
                            @else
                                {{ sprintf('%02d:%02d', floor($i/60), $i%60) }}
                            @endif
                        </option>
                    @endfor
                </select>


                @error('duration')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="servicePrice" class="block text-sm font-medium text-gray-900">Service Price ($)</label>
                <input type="number" name="price" id="servicePrice" step="0.01" value="{{ old('price') }}" class="w-full p-2 mt-1 border rounded-md focus:outline-none focus:ring focus:border-blue-300">
                @error('price')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <input type="hidden" name="user_id" value="{{ auth()->id() }}">

{{--            <div class="mb-4">--}}
{{--                <label for="serviceDescription" class="block text-sm font-medium text-gray-900">Service Description</label>--}}
{{--                <textarea name="description" id="serviceDescription" rows="3" class="w-full p-2 mt-1 border rounded-md focus:outline-none focus:ring focus:border-blue-300">{{ old('description') }}</textarea>--}}
{{--                @error('description')--}}
{{--                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>--}}
{{--                @enderror--}}
{{--            </div>--}}

            <button type="submit" class="w-full py-2 text-white bg-pink-500 hover:bg-pink-600 rounded-md">Add Service</button>
        </form>

    </div>

    <div class="w-full md:w-1/2 overflow-y-auto" style="max-height: 500px;">
        <h2 class="text-lg font-semibold mb-4">Services List</h2>
        <div class="grid md:grid-cols-2 gap-4 items-start">
            @foreach($services as $service)
                <div class="bg-white rounded-lg shadow-lg ">
                    <!-- Header -->


                    <div class="p-3">
                        <!-- Display Data -->
                        <div class="display-data">
                            <div class="rounded-xl inline-flex items-center w-full overflow-x-auto justify-between">

                                <!-- Service Title with Icon -->
                                <div class="text-sm font-semibold flex-shrink-0 flex items-center space-x-1">
                                    <i class="fas fa-cut text-gray-600 fa-xs"></i>
                                    <span class="truncate" style="max-width: 150px;">{{$service->name}}</span>
                                </div>

                                <!-- Separator -->
                                <div class="border-r h-4 border-gray-300 mx-1.5"></div>

                                <!-- Service Price with Icon -->
                                <div class="text-sm text-gray-700 flex-shrink-0 flex items-center space-x-1">
                                    <i class="fas fa-dollar-sign text-gray-600 fa-xs"></i>
                                    <span class="font-bold text-green-500"></span><span class="truncate" style="max-width: 100px;">{{$service->price}} and up</span>
                                </div>

                                <!-- Separator -->
                                <div class="border-r h-4 border-gray-300 mx-1.5"></div>

                                <!-- Service Duration with Icon -->
                                <div class="text-sm text-gray-500 flex-shrink-0 flex items-center space-x-1">
                                    <i class="fas fa-clock text-gray-600 fa-xs"></i>
                                    <span class="font-medium truncate" style="max-width: 50px;">{{$service->duration}}</span>
                                </div>
                            </div>


                            {{--                            <p class="flex items-start">--}}
{{--                                <span class="w-20 font-medium text-sm align-top">Desc:</span>--}}
{{--                                <span class="description text-sm">{{ $service->description }}</span>--}}
{{--                            </p>--}}
                        </div>

                        <!-- Editable Data (Hidden by default) -->
                        <div class="edit-data hidden">
                            <form class="update-form" method="POST" action="{{ route('service.update', $service) }}">
                                @csrf
                                @method('PATCH')
                            <!-- Service Name -->
                            <div class="mb-4">
                                <label for="serviceName_{{ $service->id }}" class="block text-sm font-medium text-gray-900">Service Name</label>
                                <input type="text" name="name" id="serviceName_{{ $service->id }}" value="{{ $service->name }}" class="w-full p-2 mt-1 border rounded-md focus:outline-none focus:ring focus:border-blue-300">
                                @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Service Duration -->
                            <div class="mb-2 relative">
                                <label for="durationSelect_{{ $service->id }}" class="block text-sm font-medium text-gray-900">Choose Service Duration</label>
                                <select size="5" name="duration" id="durationSelect_{{ $service->id }}" class="bg-gray-50 border-0 border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                    @for ($i = 10; $i <= 480; $i+=10)
                                        <option value="{{ sprintf('%02d:%02d', floor($i/60), $i%60) }}" {{ $service->duration == sprintf('%02d:%02d', floor($i/60), $i%60) ? 'selected' : '' }}>
                                            @if ($i < 60)
                                                {{ $i }} minutes
                                            @else
                                                {{ sprintf('%02d:%02d', floor($i/60), $i%60) }}
                                            @endif
                                        </option>
                                    @endfor
                                </select>

                                @error('duration')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Service Price -->
                            <div class="mb-4">
                                <label for="servicePrice_{{ $service->id }}" class="block text-sm font-medium text-gray-900">Service Price ($)</label>
                                <input type="number" name="price" id="servicePrice_{{ $service->id }}" step="0.01" value="{{ $service->price }}" class="w-full p-2 mt-1 border rounded-md focus:outline-none focus:ring focus:border-blue-300">
                                @error('price')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            </form>
                        </div>

                    </div>


                    <div class="flex justify-between bg-gray-100 p-3 rounded-b-lg border-t border-gray-200">
                        <a href="#" class="edit-service text-blue-500 hover:text-blue-600 text-sm">
                            <i class="fas fa-edit edit-icon"></i>
                            <i class="fas fa-save save-icon hidden" data-id="{{ $service->id }}"></i>  <!-- This should be hidden initially -->
                        </a>


                        <form method="POST" action="{{ route('service.destroy', $service) }}" class="delete-service-form">
                            @csrf
                            @method('DELETE')
                            <a href="#" class="delete-service text-red-500 hover:text-red-600 text-sm" onclick="event.preventDefault(); this.closest('.delete-service-form').submit();">
                                <span class="material-icons"><i class="fas fa-trash"></i></span>
                            </a>
                        </form>


                    </div>
                    @if (session('success'))
                        <div class="bg-green-100 border-t-4 border-green-500 rounded-b text-green-900 px-4 py-3 shadow-md" role="alert">
                            <div class="flex">
                                <div class="py-1"><i class="fas fa-check mr-2"></i></div>
                                <div>
                                    <p class="font-bold">Success</p>
                                    <p class="text-sm">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>




</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editLinks = document.querySelectorAll('.edit-service');

        editLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();

                const serviceCard = link.closest('.bg-white');
                const displayData = serviceCard.querySelector('.display-data');
                const editData = serviceCard.querySelector('.edit-data');
                const editIcon = link.querySelector('.fa-edit');
                const saveIcon = link.querySelector('.fa-save');

                if (!displayData.classList.contains('hidden')) {
                    displayData.classList.add('hidden');
                    editData.classList.remove('hidden');
                    editIcon.classList.add('hidden');
                    saveIcon.classList.remove('hidden');
                } else {
                    displayData.classList.remove('hidden');
                    editData.classList.add('hidden');
                    editIcon.classList.remove('hidden');
                    saveIcon.classList.add('hidden');
                }
            });
        });

        const saveIcons = document.querySelectorAll('.fa-save');

        saveIcons.forEach(icon => {
            icon.addEventListener('click', function(event) {
                event.preventDefault();

                const serviceId = icon.getAttribute('data-id');
                const serviceCard = document.querySelector(`[data-id="${serviceId}"]`).closest('.bg-white');
                const updateForm = serviceCard.querySelector('.update-form');

                updateForm.submit();
            });
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        const deleteLinks = document.querySelectorAll('.delete-service');

        deleteLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();

                if (confirm('Are you sure you want to delete this service?')) {
                    this.closest('.delete-service-form').submit();
                }
            });
        });
    });





</script>
</body>
</html>
