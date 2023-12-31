@if (session('success'))
    <div class="bg-green-500 text-white px-4 py-2 rounded-lg mb-3">
        {{ session('success') }}
    </div>
@endif

<div class="bg-black py-3 ">
    <div class="max-w-6xl mx-auto">
        <div class="overflow-x-auto relative">
            <div class="flex items-center">
                <button id="leftButton" class="text-pink px-3 py-2 rounded-l-full absolute top-0 bottom-0 flex items-center">
                    <i class="fas fa-chevron-left text-white bg-pink-500 rounded-full p-2"></i>

                </button>
                <ul id="userList" class="flex space-x-2 overflow-x-auto ">
                    @foreach($filteredUsers as $user)
                        @if($user->account_type === 'Client')
                            <li class="flex  items-center space-x-2 border border-gray-200 p-2 bg-black rounded-lg shadow-md">
                                @if($user->photos)
                                    <div class="w-14 h-14 rounded-full overflow-hidden border-2 border-teal-400">
                                        <img src="{{ asset('storage/' . $user->photos) }}" alt="User Avatar" class="w-full h-full object-cover rounded-full">
                                    </div>
                                @else
                                    <div class="w-14 h-14 rounded-full overflow-hidden border-2 border-teal-400">
                                        <img src="/images/avatar.png" alt="User Avatar" class="w-full h-full object-cover rounded-full">
                                    </div>
                                @endif
                                <h3 class=" font-semibold text-center text-white">{{$user['client-name']}}</h3>
                                @auth
                                    @if (($user->account_type === 'Client' && auth()->user()->account_type === 'Business') || ($user->account_type === 'Business' && auth()->user()->account_type === 'Client') )
                                        @if ($user->sentConnectionRequests->contains(auth()->user()))
                                            <!-- Request received -->
                                            <form method="POST" action="/connections/{{$user->id}}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-full mt-2 whitespace-nowrap text-sm">
                                                    Accept Request
                                                </button>

                                            </form>
                                        @elseif ($user->receivedConnectionRequests->contains(auth()->user()))
                                            <!-- Request sent -->
                                            <button class="bg-gray-500 text-white px-4 py-2 rounded-full mt-2 mt-2 whitespace-nowrap text-sm">
                                                Request Sent
                                            </button>

                                        @elseif ($user->connectedUsers->contains(auth()->user()) || auth()->user()->connectedUsers->contains($user))

                                            <!-- Connected -->
                                            <a href="/calendar/{{$user->id}}/{{auth()->id()}}" class="ml-4 inline-block">
                                                <i class="fas fa-calendar-plus text-teal-500 text-2xl"></i>
                                            </a>
                                        @else
                                            <!-- No connection -->
                                            <form method="POST" action="/connections">
                                                @csrf
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                <button type="submit" >
                                                    <i class="fas fa-user-plus text-pink-500 text-2xl"></i>
                                                </button>
                                            </form>

                                        @endif
                                    @endif
                                @endauth


                            </li>
                        @endif
                    @endforeach

                </ul>
                <button id="rightButton" class=" text-pink px-3 py-2 rounded-r-full absolute top-0 bottom-0 flex items-center right-0">
                    <i class="fas fa-chevron-right text-white bg-pink-500 rounded-full p-2"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    #userList {
        overflow-x: auto;
        scrollbar-width: none; /* Hide scrollbar for Firefox */
        -ms-overflow-style: none; /* Hide scrollbar for IE and Edge */
    }

    #userList::-webkit-scrollbar {
        display: none; /* Hide scrollbar for Chrome, Safari, and Opera */
    }

    @media (max-width: 640px) {
        #userList {
            justify-content: flex-start;
        }
        #userList li {
            margin-right: 12px;
            font-size: 0.8rem; /* Adjust font size for mobile */
        }
        #rightButton, #leftButton {
            padding: 8px;
            opacity: 1 !important; /* Force visibility for mobile if list is scrollable */
        }
    }

    /* Touch Feedback */
    #leftButton:active, #rightButton:active {
        background: rgba(255, 0, 0, 0.1);
    }

    img {
        max-width: 100%;
    }
</style>

<script>
    const leftButton = document.getElementById('leftButton');
    const rightButton = document.getElementById('rightButton');
    const userList = document.getElementById('userList');

    // Function to check if the list is scrollable and show the scroll buttons accordingly
    function checkScrollable() {
        if(userList.scrollWidth > userList.clientWidth) {
            leftButton.style.opacity = "1";
            rightButton.style.opacity = "1";
        }
    }

    leftButton.addEventListener('click', () => {
        userList.scrollBy({
            left: -200,
            behavior: 'smooth'
        });
    });

    rightButton.addEventListener('click', () => {
        userList.scrollBy({
            left: 200,
            behavior: 'smooth'
        });
    });

    window.addEventListener('resize', checkScrollable);
    window.addEventListener('load', checkScrollable);
</script>

