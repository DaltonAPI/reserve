<x-layout>
    <div >
        @include('partials._search')
        <div class="container mx-auto gap-4 space-y-4 md:space-y-0 mx-4 mt-4 sm:w-3/4 lg:w-2/3 xl:w-1/2"
        ><x-business :user="$user" ></x-business>
            <x-calendar :reservationData="$reservationData" />
        </div>
    </div>
</x-layout>















