<?php declare(strict_types=1);

namespace Ewald\AdventOfCode2025\Day6;

use Ewald\AdventOfCode2025\DayBase;

class Day6Part2 extends DayBase
{
    public array $todo = []; // public for unit tests

    #[\Override]
    public function solve(array $input): int
    {
        $this->readInput($input);
        return $this->solveTodo(); // we could do this directly, but nicer separation this way :)
    }

    public function readInput(array $input): void
    {
        $operands = array_pop($input);
        $nrOfColumns = strlen($operands);
        $todo = 0;
        $operand = '';
        for ($i = $nrOfColumns; $i >= 0; $i--) {
            $column = '';
            foreach ($input as $line) {
                $column .= $line[$i] ?? '';
            }
            $operand = trim($operand . ($operands[$i] ?? ''));
            $column = trim($column);
            $this->log[] = "column [$i] = $column / operand = $operand";
            if ($column !== '') {
                $this->todo[$todo][] = $column;
                $this->log[] = "stored $column in $todo";
            } else {
                if ($operand !== '') {
                    $this->todo[$todo][] = $operand;
                    $this->log[] = "stored operand $operand for $todo";
                    $operand = '';
                    $todo++;
                }
            }
        }
        if ($operand !== '') {
            $this->log[] = "found a orphaned $operand should go with $todo";
            $this->todo[$todo][] = $operand;
        }

        $this->log[] = var_export($this->todo, true);
    }

    public function solveTodo(): int
    {
        $total = 0;
        foreach ($this->todo as $todo) {
            $operation = array_pop($todo);
            $result = match ($operation) {
                '*' => array_product($todo),
                '+' => array_sum($todo),
            };
            $total += $result;
        }
        return $total;
    }
}
