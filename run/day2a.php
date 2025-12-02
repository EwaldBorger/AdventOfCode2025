<?php declare(strict_types=1);

require_once 'vendor/autoload.php';
// https://adventofcode.com/2025/day/2

// answer: 19219508902

$sum = new \Ewald\AdventOfCode2025\Day2a()->run(file_get_contents('inputs/day2.txt') ?: "");
echo "\nSum is {$sum}\n";
