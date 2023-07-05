<x-layout :filteredUsers="$filteredUsers">
    <div>



{{--        @include('partials._search')--}}



        <x-sidbar :filteredUsers="$filteredUsers"/>
        <div class="container mx-auto gap-4 mx-4 mt-4 sm:w-3/4 lg:w-2/3 xl:w-1/2">
            <div class="text-center md:text-left">
                @unless(count($filteredUsers) == 0)
                     <x-users :filteredUsers="$filteredUsers"></x-users>
                @endunless

                <h1 class="text-3xl font-bold text-gray-900">
                    Explore Our <span class="text-pink-500">Business List</span>
                </h1>
                <p class="font-semibold text-gray-700 mb-3">
                    Discover Local Businesses Near You
                </p>
            </div>

            @unless(count($filteredUsers) == 0)
                @foreach($filteredUsers as $user)
                    @if($user->account_type === 'Business')
                        <x-business :user="$user" />
                    @elseif(count($filteredUsers) == 0)
                        <p>No listings found</p>
                    @endif
                @endforeach
            @endunless
        </div>

        <div class="mt-6 p-4">
            {{$filteredUsers->links()}}
        </div>
    </div>
</x-layout>
