<?php declare(strict_types=1);

namespace Ewald\AdventOfCode2025;

class DayBase
{
    /**
     * @var string[]
     */
    protected array $log = [];

    public function getLog(): string
    {
        return implode("\n", $this->log);
    }
}
