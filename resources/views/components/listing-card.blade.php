


<div class="container mx-auto gap-4 space-y-4 md:space-y-0 mx-4 mt-4">
    <?php
    $currentDate = date('Y-m-d');
    $listingDate = date('Y-m-d', strtotime($listing->date));
    ?>

    @if ((!isset($_GET['active']) || $_GET['active'] === 'upcoming') && $listingDate >= $currentDate)
        <!-- Display only upcoming listings -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <img class="w-16 h-16 rounded-full mr-4"  src="{{ asset('storage/' . $listing->user->photos) }}" alt="Business Logo">
                <div>
                    @if($listing->user->name)
                    <h2 class=" font-bold">{{ $listing->user->name }}</h2>
                    @else
                        <h2 class=" font-bold">{{ $listing->user['client-name'] }}</h2>
                    @endif
                    <p class="text-gray-500" style="font-size: x-small">{{ date('j F, Y', strtotime($listing->date)) }} @ {{ date('h:i A', strtotime($listing->time)) }}</p>
                </div>
            </div>
            <div class="flex items-center">
                @if ($listing->status === 'cancelled')
                    <div>
                        <div class="tooltip" data-tippy-content="Edit Reservation">
                            <a href="/listings/{{ $listing->id }}/edit" class="text-white py-2 px-4 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#FF9CB3" class="h-6 w-6 inline-block mr-1 -mt-1">
                                    <path d="M5 14.14V16h1.86l8.02-8.02-1.86-1.86L5 14.14zm11.72-9.44c.39-.39.39-1.02 0-1.41l-1.85-1.85c-.39-.39-1.02-.39-1.41 0l-1.22 1.22 3.26 3.26 1.22-1.22zM3.41 17.58l3.26 3.26 1.41-1.41L4.83 16H3v-1.83l-1.41-1.41zM16.59 4L20 7.41 17.41 10l-3.42-3.41L16.59 4zM2 18h16v2H2v-2z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @elseif ($listing->status === 'confirmed')
                    <div>
                        <form action="/reservations/{{ $listing->id }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="tooltip" data-tippy-content="Cancel Reservation">
                                <button type="submit" class="text-white rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#FF9CB3" class="h-8 w-8 inline-block mr-1 -mt-1">
                                        <path d="M5.293 4.293a1 1 0 011.414 0L10 8.586l3.293-3.293a1 1 0 011.414 1.414L11.414 10l3.293 3.293a1 1 0 01-1.414 1.414L10 11.414l-3.293 3.293a1 1 0 01-1.414-1.414L8.586 10 5.293 6.707a1 1 0 010-1.414z"/>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <div>
                        <div class="tooltip" data-tippy-content="Edit Reservation">
                            <a href="/listings/{{ $listing->id }}/edit" class="text-white py-2 px-4 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#FF9CB3" class="h-6 w-6 inline-block ">
                                    <path d="M5 14.14V16h1.86l8.02-8.02-1.86-1.86L5 14.14zm11.72-9.44c.39-.39.39-1.02 0-1.41l-1.85-1.85c-.39-.39-1.02-.39-1.41 0l-1.22 1.22 3.26 3.26 1.22-1.22zM3.41 17.58l3.26 3.26 1.41-1.41L4.83 16H3v-1.83l-1.41-1.41zM16.59 4L20 7.41 17.41 10l-3.42-3.41L16.59 4zM2 18h16v2H2v-2z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div>
                        <form action="/reservations/{{ $listing->id }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="tooltip" data-tippy-content="Cancel Reservation">
                                <button type="submit" class="text-white  rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#FF9CB3" class="h-8 w-8 inline-block ">
                                        <path d="M5.293 4.293a1 1 0 011.414 0L10 8.586l3.293-3.293a1 1 0 011.414 1.414L11.414 10l3.293 3.293a1 1 0 01-1.414 1.414L10 11.414l-3.293 3.293a1 1 0 01-1.414-1.414L8.586 10 5.293 6.707a1 1 0 010-1.414z"/>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>

        </div>

        <div class="flex items-center justify-between">
            <div class="w-2/3">
                <p class="text-gray-600">Type of Service: <span class="font-semibold"> {{ $listing->title }} </span></p>
                @if ($listing->customer_name)
                    <p class="text-gray-600">Customer Name: <span class="font-semibold">{{ $listing->customer_name }}</span></p>
                @endif
                @if ($listing->email)
                    <p class="text-gray-600">Customer Email: <span class="font-semibold">{{ $listing->email }}</span></p>
                @endif
                @if ($listing->customer_phone)
                    <p class="text-gray-600">Customer Phone: <span class="font-semibold">{{ $listing->customer_phone }}</span></p>
                @endif
            </div>
            <div class="w-1/2">
                @if ($listing->logo)
                <div class="mb-4">
                    <h3 class="text-gray-700 font-semibold">Service Expectation</h3>
                    <img class="w-24 h-24" src="{{ asset('storage/' . $listing->logo) }}" alt="Small Image">
                </div>
                @endif
                @if ($listing->description)
                    <h3 class="text-gray-700 font-semibold">Additional Information</h3>
                    <p class="text-gray-600">Note: <span class="font-semibold">{{ $listing->description }}</span></p>
                @endif
            </div>
        </div>

        <div>
            @if ($listing->tags)
            <div class="flex flex-wrap">
                @foreach(explode(',', $listing->tags) as $tag)
                    <span class="bg-pink-400 text-white rounded-full px-3 py-1 text-sm font-semibold mr-2 mb-2">{{ $tag }}</span>
                @endforeach
            </div>
            @endif
        </div>


        <div class="bg-gray-100 p-4 rounded">
            <h3 class=" font-bold">Status</h3>
            <p class="text-base text-gray-800">{{ $listing->status }}</p>
        </div>
    </div>


    @elseif (isset($_GET['active']) && $_GET['active'] === 'past' && $listingDate < $currentDate)
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <img class="w-16 h-16 rounded-full mr-4"  src="{{ asset('storage/' . $listing->user->photos) }}" alt="Business Logo">
                <div>
                    <h2 class=" font-bold">{{ $listing->user->name }}</h2>
                    <p class="text-gray-500" style="font-size: x-small">{{ date('j F, Y', strtotime($listing->date)) }} @ {{ date('h:i A', strtotime($listing->time)) }}</p>
                </div>
            </div>
            <div class="flex items-center">
                @if ($listing->status === 'cancelled')
                    <div>
                        <div class="tooltip" data-tippy-content="Edit Reservation">
                            <a href="/listings/{{ $listing->id }}/edit" class="text-white py-2 px-4 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#FF9CB3" class="h-6 w-6 inline-block mr-1 -mt-1">
                                    <path d="M5 14.14V16h1.86l8.02-8.02-1.86-1.86L5 14.14zm11.72-9.44c.39-.39.39-1.02 0-1.41l-1.85-1.85c-.39-.39-1.02-.39-1.41 0l-1.22 1.22 3.26 3.26 1.22-1.22zM3.41 17.58l3.26 3.26 1.41-1.41L4.83 16H3v-1.83l-1.41-1.41zM16.59 4L20 7.41 17.41 10l-3.42-3.41L16.59 4zM2 18h16v2H2v-2z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @elseif ($listing->status === 'confirmed')
                    <div>
                        <form action="/reservations/{{ $listing->id }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="tooltip" data-tippy-content="Cancel Reservation">
                                <button type="submit" class="text-white rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#FF9CB3" class="h-8 w-8 inline-block mr-1 -mt-1">
                                        <path d="M5.293 4.293a1 1 0 011.414 0L10 8.586l3.293-3.293a1 1 0 011.414 1.414L11.414 10l3.293 3.293a1 1 0 01-1.414 1.414L10 11.414l-3.293 3.293a1 1 0 01-1.414-1.414L8.586 10 5.293 6.707a1 1 0 010-1.414z"/>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <div>
                        <div class="tooltip" data-tippy-content="Edit Reservation">
                            <a href="/listings/{{ $listing->id }}/edit" class="text-white py-2 px-4 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#FF9CB3" class="h-6 w-6 inline-block ">
                                    <path d="M5 14.14V16h1.86l8.02-8.02-1.86-1.86L5 14.14zm11.72-9.44c.39-.39.39-1.02 0-1.41l-1.85-1.85c-.39-.39-1.02-.39-1.41 0l-1.22 1.22 3.26 3.26 1.22-1.22zM3.41 17.58l3.26 3.26 1.41-1.41L4.83 16H3v-1.83l-1.41-1.41zM16.59 4L20 7.41 17.41 10l-3.42-3.41L16.59 4zM2 18h16v2H2v-2z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div>
                        <form action="/reservations/{{ $listing->id }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="tooltip" data-tippy-content="Cancel Reservation">
                                <button type="submit" class="text-white  rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#FF9CB3" class="h-8 w-8 inline-block ">
                                        <path d="M5.293 4.293a1 1 0 011.414 0L10 8.586l3.293-3.293a1 1 0 011.414 1.414L11.414 10l3.293 3.293a1 1 0 01-1.414 1.414L10 11.414l-3.293 3.293a1 1 0 01-1.414-1.414L8.586 10 5.293 6.707a1 1 0 010-1.414z"/>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>

        </div>

            <div class="flex items-center justify-between">
                <div class="w-2/3">

                    <p class="text-gray-600">Type of Service: <span class="font-semibold"> {{ $listing->title }} </span></p>
                    @if ($listing->customer_name)
                        <p class="text-gray-600">Customer Name: <span class="font-semibold">{{ $listing->customer_name }}</span></p>
                    @endif
                    @if ($listing->email)
                        <p class="text-gray-600">Customer Email: <span class="font-semibold">{{ $listing->email }}</span></p>
                    @endif
                    @if ($listing->customer_phone)
                        <p class="text-gray-600">Customer Phone: <span class="font-semibold">{{ $listing->customer_phone }}</span></p>
                    @endif
                </div>
                <div class="w-1/2">
                    @if ($listing->logo)
                        <div class="mb-4">
                            <h3 class="text-gray-700 font-semibold">Service Expectation</h3>
                            <img class="w-24 h-24" src="{{ asset('storage/' . $listing->logo) }}" alt="Small Image">
                        </div>
                    @endif
                    @if ($listing->description)
                        <h3 class="text-gray-700 font-semibold">Additional Information</h3>
                        <p class="text-gray-600">Note: <span class="font-semibold">{{ $listing->description }}</span></p>
                    @endif
                </div>
            </div>

            <div>
                @if ($listing->tags)
                    <div class="flex flex-wrap">
                        @foreach(explode(',', $listing->tags) as $tag)
                            <span class="bg-pink-400 text-white rounded-full px-3 py-1 text-sm font-semibold mr-2 mb-2">{{ $tag }}</span>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="bg-gray-100 p-4 rounded">
                <h3 class=" font-bold">Status</h3>
                <p class="text-base text-gray-800">{{ $listing->status }}</p>
            </div>

        </div>


    @endif


</div>









