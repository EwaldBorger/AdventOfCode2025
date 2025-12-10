<?php declare(strict_types=1);

namespace Ewald\AdventOfCode2025\Day2;

class Day2Part2 extends Day2Part1
{
    #[\Override]
    public function isWrongId(int $id): bool
    {
        $str = (string) $id;
        $n = strlen($str);
        if ($n === 0) {
            return true;
        }
        $half = (int) floor($n / 2);
        /** @var positive-int $length */
        for ($length = $half; $length > 0; $length--) {
            $log = "checking {$id} with {$length} long blocks";
            if (($n % $length) !== 0) {
                $this->log[] = $log . " skip, {$n} not divisible by {$length}";
                continue;
            }
            $uniqueParts = array_unique(str_split($str, $length));
            $log .= ' has ' . count($uniqueParts) . ' parts: [' . implode(', ', $uniqueParts) . ']';
            if (count($uniqueParts) === 1) {
                $this->log[] = $log . ' is repeating';
                return true;
            }
            $this->log[] = $log . ' is not repeating';
        }
        $this->log[] = $id . ' is not repeating in any way';
        return false;
    }
}
