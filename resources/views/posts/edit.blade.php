<x-layout>
    <x-card class="max-w-lg mx-auto">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">Update Post</h2>
            <p class="mb-4">Edit the post details</p>
        </header>

        <form method="POST" action="/updatePost/{{ $post->id }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="mb-6">
                <label for="title" class="inline-block text-lg mb-2">Title</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" name="title" value="{{ $post->title }}" />
                @error('title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

{{--            <!-- Excerpt -->--}}
{{--            <div class="mb-6">--}}
{{--                <label for="excerpt" class="inline-block text-lg mb-2">Excerpt</label>--}}
{{--                <textarea class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" name="excerpt">{{ $post->excerpt }}</textarea>--}}
{{--                @error('excerpt')--}}
{{--                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>--}}
{{--                @enderror--}}
{{--            </div>--}}

            <!-- Body -->
            <div class="mb-6">
                <label for="body" class="inline-block text-lg mb-2">Body</label>
                <textarea class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" name="body">{{ $post->body }}</textarea>
                @error('body')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price -->
            <div class="mb-6">
                <label for="price" class="inline-block text-lg mb-2">Price</label>
                <input type="number" step="0.01" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" name="price" value="{{ $post->price }}" />
                @error('price')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Thumbnail -->
            <div class="mb-6">
                <label for="thumbnail" class="inline-block text-lg mb-2">Thumbnail</label>
                <div class="relative">
                    <label for="thumbnail-input" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 cursor-pointer">
                        <input type="file" class="hidden" name="thumbnail" accept="image/*" id="thumbnail-input" onchange="previewImage(event)" />
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
                    <img id="thumbnail-preview" class="w-40 h-40 object-cover rounded-lg border border-gray-300" src="{{ asset('storage/' . $post->thumbnail) }}" alt="Thumbnail Preview" />
                </div>
                @error('thumbnail')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>



            <!-- Submit Button -->
            <div class="mb-6">
                <button type="submit" class="w-full text-gray-900 bg-pink-500 hover:bg-pink-300 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5">Update</button>
            </div>
        </form>
    </x-card>
</x-layout>

<script>



    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('thumbnail-preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '#';
        }
    }
</script>
