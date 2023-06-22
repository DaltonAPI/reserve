
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Add Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="fixed top-0 left-0 inline-flex items-center p-2 mt-2 ml-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
    <span class="sr-only">Open sidebar</span>
    <svg class="w-6 h-6 text-pink-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
    </svg>
</button>

<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transform -translate-x-full sm:translate-x-0 transition-transform ease-in-out duration-300 bg-white border-r-2 border-pink-200">
    <div class="h-full px-3  overflow-y-auto bg-gray-100">
        <ul class="space-y-2 font-medium">
            <li>
                <a href="/" class="flex items-center justify-center mt-2">
                    <img src="{{asset('images/logo.png')}}" alt="Logo" class="h-2/4 w-24">
                </a>

            </li><li>
                <a href="/listings/manage" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
                    <svg aria-hidden="true" class="w-6 h-6 text-pink-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                        <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                    </svg>
                    <span class="ml-3">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="/reservations" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor">
                        <path d="M20.95 10.77a1 1 0 00-1.18-.1l-6.48 3.24-2.9-1.45-3.45 1.73L2 11.38V21h19V10.8c0-.26-.1-.52-.28-.71z"/>
                        <path d="M7 3h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                        <path d="M7 3v2m10-2v2"/>
                    </svg>

                    <span class="ml-3">My Reservations</span>
                </a>
            </li>
            <li>
                <a href="/posts" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-pink-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white">
                        <path d="M6 2.75a.75.75 0 01.75-.75h5.5a.75.75 0 010 1.5h-5.5A.75.75 0 016 2.75zM6 7.25a.75.75 0 01.75-.75h5.5a.75.75 0 010 1.5h-5.5A.75.75 0 016 7.25zM6 11.75a.75.75 0 01.75-.75h5.5a.75.75 0 010 1.5h-5.5a.75.75 0 01-.75-.75zM3.25 7a.75.75 0 01.75-.75h1.5a.75.75 0 010 1.5h-1.5A.75.75 0 013.25 7z" clip-rule="evenodd"></path>
                    </svg>

                    <span class="ml-2">Posts</span>
                </a>
            </li>

            <li>
                <a href="/calendar" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-pink-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <path d="M16 2v4M8 2v4M3 10h14M5 18h4M11 18h4"></path>
                    </svg>



                    <span class="ml-3">Calendar</span>
                </a>
            </li>
        </ul>
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
