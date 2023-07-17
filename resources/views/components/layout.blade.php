<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="images/mylogo.png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick.css" />
    <!-- Include the Tippy.js library -->
    <script src="https://unpkg.com/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://unpkg.com/tippy.js@6.3.5/dist/tippy-bundle.umd.min.js"></script>
    <script src="https://cdn.tailwindcss.com/2.2.19/tailwind.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

  <script src="//unpkg.com/alpinejs" defer></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
        theme: {
          extend: {
            colors: {
              laravel: '#ef3b2d',
            },
          },
        },
      }
  </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            tippy('.tooltip', {
                allowHTML: true,
                placement: 'bottom',
                theme: 'light',
            });
        });
    </script>
  <title>Reservify | Simply bookings with Reservify</title>
</head>

<body style="" >


<nav class="flex justify-between items-  mt-4 ">
    <div>
        @include('partials._sidebar')
    </div>
    <ul class="flex space-x-6 mr-6 text-lg">
        @auth
            <li>
                <a href="/listings/create" class="ml-4 inline-block">
                    <i class="fas fa-calendar-plus text-teal-500 text-2xl"></i>
                </a>
            </li>
            <li>
                <button id="dropdownNotificationButton" data-dropdown-toggle="dropdownNotification" class="inline-flex items-center text-sm font-medium text-center text-gray-500 hover:text-gray-900 focus:outline-none dark:hover:text-white dark:text-gray-400" type="button">
                    <i class="fas fa-bell text-2xl text-teal-500"></i>

                    <div class="relative flex">
                        <div class="relative inline-flex w-4 h-4 bg-pink-500 rounded-full -top-1 right-2 flex items-center justify-center">
                            <span class="text-xs text-white">{{ auth()->user()->receivedConnectionRequests->count() }}</span>
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
                            @if ($user->sentConnectionRequests->contains(auth()->user()))
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
                                        <button type="submit" class="ml-2 bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-full mt-2 sm:mt-0 sm:ml-4">
                                            Accept Request
                                        </button>

                                    </form>
                                @endif
                            </a>
                            @endif
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
                        <i class="fa-solid fa-door-closed text-teal-500"></i>
                    </button>
                </form>
            </li>
        @else

            <li>
                <a href="/register" class="hover:text-laravel">
                    <i class="text-2xl  fa-solid fa-user-plus text-teal-500"></i>
                </a>
            </li>
            <li>
                <a href="/login" class="hover:text-laravel ">
                    <i class="text-2xl  fa-solid fa-arrow-right-to-bracket text-teal-500"></i>
                </a>
            </li>
        @endauth
    </ul>
</nav>

<main>
    {{$slot}}
  </main>
<div>

</div>
<x-flash-message />
</body>

</html>
