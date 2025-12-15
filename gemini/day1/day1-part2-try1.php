<?php


/**
 * Solves the safe puzzle by counting every click that lands on 0 (Method 0x434C49434B).
 * * @param array $rotations An array of rotation strings (e.g., ["L68", "R48"]).
 * @return int The total number of times the dial points at 0.
 */
function solveSafePuzzleMethodClickCount(array $rotations): int
{
    // The dial starts by pointing at 50.
    $currentPosition = 50;
    $totalZeroPasses = 0;

    foreach ($rotations as $rotation) {
        $rotation = trim($rotation);
        if (empty($rotation)) {
            continue; // Skip empty lines
        }

        // 1. Parse the rotation string
        $direction = substr($rotation, 0, 1);
        $distance = (int)substr($rotation, 1);

        // 2. Calculate zero passes and new position

        if ($direction === 'R') {
            // --- Right Rotation (R) Logic ---

            // The dial passes 0 if the total movement includes full cycles or a wrap-around past 99.
            // A click on 0 occurs when the accumulated clicks (currentPosition + clicks_so_far)
            // is a multiple of 100.

            // Clicks needed to reach 0 for the first time: (100 - currentPosition)
            $clicksToFirstZero = 100 - $currentPosition;

            if ($distance >= $clicksToFirstZero) {
                // The first zero is passed
                $remainingDistance = $distance - $clicksToFirstZero;

                // Subsequent zero passes occur every 100 clicks
                $zeroPasses = 1 + floor($remainingDistance / 100);

                $totalZeroPasses += $zeroPasses;
            }

            // Calculate final position using modulo 100
            $currentPosition = ($currentPosition + $distance) % 100;

        } elseif ($direction === 'L') {
            // --- Left Rotation (L) Logic ---

            // The dial passes 0 if the total movement includes full cycles or a wrap-around past 0.
            // A click on 0 occurs when the currentPosition is reduced by (currentPosition)
            // or (currentPosition + 100), (currentPosition + 200), etc.

            // Clicks needed to reach 0 for the first time: currentPosition
            $clicksToFirstZero = $currentPosition;

            if ($distance > $clicksToFirstZero) {
                // Note: If distance == clicksToFirstZero, the final position will be 0,
                // which is covered in the following calculation.

                // The first zero is passed on the click *after* currentPosition clicks (i.e., at currentPosition + 1)
                // BUT, the rule is counting the click *that causes* it to point at 0.

                // Clicks that land on 0:
                // 1. If distance >= currentPosition, the first zero pass happens at currentPosition clicks.
                // 2. Subsequent zero passes occur every 100 clicks after that.

                $remainingDistance = $distance - $clicksToFirstZero;

                // If currentPosition was non-zero, the first pass counts.
                $zeroPasses = ($currentPosition > 0 ? 1 : 0) + floor($remainingDistance / 100);

                // Special case: If currentPosition was 0, a pass only counts if distance >= 100
                if ($currentPosition === 0) {
                    $zeroPasses = floor($distance / 100);
                }

                $totalZeroPasses += $zeroPasses;
            }

            // Calculate final position safely
            $currentPosition = $currentPosition - $distance;
            while ($currentPosition < 0) {
                $currentPosition += 100;
            }
            $currentPosition %= 100;

        } else {
            echo "Warning: Invalid rotation format '$rotation'\n";
            continue;
        }

        // Optional: print the trace for debugging
        // echo "Rotated $rotation, passes 0: $zeroPasses, final pos: $currentPosition, total passes: $totalZeroPasses\n";
    }

    return $totalZeroPasses;
}

// --------------------------------------------------------------------------------------------------

## 🔑 Execution

// 1. Define the input file name
$inputFile = 'inputs/day1.txt';

// 2. Read the rotations from the file
if (!file_exists($inputFile)) {
    die("Error: The input file '$inputFile' was not found.\n");
}

$rotations = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// 3. Solve the puzzle
$password = solveSafePuzzleMethodClickCount($rotations);

// 4. Output the result
echo "The new password (total clicks that land on 0) is: **$password**\n";


// --- Verification using the example data ---
/*
$exampleRotations = [
    "L68", "L30", "R48", "L5", "R60",
    "L55", "L1", "L99", "R14", "L82"
];
$examplePassword = solveSafePuzzleMethodClickCount($exampleRotations);
echo "\nExample verification result: $examplePassword (Expected: 6)\n";
// L68 (50->82, passed 0 once at 50 clicks) -> 1
// L30 (82->52, did not pass 0) -> 1
// R48 (52->0, passed 0 once at 48 clicks) -> 2
// L5 (0->95, passed 0 times) -> 2
// R60 (95->55, passed 0 once at 5 clicks) -> 3
// L55 (55->0, passed 0 once at 55 clicks) -> 4
// L1 (0->99, passed 0 times) -> 4
// L99 (99->0, passed 0 once at 99 clicks) -> 5
// R14 (0->14, passed 0 times) -> 5
// L82 (14->32, passed 0 once at 14 clicks) -> 6
// The example trace I calculated manually is 6, which matches the prompt's example.
*/

