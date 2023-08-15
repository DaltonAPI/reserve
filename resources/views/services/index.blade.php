<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Services</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-black min-h-screen flex items-center justify-center">
<div class="w-full max-w-screen-xl p-6 bg-white rounded-lg shadow-xl flex">
    <div class="w-1/2 pr-4">
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

            <div class="mb-4">
                <label for="serviceDescription" class="block text-sm font-medium text-gray-900">Service Description</label>
                <textarea name="description" id="serviceDescription" rows="3" class="w-full p-2 mt-1 border rounded-md focus:outline-none focus:ring focus:border-blue-300">{{ old('description') }}</textarea>
                @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full py-2 text-white bg-blue-500 hover:bg-blue-600 rounded-md">Add Service</button>
        </form>

    </div>

    <div class="w-1/2 pl-4 overflow-y-auto" style="max-height: 500px;">
        <h2 class="text-lg font-semibold mb-4">Services List</h2>
        @foreach($services as $service)
            <div class="mb-4 bg-white rounded-lg shadow-lg transition-transform transform ">
                <!-- Header -->
                <div class="bg-gradient-to-r from-pink-500 to-blue-600 p-3 rounded-t-lg">
                    <h3 class="text-white font-semibold text-lg">{{ $service->name }}</h3>
                </div>

                <!-- Body -->
                <div class="p-3">
                    <p class="mb-1 flex items-center">
                        <span class="w-20 font-medium text-sm">Duration:</span>
                        <span>{{ $service->duration }} mins</span>
                    </p>
                    <p class="mb-1 flex items-center">
                        <span class="w-20 font-medium text-sm">Price:</span>
                        <span>${{ number_format($service->price, 2) }}</span>
                    </p>
                    <p class="flex items-start">
                        <span class="w-20 font-medium text-sm align-top">Desc:</span>
                        <span class="text-sm">{{ $service->description }}</span>
                    </p>
                </div>

                <!-- Footer -->
                <div class="flex justify-end bg-gray-100 p-3 rounded-b-lg">
                    <a href="#" class="text-blue-500 hover:text-blue-600 hover:underline text-sm mr-2">Edit</a>
                    <a href="#" class="text-red-500 hover:text-red-600 hover:underline text-sm">Delete</a>
                </div>
            </div>
        @endforeach
    </div>



</div>

<script>

</script>
</body>
</html>
