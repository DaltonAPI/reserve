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
    </style>
</head>
<body>
<div class="mt-4 p-4 border border-gray-300 rounded" style="background: white;">
    <div class="flex items-center mb-2">
        <div class="w-6 h-6 rounded-full bg-red mr-2" style="background: red"></div>
        <div>Blocked Dates</div>
    </div>
    <div class="flex items-center">
        <div class="w-6 h-6 rounded-full bg-deeppink mr-2" style="background: teal"></div>
        <div>Available Dates</div>
    </div>
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

                echo '<div class="text-center relative';
                echo !empty($events) ? ' active' : '';
                echo '">';
                echo '<div class="w-6 h-6 rounded-full mx-auto"';
                echo !empty($events) ? ' style="background-color: ' . getRandomColor() . ';"' : '';
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

            // Fill in remaining empty grid cells
            $remainingCells = 7 - (($daysInMonth + $gridCells) % 7);
            for ($i = 0; $i < $remainingCells; $i++) {
                echo '<div class="text-center"></div>';
            }
            ?>

                <!-- Add more calendar grid cells as needed -->

        </div>
    </div>
</div>

<script>
    // Store the $times data in a JavaScript variable
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
            } else {
                cell.classList.remove('active-blocked');
            }

            if (isReservationDate && !isDayBlocked) {
                cell.classList.add('active-reservation');
            } else {
                cell.classList.remove('active-reservation');
            }
        });
    }

    // Helper function to get the day key (e.g., "monday-start") based on the day index
    function getDayKey(dayIndex) {
        var days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        return days[dayIndex];
    }

    // Call the function when the page loads
    document.addEventListener('DOMContentLoaded', function() {
        setDayBackground();
    });
</script>

</body>
</html>
