<x-sidbar :filteredUsers="$filteredUsers"/>
<x-layout :filteredUsers="$filteredUsers">
    <div class="container mx-auto gap-4  md:space-y-4 mx-4 mt-4 sm:w-3/4 lg:w-2/3 xl:w-1/2 ">
{{--        {{$times->first()->user_id}}--}}
        <x-business :user="$user" ></x-business>
        <h1 > <span>Available Hours for for</span>  <span class=" font-bold ">{{$user->name}}</span></h1>
        <table class="table-auto w-full bg-white shadow-md rounded-lg overflow-hidden ">
            <thead class="bg-pink-300 text-white">
            <tr>
                <th class="px-4 py-2">Day</th>
                <th class="px-4 py-2">Start Time</th>
                <th class="px-4 py-2">End Time</th>
            </tr>
            </thead>
            <tbody>
            @foreach($times as $time)
                <x-time :time="$time"/>
            @endforeach
            </tbody>
        </table>

    </div>
</x-layout>




