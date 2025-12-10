<?php declare(strict_types=1);

namespace Ewald\AdventOfCode2025\Day4;

use Ewald\AdventOfCode2025\DayBase;

class Day4Part1 extends DayBase
{
    public array $grid; // public for unit tests

    #[\Override]
    public function solve(array $input): int
    {
        $this->grid = $this->getGrid($input);
        $this->log[] = $this->gridToString();
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
        $this->log[] = $this->gridToString();
        return $rolls;
    }

    public function isRollAccessible(int $x, int $y): bool
    {
        $adjacentRolls = 0;
        for ($leftRight = -1; $leftRight <= 1; $leftRight++) {
            for ($upDown = -1; $upDown <= 1; $upDown++) {
                $nx = $x + $leftRight;
                $ny = $y + $upDown;
                if (!($leftRight === 0 && $upDown === 0) && $this->isRollAt($nx, $ny)) {
                    $this->log[] = "checking $x,$y with $leftRight,$upDown = $nx,$ny = roll";
                    $adjacentRolls++;
                } else {
                    $this->log[] = "checking $x,$y with $leftRight,$upDown = $nx,$ny = empty";

                }
            }
        }
        $this->log[] = "$x $y has $adjacentRolls";
        return $adjacentRolls < 4;
    }

    public function isRollAt(int $x, int $y): bool
    {
        if (!isset($this->grid[$y][$x])) {
            $this->log[] = "$x,$y outside";
            return false; // outside of grid are no rolls
        }
        $this->log[] = "$x,$y inside";
        return $this->grid[$y][$x] !== 0;
    }

    /**
     * @param string[] $input
     * @return array<int, array<int, int>>
     */
    public function getGrid(array $input): array
    {
        $grid = [];
        $y = 0;
        foreach ($input as $line) {
            $line = trim($line);
            $line = str_split($line, 1);
            $n = count($line);
            if ($n === 0) {
                continue;
            }
            $grid[$y] = [];
            for ($x = 0; $x < $n; $x++) {
                $grid[$y][$x] = $line[$x] === '@' ? 1 : 0;
            }
            $y++;
        }
        return $grid;
    }

    public function gridToString(): string
    {
        $out = '';
        foreach ($this->grid as $y => $row) {
            foreach ($row as $x => $value) {
                $out .= match ($value) {
                    2 => 'x',
                    1 => '@',
                    default => '.',
                };
            }
            $out .= "\n";
        }
        return $out;
    }
}
