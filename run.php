<?php declare(strict_types=1);

require_once 'vendor/autoload.php';

$day = $argv[1] ?? null;
$part = $argv[2] ?? null;
if ($day === null || $part === null) {
    exit("need to supply day and part\n");
}

$class = "\Ewald\AdventOfCode2025\Day{$day}\Day{$day}Part{$part}";
$instance = new $class();
$password = $instance->solve(file("inputs/day{$day}.txt") ?: []);
//print_r($instance->getLog());
echo "\nPassword for puzzle Day {$day} Part {$part} is: {$password}\n";
