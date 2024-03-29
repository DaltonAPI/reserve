<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Add Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Add Font Awesome -->
    <script src="https://kit.fontawesome.com/your-font-awesome-kit.js" crossorigin="anonymous"></script>

    <style>
        body {
            background-color: black;
        }
        li span,.me{
            color: white !important;
        }
    </style>
</head>
<body>
<button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="fixed top-0 left-0 inline-flex items-center p-2 mt-2 ml-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
    <span class="sr-only">Open sidebar</span>
    <i class="fas fa-bars text-teal-500 text-2xl"></i>
</button>

<aside id="logo-sidebar"  class="fixed top-0 left-0 z-40 w-64 h-screen transform -translate-x-full sm:translate-x-0 transition-transform ease-in-out duration-300    border-r border-white">
    <div class="h-full px-3  overflow-y-auto bg-black">
        <ul class="space-y-2 font-medium">
            <li>
                <a href="/" class="flex items-center justify-center mt-2">
                    <img src="{{asset('images/logo.png')}}" alt="Logo" class="h-2/4 w-24">
                </a>
            </li>

            <li>
                @auth
                    <a href="/getTime/{{auth()->user()->id}}">
                        <section class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="relative inline-block">
                                    @if(auth()->user()->photos)
                                        <img src="{{ asset('storage/' . auth()->user()->photos) }}" alt="User Avatar" class="w-8 h-8 rounded-full">
                                    @else
                                        <img src="{{ asset('/images/avatar.png') }}" alt="Default Image" class="w-8 h-8 rounded-full">
                                    @endif
                                    <div class="absolute inset-0 flex items-center justify-center border-2 border-teal-500 rounded-full"></div>
                                </div>

                            @if( auth()->user()->name )
                                    <h2 class="ml-1 font-bold me">{{ auth()->user()->name }}</h2>
                                @elseif(auth()->user()->getAttribute('client-name'))
                                    <h2 class="ml-1 font-bold me">{{auth()->user()->getAttribute('client-name') }}</h2>
                                @endif
                            </div>
                        </section>
                    </a>
                @endauth
            </li>

            <li>
                <a href="/listings/manage" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-600">
                    <i class="fas fa-tachometer-alt text-teal-500"></i>
                    <span class="ml-3">Dashboard</span>
                </a>
            </li>
            <li>
                @auth
                <a href="/reservations/{{auth()->user()->id}}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-600">
                    <i class="fas fa-calendar-check text-teal-500"></i>
                    <span class="ml-3">My Reservations </span>
                </a>
                @endauth
            </li>
            <li>
                <a href="/posts" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-600">
                    <i class="fas fa-newspaper text-teal-500"></i>
                    <span class="ml-2">Posts</span>
                </a>
            </li>
            <li>
                @auth
                <a href="/calendar/{{auth()->user()->id}}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-600">
                    <i class="fas fa-calendar-alt text-teal-500"></i>
                    <span class="ml-2">Calendar</span>
                </a>
                @endauth
            </li>

            <li>
                <a href="/landing" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-600">
                    <i class="fas fa-building text-teal-500"></i>
                    <span class="ml-3">Business List</span>
                </a>
            </li>


            <li>
                @auth
                    @if (auth()->user()->id )
                        <a href="/create"
                           class=" inline-block px-4 py-2 leading-none text-white bg-gradient-to-r from-pink-300 to-pink-600 rounded hover:bg-blue-700">Upload your work</a>
                    @endif
                @endauth
            </li>

        </ul>


        <x-connectedUsers :filteredUsers="$filteredUsers"/>

    </div>
</aside>

<script>
    const logoSidebar = document.getElementById('logo-sidebar');
    const sidebarToggle = document.querySelector('[data-drawer-toggle="logo-sidebar"]');

    sidebarToggle.addEventListener('click', () => {
        const expanded = sidebarToggle.getAttribute('aria-expanded') === 'true' || false;
        sidebarToggle.setAttribute('aria-expanded', !expanded);
        logoSidebar.classList.toggle('-translate-x-full');
    });

    // Get the sidebar element
    const sidebar = document.getElementById('logo-sidebar');

    // Get the button element that toggles the sidebar
    const toggleButton = document.querySelector('[data-drawer-toggle="logo-sidebar"]');

    // Function to handle clicks outside the sidebar
    const handleOutsideClick = (event) => {
        // Check if the clicked element is outside the sidebar and toggle button
        if (!sidebar.contains(event.target) && !toggleButton.contains(event.target)) {
            // Remove the sidebar
            sidebar.classList.remove('translate-x-0');
            sidebar.classList.add('-translate-x-full');
        }
    };

    // Event listener for clicks on the document
    document.addEventListener('click', handleOutsideClick);
</script>

</body>
</html>
