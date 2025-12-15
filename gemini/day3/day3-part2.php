<?php

// Define the required length for the joltage output
const TARGET_LENGTH = 12;

/**
 * Finds the lexicographically largest subsequence of a specific length (12)
 * from the input string (battery bank ratings).
 * * This uses a greedy algorithm to ensure the most significant digits are as large as possible.
 * * @param string $bankRatings The string of single-digit joltage ratings (e.g., "987654321111111").
 * @return string The maximum possible joltage as a 12-digit string.
 */
function findMaxTwelveDigitJoltage(string $bankRatings): string {
    $bankRatings = trim($bankRatings);
    $N = strlen($bankRatings);

    // Safety check: Cannot form a 12-digit number if the bank is too short.
    if ($N < TARGET_LENGTH) {
        // Return an empty string or handle as an error based on expected input constraints.
        return "";
    }

    $result = []; // Use an array as a stack to build the result subsequence
    $K = TARGET_LENGTH;

    for ($i = 0; $i < $N; $i++) {
        $currentDigit = $bankRatings[$i];

        // 1. Comparison (Greedy Step):
        // While the result is not empty, and the current digit is larger than the last
        // digit in the result, AND removing the last digit still allows us to form
        // a final result of length K (N - i - 1 + count($result) > K - 1), pop the last digit.
        while (
            !empty($result) &&
            $currentDigit > $result[count($result) - 1] &&
            ($N - $i + count($result) > $K)
        ) {
            array_pop($result);
        }

        // 2. Addition:
        // Only add the digit if we still need more digits for the final length K.
        if (count($result) < $K) {
            $result[] = $currentDigit;
        }
    }

    // The result array should now contain exactly K digits.
    // Ensure it's truncated to K in case the loop finished early due to the comparison logic.
    $finalResult = array_slice($result, 0, $K);

    return implode('', $finalResult);
}


/**
 * Solves the puzzle by calculating the total maximum output joltage.
 * * @param array $batteryBanks An array of strings, where each string is a battery bank rating.
 * @return string The total maximum joltage across all banks as a string (due to large size).
 */
function solveTotalJoltagePuzzlePartTwo(array $batteryBanks): string {
    // Initialize the total sum as a string to handle arbitrarily large numbers (PHP's built-in
    // integer type may overflow the required sum).
    $totalOutputJoltage = "0";

    foreach ($batteryBanks as $bankRatings) {
        $bankRatings = trim($bankRatings);
        if (empty($bankRatings)) { continue; }

        $maxBankJoltageString = findMaxTwelveDigitJoltage($bankRatings);

        // Use GMP (GNU Multiple Precision) or BC Math for safe addition of large numbers.
        // BC Math is generally included in default PHP installations and is easier to use.
        if (extension_loaded('bcmath')) {
            $totalOutputJoltage = bcadd($totalOutputJoltage, $maxBankJoltageString);
        } else {
            // Fallback: If BC Math is not available, proceed with string concatenation.
            // This risks incorrect results if the final sum exceeds PHP_INT_MAX, but
            // is included for compliance with the "default extensions" requirement if bcmath is missing.
            $totalOutputJoltage += (float)$maxBankJoltageString;
            //echo "Warning: BC Math extension not loaded. Final sum may be inaccurate if total exceeds PHP_INT_MAX.\n";
        }
    }

    return sprintf("%d", $totalOutputJoltage);
}

// --------------------------------------------------------------------------------------------------

## ⚙️ Main Execution Block

// 1. Define the input file name
$inputFile = 'inputs/day3.txt';

// 2. Read the battery banks from the file
if (!file_exists($inputFile)) {
    // Fallback to example input if the file is missing
    echo "Warning: The input file '$inputFile' was not found. Using example data for demonstration.\n";
    $batteryBanks = [
        "987654321111111", // Expected: 987654321111
        "811111111111119", // Expected: 811111111119
        "234234234234278", // Expected: 434234234278
        "818181911112111"  // Expected: 888911112111
    ];
} else {
    // Read lines from the input file
    $batteryBanks = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

// 3. Solve the puzzle
$totalJoltage = solveTotalJoltagePuzzlePartTwo($batteryBanks);

// 4. Output the result
echo "The new total output joltage is: **$totalJoltage**\n";

?>