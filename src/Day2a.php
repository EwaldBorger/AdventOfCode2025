<?php declare(strict_types=1);

namespace Ewald\AdventOfCode2025;

class Day2a extends DayBase
{
    public function run(string $input): int
    {
        $ranges = explode(',', $input);
        $sum = 0;
        foreach ($ranges as $range) {
            $ids = $this->getWrongIdsFromRange($range);
            $sum += array_sum($ids);
        }
        return $sum;
    }

    /**
     * @param string $range
     * @return int[]
     */
    public function getWrongIdsFromRange(string $range): array
    {
        $split = explode('-', $range);
        if (count($split) !== 2) {
            return [];
        }
        $start = (int) $split[0];
        $end = (int) $split[1];
        $all = range($start, $end);
        $this->log[] = "$start - $end = " . count($all);
        $wrongIds = [];
        foreach ($all as $id) {
            if ($this->isWrongId($id)) {
                $wrongIds[] = $id;
            }
        }
        return $wrongIds;
    }

    public function isWrongId(int $id): bool
    {
        $str = (string) $id;
        $n = strlen($str);
        if (($n % 2) !== 0 || $n === 0) {
            return false;
        }
        $split = str_split($str, $n / 2);
        return $split[0] === $split[1];
    }
}
