<?php declare(strict_types=1);

namespace Ewald\AdventOfCode2025;

abstract class DayBase
{
    /**
     * @var string[]
     */
    protected array $log = [];

    public function getLog(): string
    {
        return implode("\n", $this->log);
    }

    /**
     * @param string[] $input
     * @return int
     */
    abstract public function solve(array $input): int;
}
