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
        echo "$level $beamPosition\n";
        if (isset($this->memo["{$level}{$beamPosition}"])) {
            return $this->memo["{$level}{$beamPosition}"];
        }
        if (!isset($this->input[$level])) {
            return 1;
        }
        if (!isset($this->input[$level][$beamPosition])) {
            return 0;
        }
        if ($this->input[$level][$beamPosition] !== '^') {
            return $this->solver($level + 1, $beamPosition);
        }
        $leftLines = $this->solver($level + 1, $beamPosition - 1);
        $rightLines = $this->solver($level + 1, $beamPosition + 1);
        $total = $leftLines + $rightLines;
        $this->memo["{$level}{$beamPosition}"] = $total;
        return $total;
    }

}
