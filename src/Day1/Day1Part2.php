<?php declare(strict_types=1);

namespace Ewald\AdventOfCode2025\Day1;

use Ewald\AdventOfCode2025\DayBase;

class Day1Part2 extends DayBase
{
    public function getRotationsFromString(string $string): int
    {
        $multiplier = str_starts_with($string, 'L') ? -1 : 1;
        $rotations = (int) str_replace(['L', 'R'], '', $string);
        return $multiplier * $rotations;
    }

    #[\Override]
    public function solve(array $input): int
    {
        $previous = ['dial' => 50, 'seenZero' => 0];
        $new = $previous;
        $count = 0;

        foreach ($input as $string) {
            $this->log[] = $string;
            $new = $this->processRotation($previous['dial'], $this->getRotationsFromString($string));
            $previous = $new;
            $count += $new['seenZero'];
            $this->log[] = "add {$new['seenZero']} to count and we are now at position {$new['dial']} and seen zero {$count} times";
        }
        return $count;
    }

    /**
     * @return array{dial: int, seenZero: int}
     */
    public function processRotation(int $dial, int $rotations): array
    {
        $actualRotations = $rotations % 100;
        $previousDial = $dial;
        $pointsToZero = 0;
        $fullRounds = (int) floor(abs($rotations) / 100);
        $dial += $actualRotations;
        $this->log[] = "start: {$previousDial} req: {$rotations} which is: {$actualRotations} and {$fullRounds} rounds to end up at: {$dial}";
        if ($dial < 0) {
            $dial += 100;
            $pointsToZero = $previousDial === 0 ? 0 : 1;
            $this->log[] = '[+100/1]';
        } elseif ($dial > 99) {
            $dial -= 100;
            $pointsToZero = $dial === 0 ? 0 : 1;
            $this->log[] = '[-100/1]';
        }
        if ($fullRounds > 0) {
            $pointsToZero += $fullRounds;
            $this->log[] = '[add rounds]';
        }
        if ($dial === 0) {
            $pointsToZero += 1;
        }

        return ['dial' => $dial, 'seenZero' => $pointsToZero];
    }
}
