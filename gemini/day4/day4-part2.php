<?php

/**
 * Counts the number of paper rolls ('@') in the 8 adjacent positions around a given cell (r, c).
 * * @param array $grid The 2D array representing the grid (rows are strings).
 * @param int $r The row index of the target cell.
 * @param int $c The column index of the target cell.
 * @return int The count of adjacent paper rolls.
 */
function countAdjacentRolls(array $grid, int $r, int $c): int {
    $rows = count($grid);
    if ($rows === 0) {
        return 0;
    }
    // Assumes all rows have the same length.
    $cols = strlen($grid[0]);
    $rollCount = 0;

    // Define the 8 offsets for neighbors (dr, dc)
    $neighbors = [
        [-1, -1], [-1, 0], [-1, 1],
        [ 0, -1],          [ 0, 1],
        [ 1, -1], [ 1, 0], [ 1, 1],
    ];

    foreach ($neighbors as [$dr, $dc]) {
        $nr = $r + $dr;
        $nc = $c + $dc;

        // Check bounds and check if the neighbor is a paper roll ('@')
        if ($nr >= 0 && $nr < $rows && $nc >= 0 && $nc < $cols) {
            if ($grid[$nr][$nc] === '@') {
                $rollCount++;
            }
        }
    }

    return $rollCount;
}

/**
 * Solves the extended puzzle by iteratively identifying and removing accessible paper rolls.
 * The process repeats until no more rolls can be removed in a single step.
 * * @param array $gridInput The puzzle input (array of strings, one per grid row).
 * @return int The total number of paper rolls removed.
 */
function solveIterativeRemovalPuzzle(array $gridInput): int {
    // 1. Initialize the grid
    $grid = [];
    foreach ($gridInput as $line) {
        $trimmedLine = trim($line);
        if (!empty($trimmedLine)) {
            $grid[] = $trimmedLine;
        }
    }

    $rows = count($grid);
    if ($rows === 0) {
        return 0;
    }
    $cols = strlen($grid[0]);
    $totalRemoved = 0;

    $removedInIteration = 0;

    // Start the iterative removal process
    do {
        $removedInIteration = 0;

        // 2. Identify all removable rolls in this iteration
        $rollsToRemove = [];

        for ($r = 0; $r < $rows; $r++) {
            for ($c = 0; $c < $cols; $c++) {

                if ($grid[$r][$c] === '@') {
                    // Check accessibility condition: fewer than four adjacent rolls (< 4)
                    $neighborCount = countAdjacentRolls($grid, $r, $c);

                    if ($neighborCount < 4) {
                        $rollsToRemove[] = [$r, $c];
                    }
                }
            }
        }

        // 3. Remove the identified rolls simultaneously (update the grid)
        if (!empty($rollsToRemove)) {
            foreach ($rollsToRemove as [$r, $c]) {
                // To modify a character in a string:
                // 1. Convert the row string to an array of characters
                $rowArray = str_split($grid[$r]);
                // 2. Change the character
                $rowArray[$c] = '.';
                // 3. Convert back to string
                $grid[$r] = implode('', $rowArray);

                $removedInIteration++;
            }

            $totalRemoved += $removedInIteration;
            // echo "Removed $removedInIteration rolls in this step. Total: $totalRemoved\n"; // Debugging trace
        }

    } while ($removedInIteration > 0); // Repeat as long as at least one roll was removed in the last iteration

    return $totalRemoved;
}

// --------------------------------------------------------------------------------------------------

## ⚙️ Main Execution Block

// 1. Define the input file name
$inputFile = 'inputs/day4.txt';
$puzzleInput = [];

// 2. Read the grid from the file
if (!file_exists($inputFile)) {
    // Fallback to example input if the file is missing
    echo "Warning: The input file '$inputFile' was not found. Using example data for demonstration.\n";
    $puzzleInput = [
        "..@@.@@@@.",
        "@@@.@.@.@@",
        "@@@@@.@.@@",
        "@.@@@@..@.",
        "@@.@@@@.@@",
        ".@@@@@@@.@",
        ".@.@.@.@@@",
        "@.@@@.@@@@",
        ".@@@@@@@@.",
        "@.@.@@@.@.",
    ];
    // Expected result for example is 43.
} else {
    // Read lines from the input file, ignoring empty ones
    $puzzleInput = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

// 3. Solve the puzzle
$totalRemoved = solveIterativeRemovalPuzzle($puzzleInput);

// 4. Output the result
echo "The total number of paper rolls that can be removed is: **$totalRemoved**\n";

?>