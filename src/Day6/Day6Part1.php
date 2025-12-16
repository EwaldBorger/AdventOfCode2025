<?php declare(strict_types=1);

namespace Ewald\AdventOfCode2025\Day6;

use Ewald\AdventOfCode2025\DayBase;

class Day6Part1 extends DayBase
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
        foreach ($input as $line) {
            $line = trim($line);
            $n = strlen($line);
            $temp = null;
            $todo = 0;
            for ($i = 0; $i < $n; $i++) {
                if ($line[$i] === ' ') {
                    $this->log[] = 'separator';
                    if ($temp !== null) {
                        if (!isset($this->todo[$todo])) {
                            $this->todo[$todo] = [];
                        }
                        $this->todo[$todo][] = $temp;
                        $this->log[] = "stored $temp in $todo";
                        $temp = null;
                        $todo++;
                    } // don't think it will happen
                } else {
                    $temp = ($temp ?? '') . $line[$i];
                    $this->log[] = "added {$line[$i]} to $temp";
                }
            }
            if ($temp !== null) {
                $this->todo[$todo][] = $temp;
                $this->log[] = "added final $temp to $todo";
            }
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
