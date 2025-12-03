<?php

// Input string (use your actual puzzle input here)
$input = file_get_contents('inputs/day2.txt');

/**
 * Compares two numbers (which may be large) represented as strings.
 * This is a safe alternative to bccomp or gmp_cmp when those extensions are unavailable.
 *
 * @param string $a
 * @param string $b
 * @return int -1 if a < b, 0 if a = b, 1 if a > b
 */
function compareNumbersAsString(string $a, string $b): int
{
    $lenA = strlen($a);
    $lenB = strlen($b);

    if ($lenA < $lenB) return -1;
    if ($lenA > $lenB) return 1;

    // Lengths are equal, compare lexicographically
    if ($a < $b) return -1;
    if ($a > $b) return 1;
    return 0;
}

/**
 * Solves the puzzle using standard PHP integers and string comparison for safety.
 *
 * @param string $input The comma-separated string of ranges.
 * @return int The total sum of all invalid IDs found. Returns a string for the sum
 * to prevent overflow, though the generation itself is limited to
 * PHP's maximum integer range.
 */
function solvePuzzleNoExtensions(string $input): string
{
    // --- Step 1: Parse and Prepare Ranges ---
    $ranges = [];
    $maxIdString = '0'; // Used for the generation optimization limit

    $rangeStrings = explode(',', $input);

    foreach ($rangeStrings as $rangeStr) {
        if (strpos($rangeStr, '-') === false) continue;

        list($startStr, $endStr) = explode('-', $rangeStr);

        // Store start and end as strings for safe comparison
        $start = trim($startStr);
        $end = trim($endStr);

        $ranges[] = ['start' => $start, 'end' => $end];

        // Update the maximum ID string
        if (compareNumbersAsString($end, $maxIdString) > 0) {
            $maxIdString = $end;
        }
    }

    // The total sum *must* be stored as a string, as it will likely exceed
    // the max integer value (e.g., the example sum is 1,227,775,554, which is fine,
    // but the final answer could be much larger).
    $totalSum = '0';

    // Max L=9 results in a 18-digit ID, which is safe for PHP's native 64-bit integer,
    // but we'll stick to string handling for safety/simplicity in this no-extension context.
    $maxL = 9;

    // --- Step 2: Generate and Check Invalid IDs ---

    for ($L = 1; $L <= $maxL; $L++) {

        // Calculate the base number 'A' boundaries as standard integers first
        $startA_int = (int)pow(10, $L - 1);
        $endA_int = (int)pow(10, $L) - 1;

        // The power of 10 used for multiplication
        $pow10_L = pow(10, $L);

        // The multiplier for 'A' to form 'AA' (e.g., L=3 -> 1001)
        $multiplier = $pow10_L + 1;

        // Iterate through all possible base sequences 'A'
        for ($A = $startA_int; $A <= $endA_int; $A++) {

            // Calculate the invalid ID: I = A * multiplier
            // For L <= 9, A and multiplier are safe 64-bit integers.
            $I_int = $A * $multiplier;
            $I = (string)$I_int; // Convert to string for safe comparison and addition

            // Optimization: If the generated ID I is larger than the max required ID
            if (compareNumbersAsString($I, $maxIdString) > 0) {
                // Return the final sum as a string
                return $totalSum;
            }

            // Check if this invalid ID falls within any of the specified ranges
            foreach ($ranges as $range) {
                // If start <= I <= end
                // compareNumbersAsString(I, start) >= 0 checks I >= start
                // compareNumbersAsString(I, end) <= 0 checks I <= end
                if (compareNumbersAsString($I, $range['start']) >= 0 && compareNumbersAsString($I, $range['end']) <= 0) {

                    // It's a match! Add I to the total sum string-wise
                    // Since we can't use bcadd, we use string addition (which is complex).
                    // For the sake of a clean, no-extension solution, we will assume
                    // the *final sum* is safe for a 64-bit integer, OR
                    // we implement a simple string addition function.

                    // Implementing a simple string addition function:
                    $totalSum = stringAdd($totalSum, $I);

                    // Break the inner loop (checking ranges)
                    break;
                }
            }
        }
    }

    return $totalSum;
}

/**
 * Basic string addition function (no extensions).
 * Adds two large numbers represented as strings.
 */
function stringAdd(string $num1, string $num2): string
{
    // Pad the shorter string with leading zeros
    $len1 = strlen($num1);
    $len2 = strlen($num2);
    $maxLen = max($len1, $len2);

    $num1 = str_pad($num1, $maxLen, '0', STR_PAD_LEFT);
    $num2 = str_pad($num2, $maxLen, '0', STR_PAD_LEFT);

    $result = '';
    $carry = 0;

    // Iterate backwards through the digits
    for ($i = $maxLen - 1; $i >= 0; $i--) {
        $digit1 = (int)$num1[$i];
        $digit2 = (int)$num2[$i];

        $sum = $digit1 + $digit2 + $carry;

        $result = ($sum % 10) . $result;
        $carry = (int)($sum / 10);
    }

    if ($carry > 0) {
        $result = $carry . $result;
    }

    return $result;
}


// Execute the function and print the result
$result = solvePuzzleNoExtensions($input);
echo "The total sum of all invalid IDs is: " . $result . "\n";

// Expected output for the example input: 1227775554

?>