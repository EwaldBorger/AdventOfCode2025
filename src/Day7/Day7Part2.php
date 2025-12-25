<?php declare(strict_types=1);

namespace Ewald\AdventOfCode2025\Day7;

use Ewald\AdventOfCode2025\DayBase;

class Day7Part2 extends DayBase
{
    public array $input = [];
    public array $memo = [];

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
        $key = "{$level}-{$beamPosition}";
        if (isset($this->memo[$key])) {
            echo "$level $beamPosition from memo\n";
            return $this->memo[$key];
        }
        if (!isset($this->input[$level])) {
            echo "$level $beamPosition outside level\n";
            return 1;
        }
        if (!isset($this->input[$level][$beamPosition])) {
            echo "$level $beamPosition outside field\n";
            return 0;
        }
        if ($this->input[$level][$beamPosition] !== '^') {
            echo "$level $beamPosition falling through\n";
            return $this->solver($level + 1, $beamPosition);
        }
        echo "$level $beamPosition split\n";
        $leftLines = $this->solver($level + 1, $beamPosition - 1);
        $rightLines = $this->solver($level + 1, $beamPosition + 1);
        $total = $leftLines + $rightLines;
        $this->memo[$key] = $total;
        return $total;
    }
}
