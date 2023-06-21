<x-layout>
    <div >

        @include('partials._search')
        <div class="container mx-auto gap-4 space-y-4 md:space-y-0 mx-4 mt-4 sm:w-3/4 lg:w-2/3 xl:w-1/2"
        >
            @unless(count($posts) == 0)

                @foreach($posts as $post)
                    <x-posts :post="$post"></x-posts>
                @endforeach
            @else
                <p>No listings found</p>
            @endunless
        </div>

{{--        <div class="mt-6 p-4">--}}
{{--            {{$posts->links()}}--}}
{{--        </div>--}}

    </div>
</x-layout>
