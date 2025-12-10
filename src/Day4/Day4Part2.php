<?php declare(strict_types=1);

namespace Ewald\AdventOfCode2025\Day4;

use Ewald\AdventOfCode2025\DayBase;

class Day4Part2 extends Day4Part1
{
    #[\Override]
    public function solve(array $input): int
    {
        $this->grid = $this->getGrid($input);
        $this->log[] = $this->gridToString();
        $rolls = 0;
        do {
            $n = $this->markRolls();
            $this->removeRolls();
            $rolls += $n;
            $this->log[] = $this->gridToString();
        } while ($n > 0);

        return $rolls;
    }

    public function markRolls(): int
    {
        $rolls = 0;
        foreach ($this->grid as $y => $row) {
            foreach ($row as $x => $cell) {
                $this->log[] = "looking at $y $x $cell";
                if ($cell !== 0 && $this->isRollAccessible($x, $y)) {
                    $rolls++;
                    $this->grid[$y][$x] = 2;
                }
            }
        }
        return $rolls;
    }

    public function removeRolls(): void
    {
        foreach ($this->grid as $y => $row) {
            foreach ($row as $x => $cell) {
                if ($cell === 2) {
                    $this->grid[$y][$x] = 0;
                }
            }
        }
    }
}
