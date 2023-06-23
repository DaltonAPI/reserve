<!DOCTYPE html>
<html lang="en">
<head>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css">
</head>
<body>
<div class="container mx-auto ">
    <div class=" rounded border border-grey-500 p-4">
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
            <div class="text-center">Sun</div>
            <div class="text-center">Mon</div>
            <div class="text-center">Tue</div>
            <div class="text-center">Wed</div>
            <div class="text-center">Thu</div>
            <div class="text-center">Fri</div>
            <div class="text-center">Sat</div>

            <?php


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
                $highlighted = false;

                foreach ($reservationData as $reservation) {
                    $reservationDate = date('Y-m-d', strtotime($reservation['date']));
                    if ($date === $reservationDate) {
                        $highlighted = true;
                        break;
                    }
                }

                echo '<div class="text-center';
                echo $highlighted ? ' bg-pink-500 text-white' : '';
                echo '">' . $day . '</div>';

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
</body>
</html>
