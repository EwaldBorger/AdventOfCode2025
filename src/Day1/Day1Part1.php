<?php declare(strict_types=1);

namespace Ewald\AdventOfCode2025\Day1;

use Ewald\AdventOfCode2025\DayBase;

class Day1Part1 extends DayBase
{
    #[\Override]
    public function solve(array $input): int
    {
        // retro fitted to a class from a simple iterative script (see git history)
        $dial = 50;
        $password = 0;
        foreach ($input as $line) {
            $line = trim($line);

            if (str_starts_with($line, 'L')) {
                $clicks = (int)str_replace('L', '', $line) % 100;
                $dial -= $clicks;
                if ($dial < 0) {
                    $dial += 100;
                }
            }
            if (str_starts_with($line, 'R')) {
                $clicks = (int)str_replace('R', '', $line) % 100;
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
        return $password;
    }
}
