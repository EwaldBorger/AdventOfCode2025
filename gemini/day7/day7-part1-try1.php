<?php

/**
 * Calculates the total number of splits in the tachyon manifold.
 */
function solveTachyonManifold(array $grid): int {
    $numRows = count($grid);
    if ($numRows === 0) return 0;

    // 1. Find the starting position 'S'
    $activeBeams = [];
    $startRow = -1;
    for ($y = 0; $y < $numRows; $y++) {
        $sPos = strpos($grid[$y], 'S');
        if ($sPos !== false) {
            $activeBeams[] = $sPos;
            $startRow = $y;
            break;
        }
    }

    if ($startRow === -1) return 0;

    $totalSplits = 0;

    // 2. Descend through the manifold
    for ($y = $startRow + 1; $y < $numRows; $y++) {
        $nextBeams = [];
        $rowStr = $grid[$y];
        $width = strlen($rowStr);

        foreach ($activeBeams as $x) {
            // Check if the beam hits a splitter at the current row
            if (isset($rowStr[$x]) && $rowStr[$x] === '^') {
                $totalSplits++;

                // Split: create beams at left and right
                if ($x - 1 >= 0) $nextBeams[$x - 1] = true;
                if ($x + 1 < $width) $nextBeams[$x + 1] = true;
            } else {
                // Pass through: beam stays at current index
                $nextBeams[$x] = true;
            }
        }

        // Update active beams for the next row (array_keys removes duplicates)
        $activeBeams = array_keys($nextBeams);

        // If no beams are left, we can stop early
        if (empty($activeBeams)) break;
    }

    return $totalSplits;
}

// --- Verification with Example ---
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

//$result = solveTachyonManifold($example);
//echo "Total splits in example: **" . $result . "** (Expected: 21)\n";

$result = solveTachyonManifold(file('inputs/day7.txt'));
echo "Total splits in real: **" . $result . "** \n";
