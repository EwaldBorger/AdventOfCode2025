<?php declare(strict_types=1);

namespace Ewald\AdventOfCode2025\Day8;

class Vector implements \Stringable
{
    public float $distance;

    public function __construct(
        public Point $p,
        public Point $q,
    ) {
        $this->distance = $this->getDistance();
    }

    public function getDistance(): float
    {
        return ($this->p->x - $this->q->x) ** 2 + ($this->p->y - $this->q->y) ** 2 + ($this->p->z - $this->q->z) ** 2; // faster without sqrt and not really needed
    }

    #[\Override]
    public function __toString(): string
    {
        return "{$this->p} - {$this->q}";
    }
}
