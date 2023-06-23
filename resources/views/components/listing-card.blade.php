


<div class="container mx-auto gap-4 space-y-4 md:space-y-0 mx-4 mt-4">
    <?php
    $currentDate = date('Y-m-d');
    $listingDate = date('Y-m-d', strtotime($listing->date));
    ?>

    @if ((!isset($_GET['active']) || $_GET['active'] === 'upcoming') && $listingDate >= $currentDate)
        <!-- Display only upcoming listings -->
    <div class=" rounded-lg border border-grey-500 p-6 mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <img class="w-16 h-16 rounded-full mr-4"  src="{{ asset('storage/' . $listing->user->photos) }}" alt="Business Logo">
                <div>
                    <h5 class="text-xl font-bold">{{$listing->user->name }}</h5>
                    <p class="text-gray-500">{{ date('j F, Y', strtotime($listing->date)) }} @ {{ date('h:i A', strtotime($listing->time)) }}</p>
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
        <h2 class="text-2xl font-bold">{{ $listing->title }}</h2>
        <div class="flex items-center justify-between">
            <div class="w-2/3">
                <h3 class="text-gray-700 font-semibold">Customer Details</h3>
                <p class="text-gray-600">Customer Name: <span class="font-semibold">{{ $listing->customer_name }}</span></p>
                <p class="text-gray-600">Customer Email: <span class="font-semibold">{{ $listing->email }}</span></p>
                <p class="text-gray-600">Customer Phone: <span class="font-semibold">{{ $listing->customer_phone }}</span></p>
            </div>
            <div class="w-1/2">
                <div class="mb-4">
                    <h3 class="text-gray-700 font-semibold">Service Expectation</h3>
                    <img class="w-24 h-24" src="{{ asset('storage/' . $listing->logo) }}" alt="Small Image">
                </div>
                <h3 class="text-gray-700 font-semibold">Additional Information</h3>
                <p class="text-gray-600">Note: <span class="font-semibold">{{ $listing->description }}</span></p>
            </div>
        </div>

        <div>
            <div class="flex flex-wrap">
                @foreach(explode(',', $listing->tags) as $tag)
                    <span class="bg-pink-400 text-white rounded-full px-3 py-1 text-sm font-semibold mr-2 mb-2">{{ $tag }}</span>
                @endforeach
            </div>
        </div>

        <div>
            <h3 class="text-xl font-bold">Status</h3>
            <p>{{ $listing->status }}</p>
        </div>
    </div>


    @elseif (isset($_GET['active']) && $_GET['active'] === 'past' && $listingDate < $currentDate)
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <img class="w-16 h-16 rounded-full mr-4" src="https://cdn.pixabay.com/photo/2020/05/18/16/17/social-media-5187243_640.png" alt="Business Logo">
                <div>
                    <h2 class="text-2xl font-bold">{{ $listing->title }}</h2>
                    <p class="text-gray-500">{{ date('j F, Y', strtotime($listing->date)) }} @ {{ date('h:i A', strtotime($listing->time)) }}</p>
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
                <h3 class="text-gray-700 font-semibold">Customer Details</h3>
                <p class="text-gray-600">Customer Name: <span class="font-semibold">{{ $listing->customer_name }}</span></p>
                <p class="text-gray-600">Customer Email: <span class="font-semibold">{{ $listing->email }}</span></p>
                <p class="text-gray-600">Customer Phone: <span class="font-semibold">{{ $listing->customer_phone }}</span></p>
            </div>
            <div class="w-1/2">
                <div class="mb-4">
                    <h3 class="text-gray-700 font-semibold">Service Expectation</h3>
                    <img class="w-24 h-24" src="{{ asset('storage/' . $listing->logo) }}" alt="Small Image">
                </div>
                <h3 class="text-gray-700 font-semibold">Additional Information</h3>
                <p class="text-gray-600">Note: <span class="font-semibold">{{ $listing->description }}</span></p>
            </div>
        </div>

        <div>
            <div class="flex flex-wrap">
                @foreach(explode(',', $listing->tags) as $tag)
                    <span class="bg-pink-400 text-white rounded-full px-3 py-1 text-sm font-semibold mr-2 mb-2">{{ $tag }}</span>
                @endforeach
            </div>
        </div>

        <div>
            <h3 class="text-xl font-bold">Status</h3>
            <p>{{ $listing->status }}</p>
        </div>
    </div>


    @endif


</div>









