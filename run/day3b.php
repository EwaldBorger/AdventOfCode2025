<?php declare(strict_types=1);

use Ewald\AdventOfCode2025\Day3B;

require_once 'vendor/autoload.php';
// https://adventofcode.com/2025/day/3

// answer is 175304218462560

$day3b = new Day3B();
$joltage = $day3b->solve(file('inputs/day3.txt') ?: '');
echo "\nJoltage is {$joltage}\n";
