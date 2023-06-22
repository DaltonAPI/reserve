<x-main>
    <section class="hero bg-cover bg-center py-20 bg-pink-300">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl md:text-6xl text-white font-bold mb-6">Create and Manage Reservations for Your Small Business</h1>
            <p class="text-lg text-white mb-8">A web app designed to help small business owners and customers connect.</p>
            <a href="/landing" class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded">Get Started</a>
        </div>
    </section>


    <!-- Business Listings Section -->
    <section class="bg-white py-16">
        <div class="container mx-auto">
            <div class="flex flex-col md:flex-row items-center justify-center">
                <div class="md:w-1/2">
                    <h2 class="text-3xl md:text-4xl text-gray-800 font-bold mb-6">Business Listings</h2>
                    <p class="text-gray-600 mb-6">Discover a variety of small businesses in our visually appealing directory. Each listing includes business name, description, contact details, location, operating hours, and available services.</p>
                    <a href="/landing" class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded">Explore Listings</a>
                </div>

                <div class="md:w-1/2">
                    <img src="{{asset('images/listings.png')}}" alt="Small Business Listing" class="w-1/2 md:w-3/4 mx-auto mb-8 md:mb-0">
                </div>


            </div>
        </div>
    </section>

    <!-- Search and Filters Section -->
    <section class="bg-gray-100 py-16">
        <div class="container mx-auto">
            <div class="flex flex-col md:flex-row items-center justify-center">
                <div class="md:w-1/2">
                    <img src="{{asset('images/glass.png')}}" alt="Small Business Listing" class="w-1/2 md:w-3/4 mx-auto mb-8 md:mb-0">
                </div>
                <div class="md:w-1/2 md:ml-8">
                    <h2 class="text-3xl md:text-4xl text-gray-800 font-bold mb-6">Search and Filters</h2>
                    <p class="text-gray-600 mb-6">Easily find businesses based on keywords, categories, or location using our intuitive search bar. Refine your search results with advanced filtering options.</p>
                    <a href="/landing" class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded">Start Searching</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Business Profiles Section -->
    <section class="bg-white py-16">
        <div class="container mx-auto">
            <div class="flex flex-col md:flex-row items-center justify-center">
                <div class="md:w-1/2">
                    <h2 class="text-3xl md:text-4xl text-gray-800 font-bold mb-6">Business Profiles</h2>
                    <p class="text-gray-600 mb-6">Explore dedicated profile pages for each business. Get detailed information about their services, pricing, reviews, and ratings. High-quality images and videos give you a better understanding of what each business offers.</p>
                    <a href="/landing" class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded">View Profiles</a>
                </div>
                <div class="md:w-1/2">
                    <img src="{{asset('images/profile.png')}}" alt="Small Business Listing" class="w-1/2 md:w-3/4 mx-auto mb-8 md:mb-0">
                </div>
            </div>
        </div>
    </section>

    <!-- Reservation System Section -->
    <section class="bg-gray-100 py-16">
        <div class="container mx-auto">
            <div class="flex flex-col md:flex-row items-center justify-center">
                <div class="md:w-1/2">
                    <img src="{{asset('images/calendar.png')}}" alt="Small Business Listing" class="w-1/2 md:w-3/4 mx-auto mb-8 md:mb-0">
                </div>
                <div class="md:w-1/2 md:ml-8">
                    <h2 class="text-3xl md:text-4xl text-gray-800 font-bold mb-6">Reservation System</h2>
                    <p class="text-gray-600 mb-6">Make reservations hassle-free with our user-friendly system. Choose your preferred date and time using the calendar or time slots. Capture necessary details with a simple form and receive confirmation notifications.</p>
                    <a href="/landing" class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded">Make a Reservation</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Reviews and Ratings Section -->
    <section class="bg-white py-16">
        <div class="container mx-auto">
            <div class="flex flex-col md:flex-row items-center justify-center">
                <div class="md:w-1/2">
                    <h2 class="text-3xl md:text-4xl text-gray-800 font-bold mb-6">Reviews and Ratings</h2>
                    <p class="text-gray-600 mb-6">Share your experiences and help others make informed decisions. Leave reviews and ratings for businesses you've utilized. All reviews and ratings are displayed on business profiles.</p>
                    <a href="/landing" class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded">Write a Review</a>
                </div>
                <div class="md:w-1/2">
                    <img src="{{asset('images/star.png')}}" alt="Small Business Listing" class="w-1/2 md:w-3/4 mx-auto mb-8 md:mb-0">
                </div>
            </div>
        </div>
    </section>

    <!-- Notifications and Reminders Section -->
    <section class="bg-gray-100 py-16">
        <div class="container mx-auto">
            <div class="flex flex-col md:flex-row items-center justify-center">
                <div class="md:w-1/2">
                    <img src="{{asset('images/bell.png')}}" alt="Small Business Listing" class="w-1/2 md:w-3/4 mx-auto mb-8 md:mb-0">
                </div>
                <div class="md:w-1/2 md:ml-8">
                    <h2 class="text-3xl md:text-4xl text-gray-800 font-bold mb-6">Notifications and Reminders</h2>
                    <p class="text-gray-600 mb-6">Stay informed about your upcoming reservations. Receive automated notifications and reminders. Business owners also get notified about their upcoming appointments or bookings.</p>
                    <a href="/landing" class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded">Manage Reservations</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Payment Integration Section -->
    <section class="bg-white py-16">
        <div class="container mx-auto">
            <div class="flex flex-col md:flex-row items-center justify-center">
                <div class="md:w-1/2">
                    <h2 class="text-3xl md:text-4xl text-gray-800 font-bold mb-6">Payment Integration</h2>
                    <p class="text-gray-600 mb-6">Make online payments for your reservations seamlessly. Our secure payment system supports various payment options such as credit cards, PayPal, and other popular gateways.</p>
                    <a href="/landing" class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded">Make a Payment</a>
                </div>
                <div class="md:w-1/2">
                    <img src="{{asset('images/card.png')}}" alt="Small Business Listing" class="w-1/2 md:w-3/4 mx-auto mb-8 md:mb-0">
                </div>
            </div>
        </div>
    </section>

</x-main>



