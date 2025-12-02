<?php declare(strict_types=1);

// https://adventofcode.com/2025/day/1

$dial = 50;
$password = 0;
$file = fopen('inputs/day1.txt', 'r');
while (!feof($file)) {
    $line = fgets($file);
    if ($line === false) {
        continue;
    }
    $line = trim($line);

    if (str_starts_with($line, 'L')) {
        $clicks = ((int) str_replace('L', '', $line)) % 100;
        $dial -= $clicks;
        if ($dial < 0) {
            $dial += 100;
        }
    }
    if (str_starts_with($line, 'R')) {
        $clicks = ((int) str_replace('R', '', $line)) % 100;
        $dial += $clicks;
        if ($dial > 99) {
            $dial -= 100;
        }
    }
    echo "dial goes {$line} to {$dial}\n";
    if ($dial === 0) {
        $password++;
    }
}

echo "Password is {$password}\n";
