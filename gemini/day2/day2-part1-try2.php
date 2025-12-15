<?php

// Input string (use your actual puzzle input here)
$input = file_get_contents('inputs/day2.txt');

/**
 * Solves the puzzle using BC Math for arbitrary-precision arithmetic (no GMP required).
 *
 * @param string $input The comma-separated string of ranges.
 * @return string The total sum of all invalid IDs found (as a string).
 */
function solvePuzzleBC(string $input): string
{
    // --- Step 1: Parse and Prepare Ranges ---
    $ranges = [];
    // Start maxId at 0. BC Math works with strings for large numbers.
    $maxId = '0';

    $rangeStrings = explode(',', $input);

    foreach ($rangeStrings as $rangeStr) {
        if (strpos($rangeStr, '-') === false) continue;

        list($startStr, $endStr) = explode('-', $rangeStr);

        // Store start and end as strings for BC Math
        $start = trim($startStr);
        $end = trim($endStr);

        $ranges[] = ['start' => $start, 'end' => $end];

        // bccomp(a, b, scale) compares strings a and b
        if (bccomp($end, $maxId) > 0) {
            $maxId = $end;
        }
    }

    $totalSum = '0';
    $maxL = 9; // Max length for the base sequence 'A'

    // --- Step 2: Generate and Check Invalid IDs ---

    for ($L = 1; $L <= $maxL; $L++) {
        // Calculate powers of 10 as strings using bcpow
        $pow10_L_minus_1 = bcpow('10', (string)($L - 1));
        $pow10_L = bcpow('10', (string)$L);

        // $startA (e.g., L=3 -> 100)
        $startA = $pow10_L_minus_1;

        // $endA (e.g., L=3 -> 999)
        $endA = bcsub($pow10_L, '1');

        // The multiplier for 'A' to form 'AA' (e.g., L=3 -> 1000 + 1 = 1001)
        $multiplier = bcadd($pow10_L, '1');

        // Iterate through all possible base sequences 'A' (A is now a string)
        for ($A = $startA; bccomp($A, $endA) <= 0; $A = bcadd($A, '1')) {

            // Calculate the invalid ID: I = A * multiplier
            $I = bcmul($A, $multiplier);

            // Optimization: If I > maxId, stop everything.
            if (bccomp($I, $maxId) > 0) {
                return $totalSum;
            }

            // Check if this invalid ID falls within any of the specified ranges
            foreach ($ranges as $range) {
                // If start <= I <= end
                if (bccomp($I, $range['start']) >= 0 && bccomp($I, $range['end']) <= 0) {
                    // It's a match! Add it to the total sum
                    $totalSum = bcadd($totalSum, $I);

                    // Break the inner loop (checking ranges)
                    break;
                }
            }
        }
    }

    return $totalSum;
}

// Execute the function and print the result
$result = solvePuzzleBC($input);
echo "The total sum of all invalid IDs is: " . $result . "\n";

?>