<?php declare(strict_types=1);

namespace Ewald\AdventOfCode2025\Tests\Day5;

use Ewald\AdventOfCode2025\Day5\Day5Part2;
use PHPUnit\Framework\TestCase;

class Day5Part2Test extends TestCase
{
    public array $example = [
        '3-5',
        '10-14',
        '16-20',
        '12-18',
        '',
        '1',
        '5',
        '8',
        '11',
        '17',
        '32',
    ];

    public function testSolveWithExample(): void
    {
        $expectedOutput = 14;
        $instance = new Day5Part2();
        $this->assertSame($expectedOutput, $instance->solve($this->example), $instance->getLog());
    }

    public function testSolveWithExtendedExample(): void
    {
        $expectedOutput = 16;
        $instance = new Day5Part2();
        $this->assertSame(
            $expectedOutput,
            $instance->solve(array_merge(['9-21'], $this->example)),
            $instance->getLog(),
        );
    }
}
