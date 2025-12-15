<?php

/**
 * Counts the number of paper rolls ('@') in the 8 adjacent positions around a given cell (r, c).
 * * @param array $grid The 2D array representing the grid.
 * @param int $r The row index of the target cell.
 * @param int $c The column index of the target cell.
 * @return int The count of adjacent paper rolls.
 */
function countAdjacentRolls(array $grid, int $r, int $c): int {
    $rows = count($grid);
    if ($rows === 0) {
        return 0;
    }
    $cols = strlen($grid[0]);
    $rollCount = 0;

    // Define the 8 offsets for neighbors (dr, dc)
    $neighbors = [
        [-1, -1], [-1, 0], [-1, 1], // Top row
        [ 0, -1],          [ 0, 1], // Middle row
        [ 1, -1], [ 1, 0], [ 1, 1],  // Bottom row
    ];

    foreach ($neighbors as [$dr, $dc]) {
        $nr = $r + $dr;
        $nc = $c + $dc;

        // Check bounds: Ensure the neighbor is within the grid
        if ($nr >= 0 && $nr < $rows && $nc >= 0 && $nc < $cols) {
            // Check if the neighbor is a paper roll
            // Note: Since $grid[$nr] is a string, we access the character like an array element.
            if ($grid[$nr][$nc] === '@') {
                $rollCount++;
            }
        }
    }

    return $rollCount;
}

/**
 * Solves the puzzle by counting the total number of accessible paper rolls.
 * A roll is accessible if it has fewer than four adjacent rolls.
 * * @param array $gridInput The puzzle input (array of strings, one per grid row).
 * @return int The total number of accessible paper rolls.
 */
function solveAccessibleRollsPuzzle(array $gridInput): int {
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
    $accessibleCount = 0;

    // Iterate over every cell in the grid
    for ($r = 0; $r < $rows; $r++) {
        for ($c = 0; $c < $cols; $c++) {

            // Check if the current cell is a paper roll
            if ($grid[$r][$c] === '@') {

                // 1. Count adjacent paper rolls
                $neighborCount = countAdjacentRolls($grid, $r, $c);

                // 2. Check accessibility condition
                // Accessible if there are FEWER THAN four adjacent rolls (< 4)
                if ($neighborCount < 4) {
                    $accessibleCount++;
                }
            }
        }
    }

    return $accessibleCount;
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
    // Expected result for example is 13.
} else {
    // Read lines from the input file, ignoring empty ones
    $puzzleInput = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

// 3. Solve the puzzle
$accessibleRolls = solveAccessibleRollsPuzzle($puzzleInput);

// 4. Output the result
echo "The total number of paper rolls accessible by a forklift is: **$accessibleRolls**\n";

?>