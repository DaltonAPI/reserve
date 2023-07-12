<x-sidbar :filteredUsers="$filteredUsers"/>
<x-layout :filteredUsers="$filteredUsers">
    <div class="flex items-center justify-center  bg-gray-100">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h1 class="text-3xl font-bold mb-6">Manage Reservations</h1>

            @unless($listings->isEmpty())
                <ul class="space-y-4">
                    @foreach($listings as $listing)
                        <li class="flex items-center justify-between">
                            <a href="/listings/{{$listing->id}}" class="text-blue-500 hover:underline">{{ $listing->title }}</a>
                            <div>
                                <a href="/listings/{{$listing->id}}/edit" class="text-blue-500 hover:underline">Edit</a>
                                <form method="POST" action="/listings/{{$listing->id}}" onsubmit="return confirm('Are you sure you want to delete this account?')"   class="inline" >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline ml-2">Delete</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-center">No Listings Found</p>
            @endunless
        </div>
    </div>
</x-layout>
