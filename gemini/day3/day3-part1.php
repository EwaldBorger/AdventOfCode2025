<?php

/**
 * Finds the largest two-digit number (joltage) that can be formed
 * by selecting two digits from the input string in their original order.
 * * @param string $bankRatings The string of single-digit joltage ratings (e.g., "987654321111111").
 * @return int The maximum possible two-digit joltage (e.g., 98).
 */
function findMaxBankJoltage(string $bankRatings): int {
    $bankRatings = trim($bankRatings);
    $length = strlen($bankRatings);

    // If the bank has less than two batteries, it cannot produce a two-digit joltage.
    if ($length < 2) {
        return 0; // Or handle as an error, but 0 is safe for summation.
    }

    $maxJoltage = 0;

    // We iterate through all possible pairs of batteries (digits) that maintain order.
    // The first battery (digit) is at index $i$.
    for ($i = 0; $i < $length - 1; $i++) {
        $digit1 = $bankRatings[$i];

        // The second battery (digit) is at index $j$, which must be after $i$.
        for ($j = $i + 1; $j < $length; $j++) {
            $digit2 = $bankRatings[$j];

            // Form the two-digit number. Since these are single digits '0' through '9',
            // concatenating them and casting to (int) works perfectly.
            $currentJoltageString = $digit1 . $digit2;
            $currentJoltage = (int)$currentJoltageString;

            // Check if this is the largest joltage found so far.
            if ($currentJoltage > $maxJoltage) {
                $maxJoltage = $currentJoltage;
            }
        }
    }

    return $maxJoltage;
}


/**
 * Solves the puzzle by calculating the total maximum output joltage.
 * * @param array $batteryBanks An array of strings, where each string is a battery bank rating.
 * @return int The total maximum joltage across all banks.
 */
function solveTotalJoltagePuzzle(array $batteryBanks): int {
    $totalOutputJoltage = 0;

    foreach ($batteryBanks as $bankRatings) {
        $maxBankJoltage = findMaxBankJoltage($bankRatings);
        $totalOutputJoltage += $maxBankJoltage;
    }

    return $totalOutputJoltage;
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
        "987654321111111",
        "811111111111119",
        "234234234234278",
        "818181911112111"
    ];
} else {
    // Read lines from the input file
    $batteryBanks = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

// 3. Solve the puzzle
$totalJoltage = solveTotalJoltagePuzzle($batteryBanks);

// 4. Output the result
echo "The total output joltage is: **$totalJoltage**\n";


// --- Example Verification ---
/*
// Example: 987654321111111 -> Max is 98 (9 followed by 8)
// Example: 811111111111119 -> Max is 89 (8 followed by 9)
// Example: 234234234234278 -> Max is 78 (7 followed by 8)
// Example: 818181911112111 -> Max is 92 (9 followed by 2)
// Total: 98 + 89 + 78 + 92 = 357 (Matches example)
*/
?>