<?php

// Input string containing comma-separated ranges (example from the prompt)
// Replace this with your actual puzzle input
$input = file_get_contents('inputs/day2.txt');

/**
 * Solves the Gift Shop ID puzzle by finding and summing all "AA" pattern numbers
 * that fall within the specified product ID ranges.
 * * @param string $input The comma-separated string of ranges (e.g., "11-22,95-115").
 * @return int The total sum of all invalid IDs found.
 */
function solvePuzzle(string $input): int
{
    // --- Step 1: Parse and Prepare Ranges ---
    $ranges = [];
    $maxId = 0;

    // Split the input string by comma to get individual range strings
    $rangeStrings = explode(',', $input);

    foreach ($rangeStrings as $rangeStr) {
        // Split each range string by the dash to get start and end
        if (strpos($rangeStr, '-') === false) continue;

        list($startStr, $endStr) = explode('-', $rangeStr);

        // Use GMP functions for arbitrary-precision arithmetic,
        // as IDs can exceed standard 32-bit or 64-bit integer limits.
        $start = gmp_init(trim($startStr));
        $end = gmp_init(trim($endStr));

        $ranges[] = ['start' => $start, 'end' => $end];

        // Track the largest required number to avoid generating excessively long IDs
        if (gmp_cmp($end, $maxId) > 0) {
            $maxId = $end;
        }
    }

    $totalSum = gmp_init(0);

    // Assuming a max ID length of 18 (for 64-bit safe handling or just large numbers)
    // which means the base sequence 'A' has max length L=9.
    $maxL = 9;

    // --- Step 2: Generate and Check Invalid IDs ---

    // L is the length of the base sequence 'A'
    for ($L = 1; $L <= $maxL; $L++) {
        // $startA is the smallest L-digit number (e.g., L=3 -> 100)
        $startA = gmp_pow(10, $L - 1);

        // $endA is the largest L-digit number (e.g., L=3 -> 999)
        $endA = gmp_sub(gmp_pow(10, $L), 1);

        // The multiplier for 'A' to form 'AA' (e.g., L=3 -> 1001)
        $multiplier = gmp_add(gmp_pow(10, $L), 1);

        // Iterate through all possible base sequences 'A'
        for ($A = $startA; gmp_cmp($A, $endA) <= 0; $A = gmp_add($A, 1)) {

            // Calculate the invalid ID: I = A * (10^L + 1)
            $I = gmp_mul($A, $multiplier);

            // Optimization: If the generated ID is already larger than the
            // maximum required ID in the input, we can stop the generation.
            if (gmp_cmp($I, $maxId) > 0) {
                // Since A is increasing, all subsequent IDs for this L
                // and all larger L will also be too large.
                return gmp_strval($totalSum); // Return the final sum
            }

            // Check if this invalid ID falls within any of the specified ranges
            foreach ($ranges as $range) {
                // If start <= I <= end
                if (gmp_cmp($I, $range['start']) >= 0 && gmp_cmp($I, $range['end']) <= 0) {
                    // It's a match! Add it to the total sum
                    $totalSum = gmp_add($totalSum, $I);

                    // Break the inner loop (checking ranges) since the ID is found
                    break;
                }
            }
        }
    }

    return gmp_strval($totalSum);
}

// Execute the function and print the result
$result = solvePuzzle($input);
echo "The total sum of all invalid IDs is: " . $result . "\n";

// Expected output for the example input: 1227775554

?>