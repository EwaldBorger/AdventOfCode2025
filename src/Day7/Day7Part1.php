<?php declare(strict_types=1);

namespace Ewald\AdventOfCode2025\Day7;

use Ewald\AdventOfCode2025\DayBase;

class Day7Part1 extends DayBase
{
    #[\Override]
    public function solve(array $input): int
    {
        $beams = [];
        $line = trim(array_shift($input));
        $max = strlen($line) - 1;
        $start = strpos($line, 'S');
        $this->log[] = "$line start at $start";
        $beams[$start] = 1;
        $countSplits = 0;
        foreach ($input as $line) {
            $line = trim($line);
            $lineArray = str_split($line);
            foreach ($beams as $beam => $count) {
                //$this->log[] = "$line beam $beam hits {$lineArray[$beam]}";
                if ($lineArray[$beam] !== '^') {
                    continue;
                }

                $countSplits++;
                unset($beams[$beam]);
                if (($beam - 1) >= 0) {
                    $beams[$beam - 1] = 1;
                }
                if (($beam + 1) <= $max) {
                    $beams[$beam + 1] = 1;
                }
            }
            foreach ($beams as $beam => $count) {
                $lineArray[$beam] = '|';
            }
            $this->log[] = implode('', $lineArray);
        }
        return $countSplits;
    }
}
