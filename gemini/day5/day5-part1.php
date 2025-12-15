<?php

/**
 * Solves the ingredient freshness puzzle.
 * It determines how many available ingredient IDs fall into any of the fresh ID ranges.
 * * @param array $inputLines The puzzle input (lines of the database file).
 * @return int The total count of fresh available ingredient IDs.
 */
function solveFreshIngredientPuzzle(array $inputLines): int {
    $ranges = [];
    $availableIds = [];
    $isReadingRanges = true;

    // 1. Parse the input into ranges and available IDs
    foreach ($inputLines as $line) {
        $line = trim($line);
        if (empty($line)) {
            $isReadingRanges = false;
            continue;
        }

        if ($isReadingRanges) {
            // Parse range format "min-max"
            if (preg_match('/^(\d+)-(\d+)$/', $line, $matches)) {
                // Store the range as [min, max]
                $ranges[] = [(int)$matches[1], (int)$matches[2]];
            }
        } else {
            // Parse available ingredient ID
            if (is_numeric($line)) {
                $availableIds[] = (int)$line;
            }
        }
    }

    $freshCount = 0;

    // 2. Check each available ID against all fresh ranges
    foreach ($availableIds as $id) {
        $isFresh = false;

        foreach ($ranges as $range) {
            $min = $range[0];
            $max = $range[1];

            // Check if the ID is within the inclusive range [min, max]
            if ($id >= $min && $id <= $max) {
                $isFresh = true;
                // Once an ID is found to be fresh, we can stop checking other ranges
                break;
            }
        }

        if ($isFresh) {
            $freshCount++;
        }
    }

    return $freshCount;
}

// --------------------------------------------------------------------------------------------------

## ⚙️ Main Execution Block

// 1. Define the input file name
$inputFile = 'inputs/day5.txt';
$puzzleInput = [];

// 2. Read the database file
if (!file_exists($inputFile)) {
    // Fallback to example input if the file is missing
    echo "Warning: The input file '$inputFile' was not found. Using example data for demonstration.\n";
    $puzzleInput = [
        "3-5",
        "10-14",
        "16-20",
        "12-18",
        "", // Blank line separator
        "1",
        "5",
        "8",
        "11",
        "17",
        "32",
    ];
    // Expected result for example is 3.
} else {
    // Read lines from the input file
    $puzzleInput = file($inputFile, FILE_IGNORE_NEW_LINES);
}

// 3. Solve the puzzle
$freshCount = solveFreshIngredientPuzzle($puzzleInput);

// 4. Output the result
echo "The total number of available ingredient IDs that are fresh is: **$freshCount**\n";

?>