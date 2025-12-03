<?php declare(strict_types=1);

/**
 * Solves the safe puzzle by simulating dial rotations.
 * * @param array $rotations An array of rotation strings (e.g., ["L68", "R48"]).
 * @return int The number of times the dial lands on 0.
 */
function solveSafePuzzle(array $rotations): int {
    // The dial starts by pointing at 50.
    $currentPosition = 50;
    $zeroCount = 0;

    foreach ($rotations as $rotation) {
        $rotation = trim($rotation);
        if (empty($rotation)) {
            continue; // Skip empty lines
        }

        // 1. Parse the rotation string
        $direction = substr($rotation, 0, 1);
        $distance = (int)substr($rotation, 1);

        // 2. Calculate the new position
        if ($direction === 'R') {
            // Right rotation (toward higher numbers): Add distance, then modulo 100.
            $currentPosition = ($currentPosition + $distance) % 100;
        } elseif ($direction === 'L') {
            // Left rotation (toward lower numbers): Subtract distance.

            // To handle the circular nature and avoid negative results from the PHP % operator
            // for negative numbers, we use the property: (a - b) mod n = ((a - b) % n + n) % n.
            // A simpler, more direct approach for this problem is:

            // Subtract the distance
            $currentPosition -= $distance;

            // Keep the position within the 0-99 range (circular)
            // While loop handles rotations larger than the current position.
            while ($currentPosition < 0) {
                $currentPosition += 100;
            }
            // A single modulo 100 operation at the end is unnecessary if we use the while loop,
            // but for completeness and safety:
            $currentPosition %= 100;
        } else {
            // Handle unexpected input format
            echo "Warning: Invalid rotation format '$rotation'\n";
            continue;
        }

        // 3. Check if the dial landed on 0
        if ($currentPosition === 0) {
            $zeroCount++;
        }

        // Optional: print the trace for debugging (like in the example)
        // echo "Rotated $rotation to position $currentPosition\n";
    }

    return $zeroCount;
}

// --------------------------------------------------------------------------------------------------

// --- Main execution block ---

// 1. Define the input file name
$inputFile = 'inputs/day1.txt';

// 2. Read the rotations from the file
if (!file_exists($inputFile)) {
    die("Error: The input file '$inputFile' was not found.\n");
}

$rotations = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// 3. Solve the puzzle
$password = solveSafePuzzle($rotations);

// 4. Output the result
echo "The actual password (number of times the dial landed on 0) is: $password\n";


// --- Verification using the example data ---
/*
$exampleRotations = [
    "L68", "L30", "R48", "L5", "R60",
    "L55", "L1", "L99", "R14", "L82"
];
$examplePassword = solveSafePuzzle($exampleRotations);
echo "\nExample verification result: $examplePassword (Expected: 3)\n";
*/

?>