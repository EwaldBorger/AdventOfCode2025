<?php

// Input string (use your actual puzzle input here)
$input = file_get_contents('inputs/day2.txt');

// --- Helper Functions (From previous solution) ---

/**
 * Compares two numbers (which may be large) represented as strings.
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
 * Basic string addition function (no extensions). Adds two large numbers.
 */
function stringAdd(string $num1, string $num2): string
{
    $len1 = strlen($num1);
    $len2 = strlen($num2);
    $maxLen = max($len1, $len2);

    $num1 = str_pad($num1, $maxLen, '0', STR_PAD_LEFT);
    $num2 = str_pad($num2, $maxLen, '0', STR_PAD_LEFT);

    $result = '';
    $carry = 0;

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

// --- Main Solver Function ---

/**
 * Solves the extended puzzle where IDs are A^k (k >= 2).
 *
 * @param string $input The comma-separated string of ranges.
 * @return string The total sum of all invalid IDs found.
 */
function solveExtendedPuzzle(string $input): string
{
    // --- Step 1: Parse and Prepare Ranges ---
    $ranges = [];
    $maxIdString = '0';

    $rangeStrings = explode(',', $input);

    foreach ($rangeStrings as $rangeStr) {
        if (strpos($rangeStr, '-') === false) continue;

        list($start, $end) = explode('-', $rangeStr);
        $ranges[] = ['start' => trim($start), 'end' => trim($end)];

        if (compareNumbersAsString(trim($end), $maxIdString) > 0) {
            $maxIdString = trim($end);
        }
    }

    $totalSum = '0';
    $maxL = 9; // Max base length A, since max total length is ~18 (PHP 64-bit limit)

    // --- Step 2: Generate and Check Invalid IDs ---

    // Set to store invalid IDs found to prevent double counting
    $foundInvalidIDs = [];

    // L: Length of the base sequence A (1, 2, 3, ...)
    for ($L = 1; $L <= $maxL; $L++) {

        // k: Number of repetitions (must be >= 2)
        // We only need to check up to k=18 (since L >= 1)
        for ($k = 2; $k <= 18; $k++) {

            // Optimization: If the minimum possible ID length (L*k)
            // is already greater than the maximum ID in the input, we can stop k.
            if ($L * $k > strlen($maxIdString)) {
                break;
            }

            // Calculate the numerical start and end of base sequence A (as standard integers)
            $startA_int = (int)pow(10, $L - 1);
            $endA_int = (int)pow(10, $L) - 1;

            // Iterate through all possible base sequences 'A'
            for ($A_int = $startA_int; $A_int <= $endA_int; $A_int++) {

                $A_str = (string)$A_int;

                // Concatenate A k times to form the invalid ID I
                $I = str_repeat($A_str, $k);

                // Final Check: I should not exceed the max ID string limit
                if (compareNumbersAsString($I, $maxIdString) > 0) {
                    // Since A is increasing, all subsequent IDs for this (L, k) pair will also be too large.
                    break;
                }

                // IMPORTANT: Prevent Double Counting
                // An ID like 101010 can be generated as (A=10, k=3) OR (A=1010, k=?)
                // Wait, it is also generated as (A=101010, k=1), which is invalid since k>=2.
                // An ID like 111111 can be generated as (A=11, k=3) and (A=111, k=2).
                // We must only count the invalid ID *once* if it's found in the ranges.

                // If we've already processed this exact string I, skip it.
                if (isset($foundInvalidIDs[$I])) {
                    continue;
                }

                // Check if this invalid ID falls within any of the specified ranges
                foreach ($ranges as $range) {
                    // If start <= I <= end
                    if (compareNumbersAsString($I, $range['start']) >= 0 && compareNumbersAsString($I, $range['end']) <= 0) {

                        // Match! Add it to the total sum and mark it as found.
                        $totalSum = stringAdd($totalSum, $I);
                        $foundInvalidIDs[$I] = true;

                        // Stop checking ranges for this ID, and move to the next A
                        break;
                    }
                }
            }
        }
    }

    return $totalSum;
}

// Execute the function and print the result
$result = solveExtendedPuzzle($input);
echo "The total sum of all invalid IDs is: " . $result . "\n";

?>