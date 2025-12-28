<?php declare(strict_types=1);

namespace Ewald\AdventOfCode2025\Day8;

use Ewald\AdventOfCode2025\DayBase;

class Day8Part2 extends DayBase
{
    public int $maxPairs = PHP_INT_MAX;

    #[\Override]
    public function solve(array $input): int
    {
        $points = $this->loadPoints($input);
        $pairs = $this->getClosestPairs($points, $this->maxPairs);
        $circuits = $this->getLastVector($pairs, $points);
        return $this->getSolution($circuits);
    }

    public function loadPoints(array $input): array
    {
        $points = [];
        foreach ($input as $line) {
            $line = trim($line);
            $points[] = Point::fromString($line);
        }
        return $points;
    }

    /**
     * @param Point[] $points
     * @param int $max
     * @return Vector[]
     */
    public function getClosestPairs(array $points, int $max): array
    {
        $vectors = [];
        $n = count($points);
        for ($i = 0; $i < $n; $i++) {
            $p = $points[$i];
            for ($j = $i + 1; $j < $n; $j++) {
                $q = $points[$j];
                $vectors[] = new Vector($p, $q);
            }
        }
        usort($vectors, static function ($a, $b) {
            return $a->distance > $b->distance ? 1 : -1;
        });
        return array_slice($vectors, 0, min($max, count($vectors)));
    }

    /**
     * @param Vector[] $vectors
     * @return array<int, Vector[]>
     */
    public function getLastVector(array $vectors, array $points): Vector
    {
        $circuits = [];
        $seen = [];
        $pointsCount = count($points);
        foreach ($vectors as $vector) {
            $this->log[] = 'Looking at ' . $vector;
            $p = $vector->p;
            $q = $vector->q;
            $seen[(string) $p] = 1;
            $seen[(string) $q] = 1;
            $n = count($circuits);
            $newCircuit = null;
            $previousNewCircuit = null;
            $doneThings = false;
            for ($i = 0; $i < $n; $i++) {
                $circuit = $circuits[$i];
                $newCircuit = $this->addVectorToCircuit($circuit, $vector);
                if ($newCircuit !== null) {
                    if ($previousNewCircuit !== null) {
                        $this->log[] = 'need to merge with a previous circuit!';
                        $circuits[$previousNewCircuit] = array_unique(array_merge(
                            $circuits[$previousNewCircuit],
                            $newCircuit,
                        ));
                        $circuits[$i] = [];
                    } else {
                        $this->log[] = "added to circuit {$i}";
                        $circuits[$i] = $newCircuit;
                        $previousNewCircuit = $i;
                    }
                    $doneThings = true;
                }
            }
            if (!$doneThings) {
                $this->log[] = 'nothing to connect to, this is a circuit on its own';
                $circuits[] = [$vector->p, $vector->q];
            }

            if (count(array_filter($circuits)) === 1 && $pointsCount === count($seen)) {
                // so if we have 1 circuit and we've seen all points, then the last vector was the connecting one
                $this->log[] = 'Now at 1 circuits, seen is ' . count($seen);
                return $vector;
            }
            $this->printCircuits($circuits);
        }
        foreach ($points as $point) {
            if (isset($seen[(string) $point])) {
                continue;
            }

            $this->log[] = 'had not seen ' . $point;
            $circuits[] = [$point];
        }
        $circuits = array_filter($circuits);
        $this->printCircuits($circuits);
        usort($circuits, static fn($a, $b) => count($b) <=> count($a));
        return $vector;
    }

    public function addVectorToCircuit(array $circuit, Vector $vector): null|array
    {
        foreach ($circuit as $v) {
            if (!($v === $vector->p || $v === $vector->q)) {
                continue;
            }

            return array_unique(array_merge($circuit, [$vector->p, $vector->q]));
        }
        return null;
    }

    public function getSolution(Vector $lastVector): int
    {
        return $lastVector->p->x * $lastVector->q->x;
    }

    public function printCircuits(array $circuits): void
    {
        foreach ($circuits as $i => $circuit) {
            $this->log[] = "C{$i} [" . count($circuit) . '] ' . implode(', ', $circuit);
        }
    }
}
