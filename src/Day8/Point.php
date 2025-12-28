<?php declare(strict_types=1);

namespace Ewald\AdventOfCode2025\Day8;

class Point implements \Stringable
{
    public function __construct(
        public int $x,
        public int $y,
        public int $z,
    ) {}

    public static function fromString(string $string): Point
    {
        list($x, $y, $z) = explode(',', $string);
        return new self((int) $x, (int) $y, (int) $z);
    }

    #[\Override]
    public function __toString(): string
    {
        return "({$this->x}, {$this->y}, {$this->z})";
    }
}
