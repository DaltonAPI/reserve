
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css">
    <style>
        /* Additional styles for Google Calendar-like appearance */
        .grid {
            grid-template-columns: repeat(7, minmax(0, 1fr));
        }
        .grid > div {
            padding: 0.625rem 0;
            border: 1px solid #e4e4e4;
        }
        .grid > div:hover {
            background-color: #f1f3f4;
        }
        .grid > div.active {
            /*background-color: #4285f4;*/
            color: #ffffff;
        }
        .grid > div:not(:empty) {
            cursor: pointer;
            position: relative;
        }
        .grid > div:not(:empty)::after {
            content: '';
            position: absolute;
            right: 0.25rem;
            top: 0.25rem;
            height: 0.75rem;
            width: 0.75rem;
            border-radius: 50%;
            /*background-color: #4285f4;*/
        }
        .grid > div.active::after {
            background-color: #ffffff;
        }
        .event-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            padding: 0.25rem;
            background-color: #fff;
            border: 1px solid #e4e4e4;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            z-index: 1;
            opacity: 0;
            pointer-events: none;
            transition: opacity 150ms ease-in-out;
        }
        .grid > div:hover .event-container {
            opacity: 1;
            pointer-events: auto;
        }
        .event-item {
            padding: 0.125rem 0.25rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .grid > div.active-reservation {
            background-color: red;
            color: #ffffff;
        }

        .grid > div.active-blocked {
            background-color: teal;
            color: #ffffff;
        }

        /* Override background color for active-blocked day names */
        .grid > div.active-blocked.text-gray-600 {
            background-color: #ffffff;
            color: #000000; /* Set the desired text color for blocked day names */
        }
        .grid > div.text-center:empty {
            background-color: #ffffff;
        }
        .grid > div.active {
            background-color: deeppink;
            color: #ffffff;
            border: 2px solid deeppink; /* Add a border to the selected cell */
        }
        .grid > div.disabled {
            color: #b0b0b0; /* Set the desired text color for disabled days */
            background-color: #f5f5f5; /* Set a background color to differentiate disabled days */
        }
        #service-container {
            display: none;
        }
        .loader {
            border: 4px solid rgba(255, 255, 255, 0.3); /* Lighter border */
            border-top: 4px solid transparent;
            border-image: linear-gradient(to right, teal, deeppink, pink);
            border-image-slice: 1;
            width: 30px;
            height: 30px;
            animation: spin 1.5s linear infinite;
            display: none; /* initially hide the loader */
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }


        #availability-message {
            display: none;
        }

    </style>
</head>
<body>
<div class="mt-4 p-4 border border-gray-300 rounded" style="background: white;">

    <h1 class="text-xl font-semibold mb-2 text-center">Service Reservation Calendar</h1>
    <div class="text-center mb-4 text-gray-600">
        Select a date by clicking on it to view available slots and make a reservation.
    </div>
    <div  id="service-container" class="mt-4">

        <label for="service" class="block font-medium text-gray-700">Select a service:</label>
        <div id="service-pills" class="flex flex-wrap">
            @php
                $serviceList = $services;
            @endphp
            @foreach($serviceList as $service)
                <button
                    class="service-pill flex flex-col justify-center items-center w-[140px] h-[140px] px-4 py-1 m-1 border-2 border-gray-300 bg-white hover:bg-gray-300 focus:ring-2 focus:ring-pink-300 active:bg-pink-200 rounded-lg shadow-sm transition-transform transform hover:-translate-y-1"
                    data-name="{{ $service['name'] }}"
                    data-duration="{{ $service['duration'] }}"
                    data-price="{{ $service['price'] }}"
                >
                    <!-- Service Name -->
                    <div class="flex items-center w-full">
                        <i class="fas fa-tag text-teal-500"></i>
                        <span class="font-semibold text-xs ml-1">{{ $service['name'] }}</span>
                    </div>

                    <!-- Service Duration -->
                    <div class="flex items-center mt-0.5">
                        <i class="fas fas fa-hourglass-half text-teal-500"></i>
                        <span class="text-xs ml-1">{{ $service['duration'] }} </span>
                    </div>

                    <!-- Service Price -->
                    <div class="flex items-center mt-0.5">
                        <i class="fas fa-dollar-sign text-teal-500"></i>
                        <span class="text-xs ml-1">${{ $service['price'] }}</span>
                    </div>
                </button>





            @endforeach
        </div>


    </div>
    <div class="flex items-center justify-center h-full mt-4">
        <div id="loader" class="loader"></div>
    </div>




    <div class="mt-4">
        <div id="availability-message" class="message"></div>
    </div>
    <div id="selected-date" class="mt-4 font-medium text-gray-700"></div>
    <div id="next-button-container" class="mt-4"></div>

</div>
<div class="container mx-auto">
    <div class="bg-white rounded shadow-md p-4">
        <div class="flex flex-wrap justify-center mb-4">
            <div class="w-1/2 md:w-auto flex items-center mb-2 md:mb-0">
                <div class="w-6 h-6 rounded-full bg-red mr-2" style="background: red"></div>
                <div>Blocked Dates</div>
            </div>
            <div>

            </div>

            <div class="w-1/2 md:w-auto flex items-center mb-2 md:mb-0">
                <div class="w-6 h-6 rounded-full bg-deeppink ml-4 mr-2" style="background: teal"></div>
                <div>Available Dates</div>
            </div>
            <div class="w-1/2 md:w-auto flex items-center mb-2 md:mb-0">
                <div class="w-6 h-6 rounded-full bg-deeppink md:ml-4 mr-2" style="background: deeppink"></div>
                <div class="md:ml-0">Selected Date</div>
            </div>
            <div class="w-1/2 md:w-auto flex items-center">
                <div class="w-6 h-6 rounded-full bg-deeppink ml-4 mr-2" style="background: #f5f5f5"></div>
                <div>Disabled Date</div>
            </div>
        </div>

        <h2 class="text-xl font-bold mb-4">

            <?php
            // Get current month and year
            $currentMonth = date('m');
            $currentYear = date('Y');

            // Check if previous month/year is set in URL query parameters
            if (isset($_GET['month']) && isset($_GET['year'])) {
                $currentMonth = $_GET['month'];
                $currentYear = $_GET['year'];
            }

            // Display current month and year
            echo date('F Y', strtotime($currentYear . '-' . $currentMonth . '-01'));
            ?>
        </h2>

        <!-- Navigation buttons -->
        <div class="flex justify-between mb-4">
            <a href="?month=<?php echo date('m', strtotime('-1 month', strtotime($currentYear . '-' . $currentMonth . '-01'))); ?>&year=<?php echo date('Y', strtotime('-1 month', strtotime($currentYear . '-' . $currentMonth . '-01'))); ?>" class="text-gray-600">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <a href="?month=<?php echo date('m', strtotime('+1 month', strtotime($currentYear . '-' . $currentMonth . '-01'))); ?>&year=<?php echo date('Y', strtotime('+1 month', strtotime($currentYear . '-' . $currentMonth . '-01'))); ?>" class="text-gray-600">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-7 gap-2">
            <div class="text-center text-gray-600 font-bold"></div>
            <div class="text-center text-gray-600 font-bold">Mon</div>
            <div class="text-center text-gray-600 font-bold">Tue</div>
            <div class="text-center text-gray-600 font-bold">Wed</div>
            <div class="text-center text-gray-600 font-bold">Thu</div>
            <div class="text-center text-gray-600 font-bold">Fri</div>
            <div class="text-center text-gray-600 font-bold">Sat</div>

            <?php


            function getRandomColor()
            {
                return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            }

            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
            $firstDayOfMonth = date('N', strtotime($currentYear . '-' . $currentMonth . '-01'));

            $gridCells = $firstDayOfMonth % 7;
            if ($gridCells > 0) {
                for ($i = 0; $i < $gridCells; $i++) {
                    echo '<div class="text-center"></div>';
                }
            } else {
                $gridCells = 7;
            }

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = date('Y-m-d', strtotime($currentYear . '-' . $currentMonth . '-' . $day));
                $dayOfWeek = date('N', strtotime($date));
                $events = array();

                foreach ($reservationData as $reservation) {
                    $reservationDate = date('Y-m-d', strtotime($reservation['date']));
                    if ($date === $reservationDate) {
                        $events[] = $reservation;
                    }
                }


                $isDateReserved = count($events) > 0;

                $cellClasses = 'text-center relative';
                if ($isDateReserved) {
                    $cellClasses .= ' active-blocked';
                }

                // Add class to mark past dates as disabled
                if (strtotime($date) < strtotime(date('Y-m-d'))) {
                    $cellClasses .= ' disabled';
                }

                echo '<div class="' . $cellClasses . '"';

                echo '<div class="text-center relative';
                echo $isDateReserved ? ' active-blocked' : '';
                echo ($isDateReserved ? ' active-blocked' : '') . '"';

//                 if (!$isDateReserved){
                echo ' id="date-cell-' . $date . '" onclick="redirectToURL(\'' . $date . '\');"';
//                 }


                echo '>';
                echo '<div class="w-6 h-6 rounded-full mx-auto"';
                echo $isDateReserved ? ' style="background-color: ' . getRandomColor() . ';"' : '';
                echo '></div>';
                echo '<div class="text-sm mt-1">' . $day . '</div>';
                echo '<div class="event-container">';

                if (auth()->check() && auth()->user()->account_type === 'Business') {
                    foreach ($events as $event) {
                        // Extract the time from the reservation data and convert it to 12-hour format
                        $reservationTime = date('h:i A', strtotime($event['time']));

                        // Display the event item with "@" and the time
                        echo '<div class="event-item text-xs bg-white" style="background-color: ' . getRandomColor() . ';">';
                        echo  $event['customer_name']. ' ' . '@' . ' ' . $reservationTime ;
                        echo '</div>';
                    }
                }


                echo '</div>';
                echo '</div>';

                if (($day + $gridCells) % 7 == 0) {
                    echo '</div><div class="grid grid-cols-7 gap-2">';
                }
            }
            ?>

                <!-- Add more calendar grid cells as needed -->

        </div>
    </div>
</div>


<script>
    // Store the $times data in a JavaScript variable
    var serviceList = <?php echo json_encode($serviceList); ?>;
    var reservationData = <?php echo json_encode($reservationData); ?>;
    var timesData = <?php echo json_encode($times); ?>;
    var currentDate = new Date();
    // Function to set the background color based on the presence of times data
    function setDayBackground() {
        var gridCells = document.querySelectorAll('.grid > div');

        // Iterate over all grid cells (calendar days)
        gridCells.forEach(function(cell, index) {
            var dayOfWeek = index % 7; // 0: Sunday, 1: Monday, ..., 6: Saturday
            var isDayBlocked = false;
            var isReservationDate = false;

            // Check if the day is included in $times data
            timesData.forEach(function(timeEntry) {
                if (timeEntry[getDayKey(dayOfWeek) + '-start'] !== null) {
                    isDayBlocked = true;
                }
            });

            // Check if the day is a reservation date
            var reservationDate = cell.querySelector('.text-sm')?.textContent;
            if (reservationDate && reservationDate !== '') {
                isReservationDate = true;
            }

            // Apply the appropriate background color based on the checks
            if (isDayBlocked) {
                cell.classList.add('active-blocked');
                cell.style.pointerEvents = ''; // Enable interaction for non-blocked days

            } else {
                cell.classList.remove('active-blocked');
                // cell.style.pointerEvents = 'none'; // Disable interaction for blocked days
                cell.onclick = function() {
                    alert('This selected date is not available.');
                };
            }

            if (isReservationDate && !isDayBlocked) {
                cell.classList.add('active-reservation');
            } else {
                cell.classList.remove('active-reservation');
            }
        });
    }




    function getServiceDuration(selectedService) {
        for (const service of serviceList) {
            if (service.name === selectedService) {
                return timeToMinutes(service.duration);
            }
        }
        return 0; // Default duration if service is not found
    }
    let selectedDate = null;
    // Get a reference to the service selection dropdown
    // const serviceDropdown = document.getElementById('service');

    // Attach an event listener to the dropdown
    document.querySelectorAll('.service-pill').forEach(pill => {
        pill.addEventListener('click', function(event) {
            // Reset styles for all pills
            document.getElementById('availability-message').scrollIntoView({
                behavior: 'smooth' // This ensures smooth scrolling. Remove if you want instant jump.
            });
            document.querySelectorAll('.service-pill').forEach(p => p.classList.remove('bg-pink-500', 'text-white'));
            clearNextButton();

            // Use event.currentTarget instead of event.target
            const selectedPill = event.currentTarget;

            // Apply active style for the selected pill
            selectedPill.classList.add('bg-pink-500', 'text-white');

            selectedServiceData = {
                name: selectedPill.getAttribute('data-name'),
                duration: timeToMinutes(selectedPill.getAttribute('data-duration')),
                price: parseFloat(selectedPill.getAttribute('data-price'))
            };

            // Calculate available slots based on the selected service's duration and the stored selected date
            const availableSlots = calculateAvailableSlots(selectedDate, selectedServiceData.duration);

            // Only update the UI with available slots if they are available for the selected date
            updateAvailableSlotsUI(availableSlots);
        });
    });



    function clearNextButton() {
        const nextButtonContainer = document.getElementById('next-button-container');
        nextButtonContainer.innerHTML = '';
    }


    function redirectToURL(date) {
        const currentDate = new Date();
        const selectedDateObject = new Date(date);

        // Check if the selected date is in the past
        if (selectedDateObject < currentDate) {
            alert('You cannot select a past date.');
            return; // Early return to prevent further execution
        }

        clearNextButton();
        selectedDate = date;

        const gridCells = document.querySelectorAll('.grid > div');
        gridCells.forEach(cell => {
            cell.classList.remove('active');
        });
        document.getElementById('service-container').style.display = 'block';
        const selectedCell = document.getElementById('date-cell-' + date);
        if (selectedCell.classList.contains('disabled')) {
            // Don't perform any action for disabled cells
            return;
        }
        selectedCell.classList.add('active');
        // Update the UI to display selected date
        const selectedDateElement = document.getElementById('selected-date');
        selectedDateElement.textContent = "Selected Date: " + date;
        function formatDateToReadableString(dateString) {
            const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            const [year, monthIndex, day] = dateString.split('-');
            const month = months[parseInt(monthIndex, 10) - 1];
            return `${month} ${day}, ${year}`;
        }


        const formattedDate = formatDateToReadableString(date);
        selectedDateElement.textContent = "Selected Date: " + formattedDate;


        const availableSlots = calculateAvailableSlots(date);

        // Update the UI to display available slots
        updateAvailableSlotsUI(availableSlots);
    }

    // Helper function to convert time to minutes
    function timeToMinutes(time) {
        if (!time) {
            return 0;
        }
        const [hours, minutes] = time.split(":").map(Number);
        return (hours * 60) + minutes;
    }


    // Helper function to check if a time range overlaps with another
    function isOverlapping(start1, end1, start2, end2) {
        return start1 < end2 && start2 < end1;
    }

    function updateAvailableSlotsUI(availableSlots) {
        const loader = document.getElementById('loader');
        const availableSlotsContainer = document.getElementById('availability-message');

        // Initially hide the available slots and display the loader
        availableSlotsContainer.style.display = 'none';
        loader.style.display = 'block';

        setTimeout(() => {
            // Hide the loader
            loader.style.display = 'none';

            // Show the available slots container
            availableSlotsContainer.style.display = 'block';

            if (selectedServiceData && selectedDate) {
                if (availableSlots.length !== 0) {
                    availableSlotsContainer.innerHTML = 'Choose a time from the available slots for the date you selected';
                } else {
                    availableSlotsContainer.textContent = 'No available slots for the selected date.';
                }
            } else if (!selectedServiceData) {
                availableSlotsContainer.textContent = 'Please select a service first.';
            }
            const slotsWrapper = document.createElement('div');
            slotsWrapper.classList.add('slot-buttons-wrapper', 'mt-2');

            // Create and append the available slot options as clickable pills/buttons
            availableSlots.forEach(slot => {

                const [hour, minute] = slot.split(':').map(Number);
                const meridiem = slot.includes('PM') ? 'PM' : 'AM';

                let icon;
                if (meridiem === 'AM') {
                    icon = '☀️'; // Morning
                } else if (hour === 12) {
                    icon = '🕛'; // Noon
                } else {
                    icon = '🌙'; // Afternoon & Evening
                }


                const slotButton = document.createElement('button');
                slotButton.innerHTML = `${icon} ${slot}`;
                slotButton.classList.add('time-slot-pill', 'px-3', 'py-1', 'mr-2', 'mb-2', 'border', 'border-gray-300', 'rounded-md', 'hover:bg-pink-300', 'cursor-pointer');
                slotButton.setAttribute('data-slot', slot);

                slotButton.addEventListener('click', function(event) {
                    const selectedSlot = formatTime12Hour(...event.target.getAttribute('data-slot').split(':'));

                    // Make sure to reset any previously selected pill's style
                    const allSlotButtons = document.querySelectorAll('.time-slot-pill');
                    allSlotButtons.forEach(btn => btn.classList.remove('bg-pink-300'));

                    // Highlight the selected pill
                    event.target.classList.add('bg-pink-300');

                    const nextButtonContainer = document.getElementById('next-button-container');
                    let selectedService = selectedServiceData;

                    let serviceName = selectedService.name;

                    let serviceDurationRaw = parseInt(selectedService.duration, 10);
                    let serviceHours = Math.floor(serviceDurationRaw / 60).toString().padStart(2, '0');
                    let serviceMinutes = (serviceDurationRaw % 60).toString().padStart(2, '0');
                    let serviceDuration = `${serviceHours}:${serviceMinutes}`;

                    let servicePrice = selectedService.price;

                    const selectedDate = document.getElementById('selected-date').textContent.split(':')[1].trim();

                    const nextButton = document.createElement('button');
                    nextButton.textContent = 'Next';
                    nextButton.classList.add('px-4', 'py-2', 'bg-pink-500', 'text-white', 'rounded', 'hover:bg-pink-600', 'mt-3');
                    nextButton.addEventListener('click', function() {
                        {{--const redirectURL = `http://localhost:8000/listings/create/{{$clientId}}/{{$businessId}}?selectedDate=${selectedDate}&selectedTime=${selectedSlot}&serviceName=${serviceName}&serviceDuration=${serviceDuration}&servicePrice=${servicePrice}`;--}}
                        const redirectURL = `https://reservify.in/listings/create/{{$clientId}}/{{$businessId}}?selectedDate=${selectedDate}&selectedTime=${selectedSlot}&serviceName=${serviceName}&serviceDuration=${serviceDuration}&servicePrice=${servicePrice}`;
                        window.location.href = redirectURL;
                    });
                    nextButtonContainer.innerHTML = ''; // Clear previous content
                    nextButtonContainer.appendChild(nextButton);
                });

                slotsWrapper.appendChild(slotButton);
            });

            availableSlotsContainer.appendChild(slotsWrapper);
        }, 2000);
    }



    function formatTime12Hour(hours, minutes) {
        const ampm = hours >= 12 ? 'PM' : 'AM';
        const formattedHours = hours % 12 || 12;
        const formattedMinutes = String(minutes).padStart(2, '0');
        return `${formattedHours}:${formattedMinutes} ${ampm}`;
    }

    let selectedServiceData = null;

    function calculateAvailableSlots(date) {
        if (!selectedServiceData || !date) {
            return [];
        }

        const serviceName = selectedServiceData.name;

        // Get the duration of the selected service
        let serviceDuration = null;
        serviceList.forEach(function (service) {
            if (selectedServiceData && service.name === selectedServiceData.name) {
                serviceDuration = timeToMinutes(service.duration);
            }
        });


        // Get the day's name (lowercase) for the selected date
        const dayOfWeek = new Date(date).getDay();
        let startDay = dayOfWeek; // Start checking from the current day
        const dayCount = 7; // Total number of days in a week

        let availableSlots = [];

        // Iterate through each user's availability in timesData
        timesData.forEach(function (userAvailability) {
            for (let i = 1; i <= dayCount; i++) {
                const dayIndex = (startDay + i) % dayCount; // Calculate the index of the current day
                const dayName = getDayKey(dayIndex);

                // Check if the user has availability data for the current day
                if (userAvailability[dayName + '-start'] !== null && userAvailability[dayName + '-end'] !== null) {
                    const businessStartTime = userAvailability[dayName + '-start'];
                    const businessEndTime = userAvailability[dayName + '-end'];

                    let startMinute = timeToMinutes(businessStartTime);
                    const endMinute = timeToMinutes(businessEndTime);

                    while (startMinute + serviceDuration <= endMinute) {
                        let endTime = startMinute + serviceDuration;
                        let overlap = false;
                        let reservedEnd = 0; // Declare it here.

                        for (let reservation of reservationData) {
                            const reservationDate = reservation.date.split(' ')[0];

                            if (reservationDate === date) {

                                const titleString = reservation.title;
                                const titleObject = JSON.parse(titleString);
                                const reservationServiceDuration = timeToMinutes(titleObject.duration);
                                const reservedStart = timeToMinutes(reservation.time);
                                reservedEnd = reservedStart + reservationServiceDuration; // Update it here.

                                if (isOverlapping(startMinute, endTime, reservedStart, reservedEnd)) {
                                    overlap = true;
                                    break;  // This break will skip the overlapping time slot and move to the next one.
                                }
                            }
                        }

                        // Adjust the starting minute based on the overlap check results:
                        if (overlap) {
                            startMinute = reservedEnd; // Move to the end of the overlapping reservation.
                        } else {
                            let startHour = String(Math.floor(startMinute / 60)).padStart(2, '0');
                            let startMin = String(startMinute % 60).padStart(2, '0');
                            availableSlots.push(formatTime12Hour(startHour, startMin));
                            startMinute += serviceDuration; // Increment by service duration; adjust as needed.
                        }
                    }


                    // Found availability, exit the loop
                    break;
                }
            }
        });

        return availableSlots;
    }


    function getDayKey(dayIndex) {
        var days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        return days[dayIndex];
    }

    // Call the function when the page loads
    document.addEventListener('DOMContentLoaded', function() {
        setDayBackground();
    });
</script>


</script>

</body>
</html>

