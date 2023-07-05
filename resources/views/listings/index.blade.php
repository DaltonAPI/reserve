<x-layout :filteredUsers="$filteredUsers">
    <div >
        <x-sidbar :filteredUsers="$filteredUsers"/>
        <div class="container mx-auto gap-4 space-y-4 md:space-y-0 mx-4 mt-4 sm:w-3/4 lg:w-2/3 xl:w-1/2"
        >
            <x-business :user="$user" ></x-business>

            @unless(count($listings) == 0)
                <div class="mx-auto">
                    <div class="border-t-4 border-pink-300 rounded-t-lg">
                        <div class="flex">
                            <button class="flex-1 py-2 px-4 <?php echo isset($_GET['active']) && $_GET['active'] === 'upcoming' ? 'bg-pink-300 text-white' : 'bg-gray-100 text-gray-700'; ?> rounded-tr-lg font-semibold focus:outline-none" onclick="location.href='?active=upcoming'">Upcoming Events</button>
                            <button class="flex-1 py-2 px-4 <?php echo isset($_GET['active']) && $_GET['active'] === 'past' ? 'bg-pink-300 text-white' : 'bg-gray-100 text-gray-700'; ?> rounded-tl-lg font-semibold focus:outline-none" onclick="location.href='?active=past'">Past Reservations</button>
                        </div>
                    </div>
                </div>
                @foreach($listings as $listing)
                    <x-listing-card  :listing="$listing" />
                @endforeach
            @else
                <p>No listings found</p>
            @endunless
        </div>
        <div class="mt-6 p-4">
            {{$listings->links()}}
        </div>
    </div>
</x-layout>
