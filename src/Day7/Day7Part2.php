<?php declare(strict_types=1);

namespace Ewald\AdventOfCode2025\Day7;

use Ewald\AdventOfCode2025\DayBase;

class Day7Part2 extends DayBase
{
    public array $input = [];
    #[\Override]
    public function solve(array $input): int
    {
        $firstLine = trim(array_shift($input));
        foreach ($input as $line) {
            $this->input[] = str_split(trim($line));
        }
        $beamPosition = strpos($firstLine, 'S');
        return $this->solver(0, $beamPosition);
    }

    public function solver(int $level, int $beamPosition): int
    {
        if (!isset($this->input[$level])) {
//            echo "$level $beamPosition end\n";
            return 1;
        }
        if ($this->input[$level][$beamPosition] !== '^') {
//            echo "$level $beamPosition no split\n";
            return $this->solver($level + 1, $beamPosition);
        }
        $left = $beamPosition - 1;
        $right = $beamPosition + 1;
//        echo "$level $beamPosition split $left $right\n";
        $leftLines = $left >= 0 ? $this->solver($level + 1, $left) : 0;
        $rightLines = $right < count($this->input[$level]) ? $this->solver($level + 1, $right) : 0;
        return $leftLines + $rightLines;
    }

}
