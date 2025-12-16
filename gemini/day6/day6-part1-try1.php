<?php

/**
 * Solves the Cephalopod Math worksheet.
 * * @param array $lines The worksheet lines.
 * @return string The grand total as a string (to avoid precision issues).
 */
function solveCephalopodMath(array $lines): string {
    if (empty($lines)) return "0";

    // 1. Identify the width of the worksheet
    $width = 0;
    foreach ($lines as $line) {
        $width = max($width, strlen($line));
    }

    // 2. Identify problem columns
    // We look at the last line (the operators) to find where problems exist.
    $lastLine = end($lines);
    $lastLineIdx = key($lines);
    $problems = [];
    $currentProblemCols = [];

    for ($x = 0; $x < $width; $x++) {
        $char = $lastLine[$x] ?? ' ';
        if ($char === '*' || $char === '+') {
            // Found an operator, this marks the end of a column group
            $problems[] = [
                'cols' => $currentProblemCols,
                'operator' => $char,
                'x_pos' => $x // Useful for extracting numbers vertically at this range
            ];
            $currentProblemCols = [];
        } elseif ($char === ' ') {
            // Space column - if we were tracking columns for a problem,
            // but the operator line is empty here, we continue.
        }
    }

    // 3. Extract numbers for each problem
    // Instead of just tracking columns, let's use the space-gap logic.
    // A problem exists at a specific horizontal range.
    $grandTotal = "0";

    // Re-parsing logic: Split the worksheet into vertical slices based on empty columns.
    $slices = [];
    $currentSlice = [];
    for ($x = 0; $x < $width; $x++) {
        $columnEmpty = true;
        foreach ($lines as $line) {
            if (isset($line[$x]) && $line[$x] !== ' ') {
                $columnEmpty = false;
                break;
            }
        }

        if ($columnEmpty) {
            if (!empty($currentSlice)) {
                $slices[] = $currentSlice;
                $currentSlice = [];
            }
        } else {
            // Capture this column index
            $currentSlice[] = $x;
        }
    }
    if (!empty($currentSlice)) $slices[] = $currentSlice;

    // 4. Process each slice
    foreach ($slices as $slice) {
        $numbers = [];
        $operator = '';
        $minX = min($slice);
        $maxX = max($slice);

        // Check rows for numbers
        for ($y = 0; $y < count($lines); $y++) {
            $rowPart = substr($lines[$y], $minX, ($maxX - $minX) + 1);
            $trimmed = trim($rowPart);

            if ($y === $lastLineIdx) {
                $operator = $trimmed; // '+' or '*'
            } elseif ($trimmed !== '') {
                $numbers[] = (float)$trimmed;
            }
        }

        // 5. Calculate problem result
        if (empty($numbers)) continue;

        $result = $numbers[0];
        for ($i = 1; $i < count($numbers); $i++) {
            if ($operator === '+') {
                $result += $numbers[$i];
            } elseif ($operator === '*') {
                $result *= $numbers[$i];
            }
        }

        // Accumulate grand total
        // We use string conversion to keep precision if numbers are huge
        $grandTotal = (string)((float)$grandTotal + $result);
    }

    return $grandTotal;
}

// --------------------------------------------------------------------------------------------------

## ⚙️ Execution

$inputFile = 'inputs/day6.txt';

if (!file_exists($inputFile)) {
    // Example from the prompt
    $puzzleInput = [
        '123 328  51 64 ' . PHP_EOL,
        ' 45 64  387 23 ' . PHP_EOL,
        '  6 98  215 314' . PHP_EOL,
        '*   +   *   +' . PHP_EOL,
    ];
} else {
    // Read all lines including trailing spaces (important for column alignment!)
    $puzzleInput = file($inputFile, FILE_IGNORE_NEW_LINES);
}

$total = solveCephalopodMath($puzzleInput);

// Using number_format to avoid scientific notation in output
echo "The grand total for the worksheet is: **" . number_format($total, 0, '.', '') . "**\n";

?>