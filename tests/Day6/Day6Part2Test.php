<?php declare(strict_types=1);

namespace Ewald\AdventOfCode2025\Tests\Day6;

use Ewald\AdventOfCode2025\Day6\Day6Part2;
use PHPUnit\Framework\TestCase;

class Day6Part2Test extends TestCase
{
    public array $example = [
        '123 328  51 64 ' . PHP_EOL,
        ' 45 64  387 23 ' . PHP_EOL,
        '  6 98  215 314' . PHP_EOL,
        '*   +   *   +' . PHP_EOL,
    ];

    public function testReadInput(): void
    {
        $instance = new Day6Part2();
        $instance->readInput($this->example);
        $this->assertEquals(
            [
                0 => ['4', '431', '623', '+'],
                1 => ['175', '581', '32', '*'],
                2 => ['8', '248', '369', '+'],
                3 => ['356', '24', '1', '*'],
            ],
            $instance->todo,
            'todo ' . $instance->getLog(),
        );
    }

    public function testSolveWithExample(): void
    {
        $expectedOutput = 3263827;
        $instance = new Day6Part2();
        $this->assertSame($expectedOutput, $instance->solve($this->example), $instance->getLog());
    }
}
