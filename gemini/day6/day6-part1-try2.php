<?php

/**
 * Solves the Cephalopod Math worksheet by correctly identifying full-column gutters.
 */
function solveCephalopodMath(array $lines): string {
    if (empty($lines)) return "0";

    // 1. Normalize line lengths (pad with spaces so all rows are equal length)
    $width = 0;
    foreach ($lines as $line) {
        $width = max($width, strlen($line));
    }
    foreach ($lines as &$line) {
        $line = str_pad($line, $width, ' ');
    }
    unset($line);

    // 2. Identify "Full Empty Columns" (Gutters)
    $isEmptyColumn = [];
    for ($x = 0; $x < $width; $x++) {
        $allSpaces = true;
        foreach ($lines as $line) {
            if ($line[$x] !== ' ') {
                $allSpaces = false;
                break;
            }
        }
        $isEmptyColumn[$x] = $allSpaces;
    }

    // 3. Group columns into Problem Ranges
    $problemRanges = [];
    $inProblem = false;
    $start = 0;

    for ($x = 0; $x < $width; $x++) {
        if (!$isEmptyColumn[$x] && !$inProblem) {
            $inProblem = true;
            $start = $x;
        } elseif ($isEmptyColumn[$x] && $inProblem) {
            $inProblem = false;
            $problemRanges[] = [$start, $x - 1];
        }
    }
    // Catch the last problem if it goes to the edge
    if ($inProblem) {
        $problemRanges[] = [$start, $width - 1];
    }

    // 4. Extract and calculate
    $grandTotal = 0;
    $lastLineIdx = count($lines) - 1;

    foreach ($problemRanges as $range) {
        [$xStart, $xEnd] = $range;
        $numbers = [];
        $operator = '';

        for ($y = 0; $y <= $lastLineIdx; $y++) {
            $cellValue = trim(substr($lines[$y], $xStart, ($xEnd - $xStart) + 1));

            if ($y === $lastLineIdx) {
                // The bottom character is the operator
                $operator = $cellValue;
            } elseif ($cellValue !== '') {
                // Any non-empty value above is a number
                $numbers[] = (float)$cellValue;
            }
        }

        // Apply Math
        if (!empty($numbers) && !empty($operator)) {
            $subTotal = $numbers[0];
            for ($i = 1; $i < count($numbers); $i++) {
                if ($operator === '+') {
                    $subTotal += $numbers[$i];
                } elseif ($operator === '*') {
                    $subTotal *= $numbers[$i];
                }
            }
            $grandTotal += $subTotal;
        }
    }

    return (string)$grandTotal;
}

// --------------------------------------------------------------------------------------------------

$puzzleInput = [
    '123 328  51 64 ' . PHP_EOL,
    ' 45 64  387 23 ' . PHP_EOL,
    '  6 98  215 314' . PHP_EOL,
    '*   +   *   +' . PHP_EOL,
];
$puzzleInput = file('inputs/day6.txt', FILE_IGNORE_NEW_LINES);

$total = solveCephalopodMath($puzzleInput);
echo "The grand total is: **" . number_format($total, 0, '.', '') . "**\n";