<?php

/**
 * Parses the input lines to extract the fresh ingredient ID ranges.
 * * @param array $inputLines The puzzle input (lines of the database file).
 * @return array An array of [min, max] range pairs, sorted by min.
 */
function parseAndSortRanges(array $inputLines): array {
    $ranges = [];

    foreach ($inputLines as $line) {
        $line = trim($line);
        // Stop parsing ranges at the blank line separator
        if (empty($line)) {
            break;
        }

        // Parse range format "min-max"
        if (preg_match('/^(\d+)-(\d+)$/', $line, $matches)) {
            // Store the range as [min, max]
            $ranges[] = [(int)$matches[1], (int)$matches[2]];
        }
    }

    // Sort ranges by their starting value (min) for efficient merging.
    usort($ranges, function($a, $b) {
        return $a[0] <=> $b[0];
    });

    return $ranges;
}

/**
 * Merges overlapping and adjacent fresh ID ranges and calculates the total count of unique IDs.
 * * @param array $sortedRanges An array of [min, max] range pairs, sorted by min.
 * @return int The total number of unique fresh ingredient IDs.
 */
function mergeAndCountRanges(array $sortedRanges): int {
    if (empty($sortedRanges)) {
        return 0;
    }

    // Start with the first range as the initial merged range
    $mergedRanges = [];
    $currentMin = $sortedRanges[0][0];
    $currentMax = $sortedRanges[0][1];

    // Iterate through the remaining ranges
    for ($i = 1; $i < count($sortedRanges); $i++) {
        $nextMin = $sortedRanges[$i][0];
        $nextMax = $sortedRanges[$i][1];

        // Check for overlap or adjacency:
        // Overlap if nextMin <= currentMax (e.g., [10-14] and [12-18])
        // Adjacency if nextMin == currentMax + 1 (e.g., [3-5] and [6-8])
        if ($nextMin <= $currentMax + 1) {
            // Merge: Extend the currentMax if the next range goes further
            $currentMax = max($currentMax, $nextMax);
        } else {
            // No overlap/adjacency: Finalize the current merged range
            $mergedRanges[] = [$currentMin, $currentMax];

            // Start a new merged range
            $currentMin = $nextMin;
            $currentMax = $nextMax;
        }
    }

    // Add the very last merged range
    $mergedRanges[] = [$currentMin, $currentMax];

    // 3. Calculate the total count of unique IDs
    $totalCount = 0;
    foreach ($mergedRanges as $range) {
        $min = $range[0];
        $max = $range[1];

        // Count for an inclusive range [min, max] is max - min + 1
        $totalCount += ($max - $min + 1);
    }

    return $totalCount;
}

/**
 * Combines parsing and merging to solve the puzzle.
 * * @param array $inputLines The puzzle input (lines of the database file).
 * @return int The total count of unique fresh ingredient IDs.
 */
function solveUniqueFreshIDsPuzzle(array $inputLines): int {
    $sortedRanges = parseAndSortRanges($inputLines);
    return mergeAndCountRanges($sortedRanges);
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
        "", // Separator line and subsequent lines are ignored by the parser
        "1",
        "5",
    ];
    // Example ranges merge to: [3-5] and [10-20].
    // [3-5] length: 3
    // [10-14] + [12-18] + [16-20] merges to [10-20]. Length: 11
    // Total: 3 + 11 = 14. (Matches example)
} else {
    // Read lines from the input file
    $puzzleInput = file($inputFile, FILE_IGNORE_NEW_LINES);
}

// 3. Solve the puzzle
$freshCount = solveUniqueFreshIDsPuzzle($puzzleInput);

// 4. Output the result
echo "The total number of unique fresh ingredient IDs is: **$freshCount**\n";

?>