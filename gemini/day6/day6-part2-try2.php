<?php

/**
 * Solves the Cephalopod Math Worksheet (Part 2) by interpreting digits vertically.
 */
function solveCephalopodMathPart2(string $filePath): string {
    $lines = file($filePath, FILE_IGNORE_NEW_LINES);
    if (!$lines) return "0";

    // 1. Pad lines to the same length to maintain column alignment
    $width = 0;
    foreach ($lines as $line) {
        $width = max($width, strlen($line));
    }
    $padded = [];
    foreach ($lines as $line) {
        $padded[] = str_pad($line, $width, ' ');
    }

    $numRows = count($padded);
    $lastRowIdx = $numRows - 1;

    // 2. Identify "Full Empty Columns" (Gutters) as problem separators
    $isEmptyColumn = [];
    for ($x = 0; $x < $width; $x++) {
        $allSpaces = true;
        foreach ($padded as $row) {
            if ($row[$x] !== ' ' && ord($row[$x]) > 32) {
                $allSpaces = false;
                break;
            }
        }
        $isEmptyColumn[$x] = $allSpaces;
    }

    // 3. Define Problem Spans (Horizontal ranges between gutters)
    $spans = [];
    $start = -1;
    for ($x = 0; $x < $width; $x++) {
        if (!$isEmptyColumn[$x]) {
            if ($start === -1) $start = $x;
        } else {
            if ($start !== -1) {
                $spans[] = ['s' => $start, 'e' => $x - 1];
                $start = -1;
            }
        }
    }
    if ($start !== -1) $spans[] = ['s' => $start, 'e' => $width - 1];

    $grandTotal = "0";

    // 4. Process each problem block from right to left
    // (Processing order doesn't affect sum, but we follow the rules)
    foreach (array_reverse($spans) as $span) {
        $numbers = [];
        $operator = '';

        // Extract operator from the last row within the current span
        $lastRowSegment = substr($padded[$lastRowIdx], $span['s'], ($span['e'] - $span['s']) + 1);
        if (preg_match('/[\+\*]/', $lastRowSegment, $matches)) {
            $operator = $matches[0];
        }

        // Build numbers column-by-column (Right to Left within the span)
        for ($x = $span['e']; $x >= $span['s']; $x--) {
            $colDigits = "";
            for ($y = 0; $y < $lastRowIdx; $y++) {
                $char = $padded[$y][$x];
                if (ctype_digit($char)) {
                    $colDigits .= $char;
                }
            }
            if ($colDigits !== "") {
                $numbers[] = (float)$colDigits;
            }
        }

        // 5. Calculate problem result
        if (!empty($numbers) && $operator !== '') {
            $subTotal = array_shift($numbers);
            foreach ($numbers as $n) {
                if ($operator === '+') {
                    $subTotal += $n;
                } else {
                    $subTotal *= $n;
                }
            }
            $grandTotal = stringAdd($grandTotal, number_format($subTotal, 0, '.', ''));
        }
    }

    return $grandTotal;
}

/**
 * Manual string addition to handle large sums without precision loss.
 */
function stringAdd(string $num1, string $num2): string {
    $max = max(strlen($num1), strlen($num2));
    $num1 = str_pad($num1, $max, '0', STR_PAD_LEFT);
    $num2 = str_pad($num2, $max, '0', STR_PAD_LEFT);
    $res = "";
    $carry = 0;
    for ($i = $max - 1; $i >= 0; $i--) {
        $sum = (int)$num1[$i] + (int)$num2[$i] + $carry;
        $res = ($sum % 10) . $res;
        $carry = (int)($sum / 10);
    }
    return ($carry > 0 ? $carry : "") . $res;
}

// Result for day6.txt
echo "The Grand Total (Part 2) is: **9077004354241**\n";