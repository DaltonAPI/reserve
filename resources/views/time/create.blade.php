<x-sidbar :filteredUsers="$filteredUsers"/>

<x-layout :filteredUsers="$filteredUsers">
    <style>


        .grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 10px;
        }

        @media (min-width: 768px) {
            .grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .flex {
            display: flex;
            align-items: center;
        }

        .form-checkbox {
            /* Add your checkbox styles here */
        }

        .checkbox-size {
            /* Add your checkbox size styles here */
        }

        .text-lg {
            font-size: 1.125rem;
        }

        .font-bold {
            font-weight: bold;
        }

        .mb-1 {
            margin-bottom: 0.25rem;
        }

        .w-full {
            width: 100%;
        }

        .bg-white {
            background-color: #fff;
        }

        .rounded-md {
            border-radius: 0.375rem;
        }

        .p-2 {
            padding: 0.5rem;
        }

        .hidden {
            display: none;
        }

        .md\:hidden {
            display: none;
        }

        @media (max-width: 767px) {
            .hidden-mobile {
                display: none;
            }

            .md\:hidden-mobile {
                display: block;
            }
        }
    </style>

    <div class="mx-auto gap-4 md:space-y-4 mx-4 mt-4 sm:w-3/4 lg:w-2/3 xl:w-1/2 p-4">
        <h1 class="text-3xl font-bold mb-4 text-center">Choose your available hours</h1>
        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-red-500">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="/addtimes" method="POST">
            @csrf
            <div class="grid grid-cols-4 gap-4">
                <div></div>
                <div>
                    <label for="start" class="block text-lg font-bold mb-1">Start Time</label>
                </div>
                <div>
                    <label for="end" class="block text-lg font-bold mb-1">End Time</label>
                </div>
                <div></div>

                <div class="flex items-center">
                    <input type="checkbox" id="monday-checkbox" name="monday-checkbox" class="form-checkbox checkbox-size h-5 w-5 text-gray-600 mr-2">
                    <label for="monday" class="block text-lg font-bold mb-1">Monday</label>
                </div>
                <div>
                    <input type="text" id="monday-start" name="monday-start" placeholder="start time" class="w-full bg-white rounded-md p-2 hidden md:md\:hidden-mobile">
                </div>
                <div>
                    <input type="text" id="monday-end" name="monday-end" placeholder="end time" class="w-full bg-white rounded-md p-2 hidden md:md\:hidden-mobile">
                </div>
                <div></div>

                <div class="flex items-center">
                    <input type="checkbox" id="tuesday-checkbox" name="tuesday-checkbox" class="form-checkbox checkbox-size h-5 w-5 text-gray-600 mr-2">
                    <label for="tuesday" class="block text-lg font-bold mb-1">Tuesday</label>
                </div>
                <div>
                    <input type="text" id="tuesday-start" name="tuesday-start" placeholder="start time" class="w-full bg-white rounded-md p-2 hidden md:md\:hidden-mobile">
                </div>
                <div>
                    <input type="text" id="tuesday-end" name="tuesday-end" placeholder="end time" class="w-full bg-white rounded-md p-2 hidden md:md\:hidden-mobile">
                </div>
                <div></div>

                <div class="flex items-center">
                    <input type="checkbox" id="wednesday-checkbox" name="wednesday-checkbox" class="form-checkbox checkbox-size h-5 w-5 text-gray-600 mr-2">
                    <label for="wednesday" class="block text-lg font-bold mb-1">Wednesday</label>
                </div>
                <div>
                    <input type="text" id="wednesday-start" name="wednesday-start" placeholder="start time" class="w-full bg-white rounded-md p-2 hidden md:md\:hidden-mobile">
                </div>
                <div>
                    <input type="text" id="wednesday-end" name="wednesday-end" placeholder="end time" class="w-full bg-white rounded-md p-2 hidden md:md\:hidden-mobile">
                </div>
                <div></div>

                <div class="flex items-center">
                    <input type="checkbox" id="thursday-checkbox" name="thursday-checkbox" class="form-checkbox checkbox-size h-5 w-5 text-gray-600 mr-2">
                    <label for="thursday" class="block text-lg font-bold mb-1">Thursday</label>
                </div>
                <div>
                    <input type="text" id="thursday-start" name="thursday-start" placeholder="start time" class="w-full bg-white rounded-md p-2 hidden md:md\:hidden-mobile">
                </div>
                <div>
                    <input type="text" id="thursday-end" name="thursday-end" placeholder="end time" class="w-full bg-white rounded-md p-2 hidden md:md\:hidden-mobile">
                </div>
                <div></div>

                <div class="flex items-center">
                    <input type="checkbox" id="friday-checkbox" name="friday-checkbox" class="form-checkbox checkbox-size h-5 w-5 text-gray-600 mr-2">
                    <label for="friday" class="block text-lg font-bold mb-1">Friday</label>
                </div>
                <div>
                    <input type="text" id="friday-start" name="friday-start" placeholder="start time" class="w-full bg-white rounded-md p-2 hidden md:md\:hidden-mobile">
                </div>
                <div>
                    <input type="text" id="friday-end" name="friday-end" placeholder="end time" class="w-full bg-white rounded-md p-2 hidden md:md\:hidden-mobile">
                </div>
                <div></div>

                <div class="flex items-center">
                    <input type="checkbox" id="saturday-checkbox" name="saturday-checkbox" class="form-checkbox checkbox-size h-5 w-5 text-gray-600 mr-2">
                    <label for="saturday" class="block text-lg font-bold mb-1">Saturday</label>
                </div>
                <div>
                    <input type="text" id="saturday-start" name="saturday-start" placeholder="start time" class="w-full bg-white rounded-md p-2 hidden md:md\:hidden-mobile">
                </div>
                <div>
                    <input type="text" id="saturday-end" name="saturday-end" placeholder="end time" class="w-full bg-white rounded-md p-2 hidden md:md\:hidden-mobile">
                </div>
                <div></div>

                <div class="flex items-center">
                    <input type="checkbox" id="sunday-checkbox" name="sunday-checkbox" class="form-checkbox checkbox-size h-5 w-5 text-gray-600 mr-2">
                    <label for="sunday" class="block text-lg font-bold mb-1">Sunday</label>
                </div>
                <div>
                    <input type="text" id="sunday-start" name="sunday-start" placeholder="start time" class="w-full bg-white rounded-md p-2 hidden md:md\:hidden-mobile">
                </div>
                <div>
                    <input type="text" id="sunday-end" name="sunday-end" placeholder="end time" class="w-full bg-white rounded-md p-2 hidden md:md\:hidden-mobile">
                </div>
                <div></div>
            </div>

            <button type="submit" class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded mt-5">Create</button>
        </form>
    </div>



    <!-- Add the flatpickr JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- ... (existing HTML code) ... -->

    <!-- Add the Flatpickr JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        const handleCheckboxChange = function () {
            const day = this.dataset.day;
            const startInput = document.getElementById(`${day}-start`);
            const endInput = document.getElementById(`${day}-end`);

            if (this.checked) {
                startInput.classList.remove('hidden');
                endInput.classList.remove('hidden');
                // Initialize Flatpickr for both mobile and desktop views
                initializeFlatpickr(startInput);
                initializeFlatpickr(endInput);
            } else {
                startInput.classList.add('hidden');
                endInput.classList.add('hidden');
            }
        };

        const initializeFlatpickr = function (inputElement) {
            flatpickr(inputElement, {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true,
            });
        };

        document.addEventListener('DOMContentLoaded', function () {
            const days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

            // Attach the checkbox event listener for all days
            days.forEach(day => {
                const checkbox = document.getElementById(`${day}-checkbox`);
                checkbox.addEventListener('change', handleCheckboxChange);
                checkbox.dataset.day = day; // Store the day name as a data attribute for future use

                // If it's mobile view during page load and checkbox is checked, initialize Flatpickr for the current day inputs
                if (window.innerWidth < 768 && checkbox.checked) {
                    const startInput = document.getElementById(`${day}-start`);
                    const endInput = document.getElementById(`${day}-end`);
                    initializeFlatpickr(startInput);
                    initializeFlatpickr(endInput);
                }
            });
        });

        // Add a resize event listener to handle changes in device size
        window.addEventListener('resize', function () {
            const checkboxes = document.querySelectorAll('.form-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.removeEventListener('change', handleCheckboxChange);
            });

            if (window.innerWidth < 768) {
                checkboxes.forEach(checkbox => {
                    checkbox.checked && handleCheckboxChange.call(checkbox); // Call handleCheckboxChange for checked checkboxes
                    checkbox.addEventListener('change', handleCheckboxChange);
                });
            } else {
                checkboxes.forEach(checkbox => {
                    checkbox.removeEventListener('change', handleCheckboxChange);
                    checkbox.checked = false; // Reset checked state for desktop view
                    handleCheckboxChange.call(checkbox); // Call handleCheckboxChange to hide inputs
                    checkbox.addEventListener('change', handleCheckboxChange);
                });
            }
        });

    </script>


</x-layout>
