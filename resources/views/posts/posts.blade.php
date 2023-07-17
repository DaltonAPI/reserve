<x-sidbar :filteredUsers="$filteredUsers"></x-sidbar>
<x-layout :filteredUsers="$filteredUsers">
    <!-- Main content -->
    <div class="md:ml-64">
        <!-- Hero section -->
        <header class="text-white py-4">
            <div class="container mx-auto px-4">
                <h1 class="text-5xl font-bold text-white"><span class="text-pink-500">Discover</span> a World of People Work</h1>
                <p class="text-xl text-gray-900 mt-4">Explore a wide range of videos from <span class="text-pink-500">creators.</span> </p>
            </div>
        </header>
        <div
        >@unless(count($posts) == 0)
                <section class="container mx-auto px-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            <!-- Post cards go here -->
                            @foreach($posts as $post)
                            <x-posts :post="$post"></x-posts>
                            @endforeach
                        </div>
                    </section>
            @else
                <p>No Post found</p>
            @endunless
        </div>
        <div class="mt-6 p-4">
            {{$posts->links()}}
        </div>
    </div>
</x-layout>




