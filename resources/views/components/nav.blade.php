<nav class="flex justify-between items-center  mt-4 mb-10">
    <div>
        @include('partials._sidebar')
    </div>
    <ul class="flex space-x-6 mr-6 text-lg">
        @auth
            <li>
                <button id="dropdownNotificationButton" data-dropdown-toggle="dropdownNotification" class="inline-flex items-center text-sm font-medium text-center text-gray-500 hover:text-gray-900 focus:outline-none dark:hover:text-white dark:text-gray-400" type="button">
                    <svg class="w-7 h-7" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 14 20">
                        <path d="M12.133 10.632v-1.8A5.406 5.406 0 0 0 7.979 3.57.946.946 0 0 0 8 3.464V1.1a1 1 0 0 0-2 0v2.364a.946.946 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C1.867 13.018 0 13.614 0 14.807 0 15.4 0 16 .538 16h12.924C14 16 14 15.4 14 14.807c0-1.193-1.867-1.789-1.867-4.175ZM3.823 17a3.453 3.453 0 0 0 6.354 0H3.823Z"/>
                    </svg>
                    <div class="relative flex">
                        <div class="relative inline-flex w-4 h-4 bg-pink-500 rounded-full -top-1 right-2 flex items-center justify-center">
                            <span class="text-xs text-white">3</span>
                        </div>
                    </div>
                </button>

                <!-- Dropdown menu -->
                <div id="dropdownNotification" class="z-20 hidden absolute right-0 mt-2 w-full max-w-sm bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-800 dark:divide-gray-700" aria-labelledby="dropdownNotificationButton">
                    <div class="block px-4 py-2 font-medium text-center text-gray-700 rounded-t-lg bg-gray-50 dark:bg-gray-800 dark:text-white">
                        Notifications
                    </div>
                    @foreach($filteredUsers as $user)
                        @if (($user->account_type === 'Client' && auth()->user()->account_type === 'Business') && $user->sentConnectionRequests->contains(auth()->user()) || ($user->account_type === 'Business' && auth()->user()->account_type === 'Client') )
                            <a class="flex items-center px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <div class="flex-shrink-0">
                                    <img class="rounded-full w-10 h-10" src="{{ asset('storage/' . $user->photos) }}" alt="User Avatar">
                                </div>
                                @if($user['client-name'])
                                    <h3 class="ml-3 font-semibold">{{$user['client-name']}}</h3>
                                @elseif($user->name)
                                    <h3 class="ml-3 font-semibold">{{$user->name}}</h3>
                                @endif
                                    @if ($user->sentConnectionRequests->contains(auth()->user()))
                                            <!-- Request received -->
                                            <form method="POST" action="/connections/{{$user->id}}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="ml-2 bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-full mt-2">
                                                    Accept Request
                                                </button>
                                     </form>
                                    @endif
                                </a>
                        @endif
                    @endforeach
                </div>
                <script>
                    const dropdownButton = document.getElementById('dropdownNotificationButton');
                    const dropdownMenu = document.getElementById('dropdownNotification');

                    dropdownButton.addEventListener('click', () => {
                        dropdownMenu.classList.toggle('hidden');
                    });
                </script>
            </li>


            <li>
                <form class="inline" method="POST" action="/logout">
                    @csrf
                    <button type="submit">
                        <i class="fa-solid fa-door-closed text-pink-500"></i>
                    </button>
                </form>
            </li>
        @else

            <li>
                <a href="/register" class="hover:text-laravel">
                    <i class="fa-solid fa-user-plus text-pink-500"></i>
                </a>
            </li>
            <li>
                <a href="/login" class="hover:text-laravel ">
                    <i class="fa-solid fa-arrow-right-to-bracket text-pink-500"></i>
                </a>
            </li>
        @endauth
    </ul>
</nav>
