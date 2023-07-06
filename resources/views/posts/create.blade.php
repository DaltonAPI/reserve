
    <x-card class="max-w-lg mx-auto">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">Show your work</h2>
            <p class="mb-4">Create a post so people can see what you do</p>
        </header>

        <form method="POST" action="/createPost" enctype="multipart/form-data">
            @csrf

            <div class="mb-6">
                <label for="title" class="inline-block text-lg mb-2">Title</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" name="title" value="{{ old('title') }}" />

                @error('title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>



            <div class="mb-6">
                <label for="body" class="inline-block text-lg mb-2">description</label>
                <textarea class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" name="body">{{ old('body') }}</textarea>

                @error('body')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="price" class="inline-block text-lg mb-2">Price</label>
                <input type="number" step="0.01" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" name="price" value="{{ old('price') }}" />

                @error('price')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <!-- Thumbnail -->
            <div class="mb-6">
{{--                <label for="thumbnail" class="inline-block text-lg mb-2">Thumbnail</label>--}}
                <div class="relative">
                    <label for="thumbnail-input" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 cursor-pointer">
                        <input type="file" class="hidden" name="thumbnail" accept="image/*, video/*" id="thumbnail-input" onchange="previewMedia(event)" value="{{ old('thumbnail') }}" />
                        <div class="flex items-center justify-center">
                            <svg id="upload-icon" xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 4a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V4zm2-1a1 1 0 00-1 1v2a1 1 0 001 1h10a1 1 0 001-1V4a1 1 0 00-1-1H5z" clip-rule="evenodd" />
                                <path d="M10 9a2 2 0 100-4 2 2 0 000 4z" />
                            </svg>
                        </div>
                        <span class="ml-3 text-red-400" style="font-size: x-small">Upload Image or Video(max size(70 mb)</span>
                    </label>
                </div>
                <div class="mt-2">
                    <div id="thumbnail-preview" class="w-40 h-40 object-cover rounded-lg border border-gray-300" style="display: none;"></div>
                </div>
                @error('thumbnail')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>




            <div class="mb-6">
                <button type="submit" class="w-full text-gray-900 bg-pink-500 hover:bg-pink-300 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5">Submit</button>
            </div>
        </form>
    </x-card>

<script>
    function previewMedia(event) {
        const file = event.target.files[0];
        const thumbnailPreview = document.getElementById('thumbnail-preview');
        const uploadIcon = document.getElementById('upload-icon');

        thumbnailPreview.innerHTML = ''; // Clear previous preview content

        if (file.type.startsWith('image/')) {
            const img = document.createElement('img');
            img.classList.add('w-40', 'h-40', 'object-cover', 'rounded-lg', 'border', 'border-gray-300');
            img.src = URL.createObjectURL(file);
            thumbnailPreview.appendChild(img);
        } else if (file.type.startsWith('video/')) {
            const video = document.createElement('video');
            video.classList.add('w-40', 'h-40', 'object-cover', 'rounded-lg', 'border', 'border-gray-300');
            video.src = URL.createObjectURL(file);
            video.controls = true;
            thumbnailPreview.appendChild(video);
        }

        thumbnailPreview.style.display = 'block';
        uploadIcon.classList.add('animate-spin'); // Start the spin animation

        // Simulate file upload delay
        setTimeout(function() {
            uploadIcon.classList.remove('animate-spin'); // Stop the spin animation
        }, 2000); // Replace this with your actual file upload logic
    }


</script>
