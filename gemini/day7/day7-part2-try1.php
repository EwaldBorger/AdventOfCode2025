<?php

/**
 * Calculates the total number of unique timelines in a quantum tachyon manifold.
 */
function solveQuantumManifold(array $grid): string {
    $numRows = count($grid);
    if ($numRows === 0) return "0";

    // 1. Find starting 'S' and initialize the first timeline
    $currentPositions = []; // Array of x => count
    $startRow = -1;
    for ($y = 0; $y < $numRows; $y++) {
        $sPos = strpos($grid[$y], 'S');
        if ($sPos !== false) {
            $currentPositions[$sPos] = 1;
            $startRow = $y;
            break;
        }
    }

    if ($startRow === -1) return "0";

    // 2. Descend through the manifold row by row
    for ($y = $startRow + 1; $y < $numRows; $y++) {
        $nextPositions = [];
        $rowStr = $grid[$y];
        $width = strlen($rowStr);

        foreach ($currentPositions as $x => $count) {
            if (isset($rowStr[$x]) && $rowStr[$x] === '^') {
                // Split timeline: add current count to both left and right neighbors
                $left = $x - 1;
                $right = $x + 1;

                if ($left >= 0) {
                    $nextPositions[$left] = ($nextPositions[$left] ?? 0) + $count;
                }
                if ($right < $width) {
                    $nextPositions[$right] = ($nextPositions[$right] ?? 0) + $count;
                }
            } else {
                // Continue timeline downward at the same x
                $nextPositions[$x] = ($nextPositions[$x] ?? 0) + $count;
            }
        }
        $currentPositions = $nextPositions;

        // If all particles exit the sides, we stop
        if (empty($currentPositions)) break;
    }

    // 3. The total timelines is the sum of all particle counts after the final row
    $totalTimelines = 0;
    foreach ($currentPositions as $count) {
        $totalTimelines += $count;
    }

    return (string)$totalTimelines;
}

// --- Example Test ---
$example = [
    ".......S.......",
    "...............",
    ".......^.......",
    "...............",
    "......^.^......",
    "...............",
    ".....^.^.^.....",
    "...............",
    "....^.^...^....",
    "...............",
    "...^.^...^.^...",
    "...............",
    "..^...^.....^..",
    "...............",
    ".^.^.^.^.^...^.",
    "...............",
];

//$total = solveQuantumManifold($example);
//echo "Total timelines: **" . $total . "** (Expected: 40)\n";

$total = solveQuantumManifold(file('inputs/day7.txt'));
echo "Total timelines: **" . $total . "**\n";