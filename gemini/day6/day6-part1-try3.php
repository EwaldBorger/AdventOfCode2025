<?php

function solveCephalopodMath(array $lines): string {
    if (empty($lines)) return "0";

    $lastLineIdx = count($lines) - 1;
    $operatorLine = $lines[$lastLineIdx];
    $grandTotal = 0;

    // 1. Find every operator and its column index
    for ($x = 0; $x < strlen($operatorLine); $x++) {
        $char = $operatorLine[$x];

        if ($char === '*' || $char === '+') {
            $operator = $char;
            $numbers = [];

            // 2. For this operator column, look at every row above it
            for ($y = 0; $y < $lastLineIdx; $y++) {
                if (!isset($lines[$y][$x]) || $lines[$y][$x] === ' ') {
                    continue;
                }

                // 3. We found a digit/part of a number at ($x, $y)
                // We need to expand left and right to get the full number
                $row = $lines[$y];
                $left = $x;
                while ($left > 0 && $row[$left - 1] !== ' ') {
                    $left--;
                }

                $right = $x;
                while ($right < strlen($row) - 1 && $row[$right + 1] !== ' ') {
                    $right++;
                }

                $fullNumber = substr($row, $left, ($right - $left) + 1);
                $numbers[] = (float)$fullNumber;
            }

            // 4. Calculate this specific problem
            if (!empty($numbers)) {
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
    }

    return (string)$grandTotal;
}

// Testing with your formatted input
$input = [
    "123 328  51 64 ",
    " 45 64  387 23 ",
    "  6 98  215 314",
    "* +   * +  "
];
$input = file('inputs/day6.txt', FILE_IGNORE_NEW_LINES);

$total = solveCephalopodMath($input);
echo "The grand total is: **" . number_format($total, 0, '.', '') . "**\n";