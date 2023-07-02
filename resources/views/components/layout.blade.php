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

<body class=" bg-gray-100">
<nav class="flex justify-between items-center  mt-4 mb-10">
   <div>
       @include('partials._sidebar')
   </div>
    <ul class="flex space-x-6 mr-6 text-lg">
        @auth
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

<main>
    {{$slot}}
  </main>
<div>

</div>
<x-flash-message />
</body>

</html>
