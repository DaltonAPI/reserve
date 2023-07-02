

<div class="bg-gray-100 py-6">
    <div class="max-w-6xl mx-auto">
        <div class="overflow-x-auto relative">
            <div class="flex items-center">
                <button id="leftButton" class="text-pink px-3 py-2 rounded-l-full absolute top-0 bottom-0 flex items-center">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <ul id="userList" class="flex space-x-4 overflow-x-auto">
                    @foreach($filteredUsers as $user)
                        @if($user->account_type === 'Client')
                            <li class="flex  items-center space-x-1">
                                <div class="w-14 h-14 rounded-full overflow-hidden border-2 border-teal-400">
                                    <img src="https://cdn.pixabay.com/photo/2016/01/13/22/46/boy-1139042_640.jpg" alt="User Avatar" class="w-full h-full object-cover rounded-full">
                                </div>
                                <h3 class=" font-semibold text-center ">{{$user['client-name']}}</h3>
                                <button class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-full mt-2">
                                    Connect
                                </button>
                            </li>
                        @endif
                    @endforeach

                </ul>
                <button id="rightButton" class=" text-pink px-3 py-2 rounded-r-full absolute top-0 bottom-0 flex items-center right-0">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    #userList {
        overflow-x: auto;
        scrollbar-width: none; /* Hide the scrollbar for modern browsers */
        -ms-overflow-style: none; /* Hide the scrollbar for IE and Edge */
    }

    #userList::-webkit-scrollbar {
        display: none; /* Hide the scrollbar for Chrome, Safari, and Opera */
    }

    @media (max-width: 640px) {
        #userList {
            justify-content: flex-start;
        }
        #userList li {
            margin-right: 12px;
        }
        #rightButton, #leftButton {
            padding: 8px;
        }
    }
</style>

<script>
    const leftButton = document.getElementById('leftButton');
    const rightButton = document.getElementById('rightButton');
    const userList = document.getElementById('userList');

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
</script>

