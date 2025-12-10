<?php declare(strict_types=1);

namespace Ewald\AdventOfCode2025\Day3;

use Ewald\AdventOfCode2025\DayBase;

class Day3Part1 extends DayBase
{
    #[\Override]
    public function solve(array $input): int
    {
        $totalJoltage = 0;
        foreach ($input as $bank) {
            $bank = trim($bank);
            $highestJoltage = $this->getHighestJoltage($bank);
            $this->log[] = "joltage of {$highestJoltage}";
            $totalJoltage += $highestJoltage;
        }
        return $totalJoltage;
    }

    public function getHighestJoltage(string $in): int
    {
        $this->log[] = "working on {$in}";
        if (strlen($in) === 2) {
            $this->log[] = 'just two left';
            return (int) $in;
        }
        $i = $in[0];
        $toTheRight = substr($in, 1);
        $maxInRight = max(str_split($toTheRight, 1));
        $joltageSelf = (int) ($i . $maxInRight);
        $joltageInRight = $this->getHighestJoltage($toTheRight);
        $this->log[] = "compare $joltageSelf and {$joltageInRight}";
        return $joltageSelf > $joltageInRight ? $joltageSelf : $joltageInRight;
    }
}
