<?php declare(strict_types=1);

require_once 'vendor/autoload.php';
// https://adventofcode.com/2025/day/2

// answer:

$sum = new \Ewald\AdventOfCode2025\Day2b()->run(file_get_contents('inputs/day2.txt') ?: "");
echo "\nSum is {$sum}\n";
