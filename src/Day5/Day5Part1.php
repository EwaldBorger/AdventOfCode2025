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
            if (str_contains($line, '-')) {
                list($start, $end) = explode('-', $line);
                $range = range((int)$start, (int)$end, 1);
                $this->log[] = 'range- ' . implode(',', $range);
            } else {
                $range = [(int)$line];
                $this->log[] = 'range1 ' . implode(',', $range);
            }
            if ($fresh) {
                $this->fresh = array_merge($this->fresh, $range);
                $this->log[] = 'fresh = ' . implode(',', $this->fresh);

            } else {
                $this->available = array_merge($this->available, $range);
                $this->log[] = 'available = ' . implode(',', $this->available);

            }
        }
        $this->log[] = 'fresh total = ' . implode(',', $this->fresh);
        $this->fresh = array_unique($this->fresh);
        $this->log[] = 'fresh unique = ' . implode(',', $this->fresh);
        sort($this->fresh);
        $this->log[] = 'fresh end = ' . implode(',', $this->fresh);
    }

    public function countFresh(): int
    {
        $count = 0;
        foreach ($this->available as $id) {
            if (in_array($id, $this->fresh)) {
                $count++;
            }
        }
        return $count;
    }
}
