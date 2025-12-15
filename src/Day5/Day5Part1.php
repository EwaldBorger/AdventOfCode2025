<?php declare(strict_types=1);

namespace Ewald\AdventOfCode2025\Day5;

use Ewald\AdventOfCode2025\DayBase;

class Day5Part1 extends DayBase
{
    public array $fresh = []; // public for unit tests
    public array $available = [];

    #[\Override]
    public function solve(array $input): int
    {
        $this->readInput($input);
        return $this->countFresh();
    }

    public function readInput(array $input): void
    {
        $fresh = true;
        foreach ($input as $line) {
            $line = trim($line);
            $this->log[] = $line;
            if ($line === '') {
                $fresh = false;
                continue;
            }
            if ($fresh) {
                $this->addLineToFresh($line);
            } else {
                $this->available[] = $line;
            }
        }
    }

    public function addLineToFresh(string $line): void
    {
        if (str_contains($line, '-')) {
            list($start, $end) = explode('-', $line);
        } else {
            $start = $end = $line;
        }
        $initials = range(substr($start, 0, 1), substr($end, 0, 1));
        foreach ($initials as $initial) {
            if (!isset($this->fresh[$initial])) {
                $this->fresh[$initial] = [];
            }
            $this->fresh[$initial][] = [$start, $end];
        }
    }

    public function countFresh(): int
    {
        $count = 0;
        foreach ($this->available as $id) {
            $initial = substr($id, 0, 1);
            if (!isset($this->fresh[$initial])) {
                continue;
            }
            foreach ($this->fresh[$initial] as $freshRule) {
                if (!($id >= $freshRule[0] && $id <= $freshRule[1])) {
                    continue;
                }

                $count++;
                break;
            }
        }
        return $count;
    }
}
