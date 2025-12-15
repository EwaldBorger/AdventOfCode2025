<?php declare(strict_types=1);

namespace Ewald\AdventOfCode2025\Day5;

use Ewald\AdventOfCode2025\DayBase;

class Day5Part2 extends DayBase
{
    public array $fresh = []; // public for unit tests
    public array $points = [];

    #[\Override]
    public function solve(array $input): int
    {
        $this->readInput($input);
        return $this->countFresh();
    }

    public function readInput(array $input): void
    {
        foreach ($input as $line) {
            $line = trim($line);
            $this->log[] = $line;
            if ($line === '') {
                return;
            }
            $this->addLineToFresh($line);
        }
    }

    public function countFresh(): int
    {
        sort($this->points);
        $count = 0;
        $isStart = false;
        $start = null;
        foreach ($this->points as $point) {
            $inRange = $this->inSomeRange($point);
            if ($inRange) {
                if (!$isStart) {
                    $this->log[] = "$point this is a start";
                    $isStart = true;
                    $start = $point;
                } // else ignore
            } else {
                if ($isStart) {
                    $subCount = $point - $start;
                    $this->log[] = "$point ends a range that started with $start so add $subCount";
                    $isStart = false;
                    $count += $subCount;
                }
            }
        }
        return $count;
    }

    public function inSomeRange(int $point): bool
    {
        foreach ($this->fresh as $fresh) {
            if ($point >= $fresh[0] && $point <= $fresh[1]) {
                $this->log[] = "$point is in " . implode(', ', $fresh);
                return true;
            }
            $this->log[] = "$point is not in " . implode(', ', $fresh);
        }
        return false;
    }

    public function addLineToFresh(string $line): void
    {
        if (str_contains($line, '-')) {
            list($start, $end) = explode('-', $line);
        } else {
            $start = $end = $line;
        }
        $this->fresh[] = [(int) $start, (int) $end];
        $this->points[] = (int) $start;
        $this->points[] = (int) $end + 1;
    }
}
