
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
            background-color: #4285f4;
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
            background-color: #4285f4;
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

    </style>
</head>
<body>
<div class="mt-4 p-4 border border-gray-300 rounded" style="background: white;">



    <div class="flex items-center mb-2">
        <div class="w-6 h-6 rounded-full bg-red mr-2" style="background: red"></div>
        <div>Blocked Dates</div>
    </div>
    <div class="flex items-center mb-2">
        <div class="w-6 h-6 rounded-full bg-deeppink mr-2" style="background: teal"></div>
        <div>Available Dates</div>
    </div>
    <div class="flex items-center">
        <div class="w-6 h-6 rounded-full bg-deeppink mr-2" style="background: deeppink"></div>
        <div>Selected Date</div>
    </div>
    <div class="mt-4">
        <label for="service" class="block font-medium text-gray-700">Select a service:</label>
        <select id="service" name="service" class="mt-1 block w-full p-2 border border-gray-300 bg-white rounded-md shadow-sm focus:ring focus:ring-indigo-300 focus:border-indigo-300">
            @php
                $serviceList = json_decode($business['serviceList'], true);

            @endphp

            @foreach($serviceList as $service)
                <option value="{{ $service['name'] }}">{{ $service['name'] }} ({{ $service['duration'] }})</option>
            @endforeach
        </select>
    </div>
    <div class="mt-4">
        <label for="service" class="block font-medium text-gray-700">Choose a time from the available slots</label>
        <div id="availability-message" class="message"></div>
    </div>
    <div id="selected-date" class="mt-4 font-medium text-gray-700"></div>
    <div id="next-button-container" class="mt-4"></div>

</div>
<div class="container mx-auto">
    <div class="bg-white rounded shadow-md p-4">
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
            <div class="text-center text-gray-600 font-bold">Sun</div>
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
                foreach ($events as $event) {
                    // Extract the time from the reservation data and convert it to 12-hour format
                    $reservationTime = date('h:i A', strtotime($event['time']));

                    // Display the event item with "@" and the time
                    echo '<div class="event-item text-xs bg-white" style="background-color: ' . getRandomColor() . ';">';
                    echo  $event['customer_name']. ' ' . '@' . ' ' . $reservationTime ;
                    echo '</div>';
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
    const serviceDropdown = document.getElementById('service');

    // Attach an event listener to the dropdown
    serviceDropdown.addEventListener('change', function(event) {
        const selectedService = event.target.value;
        const selectedServiceDuration = getServiceDuration(selectedService); // You need to define this function

        // Calculate available slots based on the selected service's duration and the stored selected date
        const availableSlots = calculateAvailableSlots(selectedDate, selectedServiceDuration);
        console.log(selectedDate)
        // Only update the UI with available slots if they are available for the selected date
        if (availableSlots.length > 0 && selectedDate !== null) {
            updateAvailableSlotsUI(availableSlots);
        }
    });



    function redirectToURL(date) {

        selectedDate = date;

        // Remove the "active" class from all cells
        const gridCells = document.querySelectorAll('.grid > div');
        gridCells.forEach(cell => {
            cell.classList.remove('active');
        });

        // Add the "active" class to the selected cell
        const selectedCell = document.getElementById('date-cell-' + date);
        selectedCell.classList.add('active');
        // Update the UI to display selected date
        const selectedDateElement = document.getElementById('selected-date');
        selectedDateElement.textContent = "Selected Date: " + date;
        const availableSlots = calculateAvailableSlots(date);

        // Update the UI to display available slots
        updateAvailableSlotsUI(availableSlots);
    }

    // Helper function to convert time to minutes
    function timeToMinutes(time) {
        if (!time) {
            console.error("timeToMinutes received an invalid time:", time);
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
        const availableSlotsContainer = document.getElementById('availability-message');
        availableSlotsContainer.innerHTML = '';

        if (availableSlots.length === 0) {
            availableSlotsContainer.textContent = 'No available slots for the selected date.';
        } else {
            const slotDropdown = document.createElement('select');
            slotDropdown.classList.add('mt-2', 'block', 'w-full', 'border', 'border-gray-300', 'p-2', 'rounded-md', 'shadow-sm', 'focus:ring', 'focus:ring-indigo-300');

            // Create and append the available slot options to the dropdown
            availableSlots.forEach(slot => {
                const option = document.createElement('option');
                option.textContent = slot;
                option.value = slot;
                slotDropdown.appendChild(option);
            });

            // Attach an event listener to the dropdown to capture the selected slot
            slotDropdown.addEventListener('change', function(event) {
                const selectedSlot = formatTime12Hour(...event.target.value.split(':'));

                // Do something with the selected time slot
                console.log('Selected time slot:', selectedSlot);

                // Create and display the "Next" button
                const nextButtonContainer = document.getElementById('next-button-container');
                const selectedService = document.getElementById('service').value;
                const selectedDate = document.getElementById('selected-date').textContent.split(':')[1].trim();
                const availabilityMessage = document.getElementById('availability-message');


                const selectedTimeOption = availabilityMessage.querySelector('select').value;
                const nextButton = document.createElement('button');
                nextButton.textContent = 'Next';
                nextButton.classList.add('px-4', 'py-2', 'bg-pink-500', 'text-white', 'rounded', 'hover:bg-pink-600');
                nextButton.addEventListener('click', function() {
                    const redirectURL = `http://localhost:8000/listings/create/{{$clientId}}/{{$businessId}}?selectedDate=${selectedDate}&selectedTime=${selectedTimeOption}&selectedService=${selectedService}`;
                    window.location.href = redirectURL;
                });
                nextButtonContainer.innerHTML = ''; // Clear previous content
                nextButtonContainer.appendChild(nextButton);
            });

            availableSlotsContainer.appendChild(slotDropdown);
        }
    }
    function formatTime12Hour(hours, minutes) {
        const ampm = hours >= 12 ? 'PM' : 'AM';
        const formattedHours = hours % 12 || 12;
        const formattedMinutes = String(minutes).padStart(2, '0');
        return `${formattedHours}:${formattedMinutes} ${ampm}`;
    }


    function calculateAvailableSlots(date) {
        const selectedService = document.getElementById('service').value;

        // Get the duration of the selected service
        let serviceDuration = null;
        serviceList.forEach(function (service) {
            if (service.name === selectedService) {
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
                                const reservationServiceDuration = timeToMinutes(titleObject[0].duration);
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

