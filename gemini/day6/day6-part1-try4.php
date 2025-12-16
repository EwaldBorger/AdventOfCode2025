<?php

function solveCephalopodMath(array $lines): string {
    if (empty($lines)) return "0";

    // 1. Normalize line lengths
    $width = 0;
    foreach ($lines as $line) {
        $width = max($width, strlen($line));
    }
    $paddedLines = [];
    foreach ($lines as $line) {
        $paddedLines[] = str_pad($line, $width, ' ');
    }

    // 2. Identify "Full Empty Columns" (Gutters)
    $isEmptyColumn = [];
    for ($x = 0; $x < $width; $x++) {
        $allSpaces = true;
        foreach ($paddedLines as $line) {
            if ($line[$x] !== ' ') {
                $allSpaces = false;
                break;
            }
        }
        $isEmptyColumn[$x] = $allSpaces;
    }

    // 3. Find Problem Spans (Start and End X-coordinates)
    $spans = [];
    $inSpan = false;
    $start = 0;
    for ($x = 0; $x < $width; $x++) {
        if (!$isEmptyColumn[$x] && !$inSpan) {
            $inSpan = true;
            $start = $x;
        } elseif ($isEmptyColumn[$x] && $inSpan) {
            $inSpan = false;
            $spans[] = ['start' => $start, 'end' => $x - 1];
        }
    }
    if ($inSpan) {
        $spans[] = ['start' => $start, 'end' => $width - 1];
    }

    $grandTotal = 0;
    $lastLineIdx = count($paddedLines) - 1;

    // 4. Process each span
    foreach ($spans as $span) {
        $numbers = [];
        $operator = '';

        for ($y = 0; $y <= $lastLineIdx; $y++) {
            // Extract the string segment for this problem's width
            $segment = substr($paddedLines[$y], $span['start'], ($span['end'] - $span['start']) + 1);

            if ($y === $lastLineIdx) {
                // The operator is the only non-space character here
                $operator = trim($segment);
            } else {
                // IMPORTANT: There might be a number in this row segment
                // We use preg_match_all to find the number, as it might be padded with spaces
                if (preg_match_all('/\d+/', $segment, $matches)) {
                    foreach ($matches[0] as $num) {
                        $numbers[] = (float)$num;
                    }
                }
            }
        }

        // 5. Calculate
        if (!empty($numbers) && ($operator === '+' || $operator === '*')) {
            $subTotal = $numbers[0];
            for ($i = 1; $i < count($numbers); $i++) {
                if ($operator === '+') {
                    $subTotal += $numbers[$i];
                } else {
                    $subTotal *= $numbers[$i];
                }
            }
            $grandTotal += $subTotal;
        }
    }

    return (string)$grandTotal;
}

// Verification with Example
$input = [
    '123 328  51 64 ' . PHP_EOL,
    ' 45 64  387 23 ' . PHP_EOL,
    '  6 98  215 314' . PHP_EOL,
    '*   +   *   +' . PHP_EOL,
];
$input = file('inputs/day6.txt', FILE_IGNORE_NEW_LINES);

$total = solveCephalopodMath($input);
echo "The grand total is: **" . number_format($total, 0, '.', '') . "**\n";