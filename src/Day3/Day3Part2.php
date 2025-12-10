<?php declare(strict_types=1);

namespace Ewald\AdventOfCode2025\Day3;

class Day3Part2 extends Day3Part1
{
    // should still fit in a 64bit php int, int max is a number of 20 digits, testset has 200 lines and each number is 12 digits
    #[\Override]
    public function getHighestJoltage(string $in, int $length = 12): int
    {
        $this->log[] = "coming in for $in with $length";
        if ($length === 0) {
            return 0;
        }

        // find the max in the first part (because the first digit determines all, but we need 11 digits after it)
        $a = str_split($in, 1);
        $n = count($a) - ($length - 1);
        $max = 0;
        $maxPos = 0;
        $checked = '';
        for ($i = 0; $i < $n; $i++) {
            if ($a[$i] > $max) {
                $max = $a[$i];
                $maxPos = $i;
            }
            $checked .= $a[$i];
        }
        $toTheRight = substr($in, $maxPos + 1);
        $newLength = $length - 1;
        $this->log[] = "{$checked} {$max} {$toTheRight}";

        return ((int) $max * (10 ** ($length - 1))) + $this->getHighestJoltage($toTheRight, $newLength);
    }
}
