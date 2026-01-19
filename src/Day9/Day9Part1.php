<?php declare(strict_types=1);

namespace Ewald\AdventOfCode2025\Day9;

use Ewald\AdventOfCode2025\DayBase;

class Day9Part1 extends DayBase
{
    #[\Override]
    public function solve(array $input): int
    {
        $n = count($input);
        $max = 0;
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $max = max($max, $this->getSizeBetween($input[$i], $input[$j]));
            }
        }
        return $max;
    }

    public function getSizeBetween(string $a, string $b): int
    {
        list($aX, $aY) = explode(',', $a);
        list($bX, $bY) = explode(',', $b);
        $dX = abs((int) $aX - (int) $bX) + 1;
        $dY = abs((int) $aY - (int) $bY) + 1;
        $size = $dX * $dY;
        $this->log[] = "$aX $aY -> $bX $bY = $size";
        return $size;
    }
}
