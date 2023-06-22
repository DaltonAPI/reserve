<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservify</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Helvetica Neue', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100">
<header class="bg-pink-300 text-white py-4">
    <div class="container mx-auto px-4">
        <nav class="flex items-center justify-between">
            <a href="/landing" class=" mt-2">
                <img src="{{asset('images/logo.png')}}" alt="Logo" class="h-2/4 w-24">
            </a>

            <ul class="flex space-x-4">
                <li><a href="/about" class="hover:text-gray-200">About Us</a></li>
                <li><a href="/terms" class="hover:text-gray-200">Terms &amp; Conditions</a></li>
                <li><a href="/privacy" class="hover:text-gray-200">Privacy Policy</a></li>
                <li><a href="/faq" class="hover:text-gray-200">FAQ</a></li>
            </ul>
        </nav>
    </div>
</header>

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
