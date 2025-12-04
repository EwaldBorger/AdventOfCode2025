<?php declare(strict_types=1);

use Ewald\AdventOfCode2025\Day3A;

require_once 'vendor/autoload.php';
// https://adventofcode.com/2025/day/3

// answer is not 17640 = too high
// answer is not 17763 = too high
// anwer 17613

$day3a = new Day3A();
$joltage = $day3a->solve(file('inputs/day3.txt') ?: '');
echo "\nJoltage is {$joltage}\n";
