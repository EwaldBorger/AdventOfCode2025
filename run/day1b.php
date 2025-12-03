<?php declare(strict_types=1);

require_once 'vendor/autoload.php';
// https://adventofcode.com/2025/day/1

// not: 8026
// not: 6627
// it is: 6858

$password = (new \Ewald\AdventOfCode2025\Day1B())->processStrings(file('inputs/day1.txt') ?: []);
echo "\nPassword is {$password}\n";
