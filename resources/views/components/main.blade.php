<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservify</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
          integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: 'Helvetica Neue', sans-serif;
        }
        @media (max-width: 640px) {
            .hidden {
                display: none !important;
            }

            .mobile-menu {
                display: block;
            }
        }
    </style>
</head>

<body class="bg-gray-100">
<header class="bg-pink-300 text-white py-4">
    <div class="container mx-auto px-4">
        <nav class="flex items-center justify-between">
            <a href="/landing" class="mt-2">
                <img src="{{asset('images/logo.png')}}" alt="Logo" class="h-2/4 w-24">
            </a>

            <div class="sm:hidden">
                <button type="button" class="mobile-menu-button">
                    <i class="fas fa-bars text-white"></i>
                </button>
            </div>

            <ul class="hidden sm:flex space-x-4">
                <li><a href="/about" class="hover:text-gray-200">About Us</a></li>
                <li><a href="/terms" class="hover:text-gray-200">Terms &amp; Conditions</a></li>
                <li><a href="/privacy" class="hover:text-gray-200">Privacy Policy</a></li>
                <li><a href="/faq" class="hover:text-gray-200">FAQ</a></li>
            </ul>
        </nav>

        <div class="mobile-menu hidden">
            <ul class="flex flex-col space-y-2">
                <li><a href="/about" class="hover:text-gray-200">About Us</a></li>
                <li><a href="/terms" class="hover:text-gray-200">Terms &amp; Conditions</a></li>
                <li><a href="/privacy" class="hover:text-gray-200">Privacy Policy</a></li>
                <li><a href="/faq" class="hover:text-gray-200">FAQ</a></li>
            </ul>
        </div>
    </div>
</header>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const mobileMenuButton = document.querySelector(".mobile-menu-button");
        const mobileMenu = document.querySelector(".mobile-menu");

        mobileMenuButton.addEventListener("click", function () {
            mobileMenu.classList.toggle("hidden");
        });

        document.addEventListener("click", function (event) {
            const targetElement = event.target;
            if (!targetElement.closest(".mobile-menu-button") && !targetElement.closest(".mobile-menu")) {
                mobileMenu.classList.add("hidden");
            }
        });
    });
</script>

<div class="">
    {{$slot}}
</div>

<footer class="bg-pink-300 text-gray-700 py-4">
    <div class="container mx-auto px-4">
        <p class="text-center">&copy; 2023 Reservify. All rights reserved.</p>
    </div>
</footer>
</body>

</html>
