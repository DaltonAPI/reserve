<x-layout>
    <x-card class="max-w-lg mx-auto">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">Show your work</h2>
            <p class="mb-4">Log into your account to post gigs</p>
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
                <label for="excerpt" class="inline-block text-lg mb-2">Excerpt</label>
                <textarea class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" name="excerpt">{{ old('excerpt') }}</textarea>

                @error('excerpt')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="body" class="inline-block text-lg mb-2">Body</label>
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
            <div class="mb-6">
                <label for="thumbnail" class="inline-block text-lg mb-2">Thumbnail</label>
                <input type="file" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" name="thumbnail" accept="image/*" id="thumbnail-input" onchange="previewImage(event)" />

                <div class="mt-2">
                    <img id="thumbnail-preview" class="w-40 h-40 object-cover rounded-lg border border-gray-300" src="#" alt="Thumbnail Preview" style="display: none;" />
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
</x-layout>
